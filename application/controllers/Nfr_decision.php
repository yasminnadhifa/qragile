<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Nfr_decision extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Md_user', 'user');
        $this->load->model('Md_nfr_decision', 'dec');
        $this->load->model('Md_project', 'project');
    }
    //Fungsi untuk menampilkan nfr decision 
    public function index($param1)
    {
        grantAccessFor(array('Developer'));
        $data['title'] = 'Projects Detail Page';
        $data['user_login'] = $this->user->getById($this->session->userdata('id'));
        $data['project'] = $this->project->getById($param1);
        $data['dec'] = $this->dec->getById($param1);
        $current_uri = $this->uri->uri_string();
        $this->session->set_flashdata('current_page', $current_uri);
        $this->load->view('pages/nfr_decision', $data);
    }
    //Fungsi untuk menambahkan nfr decision (tidak digunakan)
    public function add($project_id = null)
    {
        grantAccessFor(array('Developer'));
        $data['title'] = 'Projects Detail Page';
        $data['user_login'] = $this->user->getById($this->session->userdata('id'));
        if ($project_id === null) {
            $project_id = $this->input->post('id_project');
        }
        $data['project'] = $this->project->getById($project_id);
        $data['dec'] = $this->dec->getById($project_id);
        $current_uri = $this->uri->uri_string();
        $this->session->set_flashdata('current_page', $current_uri);
        $this->form_validation->set_rules('dec_summary', 'Decision summary', 'required');
        $this->form_validation->set_rules('affected', 'Affected component', 'required');
        $this->form_validation->set_rules('rationale', 'Rationale', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('pages/nfr_decision', $data);
        } else {
           
            $data = [
                'dec_summary' => $this->input->post('dec_summary'),
                'affected' => $this->input->post('affected'),
                'rationale' => $this->input->post('rationale'),
                'id_project' => $project_id
            ];

            $this->dec->add($data);
            addLog('add', $this->session->userdata('name') . ' added data QR decision');
            $this->session->set_flashdata('message', 'QR decision data added successfully!');
            redirect('dev/projects/doc/nfr_decision/'.$project_id);
        }
    }
    //Fungsi untuk mengubah nfr decision yang dipilih
    public function update($param1,$project_id)
    {
        grantAccessFor(array('Developer'));
        $data['user_login'] = $this->user->getById($this->session->userdata('id'));
        $data['user'] = $this->user->get();
        $data = [
            'dec_summary' => $this->input->post('dec_update'),
            'affected' => $this->input->post('aff_update'),
            'rationale' => $this->input->post('rat_update'),
        ];
        $this->dec->update(['id_decision' => $param1], $data);
        addLog('update', $this->session->userdata('name') . ' updated data QR decision');
        $this->session->set_flashdata('message', 'QR decision data updated successfully!');
        redirect('dev/projects/doc/nfr_decision/'.$project_id);
    }
    //Fungsi untuk menghapus data nfr decision yang dipilih
    public function delete($param1,$project_id)
    {
        grantAccessFor(array('Developer'));
        $this->dec->delete($param1);
        $error = $this->db->error();
        if ($error['code'] != 0) {
            $this->session->set_flashdata('message', 'Error!');
        } else {
            addLog('delete', $this->session->userdata('name') . ' deleted data QR decision');
            $this->session->set_flashdata('message', 'QR decision data deleted successfully!');
            redirect('dev/projects/doc/nfr_decision/'.$project_id);
        }
    }
}
