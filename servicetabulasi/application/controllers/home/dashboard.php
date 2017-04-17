<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller{
	
	function __construct(){
		parent:: __construct();
		$this->load->model('home/dashboard_model');
	}

	public function index(){
		$data = array();
		$this->template->display('home/dashboard', $data);
	}

	function getGrafikResult(){
		$post = $this->input->post();
		$pilkada = isset($post['pilkada'])?$post['pilkada']:'';
		$putaran = isset($post['putaran'])?$post['putaran']:'';
		$provinsi = isset($post['provinsi'])?$post['provinsi']:'';
		$kabupaten = isset($post['kabupaten'])?$post['kabupaten']:'';
		$kecamatan = isset($post['kecamatan'])?$post['kecamatan']:'';
		$kelurahan = isset($post['kelurahan'])?$post['kelurahan']:'';	
		$tps = isset($post['tps'])?$post['tps']:'';			
		
		$data['result'] = '';
		$data['grafik_result'] = $grafik_result;

		$no=0;
		$_name='';
		$jml_loop = count($result);	
		$jmlmax = 10;
		$jml_ll = 0;
		for ($i=0; $i < $jml_loop; $i++) {
			if($i < $jmlmax){
				$data['result'][$i]['pilkada_candidate_name'] = $result[$i]['pilkada_candidate_name'];
				$data['result'][$i]['pilkada_result_total_vote'] = $result[$i]['pilkada_result_total_vote'];
			}
			else{
				if($jmlmax + 1 == $jml_loop){
					$data['result'][$i]['pilkada_candidate_name'] = $result[$i]['pilkada_candidate_name'];
					$data['result'][$i]['pilkada_result_total_vote'] = $result[$i]['pilkada_result_total_vote'];
				}
				else{
					$jml_ll += $result[$i]['pilkada_result_total_vote'];
				}
				
			} 				
		}

		if($jml_loop > $jmlmax + 1){
			$data['result'][$jmlmax]['pilkada_candidate_name'] = 'lain-lain';
			$data['result'][$jmlmax]['pilkada_result_total_vote'] = $jml_ll;
		}			
		
		echo json_encode($data);
	}

	function getDatGrafik(){
		$result = $this->dashboard_model->getDatResult()->result_array();

		$data['result'] = '';
		$no=0;
		$_name='';
		foreach ($result as $dt) {
			if ($_name != $dt['pilkada_candidate_name']){
				$data['result'][$no]['pilkada_candidate_name'] = $dt['pilkada_candidate_name'];
				$_name = $dt['pilkada_candidate_name'];

				$_count = 0;
				foreach ($result as $dt) {
					if($_name == $dt['pilkada_candidate_name']){
						$_count +=1;
					}
					$data['result'][$no]['pilkada_result_total_vote'] = $_count;		
				}
				$no +=1;
			}
		}
		echo json_encode($data);
	}

	function listResult($pilkada, $putaran, $provinsi, $kabupaten, $kecamatan, $kelurahan, $tps) {
		$default_order = "pilkada_result_pilkada_candidate_id";
		$limit = 10;

		$order_field 	= array(
			'pilkada_result_pilkada_candidate_id',
			'pilkada_candidate_name',
			'pilkada_result_total_vote',
			);
		$order_key 	= ($this->input->get('iSortCol_0')=="0")?"0":$this->input->get('iSortCol_0');
		$order 		= (!$this->input->get('iSortCol_0'))?$default_order:$order_field[$order_key];
		$sort 		= (!$this->input->get('sSortDir_0'))?'asc':$this->input->get('sSortDir_0');
		$search 	= (!$this->input->get('sSearch'))?'':strtoupper($this->input->get('sSearch'));
		$limit 		= (!$this->input->get('iDisplayLength'))?$limit:$this->input->get('iDisplayLength');
		$start 		= (!$this->input->get('iDisplayStart'))?0:$this->input->get('iDisplayStart');
		$data['sEcho'] = $this->input->get('sEcho');
		$data['iTotalRecords'][] = $this->dashboard_model->count_all($order_field, $search, $pilkada, $putaran, $provinsi, $kabupaten, $kecamatan, $kelurahan, $tps);
		$data['iTotalDisplayRecords'][] = $this->dashboard_model->count_all($order_field, $search, $pilkada, $putaran, $provinsi, $kabupaten, $kecamatan, $kelurahan, $tps);


		$aaData = array();
		$getData 	= $this->dashboard_model->get_paged_list($limit, $start, $order, $sort, $order_field, $search, $pilkada, $putaran, $provinsi, $kabupaten, $kecamatan, $kelurahan, $tps)->result_array();
		$no = (($start == 0) ? 1 : $start + 1);
		foreach ($getData as $row) {
			$aaData[] = array(
				'<center>'.$no.'</center>',
				$row["pilkada_candidate_name"],
				$row["pilkada_result_total_vote"],
				);
			$no++;
		}
		$data['aaData'] = $aaData;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function pilkada() {
       $this->output->set_content_type('application/json')->set_output(json_encode($this->dashboard_model->pilkada()));
   	}

	public function putaran($id) {
       $this->output->set_content_type('application/json')->set_output(json_encode($this->dashboard_model->putaran($id)));
  	}

	public function kandidat($id) {
       $this->output->set_content_type('application/json')->set_output(json_encode($this->dashboard_model->kandidat($id)));
   	}

   	public function tps($id) {
       $this->output->set_content_type('application/json')->set_output(json_encode($this->dashboard_model->tps($id)));
  	}

  	public function provinsi($id) {
       $this->output->set_content_type('application/json')->set_output(json_encode($this->dashboard_model->provinsi($id)));
  	}

  	public function kabupaten($id) {
       $this->output->set_content_type('application/json')->set_output(json_encode($this->dashboard_model->kabupaten($id)));
  	}

  	public function kecamatan($id) {
       $this->output->set_content_type('application/json')->set_output(json_encode($this->dashboard_model->kecamatan($id)));
  	}

  	public function kelurahan($id) {
       $this->output->set_content_type('application/json')->set_output(json_encode($this->dashboard_model->kelurahan($id)));
  	}

  	public function place($id) {
		$data = $this->dashboard_model->dataSelectList($id)->row_array();
    	echo json_encode($data);
  	}  	

}