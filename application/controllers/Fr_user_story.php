<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Fr_user_story extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Md_user', 'user');
        $this->load->model('Md_fr_user_story', 'fus');
        $this->load->model('Md_project', 'project');
    }
    // Fungsi untuk menampilkan detail FR user story berdasarkan project
    public function index($param1)
    {
        grantAccessFor(array('Developer'));
        $data['title'] = 'Projects Detail Page';
        $data['user_login'] = $this->user->getById($this->session->userdata('id'));
        $data['project'] = $this->project->getById($param1);
        $data['fus'] = $this->fus->getById($param1);
        $current_uri = $this->uri->uri_string();
        $this->session->set_flashdata('current_page', $current_uri);
        $this->load->view('pages/user_story_fr', $data);
    }
    // Fungsi untuk memperbarui data FR user story
    public function update($project_id,$param1)
    {
        grantAccessFor(array('Developer'));
        $data['user_login'] = $this->user->getById($this->session->userdata('id'));
        $data['user'] = $this->user->get();
        $data = [
            'description' => $this->input->post('description'),
        ];
        $this->fus->update(['id_us_fr' => $param1], $data);
        addLog('update', $this->session->userdata('name') . ' updated data FR user story');
        $this->session->set_flashdata('message', 'FR user story data updated successfully!');
        redirect('dev/projects/doc/fr_userstory/'.$project_id);
    }
}
