<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Project extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Md_user', 'user');
		$this->load->model('Md_project', 'project');
		$this->load->model('Md_domain', 'domain');
		$this->load->model('Md_system', 'system');
		$this->load->model('Md_nfrlist', 'nfr_list');
		$this->load->model('Md_nfr', 'nfr');
		$this->load->model('Md_fr', 'fr');
		$this->load->model('Md_mapping_fr', 'mfr');
		$this->load->model('Md_mapping_nfr', 'mnfr');
		$this->load->model('Md_val_quest', 'quest');
		$this->load->model('Md_validation', 'val');
		$this->load->model('Md_cat', 'cat');
		$this->load->model('Md_nfr_decision', 'dec');
	}
	//Fungsi untuk menampilkan halaman project

	public function index()
	{
		grantAccessFor(array('Developer'));
		$data['title'] = 'Projects Page';
		$data['project'] = $this->project->get();
		$data['user_login'] = $this->user->getById($this->session->userdata('id'));
		$data['system'] = $this->system->get();
		$data['domain'] = $this->domain->get();
		$current_uri = $this->uri->uri_string();
		$this->session->set_flashdata('current_page', $current_uri);
		$this->load->view('pages/project', $data);
	}
	public function add()
	{
		grantAccessFor(array('Developer'));
	
		$data['title'] = 'Projects Page';
		$data['project'] = $this->project->get();
		$data['user_login'] = $this->user->getById($this->session->userdata('id'));
		$current_uri = $this->uri->uri_string();
		$data['system'] = $this->system->get();
		$data['domain'] = $this->domain->get();
		$this->session->set_flashdata('current_page', $current_uri);
	
		$this->form_validation->set_rules('name_project', 'Project Name', 'required');
		$this->form_validation->set_rules('domain', 'Domain', 'callback_domain_or_system_required');
		$this->form_validation->set_rules('system', 'System', 'callback_domain_or_system_required');
	
		if ($this->form_validation->run() == false) {
			$this->load->view('pages/project', $data);
		} else {
			$domain = $this->input->post('domain') ?: null;
			$system = $this->input->post('system') ?: null;
	
			$project_data = [
				'name_project' => $this->input->post('name_project'),
				'domain' => $domain ?: '',
				'system' => $system ?: '',
				'date_created' => date('Y-m-d H:i:s')
			];
	
			$this->project->add($project_data);
			$id_project = $this->db->insert_id();
	
			$recommended_from_master = $this->nfr_list->getNfr($domain, $system); 
			$recommended_from_others = $this->nfr_list->get_nfr_by_domain_system($domain, $system, $id_project);
	
			$combined_names = $recommended_from_master;
	
			foreach ($recommended_from_others as $nfr) {
				$combined_names[] = $nfr['name'];
			}
	
			$unique_nfr_names = array_unique($combined_names);
	
			$nfr_data = [];
			foreach ($unique_nfr_names as $nfr_name) {
				$nfr_data[] = [
					'id_project' => $id_project,
					'name' => $nfr_name
				];
			}
	
			foreach ($nfr_data as $nfr) {
				$this->nfr_list->add($nfr);
			}
	
			addLog('add', $this->session->userdata('name') . ' added data project');
			$this->session->set_flashdata('message', 'Project data added successfully!');
			redirect('dev/projects');
		}
	}
	
	
	// Fungsi validasi kustom untuk memastikan domain atau system harus diisi salah satu
	public function domain_or_system_required($value)
	{
		$domain = $this->input->post('domain');
		$system = $this->input->post('system');
	
		if (empty($domain) && empty($system)) {
			$this->form_validation->set_message('domain_or_system_required', 'Either Domain or System must be provided.');
			return false;
		}
		return true;
	}
	
	//Fungsi untuk memperbarui project yang dipilih
	public function update($param1)
	{
		grantAccessFor(array('Developer'));
		$data['user_login'] = $this->user->getById($this->session->userdata('id'));
		$data['user'] = $this->user->get();
		$data = [
			'name_project' => $this->input->post('name_update'),
		];
		$this->project->update(['id_project' => $param1], $data);
		addLog('update', $this->session->userdata('name') . ' updated data project');
		$this->session->set_flashdata('message', 'project data updated successfully!');
		redirect('dev/projects');
	}
	//Fungsi untuk menampilkan detail project
	public function detail($param1)
	{
		grantAccessFor(array('Developer'));
		$data['title'] = 'Projects Detail Page';
		$data['project'] = $this->project->getById($param1);
		$data['project_nfr'] = $this->nfr_list->getConfirm($param1);
		$data['user_login'] = $this->user->getById($this->session->userdata('id'));
		$current_uri = $this->uri->uri_string();
		$this->session->set_flashdata('current_page', $current_uri);
		$this->load->view('pages/project_info', $data);
	}
	public function elicitation($param1)
	{
		grantAccessFor(array('Developer'));
		$data['title'] = 'Projects Detail Page';
		$project = $this->project->getById($param1);
		$data['project'] = $project;
	
		// Pastikan tidak error jika system atau domain kosong
		$system_data = !empty($project['system']) ? $this->system->getByName($project['system']) : ['nfr' => ''];
		$domain_data = !empty($project['domain']) ? $this->domain->getByName($project['domain']) : ['nfr' => ''];
	
		$system_nfrs = !empty($system_data['nfr']) ? explode(',', $system_data['nfr']) : [];
		$domain_nfrs = !empty($domain_data['nfr']) ? explode(',', $domain_data['nfr']) : [];
	
		$this->db->select('type, nfr');
		$this->db->from('iso');
		$iso_nfrs_query = $this->db->get();
		$iso_nfrs_result = $iso_nfrs_query->result_array();
	
		$iso_nfrs_by_type = [];
		foreach ($iso_nfrs_result as $row) {
			$type = trim($row['type']);
			$nfrs = array_map('trim', explode(',', $row['nfr']));
			$iso_nfrs_by_type[$type] = $nfrs;
		}
	
		$max_length = max(count($system_nfrs), count($domain_nfrs));
		$all_rec = [];
	
		for ($i = 0; $i < $max_length; $i++) {
			$system_value = isset($system_nfrs[$i]) ? $system_nfrs[$i] : '';
			$domain_value = isset($domain_nfrs[$i]) ? $domain_nfrs[$i] : '';
			$iso_system_nfrs = isset($iso_nfrs_by_type[$system_value]) ? $iso_nfrs_by_type[$system_value] : [];
			$iso_domain_nfrs = isset($iso_nfrs_by_type[$domain_value]) ? $iso_nfrs_by_type[$domain_value] : [];
	
			if (!empty($system_value) || !empty($domain_value) || !empty($iso_system_nfrs) || !empty($iso_domain_nfrs)) {
				$all_rec[] = [
					'system' => $system_value,
					'domain' => $domain_value,
					'iso_system' => $iso_system_nfrs,
					'iso_domain' => $iso_domain_nfrs,
				];
			}
		}
		$data['all_rec'] = $all_rec;
	
		// Menghindari error jika domain atau system kosong
		$current_project = $this->project->getDomainSystem($param1);
		$domain_id = !empty($current_project['domain']) ? $current_project['domain'] : null;
		$system_id = !empty($current_project['system']) ? $current_project['system'] : null;
	
		$nfr_list = $this->nfr_list->get_nfr_by_domain_system($domain_id, $system_id, $param1);
		$nfr_usage = [];
		foreach ($nfr_list as $nfr) {
			$nfr_id = $nfr['name'];
			if (!isset($nfr_usage[$nfr_id])) {
				$nfr_usage[$nfr_id] = ['used_count' => 0, 'total_count' => 0];
			}
			if ($nfr['status'] == 2) {
				$nfr_usage[$nfr_id]['used_count']++;
			}
			$nfr_usage[$nfr_id]['total_count']++;
		}
	
		foreach ($nfr_usage as $nfr_id => $usage) {
			$nfr_usage[$nfr_id]['usage_percentage'] = ($usage['used_count'] / $usage['total_count']) * 100;
		}
		$data['nfr_usage'] = $nfr_usage;
		$data['nfr'] = $this->nfr->get_filtered_nfr($param1);
		$data['project_nfr'] = $this->nfr_list->get($param1);
		$data['user_login'] = $this->user->getById($this->session->userdata('id'));
		$current_uri = $this->uri->uri_string();
		$this->session->set_flashdata('current_page', $current_uri);
		$this->load->view('pages/project_eli', $data);
	}
	
	// Fungsi untuk menghapus QR di elicitation
	public function delete_eli($param1, $project_id)
	{
		grantAccessFor(array('Developer'));
		$this->nfr_list->delete($param1);
		$error = $this->db->error();
		if ($error['code'] != 0) {
			$this->session->set_flashdata('message', 'Error!');
		} else {
			addLog('delete', $this->session->userdata('name') . ' deleted data QR');
			$this->session->set_flashdata('message', 'QR data deleted successfully!');
			redirect('dev/projects/elicitation/' . $project_id);
		}
	}
	// Fungsi untuk menambahkan NFR di elicitation
	public function add_nfr($project_id = null)
	{
		grantAccessFor(array('Developer'));
		$data['user_login'] = $this->user->getById($this->session->userdata('id'));
		$data['title'] = 'Projects Detail Page';
		if ($project_id === null) {
			$project_id = $this->input->post('id_project');
		}
		$data['project'] = $this->project->getById($project_id);
		$data['frs'] = $this->fr->getById($project_id);
		$data['mappings'] = $this->mfr->getById($project_id);
		$data['mappings_nfr'] = $this->mnfr->getById($project_id);
		$data['mappings_nfr_formatted'] = [];
		foreach ($data['mappings_nfr'] as $mapping) {
			$data['mappings_nfr_formatted'][$mapping['id_nfr1']][$mapping['id_nfr2']] = $mapping['value'];
		}
		$current_uri = $this->uri->uri_string();
		$this->session->set_flashdata('current_page', $current_uri);
		$data = [
			'name' => $this->input->post('nfr'),
			'id_project' =>  $project_id,
			'status' => 0
		];

		$this->nfr_list->add($data);
		$project = $this->project->getById($project_id);

		if ($project && $project['validate'] == 1) {
			// Retrieve the NFR name from the form
			$nfr_name = $this->input->post('nfr'); // This is the NFR name

			// Fetch the corresponding NFR ID from the database based on the name
			$nfr = $this->nfr_list->getByName($nfr_name); 
			// Assuming you have a method to get NFR by name
			if ($nfr) {
				// If project is validated, add the NFR ID to qr_decision
				$qr_decision_data = [
					'id_project' => $project_id,
					'nfr' => $nfr['id_nfr_list'] // Store the ID of the NFR instead of the name
				];

				$this->dec->add($qr_decision_data);
			}
		}

		addLog('add', $this->session->userdata('name') . ' added data QR');
		$this->session->set_flashdata('message', 'QR data added successfully!');
		redirect('dev/projects/elicitation/' . $project_id);
	}
	//Fungsi untuk menampilkan halaman analisis 
	public function analysis($param1)
	{
		grantAccessFor(array('Developer'));
		$data['title'] = 'Projects Detail Page';
		$data['project'] = $this->project->getById($param1);
		$data['project_nfr'] = $this->nfr_list->get($param1);
		$data['nfr_list'] = $this->nfr_list->getFilter($param1);
		$data['frs'] = $this->fr->getById($param1);
		$data['mappings'] = $this->mfr->getById($param1);
		$data['mappings_nfr'] = $this->mnfr->getById($param1);

		$data['mappings_nfr_formatted'] = [];
		foreach ($data['mappings_nfr'] as $mapping) {
			$data['mappings_nfr_formatted'][$mapping['id_nfr1']][$mapping['id_nfr2']] = $mapping['value'];
		}
		$data['user_login'] = $this->user->getById($this->session->userdata('id'));
		$current_uri = $this->uri->uri_string();
		$this->session->set_flashdata('current_page', $current_uri);
		$this->load->view('pages/project_analysis', $data);
	}
	//Fungsi untuk menampilkan halaman document
	public function doc($param1)
	{
		grantAccessFor(array('Developer'));
		$data['title'] = 'Projects Detail Page';
		$data['project'] = $this->project->getById($param1);
		$data['user_login'] = $this->user->getById($this->session->userdata('id'));
		$current_uri = $this->uri->uri_string();
		$this->session->set_flashdata('current_page', $current_uri);
		$this->load->view('pages/project_doc', $data);
	}
	//Fungsi untuk menampilkan halaman validation
	public function val($param1)
	{
		grantAccessFor(array('Developer'));
		$data['title'] = 'Projects Detail Page';
		$data['project'] = $this->project->getById($param1);
		$data['user_login'] = $this->user->getById($this->session->userdata('id'));
		$data['project_nfr'] = $this->nfr_list->getFilter($param1);
		$data['questions'] = $this->quest->get_questions_with_categories($param1);
		$data['vals'] = $this->val->getById($param1);
		$data['cat'] = $this->cat->getByProject($param1);
		$current_uri = $this->uri->uri_string();
		$this->session->set_flashdata('current_page', $current_uri);
		$this->load->view('pages/project_val', $data);
	}
	//Fungsi untuk menampilkan halaman konfirmasi
	public function confirm($param1)
	{
		grantAccessFor(array('Developer'));
		$data['title'] = 'Projects Detail Page';
		$data['project'] = $this->project->getById($param1);
		$data['user_login'] = $this->user->getById($this->session->userdata('id'));
		$current_uri = $this->uri->uri_string();
		$this->session->set_flashdata('current_page', $current_uri);
		$data['project_nfr'] = $this->nfr_list->getFilter($param1);
		$this->load->view('pages/project_confirm', $data);
	}
	//Fungsi untuk melakukan konfirmasi NFR dengan cara update status 
	public function update_nfr()
	{
		$project_id = $this->input->post('id_project');
		$checked_nfrs = $this->input->post('nfrs');
		$all_nfrs = $this->nfr_list->get_all_nfr_by_project($project_id);
		if (empty($checked_nfrs)) {
			$this->session->set_flashdata('error', 'You must select at least one NFR.');
			redirect('dev/projects/confirm/' . $project_id);
			return;
		}
		$this->nfr_list->update_nfr_status($project_id, $checked_nfrs, 2);
		$unchecked_nfrs = array_diff($all_nfrs, $checked_nfrs);
		$this->nfr_list->update_nfr_status($project_id, $unchecked_nfrs, 1);
		$this->project->update_validate_status($project_id, 1);
		addLog('update', $this->session->userdata('name') . ' confirmed NFR');
		$this->session->set_flashdata('message', 'QRs confirmed successfully.');
		redirect('dev/projects/confirm/' . $project_id);
	}
	//Fungsi untuk menghapus project yang dipilih
	public function delete($param1)
	{
		grantAccessFor(array('Developer'));
		$this->project->delete($param1);
		$error = $this->db->error();
		if ($error['code'] != 0) {
			$this->session->set_flashdata('error', 'Error!');
		} else {
			addLog('delete', $this->session->userdata('name') . ' deleted data project');
			$this->session->set_flashdata('message', 'project data deleted successfully!');
			redirect('dev/projects');
		}
	}
}
