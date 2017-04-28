<?php
class Dashboard_model extends CI_Model{

	function __construct(){
		parent:: __construct();
	}
	function getDatResult() {
		return $this->db->get('view_trx_pilkada_results')->result_array();
	}

	function get_paged_list($limit=10, $offset=0, $order_column='', $order_type='asc', $search='', $fields='', $pilkada)
	{
		$this->db->where('pilkada_result_pilkada_id', $pilkada);
		$this->db->where('pilkada_result_status',1);

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
			$this->db->order_by('pilkada_result_id','DESC');
		} else {
			$this->db->order_by($order_column,$order_type);
		}

		return $this->db->get('view_trx_pilkada_results',$limit,$offset);
	}

	function count_all($search='', $fields='', $pilkada)
	{	
		$this->db->where('pilkada_result_pilkada_id', $pilkada);
		$this->db->where('pilkada_result_status',1);
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
		$this->db->from('view_trx_pilkada_results');
		return $this->db->count_all_results(); 
	}

	function list_perjalanan_month($limit=10, $offset=0, $order_column='', $order_type='asc', $search='', $fields='', $years, $month)
	{
		$this->db->select('a.country_name,
						COUNT(a.country_name) Jml');
		$this->db->join('kst_master_countries as a', 'traveling_destination_country_id = country_id', 'inner');
		$this->db->group_by('a.country_name');		
		$this->db->where('traveling_destination_status ', 1);
		$this->db->where('YEAR(traveling_startdate) ', $years);
		$this->db->where('MONTH(traveling_startdate) ', $month);

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

		// if (empty($order_column) || empty($order_type))
		// {
		// 	$this->db->order_by('Jml','DESC');
		// } 
		// else {
		// 	$this->db->order_by($order_column,$order_type);
		// }

		$this->db->order_by('Jml','DESC');

		// return $this->db->get('kst_view_trx_traveling_destinations',$limit,$offset);
		return $this->db->get('kst_view_trx_traveling_destinations',$limit,$offset);
	}


	function count_perjalanan_month($search='', $fields='', $years, $month)
	{	
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
		$this->db->from('view_dash_perjalanan');
		return $this->db->count_all_results(); 
	}

	function dataSelectList($id){
		$this->db->where('pilkada_id', $id);
		return $this->db->get('view_trx_pilkadas');
	}

	public function pilkada() {
       return $this->db->get('trx_pilkadas')->result_array();
  	}

  	public function putaran($id) {
       $this->db->where('pilkada_session_pilkada_id', $id);
       return $this->db->get('trx_pilkada_sessions')->result_array();
   	}

	public function kandidat($id) {
       $this->db->where('pilkada_session_member_pilkada_session_id', $id);
       return $this->db->get('view_trx_pilkada_session_members')->result_array();
   	}

   	public function tps($id) {
       $this->db->where('pilkada_tps_village_id', $id);
       return $this->db->get('trx_pilkada_tpses')->result_array();
   	}

   	public function provinsi($id) {
        $this->db->where('province_id', $id);
        return $this->db->get('view_master_provinces')->result_array();
   	}

   	public function kabupaten($id) {
        $this->db->where('regency_province_code', $id);
        return $this->db->get('master_regencies')->result_array();
   	}

   	public function kecamatan($id) {
       $this->db->where('district_regency_code', $id);
        return $this->db->get('master_districts')->result_array();
   	}

   	public function kelurahan($id) {
       $this->db->where('village_district_code', $id);
       return $this->db->get('master_villages')->result_array();
   	}
}