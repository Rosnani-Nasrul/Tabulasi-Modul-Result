<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hak_akses extends CI_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('pengaturan/hakakses_model');
		$this->load->model('access_model');
		$this->load->helper('xml');
		$this->load->helper('text');
	}

	public function index(){
		$data = array();
		$this->template->display('pengaturan/hak_akses/index', $data);
	}
	public function create(){
		if($this->access->permission('create')){

			if($post = $this->input->post()){
				$create  = $this->input->post('create');
				$read 	 = $this->input->post('read');
				$update  = $this->input->post('update');
				$delete  = $this->input->post('delete');
				$approve = $this->input->post('approve');
				$print   = $this->input->post('print');


				$datapost = array(
					'access_name' 				=> isset($post['add_accname'])?$post['add_accname']:'',
					'access_create_by'		 	=> $this->session->userdata('user_id'),
					'access_create_date' 		=> date('Y-m-d H:i:s'),
					'access_status' 			=> 1
					);

				//Insert to Table sys_accesses
				$sysacc = $this->hakakses_model->add($datapost);

				$dataAccDetail 	= array();
				$newarray 		= array_slice($post, 1, -1);
				$keyarr   		= array_keys($newarray);

				$x=0;

				for ($i=0; $i < count($read); $i++) { 
					$dataAccDetail = array(
						'access_detail_menu_id' 	=> $read[$i],
						'access_detail_access_id'   => $sysacc,
						'access_detail_can_read'    => 1,
						'access_detail_status' 	   	=> 1,
						); 	
					$this->hakakses_model->addDetail($dataAccDetail);
				}

				for ($i=0; $i < count($create); $i++) { 
					$dataupdate = array(
						'access_detail_can_create'    => 1
						); 	
					$this->hakakses_model->updateDetail($create[$i],$sysacc,$dataupdate);
				}

				for ($i=0; $i < count($update); $i++) { 
					$dataupdate = array(
						'access_detail_can_update'    => 1
						); 	
					$this->hakakses_model->updateDetail($update[$i],$sysacc,$dataupdate);
				}

				for ($i=0; $i < count($delete); $i++) { 
					$dataupdate = array(
						'access_detail_can_delete'    => 1
						); 	
					$this->hakakses_model->updateDetail($delete[$i],$sysacc,$dataupdate);
				}

				for ($i=0; $i < count($approve); $i++) { 
					$dataupdate = array(
						'access_detail_can_approve'   => 1
						); 	
					$this->hakakses_model->updateDetail($approve[$i],$sysacc,$dataupdate);
				}

				for ($i=0; $i < count($print); $i++) { 
					$dataupdate = array(
						'access_detail_can_print'    => 1
						); 	
					$this->hakakses_model->updateDetail($print[$i],$sysacc,$dataupdate);
				}

				if($sysacc > 0){
					$notify = array(
						'title' 	=> 'Berhasil!',
						'message' 	=> 'Tambah Hak Akses Berhasil',
						'status' 	=> 'success'
						);
					$this->session->set_flashdata('notify', $notify);

					redirect(base_url().'pengaturan/hak_akses');
				}else{
					$notify = array(
						'title' 	=> 'Gagal!',
						'message' 	=> 'Tambah Hak Akses gagal, silahkan coba lagi',
						'status' 	=> 'error'
						);
					$this->session->set_flashdata('notify', $notify);
					redirect(base_url().'pengaturan/hak_akses');
				}
			}
			
			$data = array();
			$datamenus = array();
			$menuinduk = $this->hakakses_model->get_listmenu_induk(0)->result_array();
			//array_push($datamenus, $menuinduk);

			foreach ($menuinduk as $k => $v) {
				$menuanak = $this->hakakses_model->get_listmenu_anak($v["menu_id"],$v['menu_sort'])->result_array();
				$datamenus[] = $v;
				foreach ($menuanak as $key => $val) {
					array_push($menuinduk, $val);
					$datamenus[] = $val;
				}
			}

			function cmp($a, $b)
			{
				return strcmp($a["menu_sort"], $b["menu_sort"]);
			}

			//usort($menuinduk, "cmp");

			$data['datamenus'] 		= $datamenus;
			$data['hakaksesList']  	= $this->hakakses_model->getListhakakses()->result_array();
			$data['aksesList']  	= $this->hakakses_model->getlistakses()->result_array();
			$this->template->display('pengaturan/hak_akses/create', $data);
		} else {
			$this->access->redirect('404');
		}
	}
	public function detail($idakses = 0){
		if($this->access->permission('read')){
			$data = array();
			$datamenus = array();
			$menuinduk = $this->hakakses_model->get_listmenu_induk(0)->result_array();
			//array_push($datamenus, $menuinduk);

			foreach ($menuinduk as $k => $v) {
				$menuanak = $this->hakakses_model->get_listmenu_anak($v["menu_id"],$v['menu_sort'])->result_array();
				$datamenus[] = $v;
				foreach ($menuanak as $key => $val) {
					array_push($menuinduk, $val);
					$datamenus[] = $val;
					# code...val
				}
			}

			function cmp($a, $b)
			{
				return strcmp($a["menu_sort"], $b["menu_sort"]);
			}

			//usort($menuinduk, "cmp");
			
			$data['datamenus'] 		= $datamenus;
			$data['getDetail']  	= $this->hakakses_model->getDetailhakakses($idakses)->row_array();
			$data['dataakses']  	= $this->hakakses_model->getDetailakses($idakses)->result_array();

			$this->template->display('pengaturan/hak_akses/detail', $data);
		} else {
			$this->access->redirect('404');
		}
	}
	public function update($idakses = 0){
		if($this->access->permission('read')){
			
			if($post = $this->input->post()){

				$create  = $this->input->post('create');
				$read 	 = $this->input->post('read');
				$update  = $this->input->post('update');
				$delete  = $this->input->post('delete');
				$approve = $this->input->post('approve');
				$print   = $this->input->post('print');
				

				$dataupdate = array(
					'access_name' 				=> isset($post['add_accname'])?$post['add_accname']:'',
					'access_update_by' 			=> $this->session->userdata('user_id'),
					'access_update_date' 		=> date('Y-m-d H:i:s'),
					);

				$this->hakakses_model->update($idakses, $dataupdate);

				$dataAccDetail 	= array();

				$x=0;
				$this->hakakses_model->delete_detail($idakses);
				for ($i=0; $i < count($read); $i++) { 
					$dataAccDetail = array(
						'access_detail_menu_id' 	=> $read[$i],
						'access_detail_access_id'   => $idakses,
						'access_detail_can_read'    => 1,
						'access_detail_status' 	   	=> 1,
						); 	
					$this->hakakses_model->addDetail($dataAccDetail);
				}

				for ($i=0; $i < count($create); $i++) { 
					$dataupdate = array(
						'access_detail_can_create'    => 1
						); 	
					$this->hakakses_model->updateDetail($create[$i],$idakses,$dataupdate);
				}

				for ($i=0; $i < count($update); $i++) { 
					$dataupdate = array(
						'access_detail_can_update'    => 1
						); 	
					$this->hakakses_model->updateDetail($update[$i],$idakses,$dataupdate);
				}

				for ($i=0; $i < count($delete); $i++) { 
					$dataupdate = array(
						'access_detail_can_delete'    => 1
						); 	
					$this->hakakses_model->updateDetail($delete[$i],$idakses,$dataupdate);
				}

				for ($i=0; $i < count($approve); $i++) { 
					$dataupdate = array(
						'access_detail_can_approve'    => 1
						); 	
					$this->hakakses_model->updateDetail($approve[$i],$idakses,$dataupdate);
				}

				for ($i=0; $i < count($print); $i++) { 
					$dataupdate = array(
						'access_detail_can_print'    => 1
						); 	
					$this->hakakses_model->updateDetail($print[$i],$idakses,$dataupdate);
				}

				if($idakses > 0){
					$notify = array(
						'title' 	=> 'Berhasil!',
						'message' 	=> 'Ubah Hak Akses Berhasil',
						'status' 	=> 'success'
						);
					$this->session->set_flashdata('notify', $notify);

					redirect(base_url().'pengaturan/hak_akses');
				}else{
					$notify = array(
						'title' 	=> 'Gagal!',
						'message' 	=> 'Ubah Hak Akses gagal, silahkan coba lagi',
						'status' 	=> 'error'
						);
					$this->session->set_flashdata('notify', $notify);
					redirect(base_url().'pengaturan/hak_akses');
				}
			}
			
			$data = array();
			$datamenus = array();
			$menuinduk = $this->hakakses_model->get_listmenu_induk(0)->result_array();
			//array_push($datamenus, $menuinduk);

			foreach ($menuinduk as $k => $v) {
				$menuanak = $this->hakakses_model->get_listmenu_anak($v["menu_id"],$v['menu_sort'])->result_array();
				$datamenus[] = $v;
				foreach ($menuanak as $key => $val) {
					array_push($menuinduk, $val);
					$datamenus[] = $val;
					# code...val
				}
			}

			function cmp($a, $b)
			{
				return strcmp($a["menu_sort"], $b["menu_sort"]);
			}

			//usort($menuinduk, "cmp");
			
			$data['datamenus'] 		= $datamenus;
			$data['getDetail']  	= $this->hakakses_model->getDetailhakakses($idakses)->row_array();
			$data['dataakses']  	= $this->hakakses_model->getDetailakses($idakses)->result_array();

			$this->template->display('pengaturan/hak_akses/update', $data);
		} else {
			$this->access->redirect('404');
		}
	}
	public function listdataaktif(){
		$default_order = "aksesid";
		$limit = 10;

		$order_field 	= array(
			'aksesid',
			'namaakses',
			'totalUser',
			'totalMenu',
			'access_status_name',
			);
		$order_key 	= ($this->input->get('iSortCol_0')=="0")?"0":$this->input->get('iSortCol_0');
		$order 		= (!$this->input->get('iSortCol_0'))?$default_order:$order_field[$order_key];
		$sort 		= (!$this->input->get('sSortDir_0'))?'asc':$this->input->get('sSortDir_0');
		$search 	= (!$this->input->get('sSearch'))?'':strtoupper($this->input->get('sSearch'));
		$limit 		= (!$this->input->get('iDisplayLength'))?$limit:$this->input->get('iDisplayLength');
		$start 		= (!$this->input->get('iDisplayStart'))?0:$this->input->get('iDisplayStart');
		$data['sEcho'] = $this->input->get('sEcho');
		$data['iTotalRecords'][] = $this->hakakses_model->count_all($search,$order_field);
		$data['iTotalDisplayRecords'][] = $this->hakakses_model->count_all($search,$order_field);


		$aaData = array();
		$getData 	= $this->hakakses_model->get_paged_list($limit, $start, $order, $sort, $search, $order_field)->result_array();
		$no = (($start == 0) ? 1 : $start + 1);
		foreach ($getData as $row) {
			$aaData[] = array(
				'<center>'.$no.'</center>',
				$row["namaakses"],
				$row["totalUser"],
				$row["totalMenu"],
				$row["access_status_name"],
				'<a href="'.base_url().'pengaturan/hak_akses/detail/'.$row["aksesid"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Lihat" data-placement="top"><i class="icon-file6"></i></a>
				<a href="'.base_url().'pengaturan/hak_akses/update/'.$row["aksesid"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Edit" data-placement="top"><i class="icon-pencil"></i></a>
				<a href="'.base_url().'pengaturan/hak_akses/delete/'.$row["aksesid"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Non Aktifkan" data-placement="top"><i class="icon-close"></i></a>');
			$no++;
		}
		$data['aaData'] = $aaData;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
	public function delete($idakses = 0){

		$idaksesFilter = filter_var($idakses, FILTER_SANITIZE_NUMBER_INT);
		if($this->access->permission('delete')) {
			if($idakses==$idaksesFilter) {

				$dataupdate = array(
					'access_update_by' 			=> $this->session->userdata('user_id'),
					'access_update_date' 		=> date('Y-m-d H:i:s')
					);
				$del = $this->hakakses_model->deleteakses($idakses, $dataupdate);

				$notify = array(
					'title' 	=> 'Berhasil!',
					'message' 	=> 'Hak Akses Berhasil dinonaktifkan',
					'status' 	=> 'success'
					);
				$this->session->set_flashdata('notify', $notify);

				redirect(base_url().'pengaturan/hak_akses');
			} else {
				$notify = array(
					'title' 	=> 'Gagal!',
					'message' 	=> 'Hak Akses gagal dinonaktifkan',
					'status' 	=> 'error'
					);
				$this->session->set_flashdata('notify', $notify);
				redirect(base_url().'pengaturan/hak_akses');
			}
		} else {
			$notify = array(
				'title' 	=> 'Gagal!',
				'message' 	=> 'Hak Akses gagal dinonaktifkan',
				'status'	=> 'error'
				);
			$this->session->set_flashdata('notify', $notify);
			redirect(base_url().'pengaturan/hak_akses');
		}
	}

	public function aktif($idakses = 0){

		$idaksesFilter = filter_var($idakses, FILTER_SANITIZE_NUMBER_INT);
		if($this->access->permission('update')) {
			if($idakses==$idaksesFilter) {

				$dataupdate = array(
					'access_update_by' 			=> $this->session->userdata('user_id'),
					'access_update_date' 		=> date('Y-m-d H:i:s')
					);

				$del = $this->hakakses_model->aktifakses($idakses, $dataupdate);
				$notify = array(
					'title' 	=> 'Berhasil!',
					'message' 	=> 'Hak akses diaktifkan',
					'status' 	=> 'success'
					);
				$this->session->set_flashdata('notify', $notify);

				redirect(base_url().'pengaturan/hak_akses');
			} else {
				$notify = array(
					'title' 	=> 'Gagal!',
					'message' 	=> 'Hak akses gagal diaktifkan',
					'status' 	=> 'error'
					);
				$this->session->set_flashdata('notify', $notify);
				redirect(base_url().'pengaturan/hak_akses');
			}
		} else {
			$notify = array(
				'title' 	=> 'Gagal!',
				'message' 	=> 'Hak akses gagal diaktifkan',
				'status' 	=> 'error'
				);
			$this->session->set_flashdata('notify', $notify);
			redirect(base_url().'pengaturan/hak_akses');
		}
	}

	public function listdatanonaktif(){
		$default_order = "aksesid";
		$limit = 10;

		$order_field 	= array(
			'aksesid',
			'namaakses',
			'totalUser',
			'totalMenu',
			'access_status_name',
			);
		$order_key 	= ($this->input->get('iSortCol_0')=="0")?"0":$this->input->get('iSortCol_0');
		$order 		= (!$this->input->get('iSortCol_0'))?$default_order:$order_field[$order_key];
		$sort 		= (!$this->input->get('sSortDir_0'))?'asc':$this->input->get('sSortDir_0');
		$search 	= (!$this->input->get('sSearch'))?'':strtoupper($this->input->get('sSearch'));
		$limit 		= (!$this->input->get('iDisplayLength'))?$limit:$this->input->get('iDisplayLength');
		$start 		= (!$this->input->get('iDisplayStart'))?0:$this->input->get('iDisplayStart');
		$data['sEcho'] = $this->input->get('sEcho');
		$data['iTotalRecords'][] = $this->hakakses_model->count_allnonaktif($search,$order_field);
		$data['iTotalDisplayRecords'][] = $this->hakakses_model->count_allnonaktif($search,$order_field);


		$aaData = array();
		$getData 	= $this->hakakses_model->get_paged_listnonaktif($limit, $start, $order, $sort, $search, $order_field)->result_array();
		$no = (($start == 0) ? 1 : $start + 1);
		foreach ($getData as $row) {
			$aaData[] = array(
				'<center>'.$no.'</center>',
				$row["namaakses"],
				$row["totalUser"],
				$row["totalMenu"],
				$row["access_status_name"],
				'<a href="'.base_url().'pengaturan/hak_akses/detail/'.$row["aksesid"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Lihat" data-placement="top"><i class="icon-file6"></i></a> '.
				'<a href="'.base_url().'pengaturan/hak_akses/aktif/'.$row["aksesid"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Aktifkan" data-placement="top"><i class="icon-checkmark3"></i></a>');
			$no++;
		}
		$data['aaData'] = $aaData;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
}