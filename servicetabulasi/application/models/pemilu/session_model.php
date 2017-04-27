<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class session_model extends CI_Model {

	public function __construct() 
	{
		parent::__construct();
		
	}

	function get_paged_list($limit=10, $offset=0, $order_column='', $order_type='asc', $search='', $fields='')
	{
		$this->db->where('pilkada_session_status',1);
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
			$this->db->order_by('pilkada_session_id','DESC');
		} else {
			$this->db->order_by($order_column,$order_type);
		}

		return $this->db->get('trx_pilkada_sessions',$limit,$offset);
	}

	function get_paged_listcandidat($limit=10, $offset=0, $order_column='', $order_type='asc', $search='', $fields='', $id)
	{
		$this->db->where('pilkada_session_id',$id);
		$this->db->where('pilkada_candidate_status',1);
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
			$this->db->order_by('pilkada_session_id','DESC');
		} else {
			$this->db->order_by($order_column,$order_type);
		}

		return $this->db->get('view_trx_sessions',$limit,$offset);
	}

	function count_all($search='', $fields='')
	{	
		$this->db->where('pilkada_session_status',1);
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
		$this->db->from('trx_pilkada_sessions');
		return $this->db->count_all_results(); 
	}

	function count_allcandidat($search='', $fields='', $id)
	{	
		$this->db->where('pilkada_session_id',$id);
		$this->db->where('pilkada_candidate_status',1);
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
		$this->db->from('view_trx_sessions');
		return $this->db->count_all_results(); 
	}

	function get_paged_listnonaktif($limit=10, $offset=0, $order_column='', $order_type='asc', $search='', $fields='')
	{
		$this->db->where('pilkada_session_status',0);
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
			$this->db->order_by('pilkada_session_id','DESC');
		} else {
			$this->db->order_by($order_column,$order_type);
		}

		return $this->db->get('trx_pilkada_sessions',$limit,$offset);
	}

	function count_allnonaktif($search='', $fields='')
	{	
		$this->db->where('pilkada_session_status',0);
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
		$this->db->from('trx_pilkada_sessions');
		return $this->db->count_all_results(); 
	}

	function getDetail($sessionId){
		// $this->db->join('master_employees', 'employee_id = user_employee_id', 'inner');
		$this->db->where('pilkada_session_id', $sessionId);
		return $this->db->get('view_trx_sessions');
	}

	// function getListAcc(){
	// 	return $this->db->get_where('sys_access', array('access_status' => 1));
	// }

	// function ListAcc(){
	// 	return $this->db->get_where('sys_access', array('access_status' => 1));
	// }

	function getListPilkada(){
		// return $this->db->get('trx_pilkadas')->result_array();
		return $this->db->get_where('trx_pilkadas', array('pilkada_status' => 1))->result_array();
    	// return $this->db->get("trx_pilkadas");
	}

	function getListCandidat($id){
		$this->db->where('pilkada_candidate_pilkada_id', $id);
		return $this->db->get_where('trx_pilkada_candidates', array('pilkada_candidate_status' => 1))->result_array();
		// return $this->db->get('trx_pilkada_candidates')->result_array();
    	// return $this->db->get("trx_pilkada_candidates");
	}

	function getListSession($id){
		$this->db->where('pilkada_session_pilkada_id', $id);
		return $this->db->get_where('trx_pilkada_sessions', array('pilkada_session_status' => 1))->result_array();
    	// return $this->db->get("trx_pilkadas");
	}

	function addSession($datacreate){
		$this->db->insert('trx_pilkada_sessions', $datacreate);
		return $this->db->insert_id();
	}

	function addSessionMember($datacreate){
		$this->db->insert('trx_pilkada_session_members', $datacreate);
		return $this->db->insert_id();
	}

	function updateSession($dataupdate, $sessionId){
		$this->db->where('pilkada_session_id', $sessionId);
		return $this->db->update('trx_pilkada_sessions', $dataupdate);
	}

	// function updateSessionMember($dataSessionMember, $id){
	// 	$this->db->where('pilkada_session_member_id', $id);
	// 	return $this->db->update('trx_pilkada_session_members',$dataSessionMember);
	// }

	function getTrxSession($sessionId){
		return $this->db->get_where('view_trx_sessions', array('pilkada_session_id' => $sessionId));
	}

	function deleteSession($sessionId, $dataupdate){
		$this->db->set('pilkada_session_status',0);
		$this->db->where('pilkada_session_id', $sessionId);
		return $this->db->update('trx_pilkada_sessions', $dataupdate);
	}

	function aktifSession($sessionId, $dataupdate){
		$this->db->set('pilkada_session_status',1);
		$this->db->where('pilkada_session_id', $sessionId);
		return $this->db->update('trx_pilkada_sessions',  $dataupdate);
	}


}

/* End of file pengguna_model.php */
/* Location: ./application/models/pengguna_model.php */