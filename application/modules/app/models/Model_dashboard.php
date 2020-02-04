<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_dashboard extends CI_Model {

	function getLastPeminjaman()
	{
		$this->db->limit('5');
		return $this->db->get('peminjaman')->result();
	}	

	function getTopBarang()
	{
		$this->db->select('c.namaBarang, COUNT(a.idItem) as count')
		->join('peminjaman d','d.idPeminjaman = a.idPeminjaman','INNER')
		->join('item b','b.idItem = a.idItem','INNER')
		->join('barang c','c.idBarang = b.idBarang','INNER')
		->where('d.statusPeminjaman != 3')
		->group_by('b.idBarang')
		->limit('5');
		return $this->db->get('peminjaman_detail a')->result();
	}

	function getTopPeminjam()
	{
		$this->db->select('b.nameUser as peminjam, COUNT(a.idPeminjaman) as count')
		->join('user b','b.idUser = a.userPeminjam','INNER')
		->where('a.statusPeminjaman != 3')
		->group_by('a.userPeminjam')
		->limit('5');
		return $this->db->get('peminjaman a')->result();
	}

	function getPeminjamanByStatus($status="")
	{
		$this->db->where('statusPeminjaman', $status);
		return $this->db->from('peminjaman');
	}

}

/* End of file Model_dashboard.php */
/* Location: ./application/modules/app/models/Model_dashboard.php */