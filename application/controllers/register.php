<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {
	
	public function __construct(){
     	parent::__construct();
     	$this->load->model("Register_model");
  	}

  	public function index(){
		$this->load->view('register_view');
	}

	public function registerUser()
    {
    	$params = isset($_POST)?$_POST:NULL;

        $res = $this->Register_model->registerUser($params);
        if( $res){
        	echo json_encode(array('status' => "success", "message" => 'You have registered successfully!'));	
        }else{
        	echo json_encode(array('status' => "error", "message" => 'Email send successfully to verify email. Please check your email.'));	
        }
    }

    public function resendVerificationEmail(){
	$params = isset($_POST)?$_POST:NULL;

        $res = $this->Register_model->resendVerificationEmail($params);
        if( $res){
        	echo json_encode(array('status' => "success", "message" => 'Email send successfully to verify email. Please check your email.!'));	
        }else if($res == 3){
        	echo json_encode(array('status' => "error", "message" => 'No user found with this email address. Please enter another email address.'));	
        }else{
        	echo json_encode(array('status' => "error", "message" => 'An error occured while sending email. Please Try again later!'));	
        }
    }

    public function changeEmail(){
    	$params = isset($_POST)?$_POST:NULL;
    	$res = $this->Register_model->changeEmail($params);
    	if($res == 4){
        	echo json_encode(array('status' => "error", "message" => "No user found with this email address. Please enter another email address."));	
        }else if($res == 5){
        	echo json_encode(array('status' => "error", "message" => 'An error occured while sending email. Please Try again later!'));	
        } else {
        	echo json_encode(array('status' => "success", "message" => 'Email send successfully to verify email. Please check your email.'));	
        }
	
    }

    public function completeRegistration(){
		$params = isset($_POST)?$_POST:NULL;

        $res = $this->Register_model->completeRegistration($params);
        if( $res){
        	echo json_encode(array('status' => "success", "message" => 'Registration successful. Please wait while redirecting to login page!'));	
        }else{
        	echo json_encode(array('status' => "error", "message" => 'An error occured while updating this password. Please Try again later!'));	
        }
     }

}