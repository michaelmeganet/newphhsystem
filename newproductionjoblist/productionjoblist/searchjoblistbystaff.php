<?php
require_once("include/session.php");
include_once("include/admin_check.php");
include_once("includes/input_modechange.php");
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
    </head>
    <body>
        <script language="javascript" type="text/javascript" src="productionjoblist/ajax_getAll.js"></script>
        <script language="javascript" type="text/javascript" src="productionjoblist/autodate.js"></script>
        <input type="hidden" id="input_mode" value="<?php echo $getPage; ?>" />
        <table width="100%" cellspacing="0" cellpadding="2" border="0">
            <tr>
                <td>JOBLIST SCAN STATION TASK REPORT - <b><?php echo $pageMode; ?></b></td>
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
                        <div>
                            Select Period:
                            <select v-model='period' id='period' name='period'>
                                <option v-for='data in periodList' v-bind:value='data'>{{data}}</option>
                            </select>
                        </div>
                        <br>
                        <div v-if='period != ""'>
                            User Id:<br>
                            <input type='text' value='' id='userid' name='userid' v-model='userid' placeholder="BD####" maxlength="6"/>
                            <button type='button' @click='getStaffName()'>Search</button>
                            <br>
                            <br>
                            <div v-if='staffName == "empty"'>
                                <a style="color:red">Cannot Find the staff name for {{userid}} !!!</a>
                            </div>
                            <div v-else>
                                Staff Name : <a style="color:yellow">{{staffName}}</a>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div v-if="joblistTaskList != ''" style="overflow-y: scroll;height:700px">
                            <!--paginationarea-->
                            Page {{page}} of {{totalpage}}
                            <nav>
                                <button type='button' v-if='page != 1' @click='page = 1'>First</button>
                                <span v-for='pageNumber in pageList.slice(pageStart,page+2)'>
                                    &nbsp;<button type='button' v-if='page == pageNumber' style='color:red' disabled>{{pageNumber}}</button>
                                    <button type='button' v-if='page != pageNumber' @click='page = pageNumber'>{{pageNumber}}</button>
                                </span>
                                <button type='button' v-if='page != totalpage' @click='page = totalpage'>Last</button>
                            </nav>
                            <!--endpaginationarea-->
                            <br>
                            <div v-if='loading'>
                                Loading new data....
                            </div>
                            <div v-if='!loading'>
                                <table style='border: 1px;border-style: solid'>
                                    <thead>
                                        <tr style='border: 1px;border-style: solid'>
                                            <th style='border: 1px;border-style: solid'>No</th>
                                            <th style='border: 1px;border-style: solid'>SID</th>
                                            <th style='border: 1px;border-style: solid'>Job Code</th>
                                            <th style='border: 1px;border-style: solid'>Status</th>
                                            <th style='border: 1px;border-style: solid'>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr style='border: 1px;border-style: solid' v-for='row in joblistTaskList'>
                                            <td v-for='data in row' style='border: 1px;border-style: solid;padding:5px 2px 5px 2px'>{{data}}</td>
                                            <td style='border:1px;border-style:solid;padding:5px 2px 5px 2px'>
                                                <a v-if='row.status != "Finished"' href="#" @click='openJobWorkDetail(row.job_code,userid,period)'>UPDATE</a>
                                                <a v-else>NO MORE UPDATE</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <script>
            function openJobWorkDetail(sid) {
                window.open('index.php?view=jwcdetail&page=scan&sid=' + sid);
            }
            var vueApp = new Vue({
                el: '#mainArea',
                data: {
                    phpajaxresponsefile: 'backend/joblisttaskreport.axios.php',
                    period: '',
                    userid: '',
                    staffName: '',
                    loading: false,
                    page: 1,
                    totaldata: 0,
                    totalpage: 0,
                    pageList: '',

                    periodList: '',
                    joblistTaskList: ''
                },
                watch: {
                    userid: function () {
                        if (this.userid.length === 6) {
                            this.getStaffName();
                        }
                    },
                    staffName: function () {
                        if (this.staffName !== 'empty') {
                            this.getJoblistTaskPages();
                        } else {
                            this.joblistTaskList = '';
                        }
                    },
                    page: function () {
                        this.getJoblistTasks(this.page);
                    }
                    
                },
                computed:{
                    pageStart: function(){
                        if(this.page < 3){
                            return 0
                        }else{
                            return (this.page - 3);
                        }
                    }
                },
                methods: {
                    getPeriodList: function () {
                        axios.post(this.phpajaxresponsefile, {
                            action: 'getPeriodList'
                        }).then(function (response) {
                            console.log('in getPeriodList...');
                            console.log(response.data);
                            vueApp.periodList = response.data;
                        });
                    },
                    getStaffName: function () {
                        axios.post(this.phpajaxresponsefile, {
                            action: 'getStaffName',
                            userid: vueApp.userid
                        }).then(function (response) {
                            console.log('in getStaffname....');
                            console.log(response.data);
                            vueApp.staffName = response.data;
                        });
                    },
                    getJoblistTasks: function (page = 1) {
                        this.loading = true;
                        axios.post(this.phpajaxresponsefile, {
                            action: 'getJoblistTasks',
                            period: vueApp.period,
                            userid: vueApp.userid,
                            page: page
                        }).then(function (response) {
                            console.log('in getJoblistTasks');
                            console.log(response.data);
                            vueApp.joblistTaskList = response.data;
                            vueApp.loading = false;
                        });
                    },
                    getJoblistTaskPages: function () {
                        axios.post(this.phpajaxresponsefile, {
                            action: 'getJoblistTaskPages',
                            period: vueApp.period,
                            userid: vueApp.userid
                        }).then(function (response) {
                            console.log('list amount of pages:');
                            console.log(response.data);
                            vueApp.totaldata = response.data.totaldata;
                            totalpage = response.data.totalpage;
                            vueApp.totalpage = totalpage;
                            pageList = [];
                            for (i = 0; i < totalpage; i++) {
                                pageList.push(i + 1);
                            }
                            console.log(pageList);
                            vueApp.pageList = pageList;
                        }).then(function () {
                            vueApp.getJoblistTasks(1);
                        });
                    },
                    openJobWorkDetail: function (jobcode, staffid, period) {
                        encJobCode = encodeURIComponent(jobcode);
                        url = 'index.php?view=jss&page=scan&jobcode=' + encJobCode + '&staffid=' + staffid + '&period=' + period;
                        window.open(url, '_self');
                    }
                },
                mounted: function () {
                    this.getPeriodList();
                }
            })
        </script>
        <!--
        <script language="javascript" type="text/javascript">
            window.onload = function () {
                document.forms['bandsawcutstart'].elements['staffid'].focus();
                var pageMode = document.getElementById('input_mode').value;
                var modeTimeout = null;
                if (pageMode == 'normal') {
                    input.addEventListener('keyup', function (e) {
                        clearTimeout(modeTimeout);
                        modeTimeout = setTimeout(function () {
                            var data = <?php echo json_encode($link, JSON_HEX_TAG); ?>;
                            //console.log(data);
                            window.location = data;
                        }, 30000)
                    })
                }
            }
        </script>
        <script>
            var input = document.getElementById('jobno');
            var pageMode = document.getElementById('input_mode').value;
            var timeout = null;
            var modeTimeout = null;
            if (pageMode == 'scan') {
                //console.log('scan mode selected');
                input.addEventListener('keyup', function (e) {
                    clearTimeout(timeout);
                    timeout = setTimeout(function () {
                        return getJoblistStart(input.value);
                    }, 700);
                })
            }
            }
        </script>
        <!--
        <script language="javascript" type="text/javascript">
            let input = document.getElementById('jobno');
            let timeout = null;
            
            input.addEventListener('keyup', function(e){
                if (input.value.length == '28' && input.value.charAt(20) == '('){
                    var numtimeout = 700;
                } else if (input.value.charAt(0) == '['){
                    var numtimeout = 4000;
                    if (input.value.charAt(21) == '(' && input.value.charAt(29) == ']'){
                        var numtimeout = 700;
                    }else if (input.value.charAt(25) == ']'){
                        var numtimeout = 700;
                    }
        
                } else if (input.value.length == '24'){
                    var numtimeout = 900;
                }else{
                    var numtimeout = 4000;
                }
                clearTimeout(timeout);
                
                timeout = setTimeout(function(){
                    return getBandsawCutStart(input.value);
                },numtimeout);
            })
        </script>
        -->
    </body>
</html>
