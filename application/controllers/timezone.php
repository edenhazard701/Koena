<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Timezone extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model("Timezone_model");
	}

	public function index(){
		//$result = $this->Timezone_model->getTableData();
		$params = array(
			'title' => "Session",
			'data' => '',
			'selections' => json_encode(array("session"))
		);

		if (isset($_GET['ac'])){
			$_SESSION['account_id'] = $_GET['ac'];
		};

		$this->load_view('timezone/timezone_view.php', $params);		
	}

	public function getTableData(){

		$sessionGMT = isset($_POST['sessionGMT']) ? $_POST['sessionGMT'] : NULL;
		$baseGMT = isset($_POST['baseGMT']) ? $_POST['baseGMT'] : NULL;

		$table = $this->Timezone_model->getTableData($sessionGMT, $baseGMT);

		echo json_encode(array('data' => $table, 'status' => 'success' ));
	}

	public function getBrokersTimeADayData() {
		$sessionGMT = isset($_POST['sessionGMT']) ? $_POST['sessionGMT'] : NULL;
		$baseGMT = isset($_POST['baseGMT']) ? $_POST['baseGMT'] : NULL;

		$table = $this->Timezone_model->getBrokersTimeADayData($sessionGMT, $baseGMT);

		echo json_encode(array('data' => $table, 'status' => 'success' ));
	}

	public function modalBestWorstHrSession() {
		$timezone = isset($_POST['timezone']) ? $_POST['timezone'] : NULL;
		$baseGMT = isset($_POST['baseGMT']) ? $_POST['baseGMT'] : NULL;

		$table = $this->Timezone_model->modalBestWorstHrSession($timezone, $baseGMT);

		echo json_encode(array('data' => $table, 'status' => 'success' ));
	}

	public function spTimezoneSession() {
		$data = $_POST;

		$res = $this->Timezone_model->spTimezoneSession($data);

		echo json_encode(array('data' => $res, 'status' => 'success' ));
	}
}
	