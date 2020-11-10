
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
        <link href="../assets/html-excel/dist/css/tableexport.min.css" rel="stylesheet">      
        <script src='https://cdn.jsdelivr.net/npm/vue/dist/vue.js'></script>
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    </head>
    <body>
        <br>
        <div id='mainArea'>
            <table>
                <tr>
                    <td>Select Period :</td>
                    <td>
                        <select v-model='period' id='period' name='period' ref='period'>
                            <option v-for='data in periodList' v-bind:value='data'>{{data}}</option>
                        </select>
                    </td>
                <tr>
                    <td>Scan Jobcode :</td>
                    <td><input type='text' id='jobcode' name='jobcode' v-model='jobcode' v-on:keyup.enter='parseJobCode()'/></td>
                    <td>{{jobcode_response}}</td>
                </tr>
            </table>
            <br>
            <br>
            <div v-if='checkList !== undefined || checkList.length > 0'>
                <button type='button' @click='generatePrint()'>Generate Printout</button>
                <div id='tableArea'>
                    <table border='1' style='text-align: center' id='reportTable'>
                        <thead>
                            <tr>
                                <td class="tableexport-caption target" v-for='(data,key) in checkList[0]'>{{key}}</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for='data in checkList'>
                                <td v-for='val in data'>{{val}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script>
var vueApp = new Vue({
    el: '#mainArea',
    data: {
        phpajaxresponsefile: './joblistcheck/joblistcheck.axios.php',
        period: '',
        jobcode: '',
        jobcode_response: '',
        periodList: '',
        checkList: []


    },
    methods: {
        getPeriod: function () {
            axios.post(this.phpajaxresponsefile, {
                action: 'getPeriodList'
            }).then(function (response) {
                console.log('on getPeriodList...');
                console.log(response.data);
                vueApp.periodList = response.data;
                vueApp.period = response.data[0];
            });
        },
        parseJobCode: function () {
            axios.post(this.phpajaxresponsefile, {
                action: 'parseJobCode',
                jobcode: vueApp.jobcode
            }).then(function (response) {
                console.log('on parseJobCode');
                console.log(response.data);
                if (response.data === 'error') {
                    jobcode_response = 'Cannot parse jobcode, please check your input';
                } else {
                    jobcode_response = response.data;
                }
                vueApp.jobcode_response = jobcode_response;
                return jobcode_response;
            }).then(function (jc_resp) {
                console.log('jc_resp = ' + jc_resp);
                if (jc_resp !== 'Cannot parse jobcode, please check your input') {
                    vueApp.getCheckJobCode(jc_resp);
                }
            });
        },
        getCheckJobCode: function (jobcode) {
            axios.post(this.phpajaxresponsefile, {
                action: 'getCheckJobCode',
                period: vueApp.period,
                jobcode: jobcode
            }).then(function (response) {
                console.log('on parseJobCode');
                console.log(response.data);
                vueApp.checkList.push(response.data);
            });
        },
        generatePrint: function () {
            console.log('on GeneratePring..');
            if (this.checkList.length <= 0) {
                console.log('no data found!');
                window.alert('Cannot generate, There\'s no data found');
            } else {
                console.log('data found!');
                prt_win = window.open('');
                prt_win.document.write('<html><body><h4>Select Export Type:</h4><div id="table"></div></body></html>');
                l = prt_win.document.createElement('link');
                l.rel = 'stylesheet';
                l.href = './assets/html-excel/dist/css/tableexport.min.css';
                prt_win.document.head.appendChild(l);
                prt_win.document.getElementById('table').innerHTML =
                        document.getElementById('tableArea').innerHTML;
                s = prt_win.document.createElement("script");
                s.type = "text/javascript";
                s.src = "./assets/html-excel/bower_components/jquery/dist/jquery.min.js";
                prt_win.document.body.appendChild(s);
                s = prt_win.document.createElement("script");
                s.type = "text/javascript";
                s.src = "./assets/html-excel/bower_components/js-xlsx/dist/xlsx.core.min.js";
                prt_win.document.body.appendChild(s);
                s = prt_win.document.createElement("script");
                s.type = "text/javascript";
                s.src = "./assets/html-excel/bower_components/blobjs/Blob.min.js";
                prt_win.document.body.appendChild(s);
                s = prt_win.document.createElement("script");
                s.type = "text/javascript";
                s.src = "./assets/html-excel/bower_components/file-saverjs/FileSaver.min.js";
                prt_win.document.body.appendChild(s);
                s = prt_win.document.createElement("script");
                s.type = "text/javascript";
                s.src = "./assets/html-excel/dist/js/tableexport.min.js";
                prt_win.document.body.appendChild(s);
                s = prt_win.document.createElement("script");
                s.type = "text/javascript";
                s.src = "./joblistcheck/joblistcheck-htmlexcel.js";
                prt_win.document.body.appendChild(s);



            }
        }
    },
    mounted: function () {
        this.getPeriod();
    }

});
        </script>
    </body>
</html>
