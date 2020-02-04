 <?php
 defined('BASEPATH') OR exit('No direct script access allowed');

 class Kategori extends MY_Controller
 {

 	public function index()
 	{
 		$data['data'] = $this->model->get('kategori');
 		$data['content'] = 'kategori_content';
 		$this->load->view('backend/main',$data,FALSE);
 	}

 	public function add($id="")
 	{
 		$get = $this->input->get();
 		$data['idKategori'] = $id;
 		$data['getKategori'] = $this->model->get_where('kategori',array('idKategori'=>$id));
 		$data['content'] = 'kategori_add';
 		$this->load->view('backend/main',$data,FALSE);
 	}

 	public function save($id="")
 	{

 		$post = $this->input->post();

 		$data = array(
 			'namaKategori' => $post['namaKategori'],
 			);

 		if ($post['idKategori']) {
 			$idKategori = $post['idKategori'];
 			$this->model->update_data('kategori',$data,array('idKategori'=>$post['idKategori']));
 		}
 		else{
 			$this->db->insert('kategori',$data);
 			$idKategori = $this->db->insert_id();
 		}

 		redirect('barang/kategori');
 	}

 	public function delete($id)
 	{
 		$this->model->delete_data('kategori',array('idKategori'=>$id));
 	}

 }
 ?>