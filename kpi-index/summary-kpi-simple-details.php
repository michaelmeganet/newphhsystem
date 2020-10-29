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
            <div class='container'>
                <div style='text-align:center'>
                    <b style='font-size:2em'>DETAILS OF MONTHLY SUMMARY</b><br></div>
                <br>
                <br>
                <div v-if="status == 'error'">
                    {{errorMsg}}
                </div>
                <div v-else>
                    <div class="row">
                        <div class="col-md">
                            <table class="table table-borderless">
                                <tr>
                                    <td>Period :</td>
                                    <td>{{period.substr(2,2)}} - 20{{period.substr(0,2)}}</td>
                                </tr>
                                <tr>
                                    <td>Staff :</td>
                                    <td>[{{staffid}}] - {{staffname}}</td>
                                </tr>
                                <tr>
                                    <td>Machine :</td>
                                    <td>[{{machineid}}] - {{machinename}} ({{machinemodel}})</td>
                                </tr>
                            </table>
                            
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md' v-if='dataList != ""'>
                            <table class='table table-bordered'>
                                <thead>
                                    <tr>
                                        <th v-for='(data,index) in dataList[0]'>{{index}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for='datarow in dataList'>
                                        <td v-for='data in datarow'>{{data}}</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan='7'>Total accumulated Value of KPI from {{period.substr(2,2)}} - 20{{period.substr(0,2)}} is <b style='color:lightgreen'>{{totalrealkpi}}</b> (Calculated Value = {{totalcalckpi}})</td>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <script>
var sumKPIVue = new Vue({
    el: '#mainArea',
    data: {
        phpajaxresponsefile: 'kpi-index/summarykpi.axios.php',
        period: '',
        staffid: '',
        staffname: '',
        machineid: '',
        machinename: '',
        machinemodel: '',
        machineno: '',
        dataList: '',

        status: '',
        errorMsg: ''
    },
    computed: {
        totalrealkpi: function () {
            data = this.dataList;
            sum = 0;
            if (data != '') {
                for (i = 0; i < data.length; i++) {
                   sum += data[i]['Real Value by KPI (RM)']; 
                }
                return sum.toFixed(2);
            }
           
        },
        totalcalckpi : function(){
            data = this.dataList;
            sum = 0;
            if (data!= ''){
                for (i = 0; i< data.length;i++){
                    sum += data[i]['Calculated Value by KPI (RM)'];
                }
                return sum.toFixed(2);
            }
        }
    },
    watch: {
    },
    methods: {
        summaryKPISimpleDetails: function () {
            period = this.period;
            staffid = this.staffid;
            machineid = this.machineid;
            axios.post(this.phpajaxresponsefile, {
                action: 'summaryKPISimpleDetails',
                period: period,
                staffid: staffid,
                machineid: machineid
            }).then(function (response) {
                console.log('on summaryKPISimpleDetails..');
                console.log(response.data);
                sumKPIVue.dataList = response.data;
            });
        },
        getStaffData: function () {
            axios.post(this.phpajaxresponsefile, {
                action: 'getStaffData',
                staffid: this.staffid
            }).then(function (response) {
                console.log('in getStaffData...');
                console.log(response.data);
                if (response.data.status == 'ok') {
                    sumKPIVue.staffname = response.data.msg;
                } else {
                    sumKPIVue.status = 'error';
                    sumKPIVue.errorMsg = response.data.msg;
                }
            });
        },
        getMachineData: function () {
            axios.post(this.phpajaxresponsefile, {
                action: 'getMachineData',
                machineid: this.machineid
            }).then(function (response) {
                console.log('in getMachineData');
                console.log(response.data);
                if (response.data.status == 'ok') {
                    sumKPIVue.machinename = response.data.machinename;
                    sumKPIVue.machinemodel = response.data.machinemodel;
                    sumKPIVue.machineno = response.data.machineno;
                } else {
                    sumKPIVue.status = 'error';
                    sumKPIVue.errorMsg = response.data.msg;
                }
            })
        }

    },
    beforeMount: function () {
        params = new URLSearchParams(location.search);
        this.period = params.get('period');
        this.staffid = params.get('staffid');
        this.machineid = params.get('machineid');
    },
    mounted: function () {
        console.log(this.period);
        console.log(this.staffid);
        console.log(this.machineid);
        this.summaryKPISimpleDetails();
        this.getStaffData();
        this.getMachineData();
    }
});
        </script>
    </body>
</html>
