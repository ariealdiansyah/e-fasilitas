<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengembalian extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Model_peminjaman');
	}

	public function index()
	{
		$data['peminjam'] = $this->Model_peminjaman->getPeminjam();
		$data['content'] = 'pengembalian_add';
		$this->load->view('backend/main',$data,FALSE);
	}

	public function save()
	{
		$post = $this->input->post();

		$arr_peminjaman = array(
			'tanggalKembali' => date('Y-m-d', strtotime($post['tanggalPengembalian'])),
			'idUserPenerima' => $this->session->userdata('idUser'),
			'statusPeminjaman' => 4,
			'catatanKembali' => $post['catatanPengembalian'],
			'updateBy' => $this->session->userdata('usernameUser')
			);

		$query = $this->db->update('peminjaman', $arr_peminjaman, array('idPeminjaman' => $post['idPeminjaman']));

		if ($query) {
			$response = array(
				'id' => encode($post['idPeminjaman']),
				'message' => 'Peminjaman sudah berhasil dikembalikan',
				'status' => 'success'
				);
		}else{
			$response = array(
				'message' => 'Maaf, pengembalian tidak dapat disimpan',
				'status' => 'failed'
				);			
		}

		foreach ($post['idItem'] as $key) {
			if (@$post['kondisiItem'][$key]) {
				$arr_item = array(
					'kondisiItem' => $post['kondisiItem'][$key],
					'updateBy' => $this->session->userdata('usernameUser')
					);
				$this->db->update('item', $arr_item, array('idItem' => $key));
				$arr_pengembalian = array(
					'idPeminjaman' => $post['idPeminjaman'],
					'idItem' => $key,
					'kondisiItem' => $post['kondisiItem'][$key]
					);				
				$this->db->insert('pengembalian_pinjaman', $arr_pengembalian);
			}
		}

		echo json_encode($response);

	}

}

/* End of file Pengembalian.php */
/* Location: ./application/modules/peminjaman/controllers/Pengembalian.php */