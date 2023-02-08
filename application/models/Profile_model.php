<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_model extends CI_Model {

    public function getUserAccountList() {
        $isplanupdate = (isset($_SESSION['is_plan_update']) ? $_SESSION['is_plan_update'] : 0);
        $acct = null;
        if ($_SESSION["usertype_id"] == 1) {
            $query = $this->db->query("SELECT u.*,user_plan.*, uuu.username, uuu.email, us.plan_id, us.end_date, a.is_active,a.broker," .  $isplanupdate . " as is_plan_update, a.BaseGMT FROM user_accounts u inner join trade_summary a on u.account_id=a.acct inner join user uuu on u.user_id=uuu.user_id inner join user_subscription us on us.user_id=uuu.user_id INNER JOIN user_plan ON us.plan_id=user_plan.id GROUP BY u.account_id ORDER BY u.account_id ASC");
        } else {
            $query = $this->db->query("SELECT u.*, user_plan.*,uuu.username, uuu.email, us.plan_id, us.end_date, a.is_active,a.broker," .  $isplanupdate . " as is_plan_update, a.BaseGMT FROM user_accounts u inner join trade_summary a on u.account_id=a.acct inner join user uuu on u.user_id=uuu.user_id inner join user_subscription us on us.user_id=uuu.user_id INNER JOIN user_plan ON us.plan_id=user_plan.id WHERE u.user_id = ".$_SESSION['user_id']." GROUP BY u.account_id ORDER BY u.account_id ASC ");
        }

        $acct = $query->result();

        return $acct;
    }

    public function updateAccountStatus($account_id, $status)
    {
        if ($_SESSION['is_plan_update'] == 1) {
            $status1 = 0;
            if ($status == "true") {
                $query = $this->db->query("SELECT * from user_plan WHERE id=".$_SESSION['plan_id']."");
                $plan_details = $query->result();
                $query = $this->db->query("SELECT count(*) as accounts_count FROM user_accounts u inner join trade_summary a on u.account_id=a.acct  WHERE u.user_id = ".$account_id." and a.is_active=1");
                $user_accounts = $query->result();
                if ($user_accounts[0]->accounts_count >= $plan_details[0]->noofaccounts)
                    return array('status' => 'error', 'message' => 'Cannot activate account, you have reached your plan limit, you are only allowed ' . $plan_details["noofaccounts"] . ' active accounts.');
                $status1 = 1;
                $u_select = NULL;
            } else {
                // $u_select = ' and u.user_id = ".$_SESSION['user_id']."';
            }

            $query = $this->db->query("update trade_summary set is_active=".$status." where acct=".$account_id."");
            if ($query <= 0) return array('status' => 'error', 'message' => 'An error occured while updating. Please Try again later!');

            if ($account_id == $_SESSION["account_id"]) {
                if ($status == "true") {
                    $_SESSION["account_active"] = 1;
                } else {
                    $_SESSION["account_active"] = 0;
                }
            }

            return array('status' => 'success','message' => 'Account ' . (($status == "true") ? 'activated' : 'deactivated') . ' successfully.');
        } else {
            return array('status' => 'error', 'message' => 'Unable to update, its only allowed one time after plan subscription.');
        }
    }

    // Get User Accounts
    public function getUserAccounts1()
    {
        $isplanupdate = (isset($_SESSION['is_plan_update']) ? $_SESSION['is_plan_update'] : 0);
        $acct = null;
        $query = $this->db->query("SELECT u.*, user_plan.*,uuu.username, uuu.email, us.plan_id, us.end_date, a.is_active,a.broker," .  $isplanupdate . " as is_plan_update, a.BaseGMT FROM user_accounts u inner join trade_summary a on u.account_id=a.acct inner join user uuu on u.user_id=uuu.user_id inner join user_subscription us on us.user_id=uuu.user_id INNER JOIN user_plan ON us.plan_id=user_plan.id WHERE u.account_id = ".$_SESSION['account_id']." GROUP BY u.account_id ORDER BY u.account_id ASC ");
        
        $acct = $query->result();
        return $acct;
    }

    public function getPlans() {
        $query = $this->db->query("select * from user_plan");
        return $query->result();
	}

    public function delectAccount($account_id){

        // Cleaning `closedtrades` table with Acc_Id field
        $query = $this->db->query("DELETE from closedtrades WHERE Acc_Id=".$account_id."");
        if ($query <= 0) return array('status' => 'error', 'message' => 'An error occured while cleaning `closedtrades`. Please Try again later!');

        // Cleaning `deposit_withdrawal` table with acc_ID field
        $query = $this->db->query("DELETE from deposit_withdrawal WHERE acc_ID=".$account_id."");
        if ($query <= 0) return array('status' => 'error', 'message' => 'An error occured while cleaning `deposit_withdrawal`. Please Try again later!');

        // Cleaning `tradejournal` table with Acc_Id field
        $query = $this->db->query("DELETE from tradejournal WHERE Acc_Id=".$account_id."");
        if ($query <= 0) return array('status' => 'error', 'message' => 'An error occured while cleaning `tradejournal`. Please Try again later!');

        // Cleaning `trades_details` table with acct field
        $query = $this->db->query("DELETE from trades_details WHERE acct=".$account_id."");
        if ($query <= 0) return array('status' => 'error', 'message' => 'An error occured while cleaning `trades_details`. Please Try again later!');

        // Cleaning `trade_summary` table with acct field
        $query = $this->db->query("DELETE from trade_summary WHERE acct=".$account_id."");
        if ($query <= 0) return array('status' => 'error', 'message' => 'An error occured while cleaning `trade_summary`. Please Try again later!');

        // Cleaning `user_reason` table with account_id field
        $query = $this->db->query("DELETE from user_reason WHERE account_id=".$account_id."");
        if ($query <= 0) return array('status' => 'error', 'message' => 'An error occured while cleaning `user_reason`. Please Try again later!');

        // FINALLY remove account from `user_accounts` table with account_id field
        $query = $this->db->query("DELETE from user_accounts WHERE account_id=".$account_id."");
        if ($query <= 0) return array('status' => 'error', 'message' => 'An error occured while cleaning `user_accounts`. Please Try again later!');

        return array('status' => 'success', 'messsage' => 'Account #'.$account_id.' delete successfully.');
    }

    public function addAccount($account_id)
    {
        $query = $this->db->query("SELECT count(*) as accounts_count FROM user_accounts WHERE account_id=".$account_id."");
        $user_accounts_already = $query->result();

        if ($user_accounts_already[0]->accounts_count > 0) {
            return array('status' => 'error', 'message' => 'This account No already exists in your user or another user.');
        }

        $query = $this->db->query("SELECT * from user_plan WHERE id=".$_SESSION['plan_id']."");
        $plan_details = $query->result();

        $query = $this->db->query("SELECT count(*) as accounts_count FROM user_accounts u inner join trade_summary a on u.account_id=a.acct  WHERE u.user_id = ".$_SESSION['user_id']." and a.is_active=1");
        $user_accounts = $query->result();

        if ($user_accounts[0]->accounts_count >= $plan_details[0]->noofaccounts) {
            return array('status' => 'error', 'message' => 'Cannot add account, you have reached your plan limit, you are only allowed to add ' . $plan_details["noofaccounts"] . ' accounts.');
        } else {
            $date = date('Y-m-d h:i:s');
            $is_default = 0;
            $is_active = 0;
            $query = $this->db->query("INSERT INTO `user_accounts`(`user_id`, `account_id`,`is_default`,`created_date`) VALUES (".$_SESSION['user_id'].",".$account_id.",".$is_default.", '".$date."')");

            if ($query <= 0) return array('status' => 'error', 'message' => 'An error occured while adding account. Please Try again later!');

            $query = $this->db->query("INSERT INTO `trade_summary`(`acct`, `accountid`,`is_active`) VALUES ($account_id,$account_id,".$is_active.")");

            if ($query <= 0) return array('status' => 'error', 'message' => 'An error occured while adding account. Please Try again later!');

            return array('status' => 'success', 'message' => 'Account addedd successfully.');
        }
    }

    //Get User Invoices
    public function getUserInvoices() {

        
        $query = $this->db->query("SELECT * FROM `user_subscription` WHERE `user_id` = ".$_SESSION['user_id']." ORDER BY `end_date` DESC");
        
        $inovices = $query->result();
        

        if (!$inovices) {
            return "";
        } 

        return  $inovices;
    }


    public function changeUsername($uname, $email) {
        $this->db->query("UPDATE user SET `username` = '".$uname."' WHERE `email` = '".$email."';");
        $_SESSION['username'] = $uname;
        return 1;
	}

    public function updateUserProfile($data) {
        $user_id = $_SESSION['user_id'];
        $firstname = $data['fname'];
        $phone = $data['phone'];
        $lastname = $data['lname'];
        $street = $data['street'];
        $city = $data['city'];
        $userstate = $data['state'];
        $country = $data['country'];
        $zipcode = $data['zipcode'];
		$this->db->query("UPDATE user SET `phone` = '".$phone."', firstname='".$firstname."', lastname='".$lastname."',street='".$street."',city='".$city."',userstate='".$userstate."' ,country='".$country."',zipcode='".$zipcode."' WHERE user_id = ".$user_id."");

		$_SESSION['fname'] = $data['fname'];
		$_SESSION['lname'] = $data['lname'];
		$_SESSION['street'] = $data['street'];
		$_SESSION['city'] = $data['city'];
		$_SESSION['phone'] = $data['phone'];
		$_SESSION['state'] = $data['state'];
		$_SESSION['country'] = $data['country'];
		$_SESSION['zipcode'] = $data['zipcode'];
        return 1;
	}
}
