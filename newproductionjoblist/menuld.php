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
        <td id="tdtitle">Logistic Delivery</td>
    </tr>
    <tr>
        <td id="tdsubtitle">
        <!--    <a href="index-pj-ld.php?view=pkg"class="noline">Packing/Complete Item(On-Progress)</a>-->
        <a href="#" class="noline">Packing/Complete Item(On-Progress)</a>
        </td>
    </tr>   
    <!--
    <tr>
      <td id="tdsubtitle"><a href="index-pj-ld.php?view=dyo" class="noline">Delivery Out</a></td>
    </tr>
    <tr>
      <td id="tdsubtitle"><a href="index-pj-ld.php?view=dyr" class="noline">Delivery Return</a></td>
    </tr>
    -->
    <tr>
        <td id="tdsubtitle">
            <!--<a href="index-pj-ld.php?view=sbj" class="noline">Search By Job No(On-Progress)</a>-->
            <a href="#" class="noline">Search By Job No(On-Progress)</a>
        </td>
    </tr>
    <tr>
        <td id="tdsubtitle">
            <!--<a href="index-pj-ld.php?view=sbr" class="noline">Search By Running No(On-Progress)</a>-->
            <a href="#" class="noline">Search By Running No(On-Progress)</a>
        </td>
    </tr>
    <tr>
        <td id="tdsubtitle">&nbsp;</td>
    </tr>

    <tr>
        <td id="tdsubtitle">&nbsp;</td>
    </tr>
    <?php
    //end of Production Joblist
    ?>
</table>

<br />
