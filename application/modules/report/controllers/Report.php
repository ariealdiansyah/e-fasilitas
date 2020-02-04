<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('excel');		
	}

	public function peminjaman($id="")
	{
		$this->load->model('Model_report');
		$data['data'] = $this->Model_report->getById(decode($id));
		$this->load->view('report_peminjaman', $data, FALSE);
	}

}

/* End of file Report.php */
/* Location: ./application/modules/report/controllers/Report.php */