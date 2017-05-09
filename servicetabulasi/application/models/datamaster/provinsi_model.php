<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class provinsi_model extends CI_Model {

	public function __construct() 
	{
		parent::__construct();
		
	}

	function get_paged_list($limit=10, $offset=0, $order_column='', $order_type='asc', $search='', $fields='')
	{
		$this->db->where('province_status',1);
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
			$this->db->order_by('province_id','DESC');
		} else {
			$this->db->order_by($order_column,$order_type);
		}

		return $this->db->get('master_provinces',$limit,$offset);
	}

	function count_all($search='', $fields='')
	{	
		$this->db->where('province_status',1);
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
		$this->db->from('master_provinces');
		return $this->db->count_all_results(); 
	}

	function get_paged_listnonaktif($limit=10, $offset=0, $order_column='', $order_type='asc', $search='', $fields='')
	{
		$this->db->where('province_status',0);
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
			$this->db->order_by('province_id','DESC');
		} else {
			$this->db->order_by($order_column,$order_type);
		}

		return $this->db->get('master_provinces',$limit,$offset);
	}

	function count_allnonaktif($search='', $fields='')
	{	
		$this->db->where('province_status',0);
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
		$this->db->from('master_provinces');
		return $this->db->count_all_results(); 
	}

	function getDetail($provinceId){
		// $this->db->join('master_politicians', 'politician_id = user_people_id', 'inner');
		$this->db->where('province_id', $provinceId);
		return $this->db->get('master_provinces');
	}

	function getListAcc(){
		return $this->db->get_where('sys_access', array('access_status' => 1));
	}

	function ListAcc(){
		return $this->db->get_where('sys_access', array('access_status' => 1));
	}

	function addProvince($datacreate){
		$this->db->insert('master_provinces', $datacreate);
		return $this->db->insert_id();
	}

	function update($dataupdate, $provinceId){
		$this->db->where('province_id', $provinceId);
		return $this->db->update('master_provinces', $dataupdate);
	}

	function updateuser($datauser, $id){
		$this->db->where('user_id', $id);
		return $this->db->update('sys_users',$datauser);
	}

	function getMasterProvince($provinceId){
		return $this->db->get_where('master_provinces', array('province_id' => $provinceId));
	}

	function deleteProvince($provinceId, $dataupdate){
		$this->db->set('province_status',0);
		$this->db->where('province_id', $provinceId);
		return $this->db->update('master_provinces', $dataupdate);
	}

	function aktifProvince($provinceId, $dataupdate){
		$this->db->set('province_status',1);
		$this->db->where('province_id', $provinceId);
		return $this->db->update('master_provinces',  $dataupdate);
	}


}

/* End of file provinsi_model.php */
/* Location: ./application/models/provinsi_model.php */