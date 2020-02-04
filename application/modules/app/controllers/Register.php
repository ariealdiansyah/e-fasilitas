<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Model_register');
	}

	public function index()
	{
		$this->load->view('register','',FALSE);
	}


	public function submit()
	{

		$post = $this->input->post();

		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
		$this->form_validation->set_rules('email','Email','required|valid_email|is_unique[user.emailUser]');
		$this->form_validation->set_rules('username','Username','required|min_length[4]|is_unique[user.usernameUser]');		
		$this->form_validation->set_rules('fullname','Fullname','required');
		$this->form_validation->set_rules('password','Password','required|min_length[8]');
		$this->form_validation->set_rules('confirm_password','Konfirmasi Password','matches[password]');

		if ($this->form_validation->run() == TRUE) {

			$data = array(
				'emailUser' => $post['email'],
				'usernameUser' => $post['username'],
				'nameUser' => $post['fullname'],
				'passwordUser' => hash_password($post['confirm_password']),
				'statusUser' => 'y'
				);

			$query = $this->Model_register->insert($data);

			if ($query) {
				$this->session->set_flashdata('success_msg','Akun anda berhasil dibuat, silahkan login');
				redirect('app/login');
			}

		}else{
			$this->index();
		}


	}

}

/* End of file Register.php */
/* Location: ./application/modules/app/controllers/Register.php */