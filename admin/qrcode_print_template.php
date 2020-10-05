<?php
$currURL = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
#echo $currURL."<br>";
$query = $_SERVER['PHP_SELF'];
$path = pathinfo( $query );
$basename = $path['basename'];
$baseurl = str_replace($basename, '', $currURL);
#echo (__DIR__);
#print_r($array_staff_nametag);
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
        <style>
            table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
            }
        </style>
    </head>
    <body>
        <div style="margin: auto;width:100%">
            <table >
                <thead>
                    <tr>
                        <?php
                        foreach ($data_array as $data_row) {
                            foreach ($data_row as $rowKey => $rowVal) {
                                echo "<td style='text-align:center' >$rowKey</td>";
                            }
                            break;
                        }
                        ?>
                    </tr>
                </thead>
                <tbody >
                    <?php
                    foreach ($data_array as $data_row) {
                        echo "<tr>";
                        foreach ($data_row as $rowKey => $rowVal) {
                            if ($rowKey == 'staffid') {
                                $staffid = $rowVal;
                            }
                            if ($rowKey == 'qrcode') {
                                echo "<td style='text-align:center;padding:5px 5px 5px 5px'><img src='".(__DIR__)."/".$rowVal."' width='85' height='85' /></td>";
                            } else {
                                echo "<td>$rowVal</td>";
                            }
                            
                        }
                        echo "</tr>";
                    }
                    ?>
                    </div>
                </tbody>
            </table>
            <?php
            //include_once 'qrcodeimage.php?code=TEST';
            ?>
            <!--<img src="qrcodeimage.php?code=TEST" />-->
        </div>
    </body>
</html>