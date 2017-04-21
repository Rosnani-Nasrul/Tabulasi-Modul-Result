<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class pengguna_model extends CI_Model {

	public function __construct() 
	{
		parent::__construct();
		
	}

	function get_paged_list($limit=10, $offset=0, $order_column='', $order_type='asc', $search='', $fields='')
	{
		$this->db->where('user_status',1);
		if($search!='' AND $fields!='')
		{
			$likeclause = '(';
			$i=0;
			foreach($fields as $field)
			{
				if($i==count($fields)-1) {
					$likeclause .= "UPPER(".$field.") LIKE '%".strtoupper($search)."%'";
				} else {
					$likeclause .= "UPPER(".$field.") LIKE '%".strtoupper($search)."%' OR ";
				}
				++$i;
			}
			$likeclause .= ')';
			$this->db->where($likeclause);
		}

		if (empty($order_column) || empty($order_type))
		{
			$this->db->order_by('user_id','DESC');
		} else {
			$this->db->order_by($order_column,$order_type);
		}

		return $this->db->get('view_sys_users',$limit,$offset);
	}

	function count_all($search='', $fields='')
	{	
		$this->db->where('user_status',1);
		if($search!='' AND $fields!='')
		{
			$likeclause = '(';
			$i=0;
			foreach($fields as $field)
			{
				if($i==count($fields)-1) {
					$likeclause .= "UPPER(".$field.") LIKE '%".strtoupper($search)."%'";
				} else {
					$likeclause .= "UPPER(".$field.") LIKE '%".strtoupper($search)."%' OR ";
				}
				++$i;
			}
			$likeclause .= ')';
			$this->db->where($likeclause);
		}
		$this->db->from('view_sys_users');
		return $this->db->count_all_results(); 
	}

	function get_paged_listnonaktif($limit=10, $offset=0, $order_column='', $order_type='asc', $search='', $fields='')
	{
		$this->db->where('user_status',0);
		if($search!='' AND $fields!='')
		{
			$likeclause = '(';
			$i=0;
			foreach($fields as $field)
			{
				if($i==count($fields)-1) {
					$likeclause .= "UPPER(".$field.") LIKE '%".strtoupper($search)."%'";
				} else {
					$likeclause .= "UPPER(".$field.") LIKE '%".strtoupper($search)."%' OR ";
				}
				++$i;
			}
			$likeclause .= ')';
			$this->db->where($likeclause);
		}

		if (empty($order_column) || empty($order_type))
		{
			$this->db->order_by('user_id','DESC');
		} else {
			$this->db->order_by($order_column,$order_type);
		}

		return $this->db->get('view_sys_users',$limit,$offset);
	}

	function count_allnonaktif($search='', $fields='')
	{	
		$this->db->where('user_status',0);
		if($search!='' AND $fields!='')
		{
			$likeclause = '(';
			$i=0;
			foreach($fields as $field)
			{
				if($i==count($fields)-1) {
					$likeclause .= "UPPER(".$field.") LIKE '%".strtoupper($search)."%'";
				} else {
					$likeclause .= "UPPER(".$field.") LIKE '%".strtoupper($search)."%' OR ";
				}
				++$i;
			}
			$likeclause .= ')';
			$this->db->where($likeclause);
		}
		$this->db->from('view_sys_users');
		return $this->db->count_all_results(); 
	}

	function getDetail($pggnaId){
		// $this->db->join('master_employees', 'employee_id = user_employee_id', 'inner');
		$this->db->where('user_id', $pggnaId);
		return $this->db->get('view_sys_users');
	}

	function getListAcc(){
		return $this->db->get_where('sys_access', array('access_status' => 1));
	}

	function ListAcc(){
		return $this->db->get_where('sys_access', array('access_status' => 1));
	}

	function add($datacreate){
		$this->db->insert('sys_users', $datacreate);
		return $this->db->insert_id();
	}

	function addpeople($datacreate){
		$this->db->insert('master_peoples', $datacreate);
		return $this->db->insert_id();
	}

	function update($dataupdate, $idpengguna){
		$this->db->where('user_id', $idpengguna);
		return $this->db->update('sys_users', $dataupdate);
	}

	function updatepeople($datapeople, $id){
		$this->db->where('people_id', $id);
		return $this->db->update('master_peoples',$datapeople);
	}

	function getSysUser($userId){
		return $this->db->get_where('view_sys_users', array('user_id' => $userId));
	}

	function deleteuser($userId, $dataupdate){
		$this->db->set('user_status',0);
		$this->db->where('user_id', $userId);
		return $this->db->update('sys_users', $dataupdate);
	}

	function aktifuser($userId, $dataupdate){
		$this->db->set('user_status',1);
		$this->db->where('user_id', $userId);
		return $this->db->update('sys_users',  $dataupdate);
	}


}

/* End of file pengguna_model.php */
/* Location: ./application/models/pengguna_model.php */