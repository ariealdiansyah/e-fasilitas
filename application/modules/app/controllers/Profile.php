<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller {

	public function index()
	{
		
		$data['content'] = 'profile';
		$this->load->view('backend/main',$data,FALSE);

	}

	public function oldpassword_check($old_password=""){

		$old_password_hash = hash_password($old_password);

		if($old_password_hash != getMember('passwordUser'))
		{
			$this->form_validation->set_message('oldpassword_check', 'Password lama salah');
			return FALSE;
		}else{						
			return TRUE;	
		}
		

	}

	public function save()
	{

		$post = $this->input->post();
		$saved = "Data anda berhasil disimpan";

		$post['emailUser'] != $post['temp_email'] ? $emailUnique = '|is_unique[user.emailUser]' : $emailUnique = '';

		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
		$this->form_validation->set_rules('nameUser', 'Nama User', 'trim|required',array('required'=>'Field ini harus diisi'));
		$this->form_validation->set_rules('emailUser', 'Email', 'trim|required|valid_email'.$emailUnique,array('is_unique'=>'Maaf email sudah terdaftar','required'=>'Field ini harus diisi'));

		if (!empty($post['new_pass'])) {
			$this->form_validation->set_rules('old_pass', 'Password Lama', 'callback_oldpassword_check');
			$this->form_validation->set_rules('new_pass', 'Password Baru', 'trim');
			$this->form_validation->set_rules('new_pass_conf', 'Konfirmasi Password Baru', 'matches[new_pass]', array('matches' => 'Konfirmasi Password baru tidak sama'));
			$password = hash_password($post['new_pass']);
			$this->session->set_flashdata('wrong',TRUE);
		}else{
			$password = getMember('passwordUser');
		}

		if ($this->form_validation->run() == TRUE){

			if ($password == getMember('passwordUser')) {

			}else{
				$this->session->set_flashdata('changePass',TRUE);
			}

			$data = array(
				'nameUser' => $post['nameUser'],				
				'emailUser' => $post['emailUser'],
				'passwordUser' => $password,
				'updateBy' => getMember('id'),
				'updateDate' => date("Y-m-d H:i:s")
				);

			$this->model->update_data('user',$data,array('idUser'=>getMember('id')));
			$this->session->set_flashdata('save_info',$saved);

			redirect('app/profile');

		}else{
			$data['temp_email'] = $post['temp_email'];
			$data['content'] = 'profile';
			$this->load->view('backend/main',$data,FALSE);
		}

	}

	public function save_foto()
	{

		$post = $this->input->post();

		if (!empty($_FILES['fotoUser']['name'])) {
			if ($post['fotoUser']) {
				unlink('assets/backend/images/users/'.$post['fotoUser']);
				unlink('assets/backend/images/users/small/'.$post['fotoUser']);				
			}
			$this->load->library('uploads');
			$file = $this->uploads->upload_image('fotoUser','assets/backend/images/users');

			$this->uploads->resize_image('assets/backend/images/users/'.$file['file_name'],'assets/backend/images/users/small','128','128');

			$post['fotoUser'] = $file['file_name'];
			$this->model->update_data('user',$post,array('idUser'=>getMember('id')));
		}

		redirect('app/profile');

	}

}

/* End of file Profile.php */
/* Location: ./application/modules/app/controllers/Profile.php */