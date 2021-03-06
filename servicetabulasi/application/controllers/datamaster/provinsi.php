<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Provinsi extends CI_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('datamaster/provinsi_model');
		$this->load->helper('xml');
		$this->load->helper('text');
	}

	 public function index(){
		 $data = array();
		 $this->template->display('datamaster/provinsi/index', $data);
	}

	function update($provinceId = 0){
		if($this->access->permission('read')){

			if($post = $this->input->post()){
				
				$getMaster = $this->provinsi_model->getMasterProvince($provinceId)->row_array();
				
				$dataupdate = array(
					'province_code' 		=> isset($post['add_code'])?$post['add_code']:'',
					'province_name'				=> isset($post['add_name'])?$post['add_name']:'',
					'province_status' 			=> 1
					);
				
				$insDb = $this->provinsi_model->update($dataupdate, $provinceId);

				if($insDb > 0){
					$notify = array(
						'title' 	=> 'Berhasil!',
						'message' 	=> 'Perubahan pengguna Berhasil',
						'status' 	=> 'success'
						);
					$this->session->set_flashdata('notify', $notify);

					redirect(base_url().'datamaster/provinsi');
				}else{
					$notify = array(
						'title' 	=> 'Gagal!',
						'message'	=> 'Perubahan pengguna gagal, silahkan coba lagi',
						'status' 	=> 'error'
						);
					$this->session->set_flashdata('notify', $notify);
					redirect(base_url().'datamaster/provinsi');
				}
			}

			$data = array();
			$data['getDetail']  	= $this->provinsi_model->getDetail($provinceId)->row_array();
			$data['accList']  		= $this->provinsi_model->getListAcc()->result_array();
			$data['List']  			= $this->provinsi_model->ListAcc()->row_array();
			$this->template->display('datamaster/provinsi/update', $data);
		}else{
			$this->access->redirect('404');
		}
	}

	public function create(){
		if($this->access->permission('create')){
			
			if($post = $this->input->post()){

				$datapostprovince = array(
					'province_code' 		=> isset($post['add_code'])?$post['add_code']:'',
					'province_name'				=> isset($post['add_name'])?$post['add_name']:'',
					'province_status' 			=> 1
					);
					
					$insDb = $this->provinsi_model->addProvince($datapostprovince);

				if($insDb > 0){
					$notify = array(
							'title' 	=> 'Berhasil!',
							'message' 	=> 'Tambah Data provinsi Berhasil',
							'status' 	=> 'success'
						);
					$this->session->set_flashdata('notify', $notify);

					redirect(base_url().'datamaster/provinsi');
				}else{
					$notify = array(
							'title' 	=> 'Gagal!',
							'message' 	=> 'Tambah Data provinsi  gagal, silahkan coba lagi',
							'status' 	=> 'error'
						);
					$this->session->set_flashdata('notify', $notify);
					redirect(base_url().'datamaster/provinsi');
				}
			}
			
			$data = array();
			$data['accList']  	= $this->provinsi_model->getListAcc()->result_array();
			$this->template->display('datamaster/provinsi/create', $data);
		} else {
			$this->access->redirect('404');
		}
	}

	public function listdataaktif(){
		$default_order = "province_name";
		$limit = 10;

		$order_field 	= array(
			'province_id',
			'province_code',
			'province_name',
			'province_status',
			);
		$order_key 	= ($this->input->get('iSortCol_0')=="0")?"0":$this->input->get('iSortCol_0');
		$order 		= (!$this->input->get('iSortCol_0'))?$default_order:$order_field[$order_key];
		$sort 		= (!$this->input->get('sSortDir_0'))?'asc':$this->input->get('sSortDir_0');
		$search 	= (!$this->input->get('sSearch'))?'':strtoupper($this->input->get('sSearch'));
		$limit 		= (!$this->input->get('iDisplayLength'))?$limit:$this->input->get('iDisplayLength');
		$start 		= (!$this->input->get('iDisplayStart'))?0:$this->input->get('iDisplayStart');
		$data['sEcho'] = $this->input->get('sEcho');
		$data['iTotalRecords'][] = $this->provinsi_model->count_all($search,$order_field);
		$data['iTotalDisplayRecords'][] = $this->provinsi_model->count_all($search,$order_field);


		$aaData = array();
		$getData 	= $this->provinsi_model->get_paged_list($limit, $start, $order, $sort, $search, $order_field)->result_array();
		$no = (($start == 0) ? 1 : $start + 1);
		foreach ($getData as $row) {
			$aaData[] = array(
				'<center>'.$no.'</center>',
				$row["province_code"],
				$row["province_name"],
				$row["province_status"],
				'<a href="'.base_url().'datamaster/provinsi/detail/'.$row["province_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Lihat" data-placement="top"><i class="icon-file6"></i></a>
				<a href="'.base_url().'datamaster/provinsi/update/'.$row["province_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Edit" data-placement="top"><i class="icon-pencil"></i></a>
				<a href="'.base_url().'datamaster/provinsi/delete/'.$row["province_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Non Aktifkan" data-placement="top"><i class="icon-close"></i></a>');
			$no++;
		}
		$data['aaData'] = $aaData;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function listdatanonaktif(){
		$default_order = "province_name";
		$limit = 10;

		$order_field 	= array(
			'province_id',
			'province_code',
			'province_name',
			'province_status',
			);
		$order_key 	= ($this->input->get('iSortCol_0')=="0")?"0":$this->input->get('iSortCol_0');
		$order 		= (!$this->input->get('iSortCol_0'))?$default_order:$order_field[$order_key];
		$sort 		= (!$this->input->get('sSortDir_0'))?'asc':$this->input->get('sSortDir_0');
		$search 	= (!$this->input->get('sSearch'))?'':strtoupper($this->input->get('sSearch'));
		$limit 		= (!$this->input->get('iDisplayLength'))?$limit:$this->input->get('iDisplayLength');
		$start 		= (!$this->input->get('iDisplayStart'))?0:$this->input->get('iDisplayStart');
		$data['sEcho'] = $this->input->get('sEcho');
		$data['iTotalRecords'][] = $this->provinsi_model->count_allnonaktif($search,$order_field);
		$data['iTotalDisplayRecords'][] = $this->provinsi_model->count_allnonaktif($search,$order_field);


		$aaData = array();
		$getData 	= $this->provinsi_model->get_paged_listnonaktif($limit, $start, $order, $sort, $search, $order_field)->result_array();
		$no = (($start == 0) ? 1 : $start + 1);
		foreach ($getData as $row) {
			$aaData[] = array(
				'<center>'.$no.'</center>',
				$row["province_code"],
				$row["province_name"],
				$row["province_status"],
				'<a href="'.base_url().'datamaster/provinsi/detail/'.$row["province_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Lihat" data-placement="top"><i class="icon-file6"></i></a> '.
				'<a href="'.base_url().'datamaster/provinsi/aktif/'.$row["province_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Aktifkan" data-placement="top"><i class="icon-checkmark3"></i></a>');
			$no++;
		}
		$data['aaData'] = $aaData;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function detail($id=0){
		if($this->access->permission('read')){
			$provinceId = $this->provinsi_model->getDetail($id)->row_array();
			$data["provinsi"] = $provinceId;
			$this->template->display('datamaster/provinsi/detail', $data);
		}
	}

	public function delete($provinceId = 0){

		$provinceIdFilter = filter_var($provinceId, FILTER_SANITIZE_NUMBER_INT);
		if($this->access->permission('delete')) {
			if($provinceId==$provinceIdFilter) {

				// $dataupdate = array(
					// 'user_update_by' 			=> $this->session->userdata('user_id'),
					// 'user_update_date' 			=> date('Y-m-d H:i:s')
					// );

				$del = $this->provinsi_model->deleteProvince($provinceId);
				$notify = array(
					'title' 	=> 'Berhasil!',
					'message' 	=> 'Pengguna dinonaktifkan',
					'status' 	=> 'success'
					);
				$this->session->set_flashdata('notify', $notify);

				redirect(base_url().'datamaster/provinsi');
			} else {
				$notify = array(
					'title' 	=> 'Gagal!',
					'message' 	=> 'Pengguna gagal dinonaktifkan',
					'status' 	=> 'error'
					);
				$this->session->set_flashdata('notify', $notify);
				redirect(base_url().'datamaster/provinsi');
			}
		} else {
			$notify = array(
				'title' 	=> 'Gagal!',
				'message' 	=> 'Pengguna gagal dinonaktifkan',
				'status' 	=> 'error'
				);
			$this->session->set_flashdata('notify', $notify);
			redirect(base_url().'datamaster/provinsi');
		}
	}

	public function aktif($provinceId = 0){

		$provinceIdFilter = filter_var($provinceId, FILTER_SANITIZE_NUMBER_INT);
		if($this->access->permission('update')) {
			if($provinceId==$provinceIdFilter) {

				// $dataupdate = array(
					// 'user_update_by' 			=> $this->session->userdata('user_id'),
					// 'user_update_date' 			=> date('Y-m-d H:i:s')
					// );

				$del = $this->provinsi_model->aktifProvince($provinceId);
				$notify = array(
					'title' 	=> 'Berhasil!',
					'message' 	=> 'Provinsi diaktifkan',
					'status' 	=> 'success'
					);
				$this->session->set_flashdata('notify', $notify);

				redirect(base_url().'datamaster/provinsi');
			} else {
				$notify = array(
					'title' 	=> 'Gagal!',
					'message' 	=> 'Provinsi gagal diaktifkan',
					'status' 	=> 'error'
					);
				$this->session->set_flashdata('notify', $notify);
				redirect(base_url().'datamaster/provinsi');
			}
		} else {
			$notify = array(
				'title' 	=> 'Gagal!',
				'message' 	=> 'Provinsi gagal diaktifkan',
				'status' 	=> 'error'
				);
			$this->session->set_flashdata('notify', $notify);
			redirect(base_url().'datamaster/provinsi');
		}
	}
}