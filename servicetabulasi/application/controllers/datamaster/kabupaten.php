<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kabupaten extends CI_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('datamaster/kabupaten_model');
		$this->load->helper('xml');
		$this->load->helper('text');
	}

	 public function index(){
		 $data = array();
		 $this->template->display('datamaster/kabupaten/index', $data);
	}

	function update($regencyId = 0){
		if($this->access->permission('read')){

			if($post = $this->input->post()){
				
				$getMaster = $this->kabupaten_model->getMasterRegency($regencyId)->row_array();
				
				$dataupdate = array(
					'regency_province_code' 	=> isset($post['add_province_code'])?$post['add_province_code']:'',
					'regency_code'				=> isset($post['add_code'])?$post['add_code']:'',
					'regency_name'				=> isset($post['add_name'])?$post['add_name']:'',
					'regency_status' 			=> 1
					);
				
				$insDb = $this->kabupaten_model->update($dataupdate, $regencyId);

				if($insDb > 0){
					$notify = array(
						'title' 	=> 'Berhasil!',
						'message' 	=> 'Perubahan Kabupaten Berhasil',
						'status' 	=> 'success'
						);
					$this->session->set_flashdata('notify', $notify);

					redirect(base_url().'datamaster/kabupaten');
				}else{
					$notify = array(
						'title' 	=> 'Gagal!',
						'message'	=> 'Perubahan Kabupaten gagal, silahkan coba lagi',
						'status' 	=> 'error'
						);
					$this->session->set_flashdata('notify', $notify);
					redirect(base_url().'datamaster/kabupaten');
				}
			}

			$data = array();
			$data['getDetail']  	= $this->kabupaten_model->getDetail($regencyId)->row_array();
			$this->template->display('datamaster/kabupaten/update', $data);
		}else{
			$this->access->redirect('404');
		}
	}

	public function create(){
		if($this->access->permission('create')){
			
			if($post = $this->input->post()){

				$datapostregency = array(
					'regency_province_code' 	=> isset($post['add_province_code'])?$post['add_province_code']:'',
					'regency_code'				=> isset($post['add_code'])?$post['add_code']:'',
					'regency_name'				=> isset($post['add_name'])?$post['add_name']:'',
					'regency_status' 			=> 1
					);

					$insDb = $this->kabupaten_model->addRegency($datapostregency);

				if($insDb > 0){
					$notify = array(
							'title' 	=> 'Berhasil!',
							'message' 	=> 'Tambah Data kabupaten Berhasil',
							'status' 	=> 'success'
						);
					$this->session->set_flashdata('notify', $notify);

					redirect(base_url().'datamaster/kabupaten');
				}else{
					$notify = array(
							'title' 	=> 'Gagal!',
							'message' 	=> 'Tambah Data kabupaten  gagal, silahkan coba lagi',
							'status' 	=> 'error'
						);
					$this->session->set_flashdata('notify', $notify);
					redirect(base_url().'datamaster/kabupaten');
				}
			}
			
			$data = array();
			$this->template->display('datamaster/kabupaten/create', $data);
		} else {
			$this->access->redirect('404');
		}
	}

	public function listdataaktif(){
		$default_order = "regency_name";
		$limit = 10;

		$order_field 	= array(
			'regency_id',
			'regency_province_code',
			'regency_code',
			'regency_name',
			'regency_status',
			);
		$order_key 	= ($this->input->get('iSortCol_0')=="0")?"0":$this->input->get('iSortCol_0');
		$order 		= (!$this->input->get('iSortCol_0'))?$default_order:$order_field[$order_key];
		$sort 		= (!$this->input->get('sSortDir_0'))?'asc':$this->input->get('sSortDir_0');
		$search 	= (!$this->input->get('sSearch'))?'':strtoupper($this->input->get('sSearch'));
		$limit 		= (!$this->input->get('iDisplayLength'))?$limit:$this->input->get('iDisplayLength');
		$start 		= (!$this->input->get('iDisplayStart'))?0:$this->input->get('iDisplayStart');
		$data['sEcho'] = $this->input->get('sEcho');
		$data['iTotalRecords'][] = $this->kabupaten_model->count_all($search,$order_field);
		$data['iTotalDisplayRecords'][] = $this->kabupaten_model->count_all($search,$order_field);


		$aaData = array();
		$getData 	= $this->kabupaten_model->get_paged_list($limit, $start, $order, $sort, $search, $order_field)->result_array();
		$no = (($start == 0) ? 1 : $start + 1);
		foreach ($getData as $row) {
			$aaData[] = array(
				'<center>'.$no.'</center>',
				$row["regency_province_code"],
				$row["regency_code"],
				$row["regency_name"],
				$row["regency_status"],
				'<a href="'.base_url().'datamaster/kabupaten/detail/'.$row["regency_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Lihat" data-placement="top"><i class="icon-file6"></i></a>
				<a href="'.base_url().'datamaster/kabupaten/update/'.$row["regency_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Edit" data-placement="top"><i class="icon-pencil"></i></a>
				<a href="'.base_url().'datamaster/kabupaten/delete/'.$row["regency_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Non Aktifkan" data-placement="top"><i class="icon-close"></i></a>');
			$no++;
		}
		$data['aaData'] = $aaData;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function listdatanonaktif(){
		$default_order = "regency_name";
		$limit = 10;

		$order_field 	= array(
			'regency_id',
			'regency_province_code',
			'regency_code',
			'regency_name',
			'regency_status',
			);
		$order_key 	= ($this->input->get('iSortCol_0')=="0")?"0":$this->input->get('iSortCol_0');
		$order 		= (!$this->input->get('iSortCol_0'))?$default_order:$order_field[$order_key];
		$sort 		= (!$this->input->get('sSortDir_0'))?'asc':$this->input->get('sSortDir_0');
		$search 	= (!$this->input->get('sSearch'))?'':strtoupper($this->input->get('sSearch'));
		$limit 		= (!$this->input->get('iDisplayLength'))?$limit:$this->input->get('iDisplayLength');
		$start 		= (!$this->input->get('iDisplayStart'))?0:$this->input->get('iDisplayStart');
		$data['sEcho'] = $this->input->get('sEcho');
		$data['iTotalRecords'][] = $this->kabupaten_model->count_allnonaktif($search,$order_field);
		$data['iTotalDisplayRecords'][] = $this->kabupaten_model->count_allnonaktif($search,$order_field);


		$aaData = array();
		$getData 	= $this->kabupaten_model->get_paged_listnonaktif($limit, $start, $order, $sort, $search, $order_field)->result_array();
		$no = (($start == 0) ? 1 : $start + 1);
		foreach ($getData as $row) {
			$aaData[] = array(
				'<center>'.$no.'</center>',
				$row["regency_province_code"],
				$row["regency_code"],
				$row["regency_name"],
				$row["regency_status"],
				'<a href="'.base_url().'datamaster/kabupaten/detail/'.$row["regency_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Lihat" data-placement="top"><i class="icon-file6"></i></a> '.
				'<a href="'.base_url().'datamaster/kabupaten/aktif/'.$row["regency_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Aktifkan" data-placement="top"><i class="icon-checkmark3"></i></a>');
			$no++;
		}
		$data['aaData'] = $aaData;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function detail($id=0){
		if($this->access->permission('read')){
			$kabupatenId = $this->kabupaten_model->getDetail($id)->row_array();
			$data["kabupaten"] = $kabupatenId;
			$this->template->display('datamaster/kabupaten/detail', $data);
		}
	}

	public function delete($regencyId = 0){

		$regencyIdFilter = filter_var($regencyId, FILTER_SANITIZE_NUMBER_INT);
		if($this->access->permission('delete')) {
			if($regencyId==$regencyIdFilter) {

				$del = $this->kabupaten_model->deleteRegency($regencyId);
				$notify = array(
					'title' 	=> 'Berhasil!',
					'message' 	=> 'Kabupaten dinonaktifkan',
					'status' 	=> 'success'
					);
				$this->session->set_flashdata('notify', $notify);

				redirect(base_url().'datamaster/kabupaten');
			} else {
				$notify = array(
					'title' 	=> 'Gagal!',
					'message' 	=> 'Kabupaten gagal dinonaktifkan',
					'status' 	=> 'error'
					);
				$this->session->set_flashdata('notify', $notify);
				redirect(base_url().'datamaster/kabupaten');
			}
		} else {
			$notify = array(
				'title' 	=> 'Gagal!',
				'message' 	=> 'Kabupaten gagal dinonaktifkan',
				'status' 	=> 'error'
				);
			$this->session->set_flashdata('notify', $notify);
			redirect(base_url().'datamaster/kabupaten');
		}
	}

	public function aktif($regencyId = 0){

		$regencyIdFilter = filter_var($regencyId, FILTER_SANITIZE_NUMBER_INT);
		if($this->access->permission('update')) {
			if($regencyId==$regencyIdFilter) {

				$del = $this->kabupaten_model->aktifRegency($regencyId);
				$notify = array(
					'title' 	=> 'Berhasil!',
					'message' 	=> 'Kabupaten diaktifkan',
					'status' 	=> 'success'
					);
				$this->session->set_flashdata('notify', $notify);

				redirect(base_url().'datamaster/kabupaten');
			} else {
				$notify = array(
					'title' 	=> 'Gagal!',
					'message' 	=> 'Kabupaten gagal diaktifkan',
					'status' 	=> 'error'
					);
				$this->session->set_flashdata('notify', $notify);
				redirect(base_url().'datamaster/kabupaten');
			}
		} else {
			$notify = array(
				'title' 	=> 'Gagal!',
				'message' 	=> 'Kabupaten gagal diaktifkan',
				'status' 	=> 'error'
				);
			$this->session->set_flashdata('notify', $notify);
			redirect(base_url().'datamaster/kabupaten');
		}
	}

	public function place($Id){
		$data = $this->kabupaten_model->Dataselectlist($Id)->row_array();
		echo json_encode($data);
	}

	public function provinsi() {
       $this->output->set_content_type('application/json')->set_output(json_encode($this->kabupaten_model->get_provinsi()));
   	}

}