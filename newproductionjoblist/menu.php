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
    <?php
    //begin of Logistic Delivery Menu
    ?>
    <tr>
        <td id="tdtitle">Logistic Delivery</td>
    </tr>
    <tr>
        <td id="tdsubtitle"><a href="index.php?view=pkg" class="noline">Packing/Complete Item(On-Progress)</a></td>
    </tr>   
    <!--
    <tr>
      <td id="tdsubtitle"><a href="index.php?view=dyo" class="noline">Delivery Out</a></td>
    </tr>
    <tr>
      <td id="tdsubtitle"><a href="index.php?view=dyr" class="noline">Delivery Return</a></td>
    </tr>
    -->
    <tr>
        <td id="tdsubtitle"><a href="index.php?view=sbj" class="noline">Search By Job No(On-Progress)</a></td>
    </tr>
    <tr>
        <td id="tdsubtitle"><a href="index.php?view=sbr" class="noline">Search By Running No(On-Progress)</a></td>
    </tr>
    <tr>
        <td id="tdsubtitle">&nbsp;</td>
    </tr>
    <?php
    //begin of Production Joblist
    ?>
    <tr>
        <td id="tdtitle">Production Joblist</td>
    </tr>
    <tr>
        <td id="tdsubtitle"><a href='index.php?view=jwc&page=scan' class="noline"><strike>Search Joblist by Staff</strike><br>(Still Under Development)</a></td>
    </tr>
    <tr>
        <td id="tdsubtitle"><a href='index.php?view=jss&page=scan' class="noline"><strike>Single Joblist Status</strike><br>(Still Under Development)</a></td>
    </tr>
    <tr>
        <td id="tdsubtitle"><a href='index.php?view=jsn&page=scan' class="noline"><strike>NEW JOBLIST SCAN</strike><br>(Still Under Development)</a></td>
    </tr>
    <tr>
        <td id="tdsubtitle"><hr></td>
    </tr>
    <tr>
        <td id="tdsubtitle"><a href="index.php?view=jte&page=scan" class="noline">Joblist End(On-Progress)</a></td>
    </tr>
    <tr>
        <td id="tdsubtitle"><a href="index.php?view=cfq" class="noline">Change Finishing Quantity(On-Progress)</a></td>
    </tr>
    <tr>
        <td id="tdsubtitle"><a href="index.php?view=pbj" class="noline">Search By Joblist No(On-Progress)</a></td>
    </tr>
    <tr>
        <td id="tdsubtitle"><a href="index.php?view=pbr" class="noline">Search By Running No(On-Progress)</a></td>
    </tr>
    <tr>
        <td id="tdsubtitle"><a href="index.php?view=psr" class="noline">Print Sticker (On-Progress)</a></td>
    </tr>
    <tr>
        <td id="tdtitle">SCAN BARCODE</td>
    </tr>
    <tr>
        <td id="tdsubtitle"><a href="index.php?view=mcs&page=scan" class="noline">Manual Cut</a></td>
    </tr>
    <tr>
        <td id="tdsubtitle"><a href="index.php?view=bws&page=scan" class="noline">Bandsaw</a></td>
    </tr>
    <tr>
        <td id="tdsubtitle"><a href="index.php?view=cms&page=scan" class="noline">CNC</a></td>
    </tr>
    <tr>
        <td id="tdsubtitle"><a href="index.php?view=mgs&page=scan" class="noline">Milling</a></td>
    </tr>
    <tr>
        <td id="tdsubtitle"><a href="index.php?view=pgs&page=scan" class="noline">Precision Grinding</a></td>
    </tr>
    <tr>
        <td id="tdsubtitle"><a href="index.php?view=rgs&page=scan" class="noline">Rough Grinding</a></td>
    </tr>  

    <tr>
        <td id="tdsubtitle">&nbsp;</td>
    </tr>
    <?php
    //end of Production Joblist
    ?>
</table>

<br />
