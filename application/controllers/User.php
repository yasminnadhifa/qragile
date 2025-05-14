<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Md_user', 'user');
    }
    //Fungsi untuk menampilkan user 
    public function index()
    {
        grantAccessFor(array('Admin'));
        $data['title'] = 'Users Page';
        $data['user_login'] = $this->user->getById($this->session->userdata('id'));
        $data['user'] = $this->user->get();
        $current_uri = $this->uri->uri_string();
        $this->session->set_flashdata('current_page', $current_uri);
        $this->load->view('pages/user', $data);
    }
    //Fungsi untuk menambahkan user baru
    public function add()
    {
        grantAccessFor(array('Admin'));
        $data['title'] = 'User Page';
        $data['user_login'] = $this->user->getById($this->session->userdata('id'));
        $data['user'] = $this->user->get();
        $current_uri = $this->uri->uri_string();
        $this->session->set_flashdata('current_page', $current_uri);
        $this->form_validation->set_rules('name', ' name', 'required');
        $this->form_validation->set_rules('role', ' role', 'required');
        $this->form_validation->set_rules('username', 'username', 'required|is_unique[user.username]');
        $this->form_validation->set_rules(
            'email',
            'email',
            'required|valid_email|is_unique[user.email]',
            array(
                'required' => 'The %s field is required.',
                'valid_email' => 'Please enter a valid email address.',
                'is_unique' => 'The %s address is already registered.'
            )
        );
        if ($this->form_validation->run() == false) {

            $this->load->view('pages/user', $data);
        } else {
            $data = [
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'username' => $this->input->post('username'),
                'password' => hash('sha256', $this->input->post('username') . '12345'),
                'role' => $this->input->post('role'),
            ];

            $this->user->add($data);
            addLog('add', $this->session->userdata('name') . ' added user');
            $this->session->set_flashdata('message', 'User data added successfully!');
            redirect('console/users');
        }
    }
    //Fumgsi untuk memperbarui user yang dipilih
    public function update($param1)
    {
        grantAccessFor(array('Admin'));
        $data['user_login'] = $this->user->getById($this->session->userdata('id'));
        $data['user'] = $this->user->get();
        $data = [
            'name' => $this->input->post('name_update'),
            'role' => $this->input->post('role_update')
        ];
        $this->user->update(['id_user' => $param1], $data);
        addLog('update', $this->session->userdata('name') . ' updated data user');
        $this->session->set_flashdata('message', 'User data updated successfully!');
        redirect('console/users');
    }
    //Fungsi untuk menghapus user yang dipilih
    public function delete($param1)
    {
        grantAccessFor(array('Admin'));
        $loggedInUserId = $this->session->userdata('id');

        if ($param1 == $loggedInUserId) {
            $this->session->set_flashdata('error', 'You cannot delete your own account!');
            redirect('console/users');
            return;
        }
        $this->user->delete($param1);
        $error = $this->db->error();
        if ($error['code'] != 0) {
            $this->session->set_flashdata('message', 'Error!');
        } else {
            addLog('delete', $this->session->userdata('name') . ' deleted data user');
            $this->session->set_flashdata('message', 'User data deleted successfully!');
            redirect('console/users');
        }
    }
}
