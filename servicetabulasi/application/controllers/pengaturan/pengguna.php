<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengguna extends CI_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('pengaturan/pengguna_model');
		$this->load->helper('xml');
		$this->load->helper('text');
	}

	public function index(){
		$data = array();
		$this->template->display('pengaturan/pengguna/index', $data);
	}

	function update($pggna_id = 0){
		if($this->access->permission('read')){

			if($post = $this->input->post()){
				
				$getSys = $this->pengguna_model->getSysUser($pggna_id)->row_array();
				
				$dataupdatepeople = array(
					'people_fullname' 		=> isset($post['add_name'])?$post['add_name']:'',
					'people_nip'				=> isset($post['add_nip'])?$post['add_nip']:'',
					'people_address'			=> isset($post['add_address'])?$post['add_address']:'',
					'people_phone' 			=> isset($post['add_phone'])?$post['add_phone']:'',
					'people_email' 			=> isset($post['email2'])?$post['email2']:'',
					'people_update_by'		=> $this->session->userdata('user_id'),
					'people_update_date'		=> date('Y-m-d H:i:s')
					);
				$this->pengguna_model->updatepeople($dataupdatepeople,$getSys['user_people_id']);
				$dataupdate = array(
					'user_access_id' 			=> isset($post['add_accld'])?$post['add_accld']:'',
					'user_update_by' 			=> $this->session->userdata('user_id'),
					'user_update_date' 			=> date('Y-m-d H:i:s')
					);

				
				$insDb = $this->pengguna_model->update($dataupdate, $pggna_id);

				if($insDb > 0){
					$notify = array(
						'title' 	=> 'Berhasil!',
						'message' 	=> 'Perubahan pengguna Berhasil',
						'status' 	=> 'success'
						);
					$this->session->set_flashdata('notify', $notify);

					redirect(base_url().'pengaturan/pengguna');
				}else{
					$notify = array(
						'title' 	=> 'Gagal!',
						'message'	=> 'Perubahan pengguna gagal, silahkan coba lagi',
						'status' 	=> 'error'
						);
					$this->session->set_flashdata('notify', $notify);
					redirect(base_url().'pengaturan/pengguna');
				}
			}

			$data = array();
			$data['getDetail']  	= $this->pengguna_model->getDetail($pggna_id)->row_array();
			$data['accList']  		= $this->pengguna_model->getListAcc()->result_array();
			$data['List']  			= $this->pengguna_model->ListAcc()->row_array();
			$this->template->display('pengaturan/pengguna/update', $data);
		}else{
			$this->access->redirect('404');
		}
	}

	public function create(){
		if($this->access->permission('create')){
			
			if($post = $this->input->post()){

				
				$datapostpeople = array(
					'people_fullname' 		=> isset($post['add_name'])?$post['add_name']:'',
					'people_nip'				=> isset($post['add_nip'])?$post['add_nip']:'',
					'people_address'			=> isset($post['add_address'])?$post['add_address']:'',
					'people_phone' 			=> isset($post['add_phone'])?$post['add_phone']:'',
					'people_email' 			=> isset($post['email2'])?$post['email2']:'',
					'people_create_by'		=> $this->session->userdata('user_id'),
					'people_create_date'		=> date('Y-m-d H:i:s'),
					'people_status' 			=> 1
					);

				$peopleid = $this->pengguna_model->addpeople($datapostpeople);
				if($peopleid > 0){
					$datapost = array(
						'user_name' 				=> isset($post['add_username'])?$post['add_username']:'',
						'user_password'				=> isset($post['password'])?passwordEncoder($post['password']):'',
						'user_access_id' 			=> isset($post['add_accld'])?$post['add_accld']:'',
						'user_people_id' 			=> $peopleid,
						'user_create_by' 			=> $this->session->userdata('user_id'),
						'user_create_date' 			=> date('Y-m-d H:i:s'),
						'user_status' 				=> 1
						);
					$insDb = $this->pengguna_model->add($datapost,$datapostpeople);
					if($insDb > 0){
						$notify = array(
							'title' 	=> 'Berhasil!',
							'message' 	=> 'Tambah Pengguna Berhasil',
							'status' 	=> 'success'
							);
						$this->session->set_flashdata('notify', $notify);
						
						redirect(base_url().'pengaturan/pengguna');
					}else{
						$notify = array(
							'title' 	=> 'Gagal!',
							'message' 	=> 'Tambah Pengguna gagal, silahkan coba lagi',
							'status' 	=> 'error'
							);
						$this->session->set_flashdata('notify', $notify);
						
						redirect(base_url().'pengaturan/pengguna');
					}
				}else{
					$notify = array(
						'title' 	=> 'Gagal!',
						'message' 	=> 'Tambah Pengguna gagal, silahkan coba lagi',
						'status' 	=> 'error'
						);
					$this->session->set_flashdata('notify', $notify);
					
					redirect(base_url().'pengaturan/pengguna');
				}
			}
			
			$data = array();
			$data['accList']  	= $this->pengguna_model->getListAcc()->result_array();
			$this->template->display('pengaturan/pengguna/create', $data);
		} else {
			$this->access->redirect('404');
		}
	}
	public function detail($id=0){
		if($this->access->permission('read')){
			$user = $this->pengguna_model->getDetail($id)->row_array();
			$data["pengguna"] = $user;
			$this->template->display('pengaturan/pengguna/detail', $data);
		}
	}

	public function listdataaktif(){
		$default_order = "user_name";
		$limit = 10;

		$order_field 	= array(
			'user_id',
			'user_name',
			'people_fullname',
			'access_name',
			'user_status_name',
			);
		$order_key 	= ($this->input->get('iSortCol_0')=="0")?"0":$this->input->get('iSortCol_0');
		$order 		= (!$this->input->get('iSortCol_0'))?$default_order:$order_field[$order_key];
		$sort 		= (!$this->input->get('sSortDir_0'))?'asc':$this->input->get('sSortDir_0');
		$search 	= (!$this->input->get('sSearch'))?'':strtoupper($this->input->get('sSearch'));
		$limit 		= (!$this->input->get('iDisplayLength'))?$limit:$this->input->get('iDisplayLength');
		$start 		= (!$this->input->get('iDisplayStart'))?0:$this->input->get('iDisplayStart');
		$data['sEcho'] = $this->input->get('sEcho');
		$data['iTotalRecords'][] = $this->pengguna_model->count_all($search,$order_field);
		$data['iTotalDisplayRecords'][] = $this->pengguna_model->count_all($search,$order_field);


		$aaData = array();
		$getData 	= $this->pengguna_model->get_paged_list($limit, $start, $order, $sort, $search, $order_field)->result_array();
		$no = (($start == 0) ? 1 : $start + 1);
		foreach ($getData as $row) {
			$aaData[] = array(
				'<center>'.$no.'</center>',
				$row["user_name"],
				$row["people_fullname"],
				$row["access_name"],
				$row["user_status_name"],
				'<a href="'.base_url().'pengaturan/pengguna/detail/'.$row["user_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Lihat" data-placement="top"><i class="icon-file6"></i></a>
				<a href="'.base_url().'pengaturan/pengguna/update/'.$row["user_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Edit" data-placement="top"><i class="icon-pencil"></i></a>
				<a href="'.base_url().'pengaturan/pengguna/delete/'.$row["user_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Non Aktifkan" data-placement="top"><i class="icon-close"></i></a>');
			$no++;
		}
		$data['aaData'] = $aaData;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function listdatanonaktif(){
		$default_order = "user_name";
		$limit = 10;

		$order_field 	= array(
			'user_id',
			'user_name',
			'people_fullname',
			'access_name',
			'user_status_name',
			);
		$order_key 	= ($this->input->get('iSortCol_0')=="0")?"0":$this->input->get('iSortCol_0');
		$order 		= (!$this->input->get('iSortCol_0'))?$default_order:$order_field[$order_key];
		$sort 		= (!$this->input->get('sSortDir_0'))?'asc':$this->input->get('sSortDir_0');
		$search 	= (!$this->input->get('sSearch'))?'':strtoupper($this->input->get('sSearch'));
		$limit 		= (!$this->input->get('iDisplayLength'))?$limit:$this->input->get('iDisplayLength');
		$start 		= (!$this->input->get('iDisplayStart'))?0:$this->input->get('iDisplayStart');
		$data['sEcho'] = $this->input->get('sEcho');
		$data['iTotalRecords'][] = $this->pengguna_model->count_allnonaktif($search,$order_field);
		$data['iTotalDisplayRecords'][] = $this->pengguna_model->count_allnonaktif($search,$order_field);


		$aaData = array();
		$getData 	= $this->pengguna_model->get_paged_listnonaktif($limit, $start, $order, $sort, $search, $order_field)->result_array();
		$no = (($start == 0) ? 1 : $start + 1);
		foreach ($getData as $row) {
			$aaData[] = array(
				'<center>'.$no.'</center>',
				$row["user_name"],
				$row["people_fullname"],
				$row["access_name"],
				$row["user_status_name"],
				'<a href="'.base_url().'pengaturan/pengguna/detail/'.$row["user_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Lihat" data-placement="top"><i class="icon-file6"></i></a> '.
				'<a href="'.base_url().'pengaturan/pengguna/aktif/'.$row["user_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Aktifkan" data-placement="top"><i class="icon-checkmark3"></i></a>');
			$no++;
		}
		$data['aaData'] = $aaData;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function delete($pggna_id = 0){

		$pggna_idFilter = filter_var($pggna_id, FILTER_SANITIZE_NUMBER_INT);
		if($this->access->permission('delete')) {
			if($pggna_id==$pggna_idFilter) {

				$dataupdate = array(
					'user_update_by' 			=> $this->session->userdata('user_id'),
					'user_update_date' 			=> date('Y-m-d H:i:s')
					);

				$del = $this->pengguna_model->deleteuser($pggna_id, $dataupdate);
				$notify = array(
					'title' 	=> 'Berhasil!',
					'message' 	=> 'Pengguna dinonaktifkan',
					'status' 	=> 'success'
					);
				$this->session->set_flashdata('notify', $notify);

				redirect(base_url().'pengaturan/pengguna');
			} else {
				$notify = array(
					'title' 	=> 'Gagal!',
					'message' 	=> 'Pengguna gagal dinonaktifkan',
					'status' 	=> 'error'
					);
				$this->session->set_flashdata('notify', $notify);
				redirect(base_url().'pengaturan/pengguna');
			}
		} else {
			$notify = array(
				'title' 	=> 'Gagal!',
				'message' 	=> 'Pengguna gagal dinonaktifkan',
				'status' 	=> 'error'
				);
			$this->session->set_flashdata('notify', $notify);
			redirect(base_url().'pengaturan/pengguna');
		}
	}

	public function aktif($pggna_id = 0){

		$pggna_idFilter = filter_var($pggna_id, FILTER_SANITIZE_NUMBER_INT);
		if($this->access->permission('update')) {
			if($pggna_id==$pggna_idFilter) {

				$dataupdate = array(
					'user_update_by' 			=> $this->session->userdata('user_id'),
					'user_update_date' 			=> date('Y-m-d H:i:s')
					);

				$del = $this->pengguna_model->aktifuser($pggna_id, $dataupdate);
				$notify = array(
					'title' 	=> 'Berhasil!',
					'message' 	=> 'Pengguna diaktifkan',
					'status' 	=> 'success'
					);
				$this->session->set_flashdata('notify', $notify);

				redirect(base_url().'pengaturan/pengguna');
			} else {
				$notify = array(
					'title' 	=> 'Gagal!',
					'message' 	=> 'Pengguna gagal diaktifkan',
					'status' 	=> 'error'
					);
				$this->session->set_flashdata('notify', $notify);
				redirect(base_url().'pengaturan/pengguna');
			}
		} else {
			$notify = array(
				'title' 	=> 'Gagal!',
				'message' 	=> 'Pengguna gagal diaktifkan',
				'status' 	=> 'error'
				);
			$this->session->set_flashdata('notify', $notify);
			redirect(base_url().'pengaturan/pengguna');
		}
	}
}