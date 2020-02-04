<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_perbaikan extends CI_Model {

	private $table_perbaikan = "perbaikan";
	private $table_perbaikan_detail = "perbaikan_detail";
	private $table_barang = "barang";
	private $table_item = "item";

	function getAll($where="")
	{
		$this->datatables->select('a.*, c.namaBarang, d.nameUser, e.kodeItem')
		->join('perbaikan_detail b','b.idPerbaikan = a.idPerbaikan','INNER')
		->join('barang c','b.idBarang = c.idBarang','LEFT')
		->join('user d','d.idUser = a.idUserPerbaikan','LEFT')
		->join('item e','b.idItem = e.idItem','LEFT')
		->from('perbaikan a')
		->where($where);
		$results = $this->datatables->generate('raw');
		return $results['aaData'];		
	}


	function getById($id="")
	{
		$this->db->select('a.*,c.idItem, c.kodeItem, d.namaBarang, e.nameUser')
		->join('perbaikan_detail b','b.idPerbaikan = a.idPerbaikan','INNER')
		->join('item c','b.idItem = c.idItem','LEFT')
		->join('barang d','c.idBarang = d.idBarang','LEFT')
		->join('user e','e.idUser = a.idUserPerbaikan','LEFT')
		->where('a.idPerbaikan', $id);
		$query = $this->db->get('perbaikan a');
		return $query->result();
	}

	function getByIdAp($id="")
	{
		$this->db->select('a.*')
		->where('a.idPerbaikan', $id);
		$query = $this->db->get('perbaikan a');
		return $query->result();
	}

	function getLastId()
	{
		return $this->db->select('MAX(idPerbaikan) as id')
		->get('perbaikan')
		->row()->id;
	}

	function getPerbaikan()
	{
		$this->db->select('a.idUserPerbaikan as id,a.statusPerbaikan as status, b.nameUser as name')
		->join('user b','b.idUser = a.idUserPerbaikan','LEFT')
		->group_by('a.idUserPerbaikan');
		$query = $this->db->get('perbaikan a');
		return $query->result();
	}

	/*ini fungsi lama function getAll($where="")
	{
		$this->datatables->select('a.*, b.nameUser')
		->join('user b','b.idUser = a.idUserPerbaikan','LEFT')
		->from('perbaikan a')
		->where($where);
		$results = $this->datatables->generate('raw');
		return $results['aaData'];		
	}*/

 	/*masih belum tau kelanjutannya 
 	function getLastId()
	{
		return $this->db->select('MAX(idPerbaikanDetail) as id')
		->get('perbaikan_detail')
		->row()->id;
	}*/


	function getBarang()
	{
		return $this->db->get($this->table_barang)->result();
	}

	function getKode()
	{
		return $this->db->get($this->table_item)->result();
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

	function insertPerbaikanDetail($data)
	{
		$this->db->insert($this->table_perbaikan_detail, $data);
		if ($this->db->affected_rows() == 1) {
			return TRUE;
		}else{
			return FALSE;
		}
	}
	function insertPerbaikan($data)
	{
		$this->db->insert($this->table_perbaikan, $data);
		if ($this->db->affected_rows() == 1) {
			return TRUE;
		}else{
			return FALSE;
		}
	}
}

/* End of file Model_perbaikan.php */
/* Location: ./application/modules/perbaikan/models/Model_perbaikan.php */