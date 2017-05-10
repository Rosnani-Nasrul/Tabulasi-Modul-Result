<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notification extends CI_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('home/notification_model');
	}

	public function index(){
		$data = array();
		$Notification = $this->notification_model->getdataNotification()->result_array();
		foreach ($Notification as $n) {
			
			$tipe = "";
			$aksi = "";
			
			$tipe = str_replace("_", " ", $n["notif_category"]);

			$subject_custom = "Terdapat ".$tipe.". dengan status ".$n["notif_message"];

			$to = $n["people_email"];
			$subject = "[Informasi Website PPATK] ".$subject_custom;

			$message = "Yang Terhormat. ".$n["people_fullname"]."<br><br><br>";
			$message .= $subject_custom." dengan data sbb.<br><br>";
			$message .= "Tanggal : ".$n["notif_date"]."<br>";
			$message .= "Judul : ".$n["article_title"]."<br><br>";
			$message .= "Silahkan cek data tersebut pada <a href='http://ppatk.go.id'>ppatk.go.id</a><br><br>";
			$message .= "Terima Kasih<br><br>";
			$message .= "Administrator Website PPATK.<br><br>";

			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .= 'From: Website PPATK <ppatkadmin@ppatk.go.id>' . "\r\n";

			if(@mail($to,$subject,$message,$headers))
			{
				$this->notification_model->updateNotif($n["notif_id"]);
			}
		}

		echo "<pre>";
		print_r($Notification);

	}

}