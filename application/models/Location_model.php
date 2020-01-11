<?php
class Location_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->output->set_header("Access-Control-Allow-Origin:*");
		$this->load->database();
	}
	public function get_location($city = False,$province=False)
	{
		if ($city === FALSE && $province === FALSE) {
			$query = $this->db->get('location');
			return $query->result_array();
		}
		$query = $this->db->get_where('location', array('city' => $city,'province'=>$province));
		return $query->row_array();
	}
	public function add($data) {
		$this->db->insert('location',$data);
		return array('id'=>$this->db->insert_id());
	}

}
