<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class kandidat_model extends CI_Model {

	public function __construct() 
	{
		parent::__construct();
		
	}

	function get_paged_list($limit=10, $offset=0, $order_column='', $order_type='asc', $search='', $fields='')
	{
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
			$this->db->order_by('pilkada_candidate_id','DESC');
		} else {
			$this->db->order_by($order_column,$order_type);
		}

		return $this->db->get('trx_pilkada_candidates',$limit,$offset);
	}

	function count_all($search='', $fields='')
	{	
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
		$this->db->from('trx_pilkada_candidates');
		return $this->db->count_all_results(); 
	}

	function get_paged_listnonaktif($limit=10, $offset=0, $order_column='', $order_type='asc', $search='', $fields='')
	{
		$this->db->where('pilkada_candidate_status',0);
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
			$this->db->order_by('pilkada_candidate_id','DESC');
		} else {
			$this->db->order_by($order_column,$order_type);
		}

		return $this->db->get('trx_pilkada_candidates',$limit,$offset);
	}

	function count_allnonaktif($search='', $fields='')
	{	
		$this->db->where('pilkada_candidate_status',0);
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
		$this->db->from('trx_pilkada_candidates');
		return $this->db->count_all_results(); 
	}

	function getDetail($candidateId){
		// $this->db->join('master_employees', 'employee_id = user_employee_id', 'inner');
		$this->db->where('pilkada_candidate_id', $candidateId);
		$this->db->group_by('party_name');
		return $this->db->get('view_trx_pilkada_candidates');
	}

	// function getPosition($candidateId){
	// 	$this->db->where('pilkada_politician_position',1);
	// 	return $this->db->get('view_trx_pilkada_candidates');
	// }

	// function getListAcc(){
	// 	return $this->db->get_where('sys_access', array('access_status' => 1));
	// }

	// function ListAcc(){
	// 	return $this->db->get_where('sys_access', array('access_status' => 1));
	// }

	function getListKandidat(){
		return $this->db->get_where('trx_pilkadas', array('pilkada_status' => 1));
	}

	function getListParty(){
		return $this->db->get_where('master_parties', array('party_status' => 1));
	}
	function getListPolitician(){
		return $this->db->get_where('master_politicians', array('politician_status' => 1));
	}

	function addKandidat($datacreate){
		$this->db->insert('trx_pilkada_candidates', $datacreate);
		return $this->db->insert_id();
	}

	function addParty($datacreate){
		$this->db->insert('trx_pilkada_politicians', $datacreate);
		return $this->db->insert_id();
	}

	function updateKandidat($dataupdate, $candidateId){
		$this->db->where('pilkada_candidate_id', $candidateId);
		return $this->db->update('trx_pilkada_candidates', $dataupdate);
	}

	function updateParty($dataPolitician, $politicianId){
		$this->db->where('pilkada_politician_id', $politicianId);
		return $this->db->update('trx_pilkada_politicians',$dataPolitician);
	}

	function getTrxKandidat($candidateId){
		return $this->db->get_where('view_trx_pilkada_candidates', array('pilkada_candidate_id' => $candidateId));
	}

	function deleteKandidat($candidateId, $dataupdate){
		$this->db->set('pilkada_candidate_status',0);
		$this->db->where('pilkada_candidate_id', $candidateId);
		return $this->db->update('trx_pilkada_candidates', $dataupdate);
	}

	function aktifKandidat($candidateId, $dataupdate){
		$this->db->set('pilkada_candidate_status',1);
		$this->db->where('pilkada_candidate_id', $candidateId);
		return $this->db->update('trx_pilkada_candidates',  $dataupdate);
	}


}

/* End of file pengguna_model.php */
/* Location: ./application/models/pengguna_model.php */