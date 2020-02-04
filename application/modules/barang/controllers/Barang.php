<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Model_barang');
	}

	public function load($id)
	{
		$detail = $this->Model_barang->getById($id);

		$data = array(
			'detail' => $detail,
			'item' => $this->Model_barang->getItem($detail->idBarang)
			);

		$result = array(
			'data' => $data,
			'status' => 'success'
			);

		echo json_encode($result);

	}

	public function index($load="")
	{
		$this->load->library('datatables');

		if ($load == "load") {
			$kategori = $this->input->get('kategori');
			$where = "a.idBarang IS NOT NULL";
			if ($kategori != "") {
				$where .= " AND a.idKategori = '".$kategori."' ";			
			}
			$data = $this->Model_barang->getBarang($where);
			$ret = array();
			foreach ($data as $key) {
				$key['jumlah_item'] = count_all('item',array('idBarang' => $key['idBarang'],'statusItem' => 'aktif', 'kondisiItem' => 'B'));
				$key['detail'] = "<a href='".base_url('barang/detail/'.$key['idBarang'])."' class='btn btn-xs btn-primary'><span class='fa fa-info-circle'><span></a>";
				$ret[] = $key;
			}
			echo json_encode(array("sEcho" => 1, "aaData" => $ret));
			exit();
		}

		$data['content'] = 'barang_content';
		$this->load->view('backend/main',$data,FALSE);
	}

	public function detail($id="")
	{
		$data['data'] = $this->Model_barang->getById($id);
		$data['lokasi'] = $this->Model_barang->getLokasi();
		$data['kategori'] = $this->Model_barang->getKategori();

		if ($data['data'] == NULL) {
			redirect(base_url('barang'));
		}

		$data['other_js'] = 'backend/vue/barang.js';
		$data['content'] = 'barang_add';
		$this->load->view('backend/main',$data,FALSE);
	}

	public function add()
	{
		$data['lokasi'] = $this->Model_barang->getLokasi();
		$data['kategori'] = $this->Model_barang->getKategori();
		$data['other_js'] = 'backend/vue/barang.js';
		$data['content'] = 'barang_add';
		$this->load->view('backend/main',$data,FALSE);
	}

	public function delete($par="",$id="")
	{

		if ($par == 'item') {
			$query = $this->Model_barang->updateItem(array('statusItem' => 'tidak aktif'),$id);
			if ($query) {
				$response = array(
					'status' => 'success',
					'message' => 'Item behasil dihapus'
					);
			}else{
				$response = array(
					'status' => 'failed',
					'message' => 'Maaf ada kesalahan, Item tidak dapat dihapus'
					);	
			}
			echo json_encode($response);
		}

	}

	public function save()
	{
		$this->load->library('uploads');
		$post = $this->input->post();

		$barang = json_decode($post['barang'], true);
		$item = json_decode($post['item'], true);

		$arr_barang = array(
			'idKategori' => $barang['kategori'],
			'namaBarang' => $barang['nama'],
			'spesifikasiBarang' => $barang['spesifikasi']
			);

		if (@$barang['id']) {
			$query = $this->Model_barang->updateBarang($arr_barang, $barang['id']);
			$id = $barang['id'];
		}else{
			$query = $this->Model_barang->insertBarang($arr_barang);
			$id = $this->db->insert_id();
		}

		if(!$query){
			$response = array(
				'status' => 'failed',
				'message' => 'Maaf ada kesalahan, barang tidak dapat disimpan'
				);
			echo json_encode($response);
			exit();
		}

		foreach ($item as $key) {
			$gambar = "";
			if ($key['gambarItem'] != '') {
				if (strstr($key['gambarItem'], 'http://')) {
					$oldImage = explode('/',$key['gambarItem']);
					$oldImage = end($oldImage);
					$gambar = $oldImage;
				}else{
					$gambar = "item_".$key['kodeItem']."_".date('ymdhis').".png";
					$filteredData = substr($key['gambarItem'], strpos($key['gambarItem'], ",")+1);
					$unencodedData = base64_decode($filteredData);
					file_put_contents('assets/uploads/item/'.$gambar, $unencodedData);
				}
			}

			$arr_item = array(
				'idBarang' => $id,
				'idLokasi' => $key['idLokasi'],
				'kodeItem' => $key['kodeItem'],
				'tahunBeli' => $key['tahunBeli'],
				'kondisiItem' => $key['kondisiItem'],
				'gambarItem' => $gambar
				);
			
			if (@$key['idItem']) {
				$this->Model_barang->updateItem($arr_item,$key['idItem']);
			}else{
				$this->Model_barang->insertItem($arr_item);
			}

		}

		$response = array(
			'status' => 'success',
			'message' => 'Data barang berhasil disimpan'
			);

		echo json_encode($response);

	}

}