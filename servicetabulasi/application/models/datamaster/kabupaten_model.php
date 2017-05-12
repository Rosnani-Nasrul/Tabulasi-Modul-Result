<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kabupaten_model extends CI_Model {

	public function __construct() 
	{
		parent::__construct();
	}

	function get_paged_list($limit=10, $offset=0, $order_column='', $order_type='asc', $search='', $fields='')
	{
		$this->db->where('regency_status',1);
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
			$this->db->order_by('regency_id','DESC');
		} else {
			$this->db->order_by($order_column,$order_type);
		}

		return $this->db->get('master_regencies',$limit,$offset);
	}

	function count_all($search='', $fields='')
	{	
		$this->db->where('regency_status',1);
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
		$this->db->from('master_regencies');
		return $this->db->count_all_results(); 
	}

	function get_paged_listnonaktif($limit=10, $offset=0, $order_column='', $order_type='asc', $search='', $fields='')
	{
		$this->db->where('regency_status',0);
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
			$this->db->order_by('regency_id','DESC');
		} else {
			$this->db->order_by($order_column,$order_type);
		}

		return $this->db->get('master_regencies',$limit,$offset);
	}

	function count_allnonaktif($search='', $fields='')
	{	
		$this->db->where('regency_status',0);
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
		$this->db->from('master_regencies');
		return $this->db->count_all_results(); 
	}

	function getDetail($regencyId){
		$this->db->where('regency_id', $regencyId);
		return $this->db->get('view_master_provinces');
	}

	function addRegency($datacreate){
		$this->db->insert('master_regencies', $datacreate);
		return $this->db->insert_id();
	}

	function update($dataupdate, $regencyId){
		$this->db->where('regency_id', $regencyId);
		return $this->db->update('master_regencies', $dataupdate);
	}

	function updateuser($datauser, $id){
		$this->db->where('user_id', $id);
		return $this->db->update('sys_users',$datauser);
	}

	function getMasterRegency($regencyId){
		return $this->db->get_where('master_regencies', array('regency_id' => $regencyId));
	}

	function deleteRegency($regencyId, $dataupdate){
		$this->db->set('regency_status',0);
		$this->db->where('regency_id', $regencyId);
		return $this->db->update('master_regencies', $dataupdate);
	}

	function aktifRegency($regencyId, $dataupdate){
		$this->db->set('regency_status',1);
		$this->db->where('regency_id', $regencyId);
		return $this->db->update('master_regencies',  $dataupdate);
	}

	function dataSelectlist($Id){
    	$this->db->where('province_id',$Id);
    	return $this->db->get("master_provinces");
    }

	public function get_provinsi() {
       return $this->db->get('master_provinces')->result_array();
  	}


}

/* End of file kabupaten_model.php */
/* Location: ./application/models/kabupaten_model.php */