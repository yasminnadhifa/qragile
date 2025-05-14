<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Val_quest extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Md_user', 'user');
        $this->load->model('Md_val_quest', 'quest');
        $this->load->model('Md_project', 'project');
        $this->load->model('Md_nfrlist', 'nfr_list');
        $this->load->model('Md_cat', 'cat');
        $this->load->model('Md_validation', 'val');

    }
    //Fungsi untuk menambahkan pertanyaan untuk validasi yang baru
    public function add($project_id = null)
    {
        grantAccessFor(array('Developer'));
        $data['user_login'] = $this->user->getById($this->session->userdata('id'));
        $data['title'] = 'Projects Detail Page';
        if ($project_id === null) {
            $project_id = $this->input->post('id_project');
        }
        $data['project_nfr'] = $this->nfr_list->get($project_id);
		$data['questions'] = $this->quest->get_questions_with_categories($project_id);
        $data['cat'] = $this->cat->getByProject($project_id);
        $data['project'] = $this->project->getById($project_id);
        $data['vals'] = $this->val->getById($project_id);

        $current_uri = $this->uri->uri_string();
        $this->session->set_flashdata('current_page', $current_uri);
        $this->form_validation->set_rules('quest', 'question', 'required');
        $this->form_validation->set_rules('id_cat', 'category', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('pages/project_val', $data);
        } else {
            $data = [
                'quest' => $this->input->post('quest'),
                'id_cat' =>$this->input->post('id_cat'),
                'id_project' =>  $project_id
            ];

            $this->quest->add($data);
            addLog('add', $this->session->userdata('name') . ' added data question for validation');
            $this->session->set_flashdata('message', 'question data added successfully!');
            redirect('dev/projects/val/' . $project_id);
        }
    }
    //Fungsi untuk menambahkan pertanyaan validasi yang dipilih
    public function delete($param1,$project_id)
    {
        grantAccessFor(array('Developer'));
        $this->quest->delete($param1);
        $error = $this->db->error();
        if ($error['code'] != 0) {
            $this->session->set_flashdata('message', 'Error!');
        } else {
            addLog('delete', $this->session->userdata('name') . ' deleted data question for validation');
            $this->session->set_flashdata('message', 'question data deleted successfully!');
            redirect('dev/projects/val/' . $project_id);
        }
    }
}
