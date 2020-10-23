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
        <div id='mainArea'>
            <form action='' method='POST'>
                <div> <!--period area-->
                    Period :
                    <select v-model='period' id='period' name='period' @change="summType=''">
                        <option v-for='data in periodList' v-bind:value='data'>{{data}}</option>
                    </select>
                </div>
                <div v-if='period!= ""'><!--summary monthly/daily area-->
                    Summary Type :
                    <select v-model='summType' id='summType' name='summType' @change='day = ""'>
                        <option value='all'>Monthly</option>
                        <option value='daily'>Daily</option>
                    </select>
                </div>
                <div v-if='summType == "daily"'><!-- date selection -->
                    Date :
                    <select v-model="day" id="day" name="day">
                        <option v-for="data in dayList" v-bind:value="data">{{data}}</option>
                    </select>
                    <button type="button" @click="getDetailedKPIStaff" >Submit</button>
                </div>
                <div v-else-if='summType != "daily" && summType!=""'>
                    Date :
                    <input type='text' id='day' name='day' value='Show All' readonly/>
                    <button type="button" @click="getDetailedKPIStaff" >Submit</button>
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
                <div v-else-if='!loading'>
                    <div v-if="detKPI != '' && status == 'ok'">
                        <div style='text-align:center'>
                            <b style='font-size:2em'>KPI INDEX DAILY DETAILS REPORT</b><br>
                            <b style='font-size:1.5em'>DATE = <span v-if='summType == "daily"'>{{day}}-</span>{{month}}-{{year}}</b><br>
                            <b style='font-size:1.5em'><button type='button' @click='changeShift()'>Current Shift : {{shift}}</button></b><br>
                        </DIV>
                        <div v-for='(data,date) in detKPI[shift]'>
                            {{date}}
                            <template v-for='datarow in data'>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style='width:25%'>({{datarow.staffid}}) - {{datarow.staffname}}</th>
                                            <th>({{datarow.machinename}}) - {{datarow.machinemodel}}</th>
                                            <th>&nbsp;</th> 
                                            <th style='width:25%'>Index Capacity Per Shift : {{datarow.index_per_shift}}</th>
                                        </tr>
                                    </thead>
                                </table>
                                <table class='table table-bordered table-responsive'>
                                    <thead>
                                        <tr>
                                            <th v-for='(data,index) in datarow.details[0]'>
                                                {{index}}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for='details in datarow.details'>
                                            <th v-for='(data, index) in details' >
                                                {{data}}
                                            </th>
                                        </tr>
                                        <tr>
                                            <td colspan="10" style="text-align:right"><b>Sum of Unit Weight :</b></td>
                                            <td><b>{{sum_unit_weight(datarow.details)}}</b></td>
                                        </tr>
                                        <tr>
                                            <td colspan="11" style="text-align:right"><b>Sum of Total Weight :</b></td>
                                            <td><b>{{sum_total_weight(datarow.details)}}</b></td>
                                        </tr>
                                        <tr>
                                            <td colspan="12" style="text-align:right"><b>Sum of Individual KPI :</b></td>
                                            <td><b>{{sum_inv_kpi(datarow.details)}}</b></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table style="width:auto">
                                    <tr>
                                        <td colspan="2" style="width:auto;"><b>
                                                Total Value Gain (RM) : {{toFixed(datarow.totalkpi,7)}}
                                            </b>
                                        </td>
                                        <td colspan="2" style="width:auto;">
                                            &nbsp;
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="width:auto"><b>
                                                Result by Program Calculation
                                            </b>
                                        </td>
                                        <td colspan="2" style="width:auto;">
                                            &nbsp;
                                        </td>
                                    </tr>
                                </table>
                            </template>
                            <div>
                                <hr>
                            </div>
                        </div>
                    </div>
                    <div v-else-if="status == 'error'">
                        {{errmsg}}
                    </div>

                </div>
                <?php
                ?>

                <?php

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
        summType: '',
        day: '',
        loading: false,
        status: '',
        errmsg: '',
        shift: 'shift1',

        periodList: '',
        dayList: '',
        kpiList: '',
        detKPI: ''
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
        summType: function () {
            if (this.summType === 'daily') {
                this.getDayList();
            }
        },
        detKPI: function () {
            if (this.detKPI.status == 'error') {
                this.status = 'error';
                this.errmsg = this.detKPI.msg;
            } else {
                this.status = 'ok';
            }
        }
    },
    methods: {
        changeShift: function (){
            if (this.shift === 'shift1'){
                this.shift = 'shift2';
            }else{
                this.shift = 'shift1';
            }
        },
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
        getDetailedKPIStaff: function () {
            this.loading = true;
            axios.post(this.phpajaxresponsefile, {
                action: 'getDetailedKPIStaff',
                period: sumKPIVue.period,
                summType: sumKPIVue.summType,
                day: sumKPIVue.day
            }).then(function (response) {
                console.log('on getDetailedKPIStaff..');
                console.log(response.data);
                sumKPIVue.detKPI = response.data;
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
                sum += parseFloat(data[i].individual_kpi);
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
