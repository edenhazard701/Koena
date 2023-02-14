<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Summary extends MY_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->model("Summary_model");
	}

	public function account(){
		$this->checkPlanID();
		if (isset($_GET['ac'])){
			$_SESSION['account_id'] = $_GET['ac'];
		};
		$params = array(
			'title' => "Account Summary",
			'selections' => json_encode(array("summary", "account")),
			'data' => "Test Data"
		);
		
		$this->load_view('summary/account_summary_view.php', $params);
	}

	public function journal(){
		$this->checkPlanID();
		if (isset($_GET['ac'])){
			$_SESSION['account_id'] = $_GET['ac'];
		};
		$params = array(
			'title' => "Joural Summary",
			'selections' => json_encode(array("summary", "journal")),
			'data' => "Test Data"
		);
		
		$this->load_view('summary/journal_summary_view.php', $params);
	}

	public function getSymbolsChart(){
		$account_id = isset($_POST['account_id']) ? $_POST['account_id'] : NULL;
		$result = $this->Summary_model->getSymbolsChart($account_id);

		echo json_encode(array('status' => 'success', 'data' => $result));
	}

	public function getTakenSymbols(){
		$account_id = isset($_POST['account_id']) ? $_POST['account_id'] : NULL;
		$plan_id = isset($_POST['plan_id']) ? $_POST['plan_id'] : NULL;

		$result = $this->Summary_model->getTakenSymbols($account_id, $plan_id);

		echo json_encode(array('status' => 'success', 'data' => $result));
	}

	public function getJournalTableAll(){
		$account_id = isset($_POST['account_id']) ? $_POST['account_id'] : NULL;
		$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : NULL;
		$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : NULL;

		$result = $this->Summary_model->getJournalTableAll($account_id, $start_date, $end_date);

		echo json_encode(array('status' => 'success', 'data' => $result));
	}

	public function getJournalTableAllFilter(){
		$account_id = isset($_POST['account_id']) ? $_POST['account_id'] : NULL;
		$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : NULL;
		$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : NULL;

		$result = $this->Summary_model->getJournalTableAllFilter($account_id, $start_date, $end_date);

		echo json_encode(array('status' => 'success', 'data' => $result));
	}

	public function getJournalGroupedTickets() {
		$group_id = isset($_POST['group_id']) ? $_POST['group_id'] : NULL;

		$result = $this->Summary_model->getJournalGroupedTickets($group_id);

		echo json_encode(array('status' => 'success', 'data' => $result));
	}

	public function getJournalTableGroup(){
		$account_id = isset($_POST['account_id']) ? $_POST['account_id'] : NULL;

		$result = $this->Summary_model->getJournalTableGroup($account_id);

		echo json_encode(array('status' => 'success', 'data' => $result));
	}	

	public function getJournalGroupedItems(){
		$account_id = isset($_POST['account_id']) ? $_POST['account_id'] : NULL;
		$journal_group_id = isset($_POST['journal_group_id']) ? $_POST['journal_group_id'] : NULL;
		$curr_ticket = isset($_POST['curr_ticket']) ? $_POST['curr_ticket'] : NULL;
		$result = $this->Summary_model->getJournalGroupedItems($account_id, $journal_group_id, $curr_ticket);

		echo json_encode(array('status' => 'success', 'data' => $result));
	}

	public function getAccountHistory() {
		$account_id = isset($_POST['account_id']) ? $_POST['account_id'] : NULL;
		$plan_id = isset($_POST['account_id']) ? $_POST['account_id'] : NULL;;

		$result = $this->Summary_model->getAccountHistory($account_id, $plan_id);

		echo json_encode(array('status' => 'success', 'data' => $result));
	}

	public function getAccountDetailsModal() {
		$ticket_id = isset($_POST['ticket_id']) ? $_POST['ticket_id'] : NULL;

		$result = $this->Summary_model->getAccountDetailsModal($ticket_id);

		echo json_encode(array('status' => 'success', 'data' => $result));
	}

	public function getAccountSummaryJournal() {
		$account_id = isset($_POST['account_id']) ? $_POST['account_id'] : NULL;
		$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : NULL;
		$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : NULL;
		$symbols = isset($_POST['symbols']) ? $_POST['symbols'] : NULL;

		$result = $this->Summary_model->getAccountSummaryJournal($account_id, $start_date, $end_date, $symbols);

		echo json_encode(array('status' => 'success', 'data' => $result));
	}

	public function getAccountSummaryJournalFilter() {
		
		$account_id = isset($_POST['account_id']) ? $_POST['account_id'] : NULL;
		$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : NULL;
		$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : NULL;
		$symbols = isset($_POST['symbols']) ? $_POST['symbols'] : NULL;

		$result = $this->Summary_model->getAccountSummaryJournalFilter($account_id, $start_date, $end_date, $symbols);

		echo json_encode(array('status' => 'success', 'data' => $result));
	}

	public function getJournalSummary() {
		$account_id = isset($_POST['account_id']) ? $_POST['account_id'] : NULL;
		$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : NULL;
		$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : NULL;
		$symbols = isset($_POST['symbols']) ? $_POST['symbols'] : NULL;
		$result = $this->Summary_model->getJournalSummary($account_id, $start_date, $end_date, $symbols);
		echo json_encode(array('status' => 'success', 'data' => $result));
	}

	public function getJournalMainDetailsModal() {
		$account_id = isset($_POST['account_id']) ? $_POST['account_id'] : NULL;
		$ticket_id = isset($_POST['ticket_id']) ? $_POST['ticket_id'] : NULL;

		$result = $this->Summary_model->getJournalMainDetailsModal($account_id, $ticket_id);

		echo json_encode(array('status' => 'success', 'data' => $result));

	}

	public function deleteSSTimeframe(){
		$timeframe = isset($_POST['timeframe']) ? $_POST['timeframe'] : NULL;
		$ticket_id = isset($_POST['ticket_id']) ? $_POST['ticket_id'] : NULL;

		$result = $this->Summary_model->deleteSSTimeframe($timeframe, $ticket_id);

		echo json_encode(array('status' => 'success', 'data' => $result));
	}

	public function deleteSSTimeframe1(){
		$timeframe = isset($_POST['timeframe']) ? $_POST['timeframe'] : NULL;
		$ticket_id = isset($_POST['ticket_id']) ? $_POST['ticket_id'] : NULL;

		$result = $this->Summary_model->deleteSSTimeframe1($timeframe, $ticket_id);

		echo json_encode(array('status' => 'success', 'data' => $result));
	}

	public function SSTimeFrameReload() {
		$field = isset($_POST['field']) ? $_POST['field'] : NULL;
		$ticket_id = isset($_POST['ticket_id']) ? $_POST['ticket_id'] : NULL;

		$result = $this->Summary_model->SSTimeFrameReload($field, $ticket_id);

		echo json_encode(array('status' => 'success', 'data' => $result));
	}

	public function getAccountReason() {

		$account_id = isset($_POST['account_id']) ? $_POST['account_id'] : NULL;

		$result = $this->Summary_model->getAccountReason($account_id);

		echo json_encode(array('status' => 'success', 'data' => $result));
	}

	public function changeSSTimeframe() {
		$result = $this->Summary_model->changeSSTimeframe($_POST);
		echo json_encode($result);
	}

	public function changeSSTimeframe1() {
		$result = $this->Summary_model->changeSSTimeframe1($_POST);

		echo json_encode($result);
	}

	public function journalDetailsModalInsertUpdate() {

		$data = $_POST;

		$result = $this->Summary_model->journalDetailsModalInsertUpdate($data);
		echo json_encode(array('status' => 'success', 'data' => $result));

	}

	public function accountDetailsModalInsertUpdate() {
		$data = $_POST;

		$result = $this->Summary_model->accountDetailsModalInsertUpdate($data);
		echo json_encode(array('status' => 'success', 'data' => $result));
	}

	public function addNewReason() {
		$data = $_POST;

		$result = $this->Summary_model->addNewReason($data);
		echo json_encode(array('status' => 'success', 'data' => $result));
	}
}