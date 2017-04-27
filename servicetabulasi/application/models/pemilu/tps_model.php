<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class tps_model extends CI_Model {

	public function __construct() 
	{
		parent::__construct();
		
	}

	function get_paged_list($limit=10, $offset=0, $order_column='', $order_type='asc', $search='', $fields='')
	{
		$this->db->where('pilkada_tps_status',1);
		if($search!='' AND $fields!='')
		{
			$likeclause = '(';
			$i=0;
			foreach($fields as $field)
			{
				if($i==count($fields)-1) {
					$likeclause .= "UPPER(".$field.") LIKE '%".strtoupper($search)."%'";
				} else {
					$likeclause .= "UPPER(".$field.") LIKE '%".strtoupper($search)."%' OR ";
				}
				++$i;
			}
			$likeclause .= ')';
			$this->db->where($likeclause);
		}

		if (empty($order_column) || empty($order_type))
		{
			$this->db->order_by('pilkada_tps_id','DESC');
		} else {
			$this->db->order_by($order_column,$order_type);
		}

		return $this->db->get('trx_pilkada_tpses',$limit,$offset);
	}

	function count_all($search='', $fields='')
	{	
		$this->db->where('pilkada_tps_status',1);
		if($search!='' AND $fields!='')
		{
			$likeclause = '(';
			$i=0;
			foreach($fields as $field)
			{
				if($i==count($fields)-1) {
					$likeclause .= "UPPER(".$field.") LIKE '%".strtoupper($search)."%'";
				} else {
					$likeclause .= "UPPER(".$field.") LIKE '%".strtoupper($search)."%' OR ";
				}
				++$i;
			}
			$likeclause .= ')';
			$this->db->where($likeclause);
		}
		$this->db->from('trx_pilkada_tpses');
		return $this->db->count_all_results(); 
	}

	function get_paged_listnonaktif($limit=10, $offset=0, $order_column='', $order_type='asc', $search='', $fields='')
	{
		$this->db->where('pilkada_tps_status',0);
		if($search!='' AND $fields!='')
		{
			$likeclause = '(';
			$i=0;
			foreach($fields as $field)
			{
				if($i==count($fields)-1) {
					$likeclause .= "UPPER(".$field.") LIKE '%".strtoupper($search)."%'";
				} else {
					$likeclause .= "UPPER(".$field.") LIKE '%".strtoupper($search)."%' OR ";
				}
				++$i;
			}
			$likeclause .= ')';
			$this->db->where($likeclause);
		}

		if (empty($order_column) || empty($order_type))
		{
			$this->db->order_by('pilkada_tps_id','DESC');
		} else {
			$this->db->order_by($order_column,$order_type);
		}

		return $this->db->get('trx_pilkada_tpses',$limit,$offset);
	}

	function count_allnonaktif($search='', $fields='')
	{	
		$this->db->where('pilkada_tps_status',0);
		if($search!='' AND $fields!='')
		{
			$likeclause = '(';
			$i=0;
			foreach($fields as $field)
			{
				if($i==count($fields)-1) {
					$likeclause .= "UPPER(".$field.") LIKE '%".strtoupper($search)."%'";
				} else {
					$likeclause .= "UPPER(".$field.") LIKE '%".strtoupper($search)."%' OR ";
				}
				++$i;
			}
			$likeclause .= ')';
			$this->db->where($likeclause);
		}
		$this->db->from('trx_pilkada_tpses');
		return $this->db->count_all_results(); 
	}

	function getDetail($tpsId){
		// $this->db->join('master_employees', 'employee_id = user_employee_id', 'inner');
		$this->db->where('pilkada_tps_id', $tpsId);
		return $this->db->get('view_trx_pilkada_tps');
	}

	// function getListAcc(){
	// 	return $this->db->get_where('sys_access', array('access_status' => 1));
	// }

	// function ListAcc(){
	// 	return $this->db->get_where('sys_access', array('access_status' => 1));
	// }

	// function getListProvince(){
	// 	$this->db->order_by('province_id','ASC');
	// 	$provinces= $this->db->get_where('master_provinces', array('province_status' => 1));
	// 	return $provinces->result_array();
	// }

	public function get_provinsi() {
        // $provinsi_code = $this->input->get('regency_province_code');
        // $this->db->where('regency_province_code', $id);
        return $this->db->get('master_provinces')->result_array();
    }

	public function get_kabupaten($id) {
        // $provinsi_code = $this->input->get('regency_province_code');
        $this->db->where('regency_province_code', $id);
        return $this->db->get('master_regencies')->result_array();
    }

    public function get_kecamatan($id) {
        // $kabupaten_code = $this->input->get('district_regency_code');
        // $this->db->where('district_regency_code', $kabupaten_code);
        // return $this->db->get('master_districts');
        $this->db->where('district_regency_code', $id);
        return $this->db->get('master_districts')->result_array();
    }

    public function get_kelurahan($id) {
        // // $kecamatan_code = $this->input->get('village_district_code');
        // $this->db->where('village_district_code', $id);
        // return $this->db->get('master_villages')->result_array();
        $this->db->where('village_district_code', $id);
        return $this->db->get('master_villages')->result_array();
    }

	// function getListRegency(){
	// 	return $this->db->get_where('master_regencies', array('regency_status' => 1));
	// }

	// function getListDistrict(){
	// 	return $this->db->get_where('master_districts', array('district_status' => 1));
	// }

	// function getListVillage(){
	// 	return $this->db->get_where('master_villages', array('village_status' => 1));
	// }

	// function provinsi(){
	// 	$this->db->order_by('province_id','ASC');
	// 	$provinces= $this->db->get('master_provinces');
	// 	return $provinces->result_array();
	// }

	// function kabupaten($provId){
	// 	$kabupaten="<option value='0'>--pilih--</pilih>";

	// 	$this->db->order_by('regency_id','ASC');
	// 	$kab= $this->db->get_where('master_regencies',array('regency_province_code'=>$provId));

	// 	foreach ($kab->result_array() as $data ){
	// 	$kabupaten.= "<option value='$data[regency_id]'>$data[regency_name]</option>";
	// 	}

	// 	return $kabupaten;
	// }

	// function kecamatan($kabId){
	// 	$kecamatan="<option value='0'>--pilih--</pilih>";

	// 	$this->db->order_by('district_id','ASC');
	// 	$kec= $this->db->get_where('master_districts',array('district_regency_code'=>$kabId));

	// 	foreach ($kec->result_array() as $data ){
	// 	$kecamatan.= "<option value='$data[district_id]'>$data[district_name]</option>";
	// 	}

	// 	return $kecamatan;
	// }

	// function kelurahan($kecId){
	// 	$kelurahan="<option value='0'>--pilih--</pilih>";

	// 	$this->db->order_by('village_id','ASC');
	// 	$kel= $this->db->get_where('master_villages',array('village_district_code'=>$kecId));

	// 	foreach ($kel->result_array() as $data ){
	// 	$kelurahan.= "<option value='$data[village_id]'>$data[village_name]</option>";
	// 	}

	// 	return $kelurahan;
	// }

	function getListPilkada(){
		return $this->db->get_where('trx_pilkadas', array('pilkada_status' => 1));
	}

	function addTps($datacreate){
		$this->db->insert('trx_pilkada_tpses', $datacreate);
		return $this->db->insert_id();
	}

	// function addProvince($datacreate){
	// 	$this->db->insert('master_provinces', $datacreate);
	// 	return $this->db->insert_id();
	// }

	function updateTps($dataupdate, $tpsId){
		$this->db->where('pilkada_tps_id', $tpsId);
		return $this->db->update('trx_pilkada_tpses', $dataupdate);
	}

	// function updateProvince($dataProvince, $provinceId){
	// 	$this->db->where('province_id', $provinceId);
	// 	return $this->db->update('master_provinces',$dataProvince);
	// }

	function getTrxTps($tpsId){
		return $this->db->get_where('view_trx_pilkada_tps', array('pilkada_tps_id' => $tpsId));
	}

	function deleteTps($tpsId, $dataupdate){
		$this->db->set('pilkada_tps_status',0);
		$this->db->where('pilkada_tps_id', $tpsId);
		return $this->db->update('trx_pilkada_tpses', $dataupdate);
	}

	function aktifTps($tpsId, $dataupdate){
		$this->db->set('pilkada_tps_status',1);
		$this->db->where('pilkada_tps_id', $tpsId);
		return $this->db->update('trx_pilkada_tpses',  $dataupdate);
	}


}

/* End of file pengguna_model.php */
/* Location: ./application/models/pengguna_model.php */