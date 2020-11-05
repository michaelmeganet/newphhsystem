<?php
#include_once("include/mysql_connect.php");
include_once ("includes/dbh.inc.php");
include_once ("includes/variables.inc.php");
#session_start();
?>

<table width="100%" cellspacing="0" cellpadding="5" border="0" align="center" class="noprint">
    <tr>
        <td id="tdtitle"><b>Home</b></td>
    </tr>
    <tr>
        <td id="tdsubtitle"><a href="index.php" class="noline">Home</a></td>
    </tr>
    <tr>
        <td id="tdsubtitle">&nbsp;</td>
    </tr>
    <tr>
        <td id="tdtitle">Production Joblist</td>
    </tr>
    <tr>
        <td id="tdsubtitle"><a href='index-pj-pj.php?view=jwc&page=scan' class="noline"><strike>Search Joblist by Staff</strike><br>(Still Under Development)</a></td>
    </tr>
    <tr>
        <td id="tdsubtitle"><a href='index-pj-pj.php?view=jss&page=scan' class="noline"><strike>Single Joblist Status</strike><br>(Still Under Development)</a></td>
    </tr>\
    <tr>
        <td id="tdsubtitle"><hr></td>
    </tr>
    <tr>
        <td id="tdsubtitle"><a href="index-pj-pj.php?view=jte&page=scan" class="noline">Joblist End(On-Progress)</a></td>
    </tr>
    <tr>
        <td id="tdsubtitle"><a href="index-pj-pj.php?view=cfq" class="noline">Change Finishing Quantity(On-Progress)</a></td>
    </tr>
    <tr>
        <td id="tdsubtitle"><a href="index-pj-pj.php?view=pbj" class="noline">Search By Joblist No(On-Progress)</a></td>
    </tr>
    <tr>
        <td id="tdsubtitle"><a href="index-pj-pj.php?view=pbr" class="noline">Search By Running No(On-Progress)</a></td>
    </tr>
    <tr>
        <td id="tdsubtitle"><a href="index-pj-pj.php?view=psr" class="noline">Print Sticker (On-Progress)</a></td>
    </tr>

    <tr>
        <td id="tdsubtitle">&nbsp;</td>
    </tr>
    <?php
    //end of Production Joblist
    ?>
</table>

<br />
