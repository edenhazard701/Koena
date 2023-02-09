<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Plan extends CI_Controller {
  public function __construct(){
		parent::__construct();

		$this->load->model("Plan_model");
	}

  public function updatePlanStatus() {
    $params = $this->input->post();
    $payment_method = isset($params['paymentMethod']) ? $params['paymentMethod'] : '';
    $plan_id = isset($params['id']) ? $params['id'] : '';
    $ref_no = isset($params['refno']) ? $params['refno'] : '';
    $amount = isset($params['amount']) ? $params['amount'] : 0;

    $res = $this->Plan_model->updateUserSubscription($payment_method, $plan_id, $ref_no, $amount);

    echo json_encode(array('status' => $res['status'], "message" => $res['message']));
  }
}