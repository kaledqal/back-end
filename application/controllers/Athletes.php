<?php
header('Access-Control-Allow-Origin: *');
header("Content-type: application/json; charset=utf-8");
header("Access-Control-Allow-Methods: GET, OPTIONS");

class Athletes extends CI_Controller
{
	public function index()
	{
		echo json_encode($this->athlete_model->get_athletes());
	}

	public function athlete($id = NULL)
	{
		$data['athlete'] = $this->athlete_model->get_athletes($id);

		if (empty($data['athlete'])) {
			show_404();
		}
		echo json_encode($data['athlete']);
	}

	public function delete($id)
	{
		echo $this->athlete_model->delete_athlete($id);
	}

	public function load($data)
	{

		$playersObj = json_decode($data);
		$playersArray = $playersObj->players;
		array_map(array($this,'insertPlayer'),$playersArray);
	}

	static function extractPlayerData($player)
	{
		list($first_name, $last_name) = explode(' ', $player->Name);
		$age = $player->Age;
		$city = ucfirst(strtolower($player->Location->City));
		$province = strtoupper($player->Location->Province);
		$country = strtoupper($player->Location->Country);
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
