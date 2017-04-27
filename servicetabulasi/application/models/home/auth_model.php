<?php
class Auth_model extends CI_Model{

	function __construct(){
		parent:: __construct();
	}

	public function checkUsername($username) {
		$this->db->select('user_name, user_status');
		$this->db->where('user_name', $username);
		$this->db->where('user_status', 1);
		return $this->db->get('view_sys_users');
	}

	public function getAuth($username, $password) {
		$this->db->where('user_name', $username);
		$this->db->where('user_password', $password);
		$this->db->where('user_status', 1);
		$this->db->from('view_sys_users');
		return $this->db->count_all_results(); 
	}
	function getUser($username) {
		$this->db->select('user_id, user_name, people_nip, people_fullname, access_id, access_name ,user_last_login,user_ip_address,people_photo');
		// $this->db->join('master_peoples', 'people_user_id = user_id and people_status = 1', 'inner');
		// $this->db->join('sys_access', 'access_id = user_access_id and access_status = 1', 'inner');
		$this->db->where('user_name', $username);
		$this->db->where('user_status', 1);
		return $this->db->get('view_sys_users');
	}
	
	function getUserDefaultMenu($username) {
		$this->db->select('menu_url,menu_name,menu_icon');
		$this->db->join('sys_access', 'access_id = user_access_id and access_status = 1', 'inner');
		$this->db->join('sys_menus', 'menu_id = access_default_menu_id and menu_status = 1', 'inner');
		$this->db->where('user_name', $username);
		$this->db->where('user_status', 1);
		return $this->db->get('sys_users');
	}
	function setLastLogin($userId){
		$ipaddress = $this->input->ip_address();
		$ipaddress = (($ipaddress=='::1')?'127.0.0.1':$ipaddress);
		$this->db->set('user_last_login', date('Y-m-d H:i:s', time()));
		$this->db->set("user_online", 1);
		$this->db->set("user_ip_address", $ipaddress);
		$this->db->where("user_id", $userId);
		$this->db->update("sys_users");
	}
	
}