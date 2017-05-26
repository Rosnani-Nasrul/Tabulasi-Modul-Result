<?php
class Notify {

	protected $_ci;

	function __construct() {
		$this->_ci = &get_instance();
		$this->_ci->load->model('notify_model','',TRUE);
	}

	public function SendNotify($div, $dept, $message, $link, $category, $type, $dataId)
	{
		if($dept!='') {
			$depthead = $this->_ci->notify_model->get_depthead($dept)->result_array();
			foreach($depthead as $duid) {
				$notify = array(
						'NOTIF_USER_ID' => $duid['USER_ID'],
						'NOTIF_LINK' => $link,
						'NOTIF_MESSAGE' => $message,
						'NOTIF_STATUS' => 1,
						'NOTIF_TYPE' => $type,
						'NOTIF_IS_FLASH' => 1,
						'NOTIF_IS_COUNT' => 1,
						'NOTIF_CATEGORY' => $category,
						'NOTIF_DATA_ID' => $dataId
					);
				$this->_ci->notify_model->save_notify($notify);
			}
		}
	}

	public function PushNotify($target, $message, $link, $category, $type, $dataId)
	{
		$targets = (is_array($target))?$target:array($target);
		foreach($targets as $ecode) {
			$targetuserid = $this->_ci->notify_model->get_user_id($ecode)->row_array();
			if(count($targetuserid)>0) {
				$notify = array(
						'NOTIF_USER_ID' => $targetuserid['USER_ID'],
						'NOTIF_LINK' => $link,
						'NOTIF_MESSAGE' => $message,
						'NOTIF_STATUS' => 1,
						'NOTIF_TYPE' => $type,
						'NOTIF_IS_FLASH' => 1,
						'NOTIF_IS_COUNT' => 1,
						'NOTIF_CATEGORY' => $category,
						'NOTIF_DATA_ID' => $dataId
					);
				$this->_ci->notify_model->save_notify($notify);
			}
		}
	}
}