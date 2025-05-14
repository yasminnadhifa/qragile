<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Fr extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Md_user', 'user');
        $this->load->model('Md_fr', 'fr');
        $this->load->model('Md_Project', 'project');
        $this->load->model('Md_nfrlist', 'nfr_list');
        $this->load->model('Md_mapping_fr', 'mfr');
        $this->load->model('Md_mapping_nfr', 'mnfr');
        $this->load->model('Md_fr_user_story', 'fus');
        $this->load->model('Md_nfr_user_story', 'nus');
    }
    // Fungsi untuk menambahkan Functional Requirement (FR)
    public function add($project_id = null)
    {
        grantAccessFor(array('Developer'));
        $data['user_login'] = $this->user->getById($this->session->userdata('id'));
        $data['title'] = 'Projects Detail Page';
        if ($project_id === null) {
            $project_id = $this->input->post('id_project');
        }
		$data['project'] = $this->project->getById($project_id);
		$data['project_nfr'] = $this->nfr_list->get($project_id);
		$data['nfr_list'] = $this->nfr_list->getFilter($project_id);
		$data['frs'] = $this->fr->getById($project_id);
		$data['mappings'] = $this->mfr->getById($project_id);
		$data['mappings_nfr'] = $this->mnfr->getById($project_id);

		$data['mappings_nfr_formatted'] = [];
		foreach ($data['mappings_nfr'] as $mapping) {
			$data['mappings_nfr_formatted'][$mapping['id_nfr1']][$mapping['id_nfr2']] = $mapping['value'];
		}
        $current_uri = $this->uri->uri_string();
        $this->session->set_flashdata('current_page', $current_uri);
        $this->form_validation->set_rules('name', 'Name', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('pages/project_analysis', $data);
        } else {
            $data = [
                'name' => $this->input->post('name'),
                'id_project' =>  $project_id
            ];

            $this->fr->add($data);
            $data_us_fr = [
                'id_project' =>  $project_id,
                'id_fr' => $this->db->insert_id()
            ];
            $this->fus->add($data_us_fr);
            $data_us_nfr = [
                'id_project' =>  $project_id,
                'id_us_fr' => $this->db->insert_id()
            ];
            $this->nus->add($data_us_nfr);
            addLog('add', $this->session->userdata('name') . ' added data FR');
            $this->session->set_flashdata('message', 'FR data added successfully!');
            redirect('dev/projects/analysis/' . $project_id);
        }
    }
    // Fungsi untuk menghapus Functional Requirement (FR)
    public function delete($param1, $project_id)
    {
        grantAccessFor(array('Developer'));
        $this->fr->delete($param1);
        $error = $this->db->error();
        if ($error['code'] != 0) {
            $this->session->set_flashdata('message', 'Error!');
        } else {
            addLog('delete', $this->session->userdata('name') . ' deleted data FR');
            $this->session->set_flashdata('message', 'FR data deleted successfully!');
            redirect('dev/projects/analysis/' . $project_id);
        }
    }
        //Fungsi untuk mengubah fr yang dipilih
        public function update($param1,$project_id)
        {
            grantAccessFor(array('Developer'));
            $data['user_login'] = $this->user->getById($this->session->userdata('id'));
            $data['user'] = $this->user->get();
            $data = [
                'name' => $this->input->post('name'),
            ];
            $this->fr->update(['id_fr' => $param1], $data);
            addLog('update', $this->session->userdata('name') . ' updated data FR');
            $this->session->set_flashdata('message', 'FR data updated successfully!');
            redirect('dev/projects/analysis/' . $project_id);
        }
}
