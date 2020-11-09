<?php
include_once("include/osdetection.php");
//include_once("include/formatting.php");
$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';

// redirect to proper sub modules if $view is set
// otherwise show the main page
switch ($view) {
   case 'pkg':
        $urlmenu = "menuld.php";
        $url = "logisticdelivery/packingcompleteitem.php";
        $pageTitle = "Logistic Delivery - Packing/Complete Item";
        break;

    case 'dyo':
        $urlmenu = "menuld.php";
        $url = "logisticdelivery/deliveryout.php";
        $pageTitle = "Logistic Delivery - Delivery Out";
        break;

    case 'dyr':
        $urlmenu = "menuld.php";
        $url = "logisticdelivery/deliveryreturn.php";
        $pageTitle = "Logistic Delivery - Delivery Return";
        break;

    case 'sbj':
        $urlmenu = "menuld.php";
        $url = "logisticdelivery/searchbyjobno.php";
        $pageTitle = "Logistic Delivery - Search By Joblist No";
        break;

    case 'sbr':
        $urlmenu = "menuld.php";
        $url = "logisticdelivery/searchbyrunningno.php";
        $pageTitle = "Logistic Delivery - Search By Running No";
        break;
    case 'vdp':
        $urlmenu = "menublank.php";
        $url = "productionjoblist/viewdailyproductiontarget.php";
        $pageTitle = "Production Joblist - View Daily Production Target";
        break;
    
    default:
        $urlmenu = "menuld.php";
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
