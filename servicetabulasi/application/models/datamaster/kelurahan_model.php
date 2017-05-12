<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kelurahan_model extends CI_Model {

	public function __construct() 
	{
		parent::__construct();
	}

	function get_paged_list($limit=10, $offset=0, $order_column='', $order_type='asc', $search='', $fields='')
	{
		$this->db->where('village_status',1);
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
			$this->db->order_by('village_id','DESC');
		} else {
			$this->db->order_by($order_column,$order_type);
		}

		return $this->db->get('master_villages',$limit,$offset);
	}

	function count_all($search='', $fields='')
	{	
		$this->db->where('village_status',1);
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
		$this->db->from('master_villages');
		return $this->db->count_all_results(); 
	}

	function get_paged_listnonaktif($limit=10, $offset=0, $order_column='', $order_type='asc', $search='', $fields='')
	{
		$this->db->where('village_status',0);
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
			$this->db->order_by('village_id','DESC');
		} else {
			$this->db->order_by($order_column,$order_type);
		}

		return $this->db->get('master_villages',$limit,$offset);
	}

	function count_allnonaktif($search='', $fields='')
	{	
		$this->db->where('village_status',0);
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
		$this->db->from('master_villages');
		return $this->db->count_all_results(); 
	}

	function getDetail($villageId){
		$this->db->where('village_id', $villageId);
		return $this->db->get('view_indonesia');
	}

	function addVillage($datacreate){
		$this->db->insert('master_villages', $datacreate);
		return $this->db->insert_id();
	}

	function update($dataupdate, $villageId){
		$this->db->where('village_id', $villageId);
		return $this->db->update('master_villages', $dataupdate);
	}

	function updateuser($datauser, $id){
		$this->db->where('user_id', $id);
		return $this->db->update('sys_users',$datauser);
	}

	function getMasterVillage($villageId){
		return $this->db->get_where('master_villages', array('village_id' => $villageId));
	}

	function deleteVillage($villageId, $dataupdate){
		$this->db->set('village_status',0);
		$this->db->where('village_id', $villageId);
		return $this->db->update('master_villages', $dataupdate);
	}

	function aktifVillage($villageId, $dataupdate){
		$this->db->set('village_status',1);
		$this->db->where('village_id', $villageId);
		return $this->db->update('master_villages',  $dataupdate);
	}

	function dataSelectlist($Id){
    	$this->db->where('district_id',$Id);
    	return $this->db->get("master_districts");
    }

	public function get_provinsi() {
       return $this->db->get('master_provinces')->result_array();
  	}

	public function get_kabupaten($id) {
       $this->db->where('regency_province_code', $id);
       return $this->db->get('master_regencies')->result_array();
   	}

   	public function get_kecamatan($id) {
       $this->db->where('district_regency_code', $id);
       return $this->db->get('master_districts')->result_array();
   	}
}

/* End of file kelurahan_model.php */
/* Location: ./application/models/kelurahan_model.php */