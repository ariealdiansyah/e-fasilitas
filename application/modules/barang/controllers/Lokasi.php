 <?php
 defined('BASEPATH') OR exit('No direct script access allowed');

 class Lokasi extends MY_Controller
 {

 	public function index()
 	{
 		$data['data'] = $this->model->get('lokasi_item');
 		$data['content'] = 'lokasi_content';
 		$this->load->view('backend/main',$data,FALSE);
 	}

 	public function add($id="")
 	{
 		$get = $this->input->get();
 		$data['idLokasi'] = $id;
 		$data['getLokasi'] = $this->model->get_where('lokasi_item',array('idLokasi'=>$id));
 		$data['content'] = 'lokasi_add';
 		$this->load->view('backend/main',$data,FALSE);
 	}

 	public function save($id="")
 	{

		$post = $this->input->post();

		$data = array(
			'kodeLokasi' => $post['kodeLokasi'],
			'deskripsiLokasi' => $post['deskripsiLokasi'],
			);

		if ($post['idLokasi']) {
			$idLokasi = $post['idLokasi'];
			$this->model->update_data('lokasi_item',$data,array('idLokasi'=>$post['idLokasi']));
		}
		else{
			$this->db->insert('lokasi_item',$data);
			$idLokasi = $this->db->insert_id();
		}
		
		redirect('barang/lokasi');
 	}

 	public function delete($id)
 	{
 		$getLokasi = $this->model->get_where('lokasi_item',array('idLokasi'=>$id));
 		$deleteLokasi = $this->model->delete_data('lokasi_item',array('idLokasi'=>$id));
		// echo deleteDir('application/modules/'.slug($getLokasi[0]['nameModule']));
 		echo $id;
 	}
 }



 ?>