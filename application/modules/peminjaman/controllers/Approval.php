<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Approval extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Model_peminjaman');
	}

	public function index($load="")
	{
		if ($load) {
			$where = "a.statusPeminjaman = 1";
			$data = $this->Model_peminjaman->getAll($where);
			$ret = array();
			foreach ($data as $key) {
				$key['kodePeminjaman'] = '<a href="javascript:void(0)" onclick="vPeminjaman('.$key['idPeminjaman'].')">'.$key['kodePeminjaman'].'</a>';
				$key['tanggalPinjam'] = date('d/m/Y', strtotime($key['tanggalPinjam']));
				$key['detail'] = '<a href="javascript:void(0)" onclick="action('."'setujui'".','.$key['idPeminjaman'].')"><button class="btn btn-icon waves-effect waves-light btn-success btn-xs m-b-5 tip-top" title="Setujui"><i class="fa fa-check"></i></button></a>&nbsp;<a href="javascript:void(0)" onclick="action('."'tolak'".','.$key['idPeminjaman'].')"><button class="btn btn-icon waves-effect waves-light btn-danger btn-xs m-b-5 tip-top" title="Tolak"><i class="fa fa-close"></i></button></a>';
				$ret[] = $key;
			}
			echo json_encode(array("sEcho" => 1, "aaData" => $ret));
			exit();
		}
		$data['content'] = 'peminjaman_approval';
		$this->load->view('backend/main',$data,FALSE);
	}

	public function action($par="")
	{
		$post = $this->input->post();
		$message = "";

		$data = array(
			'catatan' => $post['catatan'],
			'id' => $post['id']
			);

		if ($par == "setujui") {
			$query = $this->Model_peminjaman->approve(TRUE,$data);
			$message = "Peminjaman berhasil disetujui";
		}elseif ($par == "tolak") {
			$query = $this->Model_peminjaman->approve(FALSE,$data);
			$message = "Peminjaman berhasil ditolak";
		}

		if ($query) {
			$response = array(
				'id' => encode($post['id']),
				'message' => $message,
				'status' => 'success'
				);
			echo json_encode($response);
		}

	}

}