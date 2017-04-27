<?php
class Other {

	protected $_ci;

	function __construct(){
		$this->_ci = &get_instance();
	}

	public function GetLogCode()
	{
		$LogId = '';
		$InitialCode = date('Y', time()).str_pad(date('m', time()), 2, "0", STR_PAD_LEFT).str_pad(date('d', time()), 2, "0", STR_PAD_LEFT);
		$NextNumber = 1;

		$GetLast = $this->_ci->db->query("SELECT MAX(log_code) AS CODE FROM sys_logs WHERE log_code LIKE '".$InitialCode."%'")->row_array();
		if($GetLast['CODE']>0) {
			$LogId = $InitialCode.str_pad((intval(substr($GetLast['CODE'], 8, 8))+1), 8, "0", STR_PAD_LEFT);
		} else {
			$LogId = $InitialCode.str_pad($NextNumber, 8, "0", STR_PAD_LEFT);
		}
		return $LogId;
	}

	public function GetSequence($_table)
	{
		$GetLast = $this->_ci->db->query("SELECT SEQ_".$_table.".NEXTVAL as NEXTNUM FROM DUAL")->row_array();
		return $GetLast['NEXTNUM'];
	}

	public function InsertLog($code, $objek, $action, $menuId, $tableName)
	{
		$this->_ci->db->set('log_code', $code);
		$this->_ci->db->set('log_user_id', $this->_ci->session->userdata('user_id'));
		$this->_ci->db->set('log_menu_id', $menuId);
		$this->_ci->db->set('log_action', $action);
		$this->_ci->db->set('log_object', $objek);
		$this->_ci->db->set('log_date', date('Y-m-d H:i:s', time()));
		$this->_ci->db->insert('sys_logs');
	}
	public function InsertHistories($history_table_name, $history_table_id, $history_table_status, $history_table_action, $history_table_reason=null)
	{
		$this->_ci->db->set('history_user_id', $this->_ci->session->userdata('user_id'));
		$this->_ci->db->set('history_table_name', $history_table_name);
		$this->_ci->db->set('history_table_id', $history_table_id);
		$this->_ci->db->set('history_table_status', $history_table_status);
		$this->_ci->db->set('history_table_action', $history_table_action);
		$this->_ci->db->set('history_table_reason', $history_table_reason);
		$this->_ci->db->set('history_date', date('Y-m-d H:i:s', time()));
		$this->_ci->db->insert('sys_histories');
	}
	public function InsertNotif($notify) {
		$this->_ci->db->set('notif_date', date('Y-m-d H:i:s', time()));
		return $this->_ci->db->insert('sys_notif', $notify);
	}
	public function RemoveNotif($notif_category,$notif_data_id) {
		$notify = array('notif_is_count' => 0);
		$this->_ci->db->where('notif_category', $notif_category);
		$this->_ci->db->where('notif_data_id', $notif_data_id);
		return $this->_ci->db->update('sys_notif', $notify);

	}
	public function RemoveNotifPerson($notif_category = "",$notif_data_id = 0,$notif_user_id = 0) {
		return $this->_ci->db->query("UPDATE sys_notif SET notif_is_count = 0 WHERE notif_category = '".$notif_category."' AND notif_data_id = '".$notif_data_id."' AND notif_user_id = '".$notif_user_id."'");		

	}
	public function GetUserNotif($grup="", $menu_id = 0, $target_name="") {
		$query="";
		if($grup=="RE"){
			$query = "SELECT user_id,people_email,people_fullname FROM master_peoples INNER JOIN sys_users ON user_people_id = people_id WHERE people_is_redaktur = 1 AND user_status = 1";
		}elseif($grup=="PR"){
			$query = "SELECT aa.user_id,bb.people_email,bb.people_fullname FROM sys_users aa INNER JOIN master_peoples bb ON aa.user_people_id = bb.people_id WHERE aa.user_access_id IN(SELECT a.access_detail_access_id FROM sys_access_details AS a WHERE a.access_detail_can_approve = 1 AND a.access_detail_status = 1 AND a.access_detail_menu_id = ".$menu_id." ) AND aa.user_status = 1";
		}
		return $this->_ci->db->query($query);
	}
	public function getSettingValue($settingCode, $settingType){
		$result = $this->_ci->db->select('SETTING_VALUE')->where('SETTING_CODE', $settingCode)->where('SETTING_TYPE', $settingType)->get('SYS_SETTINGS')->result_array();
		foreach ($result as $value) {
			return $value['SETTING_VALUE'];
		}
	}

}