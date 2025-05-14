<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mapping_nfr extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Md_user', 'user');
        $this->load->model('Md_mapping_nfr', 'mnfr');
        $this->load->model('Md_project', 'project');
    }
    //Fungsi untuk memproses mapping nfr
    public function add()
    {
        grantAccessFor(array('Developer'));
        $data['user_login'] = $this->user->getById($this->session->userdata('id'));
        $data['title'] = 'Projects Detail Page';
        $current_uri = $this->uri->uri_string();
        $this->session->set_flashdata('current_page', $current_uri);
        $project_id = $this->input->post('id_project');
        $mappings = $this->input->post('mapping');
        $existing_mappings = $this->mnfr->getById($project_id);

        $existing_map = array();
        foreach ($existing_mappings as $mapping) {
            $existing_map[$mapping['id_nfr1']][$mapping['id_nfr2']] = $mapping['value'];
        }

        foreach ($mappings as $nfr1_id => $nfrs) {
            foreach ($nfrs as $nfr2_id => $value) {
                $data = array(
                    'id_project' => $project_id,
                    'id_nfr1' => $nfr1_id,
                    'id_nfr2' => $nfr2_id,
                    'value' => $value
                );
                $this->mnfr->add_or_update($data);
                unset($existing_map[$nfr1_id][$nfr2_id]);
            }
        }

        foreach ($existing_map as $nfr1_id => $nfrs) {
            foreach ($nfrs as $nfr2_id => $value) {
                $this->mnfr->delete($project_id, $nfr1_id, $nfr2_id);
            }
        }
        addLog('add', $this->session->userdata('name') . ' added data mapping QRxQR');
        $this->session->set_flashdata('message', 'Mappings saved successfully!');
        redirect('dev/projects/analysis/' . $project_id);
    }
}
