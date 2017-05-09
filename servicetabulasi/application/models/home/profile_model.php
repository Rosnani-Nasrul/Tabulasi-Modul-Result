<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class profile_model extends CI_Model {

	public function __construct() 
	{
		parent::__construct();
		
	}

	function getDetailprofile($web_id){
		$this->db->join('master_peoples', 'people_id = user_people_id', 'inner');
		$this->db->where('user_id', $web_id);
		return $this->db->get('view_sys_users');
	}

	function getSysUser($userId){
		return $this->db->get_where('view_sys_users', array('user_id' => $userId));
	}

	function updatepeople($datapeople, $id){
		$this->db->where('people_id', $id);
		return $this->db->update('master_peoples',$datapeople);
	}

	function update($dataupdate, $idpengguna){
		$this->db->where('user_id', $idpengguna);
		return $this->db->update('sys_users', $dataupdate);
	}

	function cekPassLama($usrId,$userpass){
		$this->db->select('COUNT(*) AS totalCount', false);
		$this->db->where('user_id', $usrId);
		$this->db->where('user_password', passwordEncoder($userpass));
		return $this->db->get('view_sys_users');
	}
}

/* End of file profile_model.php */
/* Location: ./application/models/profile_model.php */