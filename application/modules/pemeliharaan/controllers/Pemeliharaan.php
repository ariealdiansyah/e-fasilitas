<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pemeliharaan extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Model_pemeliharaan');
	}

	public function index($load="")
	{
		if ($load) {
			$where = "a.idPemeliharaan IS NOT NULL";
			$status = $this->input->get('status');

			/*if ($this->session->userdata('roleUser') == '6') {
				$where .= " AND a.idUserPemeliharaan = '".$this->session->userdata('idUser')."'";
			}

			if ($this->session->userdata('roleUser') == '7') {
				$where .= " AND a.idUserPemeliharaan = '".$this->session->userdata('idUser')."'";
			}*/

			if ($status != "") {
				$where .= " AND a.statusPemeliharaan = '".$status."' ";			
			}

			$data = $this->Model_pemeliharaan->getAll($where);
			$ret = array();
			$status = "";
			foreach ($data as $key) {
				switch ($key['statusPemeliharaan']) {
					case 'terjadwal':
					$status = "info";
					break;
					case 'proses':
					$status = "success";
					break;
					case 'selesai':
					$status = "warning";
					break;
					default:
					$status = "info";
					break;
				}
				$key['statusPemeliharaan'] = '<p class="text-center"><label class="label label-'.$status.'">'.$key['statusPemeliharaan'].'</label></p>';
				$key['tanggalLapor'] = date('d/m/Y', strtotime($key['tanggalLapor']));
				$ret[] = $key;
			}
			echo json_encode(array("sEcho" => 1, "aaData" => $ret));
			exit();
		}
		$data['content'] = 'pemeliharaan_list';
		$this->load->view('backend/main',$data,FALSE);
	}

	public function add()
	{
		$data['barang'] = $this->Model_pemeliharaan->getBarang();
		$data['item'] = $this->Model_pemeliharaan->getKode();
		// validasi di vue.js
		$data['other_js'] = 'backend/vue/pemeliharaan.js';
		$data['content'] = 'pemeliharaan_add';
		$this->load->view('backend/main',$data,FALSE);
	}

	public function update()
	{
		$data['pemeliharaan'] = $this->Model_pemeliharaan->getPemeliharaan();
		$data['content'] = 'pemeliharaan_update';
		$this->load->view('backend/main',$data,FALSE);
	}

	public function saveupdate()
	{
		$post = $this->input->post();

		$arr_perbaikan = array(
			'tanggalUpdate' => date('Y-m-d', strtotime($post['tanggalUpdate'])),
			'statusPemeliharaan' => $post['statusPemeliharaan']
			);

		$query = $this->db->update('pemeliharaan', $arr_perbaikan, array('idPemeliharaan' => $post['idPemeliharaan']));

		if ($query) {
			$response = array(
				'id' => encode($post['idPemeliharaan']),
				'message' => 'Status Pemeliharaan Telah Terupdate',
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

	public function load($id)
	{
		$detail = $this->Model_pemeliharaan->getById($id);

		$data = array(
			'detail' => $detail,
			'item' => $this->Model_pemeliharaan->getItem($detail->idBarang));
		
		$result = array(
			'data' => $data,
			'status' => 'success');

		echo json_encode($result);
	}

	public function save()
	{
		$post = $this->input->post();

		$pemeliharaan_detail = json_decode($post['pemeliharaan_detail'], true);
		/*masih belum tau datanya $item = json_decode($post['item'], true);*/
		$lastId = $this->Model_pemeliharaan->getLastId()+1;

		$arr_detail = array(
			'kodePemeliharaan' => generateCode('P',$lastId),
			'idUserPemeliharaan' => $this->session->userdata('idUser'),
			'tanggalLapor' => date('Y-m-d'),
			'rincianLapor' => $pemeliharaan_detail['rincianLapor'],
			'statusPemeliharaan' => 1,
			'namaTeknisi' => $pemeliharaan_detail['namaTeknisi']
				);
			$query = $this->Model_pemeliharaan->insertPemeliharaan($arr_detail);
			$id = $this->db->insert_id();

		if(!$query){
			$response = array(
				'status' => 'failed',
				'message' => 'Maaf ada kesalahan, barang tidak dapat disimpan'
				);
			echo json_encode($response);
			exit();
		}

		$arr_pemeliharaan_detail = array(
				'idPemeliharaan' => $id,
				'idBarang' => $pemeliharaan_detail['namaBarang'],
				'idItem' => $pemeliharaan_detail['kodeItem']
			);

			$this->db->insert('pemeliharaan_detail', $arr_pemeliharaan_detail);
		/*masih salah di vue js perbaikan nya, var item tidak ke detect 
		foreach($item as $key){
			$arr_perbaikan_detail = array(
				'idPerbaikan' => $id,
				'idBarang' => $perbaikan_detail['namaBarang'],
				'idItem' => $perbaikan_detail['kodeItem']
			);

			$this->db->insert('perbaikan_detail', $arr_perbaikan_detail);
		}*/

		$response = array(
			'status' => 'success',
			'message' => 'Data barang berhasil disimpan'
			);

		echo json_encode($response);

	}


}