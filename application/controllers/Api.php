<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
defined('BASEPATH') OR exit ('No direct script access allowed');


require APPPATH . 'libraries/REST_Controller.php';


use Restserver\Libraries\REST_Controller;

class Api extends \REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();

	}

	/**
	 * @method: POST
	 */
	public function load_post(){
		$data = json_decode(file_get_contents('php://input'), true);
		$playersArray = $data['players'];
		array_map(array($this,'insertPlayer'),$playersArray);
		$this->response("Success", 200);

	}

	/**
	 * @method: GET
	 * @param $id
	 */
	public function athlete_get($id=FALSE){
		$result = $this->athlete_model->get_athletes($id);
		if($result){
			$this->response($result, 200);
		}
		else{
			$this->response($result, 400);
		}
	}

	public function delete_get($id){
		$result = $this->athlete_model->delete_athlete($id);
		if($result)
		{
			$this->response("Deletion Successfull", 200);
		}
		else{
			$this->response('No Player with that id exists', 404);
		}
	}

	static function extractPlayerData($player)
	{
		list($first_name, $last_name) = explode(' ', $player['Name']);
		$age = $player['Age'];
		$city = ucfirst(strtolower($player['Location']['City']));
		$province = strtoupper($player['Location']['Province']);
		$country = strtoupper($player['Location']['Country']);
		return array($first_name, $last_name, $age, $city, $province, $country);
	}

	public function insertPlayer($playerData)
	{
		//$first_name,$last_name,$age,$city,$province,$country
		// check that the location isn't already in the database
		list($first_name, $last_name, $age, $city, $province, $country) = self::extractPlayerData($playerData);
		$result = $this->location_model->get_location($city, $province);
		if (!$result) {
			$location_data = array(
				'city' => $city,
				'province' => $province,
				'country' => $country
			);
			$result = $this->location_model->add($location_data);
		}
		$data = array(
			'first_name' => $first_name,
			'last_name' => $last_name,
			'age' => $age,
			'loc_id' => $result['id']
		);
		$result = $this->athlete_model->insert($data);
		echo $result;
	}

}
