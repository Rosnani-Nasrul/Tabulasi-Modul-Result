<?php
class Template {

	protected $_ci;

	function __construct(){
		$this->_ci = &get_instance();
		$this->_ci->load->model('global_model','',TRUE);
		$this->_ci->load->model('home/auth_model','',TRUE);
		$this->_ci->load->helper('global_helper','',TRUE);
	}
	function ordered_menu($array,$parent_id = 0)
	{
		$temp_array = array();
		foreach($array as $element)
		{
			if($element['menu_parent_id']==$parent_id)
			{
				$element['subs'] = $this->ordered_menu($array,$element['menu_id']);
				$temp_array[] = $element;
			}
		}
		return $temp_array;
	}
	function get_html_sub_menu($array,$parent_id = 0)
	{
		//if($parent_id==0)

		$menu_html = '<ul class="">';
		
		
		foreach($array as $element)
		{
			if($element['menu_parent_id']==$parent_id)
			{

				$getMenuIsParent = $this->_ci->global_model->getMenuIsParent($element['menu_id']);
				$datamenu =  $this->_ci->global_model->getThisMenu($this->_ci->uri->segment(1)."/".$this->_ci->uri->segment(2))->row_array();
				if(count($datamenu)>0){
					$menu_html .= '<li class="'.(($datamenu["menu_id"]==$element["menu_id"])?"active":"").'"><a href="'.(($element['menu_url']!="javascript:void(0);")?base_url().$element['menu_url']:"javascript:void(0);").'">'.(($element['menu_icon']!=null|| $element['menu_icon']!="")?'<i class="'.$element['menu_icon'].'"></i>':'').' <span class="title"> '.$element['menu_name'].' </span>'.(($getMenuIsParent>0)?'':"").' '.(($datamenu["menu_id"]==$element["menu_id"])?'<span class="selected"></span>':"").'</a>';
					$menu_html .= $this->get_html_sub_menu($array,$element['menu_id']);

					$menu_html .= '</li>';
				}else{
					$menu_html .= '<li class=""><a href="'.(($element['menu_url']!="javascript:void(0);")?base_url().$element['menu_url']:"javascript:void(0);").'">'.(($element['menu_icon']!=null|| $element['menu_icon']!="")?'<i class="'.$element['menu_icon'].'"></i>':'').' <span class="title"> '.$element['menu_name'].' </span>'.(($getMenuIsParent>0)?'':"").'</a>';
					$menu_html .= $this->get_html_sub_menu($array,$element['menu_id']);

					$menu_html .= '</li>';
				}
				
			}
		}
		$menu_html .= '</ul>';
		
		return $menu_html;
	}
	function get_html_menu($array,$parent_id = 0)
	{
		
		$menu_html = '<ul class="navigation">';	
		
		foreach($array as $element)
		{
			if($element['menu_parent_id']==$parent_id)
			{

				$getMenuIsParent = $this->_ci->global_model->getMenuIsParent($element['menu_id']);
				$datamenu =  $this->_ci->global_model->getThisMenu($this->_ci->uri->segment(1)."/".$this->_ci->uri->segment(2))->row_array();
				if(count($datamenu)>0){
					$menu_html .= '<li class="'.(($datamenu["menu_id"]==$element["menu_id"] || $datamenu["menu_parent_id"]==$element["menu_id"])?"active":"").'"><a href="'.(($element['menu_url']!="javascript:void(0);")?base_url().$element['menu_url']:"javascript:void(0);").'">'.(($element['menu_icon']!=null|| $element['menu_icon']!="")?'<i class="'.$element['menu_icon'].'"></i>':'').' <span class="title"> '.$element['menu_name'].' </span>'.(($getMenuIsParent>0)?'':"").' '.(($datamenu["menu_id"]==$element["menu_id"] || $datamenu["menu_parent_id"]==$element["menu_id"])?'<span class="selected"></span>':"").'</a>';
					if($getMenuIsParent>0){
						$menu_html .= $this->get_html_sub_menu($array,$element['menu_id']);	

					}
					$menu_html .= '</li>';
				}else{
					$menu_html .= '<li class=""><a href="'.(($element['menu_url']!="javascript:void(0);")?base_url().$element['menu_url']:"javascript:void(0);").'">'.(($element['menu_icon']!=null|| $element['menu_icon']!="")?'<i class="'.$element['menu_icon'].'"></i>':'').' <span class="title"> '.$element['menu_name'].' </span>'.(($getMenuIsParent>0)?'':"").'</a>';
					if($getMenuIsParent>0){
						$menu_html .= $this->get_html_sub_menu($array,$element['menu_id']);	
					}
					$menu_html .= '</li>';
				}
				
			}
		}
		$menu_html .= '</ul>';

						//echo "<pre>";
		 $menu_html = str_replace('<ul class=""></ul>',"",$menu_html);
		
		return $menu_html;
	}
	function get_html_notifikasi($array)
	{
		$menu_html = '<a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" data-close-others="true" href="#">
		<i class="clip-notification-2"></i>
		<span class="badge"> '.count($array).'</span>
	</a>';
	$menu_html .= '<ul class="dropdown-menu notifications">';	
	$menu_html .='<li><span class="dropdown-menu-title"> Anda Memiliki '.count($array).' notifikasi</span></li>';
	$menu_html .='<li><div class="drop-down-wrapper"><ul>';
	if(count($array)>0){
		foreach($array as $element)
		{
			$menu_html .='<li><a href="'.base_url().$element["notif_link"].'">
			<span class="message"> '.$element["notif_message"].'</span>
			<span class="time"> '.timeToTextNotif($element["notif_date"]).'</span>
		</a>
	</li>';
}

}

$menu_html .='</ul></div></li>';
$menu_html .='<li class="view-all">
<a href="'.base_url().'home/notifikasi'.'">
	Lihat Semua Notifikasi <i class="fa fa-arrow-circle-o-right"></i>
</a>
</li></ul>';


return $menu_html;
}
function display($template, $data=null, $ignore=null){
	$accessid = $this->_ci->session->userdata('user_access_id');
	$data_user = $userdata = $this->_ci->auth_model->getUser($this->_ci->session->userdata('user_username'))->row_array();
	$data["photo"] = (($data_user["people_photo"]==null || $data_user["people_photo"] == "")?"defaultphoto.png":$data_user["people_photo"]);
	
	$menu = $this->_ci->global_model->getMenus($accessid)->result_array();
	$html_menu = $this->get_html_menu($menu,0);
	$data["menu"] = $html_menu;
	$datamenu =  $this->_ci->global_model->getThisMenu($this->_ci->uri->segment(1)."/".$this->_ci->uri->segment(2))->row_array();
	$datanotif =  $this->_ci->global_model->get_notifikasi()->result_array();

			//$data["currentmenu"] = 29;
			//$data["currentmenuparent"] = 2;
	$data["breadcrumb"] = "";
	$data["notif"] = $this->get_html_notifikasi($datanotif);
	$data["statusproses"] = $this->_ci->session->flashdata('statusproses');
	$data["message"] = $this->_ci->session->flashdata('message');
	if(count($datamenu)>0){
		$data["currentmenu"] = $datamenu["menu_name"];
		$data["currentmenuparent"] = ($datamenu["menu_parent_id"]==0)?$datamenu["menu_id"]:$datamenu["menu_parent_id"];
		$breadcrumb = $this->_ci->global_model->getbreadcrumb($datamenu["menu_id"])->row_array();
		$data["breadcrumb"] = $breadcrumb["breadcrumb"];
	}
	$data['_content'] = $this->_ci->load->view('/sources/'.$template, $data, TRUE);

	$this->_ci->load->view('/template_render', $data);
}

function single($template, $data=null){
			//$config = $this->_ci->config->config['template'];
	$this->_ci->load->view('/structures/single/'.$template, $data);
}

function printout($data=null){
			//$config = $this->_ci->config->config['template'];
	$this->_ci->load->view('/structures/print_header', $data);
	$this->_ci->load->view('/structures/print_footer');
}
}

?>
