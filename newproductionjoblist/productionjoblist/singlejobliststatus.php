<?php
// require_once("include/session.php");
include_once("include/admin_check.php");
include_once("includes/input_modechange.php");

if (isset($_GET['jobcode']) && isset($_GET['period']) && isset($_GET['staffid'])) {
    $jobcode = $_GET['jobcode'];
    $period = $_GET['period'];
    $staffid = $_GET['staffid'];
    #$_SESSION['sj_staffid'] = $_GET['staffid'];
    #echo "jobcode = $jobcode<br>\n";
    echo "staffid = $staffid<br>\n";
    #echo "period  = $period<br>\n";
}
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->


<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src='https://cdn.jsdelivr.net/npm/vue/dist/vue.js'></script>
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
        <style>
            a:link{
                color: red;
                text-decoration: none;
            }
            a:visited{
                color: pink;
                text-decoration:none;
            }
            a:hover{
                color: blue;
                text-decoration:underline;
            }
            a:active{
                color: yellow;
                text-decoration:underline;
            }
        </style>
    </head>
    <body>
        <script language="javascript" type="text/javascript" src="productionjoblist/ajax_getAll.js"></script>
        <script language="javascript" type="text/javascript" src="productionjoblist/autodate.js"></script>
        <input type="hidden" id="input_mode" value="<?php echo $getPage; ?>" />
        <table width="100%" cellspacing="0" cellpadding="2" border="0">
            <tr>
                <td>SINGLE JOBLIST STATUS - <b><?php echo $pageMode; ?></b></td>
            </tr>
            <tr>
                <td><button onclick="window.location.href = '<?php echo $link; ?>'">Change Mode (current :<?php echo $pageMode; ?>)</button>
            </tr>
        </table>

        <br /><br />

        <table width="100%" cellspacing="0" cellpadding="2" border="0">
            <tr>
                <td>
                    <div id='mainArea'>
                        <input type="hidden"  id="jobcode" value ="<?php echo(isset($jobcode)) ? $jobcode : ''; ?>"/>
                        <input type='hidden'  id="period"  value ='<?php echo(isset($period)) ? $period : ""; ?>'/> 
                        <input type='hidden'  id="staffid"  value ='<?php echo(isset($staffid)) ? $staffid : ""; ?>'/> 
                        <div>
                            <div>
                                Select Period:
                                <select v-model='period' id='period' name='period'>
                                    <option v-for='data in periodList' v-bind:value='data'>{{data}}</option>
                                </select>
                            </div>
                            <br>
                            <table>
                                <tbody>
                                    <tr>
                                        <td>
                                            Job Code :<br>
                                            <input type="text" v-model="jobcode" id="jobcodev" name="jobcodev" value="" v-on:keyup.enter="parseJobCode();"/>
                                            <button type='button' @click='parseJobCode();'>Refresh</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="1">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="1">
                                            <span style="color:greenyellow" v-if='jobcodeParse !== "error"'>{{jobcodeParse}}</span>
                                            <span style="color:red" v-else-if='jobcodeParse === "error"'>There's error in Job Code.<br> Please check the format, or contact administrator.</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top">
                                            <div v-if='schDetail != ""' style="color:yellow">
                                                <table style='color:yellow'>
                                                    <tr>
                                                        <td>Quantity</td>       <td>:</td> <td>{{schDetail.quantity}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Cutting Type</td>   <td>:</td> <td>{{schDetail.cuttingtype}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Process Code</td>   <td>:</td> <td>{{schDetail.processcode}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Finish Date</td>    <td>:</td> <td>{{schDetail.dateofcompletion}}</td>
                                                    </tr>
                                                </table>
                                                &nbsp;<br>
                                                <span v-if="jobworkStatusText == 'This joblist has been Ended Properly'" style='color:green'>{{jobworkStatusText}}</span>
                                                <span v-else-if="jobworkStatusText != 'This joblist has been Ended Properly'" style='color:red'>{{jobworkStatusText}}</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            &nbsp;<br>
                            <br>
                            <div v-if="jobWorkDetail != ''">
                                <table>
                                    <thead>
                                        <tr>
                                            <th style='border:1px;border-style:solid;padding:5px 3px 5px 3px'>Process</th>
                                            <th style='border:1px;border-style:solid;padding:5px 3px 5px 3px'>Status</th>
                                            <th style='border:1px;border-style:solid;padding:5px 3px 5px 3px'>Action</th>
                                            <th style='border:1px;border-style:solid;padding:5px 3px 5px 3px'>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for='row in jobWorkDetail'>

                                            <td style='border:1px;border-style:solid;padding:5px 3px 5px 3px'>{{row.process}}</td>
                                            <td style='border:1px;border-style:solid;padding:5px 3px 5px 3px'>{{row.status}}</td>
                                            <td style='border:1px;border-style:solid;padding:5px 3px 5px 3px' v-if     ='row.process!=="Job Take" && row.status!=="Finished"'><a style="link" href="#" @click='openUpdateProcess(row.process,row.status,jobcodeParse,staffid)'>UPDATE</a></td>
                                            <td style='border:1px;border-style:solid;padding:5px 3px 5px 3px' v-else-if='row.process!=="Job Take" && row.status =="Finished"'><span style='color:white' >No Action</span></td>
                                            <td style='border:1px;border-style:solid;padding:5px 3px 5px 3px' v-else-if='row.process =="Job Take"'></td>
                                            <td style='border:1px;border-style:solid;padding:5px 3px 5px 3px'>{{getStatusDescription(row.process,row.status)}}</td>
                                            <td v-if="checkProcess(row.process)"><button type="button" @click="addBandsaw(jobcodeParse)">Add Bandsaw</button>(Only use this if there's need to do Bandsaw Process!!)</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <br>
                            <div v-if='outDetail != ""'>
                                Output Process Detail :
                                <table>
                                    <thead>
                                        <tr>
                                            <th style='border:1px;border-style:solid;padding:5px 3px 5px 3px' v-for="keys in outDetailKeys">{{keys}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="row in outDetail">
                                            <td style='border:1px;border-style:solid;padding:5px 3px 5px 3px' v-for="data in row">{{data}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <br>

                    </div>
                </td>
            </tr>
        </table>
        <script>
            window.onload = function () {
                var input = document.getElementById('jobcodev').focus();
            };
            var vueJApp = new Vue({
                el: '#mainArea',
                data: {
                    phpajaxresponsefile: 'backend/joblisttaskreport.axios.php',
                    period: '',
                    jobcode: '',
                    jobcodeParse: '',
                    staffid: '',
                    periodList: '',
                    schDetail: '',
                    outDetail: '',
                    jobWorkDetail: '',
                    jobworkStatusText: ''
                },
                computed: {
                    outDetailKeys: function () {
                        if (this.outDetail !== '') {
                            keys = Object.keys(this.outDetail[0]);
                            console.log('extracting keys of outDetail :');
                            console.log(keys);
                            return keys;
                        }
                    }
                },
                watch: {
                    chkInput: function () {
                        if (this.chkInput) {
                            console.log('input ok!');
                        } else {
                            console.log('input fail');
                        }
                    },
                    jobcodeParse: function () {
                        if (this.period !== '' && this.jobcode !== '' && this.jobcodeParse !== '' && this.jobcodeParse !== 'error') {
                            console.log('All data has been inputed\n Fetch jobworklist detail');
                            this.getSchdDetail();
                            //this.getJobWorkDetail();
                        } else {
                            this.schDetail = '';
                            this.jobWorkDetail = '';
                            this.outDetail = '';
                        }
                    },
                    schDetail: function () {
                        if (this.schDetail != '') {
                            this.getJobWorkDetail();
                        }
                    }

                },
                methods: {
                    addBandsaw: function (jobcode) {
                        axios.post(this.phpajaxresponsefile, {
                            action: 'addBandsaw',
                            jobcode: jobcode
                        }).then(function (response) {
                            console.log('on addBandsaw');
                            console.log(response.data);
                        }).then(function(){
                           vueJApp.parseJobCode(); 
                        });
                    },
                    checkProcess: function (process) {
                        if (process === 'Manual') {
                            jwDetail = this.jobWorkDetail;
                            filteredJW = jwDetail.filter(d => d.process === 'Bandsaw');
                            console.log('on checkProcess');
                            console.log(filteredJW);
                            if (filteredJW.length === 0) {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    },
                    getPeriodList: function () {
                        axios.post(this.phpajaxresponsefile, {
                            action: 'getPeriodList'
                        }).then(function (response) {
                            console.log('in getPeriodList...');
                            console.log(response.data);
                            vueJApp.periodList = response.data;
                        });
                    },
                    parseJobCode: function () {
                        this.jobcodeParse = '';
                        axios.post(this.phpajaxresponsefile, {
                            action: 'parseJobCode',
                            jobcode: vueJApp.jobcode
                        }).then(function (response) {
                            console.log('in parseJobCode...');
                            console.log(response.data);
                            vueJApp.jobcodeParse = response.data;
                        });
                    },
                    getSchdDetail: function () {
                        axios.post(this.phpajaxresponsefile, {
                            action: 'getSchdDetail',
                            period: vueJApp.period,
                            jobcode: vueJApp.jobcodeParse
                        }).then(function (response) {
                            console.log('in getSchdDetail...');
                            console.log(response.data);
                            vueJApp.schDetail = response.data;
                        }).then(function () {
                            vueJApp.getOutputDetail();
                        });
                    },
                    getOutputDetail: function () {
                        sid = this.schDetail.sid;
                        console.log('sid = ' + sid);
                        axios.post(this.phpajaxresponsefile, {
                            action: 'getOutputDetail',
                            period: vueJApp.period,
                            sid: sid
                        }).then(function (response) {
                            console.log('in getOutputDetail');
                            console.log(response.data);
                            vueJApp.outDetail = response.data;
                        });
                    },
                    getJobWorkDetail: function () {
                        axios.post(this.phpajaxresponsefile, {
                            action: 'getJobWorkDetail',
                            period: vueJApp.period,
                            jobcode: vueJApp.jobcodeParse
                        }).then(function (response) {
                            console.log('in getJobWorkDetail...');
                            console.log(response.data);
                            vueJApp.jobWorkDetail = response.data;
                        }).then(function () {
                            vueJApp.getJobworkStatusText();
                        });
                    },
                    getJobworkStatusText: function () {
                        console.log('in jobworkstatustext....');
                        dateofcompletion = this.schDetail.dateofcompletion;
                        console.log('dateofcompletion = ' + dateofcompletion);
                        jobworkDtl = this.jobWorkDetail;
                        console.log('length = ' + jobworkDtl.length);
                        processCount = jobworkDtl.length;
                        statusFinCount = 0;
                        info = '';
                        console.log(jobworkDtl);
                        for (var k in jobworkDtl) {
                            dat = jobworkDtl[k];
                            datValues = dat.status;

                            datKeys = dat.process;
                            if (datKeys === 'Job Take') {
                                processCount = processCount - 1;

                            }
                            if (datKeys !== 'Job Take' && datValues !== 'Finished') {

                                console.log('this is not finished yet');
                                break;
                            } else if (datKeys !== 'Job Take' && datValues === 'Finished') {

                                console.log('this is finished');
                                statusFinCount++;
                            }
                        }
                        console.log('processCount = ' + processCount + '\nstatusFinCount = ' + statusFinCount);
                        if (statusFinCount == processCount && dateofcompletion !== null) {
                            console.log('This joblist has been Ended Properly');
                            this.jobworkStatusText = 'This joblist has been Ended Properly';
                        } else if (statusFinCount != processCount && dateofcompletion !== null) {
                            console.log('This joblist has been Ended Without scanned end on several processes!');
                            this.jobworkStatusText = 'This joblist has been Ended Without scanned end on several processes!';
                        } else if (statusFinCount != processCount && dateofcompletion === null) {
                            console.log('This joblist is not yet finished');
                            this.jobworkStatusText = 'This joblist is not yet finished';
                        } else if (statusFinCount == processCount && dateofcompletion === null) {
                            console.log('This joblist process is finished, Can be job ended properly!');
                            this.jobworkStatusText = 'This joblist process is finished, Can be job ended properly!';
                        }
                    },
                    openUpdateProcess: function (p, s, jcid, stid) {
                        process = p.toLowerCase();
                        status = s.toLowerCase();
                        if (stid !== '') {
                            jlstaffid = 'jlstaffid=' + encodeURIComponent(stid);
                        } else {
                            jlstaffid = '';
                        }
                        jljobcode = 'jljobcode=' + encodeURIComponent(jcid);
                        console.log('process = ' + process + '\nstatus = ' + status);
                        //begin making the url
                        url = 'index.php?';
                        switch (process) {
                            case 'bandsaw':
                                view = 'view=bw';
                                break;
                            case 'cncmachining':
                                view = 'view=cm';
                                break;
                            case 'manual':
                                view = 'view=mc';
                                break;
                            case 'milling':
                                view = 'view=mg';
                                break;
                            case 'millingwidth':
                                view = 'view=mw';
                                break;
                            case 'millinglength':
                                view = 'view=ml';
                                break;
                            case 'roughgrinding':
                                view = 'view=rg';
                                break;
                            case 'precisiongrinding':
                                view = 'view=pg';
                                break;
                        }
                        switch (status) {
                            case 'partial':
                                view += 's';
                                break;
                            case 'on-progress':
                                view += 'e';
                                break;
                            case 'not started':
                                view += 's';
                                break;
                        }
                        scan = 'page=scan';
                        url += view + '&' + scan + '&' + jlstaffid + '&' + jljobcode;
                        console.log('Open url = ' + url);
                        window.open(url, '_blank');
                    },
                    getStatusDescription: function (process, status) {
                        info = '';
                        console.log('process = ' + process + '\n status = ' + status);
                        switch (process) {
                            case 'Job Take':
                                switch (status) {
                                    case 'Taken':
                                        info = 'Joblist started by Admin';
                                        break;
                                    case 'Not Yet Taken':
                                        info = 'Joblist not yet started by Admin, please Contact Admin';
                                        break;
                                }
                                break;
                            default:
                                switch (status) {
                                    case 'Finished':
                                        info = 'Process has been ended';
                                        break;
                                    case 'Partial':
                                        info = 'Quantity not all finished.';
                                        break;
                                    case 'On-Progress':
                                        info = 'Joblist has been started, not yet ended';
                                        break;
                                    case 'Not Started':
                                        info = 'Process is not yet started';
                                        break;
                                }
                                break;
                        }
                        return info;
                    },
                    getHiddenInputs: function () {
                        this.jobcode = document.getElementById('jobcode').value;
                        this.period = document.getElementById('period').value;
                        this.staffid = document.getElementById('staffid').value;
                    }
                },
                mounted: function () {
                    this.getPeriodList();
                    this.getHiddenInputs();
                }
            });
        </script>
    </body>
</html>
