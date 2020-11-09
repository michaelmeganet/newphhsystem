<?php
#include_once("include/mysql_connect.php");
include_once ("includes/dbh.inc.php");
include_once ("includes/variables.inc.php");
#session_start();
?>

<table width="100%" cellspacing="0" cellpadding="5" border="0" align="center" class="noprint">
    <tr>
        <td id="tdtitle">Home</td>
    </tr>
    <tr>
        <td id="tdsubtitle"><a href="index.php" class="noline">Home</a></td>
    </tr>
    <tr>
        <td id="tdsubtitle">&nbsp;</td>
    </tr>
    <!-- Logistic Delivery Area -->
    <tr>
        <td id="tdtitle">Logistic Delivery</td>
    </tr>
    <tr>
        <td id="tdsubtitle"><a href='index-pj-ld.php' class='noline'>Go To Logistic Delivery Area</a></td>
    </tr>
    <!-- Production Joblist Area-->
    <tr>
        <td id="tdtitle">Production Joblist</td>
    </tr>
    <tr>
        <td id="tdsubtitle"><a href='index-pj-pj.php' class='noline'>Go To Production Joblist Area</a></td>
    </tr>
    <!-- Scan Barcode Area-->
    <tr>
        <td id="tdtitle">SCAN BARCODE</td>
    </tr>
    <tr>
        <td id="tdsubtitle"><a href="index-pj-sb.php" class="noline">Go To Legacy Scan Barcode</a></td>
    </tr>
    <tr>
        <td id="tdsubtitle"><hr></td>
    </tr>
    <tr>
        <td id="tdsubtitle"><a href="index.php?view=njs" class="noline">Go To New Scan Barcode</a></td>
    </tr>
    <?php
    //end of Production Joblist
    ?>
</table>

<br />
