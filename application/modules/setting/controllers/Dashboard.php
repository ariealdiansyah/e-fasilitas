<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	public function index()
	{
		$data['content'] = 'dashboard_content';
		$this->load->view('backend/main',$data,FALSE);
	}

}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */