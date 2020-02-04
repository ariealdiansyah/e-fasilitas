<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

	public function test()
	{
		echo base_url();
	}

	public function index()
	{
		$data['data'] = $this->model->get('user');
		$data['content'] = 'user_content';
		$this->load->view('backend/main',$data,FALSE);
	}

	public function add($id="")
	{
		$data['getZona'] = $this->model->get_where('master_data',array('kodeCategory' => 'ZON','statusData' => 'y'));
		$data['content'] = 'user_add';
		$data['getMember'] = $this->model->get_where('user',array('idUser'=>decode($id)));

		$this->load->view('backend/main',$data,FALSE);
	}

	public function save_password($id="")
	{

		$post = $this->input->post();

		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
		$this->form_validation->set_rules('pass_confirmation', 'Password', 'trim');
		$this->form_validation->set_rules('Password', 'Konfirmasi Password', 'matches[pass_confirmation]', array('matches' => 'Konfirmasi Password tidak sama'));

		if ($this->form_validation->run() == TRUE){

			$data = array(
				'passwordUser' => hash_password($post['Password']),
				'updateBy' => getMember('idMember'),
				'updateDate' => date('Y-m-d H:i:s')
				);

			$this->model->update_data('user',$data,array('idUser' => decode($id)));

			if ($this->db->affected_rows() == '1') {
				$this->session->set_flashdata('success_password',TRUE);
			}

			redirect('setting/user/add/'.$id);

		}

	}

	public function save($id="")
	{
		$post = $this->input->post();
		$data['getMember'] = $this->model->get_where('user',array('idUser'=>decode($id)));
		
		// $post['usernameUser'] != $post['temp_user'] ? $userUnique = '|is_unique[user.usernameUser]' : $userUnique = '';
		$post['emailUser'] != $post['temp_email'] ? $emailUnique = '|is_unique[user.emailUser]' : $emailUnique = '';

		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
		$this->form_validation->set_rules('nameUser', 'Nama User', 'trim|required',array('required'=>'Field ini harus diisi'));
		$this->form_validation->set_rules('emailUser', 'Email', 'trim|required|valid_email'.$emailUnique,array('is_unique'=>'Maaf email sudah terdaftar','required'=>'Field ini harus diisi'));
		// $this->form_validation->set_rules('usernameUser', 'Username', 'trim|required'.$userUnique,array('is_unique'=>'Maaf username sudah terpakai','required'=>'Field ini harus diisi'));

		if (!@$post['idUser']) {

			$this->form_validation->set_rules('pass_confirmation', 'Password', 'trim');
			$this->form_validation->set_rules('Password', 'Konfirmasi Password', 'matches[pass_confirmation]', array('matches' => 'Konfirmasi Password tidak sama'));

		}

		$this->form_validation->set_rules('roleUser', 'Role User', 'trim|required',array('required'=>'Field ini harus diisi'));

		if ($this->form_validation->run() == FALSE)
		{

			$data['content'] = 'user_add';
			$data['idUser'] = $post['idUser'];
			// $data['temp_user'] = $post['temp_user'];
			$data['temp_email'] = $post['temp_email'];			
			$this->load->view('backend/main',$data,FALSE);
		}
		else{

			$data = array(
				// 'usernameUser' => $post['usernameUser'],
				'emailUser' => $post['emailUser'],
				'nameUser' => $post['nameUser'],
				'roleUser' => $post['roleUser'],
				'statusUser' => $post['statusUser']
				);

			if ($post['idUser']) {
				$data['updateDate'] = date('Y-m-d H:i:s');
				$data['updateBy'] = getMember('id');
				$this->model->update_data('user',$data,array('idUser'=>decode($post['idUser'])));
			}
			else{
				$data['passwordUser'] = hash_password($post['Password']);
				$data['createDate'] = date('Y-m-d H:i:s');
				$data['createBy'] = getMember('id');
				$this->model->insert_data('user',$data);
			}
			redirect('setting/user');
		}
	}

	public function delete($id="")
	{
		$this->model->delete_data('user',array('idUser'=>decode($id)));
	}
}

/* End of file User.php */
/* Location: ./application/modules/pengaturan/controllers/User.php */