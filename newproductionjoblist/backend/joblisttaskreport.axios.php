<?php

include_once('../includes/dbh.inc.php');
include_once('../includes/variables.inc.php');
include_once('../includes/joblistwork.inc.php');
include_once('../includes/phhdate.inc.php');

$received_data = json_decode(file_get_contents("php://input"));

$data_output = array();
$action = $received_data->action;

function get_joblisttasks($userid, $period, $start, $limit) {
    if ($userid == null) {
        $where = '';
    } else {
        $where = "WHERE start_by like '%$userid%'";
    }
    $proouttab = "production_output_" . $period;
    $qr = "SELECT DISTINCT sid FROM $proouttab $where LIMIT $start,$limit";
    #echo $qr;
    $objSQL = new SQL($qr);
    $result = $objSQL->getResultRowArray();

    if (!empty($result)) {
        return $result;
    } else {
        return 'empty';
    }
}

function get_count_joblisttasks($userid, $period) {
    if ($userid == null) {
        $where = '';
    } else {
        $where = "WHERE start_by like '%$userid%'";
    }
    $proouttab = "production_output_" . $period;
    $qr = "SELECT COUNT(DISTINCT sid) FROM $proouttab $where";
    #echo $qr;
    $objSQL = new SQL($qr);
    $result = $objSQL->getRowCount();

    if (!empty($result)) {
        return $result;
    } else {
        return 0;
    }
}

function get_companycode($cid, $company) {
    $com = trim(strtolower($company));
    $custab = "customer_" . $com;
    $qr = "SELECT * FROM $custab WHERE cid = $cid AND co_code IS NOT NULL";
    #echo "$qr";
    $objSQL = new SQL($qr);
    $result = $objSQL->getResultOneRowArray();
    if (!empty($result)) {
        return $result['co_code'];
    } else {
        return 'empty';
    }
}

function get_scheduling_detail($sid, $period) {
    $proschtab = "production_scheduling_" . $period;
    $qr = "SELECT * FROM $proschtab WHERE sid = $sid AND status = 'active'";
    $objSQL = new SQL($qr);
    $result = $objSQL->getResultOneRowArray();
    if (!empty($result)) {
        return $result;
    } else {
        return 'empty';
    }
}

function get_array_output($sid, $period) {
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

function get_staff_name($userid) {
    $qr = "SELECT * FROM admin_staff WHERE staffid = '$userid'";
    $objSQL = new SQL($qr);
    $result = $objSQL->getResultOneRowArray();
    if (!empty($result)) {
        return $result['name'];
    } else {
        return null;
    }
}

function get_processcode($pmid) {
    $qr = "SELECT * FROM premachining WHERE pmid = $pmid";
    $objSQL = new SQL($qr);
    $result = $objSQL->getResultOneRowArray();
    if (!empty($result)) {
        return $result['process'];
    }
}

function get_scheduling_detail_by_jobcode($period, $branch, $co_code, $yearmonth, $runningno, $jobno) {
    $proschtab = 'production_scheduling_' . $period;
    $qr = "SELECT * FROM $proschtab "
            . "WHERE jlfor = '$branch' "
            . "AND quono LIKE '$co_code%' "
            . "AND date_issue LIKE '$yearmonth%' "
            . "AND runningno = $runningno "
            . "AND jobno = $jobno";
    $objSQL = new SQL($qr);
    $result = $objSQL->getResultOneRowArray();
    #print_r($result);
    if (!empty($result)) {
        return $result;
    } else {
        return 'empty';
    }
}

function get_array_machine($mcid) {
    $qr = "SELECT name FROM machine WHERE mcid = $mcid";
    $objSQL = new SQL($qr);
    $result = $objSQL->getResultOneRowArray();
    if (!empty($result)) {
        return $result['name'];
    } else {
        return 'empty';
    }
}

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
    case 'getUnfinJoblistPages':
        $period = $received_data->period;
        #$page_arr = array();
        $limit = 15;
        $proschtab = "production_scheduling_" . $period;
        $qr3 = "SELECT COUNT(*) FROM $proschtab WHERE status = 'active'";
        #echo $qr3;
        $objSQL3 = new SQL($qr3);
        $totaldata = $objSQL3->getRowCount();
        $totalpage = ceil($totaldata / $limit);
        $page_arr = array('totaldata' => $totaldata, 'totalpage' => $totalpage);
        #print_r($page_arr);
        echo json_encode($page_arr);
        break;
    case 'getUnfinJoblist':
        $period = $received_data->period;
        $page = $received_data->page;
        $limit = 15; //show max 30 records per page
        $start = ($page - 1) * $limit;
        try {
            $qr1 = "SELECT * FROM production_scheduling_$period WHERE status = 'active' ORDER BY sid LIMIT $start,$limit";
            #echo "qr = $qr1";
            $objSQL1 = new SQL($qr1);
            $schList = $objSQL1->getResultRowArray();
            if (empty($schList)) {
                Throw new Exception('There\'s no data in ' . $period . '!');
            }
            $arr_response = array();
            $cnt = $start;
            foreach ($schList as $data_row) {
                try {
                    $sid = $data_row['sid'];
                    $dateofcompletion = $data_row['dateofcompletion'];
                    $cuttingtype = $data_row['cuttingtype'];
                    $processcode = $data_row['process'];
                    $totalqty = $data_row['quantity'];

                    $cid = $data_row['cid'];
                    $company = $data_row['company'];
                    $runningno = sprintf('%04d', $data_row['runningno']);
                    $jobno = sprintf('%02d', $data_row['jobno']);
                    $jlfor = $data_row['jlfor'];
                    $co_code = get_companycode($cid, $company);
                    $issuedate = $data_row['date_issue'];
                    $issueperiod = substr($issuedate, 2, 2) . substr($issuedate, 5, 2);
                    #$completiondate = $data_row['completion_date'];
                    #$completionperiod = substr($completiondate, 2, 2) . substr($completiondate, 5, 2);
                    #$jobcode = $jlfor . ' ' . $co_code . ' ' . $issueperiod . ' ' . $runningno . ' ' . $jobno . ' ' . $completionperiod;
                    $jobcode = $jlfor . ' ' . $co_code . ' ' . $issueperiod . ' ' . $runningno . ' ' . $jobno;
                    if ($dateofcompletion == null) {
                        $infoDC = 'Joblist Not Yet Ended';
                    } else {
                        $infoDC = 'Joblist Ended';
                    }
                    $infoJT = 'Not Taken';
                    $infoPC = 'Not Started';
                    $jobOutputList = get_array_output($sid, $period);
                    if (empty($jobOutputList)) {
                        Throw new Exception("This doesn't have any output data", 101);
                    }


                    $objJWL = new JOB_WORK_DETAIL($jobcode, $cuttingtype, $processcode, $totalqty, $jobOutputList);
                    $arr_JobWorkDtl = $objJWL->get_arr_jobWork();
                    #print_r($arr_JobWorkDtl);
                    $jobworklen = count($arr_JobWorkDtl) - 1;
                    $finCount = 0;
                    foreach ($arr_JobWorkDtl as $data_out_row) {
                        $process = $data_out_row['process'];
                        $status = $data_out_row['status'];
                        //if ($process == 'Job Take') {
                        //    $infoJT = $status;
                        //} else {
                            if ($status == 'Finished') {
                                $finCount++;
                            }
                        //}
                    }
                    #echo "sid=$sid;\nfinCount = $finCount ; jobworklen = $jobworklen\n";
                    if ($finCount == $jobworklen) {
                        $infoPC = 'Finished';
                    } elseif ($finCount == 0) {
                        $infoPC = 'Not Started';
                    } else {
                        $infoPC = 'On-Progress';
                    }
                    if ($infoDC == 'Joblist Ended' && $infoJT == 'Taken' && $infoPC == 'Finished') {
                        throw new Exception('This joblist is finished already', 100);
                    }
                    $cnt++;
                    $arr_response[] = array(
                        'no' => $cnt,
                        'sid' => $sid,
                        'jobcode' => $jobcode,
                        //'jobtake' => $infoJT,
                        'process' => $infoPC,
                        'Joblist' => $infoDC
                    );
                } catch (Exception $exc) {
                    $ex_code = $exc->getCode();
                    switch ($ex_code) {
                        case 100: //Joblist is finished
                            //skip the process
                            break;
                        case 101:
                            $cnt++;
                            $arr_response[] = array(
                                'no' => $cnt,
                                'sid' => $sid,
                                'jobcode' => $jobcode,
                                'jobtake' => $infoJT,
                                'process' => $infoPC,
                                'Joblist' => $infoDC
                            );
                            break;
                    }
                }
            }
        } catch (Exception $ex) {
            $arr_response[] = array('message' => 'Cannot find data for period = ' . $period . '!');
        }
        #print_r($arr_response);
        echo json_encode($arr_response);
        break;
    case 'getStaffName':
        $userid = $received_data->userid;
        $staffname = get_staff_name($userid);
        echo json_encode($staffname);
        break;
    case 'getJoblistTaskPages':
        $userid = $received_data->userid;
        $period = $received_data->period;
        #$page_arr = array();
        $limit = 30;
        $totaldata = get_count_joblisttasks($userid, $period);
        $totalpage = ceil($totaldata / $limit);
        $page_arr = array('totaldata' => $totaldata, 'totalpage' => $totalpage);
        #print_r($page_arr);
        echo json_encode($page_arr);
        break;
    case 'getJoblistTasks':
        $userid = $received_data->userid;
        $period = $received_data->period;
        $page = $received_data->page;
        $limit = 30; //show max 30 records per page
        $start = ($page - 1) * $limit;
        try {
            $list_joblisttask = get_joblisttasks($userid, $period, $start, $limit);
#            print_r($outputList);
            #echo $outputList['sid'];
            if ($list_joblisttask == 'empty') {
                throw new Exception("Cannot find data using StaffID = $userid and period = $period, aborting process....", 101);
            }
            //begin checking foreach rows for jobno and workdetails;
            $output_data = array();
            $cnt = $start;
            foreach ($list_joblisttask as $data_row) {
                try {
                    $cnt++;
                    $sid = $data_row['sid'];
                    #echo "current sid = $sid\n";
                    $dtl_scheduling = get_scheduling_detail($sid, $period);
                    if ($dtl_scheduling == 'empty') {
                        throw new Exception('This data is not active!');
                    }
                    $outputList = get_array_output($sid, $period);
                    $cuttingtype = $dtl_scheduling['cuttingtype'];
                    $processcode = $dtl_scheduling['process'];
                    $totalqty = $dtl_scheduling['quantity'];
                    $cid = $dtl_scheduling['cid'];
                    $company = $dtl_scheduling['company'];
                    $runningno = sprintf('%04d', $dtl_scheduling['runningno']);
                    $jobno = sprintf('%02d', $dtl_scheduling['jobno']);
                    $jlfor = $dtl_scheduling['jlfor'];
                    $co_code = get_companycode($cid, $company);
                    $issuedate = $dtl_scheduling['date_issue'];
                    $issueperiod = substr($issuedate, 2, 2) . substr($issuedate, 5, 2);
                    #$completiondate = $dtl_scheduling['completion_date'];
                    #$completionperiod = substr($completiondate, 2, 2) . substr($completiondate, 5, 2);

                    #$jobcode = $jlfor . ' ' . $co_code . ' ' . $issueperiod . ' ' . $runningno . ' ' . $jobno . ' ' . $completionperiod;
                    $jobcode = $jlfor . ' ' . $co_code . ' ' . $issueperiod . ' ' . $runningno . ' ' . $jobno;
                    $objJWL = new JOB_WORK_DETAIL($jobcode, $cuttingtype, $processcode, $totalqty, $outputList);
                    $arr_jobworkdtl = $objJWL->get_arr_jobWork();
                    $JobWorkStatus = $objJWL->check_job_work_status($arr_jobworkdtl);
                    #if ($sid == '315' || $sid == 894) {
                    #print_r($dtl_scheduling);
                    #echo "sid = $sid<br>\n";
                    #echo "jobcode = $jobcode<br>\n";
                    #echo "jobworkstatus = $JobWorkStatus<br>\n";
                    #print_r($arr_jobworkdtl);
                    #}
                    $output_data[] = array('no' => $cnt, 'sid' => $sid, 'job_code' => $jobcode, 'status' => $JobWorkStatus);

                    #echo $data_row['sid'];
                } catch (Exception $ex) {
                    
                }
            }
        } catch (Exception $ex) {
            $output_data = array();
            $output_data[] = array('code' => $ex->getCode(), 'msg' => $ex->getMessage());
        }
        echo json_encode($output_data);

        break;
    case 'getSchdDetail':
        $period = $received_data->period;
        $jobcode = $received_data->jobcode;
        //begin parsing the jobcode;
        //jobcode format is AA BBB CCDD EEEE FF; Length is 19, Min 0, Max 18
        //AA = branch
        //BBB = Co_Code
        //CC = Year Issue
        //DD = Month Issue
        //EEEE = Runningno
        //FF = Jobitemno
        $branchcode = substr($jobcode, 0, 2);
        $co_code = substr($jobcode, 3, 3);
        $yearmonth = '20' . substr($jobcode, 7, 2) . '-' . substr($jobcode, 9, 2);
        $runningno = (int) substr($jobcode, 12, 4);
        $jobno = (int) substr($jobcode, 17, 2);
        #echo "branch = $branchcode;\n co_code = $co_code;\n yearmonth = $yearmonth;\n runningno = $runningno;\n jobno = $jobno;";
        $sch_detail = get_scheduling_detail_by_jobcode($period, $branchcode, $co_code, $yearmonth, $runningno, $jobno);
        $pmid = $sch_detail['process'];
        $processcode = get_processcode($pmid);
        $sch_detail['processcode'] = $processcode;
        echo json_encode($sch_detail);
        break;
    case 'getOutputDetail':
        $period = $received_data->period;
        #echo "period = $period\n";
        $sid = $received_data->sid;
        #echo "sid = $sid\n";
        $outputDetail = get_array_output($sid, $period);
        if ($outputDetail != 'empty') {
            foreach ($outputDetail as $data_key => $data_row) {
                //convert start_by into name
                $start_by = get_staff_name($data_row['start_by']);
                #$data_row['start_by_name'] = $start_by;
                //convert end_by into name
                $end_by = get_staff_name($data_row['end_by']);
                #$data_row['end_by_name'] = $end_by;
                //convert mcid into machine name
                $mcname = get_array_machine($data_row['machine_id']);
                #$data_row['machine_name'] = $mcname;
                $new_data_row = array (
                    'poid' => $data_row['poid'],
                    'sid' => $data_row['sid'],
                    'jobtype' => $data_row['jobtype'],
                    'date_start' => $data_row['date_start'],
                    'start_by' => $data_row['start_by'],
                    'start_by_name' => $start_by,
                    'machine_id' => $data_row['machine_id'],
                    'machine_name' => $mcname,
                    'date_end' => $data_row['date_end'],
                    'end_by' => $data_row['end_by'],
                    'end_by_name' => $end_by,
                    'quantity' => $data_row['quantity'],
                    'totalquantity' => $data_row['totalquantity'],
                    'remainingquantity' => $data_row['remainingquantity']
                );
                $outputDetail[$data_key] = $new_data_row;
            }
        }
        #print_r($outputDetail);
        echo json_encode($outputDetail);
        break;
    case 'getJobWorkDetail':
        $period = $received_data->period;
        $jobcode = $received_data->jobcode;
        #$staffid = $received_data->staffid;

        //begin parsing the jobcode;
        //jobcode format is AA BBB CCDD EEEE FF; Length is 19, Min 0, Max 18
        //AA = branch
        //BBB = Co_Code
        //CC = Year Issue
        //DD = Month Issue
        //EEEE = Runningno
        //FF = Jobitemno
        $branchcode = substr($jobcode, 0, 2);
        $co_code = substr($jobcode, 3, 3);
        $yearmonth = '20' . substr($jobcode, 7, 2) . '-' . substr($jobcode, 9, 2);
        $runningno = (int) substr($jobcode, 12, 4);
        $jobno = (int) substr($jobcode, 17, 2);
        #echo "branch = $branchcode;\n co_code = $co_code;\n yearmonth = $yearmonth;\n runningno = $runningno;\n jobno = $jobno;";
        $sch_detail = get_scheduling_detail_by_jobcode($period, $branchcode, $co_code, $yearmonth, $runningno, $jobno);
        #print_r($sch_detail);
        $sid = $sch_detail['sid'];
        $cuttingtype = $sch_detail['cuttingtype'];
        $processcode = $sch_detail['process'];
        $totalqty = $sch_detail['quantity'];
        $jobOutputDetail = get_array_output($sid, $period);
        #print_r($out_detail);
        $objJWL = new JOB_WORK_DETAIL($jobcode, $cuttingtype, $processcode, $totalqty, $jobOutputDetail);
        $arr_JobWorkDtl = $objJWL->get_arr_jobWork();
        #print_r($arr_JobWorkDtl);
        echo json_encode($arr_JobWorkDtl);
        break;
    case 'addBandsaw':
        $jobcode = $received_data->jobcode;
        $qr = "SELECT * FROM joblist_work_status WHERE jobcode = '$jobcode'";
        $objSQL1 = new SQL($qr);
        $result = $objSQL1->getResultOneRowArray();
        if (!empty($result)){
            $qr2 = "UPDATE `joblist_work_status` SET `bandsaw` = 'true' WHERE jobcode LIKE '$jobcode'";
            echo "$qr2<br>";
            $objSQL2 = new SQL($qr2);
            $result2 = $objSQL2->getUpdate();
            if ($result2 == 'updated'){
                echo json_encode(true);
            }else{
                echo json_encode(false);
            }
        }else{
            echo json_encode(false);
        }
        break;
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

