<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends MY_Controller {

public function test(){
$query = $this->model->get_where('master_menu',array('kodeInduk'=>0,'idModule'=>1,'statusMenu'=>'y'),'orderMenu','asc');
print_r($query);
}

	public function index($id="")
	{
		$getID = $this->input->get('key');
		if ($getID) {
			$data['data'] = $this->model->get_where('master_menu',array('kodeInduk'=>0,'idModule'=>$getID));
		}else{
			$data['data'] = $this->model->get_where('master_menu',array('kodeInduk'=>0),'orderMenu','asc');
		}

		$data['getModule'] = $this->model->get_where('master_module',array('statusModule'=>'Tampil'),'orderModule','asc');
		$data['getMenu'] = $this->model->get_where('master_menu',array('idMenu'=>$id));
		$data['getParentMenu'] = $this->model->get_where('master_menu',array('kodeInduk'=>0),'orderMenu','asc');
		$data['content'] = 'menu_content';
		$this->load->view('backend/main',$data,FALSE);
	}

	public function add($id="")
	{

		if (empty($id)) {
			$idModule = $this->input->get('key');
		}else{
			$idModule = getField('master_menu','idModule',array('idMenu' => $id));			
		}

		$data['getMenu'] = $this->model->get_where('master_menu',array('idMenu'=>$id));
		$data['getParentMenu'] = $this->model->get_where('master_menu',array('kodeInduk'=>0,'idModule'=>$idModule),'orderMenu','asc');
		$data['getAttributeMenu'] = $this->model->get_where('pengaturan_attribute',array('idMenu'=>$id));
		$data['getMenuPrivilege'] = $this->model->join('master_menu_privilege','*',array(array('table'=>'pengaturan_attribute_detail','parameter'=>'master_menu_privilege.actionMenuPrivilege=pengaturan_attribute_detail.idPAttributeDetail')),array('idMenu'=>$id));
		$data['menuPrivilege'] = $this->model->join('pengaturan_attribute_detail','*',array(array('table'=>'pengaturan_attribute','parameter'=>'pengaturan_attribute.idPAttribute=pengaturan_attribute_detail.idPAttribute')),array('pengaturan_attribute_detail.idPAttribute'=>1),'','','','');

		$data['orderMenu'] = $this->model->getOrder('master_menu','orderMenu',array('idModule' => $this->input->get('key')));
		$data['content'] = 'menu_add';
		$this->load->view('backend/main',$data,FALSE);
	}

	public function attribute($id="")
	{
		$data['getMenu'] =  $this->model->get_where('master_menu',array('targetMenu'=>getModule()."/".getController()));
		$data['idMenu'] = $id;
		$data['content'] = 'menu_add_attribute';
		$data['getMenuPrivilege'] = $this->model->join('master_menu_privilege','*',array(array('table'=>'pengaturan_attribute_detail','parameter'=>'master_menu_privilege.actionMenuPrivilege=pengaturan_attribute_detail.idPAttributeDetail')),array('idMenuPrivilege'=>$id));
		$getAll = $this->model->get('pengaturan_attribute_detail');
		foreach ($getAll as $allPrivilege) {
			$data['getMenuPrivilegeID'][] = $allPrivilege['idPAttributeDetail'];
		}

		$this->load->view('backend/main',$data,FALSE);
	}

	public function save()
	{

		$post = $this->input->post();
		$nameModule = getField('master_module','nameModule',array('idModule' => $post['idModule']));

		unset($post['current_url']);
		$tmp['actionMenuPrivilege'] = $post['actionMenuPrivilege'];

		// $post['targetMenu'] = strtolower($post['nameModule']).'/'.str_replace(" ","_",strtolower($post['namaMenu']));
		$idMenu = 0;
		if ($post['idMenu']) {
			$post['updateBy'] = getMember('id');
			$post['updateDate'] = date('Y-m-d H:i:s'); 
			unset($post['actionMenuPrivilege']);
			$idMenu += $post['idMenu'];
			$this->model->update_data('master_menu',$post,array('idMenu'=>$post['idMenu']));
		}
		else{
			unset($post['actionMenuPrivilege']);
			$post['createBy'] = getMember('id');
			$post['createDate'] = date('Y-m-d H:i:s'); 
			$idMenu += $this->model->insert_data('master_menu',$post);
		}


		$getAllPrivilege = $this->model->get_where('master_menu_privilege',array('idMenu'=>$idMenu));
		foreach ($getAllPrivilege as $PrivilegeID) {
			$allPrivilegeID[] = $PrivilegeID['idMenuPrivilege'];
		}

		foreach ($tmp['actionMenuPrivilege'] as $key => $value) {
		
			$data = array(
				'idMenu'=>$idMenu,
				'actionMenuPrivilege'=>$value,
				);
		
			
			$getPrivilege = $this->model->get_where('master_menu_privilege',array('idMenu'=>$idMenu,'actionMenuPrivilege'=>$value));

			foreach ($getPrivilege as $row) {
				if ($post['idMenu']==$row['idMenu']&&$value==$row['actionMenuPrivilege']) {
					$data['updateDate'] = 'Y-m-d H:i:s';
					$this->model->update_data('master_menu_privilege',$data,array('idMenu'=>$post['idMenu'],'actionMenuPrivilege'=>$value));
				}

				$rows[] = $row['idMenuPrivilege'];
			}
			if ($idMenu!=@$getPrivilege[0]['idMenu']&&$value!=@$getPrivilege[0]['actionMenuPrivilege']) {
				$data['createDate'] = date('Y-m-d H:i:s');
				$insert_data = $this->model->insert_data('master_menu_privilege',$data);
			}

		}	
		if ($getAllPrivilege) {

			$filterID = array_diff($allPrivilegeID,$rows);
			foreach ($filterID as $filterValue) {
				$this->model->delete_data('master_menu_privilege',array('idMenuPrivilege'=>$filterValue));
			}
		}
		redirect('setting/menu?module='.$nameModule.'&key='.$post['idModule']);
	}

	public function delete($id)
	{
		$getMenu = $this->model->get_where('master_menu',array('kodeInduk'=>$id));
		print_r($getMenu);
		$this->model->delete_data('master_menu',array('idMenu'=>$id)); //hapus menu
		$this->model->delete_data('master_menu',array('kodeInduk'=>$id)); //hapus sub menu
		$this->model->delete_data('master_menu_privilege',array('idMenu'=>$id)); //hapus akses menu
		$this->model->delete_data('privilege_user',array('menuPrivilege'=>$id)); //hapus hak akses user terhadap menu

		$getAttribute = $this->model->get_where('pengaturan_attribute',array('idMenu'=>$id)); //tampilkan atribut menu berdasarkan id
		$this->model->delete_data('pengaturan_attribute',array('idMenu'=>$id)); //hapus atribut menu
		$this->model->delete_data('pengaturan_attribute_detail',array('idPAttribute'=>$getAttribute[0]['idMenu']));
		redirect('setting/menu');
	}

	public function session($id)
	{
		echo $id;
	}


}

/* End of file Menu.php */
/* Location: ./application/modules/user/controllers/Menu.php */