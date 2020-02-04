<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends MY_Controller {

	public function index($params=""){

		if(empty($params)){
			$data['orderCategory'] = $this->model->getOrder('master_category','orderCategory');

			$data['category'] = $this->model->get('master_category','','','orderCategory','asc');		

			$data['content'] = 'master_index';
			$this->load->view('backend/main',$data,FALSE);
		}elseif (!empty($params)) {

			$data['orderData'] = $this->model->getOrder('master_data','orderData',array('kodeCategory'=>$params));
			$data['kodeInduk'] = getField('master_category','kodeInduk',array('kodeCategory' => $params));			

			// $data['getData'] = $this->model->get_where('master_data',array('kodeCategory' => $params));

			$data['content'] = 'master_content';
			$this->load->view('backend/main',$data,FALSE);

		}


	}

	public function loadModal($params="",$id=""){

		$post = $this->input->post();

		$getData = $this->model->get_where('master_data',array('idData' => decode($post['idData'])));
		$data['data'] = $getData[0];

		if ($params == "masterEdit") {

			$data['orderData'] = $this->model->getOrder('master_data','orderData',array('kodeCategory'=>$id));
			$data['kodeInduk'] = getField('master_category','kodeInduk',array('kodeCategory' => $id));			

			$this->load->view('modal/master_edit',$data,FALSE);

		}elseif ($params == "masterDelete") {
			
			$this->load->view('modal/master_delete',$data,FALSE);

		}

	}

	public function loadData($params="")
	{

		$where = array(
			'kodeCategory' => $params
			);

		$column = array('namaData','keteranganData','orderData','statusData');

		$list = $this->model->get_datatables('master_data',$where,$column);
		$data = array();
		$no = 0;
		foreach ($list as $r) {

			$status = '';

			switch($r->statusData){
				case "y":
				$status = "<img src='".base_url('assets/backend/images/icons/y.png')."' class='tip-right' title='Active'>";
				break;
				case "n":
				$status = "<img src='".base_url('assets/backend/images/icons/n.png')."' class='tip-right' title='Not Active'>";
				break;
			}

			$action = "
			<button class='btn btn-icon waves-effect wanves-light btn-inverse edit-data btn-xs m-b-5' data-id='".encode($r->idData)."'><i class='fa fa-pencil'></i></button>
			<button class='btn btn-icon waves-effect waves-light btn-danger del-dialog btn-xs m-b-5' data-route='".base_url(getModule().'/'.getController().'/delete/data/'.encode($r->idData))."'><i class='fa fa-trash'></i></button>
			";

			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $r->namaData;
			$row[] = $r->keteranganData;
			$row[] = $r->orderData;
			$row[] = $status;
			$row[] = $action;

			$data[] = $row;
		}

		$output = array(
		// "draw" => $_POST['draw'],
			"recordsTotal" => $this->model->count_all('master_data',$where,$column),
			"recordsFiltered" => $this->model->count_filtered('master_data',$where,$column),
			"data" => $data,
			);
		echo json_encode($output);
	}


	// public function form($params="",$id=""){

	// 	$getData = $this->model->get_where('master_data',array('id'=>$id));
	// 	$data['orderData'] = $this->model->getOrder('master_data','orderData',array('kodeCategory'=>$params));
	// 	$data['kodeInduk'] = getField('master_category','kodeInduk',array('kodeCategory' => $params));			

	// 	if ($getData) {
	// 		$data['getData'] = $getData[0];
	// 	}
	// 	else{
	// 		$data['getData'] = "";
	// 	}

	// 	$this->load->view('modal/master_edit',$data,FALSE);

	// }

	public function save($params="",$id=""){

		$post = $this->input->post();

		if ($params == "category" AND empty($id)) {

	// $data1 = array(
	// 	'idMenu' => $this->model->getOrder('master_menu','idMenu'),
	// 	'idModule' => getMenu('idModule','index'),
	// 	'kodeInduk' => getMenu('idMenu','index'),
	// 	'namaMenu' => $post['namaCategory'],
	// 	'iconCategory' => $post['iconCategory'],
	// 	'targetMenu' => getMenu('targetMenu','index')."/".$post['kodeCategory'],
	// 	'orderMenu' => $post['orderCategory'],
	// 	'statusMenu' => $post['statusCategory'],
	// 	'createBy' => getMember('id'),
	// 	'createDate' => date('Y-m-d H:i:s')
	// 	);

			$data2 = array(
				'kodeCategory' => $post['kodeCategory'],
	// 'idModule' => getMenu('idModule','index'),
	// 'idMenu' => $this->model->getOrder('master_menu','idMenu'),
				'namaCategory' => $post['namaCategory'],
				'kodeInduk' => $post['kodeInduk'],
				'ketCategory' => $post['ketCategory'],
				'iconCategory' => $post['iconCategory'],
				'orderCategory' => $post['orderCategory'],
				'statusCategory' => $post['statusCategory'],
				'createBy' => getMember('id'),
				'createDate' => date('Y-m-d H:i:s')
				);

	// $this->model->insert_data('master_menu',$data1);
			$this->model->insert_data('master_category',$data2);

			redirect(getModule().'/'.getController().'/index?mode=list');

		}elseif ($params == "category" AND !empty($id)) {

// $data1 = array(
// 	'namaMenu' => $post['namaCategory'],
// 	'iconCategory' => $post['iconCategory'],
// 	// 'targetMenu' => getMenu('targetMenu','index')."/".$post['kodeCategory'],
// 	'orderMenu' => $post['orderCategory'],
// 	'statusMenu' => 'n',
// 	'updateBy' => getMember('id'),
// 	'updateDate' => date('Y-m-d H:i:s')
// 	);

			$data2 = array(
// 'kodeCategory' => $post['kodeCategory'],
				'namaCategory' => $post['namaCategory'],
				'kodeInduk' => $post['kodeInduk'],
				'ketCategory' => $post['ketCategory'],
				'iconCategory' => $post['iconCategory'],
				'orderCategory' => $post['orderCategory'],
				'statusCategory' => $post['statusCategory'],
				'updateBy' => getMember('id'),
				'updateDate' => date('Y-m-d H:i:s')
				);

// $data3 = array(
// 	'kodeCategory' => $post['kodeCategory'],
// 	);

// $this->model->update_data('master_menu',$data1,array('idMenu' => $id));
			// $this->model->update_data('master_data',$data3,array('kodeCategory' => getCategory('kodeCategory',$id)));
			$this->model->update_data('master_category',$data2,array('idCategory' => $id));			

			redirect(getModule().'/'.getController().'/index?mode=list');

		}elseif ($params == "data") {
			empty($post['kodeInduk']) ? $kodeInduk = '0' : $kodeInduk = $post['kodeInduk'];

			$data = array(				
				'kodeInduk' => $kodeInduk,				
				'namaData' => $post['namaData'],
				'kodeData' => $post['kodeData'],				
				'keteranganData' => $post['keteranganData'],
				'orderData' => $post['orderData'],
				'statusData' => $post['statusData'],
				'updateBy' => getMember('id'),
				'updateDate' => date('Y-m-d H:i:s')
				);

			$this->model->update_data('master_data',$data,array('idData' => decode($post['idData'])));
			redirect(getModule().'/'.getController().'/index/'.$id);

		}


	}

	public function add($params="",$id=""){

		$post = $this->input->post();

		if ($params == "data") {

			empty($post['kodeInduk']) ? $kodeInduk = '0' : $kodeInduk = $post['kodeInduk'];

			$data = array(
				'idData' => $this->model->getOrder('master_data','idData'),
				'kodeInduk' => $kodeInduk,
				'kodeCategory' => $id,
				'namaData' => $post['namaData'],
				'kodeData' => $post['kodeData'],				
				'keteranganData' => $post['keteranganData'],
				'orderData' => $post['orderData'],
				'statusData' => $post['statusData'],
				'createBy' => getMember('id'),
				'createDate' => date('Y-m-d H:i:s')
				);

			$this->model->insert_data('master_data',$data);
			redirect(getModule().'/'.getController().'/index/'.$id);

		}


	}

	public function delete($params="",$id=""){

		$post = $this->input->post();

		if ($params == "category") {
			$this->model->delete_data('master_category',array('idCategory' => decode($id)));
			// redirect(getModule().'/'.getController().'/index?mode=list');
		}elseif ($params == "data") {
			$this->model->delete_data('master_data',array('idData' => decode($id)));
			// redirect(getModule().'/'.getController().'/index/'.$id);
		}

	}

	public function getOrder($params="",$id=""){

		if($params == 'category'){

			$id = end($this->uri->segments);
			$query = $this->model->getOrder('master_data','orderData',array('kodeInduk' => $id));
			echo $query;
		}

	}

	public function kelas(){
		$data['content'] = 'master_content';

		$this->load->view('backend/main',$data,FALSE);

	}


}

/* End of file Data.php */
/* Location: ./application/modules/membership/controllers/Master.php */