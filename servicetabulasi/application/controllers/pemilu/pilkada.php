<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pilkada extends CI_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('pemilu/pilkada_model');
		$this->load->helper('xml');
		$this->load->helper('text');
	}

	public function index(){
		$data = array();
		$this->template->display('pemilu/kepaladaerah/pilkada/index', $data);
	}

	function update($pilkadaId = 0){
		if($this->access->permission('read')){

			if($post = $this->input->post()){
				
				$getTrx = $this->pilkada_model->getTrxPilkada($pilkadaId)->row_array();
				
				$dataupdatepilkada = array(
					'pilkada_code' 				=> isset($post['add_code'])?$post['add_code']:'',
					'pilkada_level' 			=> isset($post['add_level'])?$post['add_level']:'',
					'pilkada_name'				=> isset($post['add_name'])?$post['add_name']:'',
					'pilkada_periode_start'		=> isset($post['add_start'])?$post['add_start']:'',
					'pilkada_periode_end'		=> isset($post['add_end'])?$post['add_end']:'',
					'pilkada_area_id' 			=> isset($post['add_lok'])?$post['add_lok']:'',
					);
				// $this->pengguna_model->updatePilkada($dataupdatepilkada,$getTrx['pilkada_area_id']);
				// $dataupdate = array(
				// 	'user_access_id' 			=> isset($post['add_accld'])?$post['add_accld']:'',
				// 	'user_update_by' 			=> $this->session->userdata('user_id'),
				// 	'user_update_date' 			=> date('Y-m-d H:i:s')
				// 	);

				
				$insDb = $this->pilkada_model->updatePilkada($dataupdatepilkada, $pilkadaId);

				if($insDb > 0){
					$notify = array(
						'title' 	=> 'Berhasil!',
						'message' 	=> 'Perubahan Data Pilkada Berhasil',
						'status' 	=> 'success'
						);
					$this->session->set_flashdata('notify', $notify);

					redirect(base_url().'pemilu/pilkada');
				}else{
					$notify = array(
						'title' 	=> 'Gagal!',
						'message'	=> 'Perubahan Data Pilkada gagal, silahkan coba lagi',
						'status' 	=> 'error'
						);
					$this->session->set_flashdata('notify', $notify);
					redirect(base_url().'pemilu/pilkada');
				}
			}

			$data = array();
			$data['getDetail']  	= $this->pilkada_model->getDetail($pilkadaId)->row_array();
			$data['provinceList']  	= $this->pilkada_model->getListProvince()->result_array();
			// $data['accList']  		= $this->pilkada_model->getListAcc()->result_array();
			// $data['List']  			= $this->pilkada_model->ListAcc()->row_array();
			$this->template->display('pemilu/kepaladaerah/pilkada/update', $data);
		}else{
			$this->access->redirect('404');
		}
	}

	public function create(){
		if($this->access->permission('create')){
			
			if($post = $this->input->post()){

				
				$datapostpilkada = array(
					'pilkada_code' 				=> isset($post['add_code'])?$post['add_code']:'',
					'pilkada_level' 			=> isset($post['add_level'])?$post['add_level']:'',
					'pilkada_name'				=> isset($post['add_name'])?$post['add_name']:'',
					'pilkada_periode_start'		=> isset($post['add_start'])?$post['add_start']:'',
					'pilkada_periode_end'		=> isset($post['add_end'])?$post['add_end']:'',
					'pilkada_area_id' 			=> isset($post['add_lok'])?$post['add_lok']:'',
					'pilkada_create_user_id'	=> $this->session->userdata('user_id'),
					'pilkada_create_date' 		=> date('Y-m-d H:i:s'),
					'pilkada_status' 			=> 1
					);

				// $provinceId = $this->pilkada_model->addProvince($datapostprovince);
				// if($provinceId > 0){
				// 	$datapost = array(
				// 		'pilkada_code' 				=> isset($post['add_code'])?$post['add_code']:'',
				// 		'pilkada_name'				=> isset($post['add_name'])?$post['add_name']:'',
				// 		'pilkada_periode_start'		=> isset($post['add_start'])?$post['add_start']:'',
				// 		'pilkada_periode_end'		=> isset($post['add_end'])?$post['add_end']:'',
				// 		'pilkada_area_id' 			=> $provinceId,
				// 		'pilkada_create_user_id'	=> $this->session->userdata('user_id'),
				// 		'pilkada_create_date' 		=> date('d-m-Y H:i:s'),
				// 		'pilkada_status' 			=> 1
				// 		);
					$insDb = $this->pilkada_model->addPilkada($datapostpilkada);
					if($insDb > 0){
						$notify = array(
							'title' 	=> 'Berhasil!',
							'message' 	=> 'Tambah Data Pilkada Berhasil',
							'status' 	=> 'success'
							);
						$this->session->set_flashdata('notify', $notify);
						
						redirect(base_url().'pemilu/pilkada');
					}else{
						$notify = array(
							'title' 	=> 'Gagal!',
							'message' 	=> 'Tambah Data Pilkada gagal, silahkan coba lagi',
							'status' 	=> 'error'
							);
						$this->session->set_flashdata('notify', $notify);
						
						redirect(base_url().'pemilu/pilkada');
					}
				}
			$data = array();
			// $data['accList']  	= $this->pengguna_model->getListAcc()->result_array();
			$data['provinceList']  	= $this->pilkada_model->getListProvince()->result_array();
			$this->template->display('pemilu/kepaladaerah/pilkada/create', $data);
		} else {
			$this->access->redirect('404');
		}
	}
	public function detail($id=0){
		if($this->access->permission('read')){
			$pilkada = $this->pilkada_model->getDetail($id)->row_array();
			$data["pilkada"] = $pilkada;
			$this->template->display('pemilu/kepaladaerah/pilkada/detail', $data);
		}
	}

	public function listdataaktif(){
		$default_order = "pilkada_id";
		$limit = 10;

		$order_field 	= array(
			'pilkada_id',
			'pilkada_name',
			'province_name',
			'pilkada_periode_start',
			'pilkada_periode_end',
			);
		$order_key 	= ($this->input->get('iSortCol_0')=="0")?"0":$this->input->get('iSortCol_0');
		$order 		= (!$this->input->get('iSortCol_0'))?$default_order:$order_field[$order_key];
		$sort 		= (!$this->input->get('sSortDir_0'))?'asc':$this->input->get('sSortDir_0');
		$search 	= (!$this->input->get('sSearch'))?'':strtoupper($this->input->get('sSearch'));
		$limit 		= (!$this->input->get('iDisplayLength'))?$limit:$this->input->get('iDisplayLength');
		$start 		= (!$this->input->get('iDisplayStart'))?0:$this->input->get('iDisplayStart');
		$data['sEcho'] = $this->input->get('sEcho');
		$data['iTotalRecords'][] = $this->pilkada_model->count_all($search,$order_field);
		$data['iTotalDisplayRecords'][] = $this->pilkada_model->count_all($search,$order_field);


		$aaData = array();
		$getData 	= $this->pilkada_model->get_paged_list($limit, $start, $order, $sort, $search, $order_field)->result_array();
		$no = (($start == 0) ? 1 : $start + 1);
		foreach ($getData as $row) {
			$aaData[] = array(
				'<center>'.$no.'</center>',
				$row["pilkada_name"],
				$row["province_name"],
				$row["pilkada_periode_start"],
				$row["pilkada_periode_end"],
				'<a href="'.base_url().'pemilu/pilkada/detail/'.$row["pilkada_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Lihat" data-placement="top"><i class="icon-file6"></i></a>
				<a href="'.base_url().'pemilu/pilkada/update/'.$row["pilkada_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Edit" data-placement="top"><i class="icon-pencil"></i></a>
				<a href="'.base_url().'pemilu/pilkada/delete/'.$row["pilkada_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Non Aktifkan" data-placement="top"><i class="icon-close"></i></a>');
			$no++;
		}
		$data['aaData'] = $aaData;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function listdatanonaktif(){
		$default_order = "pilkada_id";
		$limit = 10;

		$order_field 	= array(
			'pilkada_id',
			'pilkada_name',
			'province_name',
			'pilkada_periode_start',
			'pilkada_periode_end',
			);
		$order_key 	= ($this->input->get('iSortCol_0')=="0")?"0":$this->input->get('iSortCol_0');
		$order 		= (!$this->input->get('iSortCol_0'))?$default_order:$order_field[$order_key];
		$sort 		= (!$this->input->get('sSortDir_0'))?'asc':$this->input->get('sSortDir_0');
		$search 	= (!$this->input->get('sSearch'))?'':strtoupper($this->input->get('sSearch'));
		$limit 		= (!$this->input->get('iDisplayLength'))?$limit:$this->input->get('iDisplayLength');
		$start 		= (!$this->input->get('iDisplayStart'))?0:$this->input->get('iDisplayStart');
		$data['sEcho'] = $this->input->get('sEcho');
		$data['iTotalRecords'][] = $this->pilkada_model->count_allnonaktif($search,$order_field);
		$data['iTotalDisplayRecords'][] = $this->pilkada_model->count_allnonaktif($search,$order_field);


		$aaData = array();
		$getData 	= $this->pilkada_model->get_paged_listnonaktif($limit, $start, $order, $sort, $search, $order_field)->result_array();
		$no = (($start == 0) ? 1 : $start + 1);
		foreach ($getData as $row) {
			$aaData[] = array(
				'<center>'.$no.'</center>',
				$row["pilkada_name"],
				$row["province_name"],
				$row["pilkada_periode_start"],
				$row["pilkada_periode_end"],
				'<a href="'.base_url().'pemilu/pilkada/detail/'.$row["pilkada_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Lihat" data-placement="top"><i class="icon-file6"></i></a> '.
				'<a href="'.base_url().'pemilu/pilkada/aktif/'.$row["pilkada_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Aktifkan" data-placement="top"><i class="icon-checkmark3"></i></a>');
			$no++;
		}
		$data['aaData'] = $aaData;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function delete($pilkadaId = 0){

		$pilkadaIdFilter = filter_var($pilkadaId, FILTER_SANITIZE_NUMBER_INT);
		if($this->access->permission('delete')) {
			if($pilkadaId==$pilkadaIdFilter) {

				// $dataupdate = array(
				// 	'user_update_by' 			=> $this->session->userdata('user_id'),
				// 	'user_update_date' 			=> date('Y-m-d H:i:s')
				// 	);

				$del = $this->pilkada_model->deletePilkada($pilkadaId);
				$notify = array(
					'title' 	=> 'Berhasil!',
					'message' 	=> 'Data Pilkada dinonaktifkan',
					'status' 	=> 'success'
					);
				$this->session->set_flashdata('notify', $notify);

				redirect(base_url().'pemilu/pilkada');
			} else {
				$notify = array(
					'title' 	=> 'Gagal!',
					'message' 	=> 'Data Pilkada gagal dinonaktifkan',
					'status' 	=> 'error'
					);
				$this->session->set_flashdata('notify', $notify);
				redirect(base_url().'pemilu/pilkada');
			}
		} else {
			$notify = array(
				'title' 	=> 'Gagal!',
				'message' 	=> 'Data Pilkada gagal dinonaktifkan',
				'status' 	=> 'error'
				);
			$this->session->set_flashdata('notify', $notify);
			redirect(base_url().'pemilu/pilkada');
		}
	}

	public function aktif($pilkadaId = 0){

		$pilkadaIdFilter = filter_var($pilkadaId, FILTER_SANITIZE_NUMBER_INT);
		if($this->access->permission('update')) {
			if($pilkadaId==$pilkadaIdFilter) {

				// $dataupdate = array(
				// 	'user_update_by' 			=> $this->session->userdata('user_id'),
				// 	'user_update_date' 			=> date('Y-m-d H:i:s')
				// 	);

				$del = $this->pilkada_model->aktifPilkada($pilkadaId);
				$notify = array(
					'title' 	=> 'Berhasil!',
					'message' 	=> 'Data Pilkada diaktifkan',
					'status' 	=> 'success'
					);
				$this->session->set_flashdata('notify', $notify);

				redirect(base_url().'pemilu/pilkada');
			} else {
				$notify = array(
					'title' 	=> 'Gagal!',
					'message' 	=> 'Data Pilkada gagal diaktifkan',
					'status' 	=> 'error'
					);
				$this->session->set_flashdata('notify', $notify);
				redirect(base_url().'pemilu/pilkada');
			}
		} else {
			$notify = array(
				'title' 	=> 'Gagal!',
				'message' 	=> 'Data Pilkada gagal diaktifkan',
				'status' 	=> 'error'
				);
			$this->session->set_flashdata('notify', $notify);
			redirect(base_url().'pemilu/pilkada');
		}
	}
}