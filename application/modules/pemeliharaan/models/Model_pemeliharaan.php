<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_pemeliharaan extends CI_Model {

	// memanggil table di db e-fasilitas
	private $table_pemeliharaan = "pemeliharaan";
	private $table_pemeliharaan_detail = "pemeliharaan_detail";
	private $table_barang = "barang";
	private $table_item = "item";


	public function get(){
  		return $this->db->get("pemeliharaan");
 	}

	function getPemeliharaan()
	{
		$this->db->select('a.idUserPemeliharaan as id,a.statusPemeliharaan as status, b.nameUser as name')
		->join('user b','b.idUser = a.idUserPemeliharaan','LEFT')
		->group_by('a.idUserPemeliharaan');
		$query = $this->db->get('pemeliharaan a');
		return $query->result();
	}
	
	function getAll($where="")
	{
		$this->datatables->select('a.*, c.namaBarang, d.nameUser, e.kodeItem')
		->join('pemeliharaan_detail b','b.idPemeliharaan = a.idPemeliharaan','INNER')
		->join('barang c','b.idBarang = c.idBarang','LEFT')
		->join('user d','d.idUser = a.idUserPemeliharaan','LEFT')
		->join('item e','b.idItem = e.idItem','LEFT')
		->from('pemeliharaan a')
		->where($where);
		$results = $this->datatables->generate('raw');
		return $results['aaData'];		
	}

	function getLastId()
	{
		return $this->db->select('MAX(idPemeliharaan) as id')
		->get('pemeliharaan')
		->row()->id;
	}

	function getByIdPem($id="")
	{
		$this->db->select('a.*,c.idItem, c.kodeItem, d.namaBarang, e.nameUser')
		->join('pemeliharaan_detail b','b.idPemeliharaan = a.idPemeliharaan','INNER')
		->join('item c','b.idItem = c.idItem','LEFT')
		->join('barang d','c.idBarang = d.idBarang','LEFT')
		->join('user e','e.idUser = a.idUserPemeliharaan','LEFT')
		->where('a.idPemeliharaan', $id);
		$query = $this->db->get('pemeliharaan a');
		return $query->result();
	}
	
	function getBarang()
	{
		return $this->db->get($this->table_barang)->result();
	}

	function getKode()
	{
		return $this->db->get($this->table_item)->result();
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

	function insertPemeliharaanDetail($data)
	{
		$this->db->insert($this->table_pemeliharaan_detail, $data);
		if ($this->db->affected_rows() == 1) {
			return TRUE;
		}else{
			return FALSE;
		}
	}
	function insertPemeliharaan($data)
	{
		$this->db->insert($this->table_pemeliharaan, $data);
		if ($this->db->affected_rows() == 1) {
			return TRUE;
		}else{
			return FALSE;
		}
	}

}