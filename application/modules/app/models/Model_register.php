<?php
defined('BASEPATH') OR exit('Script not allowed');

class Model_register extends CI_Model
{
	private $table_register = "user";
	private $table_divisi = "master_data";
	

	function getLokasi()
	{
		return $this->db->get($this->table_divisi)->result();
	}

	function insert($data)
	{
		$data['createDate'] = date('Y-m-d H:i:s');
		$this->db->insert($this->table_register,$data);
		if ($this->db->affected_rows() == 1) {
			return TRUE;
		}else{
			return FALSE;
		}
	}

}
?>