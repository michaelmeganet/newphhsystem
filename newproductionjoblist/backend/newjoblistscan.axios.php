<?php

include_once('../includes/dbh.inc.php');
include_once('../includes/variables.inc.php');
include_once('../includes/joblistwork.inc.php');
include_once('../includes/phhdate.inc.php');

$received_data = json_decode(file_get_contents("php://input"));

$data_output = array();
$action = $received_data->action;

function get_StaffByID($staffid) {
    $qr = "SELECT * FROM admin_staff WHERE staffid = '$staffid'";
    $objSQL = new SQL($qr);
    $result = $objSQL->getResultOneRowArray();
    if (!empty($result)) {
        return $result;
    } else {
        return 'empty';
    }
}

function get_MachineByID($machineid) {
    $qr = "SELECT * FROM machine WHERE machineid = '$machineid'";
    $objSQL = new SQL($qr);
    $result = $objSQL->getResultOneRowArray();
    if (!empty($result)) {
        return $result;
    } else {
        return 'empty';
    }
}

function parseJobcode($jobcode) {
    $jclength = strlen($jobcode);
    #echo "jc_length = $jc_length.\n";
    #echo "strpos [ = " . strpos($jobcode, '[') . '\n';
    if (strpos($jobcode, '[') === 0) {
        //this is new jobcode
        #echo "new jobcode\n";
        $endpos = strpos($jobcode, ']');
        $cleanJobCode = substr($jobcode, 1, $endpos - 1);
    } else {
        #echo "old jobcode\n";
        //this is old jobcode
        if ($jclength <= 28) {
            # echo "ok\n";
            $cleanJobCode = $jobcode;
        } else {
            # echo "fail\n";
            return 'fail';
        }
    }
    #echo "cleanjobcode = $cleanJobCode<br>";
    if (strlen($cleanJobCode) == 28 || strlen($cleanJobCode) == 24) {
        $len = strlen($cleanJobCode) - 5;
        $cleanJobCode = substr($cleanJobCode, 0, $len);
        #echo "cleanjobcode = $cleanJobCode<br>" . strlen($cleanJobCode);
    }
    if (strlen($cleanJobCode) == 19 || strlen($cleanJobCode) == 23) {
        return $cleanJobCode;
    } else {
        return 'fail';
    }
}

switch ($action) {
    case 'getStaffName':
        $staffid = $received_data->staffid;
        $arr_staff = get_StaffByID($staffid);
        if ($arr_staff != 'empty') {
            $resp = array('status' => 'ok', 'msg' => '<font style="color:yellow">' . $arr_staff['name'] . '</font>');
        } else {
            $resp = array('status' => 'error', 'msg' => '<font style="color:red">Cannot find staffname for staffid = ' . $staffid . '</font>');
        }
        #print_r($resp);
        echo json_encode($resp);

        break;
    case 'parseJobCode':
        $jobcode = $received_data->jobcode;
        $parseJobCode = parseJobcode($jobcode);
        if ($parseJobCode != 'fail') {
            $resp = array('status' => 'ok', 'msg' => $parseJobCode);
        } else {
            $resp = array('status' => 'error', 'msg' => 'Cannot parse Jobcode, Please Check the format');
        }
        echo json_encode($resp);
        break;
    case 'getJobWorkList':
        $jobcode = parseJobcode($received_data->jobcode);
        #echo $received_data->jobcode.'\n';
        $objPeriod = new Period();
        $this_period = $objPeriod->getcurrentPeriod();
        $prev_period = $objPeriod->getlastPeriod();
        try {
            $schDetail = get_SchedulingDetails($this_period, $jobcode);
            if ($schDetail == 'empty') {
                $schDetail = get_SchedulingDetails($prev_period, $jobcode);
                if ($schDetail == 'empty') {
                    throw new Exception('Cannot Find Data for Jobcode = ' . $jobcode . " on period = $this_period and $prev_period", 101);
                }
            }
            $sid = $schDetail['sid'];
            $pmid = $schDetail['process'];
            $schDetail['processname'] = get_processName($pmid);
            $outDetail = get_OutputDetails($this_period, $sid);
            if ($outDetail == 'empty') {
                $outDetail = get_OutputDetails($prev_period, $sid);
            }

            $cuttingtype = $schDetail['cuttingtype'];
            $totalquantity = $schDetail['quantity'];
            $processcode = $schDetail['process'];
            $objJW = new JOB_WORK_DETAIL($jobcode, $cuttingtype, $processcode, $totalquantity, $outDetail);
            $jobworkDetail = $objJW->get_arr_jobWork();
            $jobworkStatus = $objJW->get_ex_jobwork();
            unset($jobworkStatus['jlwsid']);
            unset($jobworkStatus['jobcode']);
            $resp = array('status' => 'ok', 'schDetail' => $schDetail, 'outDetail' => $outDetail, 'jobworkStatus' => $jobworkStatus, 'jobworkDetail' => $jobworkDetail);
        } catch (Exception $ex) {
            $resp = array('status' => 'error', 'msg' => $ex->getMessage());
        }
        echo json_encode($resp);
        break;
    case 'getProcessName':
        $pmid = $received_data->pmid;
        $processname = get_processName($pmid);
        if ($processname != 'empty') {
            echo json_encode($processname);
        } else {
            echo json_encode('Cannot Find Process Name');
        }
        break;
    case 'getMachineName':
        $machineid = $received_data->machineid;
        $proc = $received_data->proc;
        $ttlmc = substr(strtolower($machineid), 0, 3);
        $prRun = true;
        #echo $ttlmc;
        if (strlen($machineid) != 5) {
            echo json_encode("MachineID format is not accepted, Contact Administrator");
        } else {
            switch ($proc) {
                case 'cncmachining':
                    if ($ttlmc != 'cnc') {
                        $prRun = false;
                    }
                    break;
                case 'manual':
                    if ($ttlmc != 'mct') {
                        $prRun = false;
                    }
                    break;
                case 'bandsaw':
                    if ($ttlmc != 'bsc') {
                        $prRun = false;
                    }
                    break;
                case 'milling':
                case 'millingwidth':
                case 'millinglength':
                    if ($ttlmc != 'mmg') {
                        $prRun = false;
                    }
                    break;
                case 'roughgrinding':
                    if ($ttlmc != 'rgg') {
                        $prRun = false;
                    }
                    break;
                case 'precisiongrinding':
                    if ($ttlmc != 'sgg') {
                        $prRun = false;
                    }
                    break;
                default:
                    break;
            }
            if (!$prRun) {
                echo json_encode('Cannot use this machine for ' . $proc . ' process.');
            } else {
                $machinename = get_MachineByID($machineid);
                if ($machinename != 'empty') {
                    echo json_encode($machinename['name']);
                } else {
                    echo json_encode("Cannot find Machine Name for MachineID = $machineid");
                }
            }
        }
        break;
    case 'getJobUpdate':
        $proc = $received_data->proc;               //this is what process current;
        $proc_status = $received_data->proc_status;    //this is what process start/end;
        $jobcode = $received_data->jobcode;         //jobcode
        $staffid = $received_data->staffid;         //staffid
        $jobdoneqty = ($received_data->quantity) ? $received_data->quantity : null;
        $machineid = ($received_data->machineid) ? $received_data->machineid : null;     //machineid
        if ($machineid != null) {
            $machineDtl = get_MachineByID($machineid);
            $mcid = $machineDtl['mcid'];
        }
        //parse jobcode
        try {
            $parseJobCode = parseJobcode($jobcode);
            if ($parseJobCode == 'fail') {
                throw new Exception("<span style='color:red'>Cannot parse Jobcode -> <font style='color:yellow'>$jobcode</font></span>", 101);
            }

            $branch = substr($parseJobCode, 0, 2);
            $company_code = substr($parseJobCode, 3, 3);
            $issue_period = substr($parseJobCode, 7, 4);
            $runningno = (int) substr($parseJobCode, 12, 4);
            $itemno = (int) substr($parseJobCode, 17, 2);
            #echo "parseJobCode length = " . strlen($parseJobCode) . "\n";
            if (strlen($parseJobCode) === 19) {
                $additional = NULL;
                #$end_period = substr($parseJobCode, 20, 4); //completion date
            } else if (strlen($parseJobCode) == 23) {
                $additional = substr($parseJobCode, 20, 3); //item number
                #$end_period = substr($parseJobCode, 24, 4); //completion date  
            }
            //check if there's addition change
            if ($additional == "(R)") {
                $addi = "additional = 'Replacement'";
            } else if ($additional == "(A)") {
                $addi = "additional = 'Amendment'";
            } else if ($additional == NULL || $additional == "") {
                $addi = "(additional = '' OR additional IS NULL)";
            } else {
                $addi = "ERROR";
            }
            //setup current datetime
            date_default_timezone_set('Asia/Kuala_Lumpur'); //set time to malaysia
            $currDateTime = date('Y-m-d H:i:s');
            //initialize tables
            $objPeriod = new Period();
            $this_period = $objPeriod->getcurrentPeriod();
            $last_period = $objPeriod->getlastPeriod();
            $protab = 'production_scheduling_' . $this_period;
            $pottab = 'production_output_' . $this_period;

            //check if data exists in scheduling
            $sqlpro = "SELECT * FROM $protab WHERE quono LIKE '$company_code%' AND runningno = $runningno AND noposition = $itemno AND (operation = 1 OR operation = 3) AND $addi";
            #echo "sqlpro = $sqlpro\n";
            $objSQLpro = new SQL($sqlpro);
            $resultpro = $objSQLpro->getResultOneRowArray();
            if (empty($resultpro)) {  //if there's no data in scheduling
                $protab = 'production_scheduling_' . $last_period;
                $pottab = 'production_output_' . $last_period;
                $sqlpro = "SELECT * FROM $protab WHERE quono LIKE '$company_code%' AND runningno = $runningno AND noposition = $itemno AND (operation = 1 OR operation = 3) AND $addi";
                $objSQLpro = new SQL($sqlpro);
                $resultpro = $objSQLpro->getResultOneRowArray();
                if (empty($resultpro)) {
                    throw new Exception("<span style='color:red'>Found Error while processing Job No = <b><font style='color:yellow'>$parseJobCode</font></b>. "
                    . "\nAre you scanning an old Job?"
                    . "\nIf you believe this is an error, please contact Administrator.</span>", 101);
                }
            }
            $totalqty = $resultpro['quantity'];
            $sid = $resultpro['sid'];
            #echo "sid = $sid";
            //check if this process needed or not
            $objJW = new JOB_WORK_DETAIL($parseJobCode, $resultpro['cuttingtype'], $resultpro['process'], $totalqty);
            $JWDetails = $objJW->get_ex_jobwork();
            if (isset($JWDetails[$proc])) { //check if data exists or not
                if ($JWDetails[$proc] != 'true') { //if data exists, but current process is not needed, reject this jobno
                    throw new Exception("<span style='color:red'>Cannot start this Job No = <b><font style='color:yellow'>$parseJobCode</font></b>. "
                    . "\nThis Job No doesn't have this $proc process listed.</span>");
                }
            } else { // if data doesn't exists, reject this jobno
                throw new Exception("<span style='color:red'>Cannot start this Job No = <b><font style='color:yellow'>$parseJobCode</font></b>. "
                . "\nThis Job No doesn't have this $proc process listed.</span>");
            }

            switch ($proc_status) {
                case 'start': //start process, insert to database
                    #echo "in start process : \n";
                    $sqlnumrowpot = "SELECT COUNT(*)  FROM $pottab WHERE sid = $sid AND jobtype = '$proc' AND (date_end IS NULL OR date_end LIKE '') ORDER BY poid DESC LIMIT 0, 1";
                    $objSQLnumpot = new SQL($sqlnumrowpot);
                    $numrowspot = $objSQLnumpot->getRowCount();
                    #echo $numrowspot . "<br>\n";
                    if ($numrowspot != 0) {//if already started / ended
                        $sqlpot = "SELECT * FROM $pottab WHERE sid = $sid AND jobtype = '$proc' AND (date_end IS NULL OR date_end LIKE '') ORDER BY poid DESC LIMIT 0, 1";
                        #echo $sqlpot . "\n";
                        $objSQLpot = new SQL($sqlpot);
                        $rowpot = $objSQLpot->getResultOneRowArray();
                        $date_key = "date_$proc_status";
                        $record_date = $rowpot[$date_key];
                        throw new Exception("<font style='color:red'>Job <b><font style='color:yellow'>$parseJobCode</font></b> has already been started at <font style='color:yellow'>$record_date.</font></font>", 102);
                    } else {//if has not started/ended
                        $sqlpotr = "SELECT * FROM $pottab WHERE sid = $sid AND jobtype = '$proc' AND (date_end IS NOT NULL OR NOT date_end LIKE '') ORDER BY poid DESC LIMIT 0, 1";
                        $objSQLpotr = new SQL($sqlpotr);
                        $potrResult = $objSQLpotr->getResultOneRowArray();
                        #print_r($potrResult);
                        if (!empty($potrResult)) { //if there's already data previously
                            #echo "not empty<br>";
                            $remainingqty = $potrResult['remainingquantity'];
                            #echo $rem_qty.'<br><br>';
                            if ($remainingqty != 0) { //if previous ended process is not null
                                #echo "reminingqty is not null, \n";
                                #echo "still have qty to be done<br>";
                                $remainingqty = $remainingqty - $jobdoneqty;
                            } else {  //if previous ended process is null
                                #echo "remainingqty is null\n";
                                #echo "quantity done<br>";
                                $remainingqty = $totalqty - $jobdoneqty;
                                throw new Exception("<font style='color:red'>Job <b><font style='color:yellow'>$parseJobCode</font></b> has completed process data.<br>"
                                . "This Cannot be started anymore.<br>"
                                . "If this is an error, please contact administrator.", 105);
                            }
                        } else { //if there's no other ended process;
                            #echo "There's no preceeding data!\n";
                            $remainingqty = $totalqty - $jobdoneqty;
                        }
                        if ($remainingqty < 0) {
                            $qtyneed = $remainingqty + $jobdoneqty;
                            #echo 'jobdoneqty = '. $jobdoneqty;
                            #echo 'remainingqty = '. $remainingqty;
                            throw new Exception("<font style='color:red'>Job <b><font style='color:yellow'>$parseJobCode</font></b> Cannot be started.<br>"
                            . "The quantity <b><font style='color:yellow'>($jobdoneqty)</font></b> is more than the total quantity needed <b><font style='color:yellow'>({$qtyneed})</font></b>.<br>"
                            . "If this is an error, please contact administrator.", 105);
                        }
                        //END CHECK

                        $sqlup = "INSERT INTO $pottab (poid, sid, jobtype, date_start, start_by, machine_id,totalquantity,quantity,remainingquantity) VALUES (NULL, $sid, '$proc', '$currDateTime', '$staffid', '$mcid', $totalqty,$jobdoneqty,$remainingqty)";
                        #echo "sqlup = $sqlup\n";
                        $objSQLup = new SQL($sqlup);
                        $insResult = $objSQLup->InsertData();
                        if ($insResult == 'insert ok!') { //if insert succesful
                            $sqlGetPoid = "SELECT poid FROM $pottab ORDER BY poid DESC";
                            $objSQLgetPoid = new SQL($sqlGetPoid);
                            $results = $objSQLgetPoid->getResultOneRowArray();
                            $poid = $results['poid'];
                            $successMsg = "Job No <strong><font color=\"#FFFF00\">$parseJobCode</font></strong> has been started.";
                            #. "Click <a href='#' onclick='undoJobUpdate($poid,$end_period,\"$parseJobCode\")'>here</a> to undo.";
                            $result_array = array('status' => 'success', 'code' => 001, 'msg' => "$successMsg");
                            echo json_encode($result_array);
                        } else {//if insert failed
                            throw new Exception("<font style='color:red'>Job <b><font style='color:yellow'>$parseJobCode</font></b> Cannot be started, Please Contact Administrator.</font>", 102);
                        }
                    }
                    break;
                case 'end':// end process, update data in database
                    #echo "on case end...\n";
                    $sqlpot = "SELECT COUNT(*) FROM $pottab WHERE sid = $sid AND jobtype = '$proc' ORDER BY poid DESC LIMIT 0, 2";
                    $objSQLpot2 = new SQL($sqlpot);
                    $countpot = $objSQLpot2->getRowCount();
                    if ($countpot == 0) {//if there's no data
                        //joblist has not been started yet
                        #echo "Joblist has not been started yet...\n";
                        throw new Exception("<span style='color:red'>Job <font style='color:yellow'>$parseJobCode</font> has not been started yet...</span>", 103);
                    } else { //if there's data
                        #echo "Joblist has started, begin update\n";
                        $sqlpotr = "SELECT * FROM $pottab WHERE sid = $sid AND jobtype = '$proc' ORDER BY poid DESC LIMIT 0, 2";
                        $objSQLpotr = new SQL($sqlpotr);
                        $potrResult = $objSQLpotr->getResultRowArray();
                        if (!empty($potrResult)) { //if there's already data previously
                            if ($potrResult[0]['date_end'] != NULL || $potrResult[0]['date_end'] != "") {
                                //joblist has already been ended
                                #echo "Found previously ended data\n";
                                #echo "Joblist has already been ended at {$potrResult[0]['date_end']} .\n";
                                throw new Exception("<span style='color:red'>Job <font style='color:yellow'>$parseJobCode</font> has already been ended at <font style='color:yellow'>{$potrResult[0]['date_end']}</font>.</span>", 104);
                            }
                        }
                        //begin update process
                        $sqlpot3 = "SELECT * FROM $pottab WHERE sid = $sid AND jobtype = '$proc' ORDER BY poid DESC LIMIT 0, 1";
                        #echo "sqlpot3 = $sqlpot3\n";
                        $objSQLpot3 = new SQL($sqlpot3);
                        $rowpot = $objSQLpot3->getResultOneRowArray();
                        $poid = $rowpot['poid'];
                        #echo "poid = $poid\n";
                        $qrUpdate = "UPDATE $pottab
	  			    SET date_end = '$currDateTime' , end_by = '$staffid' 
                                    WHERE poid = $poid AND sid = $sid AND jobtype = '$proc'";
                        $objSQLupd = new SQL($qrUpdate);
                        $updResult = $objSQLupd->getUpdate();
                        #echo "update query = $qrUpdate\n";
                        if ($updResult == 'updated') {
                            #echo "Success Updated\n";
                            $successMsg = "Job No <strong><font color=\"#FFFF00\">$parseJobCode</font></strong> has been ended.<br>";
                            #. "Click <a href='#' onclick='undoJobUpdate($poid,$end_period,\"$parseJobCode\")'>here</a> to undo.";
                            $result_array = array('status' => 'success', 'code' => 001, 'msg' => "$successMsg");
                            echo json_encode($result_array);
                        } else {
                            #echo "Failed updated\n";
                            throw new Exception("<font style='color:red'>Job <b><font style='color:yellow'>$parseJobCode</font></b> Cannot be ended, Please Contact Administrator.</font>", 102);
                        }
                    }
                    break;
            }
        } catch (Exception $ex) {
            $errArray = array('status' => 'error', 'code' => $ex->getCode(), 'msg' => $ex->getMessage());
            echo json_encode($errArray);
        }
        break;
    case 'undoJobUpdate':
        $proc_status = $received_data->proc_status;
        $jobcode = $received_data->jobcode;
        $poid = $received_data->poid;
        $period = $received_data->period;
        $pottab = 'production_output_' . $period;
        $qr = "SELECT COUNT(*) FROM $pottab WHERE poid = $poid";
        $objSQL = new SQL($qr);
        $result = $objSQL->getRowCount();
        if ($result == 0) {
            echo "<span style='color:yellow'>Cannot find poid = $poid in database\n"
            . "If you think this is an error, please contact administrator.</span>";
        } else {
            switch ($proc_status) {
                case 'start':// if Start process, undo is delete row
                    $qrU = "DELETE FROM $pottab WHERE poid = $poid";
                    $objSQLU = new SQL($qrU);
                    $delResult = $objSQLU->getDelete();
                    if ($delResult == 'deleted') {
                        echo "<span style='color:yellow'>Job $jobcode Start Process has been undo.</span>";
                    } else {
                        echo "<span style='color:yellow'>Cannot undo Job $jobcode.\n"
                        . "If you think this is an error, please contact administrator.</span>";
                    }
                    break;
                case 'end': // if end process, undo is update row to null
                    $qrU = "UPDATE $pottab SET date_end = NULL, end_by = NULL, quantity = NULL, remainingquantity = NULL WHERE poid = $poid";
                    $objSQLU = new SQL($qrU);
                    $updResult = $objSQLU->getUpdate();
                    if ($updResult == 'updated') {
                        echo "<span style='color:yellow'>Job $jobcode End Process has been undo.</span>";
                    } else {
                        echo "<span style='color:yellow'>Cannot undo Job $jobcode.\n"
                        . "If you think this is an error, please contact administrator.</span>";
                    }
                    break;
            }
        }

        break;
}

function get_OutputDetails($period, $sid) {
    $proouttab = "production_output_" . $period;
    $qr = "SELECT * FROM $proouttab WHERE sid = $sid ORDER BY poid DESC";
    $objSQL = new SQL($qr);
    $result = $objSQL->getResultRowArray();
    if (!empty($result)) {
        return $result;
    } else {
        return 'empty';
    }
}

function get_SchedulingDetails($period, $jobcode) {
    $tblname = 'production_scheduling_' . $period;
    #echo "jobcode = $jobcode\n";
    $jlfor = substr($jobcode, 0, 2);
    $co_code = substr($jobcode, 3, 3);
    $yearmonth = '20' . substr($jobcode, 7, 2) . '-' . substr($jobcode, 9, 2);
    $runningno = (int) substr($jobcode, 12, 4);
    $jobno = (int) substr($jobcode, 17, 2);
    $qr = "SELECT * FROM $tblname "
            . "WHERE jlfor = '$jlfor' "
            . "AND quono LIKE '$co_code%' "
            . "AND date_issue LIKE '$yearmonth%' "
            . "AND runningno = $runningno "
            . "AND jobno = $jobno";
    $objSQL = new SQL($qr);
    $result = $objSQL->getResultOneRowArray();
    #echo "qr = $qr\n";
    #print_r($result);
    if (!empty($result)) {
        return $result;
    } else {
        return 'empty';
    }
}

function get_processName($pmid) {
    $qr = "SELECT process FROM premachining WHERE pmid = $pmid";
    $objSQL = new SQL($qr);
    $results = $objSQL->getResultOneRowArray();
    if (!empty($results)) {
        return $results['process'];
    } else {
        return 'empty';
    }
}
