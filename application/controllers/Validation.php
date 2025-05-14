<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Validation extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Md_user', 'user');
        $this->load->model('Md_validation', 'val');
        $this->load->model('Md_project', 'project');
        $this->load->model('Md_cat', 'cat');
    }
    //Fungsi untuk memproses validasi 
    public function add()
    {
        grantAccessFor(array('Developer'));
        $data['user_login'] = $this->user->getById($this->session->userdata('id'));
        $data['title'] = 'Projects Detail Page';
        
        $current_uri = $this->uri->uri_string();
        $this->session->set_flashdata('current_page', $current_uri);
        $project_id = $this->input->post('id_project');
        $vals = $this->input->post('val');
        $data['cat'] = $this->cat->getByProject($project_id);
        $existing_vals = $this->val->getById($project_id);

        $existing_val = array();
        foreach ($existing_vals as $val) {
            $existing_val[$val['id_quest']][$val['id_nfr']] = $val['value'];
        }
        foreach ($vals as $quest_id => $nfrs) {
            foreach ($nfrs as $nfr_id => $value) {
                $data = array(
                    'id_project' => $project_id,
                    'id_quest' => $quest_id,
                    'id_nfr' => $nfr_id,
                    'value' => $value
                );
                $this->val->add_or_update($data);
                unset($existing_val[$quest_id][$nfr_id]);
            }
        }

        foreach ($existing_val as $quest_id => $nfrs) {
            foreach ($nfrs as $nfr_id => $value) {
                $this->val->delete($project_id, $quest_id, $nfr_id);
            }
        }
        addLog('add', $this->session->userdata('name') . ' added data validation');
        $this->session->set_flashdata('message', 'Validation data saved successfully!');
        redirect('dev/projects/val/' . $project_id);
    }
}
