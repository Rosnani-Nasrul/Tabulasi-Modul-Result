<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kecamatan_model extends CI_Model {

	public function __construct() 
	{
		parent::__construct();
	}

	function get_paged_list($limit=10, $offset=0, $order_column='', $order_type='asc', $search='', $fields='')
	{
		$this->db->where('district_status',1);
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
			$this->db->order_by('district_id','DESC');
		} else {
			$this->db->order_by($order_column,$order_type);
		}

		return $this->db->get('master_districts',$limit,$offset);
	}

	function count_all($search='', $fields='')
	{	
		$this->db->where('district_status',1);
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
		$this->db->from('master_districts');
		return $this->db->count_all_results(); 
	}

	function get_paged_listnonaktif($limit=10, $offset=0, $order_column='', $order_type='asc', $search='', $fields='')
	{
		$this->db->where('district_status',0);
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
			$this->db->order_by('district_id','DESC');
		} else {
			$this->db->order_by($order_column,$order_type);
		}

		return $this->db->get('master_districts',$limit,$offset);
	}

	function count_allnonaktif($search='', $fields='')
	{	
		$this->db->where('district_status',0);
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
		$this->db->from('master_districts');
		return $this->db->count_all_results(); 
	}

	function getDetail($districtId){
		$this->db->where('district_id', $districtId);
		return $this->db->get('view_master_districts');
	}

	function adddistrict($datacreate){
		$this->db->insert('master_districts', $datacreate);
		return $this->db->insert_id();
	}

	function update($dataupdate, $districtId){
		$this->db->where('district_id', $districtId);
		return $this->db->update('master_districts', $dataupdate);
	}

	function getMasterDistrict($districtId){
		return $this->db->get_where('view_master_districts', array('district_id' => $districtId));
	}

	function deleteDistrict($districtId, $dataupdate){
		$this->db->set('district_status',0);
		$this->db->where('district_id', $districtId);
		return $this->db->update('master_districts', $dataupdate);
	}

	function aktifDistrict($districtId, $dataupdate){
		$this->db->set('district_status',1);
		$this->db->where('district_id', $districtId);
		return $this->db->update('master_districts',  $dataupdate);
	}

	function dataSelectlist($Id){
    	$this->db->where('regency_id',$Id);
    	return $this->db->get("master_regencies");
    }

	public function get_provinsi() {
       return $this->db->get('master_provinces')->result_array();
  	}

	public function get_kabupaten($id) {
       $this->db->where('regency_province_code', $id);
       return $this->db->get('master_regencies')->result_array();
   	}
}

/* End of file kecamatan_model.php */
/* Location: ./application/models/kecamatan_model.php */