<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Partai extends CI_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('datamaster/partai_model');
		$this->load->helper('xml');
		$this->load->helper('text');
	}

	 public function index(){
		 $data = array();
		 $this->template->display('datamaster/partai/index', $data);
	}

	function update($partyId){
		if($this->access->permission('read')){

			if($post = $this->input->post()){
				
				$getMaster = $this->partai_model->getMasterParties($partyId)->row_array();

				$config['upload_path'] = './assets/upload/';
				$config['allowed_types'] = 'gif|jpg|png';
				$new_name = time()."_";
				$config['file_name'] = $new_name;
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				$field_name = "add_icon";
				$ifUpload = 0;
				$ext = "";
				$imgpath="";
				if($this->upload->do_upload('add_icon'))
				{
					$dataupdload = $this->upload->data();
					$ext = $dataupdload["file_ext"];
					$ifUpload = 1;
					$imgpath = "assets/upload/" . $dataupdload["file_name"];
				}else{
					$error = array('error' => $this->upload->display_errors());
				}
				
				$dataupdate = array(
					'party_code' 		=> isset($post['add_code'])?$post['add_code']:'',
					'party_icon'		=> $imgpath!=""?$imgpath:$getMaster['party_icon'],
					'party_name'		=> isset($post['add_name'])?$post['add_name']:'',
					'party_create_user_id'	=> $this->session->userdata('user_id'),
					'party_create_date'		=> date('Y-m-d H:i:s'),
					'party_status' 			=> 1
					);
				
				$insDb = $this->partai_model->update($dataupdate, $partyId);

				if($insDb > 0){
					$notify = array(
						'title' 	=> 'Berhasil!',
						'message' 	=> 'Perubahan Partai Berhasil',
						'status' 	=> 'success'
						);
					$this->session->set_flashdata('notify', $notify);

					redirect(base_url().'datamaster/partai');
				}else{
					$notify = array(
						'title' 	=> 'Gagal!',
						'message'	=> 'Perubahan Partai gagal, silahkan coba lagi',
						'status' 	=> 'error'
						);
					$this->session->set_flashdata('notify', $notify);
					redirect(base_url().'datamaster/partai');
				}
			}

			$data = array();
			$data['getDetail']  	= $this->partai_model->getDetail($partyId)->row_array();
			$this->template->display('datamaster/partai/update', $data);
		}else{
			$this->access->redirect('404');
		}
	}

	public function create(){
		if($this->access->permission('create')){	

			if($post = $this->input->post()){
				
				$config['upload_path'] = './assets/upload/';
				$config['allowed_types'] = 'gif|jpg|png';
				$new_name = time()."_";
				$config['file_name'] = $new_name;
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				$field_name = "add_icon";
				$ifUpload = 0;
				$ext = "";
				$imgpath="";
				if($this->upload->do_upload('add_icon'))
				{
					$dataupdload = $this->upload->data();
					$ext = $dataupdload["file_ext"];
					$ifUpload = 1;
					$imgpath = "assets/upload/" . $dataupdload["file_name"];
				}else{
					$error = array('error' => $this->upload->display_errors());
				}

				$datacreate = array(
						'party_code' 				=> isset($post['add_code'])?$post['add_code']:'',
						'party_icon' 				=> $imgpath,
						'party_name'				=> isset($post['add_name'])?$post['add_name']:'',
						'party_create_user_id'		=> $this->session->userdata('user_id'),
						'party_create_date'			=> date('Y-m-d H:i:s'),
						'party_status' 				=> 1
				);

				$insDb = $this->partai_model->addParties($datacreate);
				if($insDb > 0){
					$notify = array(
							'title' 	=> 'Berhasil!',
							'message' 	=> 'Penambahan data Berhasil',
							'status' 	=> 'success'
						);
					$this->session->set_flashdata('notify', $notify);
					redirect(base_url().'datamaster/partai/');
				}else{
					$notify = array(
							'title' 	=> 'Gagal!',
							'message'	=> 'Penambahan data gagal, silahkan coba lagi',
							'status' 	=> 'error'
						);
					$this->session->set_flashdata('notify', $notify);
					redirect(base_url().'datamaster/partai');
				}

			} else {
				$data = array();
				$this->template->display('datamaster/partai/create', $data);
			}
		}else{
			$this->access->redirect('404');
		}
	}

	public function listdataaktif(){
		$default_order = "party_name";
		$limit = 10;

		$order_field 	= array(
			'party_id',
			'party_code',
			'party_icon',
			'party_name',
			);
		$order_key 	= ($this->input->get('iSortCol_0')=="0")?"0":$this->input->get('iSortCol_0');
		$order 		= (!$this->input->get('iSortCol_0'))?$default_order:$order_field[$order_key];
		$sort 		= (!$this->input->get('sSortDir_0'))?'asc':$this->input->get('sSortDir_0');
		$search 	= (!$this->input->get('sSearch'))?'':strtoupper($this->input->get('sSearch'));
		$limit 		= (!$this->input->get('iDisplayLength'))?$limit:$this->input->get('iDisplayLength');
		$start 		= (!$this->input->get('iDisplayStart'))?0:$this->input->get('iDisplayStart');
		$data['sEcho'] = $this->input->get('sEcho');
		$data['iTotalRecords'][] = $this->partai_model->count_all($search,$order_field);
		$data['iTotalDisplayRecords'][] = $this->partai_model->count_all($search,$order_field);


		$aaData = array();
		$getData 	= $this->partai_model->get_paged_list($limit, $start, $order, $sort, $search, $order_field)->result_array();
		$no = (($start == 0) ? 1 : $start + 1);
		foreach ($getData as $row) {
			$aaData[] = array(
				'<center>'.$no.'</center>',
				$row["party_code"],
				$row["party_icon"],
				$row["party_name"],
				'<a href="'.base_url().'datamaster/partai/detail/'.$row["party_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Lihat" data-placement="top"><i class="icon-file6"></i></a>
				<a href="'.base_url().'datamaster/partai/update/'.$row["party_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Edit" data-placement="top"><i class="icon-pencil"></i></a>
				<a href="'.base_url().'datamaster/partai/delete/'.$row["party_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Non Aktifkan" data-placement="top"><i class="icon-close"></i></a>');
			$no++;
		}
		$data['aaData'] = $aaData;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function listdatanonaktif(){
		$default_order = "party_name";
		$limit = 10;

		$order_field 	= array(
			'party_id',
			'party_code',
			'party_icon',
			'party_name',
			);
		$order_key 	= ($this->input->get('iSortCol_0')=="0")?"0":$this->input->get('iSortCol_0');
		$order 		= (!$this->input->get('iSortCol_0'))?$default_order:$order_field[$order_key];
		$sort 		= (!$this->input->get('sSortDir_0'))?'asc':$this->input->get('sSortDir_0');
		$search 	= (!$this->input->get('sSearch'))?'':strtoupper($this->input->get('sSearch'));
		$limit 		= (!$this->input->get('iDisplayLength'))?$limit:$this->input->get('iDisplayLength');
		$start 		= (!$this->input->get('iDisplayStart'))?0:$this->input->get('iDisplayStart');
		$data['sEcho'] = $this->input->get('sEcho');
		$data['iTotalRecords'][] = $this->partai_model->count_allnonaktif($search,$order_field);
		$data['iTotalDisplayRecords'][] = $this->partai_model->count_allnonaktif($search,$order_field);


		$aaData = array();
		$getData 	= $this->partai_model->get_paged_listnonaktif($limit, $start, $order, $sort, $search, $order_field)->result_array();
		$no = (($start == 0) ? 1 : $start + 1);
		foreach ($getData as $row) {
			$aaData[] = array(
				'<center>'.$no.'</center>',
				$row["party_code"],
				$row["party_icon"],
				$row["party_name"],
				'<a href="'.base_url().'datamaster/partai/detail/'.$row["party_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Lihat" data-placement="top"><i class="icon-file6"></i></a> '.
				'<a href="'.base_url().'datamaster/partai/aktif/'.$row["party_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Aktifkan" data-placement="top"><i class="icon-checkmark3"></i></a>');
			$no++;
		}
		$data['aaData'] = $aaData;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function detail($id=0){
		if($this->access->permission('read')){
			$partaiId = $this->partai_model->getDetail($id)->row_array();
			$data["partai"] = $partaiId;
			$this->template->display('datamaster/partai/detail', $data);
		}
	}

	public function delete($partyId = 0){

		$partyIdFilter = filter_var($partyId, FILTER_SANITIZE_NUMBER_INT);
		if($this->access->permission('delete')) {
			if($partyId==$partyIdFilter) {

				$del = $this->partai_model->deleteParties($partyId);
				$notify = array(
					'title' 	=> 'Berhasil!',
					'message' 	=> 'Partai dinonaktifkan',
					'status' 	=> 'success'
					);
				$this->session->set_flashdata('notify', $notify);

				redirect(base_url().'datamaster/partai');
			} else {
				$notify = array(
					'title' 	=> 'Gagal!',
					'message' 	=> 'Partai gagal dinonaktifkan',
					'status' 	=> 'error'
					);
				$this->session->set_flashdata('notify', $notify);
				redirect(base_url().'datamaster/partai');
			}
		} else {
			$notify = array(
				'title' 	=> 'Gagal!',
				'message' 	=> 'Partai gagal dinonaktifkan',
				'status' 	=> 'error'
				);
			$this->session->set_flashdata('notify', $notify);
			redirect(base_url().'datamaster/partai');
		}
	}

	public function aktif($partyId = 0){

		$partyIdFilter = filter_var($partyId, FILTER_SANITIZE_NUMBER_INT);
		if($this->access->permission('update')) {
			if($partyId==$partyIdFilter) {

				$del = $this->partai_model->aktifParties($partyId);
				$notify = array(
					'title' 	=> 'Berhasil!',
					'message' 	=> 'Partai diaktifkan',
					'status' 	=> 'success'
					);
				$this->session->set_flashdata('notify', $notify);

				redirect(base_url().'datamaster/partai');
			} else {
				$notify = array(
					'title' 	=> 'Gagal!',
					'message' 	=> 'Partai gagal diaktifkan',
					'status' 	=> 'error'
					);
				$this->session->set_flashdata('notify', $notify);
				redirect(base_url().'datamaster/partai');
			}
		} else {
			$notify = array(
				'title' 	=> 'Gagal!',
				'message' 	=> 'Partai gagal diaktifkan',
				'status' 	=> 'error'
				);
			$this->session->set_flashdata('notify', $notify);
			redirect(base_url().'datamaster/partai');
		}
	}
}