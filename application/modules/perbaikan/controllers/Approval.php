<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Approval extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Model_perbaikan');
	}

	public function index()
	{
		$data['perbaikan'] = $this->Model_perbaikan->getPerbaikan();
		$data['content'] = 'perbaikan_approval';
		$this->load->view('backend/main',$data,FALSE);
	}

	public function save()
	{
		$post = $this->input->post();

		$arr_perbaikan = array(
			'tglTindakan' => date('Y-m-d', strtotime($post['tanggalTindakan'])),
			'rincianTindakan' => $post['rincianTindakan'],
			'statusPerbaikan' => $post['statusPerbaikan'],
			'namaTeknisi' => $post['namaTeknisi']
			);

		$query = $this->db->update('perbaikan', $arr_perbaikan, array('idPerbaikan' => $post['idPerbaikan']));

		if ($query) {
			$response = array(
				'id' => encode($post['idPerbaikan']),
				'message' => 'Status Perbaikan Telah Terupdate',
				'status' => 'success'
				);
		}else{
			$response = array(
				'message' => 'Maaf, tidak dapat disimpan',
				'status' => 'failed'
				);			
		}

		echo json_encode($response);

	}

}