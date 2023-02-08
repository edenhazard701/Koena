<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Timezone_model extends CI_Model {

    public function getTableData($sessionGMT, $baseGMT, $profileGMT)
    {    
        $diff = $baseGMT;
        $profileGMT = $profileGMT;
        $account_id = $_SESSION['account_id'];
        $plan_id = $_SESSION['plan_id'];
        $query = $this->db->query('CALL spTimeZoneSummary('.$account_id.','.$diff.','.$plan_id.')');
        $result = $query->result();
        _h_openclose($result, $sessionGMT);
        return $query->result(); 
    }

    public function getBrokersTimeADayData($sessionGMT, $baseGMT, $profileGMT) {
        $diff = ($profileGMT - $baseGMT ) + ($sessionGMT - $profileGMT);
        $account_id = $_SESSION['account_id'];
        $plan_id = $_SESSION['plan_id'];
        $query = $this->db->query("CALL spTimeADaySummary (".$account_id.",".$diff.",".$plan_id.")");

        $result = $query->result();

        return $result;
    }

    //TimeZone Sessions
    public function spTimezoneSession($data) {
        $sql = "SELECT * FROM `timezone` WHERE `market` = '".$data['timezone']."' LIMIT 1";

        $query = $this->db->query($sql);
    
        $timezone = $query->result();  

        if (!$timezone) {
            return array('status' => "success", 'data' => []);
        }else{
            
            if($data['baseGMT']==0){
                $open = $timezone[0]->open;
            }elseif(($data['baseGMT']+$timezone[0]->open) <0){
                $open = (24+$data['baseGMT']+$timezone[0]->open);
            }else{
                $open = ($data['baseGMT']+$timezone[0]->open) % 24;
            }

            if($data['baseGMT']==0){
                $close = $timezone[0]->close+$data['baseGMT'];
            }elseif(($data['baseGMT']+$timezone[0]->close) <0){
                $close = (24+$data['baseGMT']+$timezone[0]->close);
            }else{
                $close = ($data['baseGMT']+$timezone[0]->close) % 24;
            }

            if($close<$open){
                $break =1;
            }else{
                $break =0;
            }
            
            //echo "SELECT * FROM closedtrades c WHERE c.Acc_Id=:account_id AND (c.symbol IN (SELECT symbol FROM symbols s)) AND ( (DATE_FORMAT(c.OpenTime, '%k') BETWEEN $open AND $close))";

            if($break){
                $query = $this->db->query("SELECT * FROM closedtrades c WHERE c.Acc_Id=".$data['account_id']." AND (".$_SESSION['plan_id'].">1 OR c.symbol IN (SELECT symbol FROM symbols s)) AND ((DATE_FORMAT(c.OpenTime, '%k') BETWEEN '".$open."' AND 23) OR (DATE_FORMAT(c.OpenTime, '%k') BETWEEN 0 AND '".$close."'))");
            }
                
            else{
                $query = $this->db->query("SELECT * FROM closedtrades c WHERE c.Acc_Id=".$data['account_id']." AND (".$_SESSION['plan_id'].">1 OR c.symbol IN (SELECT symbol FROM symbols s)) AND ( (DATE_FORMAT(c.OpenTime, '%k') BETWEEN '".$open."' AND '".$close."'))");
            }

            $timezone_sessions = $query->result();
            return array('status' => "success", 'data' => $timezone_sessions);
        }
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
