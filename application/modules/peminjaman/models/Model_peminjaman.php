<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_peminjaman extends CI_Model {

	private $table = "peminjaman";

	function getAll($where="")
	{
		$this->datatables->select('a.*, b.nameUser')
		->join('user b','b.idUser = a.userPeminjam','LEFT')
		->from('peminjaman a')
		->where($where);
		$results = $this->datatables->generate('raw');
		return $results['aaData'];		
	}

	function getLastId()
	{
		return $this->db->select('MAX(idPeminjaman) as id')
		->get('peminjaman')
		->row()->id;
	}

	function getById($id="")
	{
		$this->db->select('a.*, c.idItem, c.kodeItem, c.kondisiItem, b.jumlah, d.namaBarang, e.nameUser')
		->join('peminjaman_detail b','b.idPeminjaman = a.idPeminjaman','INNER')
		->join('item c','b.idItem = c.idItem','LEFT')
		->join('barang d','c.idBarang = d.idBarang','LEFT')
		->join('user e','e.idUser = a.userPeminjam','LEFT')
		->where('a.idPeminjaman', $id);
		$query = $this->db->get('peminjaman a');
		return $query->result();
	}

	function getPeminjam()
	{
		$this->db->select('a.userPeminjam as id, b.nameUser as name')
		->join('user b','b.idUser = a.userPeminjam','LEFT')
		->group_by('a.userPeminjam');
		$query = $this->db->get('peminjaman a');
		return $query->result();
	}

	function insert($data)
	{
		$data['createBy'] = $this->session->userdata('usernameUser');
		$data['createDate'] = date('Y-m-d H:i:s');
		$this->db->insert($this->table, $data);
		if ($this->db->affected_rows() == 1) {
			return TRUE;
		}else{
			return FALSE;
		}
	}

	function approve($yes="",$myData="")
	{

		if ($yes) {
			$data = array(
				'idApproval' => $this->session->userdata('idUser'),
				'tanggalAppove' => date('Y-m-d'),
				'statusPeminjaman' => '2',
				'catatanPinjam' => $myData['catatan'],
				'updateBy' => $this->session->userdata('usernameUser')
				);
			$this->db->where('idPeminjaman', $myData['id']);
			$query = $this->db->update('peminjaman', $data);
			if ($query) {
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			$data = array(
				'statusPeminjaman' => '3',
				'catatanPinjam' => $myData['catatan'],
				'updateBy' => $this->session->userdata('usernameUser')
				);
			$this->db->where('idPeminjaman', $myData['id']);
			$query = $this->db->update('peminjaman', $data);
			if ($query) {
				return TRUE;
			}else{
				return FALSE;
			}
		}

	}
	

}

/* End of file Model_peminjaman.php */
/* Location: ./application/modules/peminjaman/models/Model_peminjaman.php */