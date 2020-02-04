<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function _remember_me(){
		if ($this->input->cookie('remember_me')) {
			$getMember = $this->model->get_where('user',array('usernameUser'=>$this->input->cookie('remember_me')));
			$newdata = array(
				'idUser'  => @$getUser[0]['idUser'],
				'usernameUser'  => @$getMember[0]['usernameUser'],
				'phone'  => @$getMember[0]['phone'],
				'roleUser' => @$getUser[0]['roleUser'],
				'logged_in' => TRUE,
				);
			$this->session->set_userdata($newdata);
		}	
	}

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model','',FALSE);
		$this->load->helper('email');	

		$this->_remember_me();
	}

	public function index()
	{

		if ($this->session->userdata('logged_in')) {
			redirect('app/dashboard');
		}else{
			$this->load->view('login','',FALSE);
		}

	}



	public function authenticate()
	{
		$get = $this->input->get();
		$post = $this->input->post();

		$email;
		$error;
		

		if (valid_email($post['uname'])) {
			$email = true;			
		}else{
			$email = false;			
		}

		$this->form_validation->set_rules('password', 'Password', 'trim|required');

		$filter = array();
		if($email)
			$filter = array('emailUser' => $post['uname']);
		else
			$filter = array('usernameUser' => $post['uname']);
		$getUser = $this->model->get_where('user',$filter);


		if (((@$getUser[0]['emailUser'] == $post['uname'] || @$getUser[0]['usernameUser'] == $post['uname'])) AND @$getUser[0]['passwordUser'] == hash_password($post['password']) AND @$getUser[0]['statusUser'] == 'y') {

			$data = array();
			$data['lastLogin'] = date('Y-m-d H:i:s');					
			$this->model->update_data('user',$data,array('idUser'=>$getUser[0]['idUser']));
			$newdata = array(
				'idUser'  => @$getUser[0]['idUser'],
				'emailUser'  => @$getUser[0]['emailUser'],
				'usernameUser'  => @$getUser[0]['usernameUser'],
				'roleUser' => @$getUser[0]['roleUser'],
				'logged_in' => TRUE,
				);
			$this->session->set_userdata($newdata);
			if (@$post['remember_me']) {
				$this->input->set_cookie('remember_me',  $newdata, 100000000);
			}
			
			// redirect('app/dashboard');

			if( $this->session->userdata('redirect_back') ) {
				$redirect_url = $this->session->userdata('redirect_back');
				$this->session->unset_userdata('redirect_back');						
				redirect( $redirect_url );
			}else{
				redirect('app/dashboard');
			}

		}elseif (((@$getUser[0]['emailUser'] == $post['uname'] || @$getUser[0]['usernameUser'] == $post['uname'])) AND @$getUser[0]['passwordUser'] != hash_password($post['password'])) {
			$error = "Maaf password anda salah";
			$this->session->set_flashdata('temp_uname', $post['uname']);
		}elseif (((@$getUser[0]['emailUser'] == $post['uname'] || @$getUser[0]['usernameUser'] == $post['uname'])) AND @$getUser[0]['passwordUser'] == hash_password($post['password']) AND @$getUser[0]['statusUser'] == 'n') {
			$error = "Maaf anda tidak dapat masuk";
			$this->session->set_flashdata('temp_uname', $post['uname']);
		}else{
			$error = "Maaf username/password anda salah";
		}

		$this->session->set_flashdata('error_msg', $error);
		redirect('app/login');

		// if ($getUser[0]['usernameMember']==$get['username'] && $getUser[0]['passwordMember']==$get['password'] && $getUser[0]['statusMember']=='Active') {
		// 	$newdata = array(
		// 		'idMember'  => @$getUser[0]['idMember'],
		// 		'usernameMember'  => @$getUser[0]['usernameMember'],
		// 		'roleMember' => @$getUser[0]['roleMember'],
		// 		'logged_in' => TRUE,
		// 		);
		// 	$this->session->set_userdata($newdata);
		// 	redirect('pengaturan/user');
		// }	
		// else{
		// 	echo 'password salah';
		// }

	}

}

/* End of file Login.php */
/* Location: ./application/modules/App/controllers/Login.php */