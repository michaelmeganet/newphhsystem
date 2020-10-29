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
    $dateY = (int) date_format(date_create($start_time), 'Y');
    $datem = (int) date_format(date_create($start_time), 'm');
    $dated = (int) date_format(date_create($start_time), 'd');
    $time = date_format(date_create($start_time), 'H:i:s');
    $shift1S = date_format(date_create('08:00:00'), 'H:i:s');
    $shift1E = date_format(date_create('19:59:59'), 'H:i:s');
    $shift2S = date_format(date_create('20:00:00'), 'H:i:s');
    $shift2ME = date_format(date_create('23:59:59'), 'H:i:s');
    $shift2MS = date_format(date_create('00:00:00'), 'H:i:s');
    $shift2E = date_format(date_create('07:59:59'), 'H:i:s');

    #echo "Old Date = " . sprintf('%04d', $dateY) . '-' . sprintf('%02d', $datem) . '-' . sprintf('%02d', $dated) . "; time = $time\n";
    if ($time >= $shift1S && $time <= $shift1E) {
        //This is Shift 1
        $date = sprintf('%04d', $dateY) . '-' . sprintf('%02d', $datem) . '-' . sprintf('%02d', $dated);
        $shift = "shift1";
    } else {
        $shift = 'shift2';
        #if ($time >= $shift2S && $time <= $shift2ME) {
        //Shift 2 of current date
        $date = sprintf('%04d', $dateY) . '-' . sprintf('%02d', $datem) . '-' . sprintf('%02d', $dated);
        #} elseif ($time >= $shift2MS && $time <= $shift2E) {
        //Shift 2 of previous date
        #    if ($datem == 1 && $dated == 1) {
        #        $datem = 12;
        #        $dated = 31;
        #    }
        #    $date = sprintf('%04d', $dateY) . '-' . sprintf('%02d', $datem) . '-' . sprintf('%02d', $dated);
        #}
    }
    $qr = "SELECT * FROM kpitimetable WHERE date = '$date'";
    #echo "Date = $date; time = $time\n";
    #echo "qr = $qr\n";
    $objSQL = new SQL($qr);
    $result = $objSQL->getResultOneRowArray();
    if (!empty($result)) {
        $shiftVal = $result[$shift];
        #if ($shiftVal == 1) {
        #    $kpiVal = 9.8;
        #} elseif ($shiftVal == 0) {
        #    $kpiVal = 7.35;
        #}
        #return $kpiVal;
        return $shiftVal;
    } else {
        return 'empty';
    }
}

function get_kpiTimeTableDetailsByShift($shift, $date) {
    $qr = "SELECT * FROM kpitimetable WHERE date = '$date'";
    $objSQL = new SQL($qr);
    $result = $objSQL->getResultOneRowArray();
    if (!empty($result)) {
        $shift_stat = $result['shift' . $shift];
        return $shift_stat;
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
    } else {
        $timecheck = '';
    }
    if ($summType == 'daily') {
        $qr = "SELECT * FROM $table "
                . "WHERE poid IS NOT NULL AND jlfor = 'CJ' "
                #. "AND NOT jobtype ='cncmachining' "
                #. "AND NOT jobtype = 'precisiongrinding' "
                . "AND NOT jobtype = 'roughgrinding' AND staffid = '$staffid' "
                . "AND mcid = $mcid AND DATE_FORMAT(start_time,'%Y %m %d') = DATE_FORMAT('$date','%Y %m %d') "
                . $timecheck
                #. "AND machineid NOT LIKE 'CNC%' AND machineid NOT LIKE 'SGG%' "
                . "AND machineid NOT LIKE 'RGG%'"
                . "ORDER BY dateofcompletion, staffid, mcid ASC";
    } elseif ($summType == 'all') {
        $qr = "SELECT * FROM $table "
                . "WHERE poid IS NOT NULL AND jlfor = 'CJ' "
                #. "AND NOT jobtype ='cncmachining' "
                #. "AND NOT jobtype = 'precisiongrinding' "
                . "AND NOT jobtype = 'roughgrinding' AND staffid = '$staffid' "
                . "AND mcid = $mcid AND DATE_FORMAT(start_time,'%Y %m') = DATE_FORMAT('$date','%Y %m') "
                . $timecheck
                #. "AND machineid NOT LIKE 'CNC%' AND machineid NOT LIKE 'SGG%' "
                . "AND machineid NOT LIKE 'RGG%'"
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
    } else {
        $timecheck = '';
    }
    if ($summType == 'daily') {
        $qr = "SELECT DISTINCT mcid,machineid FROM $table WHERE poid IS NOT NULL AND jlfor = 'CJ'"
                #. " AND NOT jobtype ='cncmachining' "
                #. "AND NOT jobtype = 'precisiongrinding' "
                . "AND NOT jobtype = 'roughgrinding' "
                . "AND staffid = '$staffid' "
                . "AND DATE_FORMAT(start_time,'%Y %m %d') = DATE_FORMAT('$date','%Y %m %d')"
                . "$timecheck "
                #. "AND machineid NOT LIKE 'CNC%' AND machineid NOT LIKE 'SGG%' "
                . "AND machineid NOT LIKE 'RGG%' AND machineid NOT LIKE 'CNC%'"
                . "OR machineid = 'CNC02' OR machineid = 'CNC01'"
                . " ORDER BY mcid ASC";
    } elseif ($summType == 'all') {
        $qr = "SELECT DISTINCT mcid,machineid FROM $table WHERE poid IS NOT NULL AND jlfor = 'CJ' "
                #. "AND NOT jobtype ='cncmachining' "
                #. "AND NOT jobtype = 'precisiongrinding' "
                . "AND NOT jobtype = 'roughgrinding' "
                . "AND staffid = '$staffid' "
                . "AND DATE_FORMAT(start_time,'%Y %m') = DATE_FORMAT('$date','%Y %m') "
                . "$timecheck "
                #. "AND machineid NOT LIKE 'CNC%' AND machineid NOT LIKE 'SGG%' "
                . "AND machineid NOT LIKE 'RGG%' AND machineid NOT LIKE 'CNC%'"
                . "OR machineid = 'CNC02' OR machineid = 'CNC01'"
                . " ORDER BY mcid ASC";
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
        $qr = "SELECT DISTINCT mcid,machineid FROM $table WHERE poid IS NOT NULL AND jlfor = 'CJ' "
                #. "AND NOT jobtype ='cncmachining' "
                #. "AND NOT jobtype = 'precisiongrinding' "
                . "AND NOT jobtype = 'roughgrinding' AND DATE_FORMAT(start_time,'%Y %m %d') = DATE_FORMAT('$date','%Y %m %d') ORDER BY mcid ASC"
                #. "AND machineid NOT LIKE 'CNC%' AND machineid NOT LIKE 'SGG%' "
                . "AND machineid NOT LIKE 'RGG%'";
    } elseif ($summType == 'all') {
        $qr = "SELECT DISTINCT mcid,machineid FROM $table WHERE poid IS NOT NULL AND jlfor = 'CJ' "
                #. "AND NOT jobtype ='cncmachining' "
                #. "AND NOT jobtype = 'precisiongrinding' "
                . "AND NOT jobtype = 'roughgrinding' AND DATE_FORMAT(start_time,'%Y %m') = DATE_FORMAT('$date','%Y %m') ORDER BY mcid ASC"
                #. "AND machineid NOT LIKE 'CNC%' AND machineid NOT LIKE 'SGG%' "
                . "AND machineid NOT LIKE 'RGG%'";
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
        $qr = "SELECT DISTINCT staffid FROM $table WHERE poid IS NOT NULL AND mcid = $mcid AND jlfor = 'CJ' "
                #. "AND NOT jobtype ='cncmachining' "
                #. "AND NOT jobtype = 'precisiongrinding' "
                . "AND NOT jobtype = 'roughgrinding' AND DATE_FORMAT(start_time,'%Y %m %d') = DATE_FORMAT('$date','%Y %m %d')"
                #. "AND machineid NOT LIKE 'CNC%' AND machineid NOT LIKE 'SGG%' "
                . "AND machineid NOT LIKE 'RGG%'";
    } elseif ($summType == 'all') {
        $qr = "SELECT DISTINCT staffid FROM $table WHERE poid IS NOT NULL AND mcid = $mcid AND jlfor = 'CJ' "
                #. "AND NOT jobtype ='cncmachining' "
                #. "AND NOT jobtype = 'precisiongrinding' "
                . "AND NOT jobtype = 'roughgrinding' AND DATE_FORMAT(start_time,'%Y %m') = DATE_FORMAT('$date','%Y %m')"
                #. "AND machineid NOT LIKE 'CNC%' AND machineid NOT LIKE 'SGG%' "
                . "AND machineid NOT LIKE 'RGG%'";
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
    } else {
        $timecheck = '';
    }

    if ($summType == 'daily') {
        $qr = "SELECT DISTINCT staffid FROM $table "
                . "WHERE poid IS NOT NULL AND jlfor = 'CJ' "
                #. "AND NOT jobtype ='cncmachining' "
                #. "AND NOT jobtype = 'precisiongrinding' "
                . "AND NOT jobtype = 'roughgrinding' "
                . "AND DATE_FORMAT(start_time,'%Y %m %d') = DATE_FORMAT('$date','%Y %m %d')"
                . "$timecheck"
                #. "AND machineid NOT LIKE 'CNC%' AND machineid NOT LIKE 'SGG%' "
                . "AND machineid NOT LIKE 'RGG%'";
    } elseif ($summType == 'all') {
        $qr = "SELECT DISTINCT staffid FROM $table "
                . "WHERE poid IS NOT NULL AND jlfor = 'CJ' "
                #. "AND NOT jobtype ='cncmachining' "
                #. "AND NOT jobtype = 'precisiongrinding' "
                . "AND NOT jobtype = 'roughgrinding' "
                . "AND DATE_FORMAT(start_time,'%Y %m') = DATE_FORMAT('$date','%Y %m')"
                . "$timecheck"
                #. "AND machineid NOT LIKE 'CNC%' AND machineid NOT LIKE 'SGG%' "
                . "AND machineid NOT LIKE 'RGG%'";
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

function get_intervalDateArray($date_start, $date_end, $index, $indexLimit) {
    #$index = 1;
    $dateLimit = 10;
    $beginAdd = ((int) $index * (int) $dateLimit);
    $beginAdd = $beginAdd . ' days';
    $endAdd = ((int) $beginAdd + (int) $dateLimit);
    $endAdd = $endAdd . ' days';
    #echo "endAdd = $endAdd\n";
    if ($index == $indexLimit) {
        $begin = new DateTime($date_start);
        date_add($begin, date_interval_create_from_date_string($beginAdd));
        $end = new DateTime($date_end);
        date_add($end, date_interval_create_from_date_string('1 days'));
    } else {
        $begin = new DateTime($date_start);
        date_add($begin, date_interval_create_from_date_string($beginAdd));
        $end = new DateTime($date_start);
        date_add($end, date_interval_create_from_date_string($endAdd));
    }

    $interval = DateInterval::createFromDateString('1 day');
    $period = new DatePeriod($begin, $interval, $end);
    $date_array = array();
    foreach ($period as $dt) {
        #echo $dt->format("Y-m-d\n");
        $date_array[] = $dt->format("Y-m-d");
    }
    return $date_array;
}

switch ($action) {
    case 'getYear':
        $objDate = new GenerateDateArray();
        $year = $objDate->generateYearArray();
        echo json_encode($year);
        break;
    case 'getMonth':
        $year = $received_data->year;
        $objDate = new GenerateDateArray();
        $month = $objDate->generateMonthArray($year);
        echo json_encode($month);
        break;
    case 'getDay' :
        $year = $received_data->year;
        $month = $received_data->month;
        #echo "year = $year; month = $month\n";
        $objDate = new GenerateDateArray();
        $day = $objDate->generateDayArray($year, $month);
        echo json_encode($day);
        break;
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
    case'getStaffData':
        $staffid = $received_data->staffid;
        $staffDetails = get_staffDetails($staffid);
        if (!empty($staffDetails)) {
            $staffname = $staffDetails['name'];
            echo json_encode(array('status' => 'ok', 'msg' => $staffname));
        } else {
            echo json_encode(array('status' => 'error', 'msg' => 'Cannot find Staff Name !'));
        }
        break;
    case 'getMachineData':
        $machineid = $received_data->machineid;
        $qr = "SELECT * FROM machine WHERE machineid = '$machineid'";
        $objSQL = new SQL($qr);
        $result = $objSQL->getResultOneRowArray();
        if (!empty($result)) {
            $mcid = $result['mcid'];
            $machinename = $result['name'];
            $machinemodel = $result['model'];
            $machineno = $result['machine_no'];
            $resArr = array(
                'status' => 'ok',
                'mcid' => $mcid,
                'machinename' => $machinename,
                'machinemodel' => $machinemodel,
                'machineno' => $machineno
            );
        } else {
            $resArr = Array(
                'status' => 'error',
                'msg' => 'Cannot find Machine Details for machineid = ' . $machineid
            );
        }
        echo json_encode($resArr);
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
            $shift = 'all';
            $staffList = get_distinctStaff($kpidetailstable, $date, $summType, $shift);
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
                $machineList = get_distinctMachine($kpidetailstable, $date, $summType, $staffid, $shift);
                #print_r($machineList);
                #echo "\n";
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
                        $machine_capacity_per_hour = $mcDetail['index_per_hour'];
                        $machine_capacity_per_shift = $machine_capacity_per_hour * 8;
                    } else {
                        $machine_name = null;
                        $machine_model = null;
                        $machine_capacity_per_hour = null;
                        $machine_capacity_per_shift = null;
                    }
                    $filteredDetails = get_filteredDetails($kpidetailstable, $date, $summType, $staffid, $mcid, $shift);
                    if ($filteredDetails != 'empty') {
                        //begin calculate kpi (based on staffid and mcid
                        $sum_deltaOutWMachine = array();
                        $output_weight_sum = 0;
                        #$det_kpi_row = array();
                        $cnt = 0;
                        foreach ($filteredDetails as $data_row) {
                            $cnt++;
                            $jd_qty = $data_row['totalquantity'];
                            $unit_weight = $data_row['unit_weight'];
                            $start_time = $data_row['start_time'];
                            $start_date = date_format(date_create($start_time), 'Y-m-d');
                            $end_time = $data_row['end_time'];
                            if ($jd_qty) {
                                $output_weight = $jd_qty * $unit_weight;
                            } else {
                                $output_weight = 0;
                            }
                            //fetch current KPI
                            #$kpiVal = get_kpiTimeTableDetails($start_time);
                            #echo "kpiVal = $kpiVal<br>";
                            #$index_gain_sum = $index_gain_sum + ($unit_gain_kg * $kpiVal);
                            $shiftVal = get_kpiTimeTableDetails($start_time);
                            #echo "rmrate = $RMRate\n";
                            #echo $staffid.$machineid;
                            $output_weight_sum += $output_weight;
                            if (isset($sum_deltaOutWMachine[$start_date][$shiftVal])) {
                                # echo "old = ".$sum_deltaOutWMachine[$start_date][$shiftVal];
                                # echo "added by $output_weight";
                                $sum_deltaOutWMachine[$start_date][$shiftVal] += $output_weight;
                                # echo "result = ".$sum_deltaOutWMachine[$start_date][$shiftVal];
                            } else {
                                $sum_deltaOutWMachine[$start_date][$shiftVal] = $output_weight;
                            }
                        }
                        $sum_total_kpi = 0;
                        foreach ($sum_deltaOutWMachine as $date_detail) {
                            #echo "test";
                            foreach ($date_detail as $key => $val) {
                                if ($machine_capacity_per_shift) {
                                    if ($key == 1) {
                                        $total_kpi = ($val - $machine_capacity_per_shift) / $machine_capacity_per_shift * 9.8;
                                    } elseif ($key == 0) {
                                        $total_kpi = ($val) / $machine_capacity_per_shift * 7.35;
                                    } else {
                                        $total_kpi = 0;
                                    }
                                    #$total_kpi = round(($sum_deltaOutWMachine / $machine_capacity_per_shift), 2);
                                    #echo 'rmrate ='.$RMRate;
                                } else {
                                    $total_kpi = 0;
                                }
                                if ($total_kpi < 0) {
                                    $total_kpi = 0;
                                }
                                $sum_total_kpi += $total_kpi;
                            }
                        }

                        #echo $staffid.$machineid;
                        #print_r($sum_deltaOutWMachine);
                        #echo "totalkpi = $sum_total_kpi";
                        //create array of the current sum
                        $det_kpi_row[] = array(
                            'machineid' => $machineid,
                            'machinename' => $machine_name,
                            'machinemodel' => $machine_model,
                            'weight_gain' => number_format(round($output_weight_sum, 2), 2),
                            'machine_index_per_shift' => $machine_capacity_per_shift,
                            #'value_gain_normal' => number_format(round($total_kpi_normal, 2), 2),
                            #'value_gain_overtime' => number_format(round($total_kpi_overtime, 2), 2),
                            'total_value_gain(RM)' => number_format(round($sum_total_kpi, 2), 2),
                                #'data_found' => $cnt
                        );
                        //push this to det_KPI array
                    } else {
                        #echo"can't find data for staffname = $staffname and machineid = $machineid#";
                    }
                }
                if (isset($det_kpi_row)) {
                    $det_KPI[] = array(
                        'staffid' => $staffid,
                        'staffname' => $staffname,
                        'details' => $det_kpi_row
                    );
                    unset($det_kpi_row);
                }
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
                                            $unit_gain_kg = $unit_weight * $totalquantity;
                                        } else {
                                            $unit_gain_kg = 0;
                                        }
                                        $inv_Nu_KPI = $unit_gain_kg / $rand_index_per_shift * 9.8;
                                        //slide in the individual value into data_row;
                                        $offset = 12;
                                        $data_row['unit_gain_kg'] = $unit_gain_kg;
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
                                $sum_index_gain += $detail_row['unit_gain_kg'];
                                $sum_KPI += $detail_row['individual_kpi'];
                            }
                            $det_KPI[] = array(
                                'machinename' => $machinename,
                                'weight_gain' => number_format(round($sum_index_gain, 2), 2),
                                'estimated_totalkpi' => number_format(round($sum_KPI, 7), 7),
                                    #'data_found' => $totaldata
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
    case 'summaryKPISimpleDetails':
        $period = $received_data->period;
        $staffid = $received_data->staffid;
        $machineid = $received_data->machineid;
        $staffDetails = get_staffDetails($staffid);
        $cntDataShift = 0;
        $rlTkpi = 0;
        $weight[0] = 0;
        $weight[1] = 0;
        if ($staffDetails != 'empty') {
            $staffname = $staffDetails['name'];
        } else {
            $staffname = null;
        }
        $qr = "SELECT * FROM machine WHERE machineid = '$machineid'";
        $objSQL = new SQL($qr);
        $result = $objSQL->getResultOneRowArray();
        if (!empty($result)) {
            $mcid = $result['mcid'];
        } else {
            echo json_encode('Cannot Find Data, Machineid Invalid');
            break;
        }


        $kpidetailstable = "kpidetails_$period";
        $year = '20' . substr($period, 0, 2);
        $month = substr($period, 2, 2);
        $i_day = 1;
        $date = $year . '-' . $month . '-' . $i_day;
        $totaldate = date_format(date_create($date), 't');
        for ($i = $i_day; $i <= $totaldate; $i++) {
            $day = sprintf('%02d', $i);
            $date = $year . '-' . $month . '-' . $day;
            for ($shift = 1; $shift <= 2; $shift++) {
                $shift_stat = get_kpiTimeTableDetailsByShift($shift, $date);
                try {
                    $mcDetail = get_machineDetails($mcid);
                    if ($mcDetail != 'empty') {
                        #echo "<pre>MachineLists : ";
                        #print_r($mcDetail);
                        #echo "</pre>";
                        $machine_name = $mcDetail['name'];
                        $machine_model = $mcDetail['model'];
                        $machine_capacity_per_hour = $mcDetail['index_per_hour'];
                        $machine_capacity_per_shift = $machine_capacity_per_hour * 8;
                    } else {
                        $machine_name = null;
                        $machine_model = null;
                        $machine_capacity_per_hour = null;
                        $machine_capacity_per_shift = null;
                    }
                    $filteredDetails = get_filteredDetails($kpidetailstable, $date, 'daily', $staffid, $mcid, $shift);
                    if ($filteredDetails != 'empty') {
                        //begin calculate kpi (based on staffid and mcid
                        $output_weight_sum = 0;
                        $cnt = 0;
                        foreach ($filteredDetails as $data_row) {
                            $cnt++;
                            $cntDataShift++;
                            $jd_qty = $data_row['totalquantity'];
                            $unit_weight = $data_row['unit_weight'];
                            $start_time = $data_row['start_time'];
                            $end_time = $data_row['end_time'];
                            if ($jd_qty) {
                                $output_weight = $jd_qty * $unit_weight;
                            } else {
                                $index_gain = 0;
                            }
                            $output_weight_sum += $output_weight;
                            #$det_kpi_row_details[] = $data_row;
                        }
                        if ($shift_stat == 1) {
                            $RMRate = 9.8;
                            if ($machine_capacity_per_shift) {
                                $kpi = ($output_weight_sum - $machine_capacity_per_shift) / $machine_capacity_per_shift;
                                $total_kpi = round(($kpi) * 9.8, 2);
                                #echo 'rmrate ='.$RMRate;
                            } else {
                                $kpi = 0;
                                $total_kpi = 0;
                            }
                        } elseif ($shift_stat == 0) {
                            $RMRate = 7.35;
                            if ($machine_capacity_per_shift) {
                                $kpi = $output_weight_sum / $machine_capacity_per_shift;
                                $total_kpi = round($kpi * 7.35, 2);
                                #echo 'rmrate ='.$RMRate;
                            } else {
                                $kpi = 0;
                                $total_kpi = 0;
                            }
                        }
                        if ($total_kpi < 0) {
                            $real_total_kpi = 0;
                        } else {
                            $real_total_kpi = $total_kpi;
                        }
                        # echo "1";
                        //create array of the current sum
                        #echo "Generating staffid = $staffid, machine id = $machineid<br>Found $cnt Data<br> <strong>Total KPI is $calculatedKPI.</strong><br>";
                        $det_kpi_row[] = array(
                            'Date' => date_format(date_create($date), 'd-m-Y'),
                            'Shift' => $shift,
                            'Total Weight (KG)' => round($output_weight_sum, 2),
                            'Rate (RM)' => $RMRate,
                            'KPI' => round($kpi, 2),
                            'Calculated Value by KPI (RM)' => round($total_kpi, 2),
                            'Real Value by KPI (RM)' => round($real_total_kpi, 2)
                        );
                        $weight[$shift_stat] += $output_weight_sum;
                        $rlTkpi += $real_total_kpi;
                        #unset($det_kpi_row_details);
                    } else {
                        
                    }
                } catch (Exception $ex) {
                    
                }
            }
        }
        #echo $cntDataShift . "\n";
        #echo "totalkpi = $rlTkpi\n;";
        #print_r($weight);
        echo json_encode($det_kpi_row);
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
                //get RM Rate by Shift
                $shift_stat = get_kpiTimeTableDetailsByShift($shift, $date);
                //end RM Rate by Shift

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
                                $machine_capacity_per_hour = $mcDetail['index_per_hour'];
                                $machine_capacity_per_shift = $machine_capacity_per_hour * 8;
                            } else {
                                $machine_name = null;
                                $machine_model = null;
                                $machine_capacity_per_hour = null;
                                $machine_capacity_per_shift = null;
                            }
                            $filteredDetails = get_filteredDetails($kpidetailstable, $date, 'daily', $staffid, $mcid, $shift);
                            if ($filteredDetails != 'empty') {
                                //begin calculate kpi (based on staffid and mcid
                                $output_weight_sum = 0;
                                $cnt = 0;
                                foreach ($filteredDetails as $data_row) {
                                    $cnt++;
                                    $jd_qty = $data_row['totalquantity'];
                                    $unit_weight = $data_row['unit_weight'];
                                    $start_time = $data_row['start_time'];
                                    $end_time = $data_row['end_time'];
                                    if ($jd_qty) {
                                        $output_weight = $jd_qty * $unit_weight;
                                    } else {
                                        $index_gain = 0;
                                    }
                                    $output_weight_sum += $output_weight;
                                    $det_kpi_row_details[] = $data_row;
                                }
                                if ($shift_stat == 1) {
                                    $RMRate = 9.8;
                                    if ($machine_capacity_per_shift) {
                                        $total_kpi = round((($output_weight_sum - $machine_capacity_per_shift) / $machine_capacity_per_shift) * 9.8, 2);
                                        #echo 'rmrate ='.$RMRate;
                                    } else {
                                        $total_kpi = 0;
                                    }
                                } elseif ($shift_stat == 0) {
                                    $RMRate = 7.35;
                                    if ($machine_capacity_per_shift) {
                                        $total_kpi = round(($output_weight_sum / $machine_capacity_per_shift) * 7.35, 2);
                                        #echo 'rmrate ='.$RMRate;
                                    } else {
                                        $total_kpi = 0;
                                    }
                                }
                                if ($total_kpi < 0) {
                                    $real_total_kpi = 0;
                                } else {
                                    $real_total_kpi = $total_kpi;
                                }
                                /** old procedure
                                  //fetch current KPI
                                  //$kpiVal = get_kpiTimeTableDetails($start_time);
                                  #echo "kpiVal = $kpiVal<br>";
                                  #$single_KPI = ($unit_gain_kg * $kpiVal);
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
                                 * 
                                 */
                                //create array of the current sum
                                #echo "Generating staffid = $staffid, machine id = $machineid<br>Found $cnt Data<br> <strong>Total KPI is $calculatedKPI.</strong><br>";
                                $det_kpi_row[] = array(
                                    'staffid' => $staffid,
                                    'staffname' => $staffname,
                                    'machineid' => $machineid,
                                    'machinename' => $machine_name,
                                    'machinemodel' => $machine_model,
                                    'machine_capacity_per_shift' => $machine_capacity_per_shift,
                                    'real_total_kpi' => $real_total_kpi,
                                    'totalkpi' => $total_kpi,
                                    'rm_rate' => $RMRate,
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
                    $det_KPI[$date]['shift' . $shift] = $det_kpi_row;
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
    case 'getDetailedKPIStaffInterval':
        #print_r($received_data);
        $date_start = $received_data->date_start;
        $date_end = $received_data->date_end;
        $index = (int) $received_data->index;
        $indexLimit = (int) $received_data->indexLimit;
        $date_array = get_intervalDateArray($date_start, $date_end, $index, $indexLimit);
        foreach ($date_array as $date) {
            $period = substr($date, 2, 2) . substr($date, 5, 2);
            $kpidetailstable = 'kpidetails_' . $period;
            #$day = sprintf('%02d', $i);
            #$date = $year . '-' . $month . '-' . $day;
            #echo "<h3>Processing Date '$date'</h3><br>";
            for ($shift = 1; $shift <= 2; $shift++) {
                #echo $shift;
                //get RM Rate by Shift
                $shift_stat = get_kpiTimeTableDetailsByShift($shift, $date);
                //end RM Rate by Shift

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
                                $machine_capacity_per_hour = $mcDetail['index_per_hour'];
                                $machine_capacity_per_shift = $machine_capacity_per_hour * 8;
                            } else {
                                $machine_name = null;
                                $machine_model = null;
                                $machine_capacity_per_hour = null;
                                $machine_capacity_per_shift = null;
                            }
                            $filteredDetails = get_filteredDetails($kpidetailstable, $date, 'daily', $staffid, $mcid, $shift);
                            if ($filteredDetails != 'empty') {
                                //begin calculate kpi (based on staffid and mcid
                                $output_weight_sum = 0;
                                $cnt = 0;
                                foreach ($filteredDetails as $data_row) {
                                    $cnt++;
                                    $jd_qty = $data_row['totalquantity'];
                                    $unit_weight = $data_row['unit_weight'];
                                    $start_time = $data_row['start_time'];
                                    $end_time = $data_row['end_time'];
                                    if ($jd_qty) {
                                        $output_weight = $jd_qty * $unit_weight;
                                    } else {
                                        $index_gain = 0;
                                    }
                                    $output_weight_sum += $output_weight;
                                    $offset = 14;
                                    $new_datarow = array_slice($data_row, 0, $offset, true) +
                                            array('unit gain (kg)' => $data_row['unit_gain_kg']) +
                                            array_slice($data_row, $offset, NULL, true);
                                    unset($new_datarow['unit_gain_kg']);
                                    $det_kpi_row_details[] = $new_datarow;
                                }
                                if ($shift_stat == 1) {
                                    $RMRate = 9.8;
                                    if ($machine_capacity_per_shift) {
                                        $total_kpi = round((($output_weight_sum - $machine_capacity_per_shift) / $machine_capacity_per_shift) * 9.8, 2);
                                        #echo 'rmrate ='.$RMRate;
                                    } else {
                                        $total_kpi = 0;
                                    }
                                } elseif ($shift_stat == 0) {
                                    $RMRate = 7.35;
                                    if ($machine_capacity_per_shift) {
                                        $total_kpi = round(($output_weight_sum / $machine_capacity_per_shift) * 7.35, 2);
                                        #echo 'rmrate ='.$RMRate;
                                    } else {
                                        $total_kpi = 0;
                                    }
                                }
                                if ($total_kpi < 0) {
                                    $real_total_kpi = 0;
                                } else {
                                    $real_total_kpi = $total_kpi;
                                }
                                //create array of the current sum
                                #echo "Generating staffid = $staffid, machine id = $machineid<br>Found $cnt Data<br> <strong>Total KPI is $calculatedKPI.</strong><br>";
                                $det_kpi_row[] = array(
                                    'staffid' => $staffid,
                                    'staffname' => $staffname,
                                    'machineid' => $machineid,
                                    'machinename' => $machine_name,
                                    'machinemodel' => $machine_model,
                                    'machine_capacity_per_shift' => $machine_capacity_per_shift,
                                    'real_total_kpi' => $real_total_kpi,
                                    'totalkpi' => $total_kpi,
                                    'rm_rate' => $RMRate,
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
                    $det_KPI[$date]['shift' . $shift] = $det_kpi_row;
                    unset($det_kpi_row);
                }
            }
        }
        if (!empty($det_KPI)) {
            echo json_encode($det_KPI);
        } else {
            $err_arr = array('status' => 'error', 'msg' => 'Cannot find data for period = ');
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
                    $machine_capacity_per_hour = $mcDetail['index_per_hour'];
                    $machine_capacity_per_shift = $machine_capacity_per_hour * 8;
                } else {
                    $machine_name = null;
                    $machine_model = null;
                    $machine_capacity_per_hour = null;
                    $machine_capacity_per_shift = null;
                }
                $sum_deltaOutWMachine = array();
                $output_weight_sum = 0;
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
                    $filteredDetails = get_filteredDetails($kpidetailstable, $date, $summType, $staffid, $mcid, 'all');
                    if ($filteredDetails != 'empty') {
                        //begin calculate kpi (based on staffid and mcid
                        foreach ($filteredDetails as $data_row) {
                            $cnt++;
                            $jd_qty = $data_row['totalquantity'];
                            $unit_weight = $data_row['unit_weight'];
                            $start_time = $data_row['start_time'];
                            $end_time = $data_row['end_time'];
                            if ($jd_qty) {
                                $output_weight = $jd_qty * $unit_weight;
                            } else {
                                $output_weight = 0;
                            }
                            //fetch current KPI
                            $shiftVal = get_kpiTimeTableDetails($start_time);
                            $output_weight_sum += $output_weight;
                            if (isset($sum_deltaOutWMachine[$shiftVal])) {
                                $sum_deltaOutWMachine[$shiftVal] = $sum_deltaOutWMachine[$shiftVal] + $output_weight;
                            } else {
                                $sum_deltaOutWMachine[$shiftVal] = $output_weight;
                            }
                            //slide in the individual value into data_row;
                            $offset = 12;
                            #$data_row['unit_gain_kg'] = $unit_gain_kg;
                            $new_datarow = array_slice($data_row, 0, $offset, true) +
                                    array('normal_shift' => $shiftVal) +
                                    array_slice($data_row, $offset, NULL, true);
                            $new_details[] = $new_datarow;
                        }
                        //create array of the current sum
                        #echo "Generating staffid = $staffid, machine id = $machineid<br>Found $cnt Data<br> <strong>Total KPI is $calculatedKPI.</strong><br>";
                        if (isset($new_details)) {
                            $det_kpi_row2[] = array(
                                'staffid' => $staffid,
                                'staffname' => $staffname,
                                'details' => $new_details
                            );
                        }
                        unset($new_details);
                    } else {
                        
                    }
                }
                if ($machine_capacity_per_shift) {
                    if (isset($sum_deltaOutWMachine[1])) {
                        $total_kpi_normal = ($sum_deltaOutWMachine[1] - $machine_capacity_per_shift) / $machine_capacity_per_shift * 9.8;
                    } else {
                        $total_kpi_normal = 0;
                    }
                    if (isset($sum_deltaOutWMachine[0])) {
                        $total_kpi_overtime = ($sum_deltaOutWMachine[0]) / $machine_capacity_per_shift * 7.35;
                    } else {
                        $total_kpi_overtime = 0;
                    }

                    if ($total_kpi_normal < 0) {
                        $total_kpi = round($total_kpi_overtime, 2);
                    } elseif ($total_kpi_overtime < 0) {
                        $total_kpi = round($total_kpi_normal, 2);
                    } elseif ($total_kpi_normal < 0 && $total_kpi_overtime < 0) {
                        $total_kpi = round(0, 2);
                    } else {
                        $total_kpi = round((float) $total_kpi_normal + (float) $total_kpi_overtime, 2);
                    }
                    #$total_kpi = round(($sum_deltaOutWMachine / $machine_capacity_per_shift), 2);
                    #echo 'rmrate ='.$RMRate;
                } else {
                    $total_kpi_overtime = 0;
                    $total_kpi_normal = 0;
                    $total_kpi = 0;
                }
                if (isset($det_kpi_row2)) {
                    $det_kpi_row[] = array(
                        'machineid' => $machineid,
                        'machinename' => $machine_name,
                        'machinemodel' => $machine_model,
                        'index_per_shift' => $machine_capacity_per_shift,
                        'kpi_normal' => $total_kpi_normal,
                        'kpi_overtime' => $total_kpi_overtime,
                        'totalkpi' => $total_kpi,
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
                            $unit_gain_kg = $unit_weight * $totalquantity;
                        } else {
                            $unit_gain_kg = 0;
                        }
                        $inv_Nu_KPI = $unit_gain_kg / $rand_index_per_shift * 9.8;
                        //slide in the individual value into data_row;
                        $offset = 12;
                        $data_row['unit_gain_kg'] = $unit_gain_kg;
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

