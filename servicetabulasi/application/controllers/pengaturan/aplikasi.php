<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class aplikasi extends CI_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('pengaturan/aplikasi_model');
		$this->load->helper('xml');
		$this->load->helper('text');
	}

	public function index(){
		$data = array();
		$this->template->display('pengaturan/aplikasi/index', $data);
	}
	public function detail($id=0){
		if($this->access->permission('read')){
			$app = $this->aplikasi_model->getDetail($id)->row_array();
			$data["aplikasi"] = $app;
			$this->template->display('pengaturan/aplikasi/detail', $data);
		}

	}
	public function update($id=0){
		if($this->access->permission('update')){

			if($post = $this->input->post()){

				$dataupdate = array(
					'config_code' 				=> isset($post['add_code'])?$post['add_code']:'',
					'config_name' 				=> isset($post['add_name'])?$post['add_name']:'',
					'config_value' 				=> isset($post['add_value'])?$post['add_value']:'',
					'config_update_by' 			=> $this->session->userdata('user_id'),
					'config_update_date' 		=> date('Y-m-d H:i:s')
					);

				
				$insDb = $this->aplikasi_model->update($dataupdate, $id);

				if($insDb > 0){
					$notify = array(
						'title' 	=> 'Berhasil!',
						'message' 	=> 'Perubahan konfigurasi Berhasil',
						'status' 	=> 'success'
						);
					$this->session->set_flashdata('notify', $notify);

					redirect(base_url().'pengaturan/aplikasi');
				}else{
					$notify = array(
						'title' 	=> 'Gagal!',
						'message'	=> 'Perubahan konfigurasi gagal, silahkan coba lagi',
						'status' 	=> 'error'
						);
					$this->session->set_flashdata('notify', $notify);
					redirect(base_url().'pengaturan/aplikasi');
				}
			}
			$data = array();
			$data['aplikasi']  	= $this->aplikasi_model->getDetail($id)->row_array();
			$this->template->display('pengaturan/aplikasi/update', $data);
		}else{
			$this->access->redirect('404');
		}
	}

	public function listdata(){
		$default_order = "config_id";
		$limit = 10;

		$order_field 	= array(
			'config_id',
			'config_code',
			'config_name',
			'config_value',
			'config_status',
			);
		$order_key 	= ($this->input->get('iSortCol_0')=="0")?"0":$this->input->get('iSortCol_0');
		$order 		= (!$this->input->get('iSortCol_0'))?$default_order:$order_field[$order_key];
		$sort 		= (!$this->input->get('sSortDir_0'))?'asc':$this->input->get('sSortDir_0');
		$search 	= (!$this->input->get('sSearch'))?'':strtoupper($this->input->get('sSearch'));
		$limit 		= (!$this->input->get('iDisplayLength'))?$limit:$this->input->get('iDisplayLength');
		$start 		= (!$this->input->get('iDisplayStart'))?0:$this->input->get('iDisplayStart');
		$data['sEcho'] = $this->input->get('sEcho');
		$data['iTotalRecords'][] = $this->aplikasi_model->count_all($search,$order_field);
		$data['iTotalDisplayRecords'][] = $this->aplikasi_model->count_all($search,$order_field);


		$aaData = array();
		$getData 	= $this->aplikasi_model->get_paged_list($limit, $start, $order, $sort, $search, $order_field)->result_array();
		/*echo "<pre>".$getdata;
		exit;*/
		$no = (($start == 0) ? 1 : $start + 1);
		foreach ($getData as $row) {
			$aaData[] = array(
				'<center>'.$no.'</center>',
				$row["config_code"],
				$row["config_name"],
				$row["config_value"],
				$status =($row['config_status']==1)?'Aktif':'Tidak Aktif',
				'<a href="'.base_url().'pengaturan/aplikasi/detail/'.$row["config_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Lihat" data-placement="top"><i class="icon-file6"></i></a>
				<a href="'.base_url().'pengaturan/aplikasi/update/'.$row["config_id"].'" role="button" class="btn btn-xs btn-default btn-icon tip" data-original-title="Edit" data-placement="top"><i class="icon-pencil"></i></a>');
			$no++;
		}
		$data['aaData'] = $aaData;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
}