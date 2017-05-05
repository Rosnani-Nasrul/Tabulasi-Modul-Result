<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

	function __construct(){
		parent:: __construct();
		$this->load->model('home/profile_model');
		$this->load->helper('xml');
		$this->load->helper('text');
	}

	public function index($web_id = 0){
		$user = $this->profile_model->getDetailprofile($web_id)->row_array();

		$data["pengguna"] = $user;
		$this->template->display('home/profile/index', $data);
	}
	public function editprofile($web_id = 0){
		if($post = $this->input->post()){

			$getSys = $this->profile_model->getSysUser($web_id)->row_array();

			$dataupdatepeople = array(
				'people_fullname' 		=> isset($post['add_name'])?$post['add_name']:'',
				'people_address'			=> isset($post['add_address'])?$post['add_address']:'',
				'people_phone' 			=> isset($post['add_phone'])?$post['add_phone']:'',
				'people_email' 			=> isset($post['email2'])?$post['email2']:'',
				'people_update_by'		=> $this->session->userdata('user_id'),
				'people_update_date'		=> date('Y-m-d H:i:s')
				);
			$this->profile_model->updatepeople($dataupdatepeople,$getSys['user_people_id']);
			$dataupdate = array(
				'user_name' 				=> isset($post['add_username'])?$post['add_username']:'',
				'user_update_by' 			=> $this->session->userdata('user_id'),
				'user_update_date' 			=> date('Y-m-d H:i:s')
				);


			$insDb = $this->profile_model->update($dataupdate, $web_id);

			if($insDb > 0){
				$notify = array(
					'title' 	=> 'Berhasil!',
					'message' 	=> 'Perubahan pengguna Berhasil',
					'status' 	=> 'success'
					);
				$this->session->set_flashdata('notify', $notify);

				redirect(base_url().'home/profile/index/'.$web_id);
			}else{
				$notify = array(
					'title' 	=> 'Gagal!',
					'message'	=> 'Perubahan pengguna gagal, silahkan coba lagi',
					'status' 	=> 'error'
					);
				$this->session->set_flashdata('notify', $notify);
				redirect(base_url().'home/profile');
			}
		}
		$user = $this->profile_model->getDetailprofile($web_id)->row_array();
		$data["pengguna"] = $user;
		$this->template->display('home/profile/index', $data);
	}

	public function editpassword($web_id = 0){
		if($post = $this->input->post()){

			$dataupdate = array(
				'user_password' 			=> isset($post['password'])?passwordEncoder($post['password']):'',
				'user_update_by' 			=> $this->session->userdata('user_id'),
				'user_update_date' 			=> date('Y-m-d H:i:s')
				);


			$insDb = $this->profile_model->update($dataupdate, $web_id);

			if($insDb > 0){
				$notify = array(
					'title' 	=> 'Berhasil!',
					'message' 	=> 'Perubahan pengguna Berhasil',
					'status' 	=> 'success'
					);
				$this->session->set_flashdata('notify', $notify);

				redirect(base_url().'home/profile/index/'.$web_id);
			}else{
				$notify = array(
					'title' 	=> 'Gagal!',
					'message'	=> 'Perubahan pengguna gagal, silahkan coba lagi',
					'status' 	=> 'error'
					);
				$this->session->set_flashdata('notify', $notify);
				redirect(base_url().'home/profile');
			}
		}
		$user = $this->profile_model->getDetailprofile($web_id)->row_array();
		$data["pengguna"] = $user;
		$this->template->display('home/profile/index', $data);
	}

	function checkOldPass(){
		$password = $this->input->get('oldpass');
		$usrId    = $this->session->userdata('user_id');
		$post     = $this->input->post();
		$cekpass  = $this->profile_model->cekPassLama($usrId,$password)->row_array();
		
		echo $cekpass["totalCount"];
		
	}
}

/* End of file profile.php */
/* Location: ./application/controllers/profile.php */