<?php

class Athlete_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_athletes($id = False)
	{
		$this->db->select('*');
		$this->db->from('players');
		if ($id === FALSE) {
			$this->db->join('location', 'location.id = players.loc_id');
			$query = $this->db->get();
			return $query->result_array();
		}
		else{
			$this->db->join('location', 'location.id = players.loc_id and pl_id = '.$id);
			$query = $this->db->get();
			return $query->row_array();
		}

	}

	public function delete_athlete($id)
	{
		$this->db->delete('players', array('pl_id' => $id));
		return $this->db->affected_rows();

	}

	public function insert($data)
	{
		$this->db->insert('players',$data);
		return $this->db->affected_rows();
	}
}
