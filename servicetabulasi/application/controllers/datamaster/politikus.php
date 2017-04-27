<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Politikus extends CI_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('datamaster/politikus_model');
		$this->load->helper('xml');
		$this->load->helper('text');
	}

	 public function index(){
		 $data = array();
		 $this->template->display('datamaster/politikus/index', $data);
	}

	function update($politicianId = 0){
		if($this->access->permission('read')){

			if($post = $this->input->post()){
				
				$getMaster = $this->politikus_model->getMasterPolitician($politicianId)->row_array();
				
				$dataupdate = array(
					'politician_nik' 		=> isset($post['add_nik'])?$post['add_nik']:'',
					'politician_name_first'				=> isset($post['add_nama_depan'])?$post['add_nama_depan']:'',
					'politician_name_last'		=> isset($post['add_nama_belakang'])?$post['add_nama_belakang']:'',
					'politician_name_alias'			=> isset($post['add_nama_alias'])?$post['add_nama_alias']:'',
					'politician_title_prefix' 			=> isset($post['add_title_prefix'])?$post['add_title_prefix']:'',
					'politician_title_suffix' 			=> isset($post['add_title_suffix'])?$post['add_title_suffix']:'',
					'politician_create_user_id'		=> $this->session->userdata('user_id'),
					'politician_create_date'		=> date('Y-m-d H:i:s'),
					'politician_status' 			=> 1
					);
				
				$insDb = $this->politikus_model->update($dataupdate, $politicianId);

				if($insDb > 0){
					$notify = array(
						'title' 	=> 'Berhasil!',
						'message' 	=> 'Perubahan Politikus Berhasil',
						'status' 	=> 'success'
						);
					$this->session->set_flashdata('notify', $notify);

					redirect(base_url().'datamaster/politikus');
				}else{
					$notify = array(
						'title' 	=> 'Gagal!',
						'message'	=> 'Perubahan Politikus gagal, silahkan coba lagi',
						'status' 	=> 'error'
						);
					$this->session->set_flashdata('notify', $notify);
					redirect(base_url().'datamaster/politikus');
				}
			}

			$data = array();
			$data['getDetail']  	= $this->politikus_model->getDetail($politicianId)->row_array();
			$data['accList']  		= $this->politikus_model->getListAcc()->result_array();
			$data['List']  			= $this->politikus_model->ListAcc()->row_array();
			$this->template->display('datamaster/politikus/update', $data);
		}else{
			$this->access->redirect('404');
		}
	}

	public function create(){
		if($this->access->permission('create')){
			
			if($post = $this->input->post()){

				$datapostpolitician = array(
					'politician_nik' 		=> isset($post['add_nik'])?$post['add_nik']:'',
					'politician_name_first'				=> isset($post['add_nama_depan'])?$post['add_nama_depan']:'',
					'politician_name_last'		=> isset($post['add_nama_belakang'])?$post['add_nama_belakang']:'',
					'politician_name_alias'			=> isset($post['add_nama_alias'])?$post['add_nama_alias']:'',
					'politician_title_prefix' 			=> isset($post['add_title_prefix'])?$post['add_title_prefix']:'',
					'politician_title_suffix' 			=> isset($post['add_title_suffix'])?$post['add_title_suffix']:'',
					'politician_create_user_id'		=> $this->session->userdata('user_id'),
					'politician_create_date'		=> date('Y-m-d H:i:s'),
					'politician_status' 			=> 1
					);
					
					$insDb = $this->politikus_model->addPolitician($datapostpolitician);

				if($insDb > 0){
					$notify = array(
							'title' 	=> 'Berhasil!',
							'message' 	=> 'Tambah Data Politikus Berhasil',
							'status' 	=> 'success'
						);
					$this->session->set_flashdata('notify', $notify);

					redirect(base_url().'datamaster/politikus');
				}else{
					$notify = array(
							'title' 	=> 'Gagal!',
							'message' 	=> 'Tambah Data Politikus  gagal, silahkan coba lagi',
							'status' 	=> 'error'
						);
					$this->session->set_flashdata('notify', $notify);
					redirect(base_url().'datamaster/politikus');
				}
			}
			
			$data = array();
			$data['accList']  	= $this->politikus_model->getListAcc()->result_array();
			$this->template->display('datamaster/politikus/create', $data);
		} else {
			$this->access->redirect('404');
		}
	}

	public function listdataaktif(){
		$default_order = "politician_name_first";
		$limit = 10;

		$order_field 	= array(
			'politician_id',
			'politician_nik',
			'politician_name_first',
			'politician_name_last',
			'politician_name_alias',
			);
		$order_key 	= ($this->input->get('iSortCol_0')=="0")?"0":$this->input->get('iSortCol_0');
		$order 		= (!$this->input->get('iSortCol_0'))?$default_order:$order_field[$order_key];
		$sort 		= (!$this->input->get('sSortDir_0'))?'asc':$this->input->get('sSortDir_0');
		$search 	= (!$this->input->get('sSearch'))?'':strtoupper($this->input->get('sSearch'));
		$limit 		= (!$this->input->get('iDisplayLength'))?$limit:$this->input->get('iDisplayLength');
		$start 		= (!$this->input->get('iDisplayStart'))?0:$this->input->get('iDisplayStart');
		$data['sEcho'] = $this->input->get('sEcho');
		$data['iTotalRecords'][] = $this->politikus_model->count_all($search,$order_field);
		$data['iTotalDisplayRecords'][] = $this->politikus_model->count_all($search,$order_field);


		$aaData = array();
		$getData 	= $this->politikus_model->get_paged_list($limit, $start, $order, $sort, $search, $order_field)->result_array();
		$no = (($start == 0) ? 1 : $start + 1);
		foreach ($getData as $row) {
			$aaData[] = array(
				'<center>'.$no.'</center>',
				$row["politician_nik"],
				$row["politician_name_first"],
				$row["politician_name_last"],
				$row["politician_name_alias"],
				'<a href="'.base_url().'datamaster/politikus/detail/'.$row["politician_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Lihat" data-placement="top"><i class="icon-file6"></i></a>
				<a href="'.base_url().'datamaster/politikus/update/'.$row["politician_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Edit" data-placement="top"><i class="icon-pencil"></i></a>
				<a href="'.base_url().'datamaster/politikus/delete/'.$row["politician_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Non Aktifkan" data-placement="top"><i class="icon-close"></i></a>');
			$no++;
		}
		$data['aaData'] = $aaData;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function listdatanonaktif(){
		$default_order = "politician_name_first";
		$limit = 10;

		$order_field 	= array(
			'politician_id',
			'politician_nik',
			'politician_name_first',
			'politician_name_last',
			'politician_name_alias',
			);
		$order_key 	= ($this->input->get('iSortCol_0')=="0")?"0":$this->input->get('iSortCol_0');
		$order 		= (!$this->input->get('iSortCol_0'))?$default_order:$order_field[$order_key];
		$sort 		= (!$this->input->get('sSortDir_0'))?'asc':$this->input->get('sSortDir_0');
		$search 	= (!$this->input->get('sSearch'))?'':strtoupper($this->input->get('sSearch'));
		$limit 		= (!$this->input->get('iDisplayLength'))?$limit:$this->input->get('iDisplayLength');
		$start 		= (!$this->input->get('iDisplayStart'))?0:$this->input->get('iDisplayStart');
		$data['sEcho'] = $this->input->get('sEcho');
		$data['iTotalRecords'][] = $this->politikus_model->count_allnonaktif($search,$order_field);
		$data['iTotalDisplayRecords'][] = $this->politikus_model->count_allnonaktif($search,$order_field);


		$aaData = array();
		$getData 	= $this->politikus_model->get_paged_listnonaktif($limit, $start, $order, $sort, $search, $order_field)->result_array();
		$no = (($start == 0) ? 1 : $start + 1);
		foreach ($getData as $row) {
			$aaData[] = array(
				'<center>'.$no.'</center>',
				$row["politician_nik"],
				$row["politician_name_first"],
				$row["politician_name_last"],
				$row["politician_name_alias"],
				'<a href="'.base_url().'datamaster/politikus/detail/'.$row["politician_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Lihat" data-placement="top"><i class="icon-file6"></i></a> '.
				'<a href="'.base_url().'datamaster/politikus/aktif/'.$row["politician_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Aktifkan" data-placement="top"><i class="icon-checkmark3"></i></a>');
			$no++;
		}
		$data['aaData'] = $aaData;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function detail($id=0){
		if($this->access->permission('read')){
			$politikusId = $this->politikus_model->getDetail($id)->row_array();
			$data["politikus"] = $politikusId;
			$this->template->display('datamaster/politikus/detail', $data);
		}
	}

	public function delete($politicianId = 0){

		$politicianIdFilter = filter_var($politicianId, FILTER_SANITIZE_NUMBER_INT);
		if($this->access->permission('delete')) {
			if($politicianId==$politicianIdFilter) {

				$del = $this->politikus_model->deletePolitician($politicianId);
				$notify = array(
					'title' 	=> 'Berhasil!',
					'message' 	=> 'Pengguna dinonaktifkan',
					'status' 	=> 'success'
					);
				$this->session->set_flashdata('notify', $notify);

				redirect(base_url().'datamaster/politikus');
			} else {
				$notify = array(
					'title' 	=> 'Gagal!',
					'message' 	=> 'Pengguna gagal dinonaktifkan',
					'status' 	=> 'error'
					);
				$this->session->set_flashdata('notify', $notify);
				redirect(base_url().'datamaster/politikus');
			}
		} else {
			$notify = array(
				'title' 	=> 'Gagal!',
				'message' 	=> 'Pengguna gagal dinonaktifkan',
				'status' 	=> 'error'
				);
			$this->session->set_flashdata('notify', $notify);
			redirect(base_url().'datamaster/politikus');
		}
	}

	public function aktif($politicianId = 0){

		$politicianIdFilter = filter_var($politicianId, FILTER_SANITIZE_NUMBER_INT);
		if($this->access->permission('update')) {
			if($politicianId==$politicianIdFilter) {


				$del = $this->politikus_model->aktifPolitician($politicianId);
				$notify = array(
					'title' 	=> 'Berhasil!',
					'message' 	=> 'Politikus diaktifkan',
					'status' 	=> 'success'
					);
				$this->session->set_flashdata('notify', $notify);

				redirect(base_url().'datamaster/politikus');
			} else {
				$notify = array(
					'title' 	=> 'Gagal!',
					'message' 	=> 'Politikus gagal diaktifkan',
					'status' 	=> 'error'
					);
				$this->session->set_flashdata('notify', $notify);
				redirect(base_url().'datamaster/politikus');
			}
		} else {
			$notify = array(
				'title' 	=> 'Gagal!',
				'message' 	=> 'Politikus gagal diaktifkan',
				'status' 	=> 'error'
				);
			$this->session->set_flashdata('notify', $notify);
			redirect(base_url().'datamaster/politikus');
		}
	}
}