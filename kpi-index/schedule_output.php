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
        <script src="./assets/jquery-2.1.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

    </head>
    <body>
        <div id="mainArea">
            <div>
                <div class='row'>
                    <div class='col-md-4'>
                        <div class='row'>
                            <div class='col-md'>
                                <label class='control-label' style='margin: 4px 0px 4px 0px;vertical-align: middle'>&nbsp;</label>
                            </div>
                            <div class='col-md'>
                                <label class='control-label' style='margin: 4px 0px 4px 0px;vertical-align: middle'>&nbsp;</label>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md'>
                                <label class='control-label' style='margin: 4px 0px 4px 0px;vertical-align: middle'>Select Period : </label>
                            </div>
                            <div class='col-md'>
                                <select class='custom-select' id="period" name='period' v-model='period'>
                                    <option v-for='data in periodList' v-bind:value='data'>{{data}}</option>
                                </select>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md'>
                                <label class='control-label' style='margin: 4px 0px 4px 0px;vertical-align: middle'>Is Manual?      : </label>
                            </div>
                            <div class='col-md'>
                                <select class='custom-select' id="manual" name="manual" v-model="manual"  @change=''>
                                    <option value="yes">Yes</option>
                                    <option value="no">No </option>
                                </select>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md'>
                                <label class='control-label' style='margin: 4px 0px 4px 0px;vertical-align: middle'>Status      : </label>
                            </div>
                            <div class='col-md'>
                                <select class='custom-select' id="status" name="status" v-model="status"  @change='getAllJobList()'>
                                    <option value="active">Active Jobs</option>
                                    <option value="billing">Billing Jobs</option>
                                    <option value="cancelled">Cancelled Jobs</option>
                                </select>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md'>
                                <label class='control-label' style='margin: 4px 0px 4px 0px;vertical-align: middle'>Job Type: </label>
                            </div>
                            <div class='col-md'>
                                <select class='custom-select' id="jobfintype" name="jobfintype" v-model="jobfintype">
                                    <option value="unfinished">Un-Finished Jobs</option>
                                    <option value="finished">Finished Jobs</option>
                                </select>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md'>
                                <button class='btn btn-primary btn-block' id='refData' name='refData' @click='getAllJobList()' v-if='period != "" && status != "" && jobfintype != "" ' >Refresh Data</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class='row'>
                            <div class='col-md-7'>
                                <div v-if='jobfintype == "unfinished"'>
                                    <label class='control-label' style='margin: 4px 0px 4px 0px;vertical-align: middle'>List of Unfinished Jobs :</label>
                                    <select class='custom-select' name ="unfinJob" id="unfinJob" v-model="unfinJob" size="10" @change='getUnFinJobListDetails();getUnFinJobOutput();'>
                                        <option v-for="data in unfinJobList" v-bind:value="data.sid">{{data.sid}} || {{data.jobcode}}</option>
                                    </select>
                                    <label class='control-label' style='margin: 4px 0px 4px 0px;vertical-align: middle'>Selected : {{unfinJob}}</label>
                                </div>
                                <div v-if='jobfintype == "finished"'>
                                    <label class='control-label' style='margin: 4px 0px 4px 0px;vertical-align: middle'>List of finished Jobs :<br></label>
                                    <select class='custom-select' name ="finJob" id="finJob" v-model="finJob" size="10" @change='getFinJobListDetails();getFinJobOutput()'>
                                        <option v-for="data in finJobList" v-bind:value="data.sid">{{data.sid}} || {{data.jobcode}}</option></label>
                                    </select>
                                    <label class='control-label' style='margin: 4px 0px 4px 0px;vertical-align: middle'>Selected : {{finJob}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>     
                <div class="row col-md">
                    <label class="control-label label label-success" style="padding:6px 4px 6px 4px;background-color:green;color:white;border-radius:3px">Report : {{finJobInfo}} </label>  
                </div>
                <div class="row">
                    <div class='col-md'>
                        <div v-if='jobfintype == "unfinished"'>
                            <div>
                                <label class='control-label'>Scheduling Details :</label><br>
                                <div v-if="unfinJobListDetail == '' && unfinJob != ''">
                                    Cannot find details, does job actually exists?
                                </div>
                                <div v-if='unfinJobListDetail != "" && unfinJob != ""'>
                                    <div>
                                        <table class="table table-bordered table-responsive text-center align-middle">
                                            <thead >
                                                <tr >
                                                    <th  rowspan="2">SID</th>
                                                    <th  rowspan="2">BID</th>
                                                    <th  rowspan="2">QID</th>
                                                    <th  rowspan="2">Quono</th>
                                                    <th  rowspan="2">CID</th>
                                                    <th  rowspan="2">Quantity</th>
                                                    <th  rowspan="2">Grade</th>
                                                    <th  colspan="7">Dimensions</th>
                                                    <th  rowspan="2">Process</th>
                                                    <th  rowspan="2">Cutting Type</th>
                                                    <th  rowspan="2">No. Position</th>
                                                    <th  rowspan="2">Issue Date</th>
                                                    <th  rowspan="2">JL For</th>
                                                    <th  rowspan="2">Status</th>
                                                    <th  rowspan="2">Date of Completion</th>
                                                </tr>
                                                <tr>
                                                    <th >MDT</th>
                                                    <th >MDW</th>
                                                    <th >MDL</th>
                                                    <th ></th>
                                                    <th >FDT</th>
                                                    <th >FDW</th>
                                                    <th >FDL</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for='data in unfinJobListDetail'>                                
                                                    <td >{{data.sid}}</td>
                                                    <td >{{data.bid}}</td>
                                                    <td >{{data.qid}}</td>
                                                    <td >{{data.quono}}</td>
                                                    <td >{{data.cid}}</td>
                                                    <td >{{data.quantity}}</td>
                                                    <td >{{data.grade}}</td>
                                                    <td >{{data.mdt}}</td>
                                                    <td >{{data.mdw}}</td>
                                                    <td >{{data.mdl}}</td>
                                                    <td ></td>
                                                    <td >{{data.fdt}}</td>
                                                    <td >{{data.fdw}}</td>
                                                    <td >{{data.fdl}}</td>
                                                    <td >{{data.processname}}</td>
                                                    <td >{{data.cuttingtype}}</td>
                                                    <td >{{data.noposition}}</td>
                                                    <td >{{data.date_issue}}</td>
                                                    <td >{{data.jlfor}}</td>
                                                    <td >{{data.status}}</td>
                                                    <td >{{data.dateofcompletion}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if='jobfintype == "finished"'>
                            <div>
                                Scheduling Details :<br>
                                <div v-if="finJobListDetail == '' && finJob != ''">
                                    Cannot find details, does job actually exists?
                                </div>
                                <div v-if='finJobListDetail != "" && finJob != ""'>
                                    <div>
                                        <table class="table table-bordered table-responsive text-center align-middle">
                                            <thead >
                                                <tr >
                                                    <th  rowspan="2">SID</th>
                                                    <th  rowspan="2">BID</th>
                                                    <th  rowspan="2">QID</th>
                                                    <th  rowspan="2">Quono</th>
                                                    <th  rowspan="2">CID</th>
                                                    <th  rowspan="2">Quantity</th>
                                                    <th  rowspan="2">Grade</th>
                                                    <th  colspan="7">Dimensions</th>
                                                    <th  rowspan="2">Process</th>
                                                    <th  rowspan="2">Cutting Type</th>
                                                    <th  rowspan="2">No. Position</th>
                                                    <th  rowspan="2">Issue Date</th>
                                                    <th  rowspan="2">JL For</th>
                                                    <th  rowspan="2">Status</th>
                                                    <th  rowspan="2">Date of Completion</th>
                                                </tr>
                                                <tr>
                                                    <th >MDT</th>
                                                    <th >MDW</th>
                                                    <th >MDL</th>
                                                    <th ></th>
                                                    <th >FDT</th>
                                                    <th >FDW</th>
                                                    <th >FDL</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for='data in finJobListDetail'>                                
                                                    <td >{{data.sid}}</td>
                                                    <td >{{data.bid}}</td>
                                                    <td >{{data.qid}}</td>
                                                    <td >{{data.quono}}</td>
                                                    <td >{{data.cid}}</td>
                                                    <td >{{data.quantity}}</td>
                                                    <td >{{data.grade}}</td>
                                                    <td >{{data.mdt}}</td>
                                                    <td >{{data.mdw}}</td>
                                                    <td >{{data.mdl}}</td>
                                                    <td ></td>
                                                    <td >{{data.fdt}}</td>
                                                    <td >{{data.fdw}}</td>
                                                    <td >{{data.fdl}}</td>
                                                    <td >{{data.processname}}</td>
                                                    <td >{{data.cuttingtype}}</td>
                                                    <td >{{data.noposition}}</td>
                                                    <td >{{data.date_issue}}</td>
                                                    <td >{{data.jlfor}}</td>
                                                    <td >{{data.status}}</td>
                                                    <td >{{data.dateofcompletion}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md'>
                        <div v-if='jobfintype == "unfinished"'>
                            <label class='control-lable'>Output Log :</label>
                            <div v-if="unfinJobListOutput == 'empty' && unfinJob != ''">
                                Cannot find log, is job has been started?
                            </div>
                            <div v-if='unfinJobListOutput !="empty" && unfinJob != ""'>
                                <table class="table table-bordered table-responsive" >
                                    <thead>
                                        <tr>
                                            <th >POID</th>
                                            <th >SID</th>
                                            <th >Job Type</th>
                                            <th >Start Date</th>
                                            <th >Start By</th>
                                            <th >Machine</th>
                                            <th >End Date</th>
                                            <th >End By</th>
                                            <th >Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for='data in unfinJobListOutput'>
                                            <td  v-for='rows in data'>{{rows}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div v-if='jobfintype == "finished"'>
                            Output Log :
                            <div v-if="finJobListOutput == 'empty' && finJob != ''">
                                Cannot find log, is job has been started?
                            </div>
                            <div v-if='finJobListOutput !="empty" && finJob != ""'>
                                <table class="table table-bordered table-responsive" >
                                    <thead>
                                        <tr>
                                            <th >POID</th>
                                            <th >SID</th>
                                            <th >Job Type</th>
                                            <th >Start Date</th>
                                            <th >Start By</th>
                                            <th >Machine</th>
                                            <th >End Date</th>
                                            <th >End By</th>
                                            <th >Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for='data in finJobListOutput'>
                                            <td  v-for='rows in data'>{{rows}}</td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md'>
                        <br>
                        <div v-if='jobfintype == "unfinished"'>
                            <div v-if='unfinJobListDetail != ""' v-for="det in unfinJobListDetail">
                                <label class='label label-info'>Cutting Type : {{det.cuttingtype}}</label><br>
                                <label>Process Code : {{det.processname}}</label>
                                <table class="table table-responsive" >
                                    <thead>
                                        <tr>
                                            <th>Job Work Detail :</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <template v-for="rowArr in JobWorkDetail">
                                        <tr v-for="(val,index) in rowArr">
                                            <td>{{index}}</td>
                                            <td>:</td>
                                            <td>{{val}}</td>
                                        </tr>
                                    </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div v-if='jobfintype == "finished"'>
                            <div v-if='finJobListDetail != ""' v-for="det in finJobListDetail">
                                <label>Cutting Type : {{det.cuttingtype}}</label><br>
                                <label>Process Code : {{det.processname}}</label>
                                <table class="table table-responsive" >
                                    <thead>
                                        <tr>
                                            <th>Job Work Detail :</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <template v-for="rowArr in JobWorkDetail">
                                        <tr v-for="(val,index) in rowArr">
                                            <td>{{index}}</td>
                                            <td>:</td>
                                            <td>{{val}}</td>
                                        </tr>
                                    </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
        <script>
var schOutVue = new Vue({
    el: '#mainArea',
    data: {
        phpajaxresponsefile: 'kpi-index/productionlog.axios.php',

//selection variables
        period: '',
        manual: '',
        status: '',
        jobfintype: '',
        unfinJob: '',
        finJob: '',
        finJobInfo: '',

//lists variable
        periodList: '',
        unfinJobList: '',
        finJobList: '',
        unfinJobListDetail: '',
        finJobListDetail: '',
        unfinJobListOutput: '',
        finJobListOutput: '',
        JobWorkDetail: ''
    },
    watch: {
    },
    filters: {
        subStr: function (string, startpos, endpos) {
            return string.substring(startpos, endpos);
        },
        padStr: function (string, padNum) {
            var s = string + "";
            while (string.length < padNum)
                s = "0" + s;
            return s;
        }
    },
    methods: {
        getPeriod: function () {
            axios.post(this.phpajaxresponsefile, {
                action: 'getPeriod' // var_dump object(stdClass)#1 (1) {  ["action"]=>   string(9) "getPeriod"
            }).then(function (response) {
                console.log('onGetPeriod Function....');
                console.log(response.data);
                schOutVue.periodList = response.data;
            });
        },
        getJobWorkDetail: function (jobListDetail, jobListOutput) {
            axios.post(this.phpajaxresponsefile, {
                action: 'getJobWorkDetail',
                jobListDetail: jobListDetail,
                jobListOutput: jobListOutput
            }).then(function (response) {
                console.log('on getJobWorkDetail function....');
                console.log(response.data);
                schOutVue.JobWorkDetail = response.data;
            });
        },
        getAllJobList: function () {
            this.getUnFinJobList();
            this.getFinJobList();
        },
        getUnFinJobList: function () {
            let period = this.period;
            let status = this.status;
            let manual = this.manual;
            axios.post(this.phpajaxresponsefile, {
                action: 'getUnFinJobList',
                period: period,
                status: status,
                manual: manual
            }).then(function (response) {
                console.log('ongetUnFinJobList Function...');
                console.log(response.data);
                schOutVue.unfinJobList = response.data;
            });
        },
        getFinJobList: function () {
            let period = this.period;
            let status = this.status;
            let manual = this.manual;
            axios.post(this.phpajaxresponsefile, {
                action: 'getFinJobList',
                period: period,
                status: status,
                manual: manual
            }).then(function (response) {
                console.log('ongetFinJobList Function...');
                console.log(response.data);
                schOutVue.finJobList = response.data;
            });
        },
        getFinJobListDetails: function () {
            let period = this.period;
            let sid = this.finJob;
            let finjoblist = this.finJobList;
            let finJobListDetail = finjoblist.filter(d => d.sid === sid);
            console.log('filtered finJobList...');
            console.log(finJobListDetail);
            schOutVue.finJobListDetail = finJobListDetail;
        },
        getUnFinJobListDetails: function () {
            let period = this.period;
            let sid = this.unfinJob;
            let unfinjoblist = this.unfinJobList;
            let unfinJobListDetail = unfinjoblist.filter(d => d.sid === sid);
            console.log('filtered unfinJobList...');
            console.log(unfinJobListDetail);
            schOutVue.unfinJobListDetail = unfinJobListDetail;
        },
        getUnFinJobOutput: function () {
            let period = this.period;
            let sid = this.unfinJob;
            axios.post(this.phpajaxresponsefile, {
                action: 'getUnFinJobOutput',
                period: period,
                sid: sid
            }).then(function (response) {
                console.log('on getUnFinJobOutput( period=' + period + ' & sid=' + sid + ' Function...');
                console.log(response.data);
                schOutVue.unfinJobListOutput = response.data;
            }).then(function () {
                schOutVue.getFinJobInfoText();
                schOutVue.getJobWorkDetail(schOutVue.unfinJobListDetail, schOutVue.unfinJobListOutput);
            });
        },
        getFinJobOutput: function () {
            let period = this.period;
            let sid = this.finJob;
            axios.post(this.phpajaxresponsefile, {
                action: 'getFinJobOutput',
                period: period,
                sid: sid
            }).then(function (response) {
                console.log('on getFinJobOutput( period=' + period + ' & sid=' + sid + ' Function...');
                console.log(response.data);
                schOutVue.finJobListOutput = response.data;
            }).then(function () {
                schOutVue.getFinJobInfoText();
                schOutVue.getJobWorkDetail(schOutVue.finJobListDetail, schOutVue.finJobListOutput);
            });
        },
        getFinJobInfoText: function () {
            let status = this.status;
            let fintype = this.jobfintype;
            let finJobListOutput = this.finJobListOutput;
            let unfinJobListOutput = this.unfinJobListOutput;
            let finJobInfo = '';
            console.log('ingetFinJobInfoText function...');
            switch (status) {
                case 'active':
                    console.log('Job is Active');
                    switch (fintype) {
                        case 'finished':
                            console.log('Job is finished');
                            if (finJobListOutput != 'empty') {
                                console.log('joblist Output is not empty');
                                console.log('finJobListOutput = ');
                                console.log(finJobListOutput);
                                let finJobTake = finJobListOutput.filter(d => d.jobtype === 'jobtake');
                                if (finJobTake.length != 0) {
                                    console.log('Jobtake Exist');
                                    if (finJobListOutput.length > 1) {
                                        console.log('There\'s otherJob other thanjobtake ');
                                        finJobInfo = 'Joblist has been started and ended properly';
                                    } else {
                                        console.log('there\'s only jobtake');
                                        finJobInfo = 'Joblist has been ended, Without scanned in production area';
                                    }
                                } else {
                                    console.log('there\'s no jobtake');
                                    finJobInfo = 'Joblist has been ended, Without started by Production Admin';
                                }
                            } else {
                                console.log('Joblist output is empty');
                                finJobInfo = 'Joblist has been ended, Without started by Production Admin and without scanned in production area';
                            }

                            break;
                        case 'unfinished':
                            console.log('Job is unfinihsed');
                            if (unfinJobListOutput != 'empty') {
                                console.log('JoblistOutput is not empty');
                                console.log('unfinJobListOutput = ');
                                console.log(unfinJobListOutput);
                                let unfinJobTake = unfinJobListOutput.filter(d => d.jobtype === 'jobtake');
                                if (unfinJobTake.length != 0) {
                                    console.log('There\s jobtake');
                                    if (unfinJobListOutput.length > 1) {
                                        console.log('There\'s more than jobtake');
                                        finJobInfo = 'Joblist is in process';
                                    } else {
                                        console.log('There\'s only jobtake');
                                        finJobInfo = 'Joblist just printed by Production Admin.';
                                    }
                                } else {
                                    console.log('There\'s no jobtake');
                                    finJobInfo = 'Joblist is in process, without started by Production Admin';
                                }
                            } else {
                                console.log('Joblist Output is empty');
                                finJobInfo = 'Joblist not yet begun process';
                            }
                            break;
                    }
                    break;
                case 'billing':
                    console.log('Status is billing');
                    finJobInfo = 'Joblist is for Billing Only';
                    break;
                case 'cancelled':
                    console.log('Status is cancelled');
                    finJobInfo = 'Joblist is cancelled';
                    break;
            }
            schOutVue.finJobInfo = finJobInfo;

        }
    },
    computed: {

    },
    mounted: function () {
        this.getPeriod();
    }
});
        </script>
    </body>
</html>
