<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Iso extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Md_user', 'user');
        $this->load->model('Md_iso', 'iso');
        $this->load->model('Md_nfr', 'nfr');
    }
    // Fungsi untuk menampilkan halaman utama ISO
    public function index()
    {
        grantAccessFor(array('Developer'));
        $data['title'] = 'ISO Type Page';
        $data['user_login'] = $this->user->getById($this->session->userdata('id'));
        $data['iso'] = $this->iso->get();
        $data['nfr'] = $this->nfr->get();
        $current_uri = $this->uri->uri_string();
        $this->session->set_flashdata('current_page', $current_uri);
        $this->load->view('pages/iso', $data);
    }
    // Fungsi untuk menambahkan data ISO
    public function add()
    {
        grantAccessFor(array('Developer'));
        $data['title'] = 'ISO Type Page';
        $data['user_login'] = $this->user->getById($this->session->userdata('id'));
        $data['iso'] = $this->iso->get();
        $data['nfr'] = $this->nfr->get();
        $current_uri = $this->uri->uri_string();
        $this->session->set_flashdata('current_page', $current_uri);
        $this->form_validation->set_rules('type', 'ISO Type', 'required|is_unique[system.type]');
        $this->form_validation->set_rules('nfr[]', 'NFR', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('pages/iso', $data);
        } else {
            $data = [
                'type' => $this->input->post('type'),
                'nfr' => implode(',', $this->input->post('nfr'))
            ];

            $this->iso->add($data);
            addLog('add', $this->session->userdata('name') . ' added data ISO type');
            $this->session->set_flashdata('message', 'ISO type data added successfully!');
            redirect('dev/iso');
        }
    }
    // Fungsi untuk memperbarui data ISO
    public function update($param1)
    {
        grantAccessFor(array('Developer'));
        $data['user_login'] = $this->user->getById($this->session->userdata('id'));
        $data['user'] = $this->user->get();
        $data = [
            'type' => $this->input->post('type_update'),
            'nfr' => $this->input->post('nfr_update'),
        ];
        $this->iso->update(['id_iso' => $param1], $data);
        addLog('update', $this->session->userdata('name') . ' updated data ISO type');
        $this->session->set_flashdata('message', 'ISO type data updated successfully!');
        redirect('dev/iso');
    }
    // Fungsi untuk menghapus data ISO
    public function delete($param1)
    {
        grantAccessFor(array('Developer'));
        $this->iso->delete($param1);
        $error = $this->db->error();
        if ($error['code'] != 0) {
            $this->session->set_flashdata('message', 'Error!');
        } else {
            addLog('delete', $this->session->userdata('name') . ' deleted data ISO type');
            $this->session->set_flashdata('message', 'ISO type data deleted successfully!');
            redirect('dev/iso');
        }
    }
}
