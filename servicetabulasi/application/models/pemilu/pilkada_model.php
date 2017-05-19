<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class pilkada_model extends CI_Model {

	public function __construct() 
	{
		parent::__construct();
		
	}

	function get_paged_list($limit=10, $offset=0, $order_column='', $order_type='asc', $search='', $fields='')
	{
		$this->db->where('pilkada_status',1);
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
			$this->db->order_by('pilkada_id','DESC');
		} else {
			$this->db->order_by($order_column,$order_type);
		}

		return $this->db->get('view_trx_pilkadas',$limit,$offset);
	}

	function count_all($search='', $fields='')
	{	
		$this->db->where('pilkada_status',1);
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
		$this->db->from('view_trx_pilkadas');
		return $this->db->count_all_results(); 
	}

	function get_paged_listnonaktif($limit=10, $offset=0, $order_column='', $order_type='asc', $search='', $fields='')
	{
		$this->db->where('pilkada_status',0);
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
			$this->db->order_by('pilkada_id','DESC');
		} else {
			$this->db->order_by($order_column,$order_type);
		}

		return $this->db->get('view_trx_pilkadas',$limit,$offset);
	}

	function count_allnonaktif($search='', $fields='')
	{	
		$this->db->where('pilkada_status',0);
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
		$this->db->from('view_trx_pilkadas');
		return $this->db->count_all_results(); 
	}

	function getDetail($pilkadaId){
		// $this->db->join('master_employees', 'employee_id = user_employee_id', 'inner');
		$this->db->where('pilkada_id', $pilkadaId);
		return $this->db->get('view_trx_pilkadas');
	}

	// function getListAcc(){
	// 	return $this->db->get_where('sys_access', array('access_status' => 1));
	// }

	// function ListAcc(){
	// 	return $this->db->get_where('sys_access', array('access_status' => 1));
	// }

	function getListProvince(){
		return $this->db->get_where('master_provinces', array('province_status' => 1));
	}

	function addPilkada($datacreate){
		$this->db->insert('trx_pilkadas', $datacreate);
		return $this->db->insert_id();
	}

	// function addProvince($datacreate){
	// 	$this->db->insert('master_provinces', $datacreate);
	// 	return $this->db->insert_id();
	// }

	function updatePilkada($dataupdate, $pilkadaId){
		$this->db->where('pilkada_id', $pilkadaId);
		return $this->db->update('trx_pilkadas', $dataupdate);
	}

	// function updateProvince($dataProvince, $provinceId){
	// 	$this->db->where('province_id', $provinceId);
	// 	return $this->db->update('master_provinces',$dataProvince);
	// }

	function getTrxPilkada($pilkadaId){
		return $this->db->get_where('view_trx_pilkadas', array('pilkada_id' => $pilkadaId));
	}

	function deletePilkada($pilkadaId, $dataupdate){
		$this->db->set('pilkada_status',0);
		$this->db->where('pilkada_id', $pilkadaId);
		return $this->db->update('trx_pilkadas', $dataupdate);
	}

	function aktifPilkada($pilkadaId, $dataupdate){
		$this->db->set('pilkada_status',1);
		$this->db->where('pilkada_id', $pilkadaId);
		return $this->db->update('trx_pilkadas',  $dataupdate);
	}


}

/* End of file pengguna_model.php */
/* Location: ./application/models/pengguna_model.php */