<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kandidat extends CI_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('pemilu/kandidat_model');
		$this->load->helper('xml');
		$this->load->helper('text');
	}

	public function index(){
		$data = array();
		$this->template->display('pemilu/kepaladaerah/kandidat/index', $data);
	}

	function update($candidateId = 0){
		if($this->access->permission('read')){

			if($post = $this->input->post()){

				$getTrx = $this->kandidat_model->getTrxKandidat($candidateId)->row_array();

				$config['upload_path'] = './assets/upload/candidate/';
				$config['allowed_types'] = 'gif|jpg|png';
				$new_name = time()."_";
				$config['file_name'] = $new_name;
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				$field_name = "add_photo";
				$ifUpload = 0;
				$ext = "";
				$imgpath="";
				if($this->upload->do_upload('add_photo'))
				{
					$dataupdload = $this->upload->data();
					$ext = $dataupdload["file_ext"];
					$ifUpload = 1;
					$imgpath = "assets/upload/candidate/" . $dataupdload["file_name"];
				}else{
					$error = array('error' => $this->upload->display_errors());
				}

				$dataupdatekandidat = array(
					'pilkada_candidate_code' 			=> isset($post['add_code'])?$post['add_code']:'',
					'pilkada_candidate_pilkada_id' 		=> isset($post['add_id'])?$post['add_id']:'',
					'pilkada_candidate_name'			=> isset($post['add_name'])?$post['add_name']:'',
					'pilkada_candidate_photo_path'		=> $imgpath !=""?$imgpath:$adata['pilkada_candidate_photo_path'],
					'pilkada_candidate_number'			=> isset($post['add_number'])?$post['add_number']:'',
					'pilkada_candidate_visi'			=> isset($post['add_visi'])?$post['add_visi']:'',
					'pilkada_candidate_misi'			=> isset($post['add_misi'])?$post['add_misi']:'',
					'pilkada_candidate_jargon'			=> isset($post['add_jargon'])?$post['add_jargon']:'',
						);
					$insDb = $this->kandidat_model->updateKandidat($dataupdatekandidat, $candidateId);

					if($insDb > 0){
						$notify = array(
							'title' 	=> 'Berhasil!',
							'message' 	=> 'Perubahan Data Kandidat Berhasil',
							'status' 	=> 'success'
							);
						$this->session->set_flashdata('notify', $notify);
					}else{
						$notify = array(
							'title' 	=> 'Gagal!',
							'message' 	=> 'Perubahan Data Kandidat gagal, silahkan coba lagi',
							'status' 	=> 'error'
							);
						$this->session->set_flashdata('notify', $notify);
					}
					$types = $this->input->post('add_parties');
				    $no=1;
			 		foreach ($types as $type) {
			 		  if($no==1){
			 		  	$candidate_id=$post['add_politician1'];
			 		  	$politician_id=1;
			 		  }
			 		  else {
			 		  	$candidate_id=$post['add_politician2'];
			 		  	$politician_id=2;
			 		  }


					$dataupdateparty = array(
						'pilkada_politician_party_id' 				=> $type,
						'pilkada_politician_pilkada_candidate_id'	=> $insDb,
						'pilkada_politician_politician_id'			=> $candidate_id,
						'pilkada_politician_create_user_id'			=> $this->session->userdata('user_id'),
						'pilkada_politician_position'				=> $politician_id,
						);

				      	$bg=$this->kandidat_model->updateParty($dataupdateparty, $candidateId);
				      	if($bg > 0){
						$notify = array(
							'title' 	=> 'Berhasil!',
							'message' 	=> 'Perubahan Data Kandidat Berhasil',
							'status' 	=> 'success'
							);
						$this->session->set_flashdata('notify', $notify);
						
						
					}else{
						$notify = array(
							'title' 	=> 'Gagal!',
							'message' 	=> 'Perubahan Data Kandidat gagal, silahkan coba lagi',
							'status' 	=> 'error'
							);
						$this->session->set_flashdata('notify', $notify);
						
						
					}
						$no++;
					 }

					 redirect(base_url().'pemilu/kandidat');
					}
				
			$data = array();
			$data['getDetail']  	= $this->kandidat_model->getDetail($candidateId)->row_array();
			$data['politicianList'] = $this->kandidat_model->getListPolitician()->result_array();
			$data['kandidatList']  	= $this->kandidat_model->getListKandidat()->result_array();
			$data['partytList']  	= $this->kandidat_model->getListParty()->result_array();
			$this->template->display('pemilu/kepaladaerah/kandidat/update', $data);
		} else {
			$this->access->redirect('404');
		}
	}

	public function create(){
		if($this->access->permission('create')){
			
			if($post = $this->input->post()){

				$config['upload_path'] = './assets/upload/candidate/';
				$config['allowed_types'] = 'gif|jpg|png';
				$new_name = time()."_";
				$config['file_name'] = $new_name;
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				$field_name = "add_photo";
				$ifUpload = 0;
				$ext = "";
				$imgpath="";
				if($this->upload->do_upload('add_photo'))
				{
					$dataupdload = $this->upload->data();
					$ext = $dataupdload["file_ext"];
					$ifUpload = 1;
					$imgpath = "assets/upload/candidate/" . $dataupdload["file_name"];
				}else{
					$error = array('error' => $this->upload->display_errors());
				}

				$datapostkandidat = array(
					'pilkada_candidate_code' 			=> isset($post['add_code'])?$post['add_code']:'',
					'pilkada_candidate_pilkada_id' 		=> isset($post['add_id'])?$post['add_id']:'',
					'pilkada_candidate_name'			=> isset($post['add_name'])?$post['add_name']:'',
					'pilkada_candidate_photo_path'		=> $imgpath,
					'pilkada_candidate_number'			=> isset($post['add_number'])?$post['add_number']:'',
					'pilkada_candidate_visi'			=> isset($post['add_visi'])?$post['add_visi']:'',
					'pilkada_candidate_misi'			=> isset($post['add_misi'])?$post['add_misi']:'',
					'pilkada_candidate_jargon'			=> isset($post['add_jargon'])?$post['add_jargon']:'',
					'pilkada_candidate_create_user_id'	=> $this->session->userdata('user_id'),
					'pilkada_candidate_create_date' 	=> date('Y-m-d H:i:s'),
					'pilkada_candidate_status' 			=> 1
						);
					$insDb = $this->kandidat_model->addKandidat($datapostkandidat);

					if($insDb > 0){
						$notify = array(
							'title' 	=> 'Berhasil!',
							'message' 	=> 'Tambah Data Kandidat Berhasil',
							'status' 	=> 'success'
							);
						$this->session->set_flashdata('notify', $notify);
					}else{
						$notify = array(
							'title' 	=> 'Gagal!',
							'message' 	=> 'Tambah Data Kandidat gagal, silahkan coba lagi',
							'status' 	=> 'error'
							);
						$this->session->set_flashdata('notify', $notify);
					}
					$types = $this->input->post('add_parties');
				    $no=1;
			 		foreach ($types as $type) {
			 		  if($no==1){
			 		  	$candidate_id=$post['add_politician1'];
			 		  	$politician_id=1;
			 		  }
			 		  else {
			 		  	$candidate_id=$post['add_politician2'];
			 		  	$politician_id=2;
			 		  }


					$datapost = array(
						'pilkada_politician_party_id' 				=> $type,
						'pilkada_politician_pilkada_candidate_id'	=> $insDb,
						'pilkada_politician_politician_id'			=> $candidate_id,
						'pilkada_politician_create_user_id'			=> $this->session->userdata('user_id'),
						'pilkada_politician_position'				=> $politician_id,
						'pilkada_politician_create_date' 			=> date('Y-m-d H:i:s'),
						'pilkada_politician_status' 				=> 1
						);

				      	$bg=$this->kandidat_model->addParty($datapost);
				      	if($bg > 0){
						$notify = array(
							'title' 	=> 'Berhasil!',
							'message' 	=> 'Tambah Data Kandidat Berhasil',
							'status' 	=> 'success'
							);
						$this->session->set_flashdata('notify', $notify);
						
						
					}else{
						$notify = array(
							'title' 	=> 'Gagal!',
							'message' 	=> 'Tambah Data Kandidat gagal, silahkan coba lagi',
							'status' 	=> 'error'
							);
						$this->session->set_flashdata('notify', $notify);
						
						
					}
						$no++;
					 }

					 redirect(base_url().'pemilu/kandidat');
					}
				
			$data = array();
			// $data['accList']  	= $this->pengguna_model->getListAcc()->result_array();
			$data['politicianList']  	= $this->kandidat_model->getListPolitician()->result_array();
			$data['kandidatList']  	= $this->kandidat_model->getListKandidat()->result_array();
			$data['partytList']  	= $this->kandidat_model->getListParty()->result_array();
			$this->template->display('pemilu/kepaladaerah/kandidat/create', $data);
		} else {
			$this->access->redirect('404');
		}
	}
	public function detail($id=0){
		if($this->access->permission('read')){
			$kandidat = $this->kandidat_model->getDetail($id)->row_array();
			$kandidats= $this->kandidat_model->getDetail($id)->result();
			$data["kandidat"] = $kandidat;
			$datas["kandidats"]=$kandidats;
			$this->template->display('pemilu/kepaladaerah/kandidat/detail', array_merge($data,$datas));
		}
	}

	public function listdataaktif(){
		$default_order = "pilkada_candidate_id";
		$limit = 10;

		$order_field 	= array(
			'pilkada_candidate_id',
			'pilkada_candidate_code',
			'pilkada_candidate_name',
			'pilkada_candidate_photo_path',
			);
		$order_key 	= ($this->input->get('iSortCol_0')=="0")?"0":$this->input->get('iSortCol_0');
		$order 		= (!$this->input->get('iSortCol_0'))?$default_order:$order_field[$order_key];
		$sort 		= (!$this->input->get('sSortDir_0'))?'asc':$this->input->get('sSortDir_0');
		$search 	= (!$this->input->get('sSearch'))?'':strtoupper($this->input->get('sSearch'));
		$limit 		= (!$this->input->get('iDisplayLength'))?$limit:$this->input->get('iDisplayLength');
		$start 		= (!$this->input->get('iDisplayStart'))?0:$this->input->get('iDisplayStart');
		$data['sEcho'] = $this->input->get('sEcho');
		$data['iTotalRecords'][] = $this->kandidat_model->count_all($search,$order_field);
		$data['iTotalDisplayRecords'][] = $this->kandidat_model->count_all($search,$order_field);


		$aaData = array();
		$getData 	= $this->kandidat_model->get_paged_list($limit, $start, $order, $sort, $search, $order_field)->result_array();
		$no = (($start == 0) ? 1 : $start + 1);
		foreach ($getData as $row) {
			$aaData[] = array(
				'<center>'.$no.'</center>',
				$row["pilkada_candidate_code"],
				$row["pilkada_candidate_name"],
				$row["pilkada_candidate_photo_path"],
				'<a href="'.base_url().'pemilu/kandidat/detail/'.$row["pilkada_candidate_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Lihat" data-placement="top"><i class="icon-file6"></i></a>
				<a href="'.base_url().'pemilu/kandidat/update/'.$row["pilkada_candidate_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Edit" data-placement="top"><i class="icon-pencil"></i></a>
				<a href="'.base_url().'pemilu/kandidat/delete/'.$row["pilkada_candidate_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Non Aktifkan" data-placement="top"><i class="icon-close"></i></a>');
			$no++;
		}
		$data['aaData'] = $aaData;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function listdatanonaktif(){
		$default_order = "pilkada_candidate_id";
		$limit = 10;

		$order_field 	= array(
			'pilkada_candidate_id',
			'pilkada_candidate_code',
			'pilkada_candidate_name',
			'pilkada_candidate_photo_path',
			);
		$order_key 	= ($this->input->get('iSortCol_0')=="0")?"0":$this->input->get('iSortCol_0');
		$order 		= (!$this->input->get('iSortCol_0'))?$default_order:$order_field[$order_key];
		$sort 		= (!$this->input->get('sSortDir_0'))?'asc':$this->input->get('sSortDir_0');
		$search 	= (!$this->input->get('sSearch'))?'':strtoupper($this->input->get('sSearch'));
		$limit 		= (!$this->input->get('iDisplayLength'))?$limit:$this->input->get('iDisplayLength');
		$start 		= (!$this->input->get('iDisplayStart'))?0:$this->input->get('iDisplayStart');
		$data['sEcho'] = $this->input->get('sEcho');
		$data['iTotalRecords'][] = $this->kandidat_model->count_allnonaktif($search,$order_field);
		$data['iTotalDisplayRecords'][] = $this->kandidat_model->count_allnonaktif($search,$order_field);


		$aaData = array();
		$getData 	= $this->kandidat_model->get_paged_listnonaktif($limit, $start, $order, $sort, $search, $order_field)->result_array();
		$no = (($start == 0) ? 1 : $start + 1);
		foreach ($getData as $row) {
			$aaData[] = array(
				'<center>'.$no.'</center>',
				$row["pilkada_candidate_code"],
				$row["pilkada_candidate_name"],
				$row["pilkada_candidate_photo_path"],
				'<a href="'.base_url().'pemilu/kandidat/detail/'.$row["pilkada_candidate_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Lihat" data-placement="top"><i class="icon-file6"></i></a> '.
				'<a href="'.base_url().'pemilu/kandidat/aktif/'.$row["pilkada_candidate_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Aktifkan" data-placement="top"><i class="icon-checkmark3"></i></a>');
			$no++;
		}
		$data['aaData'] = $aaData;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function delete($candidateId = 0){

		$candidateIdFilter = filter_var($candidateId, FILTER_SANITIZE_NUMBER_INT);
		if($this->access->permission('delete')) {
			if($candidateId==$candidateIdFilter) {

				// $dataupdate = array(
				// 	'user_update_by' 			=> $this->session->userdata('user_id'),
				// 	'user_update_date' 			=> date('Y-m-d H:i:s')
				// 	);

				$del = $this->kandidat_model->deleteKandidat($candidateId);
				$notify = array(
					'title' 	=> 'Berhasil!',
					'message' 	=> 'Data Kandidat dinonaktifkan',
					'status' 	=> 'success'
					);
				$this->session->set_flashdata('notify', $notify);

				redirect(base_url().'pemilu/kandidat');
			} else {
				$notify = array(
					'title' 	=> 'Gagal!',
					'message' 	=> 'Data Kandidat gagal dinonaktifkan',
					'status' 	=> 'error'
					);
				$this->session->set_flashdata('notify', $notify);
				redirect(base_url().'pemilu/kandidat');
			}
		} else {
			$notify = array(
				'title' 	=> 'Gagal!',
				'message' 	=> 'Data Kandidat gagal dinonaktifkan',
				'status' 	=> 'error'
				);
			$this->session->set_flashdata('notify', $notify);
			redirect(base_url().'pemilu/kandidat');
		}
	}

	public function aktif($candidateId = 0){

		$candidateIdFilter = filter_var($candidateId, FILTER_SANITIZE_NUMBER_INT);
		if($this->access->permission('update')) {
			if($candidateId==$candidateIdFilter) {

				// $dataupdate = array(
				// 	'user_update_by' 			=> $this->session->userdata('user_id'),
				// 	'user_update_date' 			=> date('Y-m-d H:i:s')
				// 	);

				$del = $this->kandidat_model->aktifKandidat($candidateId);
				$notify = array(
					'title' 	=> 'Berhasil!',
					'message' 	=> 'Data Kandidat diaktifkan',
					'status' 	=> 'success'
					);
				$this->session->set_flashdata('notify', $notify);

				redirect(base_url().'pemilu/kandidat');
			} else {
				$notify = array(
					'title' 	=> 'Gagal!',
					'message' 	=> 'Data Kandidat gagal diaktifkan',
					'status' 	=> 'error'
					);
				$this->session->set_flashdata('notify', $notify);
				redirect(base_url().'pemilu/kandidat');
			}
		} else {
			$notify = array(
				'title' 	=> 'Gagal!',
				'message' 	=> 'Data Kandidat gagal diaktifkan',
				'status' 	=> 'error'
				);
			$this->session->set_flashdata('notify', $notify);
			redirect(base_url().'pemilu/kandidat');
		}
	}
}