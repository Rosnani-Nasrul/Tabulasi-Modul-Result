<?php
class Notify_model extends CI_Model{

	function __construct(){
		parent:: __construct();
	}

	public function save_notify($notify) {
		$this->db->set('notif_date', "TO_DATE('".date('Y-m-d H:i:s', time())."', 'yyyy-mm-dd hh24:mi:ss')", false);
		return $this->db->insert('sys_notif', $notify);
	}
}