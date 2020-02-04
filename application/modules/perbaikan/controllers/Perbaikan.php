<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perbaikan extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Model_perbaikan');
	}

	public function index($load="")
	{
		if ($load == "load") {
			$where = "a.idPerbaikan IS NOT NULL";
			$status = $this->input->get('status');

			if ($this->session->userdata('roleUser') == '6') {
				$where .= " AND a.idUserPerbaikan = '".$this->session->userdata('idUser')."'";
			}

			if ($status != "") {
				$where .= " AND a.statusPerbaikan = '".$status."' ";			
			}

			$data = $this->Model_perbaikan->getAll($where);
			$ret = array();
			$status = "";
			foreach ($data as $key) {
				switch ($key['statusPerbaikan']) {
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
				$print = "";
				$key['statusPerbaikan'] = '<p class="text-center"><label class="label label-'.$status.'">'.$key['statusPerbaikan'].'</label></p>';
				$key['tanggalLapor'] = date('d/m/Y', strtotime($key['tanggalLapor']));
				$key['detail'] = '<a href="javascript:void(0)" onclick="vPerbaikan('.$key['idPerbaikan'].')" class="btn btn-xs btn-primary"><i class="fa fa-info-circle"></i></a>'.$print;
				$ret[] = $key;
			}
			echo json_encode(array("sEcho" => 1, "aaData" => $ret));
			exit();
		}
		$data['content'] = 'perbaikan_list';
		$this->load->view('backend/main',$data,FALSE);
	}

	/*masih belum tau terusannya 
	public function add($id="")
	{
		$data['other_js'] = "backend/vue/perbaikan.js";
		$data['content'] = 'perbaikan_add';
		$this->load->view('backend/main',$data,FALSE);
	}*/

	public function add()
	{
		$data['barang'] = $this->Model_perbaikan->getBarang();
		$data['item'] = $this->Model_perbaikan->getKode();
		$data['other_js'] = 'backend/vue/perbaikan.js';
		$data['content'] = 'perbaikan_add';
		$this->load->view('backend/main',$data,FALSE);
	}

	/*belum tau fungsinya untuk apa public function load($id)
	{
		$detail = $this->Model_perbaikan->getById($id);

		$data = array(
			'detail' => $detail,
			'item' => $this->Model_perbaikan->getItem($detail->idBarang)
			);

		$result = array(
			'data' => $data,
			'status' => 'success'
			);

		echo json_encode($result);

	}*/

	public function save()
	{
		$post = $this->input->post();

		$perbaikan_detail = json_decode($post['perbaikan_detail'], true);
		$lastId = $this->Model_perbaikan->getLastId()+1;
		/*masih belum tau datanya $item = json_decode($post['item'], true);*/

		$arr_detail = array(
			'kodePerbaikan' => generateCode('P',$lastId),
			'idUserPerbaikan' => $this->session->userdata('idUser'),
			'tanggalLapor' => date('Y-m-d'),
			'rincianLaporan' => $perbaikan_detail['rincianKerusakan'],
			'statusPerbaikan' => 1
				);
			$query = $this->Model_perbaikan->insertPerbaikan($arr_detail);
			$id = $this->db->insert_id();

		if(!$query){
			$response = array(
				'status' => 'failed',
				'message' => 'Maaf ada kesalahan, barang tidak dapat disimpan'
				);
			echo json_encode($response);
			exit();
		}

		$arr_perbaikan_detail = array(
				'idPerbaikan' => $id,
				'idBarang' => $perbaikan_detail['namaBarang'],
				'idItem' => $perbaikan_detail['kodeItem']
			);

			$this->db->insert('perbaikan_detail', $arr_perbaikan_detail);
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