<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kecamatan extends CI_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('datamaster/kecamatan_model');
		$this->load->helper('xml');
		$this->load->helper('text');
	}

	 public function index(){
		 $data = array();
		 $this->template->display('datamaster/kecamatan/index', $data);
	}

	function update($districtId = 0){
		if($this->access->permission('read')){

			if($post = $this->input->post()){
				
				$getMaster = $this->kecamatan_model->getMasterdistrict($districtId)->row_array();
				
				$dataupdate = array(
					'district_regency_code' 	=> isset($post['kode_kabupaten'])?$post['kode_kabupaten']:'',
					'district_code'				=> isset($post['add_code'])?$post['add_code']:'',
					'district_name'				=> isset($post['add_name'])?$post['add_name']:'',
					'district_status' 			=> 1
					);
				
				$insDb = $this->kecamatan_model->update($dataupdate, $districtId);

				if($insDb > 0){
					$notify = array(
						'title' 	=> 'Berhasil!',
						'message' 	=> 'Perubahan Kecamatan Berhasil',
						'status' 	=> 'success'
						);
					$this->session->set_flashdata('notify', $notify);

					redirect(base_url().'datamaster/kecamatan');
				}else{
					$notify = array(
						'title' 	=> 'Gagal!',
						'message'	=> 'Perubahan Kecamatan gagal, silahkan coba lagi',
						'status' 	=> 'error'
						);
					$this->session->set_flashdata('notify', $notify);
					redirect(base_url().'datamaster/kecamatan');
				}
			}

			$data = array();
			$data['getDetail']  	= $this->kecamatan_model->getDetail($districtId)->row_array();
			$this->template->display('datamaster/kecamatan/update', $data);
		}else{
			$this->access->redirect('404');
		}
	}

	public function create(){
		if($this->access->permission('create')){
			
			if($post = $this->input->post()){

				$datapostdistrict = array(
					'district_regency_code' 	=> isset($post['kode_kabupaten'])?$post['kode_kabupaten']:'',
					'district_code'				=> isset($post['add_code'])?$post['add_code']:'',
					'district_name'				=> isset($post['add_name'])?$post['add_name']:'',
					'district_status' 			=> 1
					);

					$insDb = $this->kecamatan_model->adddistrict($datapostdistrict);

				if($insDb > 0){
					$notify = array(
							'title' 	=> 'Berhasil!',
							'message' 	=> 'Tambah Data Kecamatan Berhasil',
							'status' 	=> 'success'
						);
					$this->session->set_flashdata('notify', $notify);

					redirect(base_url().'datamaster/kecamatan');
				}else{
					$notify = array(
							'title' 	=> 'Gagal!',
							'message' 	=> 'Tambah Data Kecamatan  gagal, silahkan coba lagi',
							'status' 	=> 'error'
						);
					$this->session->set_flashdata('notify', $notify);
					redirect(base_url().'datamaster/kecamatan');
				}
			}
			
			$data = array();
			$this->template->display('datamaster/kecamatan/create', $data);
		} else {
			$this->access->redirect('404');
		}
	}

	public function listdataaktif(){
		$default_order = "district_name";
		$limit = 10;

		$order_field 	= array(
			'district_id',
			'district_regency_code',
			'district_code',
			'district_name',
			'district_status',
			);
		$order_key 	= ($this->input->get('iSortCol_0')=="0")?"0":$this->input->get('iSortCol_0');
		$order 		= (!$this->input->get('iSortCol_0'))?$default_order:$order_field[$order_key];
		$sort 		= (!$this->input->get('sSortDir_0'))?'asc':$this->input->get('sSortDir_0');
		$search 	= (!$this->input->get('sSearch'))?'':strtoupper($this->input->get('sSearch'));
		$limit 		= (!$this->input->get('iDisplayLength'))?$limit:$this->input->get('iDisplayLength');
		$start 		= (!$this->input->get('iDisplayStart'))?0:$this->input->get('iDisplayStart');
		$data['sEcho'] = $this->input->get('sEcho');
		$data['iTotalRecords'][] = $this->kecamatan_model->count_all($search,$order_field);
		$data['iTotalDisplayRecords'][] = $this->kecamatan_model->count_all($search,$order_field);


		$aaData = array();
		$getData 	= $this->kecamatan_model->get_paged_list($limit, $start, $order, $sort, $search, $order_field)->result_array();
		$no = (($start == 0) ? 1 : $start + 1);
		foreach ($getData as $row) {
			$aaData[] = array(
				'<center>'.$no.'</center>',
				$row["district_regency_code"],
				$row["district_code"],
				$row["district_name"],
				$row["district_status"],
				'<a href="'.base_url().'datamaster/kecamatan/detail/'.$row["district_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Lihat" data-placement="top"><i class="icon-file6"></i></a>
				<a href="'.base_url().'datamaster/kecamatan/update/'.$row["district_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Edit" data-placement="top"><i class="icon-pencil"></i></a>
				<a href="'.base_url().'datamaster/kecamatan/delete/'.$row["district_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Non Aktifkan" data-placement="top"><i class="icon-close"></i></a>');
			$no++;
		}
		$data['aaData'] = $aaData;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function listdatanonaktif(){
		$default_order = "district_name";
		$limit = 10;

		$order_field 	= array(
			'district_id',
			'district_regency_code',
			'district_code',
			'district_name',
			'district_status',
			);
		$order_key 	= ($this->input->get('iSortCol_0')=="0")?"0":$this->input->get('iSortCol_0');
		$order 		= (!$this->input->get('iSortCol_0'))?$default_order:$order_field[$order_key];
		$sort 		= (!$this->input->get('sSortDir_0'))?'asc':$this->input->get('sSortDir_0');
		$search 	= (!$this->input->get('sSearch'))?'':strtoupper($this->input->get('sSearch'));
		$limit 		= (!$this->input->get('iDisplayLength'))?$limit:$this->input->get('iDisplayLength');
		$start 		= (!$this->input->get('iDisplayStart'))?0:$this->input->get('iDisplayStart');
		$data['sEcho'] = $this->input->get('sEcho');
		$data['iTotalRecords'][] = $this->kecamatan_model->count_allnonaktif($search,$order_field);
		$data['iTotalDisplayRecords'][] = $this->kecamatan_model->count_allnonaktif($search,$order_field);


		$aaData = array();
		$getData 	= $this->kecamatan_model->get_paged_listnonaktif($limit, $start, $order, $sort, $search, $order_field)->result_array();
		$no = (($start == 0) ? 1 : $start + 1);
		foreach ($getData as $row) {
			$aaData[] = array(
				'<center>'.$no.'</center>',
				$row["district_regency_code"],
				$row["district_code"],
				$row["district_name"],
				$row["district_status"],
				'<a href="'.base_url().'datamaster/kecamatan/detail/'.$row["district_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Lihat" data-placement="top"><i class="icon-file6"></i></a> '.
				'<a href="'.base_url().'datamaster/kecamatan/aktif/'.$row["district_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Aktifkan" data-placement="top"><i class="icon-checkmark3"></i></a>');
			$no++;
		}
		$data['aaData'] = $aaData;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function detail($id=0){
		if($this->access->permission('read')){
			$kecamatanId = $this->kecamatan_model->getDetail($id)->row_array();
			$data["kecamatan"] = $kecamatanId;
			$this->template->display('datamaster/kecamatan/detail', $data);
		}
	}

	public function delete($districtId = 0){

		$districtIdFilter = filter_var($districtId, FILTER_SANITIZE_NUMBER_INT);
		if($this->access->permission('delete')) {
			if($districtId==$districtIdFilter) {

				$del = $this->kecamatan_model->deletedistrict($districtId);
				$notify = array(
					'title' 	=> 'Berhasil!',
					'message' 	=> 'Kecamatan dinonaktifkan',
					'status' 	=> 'success'
					);
				$this->session->set_flashdata('notify', $notify);

				redirect(base_url().'datamaster/kecamatan');
			} else {
				$notify = array(
					'title' 	=> 'Gagal!',
					'message' 	=> 'Kecamatan gagal dinonaktifkan',
					'status' 	=> 'error'
					);
				$this->session->set_flashdata('notify', $notify);
				redirect(base_url().'datamaster/kecamatan');
			}
		} else {
			$notify = array(
				'title' 	=> 'Gagal!',
				'message' 	=> 'Kecamatan gagal dinonaktifkan',
				'status' 	=> 'error'
				);
			$this->session->set_flashdata('notify', $notify);
			redirect(base_url().'datamaster/kecamatan');
		}
	}

	public function aktif($districtId = 0){

		$districtIdFilter = filter_var($districtId, FILTER_SANITIZE_NUMBER_INT);
		if($this->access->permission('update')) {
			if($districtId==$districtIdFilter) {

				$del = $this->kecamatan_model->aktifdistrict($districtId);
				$notify = array(
					'title' 	=> 'Berhasil!',
					'message' 	=> 'Kecamatan diaktifkan',
					'status' 	=> 'success'
					);
				$this->session->set_flashdata('notify', $notify);

				redirect(base_url().'datamaster/kecamatan');
			} else {
				$notify = array(
					'title' 	=> 'Gagal!',
					'message' 	=> 'Kecamatan gagal diaktifkan',
					'status' 	=> 'error'
					);
				$this->session->set_flashdata('notify', $notify);
				redirect(base_url().'datamaster/kecamatan');
			}
		} else {
			$notify = array(
				'title' 	=> 'Gagal!',
				'message' 	=> 'kecamatan gagal diaktifkan',
				'status' 	=> 'error'
				);
			$this->session->set_flashdata('notify', $notify);
			redirect(base_url().'datamaster/kecamatan');
		}
	}

	public function place($id) {
		$data = $this->kecamatan_model->dataSelectList($id)->row_array();
    	echo json_encode($data);
  	}  	

	public function provinsi() {
       $this->output->set_content_type('application/json')->set_output(json_encode($this->kecamatan_model->get_provinsi()));
   	}

	public function kabupaten($id) {
       $this->output->set_content_type('application/json')->set_output(json_encode($this->kecamatan_model->get_kabupaten($id)));
   	}
}