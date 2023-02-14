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
        $_SESSION['color'] = 'light';
        $_SESSION['birth_date'] = $user->birth_date == '0000-00-00'?date('Y-m-d'):$user->birth_date;

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

    
    public function forgotPassword($email) {

        $active_code=md5(uniqid(rand(5, 15), true));
        $link = 'http://154.44.150.137/koena-new/forgot_password?key='.$active_code;

        $query = $this->db->query("SELECT * FROM user WHERE email = '".$email."' AND status = 1");

        $user = $query->result();
        if (empty($user)){
            return array('status' => "error", "message" => "No user found with this email address. Please enter another email address.");
        }else{
            $user = $user[0];

            $data = array(
                'changepwdtoken' => $active_code,
                'ispwdchange' => 0
            );

            $this->db->where('user_id', $user->user_id);
            $success = $this->db->update('user', $data);

            if(!$success)
                return array('status' => "error", "message" => "An error occured while reset password. Please Try again later!");

            //send email
            $to = $email; //change to ur mail address
            $strSubject="Koena Tech | Password Recovery Link";
            $message = 'Hi! '.$user->username.'
';
            $message .= 'Password Recovery Link : 
'.$link.'' ; 

            $this->email->from('test@gmail.com', 'Identification');
            $this->email->to($to);
            $this->email->subject($strSubject);
            $this->email->message($message);
            
            if($this->email->send()) {
                return array('status' => "success", "message" => "Email send successfully to reset the password. Please check your email.");
            } else {
                return array('status' => "error", "message" => "An error occured while sending email. Please Try again later!");
            }
            
        }
    }

    public function resetPassword($password, $resetKey) {
        $query = $this->db->query("SELECT * FROM user WHERE changepwdtoken = '".$resetKey."' AND status = 1 AND ispwdchange = 0");
        $user = $query->result();

        if (empty($user)) 
            return array('status' => 'error', 'message' => 'Invalid token or password is already reset!');
        $user = $user[0];

        $data = array(
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'user_id' => $user->user_id,
            'changepwdtoken' => ''
        );

        $this->db->where('user_id', $user->user_id);
        $success = $this->db->update('user', $data);

        if (!$success) 
            return array('status' => 'error', 'message' => 'An error occured while updating this password. Please Try again later!');

        return array('status' => 'success', 'message' => 'Password Changed successfully!');
    }
}