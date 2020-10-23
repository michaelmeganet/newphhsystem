<?php

include_once '../class/dbh.inc.php';
include_once '../class/variables.inc.php';
include_once '../class/abstract_workpcsnew.inc.php';
include_once '../class/reverse-dimension.inc.php';
include_once '../class/phhdate.inc.php';
include_once '../class/joblistwork.inc.php';

$received_data = json_decode(file_get_contents("php://input"));
$data_output = array();
$action = $received_data->action;

function check_table($tblname) {
    $qr = "SHOW TABLES LIKE '$tblname'";
    $objSQL = new SQL($qr);
    $result = $objSQL->getResultOneRowArray();
    if (!empty($result)) {
        return true;
    } else {
        return false;
    }
}

function get_virtualMachineName($processname) {
    switch ($processname) {
        case 'cncmachining':
            $machinename = 'Virtual CNC Machine';
            break;
        case 'manual':
            $machinename = 'Virtual Manual Cut Machine';
            break;
        case 'bandsaw':
            $machinename = 'Virtual Bandsaw Machine';
            break;
        case 'milling':
            $machinename = 'Virtual Milling Machine (Surface)';
            break;
        case 'millingwidth':
            $machinename = 'Virtual Milling Machine (Side|Width)';
            break;
        case 'millinglength':
            $machinename = 'Virtual Milling Machine (Side|Length)';
            break;
        case 'roughgrinding':
            $machinename = 'Virtual Rough Grinding Machine';
            break;
        case 'precisiongrinding':
            $machinename = 'Virtual Surface Grinding Machine';
            break;
    }
    return $machinename;
}

function get_randomVirtualValues($processname) {
    $qr = "SELECT DISTINCT index_per_hour FROM machine WHERE index_per_hour IS NOT NULL AND index_per_hour != 0 AND ";
    switch ($processname) {
        case 'cncmachining':
            $qr .= "  machineid LIKE 'CNC%' ";
            break;
        case 'manual':
            $qr .= "  machineid LIKE 'MCT%' ";
            break;
        case 'bandsaw':
            $qr .= "  machineid LIKE 'BSC%' ";
            break;
        case 'milling':
            $qr .= "  machineid LIKE 'MMG%' AND name LIKE '%surface%' ";
            break;
        case 'millingwidth':
            $qr .= "  machineid LIKE 'MMG%' AND name LIKE '%side%' ";
            break;
        case 'millinglength':
            $qr .= "  machineid LIKE 'MMG%' AND name LIKE '%side%' ";
            break;
        case 'roughgrinding':
            $qr .= "  machineid LIKE 'RGG%' ";
            break;
        case 'precisiongrinding':
            $qr .= "  machineid LIKE 'SGG%' ";
            break;
    }
    $objSQL = new SQL($qr);
    $result = $objSQL->getResultRowArray();
    $arr_index_per_hour = array();
    foreach ($result as $data_row) {
        foreach ($data_row as $key => $val) {
            $arr_index_per_hour[] = $val;
        }
    }
    #echo"<pre>Index Per Hour Array Random Value (Virtual $processname):";
    #print_r($arr_index_per_hour);
    #echo "</pre>";
    $rand_index_per_hour = array_rand($arr_index_per_hour, 1);
    #echo "Selected Random Value : {$arr_index_per_hour[$rand_index_per_hour]}<br>";
    return $arr_index_per_hour[$rand_index_per_hour];
}

function get_staffDetails($staffid) {
    $qr = "SELECT * FROM admin_staff WHERE staffid = '$staffid'";
    $objSQL = new SQL($qr);
    $result = $objSQL->getResultOneRowArray();
    if (!empty($result)) {
        return $result;
    } else {
        return 'empty';
    }
}

function get_kpiTimeTableDetails($start_time) {
    $date = date_format(date_create($start_time), 'Y-m-d');
    $time = date_format(date_create($start_time), 'H:i:s');
    $shift1S = date_format(date_create('08:00:00'), 'H:i:s');
    $shift1E = date_format(date_create('19:59:59'), 'H:i:s');
    $shift2S = date_format(date_create('20:00:00'), 'H:i:s');
    $shift2E = date_format(date_create('07:59:59'), 'H:i:s');
    $qr = "SELECT * FROM kpitimetable WHERE date = '$date'";
    $objSQL = new SQL($qr);
    $result = $objSQL->getResultOneRowArray();
    if (!empty($result)) {
        if ($time >= $shift1S && $time <= $shift1E) {
            $shiftVal = $result['shift1'];
        } elseif ($time >= $shift2S && $time <= $shift2E) {
            $shiftVal = $result['shift2'];
        }
        if ($shiftVal = 1) {
            $kpiVal = 9.8;
        } elseif ($shiftVal = 0) {
            $kpiVal = 7.35;
        }
        return $kpiVal;
    } else {
        return 'empty';
    }
}

function get_filteredDetails($table, $date, $summType, $staffid, $mcid, $shift) {
    if ($shift == 1) {
        $timecheck = "AND"
                . "(
                    DATE_FORMAT(start_time,'%H:%i:%s') > TIME_FORMAT('08:00:00','%H:%i:%s') AND DATE_FORMAT(start_time,'%H:%i:%s') < TIME_FORMAT('19:59:59','%H:%i:%s')
                  )";
    } elseif ($shift == 2) {
        $timecheck = "AND NOT"
                . "(
                    DATE_FORMAT(start_time,'%H:%i:%s') > TIME_FORMAT('08:00:00','%H:%i:%s') AND DATE_FORMAT(start_time,'%H:%i:%s') < TIME_FORMAT('19:59:59','%H:%i:%s')
                  )";
    }
    if ($summType == 'daily') {
        $qr = "SELECT * FROM $table "
                . "WHERE poid IS NOT NULL AND jlfor = 'CJ' AND NOT jobtype ='cncmachining' AND staffid = '$staffid' "
                . "AND mcid = $mcid AND DATE_FORMAT(dateofcompletion,'%Y %m %d') = DATE_FORMAT('$date','%Y %m %d') "
                . $timecheck
                . "ORDER BY dateofcompletion, staffid, mcid ASC";
    } elseif ($summType == 'all') {
        $qr = "SELECT * FROM $table "
                . "WHERE poid IS NOT NULL AND jlfor = 'CJ' AND NOT jobtype ='cncmachining' AND staffid = '$staffid' "
                . "AND mcid = $mcid AND DATE_FORMAT(dateofcompletion,'%Y %m') = DATE_FORMAT('$date','%Y %m') "
                . $timecheck
                . "ORDER BY dateofcompletion, staffid, mcid ASC";
    }
    $objSQL = new SQL($qr);
    $result = $objSQL->getResultRowArray();
    #echo "\n qr = $qr\n";
    if (!empty($result)) {
        return $result;
    } else {
        return 'empty';
    }
}

function get_machineDetails($mcid) {
    $qr = "SELECT * FROM machine WHERE mcid = $mcid";
    $objSQL = new SQL($qr);
    $result = $objSQL->getResultOneRowArray();
    if (!empty($result)) {
        return $result;
    } else {
        return 'empty';
    }
}

function get_distinctMachine($table, $date, $summType, $staffid, $shift) {
    if ($shift == 1) {
        $timecheck = "AND"
                . "(
                    DATE_FORMAT(start_time,'%H:%i:%s') > TIME_FORMAT('08:00:00','%H:%i:%s') AND DATE_FORMAT(start_time,'%H:%i:%s') < TIME_FORMAT('19:59:59','%H:%i:%s')
                  )";
    } elseif ($shift == 2) {
        $timecheck = "AND NOT"
                . "(
                    DATE_FORMAT(start_time,'%H:%i:%s') > TIME_FORMAT('08:00:00','%H:%i:%s') AND DATE_FORMAT(start_time,'%H:%i:%s') < TIME_FORMAT('19:59:59','%H:%i:%s')
                  )";
    }
    if ($summType == 'daily') {
        $qr = "SELECT DISTINCT mcid,machineid FROM $table WHERE poid IS NOT NULL AND jlfor = 'CJ' AND NOT jobtype ='cncmachining' "
                . "AND staffid = '$staffid' "
                . "AND DATE_FORMAT(dateofcompletion,'%Y %m %d') = DATE_FORMAT('$date','%Y %m %d')"
                . "$timecheck ORDER BY mcid ASC";
    } elseif ($summType == 'all') {
        $qr = "SELECT DISTINCT mcid,machineid FROM $table WHERE poid IS NOT NULL AND jlfor = 'CJ' AND NOT jobtype ='cncmachining' "
                . "AND staffid = '$staffid' "
                . "AND DATE_FORMAT(dateofcompletion,'%Y %m') = DATE_FORMAT('$date','%Y %m') "
                . "$timecheck ORDER BY mcid ASC";
    }
    #echo "qr = $qr\n";
    $objSQL = new SQL($qr);
    $result = $objSQL->getResultRowArray();
    if (!empty($result)) {
        return $result;
    } else {
        return 'empty';
    }
}

function get_distinctMachine_M($table, $date, $summType) {
    if ($summType == 'daily') {
        $qr = "SELECT DISTINCT mcid,machineid FROM $table WHERE poid IS NOT NULL AND jlfor = 'CJ' AND NOT jobtype ='cncmach' AND DATE_FORMAT(dateofcompletion,'%Y %m %d') = DATE_FORMAT('$date','%Y %m %d') ORDER BY mcid ASC";
    } elseif ($summType == 'all') {
        $qr = "SELECT DISTINCT mcid,machineid FROM $table WHERE poid IS NOT NULL AND jlfor = 'CJ' AND NOT jobtype ='cncmach' AND DATE_FORMAT(dateofcompletion,'%Y %m') = DATE_FORMAT('$date','%Y %m') ORDER BY mcid ASC";
    }
    $objSQL = new SQL($qr);
    $result = $objSQL->getResultRowArray();
    if (!empty($result)) {
        return $result;
    } else {
        return 'empty';
    }
}

function get_distinctStaff_M($table, $date, $summType, $mcid) {
    if ($summType == 'daily') {
        $qr = "SELECT DISTINCT staffid FROM $table WHERE poid IS NOT NULL AND mcid = $mcid AND jlfor = 'CJ' AND NOT jobtype ='cncmach' AND DATE_FORMAT(dateofcompletion,'%Y %m %d') = DATE_FORMAT('$date','%Y %m %d')";
    } elseif ($summType == 'all') {
        $qr = "SELECT DISTINCT staffid FROM $table WHERE poid IS NOT NULL AND mcid = $mcid AND jlfor = 'CJ' AND NOT jobtype ='cncmach' AND DATE_FORMAT(dateofcompletion,'%Y %m') = DATE_FORMAT('$date','%Y %m')";
    }
    $objSQL = new SQL($qr);
    $result = $objSQL->getResultRowArray();
    if (!empty($result)) {
        return $result;
    } else {
        return 'empty';
    }
}

function get_distinctStaff($table, $date, $summType, $shift) {
    if ($shift == 1) {
        $timecheck = "AND"
                . "(
                    DATE_FORMAT(start_time,'%H:%i:%s') > TIME_FORMAT('08:00:00','%H:%i:%s') AND DATE_FORMAT(start_time,'%H:%i:%s') < TIME_FORMAT('19:59:59','%H:%i:%s')
                  )";
    } elseif ($shift == 2) {
        $timecheck = "AND NOT"
                . "(
                    DATE_FORMAT(start_time,'%H:%i:%s') > TIME_FORMAT('08:00:00','%H:%i:%s') AND DATE_FORMAT(start_time,'%H:%i:%s') < TIME_FORMAT('19:59:59','%H:%i:%s')
                  )";
    }

    if ($summType == 'daily') {
        $qr = "SELECT DISTINCT staffid FROM $table "
                . "WHERE poid IS NOT NULL AND jlfor = 'CJ' "
                . "AND NOT jobtype ='cncmachining' "
                . "AND DATE_FORMAT(dateofcompletion,'%Y %m %d') = DATE_FORMAT('$date','%Y %m %d')"
                . "$timecheck";
    } elseif ($summType == 'all') {
        $qr = "SELECT DISTINCT staffid FROM $table "
                . "WHERE poid IS NOT NULL AND jlfor = 'CJ' "
                . "AND NOT jobtype ='cncmachining' "
                . "AND DATE_FORMAT(dateofcompletion,'%Y %m') = DATE_FORMAT('$date','%Y %m')"
                . "$timecheck";
        ;
    }
    $objSQL = new SQL($qr);
    $result = $objSQL->getResultRowArray();
    if (!empty($result)) {
        return $result;
    } else {
        return 'empty';
    }
}

switch ($action) {
    case 'getPeriod':
        $objDate = new DateNow();
        $currentPeriod_int = $objDate->intPeriod();
        $currentPeriod_str = $objDate->strPeriod();

        $EndYYYYmm = 2001;
        $objPeriod = new generatePeriod($currentPeriod_int, $EndYYYYmm);
        $setofPeriod = $objPeriod->generatePeriod3();

        echo json_encode($setofPeriod);
        break;
    case 'getDayList':
        $period = $received_data->period;
        $year = '20' . substr($period, 0, 2);
        $month = substr($period, 2, 2);
        $day = '01';
        $date = $year . '-' . $month . '-' . $day;
        #echo $date;
        $noofdays = date_format(date_create($date), 't');
        echo $noofdays;
        break;
    case 'getSimpleKPIMonthly':
        #$period = $_POST['period'];
        #$jobstatus = $_POST['jobstatus'];
        $period = $received_data->period;
        $jobstatus = $received_data->jobstatus;
        #echo "period = $period";
        #echo "jobstatus = $jobstatus";
        $summType = 'all';
        $day = '00';
        $kpidetailstable = 'kpidetails_' . $period;
        $year = '20' . substr($period, 0, 2);
        $month = substr($period, 2, 2);
        $date = $year . '-' . $month . '-' . $day;
        #echo "<div style='text-align:center'>";
        #echo "<b style='font-size:2em'>KPI MONTHLY SUMMARY BY STAFF NAME, MACHINE</b><br>";
        #echo "<b style='font-size:1.5em'>JOBS = " . strtoupper($jobstatus) . "&nbsp;&nbsp;PERIOD = $year-$month</b><br>";
        #echo "</div>";

        try {
            if ($jobstatus == 'unfinished') {
                throw new Exception('begin unfinished records', 191);
            }
            $staffList = get_distinctStaff($kpidetailstable, $date, $summType);
            if ($staffList == 'empty') {
                throw new Exception('There\'s no staff found!', 101);
            }
            foreach ($staffList as $data_staff) {
                $staffid = $data_staff['staffid'];
                $staffDetails = get_staffDetails($staffid);
                if ($staffDetails != 'empty') {
                    $staffname = $staffDetails['name'];
                } else {
                    $staffname = null;
                }
                $machineList = get_distinctMachine($kpidetailstable, $date, $summType, $staffid);
                foreach ($machineList as $data_machine) {
                    $mcid = $data_machine['mcid'];
                    $machineid = $data_machine['machineid'];
                    $mcDetail = get_machineDetails($mcid);
                    if ($mcDetail != 'empty') {
                        #echo "<pre>MachineLists : ";
                        #print_r($mcDetail);
                        #echo "</pre>";
                        $machine_name = $mcDetail['name'];
                        $machine_model = $mcDetail['model'];
                        $index_per_hour = $mcDetail['index_per_hour'];
                        $index_per_shift = $index_per_hour * 8;
                    } else {
                        $machine_name = null;
                        $machine_model = null;
                        $index_per_hour = null;
                        $index_per_shift = null;
                    }
                    $filteredDetails = get_filteredDetails($kpidetailstable, $date, $summType, $staffid, $mcid);
                    if ($filteredDetails != 'empty') {
                        //begin calculate kpi (based on staffid and mcid
                        $index_gain_sum = 0;
                        #$det_kpi_row = array();
                        $cnt = 0;
                        foreach ($filteredDetails as $data_row) {
                            $cnt++;
                            $jd_qty = $data_row['jobdonequantity'];
                            $unit_weight = $data_row['unit_weight'];
                            $start_time = $data_row['start_time'];
                            $end_time = $data_row['end_time'];
                            if ($jd_qty) {
                                $index_gain_in_kg = $jd_qty * $unit_weight;
                            } else {
                                $index_gain_in_kg = 0;
                            }
                            //fetch current KPI
                            $kpiVal = get_kpiTimeTableDetails($start_time);
                            #echo "kpiVal = $kpiVal<br>";
                            $index_gain_sum = $index_gain_sum + ($index_gain_in_kg * $kpiVal);
                        }
                        if ($index_per_shift) {
                            $total_value_gain = round($index_gain_sum / $index_per_shift, 3);
                        } else {
                            $total_value_gain = 0;
                        }
                        //create array of the current sum
                        $det_kpi_row[] = array(
                            'machineid' => $machineid,
                            'machinename' => $machine_name,
                            'machinemodel' => $machine_model,
                            'weight_gain' => number_format(round($index_gain_sum, 2), 2),
                            'machine_index_per_shift' => $index_per_shift,
                            'total_value_gain(RM)' => number_format(round($total_value_gain, 7), 7),
                            'data_found' => $cnt
                        );
                        //push this to det_KPI array
                    } else {
                        
                    }
                }
                $det_KPI[] = array(
                    'staffid' => $staffid,
                    'staffname' => $staffname,
                    'details' => $det_kpi_row
                );
                unset($det_kpi_row);
            }
            echo json_encode($det_KPI);
        } catch (Exception $ex) {
            $code = $ex->getCode();
            switch ($code) {
                case 101: //cannot find staff list
                    //check if current status is unfinished or not
                    $err_msg = array('status' => 'error', 'msg' => "Cannot find Staff for period = $period.");
                    #echo "Cannot find Staff for period = $period.<br>";
                    echo json_encode($err_msg);
                    break;
                case 191: //begin unfinished jobs
                    $qrU = "SELECT * FROM $kpidetailstable WHERE poid IS NULL AND jlfor = 'CJ'";
                    $objSQLU = new SQL($qrU);
                    $kpiData = $objSQLU->getResultRowArray();
                    #echo "qr = $qrU<br>";
                    #echo "Found " . count($kpiData) . " Datas.<br>";
                    #echo "<pre>";
                    #print_r($result);
                    #echo "</pre>";
                    $unfinKPIDetails = array();
                    if (!empty($kpiData)) {
                        foreach ($kpiData as $data_row) {
                            $schedulingtable = "production_scheduling_$period";
                            $jobcode = $data_row['jobcode'];
                            $cuttingtype = $data_row['cuttingtype'];
                            $sid = $data_row['sid'];
                            $qrSID = "SELECT process FROM $schedulingtable WHERE sid = $sid";
                            $objSQLSID = NEW SQL($qrSID);
                            $resultProcessCode = $objSQLSID->getResultOneRowArray();
                            $processcode = $resultProcessCode['process'];
                            $totalquantity = $data_row['totalquantity'];
                            $objJWDetail = new JOB_WORK_DETAIL($jobcode, $cuttingtype, $processcode, $totalquantity);
                            $ex_jobwork = $objJWDetail->get_ex_jobWork();
                            #echo "sid = $sid; jobcode = $jobcode; cuttingtype = $cuttingtype; processcode = $processcode; totalquantity = $totalquantity<br>";
                            #print_r($ex_jobwork);
                            #echo "<br>";
                            if ($ex_jobwork['millingwidth'] == 'true' && $ex_jobwork['millinglength'] == 'true') {
                                
                            } else {
                                foreach ($ex_jobwork as $processname => $processstatus) {
                                    if ($processstatus == 'true') {
                                        $rand_index_per_shift = get_randomVirtualValues($processname);
                                        $unit_weight = $data_row['unit_weight'];
                                        if ($totalquantity != 0) {
                                            $index_gain_in_kg = $unit_weight * $totalquantity;
                                        } else {
                                            $index_gain_in_kg = 0;
                                        }
                                        $inv_Nu_KPI = $index_gain_in_kg / $rand_index_per_shift * 9.8;
                                        //slide in the individual value into data_row;
                                        $offset = 12;
                                        $data_row['index_gain_in_kg'] = $index_gain_in_kg;
                                        $new_datarow = array_slice($data_row, 0, $offset, true) +
                                                array('individual_kpi' => number_format(round($inv_Nu_KPI, 7), 7)) +
                                                array_slice($data_row, $offset, NULL, true);
                                        $unfinKPIDetails[$processname][] = $new_datarow;
                                    }
                                }
                            }
                        }
                        foreach ($unfinKPIDetails as $processname => $details) {
                            $machinename = get_virtualMachineName($processname);
                            $totaldata = count($details);
                            $sum_index_gain = 0;
                            $sum_KPI = 0;
                            foreach ($details as $detail_row) {
                                $sum_index_gain += $detail_row['index_gain_in_kg'];
                                $sum_KPI += $detail_row['individual_kpi'];
                            }
                            $det_KPI[] = array(
                                'machinename' => $machinename,
                                'weight_gain' => number_format(round($sum_index_gain, 2), 2),
                                'estimated_totalkpi' => number_format(round($sum_KPI, 7), 7),
                                'data_found' => $totaldata
                            );
                        }
                        echo json_encode($det_KPI);
                    } else {
                        $err_msg = array('status' => 'error', 'msg' => "Cannot find Staff for period = $period.");
                        echo json_encode($err_msg);
                    }
                    #echo "<pre>";
                    #print_r($det_KPI);
                    #echo "</pre>";
                    break;
            }
        }

        break;
    case 'getDetailedKPIStaff':
        $period = $received_data->period;
        $summType = $received_data->summType;
        $i_day = $received_data->day;
        #$period = $_POST['period'];
        #$summType = $_POST['summType'];
        #$i_day = $_POST['day'];
        $kpidetailstable = 'kpidetails_' . $period;
        $year = '20' . substr($period, 0, 2);
        $month = substr($period, 2, 2);
        if ($summType == 'all') {
            $i_day = 1;
            $day = sprintf('%02d', $i_day);
            $date = $year . '-' . $month . '-' . $day;
            $totaldate = date_format(date_create($date), 't');
        } else {
            $day = sprintf('%02d', $i_day);
            $date = $year . '-' . $month . '-' . $day;
            $totaldate = $i_day;
        }
        $day = sprintf('%02d', $i_day);
        #echo "selected day = $day<br>";
        #echo "Total date in this month = $totaldate";
        #echo "<div style='text-align:center'>";
        if ($summType == 'daily') {
            #echo "<b style='font-size:2em'>KPI INDEX DAILY DETAILS REPORT</b><br>";
            #echo "<h2>DATE = $day-$month-$year</h2><br>";
        } else {
            #echo "<b style='font-size:2em'>KPI INDEX MONTHLY DETAILS REPORT</b><br>";
            #echo "<h2>DATE = $month-$year</h2><br>";
        }
        #echo "</div>";
        for ($i = $i_day; $i <= $totaldate; $i++) {
            $day = sprintf('%02d', $i);
            $date = $year . '-' . $month . '-' . $day;
            #echo "<h3>Processing Date '$date'</h3><br>";
            for ($shift = 1; $shift <= 2; $shift++) {
                #echo $shift;
                try {
                    $staffList = get_distinctStaff($kpidetailstable, $date, 'daily', $shift);
                    if ($staffList == 'empty') {
                        throw new Exception('There\'s no staff found!', 101);
                    }
                    #echo "<span style= 'color:white;background-color:blue'>found " . count($staffList) . " staff</span><br>";
                    foreach ($staffList as $data_staff) {
                        $staffid = $data_staff['staffid'];
                        $staffDetails = get_staffDetails($staffid);
                        if ($staffDetails != 'empty') {
                            $staffname = $staffDetails['name'];
                        } else {
                            $staffname = null;
                        }
                        $machineList = get_distinctMachine($kpidetailstable, $date, 'daily', $staffid, $shift);
                        #print_r($machineList);
                        #echo "<span style= 'color:white;background-color:black'>found " . count($machineList) . " machines</span><br>";
                        foreach ($machineList as $data_machine) {
                            $mcid = $data_machine['mcid'];
                            $machineid = $data_machine['machineid'];
                            $mcDetail = get_machineDetails($mcid);
                            if ($mcDetail != 'empty') {
                                #echo "<pre>MachineLists : ";
                                #print_r($mcDetail);
                                #echo "</pre>";
                                $machine_name = $mcDetail['name'];
                                $machine_model = $mcDetail['model'];
                                $index_per_hour = $mcDetail['index_per_hour'];
                                $index_per_shift = $index_per_hour * 8;
                            } else {
                                $machine_name = null;
                                $machine_model = null;
                                $index_per_hour = null;
                                $index_per_shift = null;
                            }
                            $filteredDetails = get_filteredDetails($kpidetailstable, $date, 'daily', $staffid, $mcid, $shift);
                            if ($filteredDetails != 'empty') {
                                //begin calculate kpi (based on staffid and mcid
                                $calculatedKPI = 0;
                                $cnt = 0;
                                foreach ($filteredDetails as $data_row) {
                                    $cnt++;
                                    $jd_qty = $data_row['jobdonequantity'];
                                    $unit_weight = $data_row['unit_weight'];
                                    $start_time = $data_row['start_time'];
                                    $end_time = $data_row['end_time'];
                                    if ($jd_qty) {
                                        $index_gain_in_kg = $jd_qty * $unit_weight;
                                    } else {
                                        $index_gain_in_kg = 0;
                                    }
                                    //fetch current KPI
                                    $kpiVal = get_kpiTimeTableDetails($start_time);
                                    #echo "kpiVal = $kpiVal<br>";
                                    $single_KPI = ($index_gain_in_kg * $kpiVal);
                                    if ($index_per_shift) {
                                        $inv_KPI = $single_KPI / $index_per_shift;
                                    } else {
                                        $inv_KPI = 0;
                                    }
                                    $calculatedKPI += round($inv_KPI, 7);
                                    //slide in the individual value into data_row;
                                    $offset = 12;
                                    $new_datarow = array_slice($data_row, 0, $offset, true) +
                                            array('individual_kpi' => number_format(round($inv_KPI, 7), 7)) +
                                            array_slice($data_row, $offset, NULL, true);
                                    #$data_row['individual_kpi'] = $inv_KPI;
                                    $det_kpi_row_details[] = $new_datarow;
                                }
                                //create array of the current sum
                                #echo "Generating staffid = $staffid, machine id = $machineid<br>Found $cnt Data<br> <strong>Total KPI is $calculatedKPI.</strong><br>";
                                $det_kpi_row[] = array(
                                    'staffid' => $staffid,
                                    'staffname' => $staffname,
                                    'machineid' => $machineid,
                                    'machinename' => $machine_name,
                                    'machinemodel' => $machine_model,
                                    'index_per_shift' => $index_per_shift,
                                    'totalkpi' => $calculatedKPI,
                                    'details' => $det_kpi_row_details
                                );
                                unset($det_kpi_row_details);
                            } else {
                                
                            }
                        }
                    }
                } catch (Exception $ex) {
                    $code = $ex->getCode();
                    switch ($code) {
                        case 101: //cannot find staff list
                            #echo "Cannot find Staff for period = $period.<br>";
                            break;
                    }
                }
                if (isset($det_kpi_row)) {
                    $det_KPI['shift' . $shift][$date] = $det_kpi_row;
                    unset($det_kpi_row);
                }
            }
        }
        if (!empty($det_KPI)) {
            echo json_encode($det_KPI);
        } else {
            $err_arr = array('status' => 'error', 'msg' => 'Cannot find data for period = ' . $period);
            echo json_encode($err_arr);
        }
        break;
    case 'getDetailedKPIMachine':
        $period = $received_data->period;
        $summType = $received_data->summType;
        $kpidetailstable = 'kpidetails_' . $period;
        $year = '20' . substr($period, 0, 2);
        $month = substr($period, 2, 2);
        #$day = sprintf('%02d', $i_day);
        #echo "selected day = $day<br>";
        #echo "Total date in this month = $totaldate";
        #echo "<div style='text-align:center'>";
        #echo "<b style='font-size:2em'>KPI INDEX MONTHLY DETAILS REPORT BY MACHINE</b><br>";
        #echo "<h2>DATE = $month-$year</h2><br>";
        #echo "</div>";
        $day = sprintf('%02d', 00);
        $date = $year . '-' . $month . '-' . $day;
        #echo "<h3>Processing Date '$date'</h3><br>";
        try {
            $machineList = get_distinctMachine_M($kpidetailstable, $date, $summType);
            if ($machineList == 'empty') {
                throw new Exception('There\'s no machine found!', 101);
            }
            #echo "<span style= 'color:white;background-color:blue'>found " . count($staffList) . " staff</span><br>";

            foreach ($machineList as $data_machine) {
                $mcid = $data_machine['mcid'];
                $machineid = $data_machine['machineid'];
                $mcDetail = get_machineDetails($mcid);
                if ($mcDetail != 'empty') {
                    #echo "<pre>MachineLists : ";
                    #print_r($mcDetail);
                    #echo "</pre>";
                    $machine_name = $mcDetail['name'];
                    $machine_model = $mcDetail['model'];
                    $index_per_hour = $mcDetail['index_per_hour'];
                    $index_per_shift = $index_per_hour * 8;
                } else {
                    $machine_name = null;
                    $machine_model = null;
                    $index_per_hour = null;
                    $index_per_shift = null;
                }
                $calculatedKPI = 0;
                $cnt = 0;
                $staffList = get_distinctStaff_M($kpidetailstable, $date, $summType, $mcid);
                #echo "<span style= 'color:white;background-color:black'>found " . count($machineList) . " machines</span><br>";
                foreach ($staffList as $data_staff) {
                    $staffid = $data_staff['staffid'];
                    $staffDetails = get_staffDetails($staffid);
                    if ($staffDetails != 'empty') {
                        $staffname = $staffDetails['name'];
                    } else {
                        $staffname = null;
                    }
                    $filteredDetails = get_filteredDetails($kpidetailstable, $date, $summType, $staffid, $mcid);
                    if ($filteredDetails != 'empty') {
                        //begin calculate kpi (based on staffid and mcid
                        foreach ($filteredDetails as $data_row) {
                            $cnt++;
                            $jd_qty = $data_row['jobdonequantity'];
                            $unit_weight = $data_row['unit_weight'];
                            $start_time = $data_row['start_time'];
                            $end_time = $data_row['end_time'];
                            if ($jd_qty) {
                                $index_gain_in_kg = $jd_qty * $unit_weight;
                            } else {
                                $index_gain_in_kg = 0;
                            }
                            //fetch current KPI
                            $kpiVal = get_kpiTimeTableDetails($start_time);
                            #echo "kpiVal = $kpiVal<br>";
                            $single_KPI = ($index_gain_in_kg * $kpiVal);
                            if ($index_per_shift) {
                                $inv_KPI = $single_KPI / $index_per_shift;
                            } else {
                                $inv_KPI = 0;
                            }
                            $calculatedKPI += round($inv_KPI, 7);
                            //slide in the individual value into data_row;
                            $offset = 12;
                            $new_datarow = array_slice($data_row, 0, $offset, true) +
                                    array('individual_kpi' => number_format(round($inv_KPI, 7), 7)) +
                                    array_slice($data_row, $offset, NULL, true);
                            #$data_row['individual_kpi'] = $inv_KPI;
                            $det_kpi_row_details[] = $new_datarow;
                        }
                        //create array of the current sum
                        #echo "Generating staffid = $staffid, machine id = $machineid<br>Found $cnt Data<br> <strong>Total KPI is $calculatedKPI.</strong><br>";
                        if (isset($det_kpi_row_details)) {
                            $det_kpi_row2[] = array(
                                'staffid' => $staffid,
                                'staffname' => $staffname,
                                'details' => $det_kpi_row_details
                            );
                            unset($det_kpi_row_details);
                        }
                    } else {
                        
                    }
                }
                if (isset($det_kpi_row2)) {
                    $det_kpi_row[] = array(
                        'machineid' => $machineid,
                        'machinename' => $machine_name,
                        'machinemodel' => $machine_model,
                        'index_per_shift' => $index_per_shift,
                        'totalkpi' => $calculatedKPI,
                        'bystaff' => $det_kpi_row2,
                    );
                    unset($det_kpi_row2);
                }
            }
        } catch (Exception $ex) {
            $code = $ex->getCode();
            switch ($code) {
                case 101: //cannot find staff list
                    #echo "Cannot find Machine for period = $period.<br>";
                    break;
            }
        }
        if (isset($det_kpi_row)) {
            $det_KPI = $det_kpi_row;
            unset($det_kpi_row);
        }
        if (!empty($det_KPI)) {
            echo json_encode($det_KPI);
        } else {
            $err_arr = array('status' => 'error', 'msg' => 'Cannot find data for period = ' . $period);
            echo json_encode($err_arr);
        }
        break;
    case 'getDetailedKPIUnfin':
        $period = $received_data->period;
        $processname = $received_data->processname;
        #$period = $_POST['period'];
        #$processname = $_POST['processname'];
        $kpidetailstable = 'kpidetails_' . $period;
        $year = '20' . substr($period, 0, 2);
        $month = substr($period, 2, 2);
        $currmonth = date('m');
        $currday = date('d');
        $curryear = date('Y');
        if ($month == $currmonth && $year == $curryear) {
            $noofdays = $currday;
            $overTxt = '(Current Date)';
        } else {
            $date = $year . "-" . $month . "-01";
            $noofdays = date_format(date_create($date), 't');
            $overTxt = '(Last Date of Month)';
        }
        #echo "<div style='text-align:center'>";
        #echo "<b style='font-size:2em'>ESTIMATED KPI INDEX MONTHLY UNFINISHED JOBS DETAILS REPORT</b><br>";
        #echo "<b style='font-size:1.5em>PERIOD : 01-$month-$year to $noofdays-$month-$year  $overTxt </b><br>";
        #echo "<h2>PROCESS NAME : " . strtoupper($processname) . " </h2><br>";
        #echo "</div>";

        $qrU = "SELECT * FROM $kpidetailstable WHERE poid IS NULL AND jlfor = 'CJ'";
        $objSQLU = new SQL($qrU);
        $kpiData = $objSQLU->getResultRowArray();
        #echo "qr = $qrU<br>";
        #echo "Found " . count($kpiData) . " Datas.<br>";
        #echo "<pre>";
        #print_r($result);
        #echo "</pre>";
        $unfinKPIDetails = array();
        foreach ($kpiData as $data_row) {
            $schedulingtable = "production_scheduling_$period";
            $jobcode = $data_row['jobcode'];
            $cuttingtype = $data_row['cuttingtype'];
            $sid = $data_row['sid'];
            $qrSID = "SELECT process FROM $schedulingtable WHERE sid = $sid";
            $objSQLSID = NEW SQL($qrSID);
            $resultProcessCode = $objSQLSID->getResultOneRowArray();
            $processcode = $resultProcessCode['process'];
            $totalquantity = $data_row['totalquantity'];
            $objJWDetail = new JOB_WORK_DETAIL($jobcode, $cuttingtype, $processcode, $totalquantity);
            $ex_jobwork = $objJWDetail->get_ex_jobWork();
            #echo "sid = $sid; jobcode = $jobcode; cuttingtype = $cuttingtype; processcode = $processcode; totalquantity = $totalquantity<br>";
            #print_r($ex_jobwork);
            #echo "<br>";
            if ($ex_jobwork['millingwidth'] == 'true' && $ex_jobwork['millinglength'] == 'true') {
                
            } else {
                foreach ($ex_jobwork as $key => $processstatus) {
                    if ($processstatus == 'true' && $processname == $key) {
                        $rand_index_per_shift = get_randomVirtualValues($processname);
                        $unit_weight = $data_row['unit_weight'];
                        if ($totalquantity != 0) {
                            $index_gain_in_kg = $unit_weight * $totalquantity;
                        } else {
                            $index_gain_in_kg = 0;
                        }
                        $inv_Nu_KPI = $index_gain_in_kg / $rand_index_per_shift * 9.8;
                        //slide in the individual value into data_row;
                        $offset = 12;
                        $data_row['index_gain_in_kg'] = $index_gain_in_kg;
                        $new_datarow = array_slice($data_row, 0, $offset, true) +
                                array('estimated_individual_kpi' => number_format(round($inv_Nu_KPI, 7), 7)) +
                                array_slice($data_row, $offset, NULL, true);
                        #$unfinKPIDetails[$processname][] = $new_datarow;
                        $unfinKPIDetails[] = $new_datarow;
                    }
                }
            }
        }
        if (!empty($unfinKPIDetails)) {
            echo json_encode($unfinKPIDetails);
        } else {
            $err_arr = array('status' => 'error', 'msg' => 'Cannot find data for period = ' . $period . " and Process = $processname");
            echo json_encode($err_arr);
        }
        break;
    case 'getVirtualMachineName':
        $processname = $received_data->processname;
        echo json_encode(get_virtualMachineName($processname));
        break;
}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

