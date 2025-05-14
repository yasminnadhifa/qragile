<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Domain extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Md_user', 'user');
        $this->load->model('Md_nfr', 'nfr');
        $this->load->model('Md_domain', 'domain');
    }
    // Fungsi untuk menampilkan daftar tipe domain
    public function index()
    {
        grantAccessFor(array('Developer'));
        $data['title'] = 'Domain Type Page';
        $data['user_login'] = $this->user->getById($this->session->userdata('id'));
        $data['domain'] = $this->domain->get();
        $data['nfr'] = $this->nfr->get();
        $current_uri = $this->uri->uri_string();
        $this->session->set_flashdata('current_page', $current_uri);
        $this->load->view('pages/domain', $data);
    }
    // Fungsi untuk menambahkan tipe domain baru
    public function add()
    {
        grantAccessFor(array('Developer'));
        $data['title'] = 'Domain Type Page';
        $data['user_login'] = $this->user->getById($this->session->userdata('id'));
        $data['domain'] = $this->domain->get();
        $data['nfr'] = $this->nfr->get();
        $current_uri = $this->uri->uri_string();
        $this->session->set_flashdata('current_page', $current_uri);
        $this->form_validation->set_rules('type', 'Domain Type', 'required|is_unique[system.type]');
        $this->form_validation->set_rules('nfr[]', 'NFR', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('pages/domain', $data);
        } else {
            $data = [
                'type' => $this->input->post('type'),
                'nfr' => implode(',', $this->input->post('nfr'))
            ];

            $this->domain->add($data);
            addLog('add', $this->session->userdata('name') . ' added data domain type');
            $this->session->set_flashdata('message', 'domain type data added successfully!');
            redirect('dev/domains');
        }
    }
    // Fungsi untuk memperbarui tipe domain yang ada
    public function update($param1)
    {
        grantAccessFor(array('Developer'));
        $data['user_login'] = $this->user->getById($this->session->userdata('id'));
        $data['user'] = $this->user->get();
        $data = [
            'type' => $this->input->post('type_update'),
            'nfr' => $this->input->post('nfr_update'),
        ];
        $this->domain->update(['id_domain' => $param1], $data);
        addLog('update', $this->session->userdata('name') . ' updated data domain type');
        $this->session->set_flashdata('message', 'domain type data updated successfully!');
        redirect('dev/domains');
    }
    // Fungsi untuk menghapus tipe domain
    public function delete($param1)
    {
        grantAccessFor(array('Developer'));
        $this->domain->delete($param1);
        $error = $this->db->error();
        if ($error['code'] != 0) {
            $this->session->set_flashdata('message', 'Error!');
        } else {
            addLog('delete', $this->session->userdata('name') . ' deleted data domain type');
            $this->session->set_flashdata('message', 'domain type data deleted successfully!');
            redirect('dev/domains');
        }
    }
}
