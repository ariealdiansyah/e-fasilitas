<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends MY_Controller {

	public function index()
	{
		
	}

	public function getpeminjaman($par="")
	{
		$post = $this->input->post();
		if ($par == "vPeminjaman") {
			$this->load->model('peminjaman/Model_peminjaman');
			$data['data'] = $this->Model_peminjaman->getById($post['id']);
		}
		$this->load->view('modal/'.$par, $data, FALSE);

	}

	public function getperbaikan($par="")
	{
		$post = $this->input->post();
			if ($par == "vPerbaikan") {
			$this->load->model('perbaikan/Model_perbaikan');
			$data['data'] = $this->Model_perbaikan->getById($post['id']);
			}
		$this->load->view('modal/'.$par, $data, FALSE);

	}

}

/* End of file Data.php */
/* Location: ./application/modules/app/controllers/Data.php */