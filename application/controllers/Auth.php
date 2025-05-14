<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Md_user', 'user');
	}
	// Fungsi untuk menangani proses login
	public function index()
	{
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		if ($this->form_validation->run() == false) {
			$this->load->view('pages/auth');
		} else {
			$username = $this->input->post('username');
			$password = hash('sha256', $this->input->post('password'));
			$user = $this->user->getByUsername($username);

			if ($user) {
				if ($password == $user['password']) {
					$data = [
						'username' => $user['username'],
						'id' => $user['id_user'],
						'role' => $user['role'],
						'name' => $user['name'],
					];
					$this->session->set_userdata($data);
					addLog('login', $this->session->userdata('name') . ' logged in');
					if ($user['role'] == 'Admin') {
						redirect('console/dashboard');
					} elseif ($user['role'] == 'Developer') {
						redirect('dev/dashboard');
					}
				} else {
					$this->session->set_flashdata('message', 'Incorrect Password!');
					redirect('auth');
				}
			} else {
				$this->session->set_flashdata('message', 'Account Not Found!');
				redirect('auth');
			}
		}
	}

	// Fungsi untuk menangani proses logout
	public function logout()
	{
		addLog('logout', $this->session->userdata('name') . ' logged out');
		$this->session->unset_userdata('id');
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('role');
		$this->session->unset_userdata('name');
		redirect('auth');
	}
	//Fungsi untuk mengganti password 
	public function change_pass()
	{
		$data['user_login'] = $this->user->getBy();
		$data['title'] = 'Setting Page';
		$this->form_validation->set_rules(
			'passwordnew',
			'password',
			'required|trim|min_length[5]'
		);
		$this->form_validation->set_rules(
			'passwordconfirm',
			'confirm password',
			'required|trim|matches[passwordnew]'
		);
		if ($this->form_validation->run() == false) {
			$this->load->view('pages/change_pass', $data);
		} else {
			$data = [
				'password' => hash('sha256', $this->input->post('passwordnew')),
			];

			$id = $this->session->userdata('id');
			$this->user->update(['id_user' => $id], $data);
			addLog('update', $this->session->userdata('name') . ' changed password');
			$this->session->set_flashdata('message', 'password updated successfully!');
			redirect('dev/setting');
		}
	}
	//Fungsi send email 
	private function sendEmail($token, $type)
	{
		$config = [
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_user' => 'hipmicare@gmail.com',
			'smtp_pass' => 'oqhc xdix xlki zgah',
			'smtp_port' => 465,
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'newline' => "\r\n"
		];
		$data['email'] = $this->input->post('email', true);
		$this->load->library('email');
		$this->email->initialize($config);
		$this->email->from('hipmicare@gmail.com', 'QR-Agile Website Services.');
		$this->email->to($data['email']);


		if ($type == 'forgot') {
			$this->email->subject('Change your password account');
			$data['reset_link'] = base_url() . 'change_pass?email=' . $this->input->post('email', true) . '&token=' . urlencode($token);
			$data['company_name'] = 'QR-Agile Website Services';
			$message = $this->load->view('pages/email', $data, TRUE);
			$this->email->message($message);
		}

		if ($this->email->send()) {
			return true;
		} else {
			echo $this->email->print_debugger();
			die;
		}
	}
	//Fungsi untuk pengecekan username
	public function forgot()
	{
		$this->form_validation->set_rules(
			'email',
			'email',
			'required'
		);
		if ($this->form_validation->run() == false) {
			$this->load->view('pages/forgot');
		} else {
			$email = $this->input->post('email');
			if ($this->db->get_where('user', ['email' => $email])->row_array()) {
				$token = base64_encode(random_bytes(32));
				$user_token = [
					'email' => $email,
					'token' => $token,
					'date_created' => time()
				];

				$this->db->insert('user_token', $user_token);
				$this->sendEmail($token, 'forgot');
				$this->session->set_flashdata('success', 'Check your email');
				redirect('forgot');
			} else {
				$this->session->set_flashdata('message', 'Email not found!');
				redirect('forgot');
			}
		}
	}
	public function reset()
	{
		$email = $this->input->get('email');
		$token = $this->input->get('token');

		$user = $this->db->get_where('user', ['email' => $email])->row_array();

		if ($user) {
			$user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

			if ($user_token) {
				if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
					$this->session->set_userdata('reset_email', $email);
					$this->change_forgot();
				} else {
					$this->db->delete('user_token', ['token' => $token]);
					$this->session->set_flashdata('message', 'Password reset failed, the link has expired.');
					redirect('auth');
				}
			} else {
				$this->session->set_flashdata('message', 'Password reset failed, invalid token.');
				redirect('auth');
			}
		} else {
			$this->session->set_flashdata('message', 'Password reset failed, invalid email.');
			redirect('auth');
		}
	}
	public function change_forgot()
	{
		if (!$this->session->userdata('reset_email')) {
			redirect('auth');
		}
		$this->form_validation->set_rules(
			'passwordnew',
			'password',
			'required|trim|min_length[5]'
		);
		$this->form_validation->set_rules(
			'passwordconfirm',
			'confirm password',
			'required|trim|matches[passwordnew]'
		);
		if ($this->form_validation->run() == false) {
			$this->load->view('pages/change_forgot');
		} else {
			$password= hash('sha256', $this->input->post('passwordnew'));
			$email = $this->session->userdata('reset_email');
			$this->db->set('password', $password);
			$this->db->where('email', $email);
			$this->db->update('user');
			$this->session->unset_userdata('reset_email');
			$this->session->set_flashdata('success', 'password updated successfully!');
			redirect('auth');
		}
	}
}
