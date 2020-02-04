<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_barang extends CI_Model {

	private $table_lokasi = "lokasi_item";
	private $table_kategori = "kategori";
	private $table_item = "item";
	private $table_barang = "barang";

	function getBarang($where="")
	{
		$this->datatables->select('a.*, b.namaKategori as kategori')
		->join('kategori b','b.idKategori = a.idKategori','LEFT')
		->from('barang a')
		->where($where);
		$results = $this->datatables->generate('raw');
		return $results['aaData'];
	}

	function getById($id)
	{
		$this->db->where('idBarang',$id);
		$query = $this->db->get($this->table_barang);
		return $query->row();
	}

	function getItem($id="")
	{
		if ($id) {
			$this->db->where('idBarang',$id);
		}
		$this->db->where('statusItem','aktif');
		$query = $this->db->get($this->table_item);
		return $query->result();
	}

	function getLokasi()
	{
		return $this->db->get($this->table_lokasi)->result();
	}

	function getKategori()
	{
		return $this->db->get($this->table_kategori)->result();
	}

	function insertBarang($data)
	{
		$data['createBy'] = $this->session->userdata('usernameUser');
		$data['createDate'] = date('Y-m-d H:i:s');
		$this->db->insert($this->table_barang, $data);
		if ($this->db->affected_rows() == 1) {
			return TRUE;
		}else{
			return FALSE;
		}
	}

	function updateBarang($data, $id)
	{
		$data['updateBy'] = $this->session->userdata('usernameUser');
		$this->db->where('idBarang', $id);
		$query = $this->db->update($this->table_barang, $data);
		if ($query) {
			return TRUE;
		}else{
			return FALSE;
		}
	}

	function insertItem($data)
	{
		$data['createBy'] = $this->session->userdata('usernameUser');
		$data['createDate'] = date('Y-m-d H:i:s');
		$query = $this->db->insert($this->table_item, $data);
		return $query;
	}

	function updateItem($data, $id)
	{
		$data['updateBy'] = $this->session->userdata('usernameUser');
		$this->db->where('idItem', $id);
		$query = $this->db->update($this->table_item, $data);
		if ($query) {
			return TRUE;
		}else{
			return FALSE;
		}
	}

}

/* End of file Model_barang.php */
/* Location: ./application/modules/barang/models/Model_barang.php */