<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Md_user', 'user');
		$this->load->model('Md_log', 'logs');
		$this->load->model('Md_project', 'project');
	}
	//Fungsi untuk menampilkan dashboard
	public function index()
	{
		grantAccessFor(array('Admin','Developer'));
		$data['total_user'] = $this->user->getTotal();
		$data['total_project'] = $this->project->getTotal();
		$data['total_val'] = $this->project->getTotalVal();
		$data['total_unval'] = $this->project->getTotalUnval();
		$data['log'] = $this->logs->get();
		$data['user_login'] = $this->user->getById($this->session->userdata('id'));
		$current_uri = $this->uri->uri_string();
        $this->session->set_flashdata('current_page', $current_uri);
        $this->load->view('pages/dashboard',$data);
	}
}
