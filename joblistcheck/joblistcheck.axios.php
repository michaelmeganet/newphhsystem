<?php

include_once('../class/dbh.inc.php');
include_once('../class/variables.inc.php');
include_once('../class/joblistwork.inc.php');
include_once('../class/phhdate.inc.php');

$received_data = json_decode(file_get_contents("php://input"));

$data_output = array();
$action = $received_data->action;
switch ($action) {
    case 'getPeriodList':
        $objDate = new DateNow();
        $currentPeriod_int = $objDate->intPeriod();
        $currentPeriod_str = $objDate->strPeriod();

        $EndYYYYmm = 2001;
        $objPeriod = new generatePeriod($currentPeriod_int, $EndYYYYmm);
        $setofPeriod = $objPeriod->generatePeriod3();

        echo json_encode($setofPeriod);
        break;
    case 'parseJobCode':
        $jobcode = $received_data->jobcode;
        $jclength = strlen($jobcode);
        //Jobcode formats :
        // [AA BBB CCDD EEEE FF GGHH] 
        // AA BBBB CCDD EEEE FF GGHH
        // AA BBBB CCDD EEEE FF
        //if char(0) = [, then this is new format.
        if (substr($jobcode, 0, 1) == '[' && $jclength > 32) {
            //new format
            $newjobcode = substr($jobcode, 1, 24);
        } else {
            //old format
            if ($jclength == 24 || $jclength == 19) {
                $newjobcode = substr($jobcode, 0, 19);
            } else {
                $newjobcode = 'error';
            }
        }

        echo json_encode($newjobcode);
        break;
    case 'getCheckJobCode':
        $jobcode = $received_data->jobcode;
        $period = $received_data->period;
        $schtab = 'production_scheduling_' . $period;
        $outtab = 'production_output_' . $period;
        $jlfor = substr($jobcode, 0, 2);
        $co_code = substr($jobcode, 3, 3);
        $yearmonth = '20' . substr($jobcode, 7, 2) . '-' . substr($jobcode, 9, 2);
        $runningno = (int) substr($jobcode, 12, 4);
        $jobno = (int) substr($jobcode, 17, 2);
        try{
        $qrsch = "SELECT * FROM $schtab "
                . "WHERE jlfor = '$jlfor' "
                . "AND quono LIKE '$co_code%' "
                . "AND date_issue LIKE '$yearmonth%' "
                . "AND runningno = $runningno "
                . "AND jobno = $jobno";
        $objSqlSch = new SQL($qrsch);
        $resultsch = $objSqlSch->getResultOneRowArray(); 
        if (!empty($resultsch)){ //found data
            $sid = $resultsch['sid'];
            $qrout = "SELECT DISTINCT jobtype FROM $outtab"
                    . "WHERE sid = $sid"
                    . "AND jobtype != 'jobtake'";
            $objSqlOut = new SQL($qrout);
            $resultout = $objSqlOut->getResultRowArray();
            if(!empty($resultout)){
                $msg = 'Found data, Already done scan : ';
                foreach($resultout as $data_row){
                    foreach ($data_row as $key => $val){
                        if ($key == 'jobtype'){
                            $msg .= " $val";
                        }
                    }
                }
                echo json_encode(array('jobcode'=> $jobcode, 'status'=>"$sid", 'found in period' => $period, 'message' => $msg));
            }else{
                throw new Exception('This job is not yet scanned');
            }
        }else{
            throw new Exception('Cannot find data for this job');
        }
        }catch(Exception $e){
            $msg = $e->getMessage();
            if (!isset($sid)){
                $status = '-NIL-';
                $stat_period = '-NIL-';
            }else{
                $status = 'SID = '.$sid;
                $stat_period = $period;
            }
            echo json_encode(array('jobcode' => $jobcode, 'status' => $status, 'found in period' => $stat_period, 'message' => $msg));
        }
        break;
}
?>