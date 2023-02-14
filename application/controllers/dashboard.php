<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->model("Dashboard_model");
	}

	public function index(){
		$this->checkPlanID();

		if($_SESSION['usertype_id']  > 1)
			redirect("/dashboard/general");
		if (isset($_GET['ac'])){
			$_SESSION['account_id'] = $_GET['ac'];
		};
		
		$active_inactive_account = $this->Dashboard_model->get_active_inactive_account();
		$active_inactive_client = $this->Dashboard_model->get_active_inactive_client();
		$plan = $this->Dashboard_model->getPlan();
		$payment_data = $this->Dashboard_model->getPaymentTable();

		$params = array(
			'title' => "Admin Dashboard",
			'selections' => json_encode(array("dashboard", "admin")),
			'data' => array(
				'active_inactive_account' => $active_inactive_account,
				'active_inactive_client' => $active_inactive_client,
				'plan' => $plan,
				'payment_data' => $payment_data
			)
		);

		$this->load_view('dashboard/admin_view.php', $params);
	}

	public function logout() {
		session_destroy();
		redirect('/login');
	}

	public function getUserAccounts() {

		$account = $this->Dashboard_model->getUserAccounts();

		echo json_encode(array('status' => "success", "data" => $account));
	}

	public function loadCalendarUpper() {
		$acct = isset($_POST['account_id']) ? $_POST['account_id'] : NULL;

		$account = $this->Dashboard_model->loadCalendarUpper($acct);
		
		echo json_encode(array('status' => "success", "data" => $account));
	}

	public function getTableData(){
		$table = $this->Dashboard_model->getTableData();

		echo json_encode(array('data' => $table));
	}

	public function getAccounts(){
		$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : NULL;
		$account = $this->Dashboard_model->getAccounts($user_id);

		echo json_encode(array('status' => "success", "data" => $account));
	}

	public function general(){
		$this->checkPlanID();

		if (isset($_GET['ac'])){
			$_SESSION['account_id'] = $_GET['ac'];
		};
		$params = array(
			'title' => "General Dashboard",
			'selections' => json_encode(array("dashboard", "general"))
		);
		
		$this->load_view('dashboard/general_view.php', $params);
	}

	public function session(){
		$this->checkPlanID();

		$params = array(
			'title' => "Session",
			'selections' => json_encode(array("session", "session")),
			'data' => "Test Data"
		);
		
		$this->load_view('session/session_view.php', $params);
	}

	public function deleteUser() {
		$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : NULL;
		$result = $this->Dashboard_model->deleteUser($user_id);

		echo json_encode($result);
	}

	public function getAccountSymbols() {
		$result = $this->Dashboard_model->getAccountSymbols();

		echo $result;
	}

	public function getSymbolCharts() {
		$acct = isset($_POST['account_id']) ? $_POST['account_id'] : NULL;
		$filter_type = isset($_POST['filter_type']) ? $_POST['filter_type'] : NULL;
		$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
		$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';

		$result = $this->Dashboard_model->getSymbolCharts($acct, $filter_type, $start_date, $end_date);

		echo json_encode(array('status' => "success", "data" => $result));
	}

	public function getTotalTradeSummary() {
		$acct = isset($_POST['account_id']) ? $_POST['account_id'] : NULL;
		$result = $this->Dashboard_model->getTotalTradeSummary($acct);

		echo json_encode(array('status' => "success", "data" => $result));
	}

	public function getTotalTradeSummaryFilter() {
		$acct = isset($_POST['account_id']) ? $_POST['account_id'] : NULL;
		$filterType = isset($_POST['filter_type']) ? $_POST['filter_type'] : NULL;
		$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
		$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';

		$result = $this->Dashboard_model->getTotalTradeSummaryFilter($acct, $filterType, $start_date, $end_date);

		echo json_encode(array('status' => "success", "data" => $result));
	}

	public function getPerformanceGrowth() {

		$acct = isset($_POST['account_id']) ? $_POST['account_id'] : NULL;
		$result = $this->Dashboard_model->getPerformanceGrowth($acct);

		echo json_encode(array('status' => "success", "data" => $result));
	}

	public function getAccountSummary() {
		$acct = isset($_POST['account_id']) ? $_POST['account_id'] : NULL;

		$result = $this->Dashboard_model->getAccountSummary($acct);
		echo json_encode(array('status' => "success", "data" => $result));
	}

	public function changeColorMode(){
		$color = isset($_POST['color_mode']) ? $_POST['color_mode'] : "dark";
		$cur_url = isset($_POST['cur_url']) ? $_POST['cur_url'] : "/dashboard";
		$_SESSION['color'] = $color;

		redirect($cur_url);
	}
}
