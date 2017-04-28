<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class aplikasi_model extends CI_Model {

	public function __construct() 
	{
		parent::__construct();
		
	}

	function get_paged_list($limit=10, $offset=0, $order_column='', $order_type='asc', $search='', $fields='')
	{
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
			$this->db->order_by('config_id','DESC');
		} else {
			$this->db->order_by($order_column,$order_type);
		}
		return $this->db->get('sys_config',$limit,$offset);
	}

	function count_all($search='', $fields='')
	{	

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
		$this->db->from('sys_config');
		return $this->db->count_all_results(); 
	}

	function getDetail($id){
		$this->db->where('config_id', $id);
		return $this->db->get('sys_config');
	}

	function update($data, $id){
		$this->db->where('config_id', $id);
		return $this->db->update('sys_config', $data);
	}
}

/* End of file website_model.php */
/* Location: ./application/models/website_model.php */