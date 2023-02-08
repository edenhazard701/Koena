<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

    public function getUserAccounts() {
        $isplanupdate = (isset($_SESSION['is_plan_update']) ? $_SESSION['is_plan_update'] : 0);
        $acct = null;
        if ($_SESSION["usertype_id"] == 1) {
            $query = $this->db->query("SELECT u.*,user_plan.*, uuu.username, uuu.email, us.plan_id, us.end_date, a.is_active,a.broker," .  $isplanupdate . " as is_plan_update, a.BaseGMT FROM user_accounts u inner join trade_summary a on u.account_id=a.acct inner join user uuu on u.user_id=uuu.user_id inner join user_subscription us on us.user_id=uuu.user_id INNER JOIN user_plan ON us.plan_id=user_plan.id GROUP BY u.account_id ORDER BY u.account_id ASC");
            $acct = $query->result();
        } else {
            $query = $this->db->query("SELECT u.*, user_plan.*,uuu.username, uuu.email, us.plan_id, us.end_date, a.is_active,a.broker," .  $isplanupdate . " as is_plan_update, a.BaseGMT FROM user_accounts u inner join trade_summary a on u.account_id=a.acct inner join user uuu on u.user_id=uuu.user_id inner join user_subscription us on us.user_id=uuu.user_id INNER JOIN user_plan ON us.plan_id=user_plan.id WHERE u.user_id = ".$_SESSION['user_id']." GROUP BY u.account_id ORDER BY u.account_id ASC ");
            $acct = $query->result();
        }

        return array('status' => "success", "message" => "Data fetched!", $acct);
    }

    public function loadCalendarUpper($acct) {
        $query = $this->db->query("SELECT
                ROUND(SUM(`Profit`),
                2) AS profit,
                DATE_FORMAT(`CloseTime`, '%Y-%m-%d') AS day
            FROM
                `closedtrades`
            WHERE
                `Acc_Id` = $acct
            GROUP BY
                day;");
        
        $acct = $query->result();

        if (!$acct) { return array('status' => "error", "message" => "Data not fetched data for user: ".$data['account_id']."", $acct);}
        return $acct;
    }

    public function get_active_inactive_account()
    {
        $query = $this->db->query("SELECT ( SELECT COUNT(*) FROM trade_summary Where is_active='1') AS active_accounts, 
            (SELECT COUNT(*) FROM trade_summary Where is_active='0') AS inactive_accounts");
        
        return $query->result(); 
    }

    public function get_active_inactive_client()
    {
        $query = $this->db->query("SELECT ( 
            SELECT COUNT(DISTINCT user.user_id) FROM user INNER JOIN user_subscription ON user.user_id= user_subscription.user_id WHERE user_subscription.end_date>=CURDATE() AND user.user_type_id = 2) AS active_clients,
        ( 
            SELECT COUNT(DISTINCT user.user_id) FROM user INNER JOIN user_subscription ON user.user_id= user_subscription.user_id WHERE user_subscription.end_date<CURDATE() AND user.user_type_id = 2) AS inactive_clients
        ");
        
        return $query->result(); 
    }

    public function getTableData()
    {
        $query = $this->db->query('CALL spAccountsStatus()');
    
        return $query->result(); 
    }

    public function getPlan()
    {

        $query = $this->db->query("SELECT COUNT(user_subscription.plan_id) as pid, user_plan.name as most_purchased_package FROM user_subscription INNER JOIN user_plan ON user_subscription.plan_id=user_plan.id where user_plan.price > 0 GROUP BY user_subscription.plan_id, user_plan.name ORDER BY 1 DESC LIMIT 1");
        
        return $query->result(); 
    }

    public function getPaymentTable()
    {
        $query = $this->db->query("SELECT payment_method , sum(amount) AS amount FROM user_subscription GROUP BY payment_method ORDER BY amount DESC");
        
        return $query->result(); 
    }

    public function getAccounts($user_id){
        $sql = "";

        if ($user_id) {
            $sql = "SELECT acct, is_active, BaseGMT FROM trade_summary WHERE acct IN (SELECT account_id FROM user_accounts WHERE user_id=".$user_id.") ORDER BY acct";
        } else {
            $sql = "SELECT acct, is_active, BaseGMT FROM trade_summary WHERE acct IN (SELECT account_id FROM user_accounts WHERE 1) ORDER BY acct";
        }
        
        $query = $this->db->query($sql);

        $acct = $query->result();
        
        if (!$acct) {
            $acct[] = [
                'acct'  => 'none',
                'is_active' => 0
            ];
        }

        return $acct;
    }

    public function deleteUser($uid)
    {
        $sql = "";
        $sql = "SELECT * FROM user WHERE user_id = ".$uid." AND status = 1";
        $query = $this->db->query($sql);
        $checkUser = $query->result();

        if (count($checkUser) == 0) return array('status' => "error", "message" => "No user found.");
        
        $sql = "DELETE from user_accounts WHERE user_id=".$uid;
        $this->db->query($sql);
        
        $sql = "DELETE from user_subscription WHERE user_id=".$uid;
        $this->db->query($sql);
        
        return array('status' => "success", "message" => "User and his Accounts removed successfuly!");
    }

    public function getAccountSummary($acct) {

        $sql = "";
        $sql = "CALL spAccountSummary($acct, ".$_SESSION['plan_id'].")";
        $query = $this->db->query($sql);
        $res = $query->result();

        if (!$res) return array('status' => "error", "message" => "No data found belongs to this account");

        return array('status' => "success", "message" => "Data fetched!", $res);
    }

    //General Dashboard controller

    // Get Account Symbols
    public function getAccountSymbols($acct)
    {   
        $sql = "";
        $sql = "SELECT DISTINCT td.symbol FROM trades_details td WHERE td.acct = $acct AND (".$_SESSION['plan_id'].">1 OR td.symbol IN (SELECT symbol FROM symbols))";
        $query = $this->db->query($sql);
        $res = $query->result();

        if (!$res) return array('status' => "error", "message" => "No data found.");

        return $res['data'];
    }

    public function getSymbolCharts($acct, $filterType, $start_date, $end_date) {
        $cond = '';
        switch ($filterType) {
            case '2' : {
                $cond = "AND (DATE(c.CloseTime) = DATE(NOW()))";
                break;
            }
            case 3 : {
                $cond = "AND YEARWEEK(c.CloseTime) = YEARWEEK(NOW())";
                break;
            }
            case 4 : {
                $cond = "AND MONTH(c.CloseTime) = MONTH(NOW()) AND YEAR(c.CloseTime) = YEAR(NOW())";
                break;
            }
            case 5 : {
                if ($start_date != '' && $end_date != '') {
                    $cond = "AND DATE(c.CloseTime) BETWEEN '".$start_date."' AND '".$end_date."'";
                }
                break;
            }
            default : {
                $cond = "";
                break;
            }
        }
        $sql = "";
        $sql = "SELECT `Symbol` as Symbol, SUM(`Profit`) as Profit, COUNT(`Symbol`) as Num, SUM(`Profit`) / COUNT(`Symbol`) as Strength
            FROM `closedtrades` c
            WHERE c.Acc_Id=$acct
            {$cond}
            GROUP BY `Symbol`
            ORDER BY strength DESC";
        $query = $this->db->query($sql);

        $res = $query->result();

        return $res;
    }

    public function getTotalTradeSummary($acct) {
        $sql = "";
        $sql = "CALL spTradeSummary ($acct, 111, 11, null, 1, 3)";
        $query = $this->db->query($sql);
        $res = $query->result();

        if (!$res) return array('status' => "success", "message" => "No data found!");
        return array('status' => "success", "message" => "Data fetched!", $res);
    }

    public function getTotalTradeSummaryFilter($acct, $filterType, $start_date, $end_date) {

        $sql = "";
        $sql = "CALL spTradeSummary ($acct, '$start_date', '$end_date', null, $filterType, 3)";
        $query = $this->db->query($sql);
        $res = $query->result();

        if (!$res) return array('status' => "success", "message" => "No data found!");
        return $res;
    }

    public function getPerformanceGrowth($acct) {
        $sql = "";
        $sql = "SELECT * FROM (SELECT ct.CloseTime as date, 'profit' as type, (ct.Profit+ct.Commission+ct.Swap) as value FROM closedtrades ct WHERE ct.Acc_Id=$acct
            UNION ALL (SELECT dw.date as date, CASE 
                    WHEN dw.withdrawal<>0 THEN 'withdrawal'
                    ELSE 'deposit'
                    END as type, CASE 
                    WHEN dw.withdrawal<>0 THEN dw.withdrawal
                    ELSE dw.deposit
                    END as typevalue FROM deposit_withdrawal dw WHERE dw.acc_ID=$acct )) his
                    ORDER BY his.date";
        $query = $this->db->query($sql);
        $res = $query->result();

        if (!$res) return array('status' => "error", "message" => "No data found!");
        // return array('status' => "success", "message" => "Data fetched!", $res);
        $p_type = NULL;
        foreach ($res as $step) {
            $history[strftime("%B, %Y", strtotime(str_replace('.', '/', $step->date)))][] = $step;
        }

        return array('status' => 'success', 'messsage' => 'Data fetched!', $this->_count_PG($history, false));
    }

    public function _count_PG($history, $log=true) {

        if (!is_array($history)) return;
        
        $deposit = 0;
        $end_bal = 0;
        $starting_val = 0;
        
        foreach ($history as $month=>$list) {
            $m_money = 0;
            $is_already_withdrawal = false;
            $is_trade = false;
            $is_upcoming_deposit = false;
            $is_upcoming_withdrawal = false;
            $single_month_arr = array();
                

            $deposit = $starting_val;
           
            $i=0;
            $array_keys = array_column($list, 'type');
            
            foreach ($list as $key=>$operation) {

                
                switch ($operation->type) {
                    case 'profit' : {
                        
                        
                        
                        if(isset($array_keys[$i+1]) && !empty($array_keys[$i+1])){
                            if($array_keys[$i+1] == 'deposit' || $array_keys[$i+1] == 'withdrawal'){
                                array_push($single_month_arr,$starting_val."_".($deposit+$operation->value));
                            }
                        }else if($i == (count($array_keys)-1)){

                            array_push($single_month_arr,$starting_val."_".($deposit+$operation->value));
                        }
                        
                        $deposit += $operation->value;
                        
                        $m_money += $operation->value;
                        
                        break;
                    }
                    case 'deposit' : {

                        
                        $deposit += $operation->value;
                        $starting_val = $deposit;
                        
                        break;
                    }

                    case 'withdrawal' : {
                        $deposit -= $operation->value;
                        $starting_val = $deposit;
                        break;
                    }
                }
                
              $i++;  
            }

            $starting_val = $deposit;            
                
                $final_cal = 1;
                
                foreach($single_month_arr as $value) {
                    $value = explode('_',$value);
                    $profit_loss = (($value[1]/$value[0])-1)*100;
                    $final_cal *= (1+$profit_loss/100);
                }

                $groth = $final_cal-1;
                $groth = $groth*100;
                

                $res[] = [
                    'months'    => $month,
                    'profit'    => $groth,
                    'cash'      => $m_money,
                ];

            //exit();    
        }
            
        $plPercentage = 1;

        if(!empty($res)){
            foreach($res as $month_data){
                $plPercentage *= (1+$month_data['profit']/100);
            }
        }

        $plPercentage = $plPercentage-1;
        $plPercentage = $plPercentage*100;
        $res[]['plPercentage'] = $plPercentage;
        
        return $res;
    }
}
