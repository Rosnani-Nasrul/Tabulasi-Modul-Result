<?php
header('Content-Type: application/json');
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function index()
	{
		
	}

	public function login()
	{
		$username = $this->input->post('username');
		$password  = $this->input->post('password');
		// $username = 'admin';
		// $password = 'admin';

		// var_dump($username);
		// var_dump($password);

		$this->db->where('surveyor_username', $username);
		$this->db->where('surveyor_password', $password);

		$data_user = $this->db->get('sys_surveyor')->result();
		$data['status'] = ($data_user) ? 1 : 0;
		$data['data'] = $data_user;


		echo json_encode($data);
	}

}

/* End of file User.php */
/* Location: ./application/controllers/User.php */