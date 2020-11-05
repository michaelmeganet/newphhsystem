<?php
include_once("include/osdetection.php");
//include_once("include/formatting.php");
$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';

// redirect to proper sub modules if $view is set
// otherwise show the main page
switch ($view) {
    case 'jwc':
        $urlmenu = "menupj.php";
        $url = "productionjoblist/searchjoblistbystaff.php";
        $pageTitle = "Production Joblist - Search Joblist Details By Staff";
        break;
    case 'jss':
        $urlmenu = "menupj.php";
        $url = "productionjoblist/singlejobliststatus.php";
        $pageTitle = "Production Joblist - Search Joblist Details";
        break;
    case 'jsn':
        $urlmenu = "menupj.php";
        $url = "productionjoblist/newjoblistscan.php";
        $pageTitle = "Production Joblist - NEW JOBLIST SCAN";
        break;
    case 'jte':
        $urlmenu = "menupj.php";
        $url = "productionjoblist/joblistend.php";
        $pageTitle = "Production Joblist - Joblist End";
        break;

    case 'cfq':
        $urlmenu = "menupj.php";
        $url = "productionjoblist/changefinishingquantity.php";
        $pageTitle = "Production Joblist - Change Finishing Quantity";
        break;

    case 'pbj':
        $urlmenu = "menupj.php";
        $url = "productionjoblist/searchbyjobno.php";
        $pageTitle = "Production Joblist - Search By Joblist No";
        break;

    case 'pbr':
        $urlmenu = "menupj.php";
        $url = "productionjoblist/searchbyrunningno.php";
        $pageTitle = "Production Joblist - Search By Running No";
        break;

    case 'psr':
        $urlmenu = "menupj.php";
        $url = "productionjoblist/printsticker.php";
        $pageTitle = "Production Joblist - Print Sticker";
        break;
    default:
        $urlmenu = "menupj.php";
        $url = "message.php";
        break;
}

include("display/header.php");

$aid = 19;
$sqli = "SELECT * FROM admin WHERE aid = $aid";
$objSqli = new SQL($sqli);
$rowi = $objSqli->getResultOneRowArray();
#$resulti = $rundb->Query($sqli);
#$rowi = $rundb->FetchArray($resulti);

//$sqlb = "SELECT * FROM branch_location";
#$sqlb = "SELECT * FROM branch WHERE bid = {$rowi['branch']}";
$sqlbcount = "SELECT count(*) FROM branch WHERE bid = {$rowi['branch']}";
$objSqlbcount = new SQL($sqlbcount);
$numrowsb = $objSqlbcount->getRowCount();
#$resultb = $rundb->Query($sqlb);
#$numrowsb = $rundb->NumRows($resultb);
?>

<?php
if ($urlmenu == "menublank.php") {
    ?>
    <table width="1000" cellspacing="1" cellpadding="1" border="0">
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td width="1000" align="center" valign="top"><?php include("$url"); ?></td>
        </tr>
    </table>
    <?php
} else {
    ?>
    <table width="1400" cellspacing="1" cellpadding="1" border="0">
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td width="150" valign="top"><?php include("$urlmenu"); ?></td>
            <td width="1250" align="center" valign="top"><?php include("$url"); ?></td>
        </tr>
    </table>
    <?php
}
?>

<?php
include("display/footer.php");
?>
