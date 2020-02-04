<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peminjaman extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Model_peminjaman');
	}

	public function index($load="")
	{
		if ($load == "load") {
			$where = "a.idPeminjaman IS NOT NULL";
			$status = $this->input->get('status');

			if ($this->session->userdata('roleUser') == '6') {
				$where .= " AND a.userPeminjam = '".$this->session->userdata('idUser')."'";
			}

			if ($status != "") {
				$where .= " AND a.statusPeminjaman = '".$status."' ";			
			}

			$data = $this->Model_peminjaman->getAll($where);
			$ret = array();
			$status = "";
			foreach ($data as $key) {
				switch ($key['statusPeminjaman']) {
					case 'Peminjaman Baru':
					$status = "info";
					break;
					case 'Disetujui':
					$status = "success";
					break;
					case 'Ditolak':
					$status = "danger";
					break;
					case 'Dikembalikan':
					$status = "warning";
					break;
					default:
					$status = "info";
					break;
				}
				$print = "";
				if ($key['statusPeminjaman'] == 'Disetujui' || $key['statusPeminjaman'] == 'Dikembalikan') {
					$print = '&nbsp; <a href="'.base_url('report/peminjaman/'.encode($key['idPeminjaman'])).'" target="blank" class="btn btn-xs btn-success"><i class="fa fa-print"></i></a>';
				}
				$key['statusPeminjaman'] = '<p class="text-center"><label class="label label-'.$status.'">'.$key['statusPeminjaman'].'</label></p>';
				$key['tanggalPinjam'] = date('d/m/Y', strtotime($key['tanggalPinjam']));
				$key['detail'] = '<a href="javascript:void(0)" onclick="vPeminjaman('.$key['idPeminjaman'].')" class="btn btn-xs btn-primary"><i class="fa fa-info-circle"></i></a>'.$print;
				$ret[] = $key;
			}
			echo json_encode(array("sEcho" => 1, "aaData" => $ret));
			exit();
		}
		$data['content'] = 'peminjaman_list';
		$this->load->view('backend/main',$data,FALSE);
	}

	public function add($id="")
	{
		$data['other_js'] = "backend/vue/peminjaman.js";
		$data['content'] = 'peminjaman_add';
		$this->load->view('backend/main',$data,FALSE);
	}

	public function save()
	{
		$post = $this->input->post();
		$peminjaman = json_decode($post['peminjaman'], true);
		$item = json_decode($post['item'], true);

		$lastId = $this->Model_peminjaman->getLastId()+1;
		$noDok = $lastId."/".getBulan(date('m'),'romawi')."/".date('Y')."/Profas";

		$arr_peminjaman = array(
			'kodePeminjaman' => generateCode('P',$lastId),
			'noDokPeminjaman' => $noDok,
			'tglDokPeminjaman' => date('Y-m-d'),
			'userPeminjam' => $this->session->userdata('idUser'),
			'tujuanPinjam' => $peminjaman['tujuanPinjam'],
			'tanggalPinjam' => date('Y-m-d', strtotime($peminjaman['tanggalPinjam'])),
			'batasPinjam' => date('Y-m-d', strtotime($peminjaman['batasPinjam']))
			);

		$query = $this->Model_peminjaman->insert($arr_peminjaman);
		$id = $this->db->insert_id();

		if(!$query){
			$response = array(
				'status' => 'failed',
				'message' => 'Maaf ada kesalahan, data tidak dapat disimpan'
				);
			echo json_encode($response);
			exit();
		}

		foreach ($item as $key) {
			$arr_detail = array(
				'idPeminjaman' => $id,
				'idItem' => $key['idItem']
				);
			$this->db->insert('peminjaman_detail', $arr_detail);
		}

		$response = array(
			'status' => 'success',
			'message' => 'Anda berhasil mengajukan permintaan peminjaman barang'
			);

		echo json_encode($response);

	}

}