<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->model("Profile_model");
	}

	public function index(){
		if (isset($_GET['ac'])){
			$_SESSION['account_id'] = $_GET['ac'];
		};
		$planlist = $this->Profile_model->getPlans();
		$params = array(
			'title' => "Profile",
			'selections' => json_encode(array("user", "profile")),
			'data' => array(
				'planlist' => $planlist
			)
		);
		$this->load_view('profile/account-listing_view.php',$params);
	}

  public function getUserAccountList() {
		$account = $this->Profile_model->getUserAccountList();
		
		echo json_encode(array('status' => "success", "data" => $account));
	}

	public function updateAccountStatus() {
		$account_id = isset($_POST['account_id']) ? $_POST['account_id'] : NULL;
		$status = isset($_POST['status']) ? $_POST['status'] : NULL;

		$status = $status == "Activate" ? 1 : 0;

		$account = $this->Profile_model->updateAccountStatus($account_id, $status);
		echo json_encode(array('status' => "success", "data" => $account));
	}

	public function getUserAccounts() {
		$account = $this->Profile_model->getUserAccountList();
		echo json_encode(array('status' => "success", "data" => $account));
	}

	public function delectAccount() {
		$account_id = isset($_POST['account_id']) ? $_POST['account_id'] : NULL;

		$account = $this->Profile_model->delectAccount($account_id);
		echo json_encode(array('status' => "success", "data" => $account));
	}

	public function addAccount() {
		$account_id = isset($_POST['account_id']) ? $_POST['account_id'] : NULL;

		$account = $this->Profile_model->addAccount($account_id);
		echo json_encode(array('status' => "success", "data" => $account));
	}

	public function changeUsername() {
		$uname =  isset($_POST['username'])?$_POST['username']:NULL;
		$birth_date = isset($_POST['birth_date'])?$_POST['birth_date']:NULL;
		$email = $_SESSION['email'];
		$result =$this->Profile_model->changeUsername($uname, $email, $birth_date);
		if($result){
			echo json_encode(array('status' => "success"));
		}else{
			echo json_encode(array('status' => "error"));
		}
	}

	public function getUserInvoices() {
		$account = $this->Profile_model->getUserInvoices();
		echo json_encode(array('status' => "success", "data" => $account));
	}
	
	public function profile(){
		if (isset($_GET['ac'])){
			$_SESSION['account_id'] = $_GET['ac'];
		};

		$planlist = $this->Profile_model->getPlans();

		$params = array(
			'title' => "Profile",
			'selections' => json_encode(array("user", "profile")),
			'data' => array(
				'planlist' => $planlist
			)
		);
		$this->load_view('profile/account-listing_view.php', $params);
	}

	public function updateUserProfile() {
		$params =  isset($_POST)?$_POST:NULL;
		$profile = $this->Profile_model->updateUserProfile($params);
		if($profile){
			echo json_encode(array('status' => "success")); 
		}
		else{
			echo json_encode(array('status' => "error"));
		}
	}

	public function changeTimezone(){
		$params =  isset($_POST['timezone'])?$_POST['timezone']:$_SESSION['GMT'];
		$_SESSION['GMT'] = $params;

		echo json_encode(array('status' => 'success'));
	}


	public function getPlans()
    {
		if (isset($_GET['ac'])){
			$_SESSION['account_id'] = $_GET['ac'];
		};

		$planlist = $this->Profile_model->getUserAccounts1();

		$params = array(
			'title' => "Plan",
			'selections' => json_encode(array("user", "plan")),
			'data' => array(
				'planlist' => $planlist
			)
		);
		$this->Profile_model->getPlans();
        $result = $this->query("select * from user_plan");
        return $result;
    }

	public function changeAvatar() {
		$file = isset($_FILES) ? $_FILES: NULL;
		$post = isset($_POST) ? $_POST: NULL;

		$res = $this->Profile_model->changeAvatar($file, $post);

		redirect('/profile');
  }


	//////////////email change bt
	public function resetPasswordReset($data) {

		$params = isset($_POST)?$_POST:NULL;
        $res = $this->Profile_model->resetPasswordReset($params);
        if( $res){
        	echo json_encode(array('status' => "success", "message" => 'Email send successfully to verify email. Please check your email.!'));	
        }else if($res == 3){
        	echo json_encode(array('status' => "error", "message" => 'No user found with this email address. Please enter another email address.'));	
        }else{
        	echo json_encode(array('status' => "error", "message" => 'An error occured while sending email. Please Try again later!'));	
        }
	}

	public function resetEmailReset($data) {

		$params = isset($_POST)?$_POST:NULL;
        $res = $this->Profile_model->resetPasswordReset($params);
        if( $res){
        	echo json_encode(array('status' => "success", "message" => 'Email send successfully to verify email. Please check your email.!'));	
        }else if($res == 3){
        	echo json_encode(array('status' => "error", "message" => 'No user found with this email address. Please enter another email address.'));	
        }else{
        	echo json_encode(array('status' => "error", "message" => 'An error occured while sending email. Please Try again later!'));	
        }
	}

	public function changeGMT() {
		$timezone =  isset($_POST['timezone'])?$_POST['timezone']:$_SESSION['GMT'];

		$res = $this->Profile_model->changeGMT($timezone);
		echo json_encode(array('status' => 'success', 'message' => 'GMT Changed successfully! Reloading'));
	}

}



