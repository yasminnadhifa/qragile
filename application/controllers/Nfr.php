<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Nfr extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Md_user', 'user');
        $this->load->model('Md_nfr', 'nfr');
    }
    //Fungsi untuk menampilkan NFR
    public function index()
    {
        grantAccessFor(array('Developer'));
        $data['title'] = 'QRs Page';
        $data['user_login'] = $this->user->getById($this->session->userdata('id'));
        $data['nfr'] = $this->nfr->get();
        $current_uri = $this->uri->uri_string();
        $this->session->set_flashdata('current_page', $current_uri);
        $this->load->view('pages/nfr', $data);
    }
    //Fungsi untuk menambah NFR baru
    public function add()
    {
        grantAccessFor(array('Developer'));
        $data['title'] = 'QRs Page';
        $data['user_login'] = $this->user->getById($this->session->userdata('id'));
        $data['nfr'] = $this->nfr->get();
        $current_uri = $this->uri->uri_string();
        $this->session->set_flashdata('current_page', $current_uri);
        $this->form_validation->set_rules('name', 'Name', 'required|is_unique[nfr.name]');
        if ($this->form_validation->run() == false) {
            $this->load->view('pages/nfr', $data);
        } else {
            $data = [
                'name' => $this->input->post('name'),
            ];

            $this->nfr->add($data);
            addLog('add', $this->session->userdata('name') . ' added data QR');
            $this->session->set_flashdata('message', 'QR data added successfully!');
            redirect('dev/NFRs');
        }
    }
    //Fungsi untuk memperbarui NFR yang dipilih
    public function update($param1)
    {
        grantAccessFor(array('Developer'));
        $data['user_login'] = $this->user->getById($this->session->userdata('id'));
        $data['user'] = $this->user->get();
        $data = [
            'name' => $this->input->post('name_update'),
        ];
        $this->nfr->update(['id_nfr' => $param1], $data);
        addLog('update', $this->session->userdata('name') . ' updated data QR');
        $this->session->set_flashdata('message', 'QR data updated successfully!');
        redirect('dev/NFRs');
    }
    //Fungsi untuk menghapus NFR yang dipilih
    public function delete($param1)
    {
        grantAccessFor(array('Developer'));
        $this->nfr->delete($param1);
        $error = $this->db->error();
        if ($error['code'] != 0) {
            $this->session->set_flashdata('message', 'Error!');
        } else {
            addLog('delete', $this->session->userdata('name') . ' deleted data QR');
            $this->session->set_flashdata('message', 'QR data deleted successfully!');
            redirect('dev/NFRs');
        }
    }
}
