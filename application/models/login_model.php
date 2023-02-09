<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Login_model extends CI_Model {
		
	// Login User
    public function loginUser($email, $password)
    {
        $sql = "SELECT * FROM user WHERE email = '".$email."' OR username ='".$email."'";
        $query = $this->db->query($sql);
        $user = $query->result();

        if (empty($user)) return array('status' => "error", "message" => "Invalid email or password!");
        
        $user = $user[0];

        if (!password_verify($password, $user->password)) return array('status' => "error", "message" => "Invalid email or password!");

        if ($user->status == 0) return array('status' => "error", "message" => "User is not active, Please contact support.");

        $sql = "SELECT *, end_date>=CURDATE() as IsActive FROM user_subscription WHERE user_id = ".$user->user_id." AND end_date>=CURDATE() order by id ASC LIMIT 1";

        $query = $this->db->query($sql);

        $user_subscription = $query->result();
        if (!$user_subscription) {
            $_SESSION['subscription_id'] = 0;
            $_SESSION["subscription_active"] = 0;
            $_SESSION['plan_id'] = 0;
        } else {
            $_SESSION['plan_id'] = $user_subscription[0]->plan_id;
            $_SESSION['subscription_id'] = $user_subscription[0]->id;
            $_SESSION["subscription_active"] = $user_subscription[0]->IsActive;
        }

        $_SESSION["usertype_id"] = $user->user_type_id;
        $_SESSION['user_id'] = $user->user_id;
        $_SESSION['username'] = $user->username;
        $_SESSION['email'] = $user->email;
        $_SESSION['avatar'] = $user->avatar;
        $_SESSION['GMT'] = $user->gmt;
        $_SESSION['fname'] = $user->firstname;
        $_SESSION['lname'] = $user->lastname;
        $_SESSION['street'] = $user->street;
        $_SESSION['city'] = $user->city;
        $_SESSION['phone'] = $user->phone;
        $_SESSION['state'] = $user->userstate;
        $_SESSION['country'] = $user->country;
        $_SESSION['zipcode'] = $user->zipcode;
        
        $sql = "SELECT acct, is_active FROM trade_summary WHERE acct IN (SELECT account_id FROM user_accounts WHERE user_id=".$user->user_id.")";
        $query = $this->db->query($sql);
        $accountList = $query->result();

        if ($accountList) {
            $defaultAccount = '';
            $account_found = false;
            foreach ($accountList as $key => $account) {
                if ($key == 0) {
                    $defaultAccount = $account->acct;
                }

                if ($account->is_active == 1) {
                    $_SESSION["account_id"] =  $account->acct;
                    $_SESSION["account_active"] = $account->is_active;
                    $account_found = true;
                    break;
                }
            }

            if ($account_found == false) {
                $_SESSION["account_id"] =  $defaultAccount;
                $_SESSION["account_active"] = 0;
            }
        }else{
            $_SESSION["account_id"] =  0;
            $_SESSION["account_active"] = 0;
        }
        
        $_SESSION['is_plan_update'] = 1;
        // $_SESSION['BaseGMT'] = $this->baseGMT($_SESSION["account_id"]);

        return array('status' => "success", "message" => "Logged in successfully!", 'type' => $_SESSION["usertype_id"]);
    }
}