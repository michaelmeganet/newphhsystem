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
        <h2>SUMMARY KPI</h2>
        <div id='mainArea'>
            <form action='' method='POST'>
                <div> <!--period area-->
                    Period :
                    <select v-model='period' id='period' name='period' @change="summType=''">
                        <option v-for='data in periodList' v-bind:value='data'>{{data}}</option>
                    </select>
                </div>
                <div> <!--period area-->
                    Status :
                    <select v-model='jobstatus' id='jobstatus' name='jobstatus' @change="summType='';detKPI=''">
                        <option value='finished'>Finished Jobs</option>
                        <option value='unfinished'>Unfinished Jobs</option>
                    </select>
                    <button type="button" @click="getSimpleKPIMonthly()" >Submit</button>
                </div>
            </form>
            <br>
            <br>
            <div v-if ='loading' class='text-center align-middle'>
                <h3>Loading Data...</h3>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                </div>
            </div>
            <div v-else-if='!loading'>
                <div v-if="jobstatus === 'finished' && detKPI != '' && status == 'ok'">
                    <div v-for="data in detKPI">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{data.staffid}}</th>
                                    <th>{{data.staffname}}</th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <th colspan="3">
                                        The finished job done KPI by {{data.staffname}} in the month of {{year}}-{{month}},<br>
                                        Summarized by Machine Models below :<br>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="3">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th v-for="(data,index) in data.details[0]">
                                                        {{index}}
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="datarow in data.details">
                                                    <th v-for="(data,index) in datarow">
                                                        {{data}}
                                                    </th>
                                                </tr>
                                            </tbody>
                                        </table >
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>            
                <div v-else-if="jobstatus === 'unfinished' && detKPI != '' && status == 'ok'">
                    <label class='control-label'>
                        Estimated Unfinished KPI List by Virtual Machines (Based on process to choose the appropriated virtual machines)
                    </label>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td v-for='(data,index) in detKPI[0]'>
                                    {{index}}
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for='datarow in detKPI'>
                                <td v-for='(data,index) in datarow'>
                                    {{data}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div v-else-if='status=="error"'>
                    <label class="label label-danger">{{errmsg}}</label>
                </div>
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
        jobstatus: 'finished',
        

        periodList: '',
        dayList: '',
        kpiList: '',
        detKPI: '',
        
        status: '',
        errmsg: ''
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
        detKPI: function(){
            if (this.detKPI.status == 'error'){
                this.status = 'error';
                this.errmsg = this.detKPI.msg;
            }else{
                this.status = 'ok';
            }
        }
    },
    methods: {
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
        getKPIDetail: function () {
            this.loading = true;
            axios.post(this.phpajaxresponsefile, {
                action: 'getKPIDetail',
                period: sumKPIVue.period,
                staffid: sumKPIVue.staffid,
                summType: sumKPIVue.summType,
                day: sumKPIVue.day
            }).then(function (response) {
                console.log('on getKPIDetail...');
                console.log(response.data);
                sumKPIVue.kpiList = response.data;
                sumKPIVue.loading = false;
            });
        },
        getSimpleKPIMonthly: function () {
            this.loading = true;
            axios.post(this.phpajaxresponsefile, {
                action: 'getSimpleKPIMonthly',
                period: sumKPIVue.period,
                jobstatus: sumKPIVue.jobstatus
            }).then(function (response) {
                console.log('on getSimpleKPIMonthly...');
                console.log(response.data);
                sumKPIVue.detKPI = response.data;
                sumKPIVue.loading = false;
            });
        }
    },
    mounted: function () {
        this.getPeriod();
    }
});
        </script>
    </body>
</html>
