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
    <!-- Bandsaw -->
    <tr>
        <td id="tdtitle"><b>Bandsaw Process</b></td>
    </tr>
    <tr>
        <td id="tdsubtitle"><a href="index-pj-sb.php?view=bss&page=scan" class="noline">Bandsaw Start</a></td>
    </tr>
    <tr>
        <td id="tdsubtitle"><a href="index-pj-sb.php?view=bse&page=scan" class="noline">Bandsaw End</a></td>
    </tr>
    <!-- Manual Cut-->
    <tr>
        <td id="tdtitle"><b>Manual Cut Process</b></td>
    </tr>
    <tr>
        <td id="tdsubtitle"><a href="index-pj-sb.php?view=mcs&page=scan" class="noline">Manual Cut Start</a></td>
    </tr>
    <tr>
        <td id="tdsubtitle"><a href="index-pj-sb.php?view=mce&page=scan" class="noline">Manual Cut End</a></td>
    </tr>
    <!-- CNC-->
    <tr>
        <td id="tdtitle"><b>CNC Process</b></td>
    </tr>
    <tr>
        <td id="tdsubtitle"><a href="index-pj-sb.php?view=cms&page=scan" class="noline">CNC Start</a></td>
    </tr>
    <tr>
        <td id="tdsubtitle"><a href="index-pj-sb.php?view=cme&page=scan" class="noline">CNC End</a></td>
    </tr>
    <!-- Miling-->
    <tr>
        <td id="tdtitle"><b>Milling Process</b></td>
    </tr>
    <tr>
        <td id="tdsubtitle"><a href="index-pj-sb.php?view=mts&page=scan" class="noline">Milling Thick Start</a></td>
    </tr>
    <tr>
        <td id="tdsubtitle"><a href="index-pj-sb.php?view=mte&page=scan" class="noline">Milling Thick End</a></td>
    </tr>
    <tr>
        <td id="tdsubtitle"><hr></td>
    </tr>
    <tr>
        <td id="tdsubtitle"><a href="index-pj-sb.php?view=mws&page=scan" class="noline">Milling Width Start</a></td>
    </tr>
    <tr>
        <td id="tdsubtitle"><a href="index-pj-sb.php?view=mwe&page=scan" class="noline">Milling Width End</a></td>
    </tr>
    <tr>
        <td id="tdsubtitle"><hr></td>
    </tr>
    <tr>
        <td id="tdsubtitle"><a href="index-pj-sb.php?view=mls&page=scan" class="noline">Milling Length Start</a></td>
    </tr>
    <tr>
        <td id="tdsubtitle"><a href="index-pj-sb.php?view=mle&page=scan" class="noline">Milling Length End</a></td>
    </tr>
    <!-- Rough Grinding-->
    <tr>
        <td id="tdtitle"><b>Rough Grinding Process</b></td>
    </tr>
    <tr>
        <td id="tdsubtitle"><a href="index-pj-sb.php?view=rgs&page=scan" class="noline">Rough Grind Start</a></td>
    </tr>
    <tr>
        <td id="tdsubtitle"><a href="index-pj-sb.php?view=rge&page=scan" class="noline">Rough Grind End</a></td>
    </tr>
    <!-- Precision Grinding-->
    <tr>
        <td id="tdtitle"><b>Precision Grinding Process</b></td>
    </tr>
    <tr>
        <td id="tdsubtitle"><a href="index-pj-sb.php?view=pgs&page=scan" class="noline">Precision Grind Start</a></td>
    </tr>
    <tr>
        <td id="tdsubtitle"><a href="index-pj-sb.php?view=pge&page=scan" class="noline">Precision Grind End</a></td>
    </tr>

    <tr>
        <td id="tdsubtitle">&nbsp;</td>
    </tr>
    <?php
    //end of Production Joblist
    ?>
</table>

<br />
