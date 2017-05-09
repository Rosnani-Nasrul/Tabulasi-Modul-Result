<?php
header('Content-Type: application/json');
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function index()
	{
		
	}
	
	public function get_result()
	{
		$username = $this->input->post('surveyor_id');
		// $username = '1';


		$this->db->select('*');
		$this->db->select('pilkada_result_pilkada_tps_id AS surveyor_pilkada_tps_id');
		$this->db->select('SUM(pilkada_result_total_vote) AS jumlah');

		$this->db->group_by('pilkada_candidate_id');

		$this->db->join('trx_pilkada_candidates', 'trx_pilkada_candidates.pilkada_candidate_id = trx_pilkada_results.pilkada_result_pilkada_candidate_id', 'INNER');

		$this->db->join('trx_pilkada_sessions', 'trx_pilkada_sessions.pilkada_session_id = trx_pilkada_results.pilkada_result_pilkada_session_id', 'INNER');

		$this->db->join('trx_pilkadas', 'trx_pilkadas.pilkada_id = trx_pilkada_results.pilkada_result_pilkada_id', 'INNER');

		$this->db->where('pilkada_result_create_user_id', $username);
		$data_user = $this->db->get('trx_pilkada_results')->result();
		// $data['status'] = ($data_user) ? 1 : 0;
		$data['status'] = 1;
		$data['data'] = $data_user;


		echo json_encode($data);
	}

	public function get_grafik()
	{
		$this->db->select('pilkada_result_pilkada_candidate_id');
		$this->db->select('pilkada_candidate_name');
		$this->db->select('SUM(pilkada_result_total_vote) AS jumlah');
		$this->db->group_by('pilkada_candidate_id');
		$this->db->join('trx_pilkada_candidates', 'trx_pilkada_candidates.pilkada_candidate_id = trx_pilkada_results.pilkada_result_pilkada_candidate_id', 'INNER');
		$data['data'] = $this->db->get('trx_pilkada_results')->result();


		echo json_encode($data);
	}

	public function get_data()
	{
		$username = $this->input->post('surveyor_id');
		// $username = '1';

		// var_dump($_POST);
		$this->db->where('surveyor_id', $username);
		$data['data'] = $this->db->get('sys_surveyor')->result();


		echo json_encode($data);
	}

	public function login()
	{
		$username = $this->input->post('username');
		$password  = $this->input->post('password');
		// $username = 'admin';
		// $password = 'admin';

		// var_dump($username);
		// var_dump($password);

		$this->db->where('surveyor_username', $username);
		$this->db->where('surveyor_password', $password);

		$data_user = $this->db->get('sys_surveyor')->result();
		$data['status'] = ($data_user) ? 1 : 0;
		$data['data'] = $data_user;


		echo json_encode($data);
	}

}

/* End of file User.php */
/* Location: ./application/controllers/User.php */
