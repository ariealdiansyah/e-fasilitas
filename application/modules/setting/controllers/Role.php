<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

	}

	function _idRole($id=""){
		return $this->session->userdata('roleUser');
	}

	public function index()
	{
		$data['data'] = $this->model->get('master_user_role');
		$data['content'] = 'role_content';
		$this->load->view('backend/main',$data,FALSE);
	}

	public function set($id="")
	{
		$data['getModule'] = $this->model->join('master_module','*',array(array('table'=>'role_module','parameter'=>'master_module.idModule=role_module.idModule')),array('statusModule'=>'Tampil','idRole'=>$id),'orderModule','asc');
		$data['getRole'] = $this->model->get_where('master_user_role',array('idRole'=>$id));
		$data['idRole'] = $id;
		$data['content'] = 'role_setting';
		$this->load->view('backend/main',$data,FALSE);
	}

	public function delete($id)
	{
		$this->model->delete_data('master_user_role',array('idRole'=>$id));
	}

	public function privilege($id="")
	{
		$data['getPrivilege'] = $this->model->join('privilege_user','*',array(
			array('table'=>'master_menu','parameter'=>'privilege_user.menuPrivilege=master_menu.idMenu')
			));
		$data['getParentMenu'] = $this->model->get('master_menu','','','orderMenu','asc');
		
		$data['getRole'] = $this->model->get_where('master_user_role',array('idRole'=>$id));
		$getPrivilege = $this->model->join('privilege_user','*',array(
			array('table'=>'master_user_role','parameter'=>'privilege_user.idRole=master_user_role.idRole')
			));

		foreach ($getPrivilege as $key => $value) {
			$data['actionPrivilege'] = $value['actionPrivilege'];
			$data['menuPrivilege'] = $value['menuPrivilege'];
		}

		$data['content'] = 'role_privilege';

		$this->load->view('backend/main',$data,FALSE);
	}

	public function save_privilege2()
	{
		$post = $this->input->post();
		foreach ($post['actionPrivilege'] as $key => $value) {
			foreach ($value as $sub_key => $sub_value) {
				$data = array(
					'menuPrivilege'=>$key,
					'actionPrivilege'=>$sub_value,
					'created_date'=>date('Y-m-d H:i:s'),
					);
				print_r($data);
			}
		}
	}

	public function save_privilege()
	{
		$post = $this->input->post();
		if (count(@$post['actionPrivilege'])>0) {
			# code...
			$getAllPrivilege = $this->model->get('privilege_user');
			if ($getAllPrivilege) {
				foreach ($getAllPrivilege as $PrivilegeID) {
					$allPrivilegeID[] = $PrivilegeID['idPrivilege'];
				}			}


				foreach ($post['actionPrivilege'] as $key => $value) {
					foreach ($value as $sub_key => $sub_value) {
						$data = array(
							'idRole'=>$post['idRole'],
							'menuPrivilege'=>$key,
							'actionPrivilege'=>$sub_value,
							);

						$getPrivilege = $this->model->get_where('privilege_user',array('menuPrivilege'=>$key,'actionPrivilege'=>$sub_value,'idRole'=>$post['idRole']));

						foreach ($getPrivilege as $row) {
							if ($key==$row['menuPrivilege']&&$sub_value==$row['actionPrivilege']&&$row['idRole']!=$post['idRole']) {
								$data['updateDate'] = date('Y-m-d H:i:s'); 
								$this->model->update_data('privilege_user',$data,array('menuPrivilege'=>$key,'actionPrivilege'=>$sub_value));
							}

							$rows[] = $row['idPrivilege'];
						}
						if ($key!=@$getPrivilege[0]['menuPrivilege']&&$sub_value!=@$getPrivilege[0]['actionPrivilege']&&$post['idRole']!=@$getPrivilege[0]['idRole']) {
							$data['createDate'] = date('Y-m-d H:i:s'); 
							$this->model->insert_data('privilege_user',$data);
						}

					}
				}	

				if ($getAllPrivilege) {

					$filterID = array_diff($allPrivilegeID,$rows);
					foreach ($filterID as $filterValue) {
						$this->model->delete_data('privilege_user',array('idPrivilege'=>$filterValue,'idRole'=>$post['idRole']));
					}
				}
			}
			else{
				for ($i=0; $i < count($post['singleIDActionPrivilege']) ; $i++) { 
					$tmp['singleIDActionPrivilege'] = $post['singleIDActionPrivilege'][$i];
					$tmp['singleMenuActionPrivilege'] = $post['singleMenuActionPrivilege'][$i];
					$this->model->delete_data('privilege_user',array('idPrivilege'=>$tmp['singleIDActionPrivilege']));
				}
			}

			redirect('setting/role/set/'.$post['idRole']);
		}

	}

	/* End of file User.php */
/* Location: ./application/modules/user/controllers/User.php */