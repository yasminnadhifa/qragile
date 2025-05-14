<?php
defined('BASEPATH') or exit('No direct script access allowed');

class System extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Md_user', 'user');
        $this->load->model('Md_nfr', 'nfr');
        $this->load->model('Md_system', 'system');
    }
    //Fungsi untuk menampilkan system type
    public function index()
    {
        grantAccessFor(array('Developer'));
        $data['title'] = 'Systems Type Page';
        $data['user_login'] = $this->user->getById($this->session->userdata('id'));
        $data['system'] = $this->system->get();
        $data['nfr'] = $this->nfr->get();
        $current_uri = $this->uri->uri_string();
        $this->session->set_flashdata('current_page', $current_uri);
        $this->load->view('pages/system', $data);
    }
    //Fungsi untuk menambah system type baru 
    public function add()
    {
        grantAccessFor(array('Developer'));
        $data['title'] = 'Systems Type Page';
        $data['user_login'] = $this->user->getById($this->session->userdata('id'));
        $data['system'] = $this->system->get();
        $data['nfr'] = $this->nfr->get();
        $current_uri = $this->uri->uri_string();
        $this->session->set_flashdata('current_page', $current_uri);
        $this->form_validation->set_rules('type', 'System Type', 'required|is_unique[system.type]');
        $this->form_validation->set_rules('nfr[]', 'NFR', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('pages/system', $data);
        } else {
            $data = [
                'type' => $this->input->post('type'),
                'nfr' => implode(',', $this->input->post('nfr'))
            ];

            $this->system->add($data);
            addLog('add', $this->session->userdata('name') . ' added data system type');
            $this->session->set_flashdata('message', 'system type data added successfully!');
            redirect('dev/systems');
        }
    }
    //Fungsi untuk memperbarui system type yang dipilih
    public function update($param1)
    {
        grantAccessFor(array('Developer'));
        $data['user_login'] = $this->user->getById($this->session->userdata('id'));
        $data['user'] = $this->user->get();
        $data = [
            'type' => $this->input->post('type_update'),
            'nfr' => $this->input->post('nfr_update'),
        ];
        $this->system->update(['id_system' => $param1], $data);
        addLog('update', $this->session->userdata('name') . ' updated data system type');
        $this->session->set_flashdata('message', 'system type data updated successfully!');
        redirect('dev/systems');
    }
    //Fungsi untuk menghapus system type yang dipilih
    public function delete($param1)
    {
        grantAccessFor(array('Developer'));
        $this->system->delete($param1);
        $error = $this->db->error();
        if ($error['code'] != 0) {
            $this->session->set_flashdata('message', 'Error!');
        } else {
            addLog('delete', $this->session->userdata('name') . ' deleted data system type');
            $this->session->set_flashdata('message', 'system type data deleted successfully!');
            redirect('dev/systems');
        }
    }
}
