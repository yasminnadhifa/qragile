<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Nfr_user_story extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Md_user', 'user');
        $this->load->model('Md_nfr_user_story', 'nus');
        $this->load->model('Md_project', 'project');
        $this->load->model('Md_nfrlist', 'nfr_list');

    }
    //Fungsi untuk menampilkan nfr user story 
    public function index($param1)
    {
        grantAccessFor(array('Developer'));
        $data['title'] = 'Projects Detail Page';
        $data['user_login'] = $this->user->getById($this->session->userdata('id'));
        $data['project'] = $this->project->getById($param1);
        $results = $this->nus->getById($param1);
        $nfr_ids = [];
        foreach ($results as &$result) {
            if (!empty($result['nfr'])) {
                $nfr_ids = array_merge($nfr_ids, explode(',', $result['nfr']));
            }
        }
        $nfr_ids = array_unique($nfr_ids);
        if (!empty($nfr_ids)) {
            $nfr_names = $this->nfr_list->getNfrNamesByIds($nfr_ids);
            $nfr_name_map = [];
            foreach ($nfr_names as $nfr) {
                $nfr_name_map[$nfr['id_nfr_list']] = $nfr['name'];
            }
            foreach ($results as &$result) {
                if (!empty($result['nfr'])) {
                    $nfr_ids = explode(',', $result['nfr']);
                    $nfr_names = array_map(function($id) use ($nfr_name_map) {
                        return $nfr_name_map[$id] ?? $id;
                    }, $nfr_ids);
                    $result['nfr'] = implode(', ', $nfr_names);
                }
            }
        }
        $data['nus'] = $results;
        $current_uri = $this->uri->uri_string();
        $this->session->set_flashdata('current_page', $current_uri);
        $this->load->view('pages/user_story_nfr', $data);
    }
    // Fungsi untuk memperbarui data NFR user story
    public function update($project_id,$param1)
    {
        grantAccessFor(array('Developer'));
        $data['user_login'] = $this->user->getById($this->session->userdata('id'));
        $data['user'] = $this->user->get();
        $data = [
            'description' => $this->input->post('description'),
        ];
        $this->nus->update(['id_us_nfr' => $param1], $data);
        addLog('update', $this->session->userdata('name') . ' updated data QR user story');
        $this->session->set_flashdata('message', 'QR user story data updated successfully!');
        redirect('dev/projects/doc/nfr_userstory/'.$project_id);
    }
}
