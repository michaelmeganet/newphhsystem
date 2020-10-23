<?php
include_once("include/mysql_connect.php");
//require_once("include/session.php");
include_once("include/admin_check.php");
include_once("includes/input_modechange.php");
session_start();

//cProductionJoblist('bandsawcutstart');
if (isset($_GET['jlstaffid'])) {
    $jlstaffid = $_GET['jlstaffid'];
}
if (isset($_GET['jljobcode'])) {
    $jljobcode = $_GET['jljobcode'];
}
$aid = 19;

$sqladmin = "SELECT * FROM admin WHERE aid = $aid";
$resultadmin = $rundb->Query($sqladmin);
$rowadmin = $rundb->FetchArray($resultadmin);

$branch = $rowadmin['branch'];
?>

<input type="hidden" id="input_mode" value="<?php echo $getPage; ?>" />
<div id='mainArea'>
    <table width="100%" cellspacing="0" cellpadding="2" border="1" style='text-align:left;vertical-align:middle'>
        <tr>
            <td width="49%" valign="top">PRODUCTION JOBLIST - NEW JOBLIST SCAN - <b><?php echo $pageMode; ?></b></td>
            <td width="2%">&nbsp;</td>
            <td width="49%" class="mmfont" valign="top">ကုန္ထုတ္လုပ္မႈအလုပ္စာရင္း - NEW JOBLIST SCAN - <b><?php echo $pageMode; ?></b></td>
        </tr>
        <tr>
            <td><button onclick="window.location.href = '<?php echo $link; ?>'">Change Mode (current :<?php echo $pageMode; ?>)</button>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <table width="100%" cellspacing="0" cellpadding="2" border="0">
                    <tr>
                        <td width='30%'><label>Staff ID : </label></td>
                        <td width='30%'><input type='text' v-model='staffid' id='staffid' name='staffid' v-on:keyup.enter='clearData();getStaffName()'/></td>
                        <td v-html='staff_response'>{{staff_response}}</td>
                    </tr>
                    <tr>
                        <td><label>Job Code : </label></td>
                        <td><input type='text' v-model='jobcode' id='jobcode' name='jobcode' v-on:keyup.enter='clearData();parseJobCode()' /></td>
                        <td v-html='jobcode_response'>{{jobcode_response}}</td>
                    </tr>
                    <tr>
                        <td colspan='2'>
                            <label>Process Name = {{schedulingDetail.processname}}</label><br>
                            <label>Cutting Type = {{schedulingDetail.cuttingtype}}</label><br>
                            <label>Quantity Need= {{schedulingDetail.quantity}}</label>
                        </td>
                    </tr>
                </table>
            </td>
            <td style='text-align:left;vertical-align:middle'>
                <table border='1' v-if='jobworkDetail != ""'>
                    <tr>
                        <th>Process Name</th>
                        <th>Job Status</th>
                    </tr>
                    <tr v-for='index in jobworkDetail'>
                        <td>{{index.process}}</td>
                        <td>{{index.status}}</td>
                        <!--<td><input type='radio' v-model='proc' v-bind:value='processname' /></td>-->
                    </tr>

                </table>
            </td>
        </tr>
        <tr><!--Breadcrumbs Area-->
            <td>
                <ul style='list-style: none;display: inline'>
                    <li style='display: inline'>Test</li>
                    <li style='display: inline' >Test</li>
                </ul>
            </td>
        </tr>
        <tr><!--Scan Area -->
            <td>
                <div v-show="proc_status == 'start'">
                    this is {{proc}} start process 
                    <table border="0">
                        <tr>
                            <td>Machine ID</td>
                            <td>: <input ref='machineid' type="text" v-model='machineid' name="machineid" id="machineid" maxlength="5" style="width:200px"
                                         v-on:keyup.enter='getMachineName()'/></td>
                            <td><!-- Show Machine Name here, or show Error if nothing found -->
                                <div id="machineid_data" v-if='machine_response.indexOf("Cannot") >= 0'><span style="color:red">{{machine_response}}</span></div>
                                <div id="machineid_data" v-else><span style="color:yellow">{{machine_response}}</span></div>
                            </td>
                        </tr>
                        <tr>
                            <td>Total Quantity</td>
                            <td>: <input type="text" v-model='totalquantity' name="totalquantity" id="totalquantity" maxlength="5" style="width:200px"
                                         readonly/></td>
                        </tr>
                        <tr>
                            <td>Remaining Quantity</td>
                            <td>: <input type="text" v-model='remainingquantity' name="remainingquantity" id="remainingquantity" maxlength="5" style="width:200px"
                                         readonly/></td>
                        </tr>
                        <tr>
                            <td>Quantity</td>
                            <td>: <input type="text" v-model='quantity' name="quantity" id="quantity" maxlength="5" style="width:200px"
                                         v-on:keyup.enter='getJobUpdate()'/>
                            </td>
                            <td><font style='color:red'>{{quantity_response}}</font></td>
                        </tr>
                        <tr>
                            <td colspan="3" v-html="scan_response">{{scan_response}}</td>
                        </tr>
                    </table>
                </div>
                <div v-show="proc_status == 'end'">
                    this is {{proc}} end process<br><br>
                    <font style='color:#1067c7'>Elapsed Time since Job Started : {{elapsedTime}}</font><br><br>
                    <table border="0">
                        <tr>
                            <td>Please scan the jobcode once more, to end this job.</td>
                            <td>: <input type="text" v-model='quantity' name="quantity" id="quantity" maxlength="5" style="width:200px"
                                         v-on:keyup.enter=''/>
                            </td>
                            <td><font style='color:red'>{{quantity_response}}</font></td>
                        </tr>
                        <tr>
                            <td colspan="3" v-html="scan_response">{{scan_response}}</td>
                        </tr>
                    </table>
                </div>
                <div v-show="proc_status == '' && proc == 'All Finished'">
                    Jobcode {{jobcode}} has already done process<br>
                    Contact Administrator if this is an error.
                </div>
                <div v-show='proc_status == "" && proc == ""'>
                    Please Scan a Job Code Above.
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <table border="1">
                    <thead>
                        <tr>
                            <th v-for="(data,index) in outputDetail[0]">{{index}}</th>                            
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="rows in outputDetail">
                            <td v-for="data in rows">{{data}}</td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
</div>
<script>
    //var elapsedTimer = null;
    var scanVue = new Vue({
        el: '#mainArea',
        data: {
            phpajaxresponsefile: 'backend/newjoblistscan.axios.php',
            staffid: '',
            staff_response: '',
            staff_response_stats: '',
            jobcode: '',
            parsedJobCode: '',
            jobcode_response: '',
            jobcode_response_stats: '',
            jobworkDetail: '',
            jobworkStatus: '',
            schedulingDetail: '',
            outputDetail: '',
            proc: '',
            proc_status: '',
            machineid: '',
            machine_response: '',
            quantity: '',
            quantity_response: '',
            totalquantity: '',
            scan_response: '',
            date_start: '',
            elapsedTimer: null,
            elapsedTime: ''
        },
        computed: {
            remainingquantity: function () {
                len = this.outputDetail.length;
                for (i = 0; i < len; i++) {
                    data = this.outputDetail[i];
                    if (data.jobtype === this.proc) {

                        //if (this.quantity == 0 || this.quantity == '') {
                        return data.remainingquantity;
                        //} else {
                        //    return parseFloat(data.remainingquantity) - parseFloat(this.quantity);
                        //}
                    }
                }
                //if (this.quantity == 0 || this.quantity == '') {
                return this.totalquantity;
                //} else {
                //    return parseFloat(this.totalquantity) - parseFloat(this.quantity);
                //}
            }
        },
        watch: {
            staff_response: function () {
                if (this.staff_response_stats === 'error') {
                    this.staffid = '';
                    document.getElementById('staffid').focus();
                } else {
                    document.getElementById('jobcode').focus();
                }
            },
            jobcode_response: function () {
                if (this.jobcode_response_stats === 'error') {
                    this.jobcode = '';
                    document.getElementById('jobcode').focus();
                } else {
                    document.getElementById('machineid').focus();
                    this.getJobWorkList();
                    this.jobcode = '';
                }
            },
            quantity: function () {
                if (this.machineid !== '') {
                    remqty = this.remainingquantity;
                    if (parseFloat(this.quantity) <= 0) {
                        this.quantity_response = 'Quantity cannot be less than or same as zero';
                        //this.quantity = '';
                    } else if (parseFloat(this.quantity) > remqty) {
                        console.log('remqty = ' + remqty);
                        this.quantity_response = 'Quantity cannot be more than remaining quantity';
                        //this.quantity = '';
                    } else {
                        this.quantity_response = '';
                    }
                } else {
                    this.$refs.machineid.focus();
                    this.quantity = '';
                    this.machine_response = 'Please input Machineid';
                }
            },
            machine_response: function () {
                if (this.machine_response.indexOf('Cannot') >= 0) {
                    this.machineid = '';
                    document.getElementById('machineid').focus();
                } else {
                    document.getElementById('quantity').focus();
                }
            },
            date_start: function () {
                if (this.date_start != '') {
                    clearInterval(this.elapsedTimer);
                    this.elapsedTime = '';
                    this.createElapsedTimer();
                }
            }

        },
        methods: {
            getElapsedTime: function () {
                chTime = new Date(this.date_start);
                crTime = new Date();
                diffTime = Math.abs(crTime - chTime);
                var hour = Math.floor(diffTime / (1000 * 60 * 60));
                var minute = Math.floor((diffTime - (hour * 1000 * 60 * 60)) / (1000 * 60));
                var second = Math.floor((diffTime - (hour * 1000 * 60 * 60) - (minute * 1000 * 60)) / (1000));
                this.elapsedTime = hour + 'hours, ' + minute + ' minutes, ' + second + ' seconds';
            },
            createElapsedTimer: function () {
                this.elapsedTimer = setInterval(this.getElapsedTime, 100);
            },
            getDateStart: function () {
                if (this.proc_status === 'end') {
                    len = this.outputDetail.length;
                    for (i = 0; i < len; i++) {
                        data = this.outputDetail[i];
                        if (data.jobtype === this.proc) {
                            this.date_start = data.date_start;
                            return;
                        }
                    }
                }
            },
            getJobUpdate: function () {
                if (this.proc_status === 'end') {
                    quantity = null;
                    machineid = null;
                } else {
                    quantity = this.quantity;
                    machineid = this.machineid;
                }
                if (this.quantity_response == '') {
                    axios.post(this.phpajaxresponsefile, {
                        action: 'getJobUpdate',
                        proc: scanVue.proc,
                        proc_status: scanVue.proc_status,
                        jobcode: scanVue.parsedJobCode,
                        staffid: scanVue.staffid,
                        machineid: machineid,
                        quantity: quantity
                    }).then(function (response) {
                        console.log('on getJobUpdate');
                        console.log(response.data);
                        scanVue.scan_response = response.data.msg;
                    });
                } else {
                    this.scan_response = 'Cannot Start, ' + this.quantity_response;
                }
            },
            getProcessName: function (pmid) {
                axios.post(this.phpajaxresponsefile, {
                    action: 'getProcessName',
                    pmid: pmid
                }).then(function (response) {
                    console.log('on getProcessname..');
                    console.log(response.data);
                    return response.data;
                });
            },
            selectProcess: function () {
                len = this.jobworkDetail.length;
                for (i = 0; i < len; i++) {
                    process = this.jobworkDetail[i].process.toLowerCase();
                    status = this.jobworkDetail[i].status.toLowerCase();
                    console.log('process = ' + process + ' \nstatus: ' + status);
                    if (status === 'not started') {
                        this.proc = process;
                        this.proc_status = 'start';
                        return;
                    } else if (status === 'on-progress') {
                        this.proc = process;
                        this.proc_status = 'end';
                        return;
                    }
                }
                for (j = 0; j < len; j++) {
                    process = this.jobworkDetail[j].process.toLowerCase();
                    status = this.jobworkDetail[j].status.toLowerCase();
                    console.log('process = ' + process + ' \nstatus: ' + status);
                    if (status === 'partial') {
                        this.proc = process;
                        this.proc_status = 'start';
                        return;
                    } else if (status === 'on-progress') {
                        this.proc = process;
                        this.proc_status = 'end';
                        return;
                    }
                }
                this.proc = 'All Finished';
                this.proc_status = '';
                return;
            },

            getStaffName: function () {
                axios.post(this.phpajaxresponsefile, {
                    action: 'getStaffName',
                    staffid: scanVue.staffid
                }).then(function (response) {
                    console.log('on getStaffName..');
                    console.log(response.data);
                    scanVue.staff_response = response.data.msg;
                    scanVue.staff_response_stats = response.data.status;
                });
            },
            getMachineName: function () {
                axios.post(this.phpajaxresponsefile, {
                    action: 'getMachineName',
                    machineid: scanVue.machineid,
                    proc: scanVue.proc
                }).then(function (response) {
                    console.log('on getMachineName');
                    console.log(response.data);
                    scanVue.machine_response = response.data;
                });
            },
            parseJobCode: function () {
                axios.post(this.phpajaxresponsefile, {
                    action: 'parseJobCode',
                    jobcode: scanVue.jobcode
                }).then(function (response) {
                    console.log('on parseJobCode');
                    console.log(response.data);
                    scanVue.jobcode_response_stats = response.data.status;
                    if (response.data.status === 'error') {
                        scanVue.jobcode_response = '<font style="color:red">' + response.data.msg + "</font>";
                    } else {
                        scanVue.parsedJobCode = response.data.msg;
                        scanVue.jobcode_response = '<font style="color:yellow">' + response.data.msg + "</font>";

                    }
                })
            },
            getJobWorkList: function () {
                axios.post(this.phpajaxresponsefile, {
                    action: 'getJobWorkList',
                    jobcode: scanVue.parsedJobCode
                }).then(function (response) {
                    console.log('on getJobWorkList.');
                    console.log(response.data);
                    scanVue.jobWorkStatus = response.data.status;
                    if (response.data.status === 'ok') {
                        scanVue.jobworkDetail = response.data.jobworkDetail;
                        scanVue.jobworkStatus = response.data.jobworkStatus;
                        scanVue.schedulingDetail = response.data.schDetail;
                        scanVue.outputDetail = response.data.outDetail;
                        scanVue.totalquantity = response.data.schDetail.quantity;
                    } else {
                    }
                }).then(function () {
                    scanVue.selectProcess();
                    scanVue.getDateStart();
                });
            },
            clearData: function () {
                this.jobcode_response = '';
                this.jobcode_response_stats = '';
                this.jobworkDetail = '';
                this.jobworkStatus = '';
                this.schedulingDetail = '';
                this.outputDetail = '';
                this.proc = '';
                this.proc_status = '';
                this.machineid = '';
                this.machine_response = '';
                this.quantity = '';
                this.quantity_response = '';
                this.totalquantity = '';
                this.scan_response = '';
                this.date_start = '';
                clearInterval(this.elapsedTimer);
            }
        },
        beforeMount: function () {

        },
        mounted: function () {

        }
    });
</script>
<!--
<script src='productionjoblist/scan_StartProc.js'>
</script>