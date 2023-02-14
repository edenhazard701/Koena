<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Summary_model extends CI_Model {

    public function getSymbolsChart($account_id)
    {
        $sql = "SELECT SUM(td.Profit) as Profit, tj.StrategyUsed as StrategyUsed, COUNT(tj.StrategyUsed) as Num, SUM(td.Profit) / COUNT(tj.StrategyUsed) as Strength FROM closedtrades td INNER JOIN tradejournal tj ON td.OrderNumber=tj.Ticket WHERE td.Acc_Id=".$account_id." GROUP BY tj.StrategyUsed ORDER BY Strength DESC";

        $query = $this->db->query($sql);

        return $query->result(); 
    }

    public function getTakenSymbols($account_id, $plan_id)
    {
        $sql = "CALL spTradeJournalSummary (".$account_id.", ".$plan_id.")";

        $query = $this->db->query($sql);

        return $query->result(); 
    }

    public function getJournalTableAll($account_id, $start_date, $end_date){
        $sql = "";
        // print_r($start_date);
        // die(0);
        if(!is_null($start_date)){
            $sql = "SELECT td.*, tj.* FROM closedtrades td INNER JOIN tradejournal tj ON td.OrderNumber=tj.Ticket WHERE td.Acc_Id=".$account_id." ORDER BY tj.updateddate DESC";            
        }else{
            $sql = "SELECT td.*, tj.* FROM closedtrades td INNER JOIN tradejournal tj ON td.OrderNumber=tj.Ticket WHERE td.Acc_Id=".$account_id."";
        }

        $query = $this->db->query($sql);

        return $query->result(); 
    }

    public function getJournalTableAllFilter($account_id, $start_date, $end_date){
        $sql = "";
        if(!is_null($start_date)){
            $sql = "SELECT td.*, tj.* FROM closedtrades td INNER JOIN tradejournal tj ON td.OrderNumber=tj.Ticket WHERE td.Acc_Id=".$account_id." AND DATE(td.CloseTime) BETWEEN '".$start_date."' AND '".$end_date."' GROUP BY td.OrderNumber ORDER BY td.CloseTime DESC";            
        }else{
            $sql = "SELECT td.*, tj.* FROM closedtrades td INNER JOIN tradejournal tj ON td.OrderNumber=tj.Ticket WHERE td.Acc_Id=".$account_id." GROUP BY td.OrderNumber ORDER BY td.CloseTime DESC";
        }

        $query = $this->db->query($sql);

        return $query->result(); 
    }

    public function getJournalGroupedTickets($group_id)
        {
            $sql = "SELECT td.*, tj.* FROM closedtrades td INNER JOIN tradejournal tj ON td.OrderNumber=tj.Ticket WHERE td.Acc_Id=".$_SESSION['account_id']." AND td.journal_group_id=".$group_id."";
            $query = $this->db->query($sql);

            $acct = $query->result();

            $grouped_ticket = array();
            if(!empty($acct)){
                foreach($acct as $singleacct){
                    array_push($grouped_ticket, $singleacct->OrderNumber);
                }
            }
            $grouped_ticket_str = implode(',', $grouped_ticket);
            return $grouped_ticket_str;
        }
    
    public function getJournalTableGroup($account_id){
        $sql = "";
        $sql = "SELECT td.*, tj.* FROM closedtrades td INNER JOIN tradejournal tj ON td.OrderNumber=tj.Ticket WHERE td.Acc_Id=".$account_id." GROUP BY td.journal_group_id ORDER BY td.CloseTime DESC";
        $query = $this->db->query($sql);

        $acct = $query->result(); 
        
        $journal_group_arr = array();
        foreach($acct as $singleacct){
            if(!empty($singleacct->journal_group_id) && $singleacct->journal_group_id > 0){
                array_push($journal_group_arr, $singleacct);
            }
        }

        return $journal_group_arr;
    }

    public function getJournalGroupedItems($aid, $jid, $tick){
        $sql = "SELECT td.*, tj.* FROM closedtrades td INNER JOIN tradejournal tj ON td.OrderNumber=tj.Ticket WHERE td.Acc_Id=".$aid." AND td.journal_group_id=".$jid." AND td.OrderNumber!=".$tick;
        $query = $this->db->query($sql);

        return $query->result(); 
    }

    public function getAccountHistory($account_id, $plan_id) {

        $sql = "SELECT * from closedtrades WHERE Acc_Id =$account_id AND ($plan_id>1 OR symbol IN (SELECT symbol FROM symbols)) ORDER BY UNIX_TIMESTAMP(CloseTime) DESC";

        // if ($_SESSION['plan_id']   == 1 || $_SESSION["account_active"] == 0) {
        //     $query = "SELECT * from closedtrades WHERE Acc_Id =:account_id AND (:plan_id>1 OR symbol IN (SELECT symbol FROM symbols)) ORDER BY UNIX_TIMESTAMP(CloseTime) DESC LIMIT 10 ";
        // }
        $query = $this->db->query($sql);

        return $query->result(); 
    }

    public function _ticketJournal($ticket_csv) {
        $res = [];

        $sql = "SELECT *, `ct`.`Symbol`, tj.Ticket IS NOT NULL as has FROM closedtrades ct ".
            "LEFT JOIN trades_details td ON ct.OrderNumber=td.ticket ".
            "LEFT JOIN tradejournal tj ON ct.OrderNumber=tj.Ticket ".
            "WHERE ct.OrderNumber IN ( '" . implode("','", str_getcsv($ticket_csv)) . "' ) ORDER BY ct.CloseTime DESC";
        $query = $this->db->query($sql);
        $tickets = $query->result();
        
        if ($tickets[0]) {
            
            foreach ($tickets as $row) {
                // print_r($row->OpenTime);
                // die(0);
                $res[] = [
                    'opentime'         => $row->OpenTime,
                    'closetime'         => $row->CloseTime,
                    'symbol'            => $row->Symbol,
                    'ticket'            => $row->OrderNumber,
                    'type'              => $row->OrderType,
                    'lots'              => $row->OrderSize,
                    'drawdown'          => $row->drawdowndollar,
                    'floatingprofit'    => $row->floatingprofitdollar,
                    'outcome'           => $row->Profit,

                    'ReasonForOutcome'  => !empty($row->ReasonForOutcome) ? $row->ReasonForOutcome : '',
                    'HowICanImprove'    => !empty($row->HowICanImprove) ? $row->HowICanImprove : '',
                    'StrategyUsed'      => !empty($row->StrategyUsed) ? $row->StrategyUsed : '',
                    'ReasonForEntry'    => !empty($row->ReasonForEntry) ? $row->ReasonForEntry : '',
                    'ReasonForExit'     => !empty($row->ReasonForExit) ? $row->ReasonForExit : '',
                    'GetScreenShot'     => !empty($row->GetScreenShot) ? $row->GetScreenShot : '',
                    'TimeFrame1'        => !empty($row->TimeFrame1) ? $row->TimeFrame1 : '',
                    'TimeFrame2'        => !empty($row->TimeFrame2) ? $row->TimeFrame2 : '',
                    'TimeFrame3'        => !empty($row->TimeFrame3) ? $row->TimeFrame3 : '',
                    'TimeFrame4'        => !empty($row->TimeFrame4) ? $row->TimeFrame4 : '',
                    'TimeFrame5'        => !empty($row->TimeFrame5) ? $row->TimeFrame5 : '',
                    'SSTimeFrame1'      => !empty($row->SSTimeFrame1) ? $row->SSTimeFrame1 : '',
                    'SSTimeFrame2'      => !empty($row->SSTimeFrame2) ? $row->SSTimeFrame2 : '',
                    'SSTimeFrame3'      => !empty($row->SSTimeFrame3) ? $row->SSTimeFrame3 : '',
                    'SSTimeFrame4'      => !empty($row->SSTimeFrame4) ? $row->SSTimeFrame4 : '',
                    'SSTimeFrame5'      => !empty($row->SSTimeFrame5) ? $row->SSTimeFrame5 : '',

                    // not new
                    'has'               => $row->has,
                    ];
            }
        }
        return $res;
    }

    public function getAccountDetailsModal($ticket_id) {
        $acct = $this->_ticketJournal($ticket_id);
        return $acct;
    }

    public function getAccountSummaryJournal($account_id, $start_date, $end_date, $symbols) {
        $sql = '';
        if(isset($start_date) && !empty($start_date)){
            $sql = "SELECT * FROM closedtrades ct WHERE ct.Acc_Id=".$account_id." ORDER BY ct.CloseTime DESC";
        }elseif (isset($symbols) && $symbols == "") {
            $sql = "SELECT * FROM closedtrades ct WHERE ct.Acc_Id=".$account_id." AND (".$_SESSION['plan_id'].">1 OR ct.symbol IN (SELECT symbol FROM symbols)) ORDER BY ct.CloseTime DESC";
            die(0);
        } else {
            $sql = "SELECT * FROM closedtrades ct WHERE ct.Acc_Id=".$account_id." AND FIND_IN_SET(сt.Symbol,".$symbols.") ORDER BY ct.CloseTime DESC";
            die(0);
        }

        $query = $this->db->query($sql);
        $acct = $query->result();
        
        if (!$acct) {
            return [];
         } else {
            $acct = $this->_ticketJournal(implode(',', array_column($acct, 'OrderNumber')));
        }

        return $acct;
    }

    public function getAccountSummaryJournalFilter($account_id, $start_date, $end_date, $symbols) {
        if(isset($start_date) && !empty($start_date)){
            $sql = "SELECT * FROM closedtrades ct WHERE ct.Acc_Id=".$account_id."  AND DATE(ct.CloseTime) BETWEEN ".$start_date." AND ".$end_date." ORDER BY ct.CloseTime DESC";
            $query = $this->db->query($sql);
            $acct = $query->result(); 
            
        }elseif (isset($symbols) && $symbols == "") {
            $sql = "SELECT * FROM closedtrades ct WHERE ct.Acc_Id=".$account_id." AND (".$_SESSION['plan_id'].">1 OR ct.symbol IN (SELECT symbol FROM symbols)) ORDER BY ct.CloseTime DESC";
            $query = $this->db->query($sql);
            $acct = $query->result();
        } else {
            $sql = "SELECT * FROM closedtrades ct WHERE ct.Acc_Id=".$account_id." AND FIND_IN_SET(сt.Symbol,".$symbols.") ORDER BY ct.CloseTime DESC";
            $query = $this->db->query($sql);
            $acct = $query->result();
        }

        if (!$acct) {
            return array('status' => "error", "message" => "No data found!", []);
         } else {
            $acct = $this->_ticketJournal(implode(',', array_column($acct, 'OrderNumber')));
        }

        return array('status' => "success", "message" => "Data fetched!", $acct);
    }

    public function getJournalSummary($account_id, $start_date, $end_date, $symbols)
    {
        $query = '';

        if(isset($start_date) && !empty($start_date)){
            $query = $this->db->query("SELECT * FROM closedtrades ct WHERE ct.Acc_Id=$account_id  AND DATE(ct.CloseTime) BETWEEN '".$start_date."' AND '".$end_date."' ORDER BY ct.CloseTime DESC");
        }elseif (isset($symbols) && $symbols == "") {
            
            $query = $this->db->query("SELECT * FROM closedtrades ct WHERE ct.Acc_Id=".$account_id." AND (".$_SESSION['plan_id'].">1 OR ct.symbol IN (SELECT symbol FROM symbols)) ORDER BY ct.CloseTime DESC");
        } else {

            $query = $this->db->query("SELECT * FROM closedtrades ct WHERE ct.Acc_Id=".$account_id." AND FIND_IN_SET(сt.Symbol,".$symbols.") ORDER BY ct.CloseTime DESC");
        }
        $acct = $query->result();
        if (!$acct) {
            return array('status' => "error", "message" => "No data found!");
         } else {
            $acct = $this->_ticketJournal(implode(',', array_column($acct, 'OrderNumber')));
        }

        return $acct;
    }

    public function getJournalMainDetailsModal($account_id, $ticket_id) {
        $acct = $this->_JournalMainDetails($ticket_id);
        return $acct;
    }

    public function _JournalMainDetails($ticket_csv) {
            $res = [];
            $sql = "SELECT *, `ct`.`Symbol`, tj.Ticket IS NOT NULL as has FROM closedtrades ct
                LEFT JOIN trades_details td ON ct.OrderNumber=td.ticket
                LEFT JOIN tradejournal tj ON ct.OrderNumber=tj.Ticket
                WHERE ct.OrderNumber IN ( '" . implode("','", str_getcsv($ticket_csv)) . "' )";
            $query = $this->db->query($sql); 
            
            $tick_id = $query->result();

            if ($tick_id) {
                foreach ($tick_id as $row) {
                
                    
                    $OpenTime = str_replace(".", "-", $row->OpenTime);
                    $OpenTime = strtotime($OpenTime);
                    $OpenTime = date('Y-m-d H:i:s',$OpenTime);
                    
                    $CloseTime = str_replace(".", "-", $row->CloseTime);
                    $CloseTime = strtotime($CloseTime);
                    $CloseTime = date('Y-m-d H:i:s',$CloseTime);

                    $timegreatestDD = str_replace(".", "-", $row->timegreatestDD);
                    $timegreatestDD = strtotime($timegreatestDD);
                    $timegreatestDD = date('Y-m-d H:i:s',$timegreatestDD);

                    $floatingprofittime = str_replace(".", "-", $row->floatingprofittime);
                    $floatingprofittime = strtotime($floatingprofittime);
                    $floatingprofittime = date('Y-m-d H:i:s',$floatingprofittime);

                    
                    
                    $OpenTime = new DateTime($OpenTime); 
                    
                    $trade_diff = $OpenTime->diff(new DateTime($CloseTime)); 
                    $dd_diff = $OpenTime->diff(new DateTime($timegreatestDD)); 
                    $fl_diff = $OpenTime->diff(new DateTime($floatingprofittime)); 

                   
                    $res[] = [
                        'opentime'          => $row->OpenTime,
                        'closetime'         => $row->CloseTime,
                        'symbol'            => $row->Symbol,
                        'ticket'            => $row->OrderNumber,
                        'type'              => $row->OrderType,
                        'lots'              => $row->OrderSize,
                        'drawdown'          => round($row->drawdowndollar, 2),
                        'floatingprofit'    => round($row->floatingprofitdollar, 2),
                        'outcome'           => round($row->Profit, 2),
                        'trade_diff'           => ($trade_diff->d>0)? ($trade_diff->d*24)." hr ". $trade_diff->i." min" :$trade_diff->h." hr ". $trade_diff->i." min",
                        'drawdown_diff'           => $dd_diff->h." hr ". $dd_diff->i." min",
                        'floating_diff'           => $fl_diff->h." hr ". $fl_diff->i." min",
    
                        'ReasonForOutcome'  => !empty($row->ReasonForOutcome) ? $row->ReasonForOutcome : '',
                        'HowICanImprove'    => !empty($row->HowICanImprove) ? $row->HowICanImprove : '',
                        'StrategyUsed'      => !empty($row->StrategyUsed) ? $row->StrategyUsed : '',
                        'ReasonForEntry'    => !empty($row->ReasonForEntry) ? $row->ReasonForEntry : '',
                        'ReasonForExit'     => !empty($row->ReasonForExit) ? $row->ReasonForExit : '',
                        'GetScreenShot'     => !empty($row->GetScreenShot) ? $row->GetScreenShot : '',
                        'TimeFrame1'        => !empty($row->TimeFrame1) ? $row->TimeFrame1 : '',
                        'TimeFrame2'        => !empty($row->TimeFrame2) ? $row->TimeFrame2 : '',
                        'TimeFrame3'        => !empty($row->TimeFrame3) ? $row->TimeFrame3 : '',
                        'TimeFrame4'        => !empty($row->TimeFrame4) ? $row->TimeFrame4 : '',
                        'TimeFrame5'        => !empty($row->TimeFrame5) ? $row->TimeFrame5 : '',
                        'SSTimeFrame1'      => !empty($row->SSTimeFrame1) ? $row->SSTimeFrame1 : '',
                        'SSTimeFrame2'      => !empty($row->SSTimeFrame2) ? $row->SSTimeFrame2 : '',
                        'SSTimeFrame3'      => !empty($row->SSTimeFrame3) ? $row->SSTimeFrame3 : '',
                        'SSTimeFrame4'      => !empty($row->SSTimeFrame4) ? $row->SSTimeFrame4 : '',
                        'SSTimeFrame5'      => !empty($row->SSTimeFrame5) ? $row->SSTimeFrame5 : '',
    
                        // not new
                        'has'               => $row->has,
                        ];
                }
            }
            return $res;
        }

    public function deleteSSTimeframe($timeframe, $ticket_id) {       
        if (isset($timeframe)) {
            
            // Insert image content into database 
            $query = $this->db->query("UPDATE closedtrades SET `SS".$timeframe."`='' WHERE `OrderNumber` IN ('".implode("','", str_getcsv($ticket_id))."')");

            $num = $this->db->affected_rows();
        } else {
            // $this->exitScript('error', 'An error while deleting file.');
            return array('status' => "error", "message" => "An error while deleting file.");
        }

        return array('status' => "success", "message" => "".$timeframe." for ticket(s) <big>[".$ticket_id."]</big> Changed successfully!"   );
    }

    public function deleteSSTimeframe1($timeframe, $ticket_id) {       
        if (isset($timeframe)) {
            
            // Insert image content into database 
            $query = $this->db->query("UPDATE closedtrades SET `SS".$timeframe."`='' WHERE `OrderNumber` IN ('".implode("','", str_getcsv($ticket_id))."')");

            $num = $this->db->affected_rows();
        } else {
            // $this->exitScript('error', 'An error while deleting file.');
            return array('status' => "error", "message" => "An error while deleting file.");
        }

        return array('status' => "success", "message" => "".$timeframe." for ticket(s) <big>[".$ticket_id."]</big> Changed successfully!"   );
    }

    // Reload Timeframe Image
    public function SSTimeFrameReload($field, $ticket_id) {    
        $field1 = substr($field, 0, 10);   
        $query = $this->db->query("SELECT SS".$field1." FROM closedtrades WHERE OrderNumber = ".$ticket_id."");

        $acct = $query->result();  
        return $acct;
    }

    public function getAccountReason($account_id) {
        $query = $this->db->query("SELECT * from user_reason WHERE account_id =".$account_id."");

        $acct = $query->result();

        return $acct;
    }

    // Change Timeframe Image
    public function changeSSTimeframe($data) {
        $timeframe = $data['timeframe'];
        $timeframe = substr($timeframe, 0, 10);
        if (isset($_FILES["image"])) {
            $thumb = resizer($_FILES['image']['tmp_name'], 1920, 1080, true);
            ob_start();
            imagejpeg($thumb);
            $image = ob_get_clean();
            $imgContent = addslashes($imageData = "data:image/jpg;charset=utf8;base64,".base64_encode($image)); 
            
            // Insert image content into database 
            $this->db->query("UPDATE closedtrades SET `SS".$timeframe."`='$imgContent' WHERE `OrderNumber` IN ('".implode("','", str_getcsv($data['ticket_id']))."')");
        } else {
            return array('status' => 'error', 'message' => 'ERROR');
        }
        // $this->exitScript('success', "{$data['timeframe']} for ticket(s) <big>[{$data['ticket_id']}]</big> Changed successfully!");
        return array('status' => 'success', 'message' => 'Changed successfully!');
    }

    public function journalDetailsModalInsertUpdate($data) {
        if ($data['tickets']) {
            if($data['strategyUsed']){


                if($data['strategyUsed']){
                    $this->_isertJournalStrategyUsedUserReason($data['strategyUsed'], $data['account_id']);
                }

                if($data['reasonForOutcome']){
                    $this->_isertJournalreasonForOutcomeUserReason($data['reasonForOutcome'], $data['account_id']);
                }

                if($data['reasonForEntry']){
                    $this->_isertJournalreasonForEntryUserReason($data['reasonForEntry'], $data['account_id']);
                }

                if(count(str_getcsv($data['tickets'])) >1){
                    $this->_isertJournalGroup($data['tickets'], $data['account_id']);
                }
                
                foreach(str_getcsv($data['tickets']) as $ticket_id)  {
                    
                    if ($data['has']!='1') {
                        $this->_isertJournal($ticket_id, $data['account_id']);
                    }
                    $query = $this->db->query("UPDATE tradejournal SET Email='".$_SESSION['email']."', ReasonForOutcome='".$data['reasonForOutcome']."', HowICanImprove='".$data['howICanImprove']."', StrategyUsed='".$data['strategyUsed']."', ReasonForEntry='".$data['reasonForEntry']."', ReasonForExit='', updateddate='' WHERE Ticket = ".$ticket_id." AND Acc_Id = ".$data['account_id']." ");
                    
                    if (!$query < 1) return array('status' => 'error', 'message' => 'An error occured while UPDATE  TimeFrames. Please Try again later!');

                    $query = $this->db->query("UPDATE closedtrades SET TimeFrame1=".$data['TimeFrame1'].", TimeFrame2=".$data['TimeFrame2'].", TimeFrame3=".$data['TimeFrame3'].", changes='TRUE' WHERE OrderNumber=".$data['ticket_id']."");
                    $result = $query->result();
                    if (!$result) return array('status' => 'error', 'message' => 'An error occured while UPDATE  TimeFrames. Please Try again later!');
                }
            }else{
                return array('status' => 'error', 'message' => 'Please select Strategy Used.');
            }
        } else {
            return array('status' =>'error', 'message' => 'Not tickets in data! Try again later!');
        }
        return array('status' => 'success', 'messsage' => 'Save successfully!');
    }

    // Insert Empty Journal
    public function _isertJournal($ticket_id, $account_id)  {
        try {
            $this->db->query("INSERT INTO tradejournal (Ticket, Acc_Id) VALUES ('".$ticket_id."', '".$account_id."')");
        } catch (Exception $e) {
            // if (!$res) $this->exitScript('error', 'An error while INSERT Journal row. Please Try again later!');
        }
    }

    public function _isertJournalStrategyUsedUserReason($StrategyUsed, $account_id)  {
        try {
            $date = date('Y-m-d h:i:s');
            $query = $this->db->query("SELECT * FROM `user_reason` WHERE `reason` = '".$StrategyUsed."' AND `account_id` =".$account_id." ORDER BY `id` DESC");
            $res = $query->result();
            if (!$res) {
                $query = $this->db->query("INSERT INTO user_reason (reason, valuess, user_id, account_id) VALUES ('StrategyUsed', '".$StrategyUsed."', '".$_SESSION['user_id']."', '".$account_id."')");
            }
            
        } catch (Exception $e) {
            // if (!$res) $this->exitScript('error', 'An error while INSERT Journal row. Please Try again later!');
        }

    }

    public function _isertJournalreasonForOutcomeUserReason($StrategyUsed, $account_id)  {
        try {
            $date = date('Y-m-d h:i:s');
            $query = $this->db->query("SELECT * FROM `user_reason` WHERE `reason` = 'ReasonForOutcome' AND `valuess` ='".$StrategyUsed."' AND `account_id` =".$account_id."  ORDER BY `id` DESC");
            $res = $query->result();
            
            if (!$res) {
                $query = $this->db->query("INSERT INTO user_reason (reason, valuess, user_id, account_id) VALUES ('ReasonForOutcome', '".$StrategyUsed."', '".$_SESSION['user_id']."', '".$account_id."')");
            }
            
        } catch (Exception $e) {
        // if (!$res) $this->exitScript('error', 'An error while INSERT Journal row. Please Try again later!');
        }

    }

    public function _isertJournalreasonForEntryUserReason($StrategyUsed, $account_id)  {
        try {
            $date = date('Y-m-d h:i:s');
            $query = $this->db->query("SELECT * FROM `user_reason` WHERE `reason` = 'ReasonForEntry' AND `valuess` ='".$StrategyUsed."' AND `account_id` =".$account_id."  ORDER BY `id` DESC");
            $res = $query->result();
            
            if (!$res) {
                $query = $this->db->query("INSERT INTO user_reason (reason, valuess, user_id, account_id) VALUES ('ReasonForEntry', '".$StrategyUsed."', '".$_SESSION['user_id']."', '".$account_id."')");
            }
            
        } catch (Exception $e) {
        // if (!$res) $this->exitScript('error', 'An error while INSERT Journal row. Please Try again later!');
        }

    }

    // Get Last Insert Id Method
    public function getLastInsertId()
    {
        return $this->db->lastInsertId();
    }

    public function _isertJournalGroup($ticket_id, $account_id)  {

        try {
            $date = date('Y-m-d h:i:s');
            $sql = "INSERT INTO tradejournal_group (ticket_ids, account_id, created_date) VALUES ('".$ticket_id."', '".$account_id."', '".$date."')";
            $query = $this->db->query($sql);
 
            // $res = $query->result();
            $last_insertedid = $this->db->insert_id();
            
            foreach(str_getcsv($ticket_id) as $ticket)  {
                $query = $this->db->query('UPDATE closedtrades SET journal_group_id=".$last_insertedid."  WHERE OrderNumber = ".$ticket_id." AND Acc_Id = ".$account_id."');
            }

            foreach(str_getcsv($ticket_id) as $ticket)  {

                $query = $this->db->query("SELECT * FROM `tradejournal` WHERE `Acc_Id` = ".$account_id." AND `Ticket` ='".$ticket_id."'  ");

                $res = $query->result();
                //echo "fdsafds".$res; exit();
                if (!$res) {
                    $date = date('Y-m-d h:i:s');
                    $query = $this->db->query("INSERT INTO tradejournal (Acc_Id, Ticket, updateddate) VALUES ('".$account_id."', '".$ticket."', '".$date."')");
                }
            }
        } catch (Exception $e) {
        // if (!$res) $this->exitScript('error', 'An error while INSERT Journal row. Please Try again later!');
        }

    }

    public function addNewReason($data) {

        $query = $this->db->query('INSERT INTO user_reason (reason, valuess, user_id, account_id) VALUES ("'.$data['reasonType'].'", "'.$data['reasonValue'].'", '.$data['user_id'].', '.$_SESSION['account_id'].')');

        $num = $this->db->affected_rows($query);

        if ($num < 1) return array('status' => 'error', 'message' => 'An error occured while creating this user. Please Try again later!');

        $data = array(
            'reasonType'  => $data['reasonType'],
            'reasonValue'  => $data['reasonValue'],
        );

        return $data;
    }

    public function accountDetailsModalInsertUpdate($data) {

        if ($data['tickets']) {
            if($data['strategyUsed']){
                if(count(str_getcsv($data['tickets'])) >1){
                    $this->_isertJournalGroup($data['tickets'], $data['account_id']);
                }
                
                foreach(str_getcsv($data['tickets']) as $ticket_id)  {
                    
                    if ($data['has']!='1') {
                        $this->_isertJournal($ticket_id, $data['account_id']);
                        }
                    $sql = "UPDATE tradejournal SET Email='".$data['user_email']."', ReasonForOutcome='".$data['reasonForOutcome']."',HowICanImprove=";
                    $sql .= '"'.$data['howICanImprove'].'"';
                    $sql .= ", StrategyUsed='".$data['strategyUsed']."', ReasonForEntry='".$data['reasonForEntry']."' WHERE Ticket = '".$data['tickets']."' AND Acc_Id = '".$data['account_id']."'";
                    $query = $this->db->query($sql);

                    $num = $this->db->affected_rows($query);

                    if ($num < 1) 
                        return array('status' => 'error', 'message' => 'An error occured while UPDATE  TimeFrames. Please Try again later!');
                }
            }else{
                return array('status' => 'error', 'message' => 'Please select the Strategy Used');
            }
        } else {
            return array('status' => 'error', 'message' => 'Not tickets in data! Try again later!');
        }
        return array('status' => 'success', 'message' => 'Save successfully!');
    }
}