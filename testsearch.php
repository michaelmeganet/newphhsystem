<?php
/*
  include_once 'class/dbh.inc.php';
  include_once 'class/variables.inc.php';

  $data_array = array(
  array('code' => 'ETD', 'runningno' => '683', 'jobno' => '06'),
  array('code' => 'KHI', 'runningno' => '2678', 'jobno' => '6'),
  array('code' => 'NSL', 'runningno' => '719', 'jobno' => '1'),
  array('code' => 'STU', 'runningno' => '2698', 'jobno' => '1'),
  array('code' => 'MJM', 'runningno' => '2326', 'jobno' => '3'),
  array('code' => 'AMM', 'runningno' => '2643', 'jobno' => '2'),
  array('code' => 'GEM', 'runningno' => '329', 'jobno' => '1'),
  array('code' => 'EIE', 'runningno' => '2641', 'jobno' => '4'),
  array('code' => 'PON', 'runningno' => '2707', 'jobno' => '4'),
  array('code' => 'PON', 'runningno' => '2708', 'jobno' => '6'),
  array('code' => 'NAT', 'runningno' => '42', 'jobno' => '5'),
  array('code' => 'NAT', 'runningno' => '42', 'jobno' => '2'),
  array('code' => 'ECI', 'runningno' => '61', 'jobno' => '2'),
  array('code' => 'ECI', 'runningno' => '61', 'jobno' => '3'),
  array('code' => 'PCW', 'runningno' => '720', 'jobno' => '2'),
  array('code' => 'IFE', 'runningno' => '86', 'jobno' => '1'),
  array('code' => 'SSH', 'runningno' => '160', 'jobno' => '1'),
  array('code' => 'ECJ', 'runningno' => '61', 'jobno' => '1'),
  array('code' => 'AXD', 'runningno' => '51', 'jobno' => '1'),
  array('code' => 'TBL', 'runningno' => '2604', 'jobno' => '1'),
  );
  foreach ($data_array as $data) {
  echo "<b> Begin Search With Period 2011:<br>"
  . "Code = {$data['code']}<br>"
  . "Runningno = {$data['runningno']}<br>"
  . "Jobno = {$data['jobno']}<br></b>";
  $qr = "SELECT * FROM production_scheduling_2011 "
  . "WHERE quono LIKE '{$data['code']}%' "
  . "AND runningno = '{$data['runningno']}' "
  . "AND jobno = '{$data['jobno']}'";
  $objSQL = new SQL($qr);
  $result = $objSQL->getResultOneRowArray();
  if (!empty($result)) {
  $sid = $result['sid'];
  Echo "Found SID = $sid<br>";
  $qr2 = "SELECT * FROM production_output_2011 WHERE sid = $sid";
  $objSQL2 = new SQL($qr2);
  $result2 = $objSQL2->getResultRowArray();
  if (!empty($result2)) {
  echo "<table border = '1'>";
  echo "<tr>";
  foreach ($result2 as $data_row) {
  foreach ($data_row as $key => $val) {
  echo "<td>$key</td>";
  }
  break;
  }
  echo "</tr>";
  foreach ($result2 as $data_row) {
  echo "<tr>";
  foreach ($data_row as $key => $val) {
  echo "<td>$val</td>";
  }
  echo "</tr>";
  }
  echo "</table>";
  } else {
  echo "no output found for this<br>";
  }
  } else {
  //no data found
  echo "Cannot found data in period 2011 for company = {$data['code']}, runningno = {$data['runningno']}, and jobno = {$data['jobno']}<br>";
  echo "<b> Begin Search With Period 2010:<br>"
  . "Code = {$data['code']}<br>"
  . "Runningno = {$data['runningno']}<br>"
  . "Jobno = {$data['jobno']}<br></b>";
  $qr = "SELECT * FROM production_scheduling_2010 "
  . "WHERE quono LIKE '{$data['code']}%' "
  . "AND runningno = '{$data['runningno']}' "
  . "AND jobno = '{$data['jobno']}'";
  $objSQL = new SQL($qr);
  $result = $objSQL->getResultOneRowArray();
  if (!empty($result)) {
  $sid = $result['sid'];
  Echo "Found SID = $sid<br>";
  $qr2 = "SELECT * FROM production_output_2010 WHERE sid = $sid";
  $objSQL2 = new SQL($qr2);
  $result2 = $objSQL2->getResultRowArray();
  if (!empty($result2)) {
  echo "<table border = '1'>";
  echo "<tr>";
  foreach ($result2 as $data_row) {
  foreach ($data_row as $key => $val) {
  echo "<td>$key</td>";
  }
  break;
  }
  echo "</tr>";
  foreach ($result2 as $data_row) {
  echo "<tr>";
  foreach ($data_row as $key => $val) {
  echo "<td>$val</td>";
  }
  echo "</tr>";
  }
  echo "</table>";
  } else {
  echo "no output found for this<br>";
  }
  } else {
  echo "Cannot found data in period 2010 for company = {$data['code']}, runningno = {$data['runningno']}, and jobno = {$data['jobno']}<br>";
  }
  }
  echo "<br><hr><br>";
  }
  echo "<hr><hr><hr>";
 */
// foreach ($data_array as $data) {
//     echo "<b> Begin Search With Period 2010:<br>"
//     . "Code = {$data['code']}<br>"
//     . "Runningno = {$data['runningno']}<br>"
//     . "Jobno = {$data['jobno']}<br></b>";
//     $qr = "SELECT * FROM production_scheduling_2010 "
//             . "WHERE quono LIKE '{$data['code']}%' "
//             . "AND runningno = '{$data['runningno']}' "
//             . "AND jobno = '{$data['jobno']}'";
//     $objSQL = new SQL($qr);
//     $result = $objSQL->getResultOneRowArray();
//     if (!empty($result)) {
//         $sid = $result['sid'];
//         Echo "Found SID = $sid<br>";
//         $qr2 = "SELECT * FROM production_output_2010 WHERE sid = $sid";
//         $objSQL2 = new SQL($qr2);
//         $result2 = $objSQL2->getResultRowArray();
//         if (!empty($result2)) {
//             echo "<table border = '1'>";
//             echo "<tr>";
//             foreach ($result2 as $data_row) {
//                 foreach ($data_row as $key => $val) {
//                     echo "<td>$key</td>";
//                 }
//                 break;
//             }
//             echo "</tr>";
//             foreach ($result2 as $data_row) {
//                 echo "<tr>";
//                 foreach ($data_row as $key => $val) {
//                     echo "<td>$val</td>";
//                 }
//                 echo "</tr>";
//             }
//             echo "</table>";
//         } else {
//             echo "no output found for this<br>";
//         }
//     } else {
//         //no data found
//         echo "Cannot found data for company = {$data['code']}, runningno = {$data['runningno']}, and jobno = {$data['jobno']}<br>";
//     }
//     echo "<br><hr><br>";
// }
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
        <link href="./assets/html-excel/dist/css/tableexport.min.css" rel="stylesheet">      
        <script src='https://cdn.jsdelivr.net/npm/vue/dist/vue.js'></script>
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    </head>
    <body>
        <h2>BATCH JOBCODE SEARCH</h2>
        <br>
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
                                <td v-for='(data,key) in checkList[0]'>{{key}}</td>
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
        phpajaxresponsefile: 'testsearch.axios.php',
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
                s.src = "./testsearch-htmlexcel.js";
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
