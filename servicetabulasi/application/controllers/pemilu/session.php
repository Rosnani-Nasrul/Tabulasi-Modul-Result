<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Session extends CI_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('pemilu/session_model');
		$this->load->helper('xml');
		$this->load->helper('text');
	}

	public function index(){
		$data = array();
		$this->template->display('pemilu/kepaladaerah/session/index', $data);
	}

	public function pilkada() {
        $this->output->set_content_type('application/json')->set_output(json_encode($this->session_model->getListPilkada()));
    }

	public function candidate($id) {
        $this->output->set_content_type('application/json')->set_output(json_encode($this->session_model->getListCandidat($id)));
    }

    public function putaran($id) {
        $this->output->set_content_type('application/json')->set_output(json_encode($this->session_model->getListSession($id)));
    }

	function update($sessionId = 0){
		if($this->access->permission('read')){

			if($post = $this->input->post()){
				
				$getTrx = $this->session_model->getTrxSession($sessionId)->row_array();
				
				$dataupdatesession = array(
					'pilkada_session_code' 				=> isset($post['add_code'])?$post['add_code']:'',
					'pilkada_session_name'				=> isset($post['add_name'])?$post['add_name']:'',
					'pilkada_session_pilkada_id'		=> isset($post['add_pilkada'])?$post['add_pilkada']:'',
					'pilkada_session_date_start'		=> date("Y-m-d H:i:s",strtotime($post['add_start'])),
					'pilkada_session_date_end'			=> date("Y-m-d H:i:s",strtotime($post['add_end']))
					);
				$insDb = $this->session_model->updateSession($dataupdatesession, $getTrx['pilkada_session_id']);
				// if($id > 0){
				// $dataupdate = array(
				// 	'pilkada_session_member_pilkada_session_id'			=> $id,
				// 	'pilkada_session_member_pilkada_candidate_id' 		=> isset($post['add_candidat'])?$post['add_candidat']:''
				// 	);

				
				// $insDb = $this->session_model->updateSessionMember($sessionId, $dataupdate);

				if($insDb > 0){
					$notify = array(
						'title' 	=> 'Berhasil!',
						'message' 	=> 'Perubahan Data Session Berhasil',
						'status' 	=> 'success'
						);
					$this->session->set_flashdata('notify', $notify);

					redirect(base_url().'pemilu/session');
				}else{
					$notify = array(
						'title' 	=> 'Gagal!',
						'message'	=> 'Perubahan Data Session gagal, silahkan coba lagi',
						'status' 	=> 'error'
						);
					$this->session->set_flashdata('notify', $notify);
					redirect(base_url().'pemilu/session');
					}
				}

			$data = array();
			$data['getDetail']  	= $this->session_model->getDetail($sessionId)->row_array();
			// $data['pilkadaList']  	= $this->session_model->getListPilkada()->result_array();
			// $data['candidateList']  = $this->session_model->getListCandidat()->result_array();
			// $data['accList']  		= $this->pilkada_model->getListAcc()->result_array();
			// $data['List']  			= $this->pilkada_model->ListAcc()->row_array();
			$this->template->display('pemilu/kepaladaerah/session/update', $data);
		}else{
			$this->access->redirect('404');
		}
	}

	public function create(){
		if($this->access->permission('create')){
			
			if($post = $this->input->post()){
				$datapost = array(
						'pilkada_session_code' 				=> isset($post['add_code'])?$post['add_code']:'',
						'pilkada_session_name'				=> isset($post['add_name'])?$post['add_name']:'',
						'pilkada_session_pilkada_id'		=> isset($post['add_pilkada'])?$post['add_pilkada']:'',
						'pilkada_session_date_start'		=> isset($post['add_start'])?$post['add_start']:'',
						'pilkada_session_create_user_id'	=> $this->session->userdata('user_id'),
						'pilkada_session_create_date' 		=> date('Y-m-d H:i:s'),
						'pilkada_session_status' 			=> 1
					);

				$sessionId = $this->session_model->addSession($datapost);
				if($sessionId > 0){

					$notify = array(
							'title' 	=> 'Berhasil!',
							'message' 	=> 'Tambah Data Session Berhasil',
							'status' 	=> 'success'
							);
						$this->session->set_flashdata('notify', $notify);
					}else{
						$notify = array(
							'title' 	=> 'Gagal!',
							'message' 	=> 'Tambah Data Session gagal, silahkan coba lagi',
							'status' 	=> 'error'
							);
						$this->session->set_flashdata('notify', $notify);
					}

				$candidats = $this->input->post('add_candidat');

			 	foreach ($candidats as $candidat) {

				$datapostsessionmember = array(
					'pilkada_session_member_pilkada_candidate_id' 		=> $candidat,
					'pilkada_session_member_pilkada_session_id'			=> $sessionId,
					'pilkada_session_member_create_user_id'				=> $this->session->userdata('user_id'),
					'pilkada_session_member_create_date' 				=> date('Y-m-d H:i:s'),
					'pilkada_session_member_status' 					=> 1
					
						);
					$insDb = $this->session_model->addSessionMember($datapostsessionmember);
					if($insDb > 0){
						$notify = array(
							'title' 	=> 'Berhasil!',
							'message' 	=> 'Tambah Data Session Berhasil',
							'status' 	=> 'success'
							);
						$this->session->set_flashdata('notify', $notify);
					}else{
						$notify = array(
							'title' 	=> 'Gagal!',
							'message' 	=> 'Tambah Data Session gagal, silahkan coba lagi',
							'status' 	=> 'error'
							);
						$this->session->set_flashdata('notify', $notify);
					}
				}
				redirect(base_url().'pemilu/session');
			}
			$data = array();
			// $data['accList']  	= $this->pengguna_model->getListAcc()->result_array();
			// $data['pilkadaList']  	= $this->session_model->getListPilkada()->result_array();
			// $data['candidateList']  = $this->session_model->getListCandidat()->result_array();
			$this->template->display('pemilu/kepaladaerah/session/create', $data);
		} else {
			$this->access->redirect('404');
		}
	}

	public function createcandidate(){
		if($this->access->permission('create')){
			
			if($post = $this->input->post()){
				$datapostsessionmember = array(
						'pilkada_session_member_pilkada_candidate_id' 		=> isset($post['add_candidat'])?$post['add_candidat']:'',
						'pilkada_session_member_pilkada_session_id'			=> isset($post['add_name'])?$post['add_name']:'',
						'pilkada_session_member_create_user_id'				=> $this->session->userdata('user_id'),
						'pilkada_session_member_create_date' 				=> date('Y-m-d H:i:s'),
						'pilkada_session_member_status' 					=> 1

					);

				// $sessionId = $this->session_model->addSessionMember($datapostsessionmember);
				// if($sessionId > 0){
				// $datapost = array(

				// 		'pilkada_session_pilkada_id'		=> isset($post['add_pilkada'])?$post['add_pilkada']:'',
				// 		'pilkada_session_create_user_id'	=> $this->session->userdata('user_id'),
				// 		'pilkada_session_create_date' 		=> date('d-m-Y H:i:s'),
				// 		'pilkada_session_status' 			=> 1
					
				// 		);
					$insDb = $this->session_model->addSessionMember($datapostsessionmember);
					if($insDb > 0){
						$notify = array(
							'title' 	=> 'Berhasil!',
							'message' 	=> 'Tambah Data Kandidat Berhasil',
							'status' 	=> 'success'
							);
						$this->session->set_flashdata('notify', $notify);
						
						redirect(base_url().'pemilu/session');
					}else{
						$notify = array(
							'title' 	=> 'Gagal!',
							'message' 	=> 'Tambah Data Kandidat gagal, silahkan coba lagi',
							'status' 	=> 'error'
							);
						$this->session->set_flashdata('notify', $notify);
						
						redirect(base_url().'pemilu/session');
					}
				// }
			}
			$data = array();
			// $data['accList']  	= $this->pengguna_model->getListAcc()->result_array();
			// $data['sessionList']	= $this->session_model->getListSession()->result_array();
			// $data['pilkadaList']  	= $this->session_model->getListPilkada()->result_array();
			// $data['candidateList']  = $this->session_model->getListCandidat()->result_array();
			$this->template->display('pemilu/kepaladaerah/session/createcandidate', $data);
		} else {
			$this->access->redirect('404');
		}
	}

	public function detail($sessionId=0){
		if($this->access->permission('read')){
			$session = $this->session_model->getDetail($sessionId)->row_array();
			$data["session"] = $session;
			$this->template->display('pemilu/kepaladaerah/session/detail', $data);
		}
	}

	public function listdataaktif(){
		$default_order = "pilkada_session_id";
		$limit = 10;

		$order_field 	= array(
			'pilkada_session_id',
			'pilkada_session_name',
			);
		$order_key 	= ($this->input->get('iSortCol_0')=="0")?"0":$this->input->get('iSortCol_0');
		$order 		= (!$this->input->get('iSortCol_0'))?$default_order:$order_field[$order_key];
		$sort 		= (!$this->input->get('sSortDir_0'))?'asc':$this->input->get('sSortDir_0');
		$search 	= (!$this->input->get('sSearch'))?'':strtoupper($this->input->get('sSearch'));
		$limit 		= (!$this->input->get('iDisplayLength'))?$limit:$this->input->get('iDisplayLength');
		$start 		= (!$this->input->get('iDisplayStart'))?0:$this->input->get('iDisplayStart');
		$data['sEcho'] = $this->input->get('sEcho');
		$data['iTotalRecords'][] = $this->session_model->count_all($search,$order_field);
		$data['iTotalDisplayRecords'][] = $this->session_model->count_all($search,$order_field);


		$aaData = array();
		$getData 	= $this->session_model->get_paged_list($limit, $start, $order, $sort, $search, $order_field)->result_array();
		$no = (($start == 0) ? 1 : $start + 1);
		foreach ($getData as $row) {
			$aaData[] = array(
				'<center>'.$no.'</center>',
				$row["pilkada_session_name"],
				'<a href="'.base_url().'pemilu/session/detail/'.$row["pilkada_session_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Lihat" data-placement="top"><i class="icon-file6"></i></a>
				<a href="'.base_url().'pemilu/session/update/'.$row["pilkada_session_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Edit" data-placement="top"><i class="icon-pencil"></i></a>
				<a href="'.base_url().'pemilu/session/delete/'.$row["pilkada_session_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Non Aktifkan" data-placement="top"><i class="icon-close"></i></a>');
			$no++;
		}
		$data['aaData'] = $aaData;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function listdatanonaktif(){
		$default_order = "pilkada_session_id";
		$limit = 10;

		$order_field 	= array(
			'pilkada_session_id',
			'pilkada_session_name',
			);
		$order_key 	= ($this->input->get('iSortCol_0')=="0")?"0":$this->input->get('iSortCol_0');
		$order 		= (!$this->input->get('iSortCol_0'))?$default_order:$order_field[$order_key];
		$sort 		= (!$this->input->get('sSortDir_0'))?'asc':$this->input->get('sSortDir_0');
		$search 	= (!$this->input->get('sSearch'))?'':strtoupper($this->input->get('sSearch'));
		$limit 		= (!$this->input->get('iDisplayLength'))?$limit:$this->input->get('iDisplayLength');
		$start 		= (!$this->input->get('iDisplayStart'))?0:$this->input->get('iDisplayStart');
		$data['sEcho'] = $this->input->get('sEcho');
		$data['iTotalRecords'][] = $this->session_model->count_allnonaktif($search,$order_field);
		$data['iTotalDisplayRecords'][] = $this->session_model->count_allnonaktif($search,$order_field);


		$aaData = array();
		$getData 	= $this->session_model->get_paged_listnonaktif($limit, $start, $order, $sort, $search, $order_field)->result_array();
		$no = (($start == 0) ? 1 : $start + 1);
		foreach ($getData as $row) {
			$aaData[] = array(
				'<center>'.$no.'</center>',
				$row["pilkada_session_name"],
				'<a href="'.base_url().'pemilu/session/detail/'.$row["pilkada_session_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Lihat" data-placement="top"><i class="icon-file6"></i></a> '.
				'<a href="'.base_url().'pemilu/session/aktif/'.$row["pilkada_session_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Aktifkan" data-placement="top"><i class="icon-checkmark3"></i></a>');
			$no++;
		}
		$data['aaData'] = $aaData;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function listdatacandidat($id){
		$default_order = "pilkada_candidate_id";
		$limit = 10;

		$order_field 	= array(
			'pilkada_candidate_id',
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
		$data['iTotalRecords'][] = $this->session_model->count_allcandidat($search,$order_field,$id);
		$data['iTotalDisplayRecords'][] = $this->session_model->count_allcandidat($search,$order_field,$id);


		$aaData = array();
		$getData 	= $this->session_model->get_paged_listcandidat($limit, $start, $order, $sort, $search, $order_field, $id)->result_array();
		$no = (($start == 0) ? 1 : $start + 1);
		foreach ($getData as $row) {
			$aaData[] = array(
				'<center>'.$no.'</center>',
				$row["pilkada_candidate_name"],
				$row["pilkada_candidate_photo_path"],
				'<a href="'.base_url().'pemilu/session/detail/'.$row["pilkada_candidate_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Lihat" data-placement="top"><i class="icon-file6"></i></a>
				<a href="'.base_url().'pemilu/session/update/'.$row["pilkada_candidate_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Edit" data-placement="top"><i class="icon-pencil"></i></a>');
			$no++;
		}
		$data['aaData'] = $aaData;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function delete($sessionId = 0){

		$sessionIdFilter = filter_var($sessionId, FILTER_SANITIZE_NUMBER_INT);
		if($this->access->permission('delete')) {
			if($sessionId==$sessionIdFilter) {

				// $dataupdate = array(
				// 	'user_update_by' 			=> $this->session->userdata('user_id'),
				// 	'user_update_date' 			=> date('Y-m-d H:i:s')
				// 	);

				$del = $this->session_model->deleteSession($sessionId);
				$notify = array(
					'title' 	=> 'Berhasil!',
					'message' 	=> 'Data Session dinonaktifkan',
					'status' 	=> 'success'
					);
				$this->session->set_flashdata('notify', $notify);

				redirect(base_url().'pemilu/session');
			} else {
				$notify = array(
					'title' 	=> 'Gagal!',
					'message' 	=> 'Data Session gagal dinonaktifkan',
					'status' 	=> 'error'
					);
				$this->session->set_flashdata('notify', $notify);
				redirect(base_url().'pemilu/session');
			}
		} else {
			$notify = array(
				'title' 	=> 'Gagal!',
				'message' 	=> 'Data Session gagal dinonaktifkan',
				'status' 	=> 'error'
				);
			$this->session->set_flashdata('notify', $notify);
			redirect(base_url().'pemilu/session');
		}
	}

	public function aktif($sessionId = 0){

		$sessionIdFilter = filter_var($sessionId, FILTER_SANITIZE_NUMBER_INT);
		if($this->access->permission('update')) {
			if($sessionId==$sessionIdFilter) {

				// $dataupdate = array(
				// 	'user_update_by' 			=> $this->session->userdata('user_id'),
				// 	'user_update_date' 			=> date('Y-m-d H:i:s')
				// 	);

				$del = $this->session_model->aktifSession($sessionId);
				$notify = array(
					'title' 	=> 'Berhasil!',
					'message' 	=> 'Data Session diaktifkan',
					'status' 	=> 'success'
					);
				$this->session->set_flashdata('notify', $notify);

				redirect(base_url().'pemilu/session');
			} else {
				$notify = array(
					'title' 	=> 'Gagal!',
					'message' 	=> 'Data Session gagal diaktifkan',
					'status' 	=> 'error'
					);
				$this->session->set_flashdata('notify', $notify);
				redirect(base_url().'pemilu/session');
			}
		} else {
			$notify = array(
				'title' 	=> 'Gagal!',
				'message' 	=> 'Data Session gagal diaktifkan',
				'status' 	=> 'error'
				);
			$this->session->set_flashdata('notify', $notify);
			redirect(base_url().'pemilu/session');
		}
	}
}