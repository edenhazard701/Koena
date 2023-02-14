<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forgot_Password extends CI_Controller {
  public function __construct(){
		parent::__construct();

		$this->load->model("Login_model");
	}

  public function index() {
    $this->load->view('forgot_password');
  }

  public function forgotPassword() {
    $params = $this->input->post();

    $email = isset($params['email']) ? $params['email'] : '';

    $state = $this->Login_model->forgotPassword($email);

    echo json_encode(array('status' => $state['status'], "message" => $state['message']));	
  }

  public function resetPassword() {
    $params = $this->input->post();

    $password = isset($params['password']) ? $params['password'] : '';
    $resetKey = isset($params['resetKey']) ? $params['resetKey'] : '';

    $state = $this->Login_model->resetPassword($password, $resetKey);

    echo json_encode(array('status' => $state['status'], "message" => $state['message']));	
  }
}