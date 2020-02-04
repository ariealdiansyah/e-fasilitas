<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model','',FALSE);
	}


	public function index(){
		$array_items = array('idUser', 'usernameUser','emailUser','roleUser','logged_in');
		$this->session->unset_userdata($array_items);
		delete_cookie('remember_me');
		redirect('app/login');
	}



}

/* End of file Logout.php */
/* Location: ./application/modules/membership/controllers/Logout.php */