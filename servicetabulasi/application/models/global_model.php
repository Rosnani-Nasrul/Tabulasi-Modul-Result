<?php
class Global_model extends CI_Model{

	function __construct(){
		parent:: __construct();
	}

	function get_all_menu($access_id) {
		$query = 'SELECT
					MP.MENU_ID,
					MP.MENU_PARENT_ID,
					MP.MENU_NAME,
					(
						SELECT
							COUNT (MX.MENU_ID)
						FROM
							SYS_MENUS MX
						WHERE
							MX.MENU_PARENT_ID = MP.MENU_ID
					) AS MENU_ANAK,
					LEVEL as MENU_LEVEL
				FROM
				  SYS_MENUS MP
				START WITH
				  MP.MENU_PARENT_ID = 0
				CONNECT BY
				  PRIOR MP.MENU_ID=MP.MENU_PARENT_ID
				ORDER SIBLINGS by MP.MENU_SORT ASC
				';

		return $this->db->query($query); 
	}
	
	public function get_notifikasi() {
		$this->db->where('notif_user_id',  $this->session->userdata('user_id'));
		//$this->db->where('notif_type', 1);
		$this->db->where('notif_is_count', 1);
		$this->db->order_by('notif_date', 'DESC');
		return $this->db->get('view_sys_notif');
	}
	public function get_history($table_name,$table_id) {
		$this->db->where('history_table_name', $table_name);
		$this->db->where('history_table_id', $table_id);
		$this->db->order_by('history_id', 'ASC');
		return $this->db->get('view_sys_histories');
	}
	public function getMenus($access) {
		$this->db->select('sys_menus.*');
		$this->db->where('menu_id IN', '(select access_detail_menu_id from sys_access_details where access_detail_access_id = '.$access.')', false);
		$this->db->where('menu_status', 1);
		$this->db->order_by('menu_sort', 'ASC');
		return $this->db->get('sys_menus');
	}
	public function getbreadcrumb($menu_id) {
		$query = "CALL getbreadcrumb(".$menu_id.")";
		return $this->db->query($query); 
	}
	public function getMenuIsParent($menu_id) {
		$this->db->where('menu_parent_id', $menu_id , false);
		$this->db->where('menu_status', 1);
		$this->db->from('sys_menus');
		return $this->db->count_all_results(); 
	}
	function getThisMenu($menu_segment) {
		$this->db->select('menu_id,menu_parent_id,menu_name');
		$this->db->where('menu_url', $menu_segment);
		$this->db->where('menu_status', 1);
		return $this->db->get('sys_menus');
	}
	
	
}