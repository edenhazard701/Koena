<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	
	public function __construct(){
     	parent::__construct();
     	$this->load->model("Login_model");
  	}

	public function index(){
		$this->load->view('login_view');
	}

	public function checkAuth() {
		$email = isset($_POST['email']) ? $_POST['email'] : NULL;
		$password = isset($_POST['password']) ? $_POST['password'] : NULL;

		$state = $this->Login_model->loginUser($email, $password);
		
		echo json_encode(array('status' => $state['status'], "message" => $state['message'], "type" => !empty($state['type']) ? $state['type'] : '') );

	}
}