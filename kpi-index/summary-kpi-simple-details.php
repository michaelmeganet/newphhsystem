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
                    <b style='font-size:2em'>KPI MONTHLY SUMMARY BY STAFF NAME, MACHINE</b><br></div>
                <br>
                <br>
                <div>
                    You have clicked: <br>
                    period = {{period}}<br>
                    staffid = {{staffid}}<br>
                    machineid = {{machineid}}<br>
                </div>
            </div>

        </div>
        <script>
var sumKPIVue = new Vue({
    el: '#mainArea',
    data: {
        phpajaxresponsefile: 'summarykpi.axios.php',
        period: '',
        staffid: '',
        machineid: '',
    },
    computed: {
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
                console.log(response.data);
            });
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
    }
});
        </script>
    </body>
</html>
