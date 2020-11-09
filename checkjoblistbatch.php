<?php
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
        }else{
            echo "Cannot found data in period 2010 for company = {$data['code']}, runningno = {$data['runningno']}, and jobno = {$data['jobno']}<br>";
        }
    }
    echo "<br><hr><br>";
}
echo "<hr><hr><hr>";
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
    </head>
    <body>
        <?php
// put your code here
        ?>
    </body>
</html>
