<?php
class Access_model extends CI_Model{

	function __construct(){
		parent:: __construct();
	}

	public function getAccess($access_id) {
		$this->db->where('access_detail_access_id', $access_id);
		$this->db->where('access_detail_status', 1);
		return $this->db->get('sys_access_details');
	}

	public function getMenuId($module_segment, $menu_segment) {
		$this->db->select('menu_id');
		$this->db->where('menu_url', $module_segment.'/'.$menu_segment);
		
		$this->db->where('menu_status', 1);
		return $this->db->get('sys_menus');
	}

	public function getMenus($parentid, $access) {
		$this->db->select('menu_id, menu_name, menu_url, menu_icon');
		$this->db->where('menu_parent_id', $parentid);
		$this->db->where('menu_id IN ('.implode(',',$access).')');
		$this->db->where('menu_status', 1);
		$this->db->order_by('menu_sort', 'ASC');
		return $this->db->get('sys_menus');
	}
}