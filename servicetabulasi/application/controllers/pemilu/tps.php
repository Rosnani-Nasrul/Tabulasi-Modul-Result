<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tps extends CI_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('pemilu/tps_model');
		$this->load->helper('xml');
		$this->load->helper('text');
	}

	public function index(){
		$data = array();
		$this->template->display('pemilu/kepaladaerah/tps/index', $data);
	}

	public function data_provinsi() {
        // $data = $this->tps_model->get_kabupaten($id)->result_array();
        // foreach ($data->result() as $d) {
        //     echo "<option value=$d->regency_id>$d->regency_name</option>";
        // }
        $this->output->set_content_type('application/json')->set_output(json_encode($this->tps_model->get_provinsi()));
    }

	public function data_kabupaten($id) {
        // $data = $this->tps_model->get_kabupaten($id)->result_array();
        // foreach ($data->result() as $d) {
        //     echo "<option value=$d->regency_id>$d->regency_name</option>";
        // }
        $this->output->set_content_type('application/json')->set_output(json_encode($this->tps_model->get_kabupaten($id)));
    }

    public function data_kecamatan($id) {
        // $data = $this->tps_model->get_kecamatan();
        // foreach ($data->result() as $k) {
        //     echo "<option value=$k->district_id>$k->district_name</option>";
        // }
        $this->output->set_content_type('application/json')->set_output(json_encode($this->tps_model->get_kecamatan($id)));
    }

     public function data_kelurahan($id) {
        // $data = $this->tps_model->get_kecamatan();
        // foreach ($data->result() as $k) {
        //     echo "<option value=$k->district_id>$k->district_name</option>";
        // }
        $this->output->set_content_type('application/json')->set_output(json_encode($this->tps_model->get_kelurahan($id)));
    }

	function update($tpsId = 0){
		if($this->access->permission('read')){

			if($post = $this->input->post()){
				
				$getTrx = $this->tps_model->getTrxTps($tpsId)->row_array();

				$config['upload_path'] = './assets/upload/tps/';
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
					$imgpath = "assets/upload/tps/" . $dataupdload["file_name"];
				}else{
					$error = array('error' => $this->upload->display_errors());
				}
				
				$dataupdatetps = array(
					'pilkada_tps_code' 				=> isset($post['add_code'])?$post['add_code']:'',
					'pilkada_tps_name' 				=> isset($post['add_name'])?$post['add_name']:'',
					'pilkada_tps_pilkada_id'		=> isset($post['add_pilkada'])?$post['add_pilkada']:'',
					'pilkada_tps_photo_path'		=> $imgpath !=""?$imgpath:$adata['pilkada_tps_photo_path'],
					'pilkada_tps_village_id'		=> isset($post['add_village'])?$post['add_village']:'',
					'pilkada_tps_address' 			=> isset($post['add_address'])?$post['add_address']:'',
					'pilkada_tps_total_voter'		=> isset($post['add_voter'])?$post['add_voter']:''
					);
				// $this->pengguna_model->updatePilkada($dataupdatepilkada,$getTrx['pilkada_area_id']);
				// $dataupdate = array(
				// 	'user_access_id' 			=> isset($post['add_accld'])?$post['add_accld']:'',
				// 	'user_update_by' 			=> $this->session->userdata('user_id'),
				// 	'user_update_date' 			=> date('Y-m-d H:i:s')
				// 	);

				
				$insDb = $this->tps_model->updateTps($dataupdatetps, $tpsId);

				if($insDb > 0){
					$notify = array(
						'title' 	=> 'Berhasil!',
						'message' 	=> 'Perubahan Data TPS Berhasil',
						'status' 	=> 'success'
						);
					$this->session->set_flashdata('notify', $notify);

					redirect(base_url().'pemilu/tps');
				}else{
					$notify = array(
						'title' 	=> 'Gagal!',
						'message'	=> 'Perubahan Data TPS gagal, silahkan coba lagi',
						'status' 	=> 'error'
						);
					$this->session->set_flashdata('notify', $notify);
					redirect(base_url().'pemilu/tps');
				}
			}

			$data = array();
			$data['getDetail']  	= $this->tps_model->getDetail($tpsId)->row_array();
			$data['pilkadaList']  	= $this->tps_model->getListPilkada()->result_array();
			// $data['provinsiList']  	= $this->tps_model->get_provinsi();
			// $data['kabupatenList']  = $this->tps_model->get_kabupaten();
			// $data['kecamatanList'] 	= $this->tps_model->get_kecamatan();
			// $data['kelurahanList'] 	= $this->tps_model->get_kelurahan();
			// $data['accList']  		= $this->pilkada_model->getListAcc()->result_array();
			// $data['List']  			= $this->pilkada_model->ListAcc()->row_array();
			$this->template->display('pemilu/kepaladaerah/tps/update', $data);
		}else{
			$this->access->redirect('404');
		}
	}

	public function create(){
		if($this->access->permission('create')){
			
			if($post = $this->input->post()){
				$config['upload_path'] = './assets/upload/tps/';
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
					$imgpath = "assets/upload/tps/" . $dataupdload["file_name"];
				}else{
					$error = array('error' => $this->upload->display_errors());
				}
				
				$dataposttps = array(
					'pilkada_tps_code' 				=> isset($post['add_code'])?$post['add_code']:'',
					'pilkada_tps_name' 				=> isset($post['add_name'])?$post['add_name']:'',
					'pilkada_tps_pilkada_id'		=> isset($post['add_pilkada'])?$post['add_pilkada']:'',
					'pilkada_tps_photo_path'		=> $imgpath,
					'pilkada_tps_village_id'		=> isset($post['add_village'])?$post['add_village']:'',
					'pilkada_tps_address' 			=> isset($post['add_address'])?$post['add_address']:'',
					'pilkada_tps_total_voter'		=> isset($post['add_voter'])?$post['add_voter']:'',
					'pilkada_tps_create_user_id'	=> $this->session->userdata('user_id'),
					'pilkada_tps_create_date' 		=> date('Y-m-d H:i:s'),
					'pilkada_tps_status' 			=> 1
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
					$insDb = $this->tps_model->addTps($dataposttps);
					if($insDb > 0){
						$notify = array(
							'title' 	=> 'Berhasil!',
							'message' 	=> 'Tambah Data TPS Berhasil',
							'status' 	=> 'success'
							);
						$this->session->set_flashdata('notify', $notify);
						
						redirect(base_url().'pemilu/tps');
					}else{
						$notify = array(
							'title' 	=> 'Gagal!',
							'message' 	=> 'Tambah Data TPS gagal, silahkan coba lagi',
							'status' 	=> 'error'
							);
						$this->session->set_flashdata('notify', $notify);
						
						redirect(base_url().'pemilu/tps');
					}
				}
			$data = array();
			// $data['accList']  	= $this->pengguna_model->getListAcc()->result_array();
			$data['pilkadaList']  	= $this->tps_model->getListPilkada()->result_array();
			// $data['provinceList']  	= $this->tps_model->getListProvince();
			// $data['regencyList']  	= $this->tps_model->getListRegency()->result_array();
			// $data['districtList']  	= $this->tps_model->getListDistrict()->result_array();
			// $data['villageList']  	= $this->tps_model->getListVillage()->result_array();
			$this->template->display('pemilu/kepaladaerah/tps/create', $data);
		} else {
			$this->access->redirect('404');
		}
	}
	public function detail($id=0){
		if($this->access->permission('read')){
			$tps = $this->tps_model->getDetail($id)->row_array();
			$data["tps"] = $tps;
			$this->template->display('pemilu/kepaladaerah/tps/detail', $data);
		}
	}

	public function listdataaktif(){
		$default_order = "pilkada_tps_id";
		$limit = 10;

		$order_field 	= array(
			'pilkada_tps_id',
			'pilkada_tps_name',
			'pilkada_tps_photo_path',
			'pilkada_tps_address',
			'pilkada_tps_total_voter',
			);
		$order_key 	= ($this->input->get('iSortCol_0')=="0")?"0":$this->input->get('iSortCol_0');
		$order 		= (!$this->input->get('iSortCol_0'))?$default_order:$order_field[$order_key];
		$sort 		= (!$this->input->get('sSortDir_0'))?'asc':$this->input->get('sSortDir_0');
		$search 	= (!$this->input->get('sSearch'))?'':strtoupper($this->input->get('sSearch'));
		$limit 		= (!$this->input->get('iDisplayLength'))?$limit:$this->input->get('iDisplayLength');
		$start 		= (!$this->input->get('iDisplayStart'))?0:$this->input->get('iDisplayStart');
		$data['sEcho'] = $this->input->get('sEcho');
		$data['iTotalRecords'][] = $this->tps_model->count_all($search,$order_field);
		$data['iTotalDisplayRecords'][] = $this->tps_model->count_all($search,$order_field);


		$aaData = array();
		$getData 	= $this->tps_model->get_paged_list($limit, $start, $order, $sort, $search, $order_field)->result_array();
		$no = (($start == 0) ? 1 : $start + 1);
		foreach ($getData as $img) {
			$image = ('src'.'assets/upload/tps/'. $img["pilkada_tps_photo_path"]);
			// echo img($image);
			// echo '<$image>';
		}
		foreach ($getData as $row) {
			$aaData[] = array(
				'<center>'.$no.'</center>',
				$row["pilkada_tps_name"],
				'<center>'.$image.'</center>',
				$row["pilkada_tps_address"],
				$row["pilkada_tps_total_voter"],
				'<a href="'.base_url().'pemilu/tps/detail/'.$row["pilkada_tps_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Lihat" data-placement="top"><i class="icon-file6"></i></a>
				<a href="'.base_url().'pemilu/tps/update/'.$row["pilkada_tps_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Edit" data-placement="top"><i class="icon-pencil"></i></a>
				<a href="'.base_url().'pemilu/tps/delete/'.$row["pilkada_tps_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Non Aktifkan" data-placement="top"><i class="icon-close"></i></a>');
			$no++;
		}
		$data['aaData'] = $aaData;
		// echo '<$image>';
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function listdatanonaktif(){
		$default_order = "pilkada_tps_id";
		$limit = 10;

		$order_field 	= array(
			'pilkada_tps_id',
			'pilkada_tps_name',
			'pilkada_tps_photo_path',
			'pilkada_tps_address',
			'pilkada_tps_total_voter',
			);
		$order_key 	= ($this->input->get('iSortCol_0')=="0")?"0":$this->input->get('iSortCol_0');
		$order 		= (!$this->input->get('iSortCol_0'))?$default_order:$order_field[$order_key];
		$sort 		= (!$this->input->get('sSortDir_0'))?'asc':$this->input->get('sSortDir_0');
		$search 	= (!$this->input->get('sSearch'))?'':strtoupper($this->input->get('sSearch'));
		$limit 		= (!$this->input->get('iDisplayLength'))?$limit:$this->input->get('iDisplayLength');
		$start 		= (!$this->input->get('iDisplayStart'))?0:$this->input->get('iDisplayStart');
		$data['sEcho'] = $this->input->get('sEcho');
		$data['iTotalRecords'][] = $this->tps_model->count_allnonaktif($search,$order_field);
		$data['iTotalDisplayRecords'][] = $this->tps_model->count_allnonaktif($search,$order_field);


		$aaData = array();
		$getData 	= $this->tps_model->get_paged_listnonaktif($limit, $start, $order, $sort, $search, $order_field)->result_array();
		$no = (($start == 0) ? 1 : $start + 1);
		foreach ($getData as $row) {
			$aaData[] = array(
				'<center>'.$no.'</center>',
				$row["pilkada_tps_name"],
				$row["pilkada_tps_photo_path"],
				$row["pilkada_tps_address"],
				$row["pilkada_tps_total_voter"],
				'<a href="'.base_url().'pemilu/tps/detail/'.$row["pilkada_tps_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Lihat" data-placement="top"><i class="icon-file6"></i></a> '.
				'<a href="'.base_url().'pemilu/tps/aktif/'.$row["pilkada_tps_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Aktifkan" data-placement="top"><i class="icon-checkmark3"></i></a>');
			$no++;
		}
		$data['aaData'] = $aaData;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function delete($tpsId = 0){

		$tpsIdFilter = filter_var($tpsId, FILTER_SANITIZE_NUMBER_INT);
		if($this->access->permission('delete')) {
			if($tpsId==$tpsIdFilter) {

				// $dataupdate = array(
				// 	'user_update_by' 			=> $this->session->userdata('user_id'),
				// 	'user_update_date' 			=> date('Y-m-d H:i:s')
				// 	);

				$del = $this->tps_model->deleteTps($tpsId);
				$notify = array(
					'title' 	=> 'Berhasil!',
					'message' 	=> 'Data TPS dinonaktifkan',
					'status' 	=> 'success'
					);
				$this->session->set_flashdata('notify', $notify);

				redirect(base_url().'pemilu/tps');
			} else {
				$notify = array(
					'title' 	=> 'Gagal!',
					'message' 	=> 'Data TPS gagal dinonaktifkan',
					'status' 	=> 'error'
					);
				$this->session->set_flashdata('notify', $notify);
				redirect(base_url().'pemilu/tps');
			}
		} else {
			$notify = array(
				'title' 	=> 'Gagal!',
				'message' 	=> 'Data TPS gagal dinonaktifkan',
				'status' 	=> 'error'
				);
			$this->session->set_flashdata('notify', $notify);
			redirect(base_url().'pemilu/tps');
		}
	}

	public function aktif($tpsId = 0){

		$tpsIdFilter = filter_var($tpsId, FILTER_SANITIZE_NUMBER_INT);
		if($this->access->permission('update')) {
			if($tpsId==$tpsIdFilter) {

				// $dataupdate = array(
				// 	'user_update_by' 			=> $this->session->userdata('user_id'),
				// 	'user_update_date' 			=> date('Y-m-d H:i:s')
				// 	);

				$del = $this->tps_model->aktifTps($tpsId);
				$notify = array(
					'title' 	=> 'Berhasil!',
					'message' 	=> 'Data TPS diaktifkan',
					'status' 	=> 'success'
					);
				$this->session->set_flashdata('notify', $notify);

				redirect(base_url().'pemilu/tps');
			} else {
				$notify = array(
					'title' 	=> 'Gagal!',
					'message' 	=> 'Data TPS gagal diaktifkan',
					'status' 	=> 'error'
					);
				$this->session->set_flashdata('notify', $notify);
				redirect(base_url().'pemilu/tps');
			}
		} else {
			$notify = array(
				'title' 	=> 'Gagal!',
				'message' 	=> 'Data TPS gagal diaktifkan',
				'status' 	=> 'error'
				);
			$this->session->set_flashdata('notify', $notify);
			redirect(base_url().'pemilu/tps');
		}
	}
}