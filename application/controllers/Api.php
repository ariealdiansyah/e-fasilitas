<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Model_api');
	}

	public function index()
	{
		
	}

	public function getBarang()
	{
		$data = $this->db->get('barang')->result();
		$response = array(
			'data' => $data,
			'status' => 'success'
			);
		echo json_encode($response);
	}

	public function getItem()
	{

		$post = $this->input->post();

		$tgl1 = date('Y-m-d', strtotime($post['tgl1']));
		$tgl2 = date('Y-m-d', strtotime($post['tgl2']));

		$getItems = $this->Model_api->getItems();
		$cekItems = $this->Model_api->cekItems($tgl1, $tgl2);

		$items = [];
		foreach ($cekItems as $key) {
			if (($tgl1 >= $key->tgl1) && ($tgl1 <= $key->tgl2)) {
				$items[] = $key->idItem;
			}
		}

		$data = [];
		foreach ($getItems as $key) {
			if (!in_array($key->idItem, $items)) {
				array_push($data, $key);
			}
		}

		$response = array(
			'data' => $data,
			'status' => 'success'
			);
		echo json_encode($response);
	}

	public function getKode()
	{
		$data = $this->db->get('item')->result();
		$response = array(
			'data' => $data,
			'status' => 'success'
			);
		echo json_encode($response);
	}

	/*public function getKode()
	{

		$getItems = $this->Model_api->getItems();
		$cekItems = $this->Model_api->cekItems($tgl1, $tgl2);

		$items = [];
		foreach ($cekItems as $key) {
				$items[] = $key->idItem;
		}

		$data = [];
		foreach ($getItems as $key) {
			if (!in_array($key->idItem, $items)) {
				array_push($data, $key);
			}
		}

		$response = array(
			'data' => $data,
			'status' => 'success'
			);
		echo json_encode($response);
	}*/

	public function getPeminjamanByUser($id="")
	{
		$where = array(
			'userPeminjam' => $id,
			'statusPeminjaman' => 2
			);

		$query = $this->db->where($where)->get('peminjaman')->result_array();

		if ($query) {
			echo json_encode($query);
		}

	}

	public function getPerbaikanByUser($id="")
	{
		/*$where = array(
			'idUserPerbaikan' => $id,
			'statusPerbaikan' => 'terjadwal'
			) ;*/
			/*$where = "idUserPerbaikan=".$id." AND statusPerbaikan='terjadwal' OR statusPerbaikan='proses'";*/

		

			/*$query = $this->model->get_where('perbaikan',array('idUserPerbaikan'=>$id,'statusPerbaikan'=>'terjadwal'))->result_array();*/

		$this->db->where('idUserPerbaikan', $id);
		$this->db->where("(statusPerbaikan='terjadwal' OR statusPerbaikan='proses')", NULL, FALSE);
		$query = $this->db->get('perbaikan')->result_array();
		/*$query = $this->db->where($where)->get('perbaikan')->result_array();*/

		if ($query) {
			echo json_encode($query);
		}
	}

	public function getPemeliharaanByUser($id="")
	{
		$where = array(
			'idUserPemeliharaan' => $id,
			'statusPemeliharaan' => 'proses'
			);

		$query = $this->db->where($where)->get('pemeliharaan')->result_array();

		if ($query) {
			echo json_encode($query);
		}
	}

	public function getPerbaikanByBarang($id="")
	{
		$where = array(
			'idBarang' => $id,
			'statusItem' => 'aktif'
			);

		$query = $this->db->where($where)->get('item')->result_array();

		if ($query) {
			echo json_encode($query);
		}
	}

	public function getPeminjamanById()
	{
		$this->load->model('peminjaman/Model_peminjaman');
		$post = $this->input->post();
		$data = $this->Model_peminjaman->getById($post['idPeminjaman']);
		$response = array(
			'data' => $data,
			'status' => 'success'
			);
		echo json_encode($response);
	}
	public function getPerbaikanById()
	{
		$this->load->model('perbaikan/Model_perbaikan');
		$post = $this->input->post();
		$data = $this->Model_perbaikan->getById($post['idPerbaikan']);
		$response = array(
			'data' => $data,
			'status' => 'success'
			);
		echo json_encode($response);
	}
	public function getPemeliharaanById()
	{
		$this->load->model('pemeliharaan/Model_pemeliharaan');
		$post = $this->input->post();
		$data = $this->Model_pemeliharaan->getByIdPem($post['idPemeliharaan']);
		$response = array(
			'data' => $data,
			'status' => 'success'
			);
		echo json_encode($response);
	}

	public function getNotif()
	{
		$pending = $this->db->get_where('peminjaman',array('statusPeminjaman' => 1));
		$html = '';
		if ($pending->num_rows() > 0) {
			$html .= '
			<a href="'.base_url('peminjaman/approval').'" class="list-group-item">
				<div class="media">
					<div class="media-left">
						<em class="fa fa-bell-o fa-2x text-danger"></em>
					</div>
					<div class="media-body clearfix">
						<div class="media-heading">Ada permintaan peminjaman baru</div>
						<p class="m-0">
							<small>Ada '.$pending->num_rows().' permintaan yang belum disetujui</small>
						</p>
					</div>
				</div>
			</a>
			';
			$data['msg'] = $html;
			$data['count'] = '<span class="badge badge-xs badge-danger">1</span>';
		}else{
			$html .='
			<a href="javascript:void(0)" class="list-group-item">
				<div class="media">
					<div class="media-body clearfix">
						<div class="media-heading">Ada tidak memiliki pemberitahuan</div>
					</div>
				</div>
			</a>
			';
			$data['msg'] = $html;
			$data['count'] = '';
		}
		echo json_encode($data);
	}

}

/* End of file Api.php */
/* Location: ./application/controllers/Api.php */