<?php
session_start();

$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';

// redirect to proper sub modules if $view is set
// otherwise show the main page
switch ($view) {
    case 'home':
        header('Location: index.php');
        break;
    
    //logistic delivery
    case 'ldp':
        $urlmenu = "menu.php";
        $url = "logisticdelivery/packingcompleteitem.php";
        $pageTitle = "Logistic Delivery - Packing/Complete Item";
        break;
    //Production Joblist
    case 'pjp':
        break;
    //Scan Barcode
    case 'sbp':
        $urlmenu = "menusb.php";
        $url = "index-pj-sb.php";
        $pageTitle = "Scan Barcode";
        break;
    case 'njs':
        $urlmenu = "menu.php";
        $url = "scan-barcode/newjoblistscan.php";
        $pageTitle = "Scan Barcode";
        break;
    default:
        $urlmenu = "menu.php";
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
