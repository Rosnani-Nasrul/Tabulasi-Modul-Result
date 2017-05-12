<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kelurahan extends CI_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('datamaster/kelurahan_model');
		$this->load->helper('xml');
		$this->load->helper('text');

	}

	 public function index(){
		 $data = array();
		 $this->template->display('datamaster/kelurahan/index', $data);
	}

	function update($villageId = 0){
		if($this->access->permission('read')){

			if($post = $this->input->post()){
				
				$getMaster = $this->kelurahan_model->getMasterVillage($villageId)->row_array();
				
				$dataupdate = array(
					'village_district_code' 	=> isset($post['kode_kecamatan'])?$post['kode_kecamatan']:'',
					'village_code'				=> isset($post['add_code'])?$post['add_code']:'',
					'village_name'				=> isset($post['add_name'])?$post['add_name']:'',
					'village_status' 			=> 1
					);
				
				$insDb = $this->kelurahan_model->update($dataupdate, $villageId);

				if($insDb > 0){
					$notify = array(
						'title' 	=> 'Berhasil!',
						'message' 	=> 'Perubahan kelurahan Berhasil',
						'status' 	=> 'success'
						);
					$this->session->set_flashdata('notify', $notify);

					redirect(base_url().'datamaster/kelurahan');
				}else{
					$notify = array(
						'title' 	=> 'Gagal!',
						'message'	=> 'Perubahan kelurahan gagal, silahkan coba lagi',
						'status' 	=> 'error'
						);
					$this->session->set_flashdata('notify', $notify);
					redirect(base_url().'datamaster/kelurahan');
				}
			}

			$data = array();
			$data['getDetail']  	= $this->kelurahan_model->getDetail($villageId)->row_array();
			
			$this->template->display('datamaster/kelurahan/update', $data);
		}else{
			$this->access->redirect('404');
		}
	}

	public function create(){
		if($this->access->permission('create')){
			
			if($post = $this->input->post()){

				$datapostvillage = array(
					'village_district_code' 	=> isset($post['kode_kecamatan'])?$post['kode_kecamatan']:'',
					'village_code'				=> isset($post['add_code'])?$post['add_code']:'',
					'village_name'				=> isset($post['add_name'])?$post['add_name']:'',
					'village_status' 			=> 1
					);

					$insDb = $this->kelurahan_model->addVillage($datapostvillage);

				if($insDb > 0){
					$notify = array(
							'title' 	=> 'Berhasil!',
							'message' 	=> 'Tambah Data kelurahan Berhasil',
							'status' 	=> 'success'
						);
					$this->session->set_flashdata('notify', $notify);

					redirect(base_url().'datamaster/kelurahan');
				}else{
					$notify = array(
							'title' 	=> 'Gagal!',
							'message' 	=> 'Tambah Data kelurahan  gagal, silahkan coba lagi',
							'status' 	=> 'error'
						);
					$this->session->set_flashdata('notify', $notify);
					redirect(base_url().'datamaster/kelurahan');
				}
			}
			
			$data = array();
			$this->template->display('datamaster/kelurahan/create', $data);
		} else {
			$this->access->redirect('404');
		}
	}

	public function listdataaktif(){
		$default_order = "village_name";
		$limit = 10;

		$order_field 	= array(
			'village_id',
			'village_district_code',
			'village_code',
			'village_name',
			'village_status',
			);
		$order_key 	= ($this->input->get('iSortCol_0')=="0")?"0":$this->input->get('iSortCol_0');
		$order 		= (!$this->input->get('iSortCol_0'))?$default_order:$order_field[$order_key];
		$sort 		= (!$this->input->get('sSortDir_0'))?'asc':$this->input->get('sSortDir_0');
		$search 	= (!$this->input->get('sSearch'))?'':strtoupper($this->input->get('sSearch'));
		$limit 		= (!$this->input->get('iDisplayLength'))?$limit:$this->input->get('iDisplayLength');
		$start 		= (!$this->input->get('iDisplayStart'))?0:$this->input->get('iDisplayStart');
		$data['sEcho'] = $this->input->get('sEcho');
		$data['iTotalRecords'][] = $this->kelurahan_model->count_all($search,$order_field);
		$data['iTotalDisplayRecords'][] = $this->kelurahan_model->count_all($search,$order_field);


		$aaData 	= array();
		$getData 	= $this->kelurahan_model->get_paged_list($limit, $start, $order, $sort, $search, $order_field)->result_array();
		$no 		= (($start == 0) ? 1 : $start + 1);
		foreach ($getData as $row) {
			$aaData[] = array(
				'<center>'.$no.'</center>',
				$row["village_district_code"],
				$row["village_code"],
				$row["village_name"],
				$row["village_status"],
				'<a href="'.base_url().'datamaster/kelurahan/detail/'.$row["village_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Lihat" data-placement="top"><i class="icon-file6"></i></a>
				<a href="'.base_url().'datamaster/kelurahan/update/'.$row["village_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Edit" data-placement="top"><i class="icon-pencil"></i></a>
				<a href="'.base_url().'datamaster/kelurahan/delete/'.$row["village_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Non Aktifkan" data-placement="top"><i class="icon-close"></i></a>');
			$no++;
		}
		$data['aaData'] = $aaData;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function listdatanonaktif(){
		$default_order = "village_name";
		$limit = 10;

		$order_field 	= array(
			'village_id',
			'village_district_code',
			'village_code',
			'village_name',
			'village_status',
			);
		$order_key 	= ($this->input->get('iSortCol_0')=="0")?"0":$this->input->get('iSortCol_0');
		$order 		= (!$this->input->get('iSortCol_0'))?$default_order:$order_field[$order_key];
		$sort 		= (!$this->input->get('sSortDir_0'))?'asc':$this->input->get('sSortDir_0');
		$search 	= (!$this->input->get('sSearch'))?'':strtoupper($this->input->get('sSearch'));
		$limit 		= (!$this->input->get('iDisplayLength'))?$limit:$this->input->get('iDisplayLength');
		$start 		= (!$this->input->get('iDisplayStart'))?0:$this->input->get('iDisplayStart');
		$data['sEcho'] = $this->input->get('sEcho');
		$data['iTotalRecords'][] = $this->kelurahan_model->count_allnonaktif($search,$order_field);
		$data['iTotalDisplayRecords'][] = $this->kelurahan_model->count_allnonaktif($search,$order_field);


		$aaData = array();
		$getData 	= $this->kelurahan_model->get_paged_listnonaktif($limit, $start, $order, $sort, $search, $order_field)->result_array();
		$no = (($start == 0) ? 1 : $start + 1);
		foreach ($getData as $row) {
			$aaData[] = array(
				'<center>'.$no.'</center>',
				$row["village_district_code"],
				$row["village_code"],
				$row["village_name"],
				$row["village_status"],
				'<a href="'.base_url().'datamaster/kelurahan/detail/'.$row["village_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Lihat" data-placement="top"><i class="icon-file6"></i></a> '.
				'<a href="'.base_url().'datamaster/kelurahan/aktif/'.$row["village_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Aktifkan" data-placement="top"><i class="icon-checkmark3"></i></a>');
			$no++;
		}
		$data['aaData'] = $aaData;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function detail($id=0){
		if($this->access->permission('read')){
			$kelurahanId = $this->kelurahan_model->getDetail($id)->row_array();
			$data["kelurahan"] = $kelurahanId;
			$this->template->display('datamaster/kelurahan/detail', $data);
		}
	}

	public function delete($villageId = 0){

		$villageIdFilter = filter_var($villageId, FILTER_SANITIZE_NUMBER_INT);
		if($this->access->permission('delete')) {
			if($villageId==$villageIdFilter) {

				$del = $this->kelurahan_model->deleteVillage($villageId);
				$notify = array(
					'title' 	=> 'Berhasil!',
					'message' 	=> 'kelurahan dinonaktifkan',
					'status' 	=> 'success'
					);
				$this->session->set_flashdata('notify', $notify);

				redirect(base_url().'datamaster/kelurahan');
			} else {
				$notify = array(
					'title' 	=> 'Gagal!',
					'message' 	=> 'kelurahan gagal dinonaktifkan',
					'status' 	=> 'error'
					);
				$this->session->set_flashdata('notify', $notify);
				redirect(base_url().'datamaster/kelurahan');
			}
		} else {
			$notify = array(
				'title' 	=> 'Gagal!',
				'message' 	=> 'kelurahan gagal dinonaktifkan',
				'status' 	=> 'error'
				);
			$this->session->set_flashdata('notify', $notify);
			redirect(base_url().'datamaster/kelurahan');
		}
	}

	public function aktif($villageId = 0){

		$villageIdFilter = filter_var($villageId, FILTER_SANITIZE_NUMBER_INT);
		if($this->access->permission('update')) {
			if($villageId==$villageIdFilter) {

				$del = $this->kelurahan_model->aktifVillage($villageId);
				$notify = array(
					'title' 	=> 'Berhasil!',
					'message' 	=> 'kelurahan diaktifkan',
					'status' 	=> 'success'
					);
				$this->session->set_flashdata('notify', $notify);

				redirect(base_url().'datamaster/kelurahan');
			} else {
				$notify = array(
					'title' 	=> 'Gagal!',
					'message' 	=> 'kelurahan gagal diaktifkan',
					'status' 	=> 'error'
					);
				$this->session->set_flashdata('notify', $notify);
				redirect(base_url().'datamaster/kelurahan');
			}
		} else {
			$notify = array(
				'title' 	=> 'Gagal!',
				'message' 	=> 'kelurahan gagal diaktifkan',
				'status' 	=> 'error'
				);
			$this->session->set_flashdata('notify', $notify);
			redirect(base_url().'datamaster/kelurahan');
		}
	}

	public function place($id) {
		$data = $this->kelurahan_model->dataSelectList($id)->row_array();
    	echo json_encode($data);
  	}  	

	public function provinsi() {
       $this->output->set_content_type('application/json')->set_output(json_encode($this->kelurahan_model->get_provinsi()));
   	}

	public function kabupaten($id) {
       $this->output->set_content_type('application/json')->set_output(json_encode($this->kelurahan_model->get_kabupaten($id)));
   	}

   	public function kecamatan($id) {
       $this->output->set_content_type('application/json')->set_output(json_encode($this->kelurahan_model->get_kecamatan($id)));
  	}
}