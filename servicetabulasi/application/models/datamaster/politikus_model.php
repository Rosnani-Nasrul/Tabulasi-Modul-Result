<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class politikus_model extends CI_Model {

	public function __construct() 
	{
		parent::__construct();
		
	}

	function get_paged_list($limit=10, $offset=0, $order_column='', $order_type='asc', $search='', $fields='')
	{
		$this->db->where('politician_status',1);
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
			$this->db->order_by('politician_id','DESC');
		} else {
			$this->db->order_by($order_column,$order_type);
		}

		return $this->db->get('master_politicians',$limit,$offset);
	}

	function count_all($search='', $fields='')
	{	
		$this->db->where('politician_status',1);
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
		$this->db->from('master_politicians');
		return $this->db->count_all_results(); 
	}

	function get_paged_listnonaktif($limit=10, $offset=0, $order_column='', $order_type='asc', $search='', $fields='')
	{
		$this->db->where('politician_status',0);
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
			$this->db->order_by('politician_id','DESC');
		} else {
			$this->db->order_by($order_column,$order_type);
		}

		return $this->db->get('master_politicians',$limit,$offset);
	}

	function count_allnonaktif($search='', $fields='')
	{	
		$this->db->where('politician_status',0);
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
		$this->db->from('master_politicians');
		return $this->db->count_all_results(); 
	}

	function getDetail($politikusId){
		// $this->db->join('master_politicians', 'politician_id = user_people_id', 'inner');
		$this->db->where('politician_id', $politikusId);
		return $this->db->get('view_master_politician');
	}

	function getListAcc(){
		return $this->db->get_where('sys_access', array('access_status' => 1));
	}

	function ListAcc(){
		return $this->db->get_where('sys_access', array('access_status' => 1));
	}

	function addPolitician($datacreate){
		$this->db->insert('master_politicians', $datacreate);
		return $this->db->insert_id();
	}

	function update($dataupdate, $politicianId){
		$this->db->where('politician_id', $politicianId);
		return $this->db->update('master_politicians', $dataupdate);
	}

	function updateuser($datauser, $id){
		$this->db->where('user_id', $id);
		return $this->db->update('sys_users',$datauser);
	}

	function getMasterPolitician($politicianId){
		return $this->db->get_where('view_master_politician', array('politician_id' => $politicianId));
	}

	function deletePolitician($politicianId, $dataupdate){
		$this->db->set('politician_status',0);
		$this->db->where('politician_id', $politicianId);
		return $this->db->update('master_politicians', $dataupdate);
	}

	function aktifPolitician($politicianId, $dataupdate){
		$this->db->set('politician_status',1);
		$this->db->where('politician_id', $politicianId);
		return $this->db->update('master_politicians',  $dataupdate);
	}


}

/* End of file politikus_model.php */
/* Location: ./application/models/politikus_model.php */