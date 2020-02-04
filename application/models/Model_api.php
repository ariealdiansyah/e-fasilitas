<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_api extends CI_Model {

	function getItems()
	{
		$where = array(
			'statusItem' => 'aktif',
			'kondisiItem' => 'B'
			);
		$this->db->select('a.*, b.namaBarang')
		->join('barang b','b.idBarang = a.idBarang','INNER')
		->where($where);
		return $this->db->get('item a')->result();
	}	

	function cekItems()
	{
		$this->db->select('a.tanggalPinjam as tgl1, a.batasPinjam as tgl2, b.idItem')
		->join('peminjaman_detail b','b.idPeminjaman = a.idPeminjaman','INNER')
		// ->where($where);
		->where('a.statusPeminjaman IN (1,2)');
		$query = $this->db->get('peminjaman a');
		return $query->result();
	}

}

/* End of file Model_api.php */
/* Location: ./application/models/Model_api.php */