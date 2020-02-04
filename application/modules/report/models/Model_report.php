<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_report extends CI_Model {

	function getById($id="")
	{
		$this->db->select('a.*, b.jumlah, d.idBarang, d.namaBarang, e.nameUser')
		->join('peminjaman_detail b','b.idPeminjaman = a.idPeminjaman','INNER')
		->join('item c','b.idItem = c.idItem','LEFT')
		->join('barang d','c.idBarang = d.idBarang','LEFT')
		->join('user e','e.idUser = a.userPeminjam','LEFT')
		->where('a.idPeminjaman', $id)
		->group_by('d.idBarang');
		$query = $this->db->get('peminjaman a');
		return $query->result();
	}

	function getItemPinjam($where){
		$this->db->select('a.*, b.idItem, b.kodeItem, b.kondisiItem,')
		->join('item b','b.idItem = a.idItem','LEFT')
		->where($where);
		$query = $this->db->get('peminjaman_detail a');
		return $query->result();
	}

}

/* End of file Model_report.php */
/* Location: ./application/modules/report/models/Model_report.php */