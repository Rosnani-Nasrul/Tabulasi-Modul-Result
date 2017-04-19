<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('home/auth_model','',TRUE);
	}

	public function login($force=0)
	{

		if($force==0) {
			$data = array();
			$data["message"] = $this->session->flashdata('message');
			if($this->session->userdata('user_fullname')) {
				redirect(base_url().'home/auth/lock');
			} else {
				$this->template->single('login', $data);
			}
		} else {
			$this->session->sess_destroy();
			$this->access->redirect('login');
		}
	}

	public function logout()
	{
		$data = array();
		$this->session->sess_destroy();
		$this->access->redirect('login');
	}

	public function lock()
	{
		if($this->session->userdata('user_fullname')) {
			$data = array();
			$this->session->set_userdata(array('logged_in'=>false));
			$this->template->single('lockscreen', $data);
		} else {
			redirect(base_url().'home/auth/login');
		}
	}

	public function checklogin() {
		$feedback = array('status'=>'','message'=>'','redirect_url'=>'');
		$data = array();
		$data["status"] = "";
		$data["message"] = "";
		if($post = $this->input->post()) {
			$username = $post['username'];
			$password = $post['password'];
			$cekuser = $this->auth_model->checkUsername($username)->row_array();
			if(count($cekuser)>0){
				if($cekuser['user_status']==1) {
					$authenticated = false;
					if($this->config->config['LDAP_use']) {
						if($this->LDAPChecking()) {
							$authenticated = $this->LDAPAuth($username, $password);
						} else {
							$feedback['status'] = 0;
							$feedback['message'] = 'Masalah Koneksi ke Server LDAP';
							$feedback['redirect_url'] = '';
							echo json_encode($feedback); die();
						}
					} else {
						$authenticated = ($this->auth_model->getAuth($username, passwordEncoder($password))>0)?true:false;
					}

					if($authenticated) {
						$userdata = $this->auth_model->getUser($username)->row_array();
						if(count($userdata)>0){
							$session = array(
								'user_id'				=> $userdata["user_id"],
								'user_username'			=> $userdata["user_name"],
								'user_nik'				=> $userdata["people_nip"],
								'user_fullname'			=> $userdata["people_fullname"],
								'user_ip_address'		=> $userdata["user_ip_address"],
								'user_last_login'		=> $userdata["user_last_login"],
								'user_access_id'		=> $userdata["access_id"],
								'user_access_name'		=> $userdata["access_name"],
								'logged_in' 			=> true
								);
							$this->session->set_userdata($session);
							$this->auth_model->setLastLogin($userdata["user_id"]);
							$feedback['status'] = 1;
							$feedback['message'] = 'OK';
							if($this->session->userdata('prev_url')!='') {
								$feedback['redirect_url'] = str_replace('/index.php','',$this->session->userdata('prev_url'));
							} else {
								$defMenu = $this->auth_model->getUserDefaultMenu($username)->row_array();
								if(count($defMenu)>0){
									$feedback['redirect_url'] = base_url().$defMenu["menu_url"];
								}else{
									$feedback['redirect_url'] = base_url().'home/dashboard';
								}
							}

						} else {
							$feedback['status'] = 0;
							$feedback['message'] = 'Username tidak Terdaftar';
							$feedback['redirect_url'] = '';
						}

					} else {
						$feedback['status'] = 0;
						$feedback['message'] = 'Username dan Password tidak Cocok';
						$feedback['redirect_url'] = '';
					}
				} else {
					$feedback['status'] = 0;
					$feedback['message'] = 'User Sudah tidak Aktif';
					$feedback['redirect_url'] = '';
				}
			} else {
				$feedback['status'] = 0;
				$feedback['message'] = 'Username tidak Terdaftar';
				$feedback['redirect_url'] = '';
			}
		} else {
			$feedback['status'] = 'error';
			$feedback['message'] = 'Sistem sedang gangguan';
			$feedback['redirect_url'] = '';
		}

		if($feedback['status']==1){
			redirect($feedback['redirect_url']);
		}else{
			$this->session->set_userdata(array('logged_in'=>false));
			$this->session->set_flashdata(array('status' => $feedback['status'],'message' => $feedback['message']));
			redirect(base_url().'home/auth/login');
		}
		//echo json_encode($feedback);
	}

	private function LDAPChecking() {
		$ldap = @ldap_connect($this->config->config['LDAP_server'], $this->config->config['LDAP_port']);
		@ldap_close($ldap);
		return $ldap?true:false;
	}

	private function LDAPAuth($username, $password) {
		$ldap = @ldap_connect($this->config->config['LDAP_server']);
		$bind = @ldap_bind($ldap, $this->config->config['LDAP_domain']. "\\" . $username, $password);
		@ldap_close($ldap);
		return $bind?true:false;
	}
}
