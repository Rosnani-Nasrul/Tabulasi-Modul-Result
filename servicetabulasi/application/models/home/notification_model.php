<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class notification_model extends CI_Model {

	public function __construct() 
	{
		parent::__construct();
		
	}

	function getdataNotification(){
		$this->db->where('notif_is_mail_send', 0);
		$this->db->where('notif_category', "siaran_pers");
		return $this->db->get('view_sys_notif');
	}
	function updateNotif($notif_id){
		$data = array(
			'notif_is_mail_send' => 1
			);

		$this->db->where('notif_id', $notif_id);
		return $this->db->update('sys_notif', $data); 
	}
}

/* End of file profile_model.php */
/* Location: ./application/models/profile_model.php */