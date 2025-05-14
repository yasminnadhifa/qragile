<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Categories extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Md_user', 'user');
        $this->load->model('Md_cat', 'cat');
        $this->load->model('Md_project', 'project');
    }
   // Fungsi untuk menampilkan kategori 
    public function index($param1)
    {
        grantAccessFor(array('Developer'));
        $data['title'] = 'Projects Detail Page';
        $data['user_login'] = $this->user->getById($this->session->userdata('id'));
        $data['project'] = $this->project->getById($param1);
        $data['cat'] = $this->cat->getByProject($param1);
        $current_uri = $this->uri->uri_string();
        $this->session->set_flashdata('current_page', $current_uri);
        $this->load->view('pages/cat', $data);
    }
    // Fungsi untuk menambahkan kategori baru
    public function add($project_id = null)
    {
        grantAccessFor(array('Developer'));
        $data['user_login'] = $this->user->getById($this->session->userdata('id'));
        $data['title'] = 'Projects Detail Page';
        if ($project_id === null) {
            $project_id = $this->input->post('id_project');
        }
        $data['project'] = $this->project->getById($project_id);
        $data['cat'] = $this->cat->getByProject($project_id);
        $current_uri = $this->uri->uri_string();
        $this->session->set_flashdata('current_page', $current_uri);
        $this->form_validation->set_rules('name', 'name', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('pages/cat', $data);
        } else {
            $data = [
                'name' => $this->input->post('name'),
                'id_project' =>  $project_id
            ];

            $this->cat->add($data);
            addLog('add', $this->session->userdata('name') . ' added data category for validation');
            $this->session->set_flashdata('message', 'category data added successfully!');
            redirect('dev/projects/val/categories/' . $project_id);
        }
    }
    // Fungsi untuk memperbarui kategori yang ada
    public function update($project_id,$param1)
    {
        grantAccessFor(array('Developer'));
        $data['user_login'] = $this->user->getById($this->session->userdata('id'));
        $data['user'] = $this->user->get();
        $data = [
            'name' => $this->input->post('name_update')
        ];
        $this->cat->update(['id_cat' => $param1], $data);
        addLog('update', $this->session->userdata('name') . ' updated data category');
        $this->session->set_flashdata('message', 'category data updated successfully!');
        redirect('dev/projects/val/categories/'.$project_id);
    }
    // Fungsi untuk menghapus kategori
    public function delete($param1,$project_id)
    {
        grantAccessFor(array('Developer'));
        $this->cat->delete($param1);
        $error = $this->db->error();
        if ($error['code'] != 0) {
            $this->session->set_flashdata('message', 'Error!');
        } else {
            addLog('delete', $this->session->userdata('name') . ' deleted data category');
            $this->session->set_flashdata('message', 'category data deleted successfully!');
            redirect('dev/projects/val/categories/'.$project_id);
        }
    }
}
