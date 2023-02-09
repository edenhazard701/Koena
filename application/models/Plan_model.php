<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Plan_model extends CI_Model {

  public function updateUserSubscription($payment_method, $plan_id, $ref_no, $amount) {

    $user_id = $_SESSION['user_id'];
    $payment_reference_id = $ref_no;

    $query = $this->db->query("SELECT *, end_date >= CURDATE() as IsActuve FROM user_subscription WHERE user_id = ".$user_id." AND end_date >= CURDATE() order by end_date desc, id desc LIMIT 1");

    $user_subscription = $query->result();

    if(empty($user_subscription)) {
      $start_date = 'CURDATE()';
      $end_date = 'CURDATE()';
    } else {
      $user_subscription = $user_subscription[0];
      $start_date = $user_subscription->end_date;
      $end_date = $user_subscription->end_date;
    }

    if($plan_id == 2) {
      $days = 180;
    } else if($plan_id == 3) {
      $days = 365;
    } else {
      $days = 30;
    }

    if(empty($user_subscription)) {
      $data = array(
        'user_id' => $user_id,
        'plan_id' => $plan_id,
        'invoice_date' => "CURDATE()",
        'start_date' => $start_date,
        'end_date' => "DATE_ADD(".$end_date.", INTERVAL ".$days." DAY)",
        'payment_method' => $payment_method,
        'payment_reference_id' => $payment_reference_id,
        'amount' => $amount
      );
      $success = $this->db->insert('user_subscription', $data);
    } else {
      $data = array(
        'user_id' => $user_id,
        'plan_id' => $plan_id,
        'invoice_date' => "CURDATE()",
        'start_date' => $start_date,
        'end_date' => "DATE_ADD(".$end_date.", INTERVAL ".$days." DAY)",
        'payment_method' => $payment_method,
        'payment_reference_id' => $payment_reference_id,
        'amount' => $amount
      );
      $success = $this->db->insert('user_subscription', $data);
    }
    
    if (!$success) 
      return array('status' => 'error', 'message' => 'An error occured while updating plan details. Please Try again later!');

    $query = $this->db->query("update trade_summary set is_active=0 where acct in (select account_id from user_accounts where user_id=".$user_id.")");

    if (!$query) 
      return array('status' => 'error', 'message' => 'An error occured while updating plan details. Please Try again later!');

    $query = $this->db->query("SELECT *,end_date>=CURDATE() as IsActive FROM user_subscription WHERE user_id = ".$user_id." AND end_date>=CURDATE() order by id ASC LIMIT 1");
    $user_subscription = $query->result()[0];

    if (empty($user_subscription)) {
      $_SESSION['subscription_id'] = 0;
      $_SESSION["subscription_active"] = 0;
      $_SESSION['plan_id'] = 0;
    } else {
        $_SESSION['plan_id'] = $user_subscription->plan_id;
        $_SESSION['subscription_id'] = $user_subscription->id;
        $_SESSION["subscription_active"] = $user_subscription->IsActive;
    }

    if($_SESSION['plan_id']==0){
      $menu = array(
        array('id' => 1, 'name' => 'dashboard','page_name'=>'index','icon'=>'dashboard'),
        array('id' => 2, 'name' => 'Account Summary','page_name'=>'accountsummary','icon'=>'swap_vert'),
        array('id' => 3, 'name' => 'Journal Summary','page_name'=>'journalsummary','icon'=>'menu_book'),
        array('id' => 7, 'name' => 'Profile','page_name'=>'profile','icon'=>'person'),
      );
      $_SESSION['user_menu']  = $menu;
    } else {
      $menu = array(
        array('id' => 1, 'name' => 'dashboard','page_name'=>'index','icon'=>'dashboard'),
        array('id' => 2, 'name' => 'Account Summary','page_name'=>'accountsummary','icon'=>'swap_vert'),
        array('id' => 3, 'name' => 'Journal Summary','page_name'=>'journalsummary','icon'=>'menu_book'),
        array('id' => 4, 'name' => 'Sessions','page_name'=>'timezone','icon'=>'schedule'),
        array('id' => 7, 'name' => 'Profile','page_name'=>'profile','icon'=>'person')
      );
      $_SESSION['user_menu']  = $menu;
    }

    $_SESSION['is_plan_update'] = 1;

    return array('status' => 'success', 'message' => 'Plan subscribed successfully, Redirecting... (Please add/activate your account(s))');

  }
}
