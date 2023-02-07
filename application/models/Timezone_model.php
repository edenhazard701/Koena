<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Timezone_model extends CI_Model {

    public function getTableData($sessionGMT, $baseGMT)
    {    
        $diff = $baseGMT;
        $account_id = $_SESSION['account_id'];
        $plan_id = $_SESSION['plan_id'];
        $query = $this->db->query('CALL spTimeZoneSummary('.$account_id.','.$diff.','.$plan_id.')');
        $result = $query->result();
        _h_openclose($result, $sessionGMT);
        return $query->result(); 
    }

    public function getBrokersTimeADayData($sessionGMT, $baseGMT) {
        $diff = ($_SESSION['GMT'] - $baseGMT ) + ($sessionGMT - $_SESSION['GMT']);
        $account_id = $_SESSION['account_id'];
        $plan_id = $_SESSION['plan_id'];
        $query = $this->db->query("CALL spTimeADaySummary (".$account_id.",".$diff.",".$plan_id.")");

        $result = $query->result();

        return $result;
    }

    public function modalBestWorstHrSession($baseGMT, $timezone) {
        $account_id = $_SESSION['account_id'];
        if($timezone === 'max'){
            $query = $this->db->query("SELECT *  FROM `closedtrades` WHERE `Acc_Id` = $account_id GROUP BY(HOUR(closedtrades.OpenTime) + $baseGMT) ORDER BY profit DESC");
        }else{
            $query = $this->db->query("SELECT *  FROM `closedtrades` WHERE `Acc_Id` = $account_id GROUP BY(HOUR(closedtrades.OpenTime)) ORDER BY profit ASC");
        }

        $bestWorsthrSessions = $query->result();
        return $bestWorsthrSessions;
    }

}
?>
