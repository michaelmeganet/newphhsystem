<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
        <title></title>
    </head>
    <body>
        <h2>SUMMARY KPI - UNFINISHED JOBLISTS</h2>
        <div id='mainArea'>
            <form action='' method='POST'>
                <div> <!--period area-->
                    Period :
                    <select v-model='period' id='period' name='period'>
                        <option v-for='data in periodList' v-bind:value='data'>{{data}}</option>
                    </select>
                </div>
                <div> <!--Virtual Machine Area-->
                    Process Name :
                    <select v-model='processname' id='processname' name='processname' @change="getVirtualMachineName()">
                        <option v-for='data in processNames' v-bind:value='data'>{{data}}</option>
                    </select>
                    <button type="button" @click="getDetailedKPIUnfin">Submit</button>
                </div>
            </form>
            <br>
            <br>
            <div>
                <div v-if ='loading' class='text-center align-middle'>
                    <h3>Loading Data...</h3>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                    </div>
                </div>
                <div v-else-if="!loading">
                    <div v-if='kpiList != "" && status == "ok"'>
                        <table>
                            <thead>
                                <tr>
                                    <th>Machine Name :</th>
                                    <th>{{VMName}}</th>
                                </tr>
                            </thead>
                        </table>
                        <div style='height:350px;overflow-y: scroll'>
                            <table class="table table-bordered table-responsive">
                                <thead>
                                    <tr>
                                        <th v-for="(detail,index) in kpiList[0]">{{index}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="data in kpiList">
                                        <td v-for="detail in data">{{detail}}</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="10" style="text-align:right"><b>Sum of Unit Weight :</b></td>
                                        <td><b>{{toFixed(sum_unit_weight(kpiList),2)}}</b></td>
                                    </tr>
                                    <tr>
                                        <td colspan="11" style="text-align:right"><b>Sum of Total Weight :</b></td>
                                        <td><b>{{toFixed(sum_total_weight(kpiList),2)}}</b></td>
                                    </tr>
                                    <tr>
                                        <td colspan="12" style="text-align:right"><b>Sum of Individual KPI :</b></td>
                                        <td><b>{{toFixed(sum_inv_kpi(kpiList),7)}}</b></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style='width:20%'>Total KPI :</th>
                                    <th>{{toFixed(sum_inv_kpi(kpiList),7)}}</th>
                                </tr>
                            </thead>
                        </table>
                        <br>
                        <br>
                    </div>
                    <div v-else-if='status == "error"'>
                        {{errmsg}}
                    </div>
                    
                </div>

                

                <?php
            

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

            function get_filteredDetails($table, $date, $summType, $staffid, $mcid) {
                #if ($summType == 'daily') {
                $qr = "SELECT * FROM $table "
                        . "WHERE poid IS NOT NULL AND jlfor = 'CJ' AND NOT jobtype ='cncmach' AND staffid = '$staffid' "
                        . "AND mcid = $mcid AND DATE_FORMAT(dateofcompletion,'%Y %m %d') = DATE_FORMAT('$date','%Y %m %d') "
                        . "ORDER BY dateofcompletion, staffid, mcid ASC";
                /* } elseif ($summType == 'all') {
                  $qr = "SELECT * FROM $table "
                  . "WHERE poid IS NOT NULL AND jlfor = 'CJ' AND NOT jobtype ='cncmach' AND staffid = '$staffid' "
                  . "AND mcid = $mcid AND DATE_FORMAT(dateofcompletion,'%Y %m') = DATE_FORMAT('$date','%Y %m') "
                  . "ORDER BY dateofcompletion, staffid, mcid ASC";
                  } */
                $objSQL = new SQL($qr);
                $result = $objSQL->getResultRowArray();
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

            function get_distinctMachine($table, $date, $summType, $staffid) {
                #if ($summType == 'daily') {
                $qr = "SELECT DISTINCT mcid,machineid FROM $table WHERE poid IS NOT NULL AND jlfor = 'CJ' AND NOT jobtype ='cncmach' AND staffid = '$staffid' AND DATE_FORMAT(dateofcompletion,'%Y %m %d') = DATE_FORMAT('$date','%Y %m %d') ORDER BY mcid ASC";
                /* } elseif ($summType == 'all') {
                  $qr = "SELECT DISTINCT mcid,machineid FROM $table WHERE poid IS NOT NULL AND jlfor = 'CJ' AND NOT jobtype ='cncmach' AND staffid = '$staffid' AND DATE_FORMAT(dateofcompletion,'%Y %m') = DATE_FORMAT('$date','%Y %m') ORDER BY mcid ASC";
                  } */
                $objSQL = new SQL($qr);
                $result = $objSQL->getResultRowArray();
                if (!empty($result)) {
                    return $result;
                } else {
                    return 'empty';
                }
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

            function get_distinctStaff($table, $date, $summType) {
                #if ($summType == 'daily') {
                $qr = "SELECT DISTINCT staffid FROM $table WHERE poid IS NOT NULL AND jlfor = 'CJ' AND NOT jobtype ='cncmach' AND DATE_FORMAT(dateofcompletion,'%Y %m %d') = DATE_FORMAT('$date','%Y %m %d')";
                /* } elseif ($summType == 'all') {
                  $qr = "SELECT DISTINCT staffid FROM $table WHERE poid IS NOT NULL AND jlfor = 'CJ' AND NOT jobtype ='cncmach' AND DATE_FORMAT(dateofcompletion,'%Y %m') = DATE_FORMAT('$date','%Y %m')";
                  } */
                $objSQL = new SQL($qr);
                $result = $objSQL->getResultRowArray();
                if (!empty($result)) {
                    return $result;
                } else {
                    return 'empty';
                }
            }
            ?>
        </div>
    </div>
    <script>
var sumKPIVue = new Vue({
    el: '#mainArea',
    data: {
        phpajaxresponsefile: './kpi-index/summarykpi.axios.php',
        period: '',
        loading: false,
        processname: '',
        VMName: '',
        status: '',
        errmsg: '',

        periodList: '',
        dayList: '',
        kpiList: '',
        processNames: ['cncmachining', 'bandsaw', 'manual', 'milling', 'millingwidth', 'millinglength', 'roughgrinding', 'precisiongrinding']

    },
    computed: {
        year: function () {
            if (this.period !== '') {
                return '20' + this.period.substring(0, 2);
            }
        },
        month: function () {
            if (this.period !== '') {
                return this.period.substring(2, 4);
            }
        }
    },
    watch: {
        kpiList: function () {
            if (this.kpiList.status == 'error') {
                this.status = 'error';
                this.errmsg = this.kpiList.msg;
            } else {
                this.status = 'ok';
            }
        }
        
    },
    methods: {
        toUpperCase: function (str) {
            return str.toUpperCase();
        },
        toFixed: function (str, decimal) {
            return str.toFixed(decimal);
        },
        getPeriod: function () {
            axios.post(this.phpajaxresponsefile, {
                action: 'getPeriod'
            }).then(function (response) {
                console.log('on getPeriod....');
                console.log(response.data);
                sumKPIVue.periodList = response.data;
            });
        },
        getDayList: function () {
            axios.post(this.phpajaxresponsefile, {
                action: 'getDayList',
                period: sumKPIVue.period
            }).then(function (response) {
                console.log('on getDayList');
                console.log(response.data);
                sumKPIVue.dayList = response.data;
            });
        },
        getVirtualMachineName: function () {
            axios.post(this.phpajaxresponsefile, {
                action: 'getVirtualMachineName',
                processname: sumKPIVue.processname
            }).then(function (response) {
                console.log('on getVirtualMachineName');
                console.log(response.data);
                sumKPIVue.VMName = response.data;
            });
        },
        getDetailedKPIUnfin: function () {
            this.loading = true;
            axios.post(this.phpajaxresponsefile, {
                action: 'getDetailedKPIUnfin',
                period: sumKPIVue.period,
                processname: sumKPIVue.processname
            }).then(function (response) {
                console.log('on getDetailedKPIUnfin');
                console.log(response.data);
                sumKPIVue.kpiList = response.data;
                sumKPIVue.loading = false;
            });
        },
        sum_total_weight: function (data) {
            sum = 0;
            for (i = 0; i < data.length; i++) {
                sum += parseFloat(data[i].total_weight);
            }
            return(sum);
        },
        sum_unit_weight: function (data) {
            sum = 0;
            for (i = 0; i < data.length; i++) {
                sum += parseFloat(data[i].unit_weight);
            }
            return(sum);

        },
        sum_inv_kpi: function (data) {
            sum = 0;
            for (i = 0; i < data.length; i++) {
                sum += parseFloat(data[i].estimated_individual_kpi);
            }
            return(sum);

        }
    },
    mounted: function () {
        this.getPeriod();
    }
});
    </script>
</body>
</html>
