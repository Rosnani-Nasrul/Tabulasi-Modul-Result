<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Partai_model extends CI_Model {

	public function __construct() 
	{
		parent::__construct();
		
	}

	function get_paged_list($limit=10, $offset=0, $order_column='', $order_type='asc', $search='', $fields='')
	{
		$this->db->where('party_status',1);
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
			$this->db->order_by('party_id','DESC');
		} else {
			$this->db->order_by($order_column,$order_type);
		}

		return $this->db->get('master_parties',$limit,$offset);
	}

	function count_all($search='', $fields='')
	{	
		$this->db->where('party_status',1);
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
		$this->db->from('master_parties');
		return $this->db->count_all_results(); 
	}

	function get_paged_listnonaktif($limit=10, $offset=0, $order_column='', $order_type='asc', $search='', $fields='')
	{
		$this->db->where('party_status',0);
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
			$this->db->order_by('party_id','DESC');
		} else {
			$this->db->order_by($order_column,$order_type);
		}

		return $this->db->get('master_parties',$limit,$offset);
	}

	function count_allnonaktif($search='', $fields='')
	{	
		$this->db->where('party_status',0);
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
		$this->db->from('master_parties');
		return $this->db->count_all_results(); 
	}

	function getDetail($partyId){
		$this->db->where('party_id', $partyId);
		return $this->db->get('view_master_parties');
	}

	function getListAcc(){
		return $this->db->get_where('sys_access', array('access_status' => 1));
	}

	function ListAcc(){
		return $this->db->get_where('sys_access', array('access_status' => 1));
	}

	function addParties($datacreate){
		$this->db->insert('master_parties', $datacreate);
		return $this->db->insert_id();
	}

	function update($dataupdate, $partyId){
		$this->db->where('party_id', $partyId);
		return $this->db->update('master_parties', $dataupdate);
	}

	function updateuser($datauser, $id){
		$this->db->where('user_id', $id);
		return $this->db->update('sys_users',$datauser);
	}

	function getMasterParties($partyId){
		return $this->db->get_where('master_parties', array('party_id' => $partyId));
	}

	function deleteParties($partyId, $dataupdate){
		$this->db->set('party_status',0);
		$this->db->where('party_id', $partyId);
		return $this->db->update('master_parties', $dataupdate);
	}

	function aktifParties($partyId, $dataupdate){
		$this->db->set('party_status',1);
		$this->db->where('party_id', $partyId);
		return $this->db->update('master_parties',  $dataupdate);
	}


}

/* End of file partai_model.php */
/* Location: ./application/models/partai_model.php */