<?php
class Access {

	protected $_ci;
	protected $segment_module, $segment_menu, $segment_function = '';
	protected $login_page = 'home/auth/login';
	protected $logout_page = 'home/auth/logout';
	protected $accessibility = array();
	protected $menu_id = 0;
	protected $not_logged_access = array(
						'home/auth/login',
						'home/auth/checklogin',
						'home/auth/lock',
						'home/notification'
					);
	protected $read_access = array();
	protected $out_of_menu_access = array('home/notification','home/auth/logout','home/auth/lock','home/profile/index','home/profile/editprofile','home/profile/editpassword','home/profile/checkOldPass','home/profile/test_kirim');

	function __construct(){

		$this->_ci = &get_instance();

		$this->base_path_detector = $this->_ci->uri->segment(1);
		$this->segment_module = $this->_ci->uri->segment(1);
		$this->segment_menu = $this->_ci->uri->segment(2);
		$this->segment_function = $this->_ci->uri->segment(3);

		$this->_ci->load->model('access_model','',TRUE);
		//$this->_ci->session->sess_destroy();
		$this->initializing();
	}

	function initializing() {
		//not selecting modul
		
		if($this->base_path_detector!='' && $this->segment_module=='') {
			
			$this->redirect('404');
		}

		//user not logged in
		if(!$this->_ci->session->userdata('logged_in')) {
			if($this->login_page!=$this->segment_module.'/'.$this->segment_menu) {
				if(!in_array($this->segment_module.'/'.$this->segment_menu.'/'.$this->segment_function, $this->not_logged_access)) {
					$this->redirect('login');
				}
			}
		} else {
			if($this->base_path_detector!='') {
				if(!in_array($this->segment_module.'/'.$this->segment_menu, $this->not_logged_access)) {
					//user direct from login page if logged
					if($this->login_page==$this->segment_module.'/'.$this->segment_menu.'/'.$this->segment_function) {

						$this->redirect('first');
					}
					
					$this->accessibility = $this->get_access();
					$menu_row = $this->_ci->access_model->getMenuId($this->segment_module, $this->segment_menu)->row_array();
					if(count($this->accessibility)==0) {
						$this->redirect('404');
					}
					if(!in_array($this->segment_module.(($this->segment_menu!="")?"/".$this->segment_menu:"").(($this->segment_function!="")?"/".$this->segment_function:""), $this->out_of_menu_access)) {
						$this->menu_id = $this->get_menu_id();

						if($this->menu_id==0) {
							$this->redirect('404');
						}
						if(!$this->permission('read')) {
							$this->redirect('404');
						}
					}
				}
			}
		}
	}

	function get_access() {
		$access_rows = $this->_ci->access_model->getAccess($this->_ci->session->userdata('user_access_id'))->result_array();
		$res_access = array(
				'create' => array(),
				'read' => array(),
				'update' => array(),
				'delete' => array(),
				'approve' => array(),
				'print' => array()
			);
		$read_access = array();
		$index_access = 0;
		foreach($access_rows as $access) {
			//echo "....".$access['access_detail_can_create']."....<br>";

			if($access['access_detail_can_create']==1) {
				$res_access['create'][] = $access['access_detail_menu_id'];
				$read_access[] = $access['access_detail_menu_id'];
			}
			if($access['access_detail_can_read']==1) {
				$res_access['read'][] = $access['access_detail_menu_id'];
				$read_access[] = $access['access_detail_menu_id'];
			}
			if($access['access_detail_can_update']==1) {
				$res_access['update'][] = $access['access_detail_menu_id'];
				$read_access[] = $access['access_detail_menu_id'];
			}
			if($access['access_detail_can_delete']==1) {
				$res_access['delete'][] = $access['access_detail_menu_id'];
				$read_access[] = $access['access_detail_menu_id'];
			}
			if($access['access_detail_can_approve']==1) {
				$res_access['approve'][] = $access['access_detail_menu_id'];
				$read_access[] = $access['access_detail_menu_id'];
			}
			if($access['access_detail_can_print']==1) {
				$res_access['print'][] = $access['access_detail_menu_id'];
				$read_access[] = $access['access_detail_menu_id'];
			}
		}
		$res_access['read'] = array_unique($read_access);
		/*echo "<pre>";
		print_r($res_access);
		print_r($res_access);
		die();*/
		return $res_access;
	}


	function get_menu_id() {
		$menu_row = $this->_ci->access_model->getMenuId($this->segment_module, $this->segment_menu)->row_array();

		$menu_id = 0;
		if(count($menu_row)>0) {
			$menu_id = $menu_row['menu_id'];
		}
		return $menu_id;
	}

	function permission($for, $menuid='') {
		$result = false;
		$new_access = ($menuid=='')?$this->accessibility:$this->get_access();

		if(isset($this->accessibility[$for])) {
			if(count($this->accessibility[$for])>0) {
				if(in_array($this->menu_id, $this->accessibility[$for]))
				{
					$result = true;
					//echo "<pre>".$for."=";
					//echo $this->menu_id."----".print_r($this->accessibility[$for]);
					//die();
				}
			}
		}
			//echo "<pre>".$for."=";
			//echo count($this->accessibility[$for])."<br>";
		//print_r(isset($this->accessibility[$for]));
		//die();
		return $result;
	}

	function redirect($word) {

		switch ($word) {
			case 'login':
				redirect(base_url().'home/auth/login');
				die();
			break;
			case 'logout':
				redirect(base_url().'home/auth/logout');
				die();
			break;
			case 'first':
				redirect(base_url().'home/dashboard');
				die();
			break;
			case 'last':
				redirect(base_url().'home/auth/login');
				die();
			break;
			case '404':
				show_404();
				die();
			break;
		}
	}

	function get_all_menu($accessid) {
		$menus = $this->_ci->access_model->getMenus(0, $this->accessibility['read'])->result_array();
		$res = array();
		//'menu_id, menu_name, menu_url, menu_icon
		foreach($menus as $menu) {
			$res[$menu['menu_id']] = $menu;
			$res[$menu['menu_id']]['childs_count'] = 0;
			$res[$menu['menu_id']]['childs'] = array();
			$childs = $this->_ci->access_model->getMenus($menu['menu_id'], $this->accessibility['read'])->result_array();
			if(count($childs)>0) {
				$res[$menu['menu_id']]['childs_count'] = count($childs);
				foreach($childs as $child) {
					$res[$menu['menu_id']]['childs'][$child['menu_id']] = $child;
				}
			}
		}
		
		return $res;
	}

}
?>
