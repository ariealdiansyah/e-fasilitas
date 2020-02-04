<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model extends MY_Model { 

	function __construct()
	{
		parent::__construct();
	}

	function getWhereOtherTable($table="",$params="",$sort="",$order=""){
		$query = $this->db->order_by($sort,$order)->where($params)->get($table);
		return $query->result_array();
	}

	function getOtherTable($table=""){
		$query = $this->db->get($table);
		return $query->result_array();
	}

	function insertOtherTable($table="",$data="") {
		$this->db->insert($table,$data);
	}

	function updateOtherTable($table="",$data="",$params=""){
		$this->db->update($table, $data,$params);
	}

	function deleteOtherTable($table="",$params=""){
		$this->db->delete($table,$params);
	}
	
}

/* End of file Pasien.php */
/* Location: ./application/models/Pasien.php */