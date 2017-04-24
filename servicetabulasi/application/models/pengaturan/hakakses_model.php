<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class hakakses_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}

	function get_paged_list($limit=10, $offset=0, $order_column='', $order_type='asc', $search='', $fields='')
	{
		$this->db->where('access_status',1);
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
			$this->db->order_by('aksesid','DESC');
		} else {
			$this->db->order_by($order_column,$order_type);
		}

		return $this->db->get('view_sys_access',$limit,$offset);
	}

	function count_all($search='', $fields='')
	{	
		$this->db->where('access_status',1);
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

		$this->db->from('view_sys_access');
		return $this->db->count_all_results(); 
	}

	function get_paged_listnonaktif($limit=10, $offset=0, $order_column='', $order_type='asc', $search='', $fields='')
	{
		$this->db->where('access_status',0);
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
			$this->db->order_by('aksesid','DESC');
		} else {
			$this->db->order_by($order_column,$order_type);
		}

		return $this->db->get('view_sys_access',$limit,$offset);
	}

	function count_allnonaktif($search='', $fields='')
	{	
		$this->db->where('access_status',0);
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

		$this->db->from('view_sys_access');
		return $this->db->count_all_results(); 
	}

	function add($datacreate){
		$this->db->insert('sys_access', $datacreate);
		return $this->db->insert_id();
	}

	function addDetail($dataAccDetail){
		$this->db->insert('sys_access_details', $dataAccDetail);
	}

	function update($idakses, $dataupdate){
		$this->db->where('access_id', $idakses);
		return $this->db->update('sys_access', $dataupdate);
	}

	function updateDetail($menuid,$accessid,$dataupdate){
		$this->db->where('access_detail_menu_id',$menuid);
		$this->db->where('access_detail_access_id',$accessid);
		$this->db->update('sys_access_details', $dataupdate);
	}

	function delete_detail($idakses){
		$this->db->where('access_detail_access_id',$idakses);
		return $this->db->delete('sys_access_details');
	}

	function getListhakakses(){
		return $this->db->get_where('sys_access', array('access_status' => 1));
	}

	function getlistakses(){
		return $this->db->get_where('sys_access_details', array('access_detail_status' => 1));
	}

	function getDetailakses($idakses){
		$this->db->where('access_detail_access_id',$idakses);
		return $this->db->get('sys_access_details');
	}

	function getDetailhakakses($idakses){
		$this->db->where('access_id',$idakses);
		return $this->db->get('sys_access');
	}

	function gethakakses($idakses){
		return $this->db->get_where('sys_access', array('access_id' => $idakses));
	}

	function deleteakses($idakses, $dataupdate){
		$this->db->set('access_status',0);
		$this->db->where('access_id', $idakses);
		return $this->db->update('sys_access', $dataupdate);
	}

	function aktifakses($idakses, $dataupdate){
		$this->db->set('access_status',1);
		$this->db->where('access_id', $idakses);
		return $this->db->update('sys_access', $dataupdate);
	}

	function get_listmenu_induk($id){
		$query = "SELECT
			m.menu_id,
			m.menu_parent_id,
			m.menu_url,
			m.menu_name,
			m.menu_icon,
			m.menu_sort,
			m.menu_status,
			1 AS menu_level
		FROM
			sys_menus AS m
		WHERE
		m.menu_parent_id = '".$id."' ORDER BY m.menu_sort ASC";
		return $this->db->query($query);
	}

	function get_listmenu_anak($id, $sort){
		$query = "SELECT
			m.menu_id,
			m.menu_parent_id,
			m.menu_url,
			m.menu_icon,
			m.menu_name,
			CONCAT('".$sort."','.',m.menu_sort) AS menu_sort,
			m.menu_status,
			2 AS menu_level
		FROM
			sys_menus AS m
		WHERE
		m.menu_parent_id = '".$id."'";
		return $this->db->query($query);
	}

}

/* End of file hakakses_model.php */
/* Location: ./application/models/hakakses_model.php */