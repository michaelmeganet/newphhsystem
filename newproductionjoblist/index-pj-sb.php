<?php
include_once("include/osdetection.php");
//include_once("include/formatting.php");
$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';

// redirect to proper sub modules if $view is set
// otherwise show the main page
switch ($view) {
    case 'bss':
        $urlmenu = "menusb.php";
        $url = "scan-barcode/bandsawcutstart.php";
        $pageTitle = "Production Joblist - Bandsaw Cut Start";
        break;

    case 'bse':
        $urlmenu = "menusb.php";
        $url = "scan-barcode/bandsawcutend.php";
        $pageTitle = "Production Joblist - Bandsaw Cut End";
        break;

    case 'mts':
        $urlmenu = "menusb.php";
        $url = "scan-barcode/millingstart.php";
        $pageTitle = "Production Joblist - Milling Thickness Start";
        break;

    case 'mte':
        $urlmenu = "menusb.php";
        $url = "scan-barcode/millingend.php";
        $pageTitle = "Production Joblist - Milling Thickness End";
        break;

    case 'mws':
        $urlmenu = "menusb.php";
        $url = "scan-barcode/millingwidthstart.php";
        $pageTitle = "Production Joblist - Milling Width Start";
        break;

    case 'mwe':
        $urlmenu = "menusb.php";
        $url = "scan-barcode/millingwidthend.php";
        $pageTitle = "Production Joblist - Milling Width End";
        break;

    case 'mls':
        $urlmenu = "menusb.php";
        $url = "scan-barcode/millinglengthstart.php";
        $pageTitle = "Production Joblist - Milling Length Start";
        break;

    case 'mle':
        $urlmenu = "menusb.php";
        $url = "scan-barcode/millinglengthend.php";
        $pageTitle = "Production Joblist - Milling Length End";
        break;

    case 'rgs':
        $urlmenu = "menusb.php";
        $url = "scan-barcode/roughgrindingstart.php";
        $pageTitle = "Production Joblist - Rough Grinding Start";
        break;

    case 'rge':
        $urlmenu = "menusb.php";
        $url = "scan-barcode/roughgrindingend.php";
        $pageTitle = "Production Joblist - Rough Grinding End";
        break;

    case 'pgs':
        $urlmenu = "menusb.php";
        $url = "scan-barcode/precisiongrindingstart.php";
        $pageTitle = "Production Joblist - Precision Grinding Start";
        break;

    case 'pge':
        $urlmenu = "menusb.php";
        $url = "scan-barcode/precisiongrindingend.php";
        $pageTitle = "Production Joblist - Precision Grinding End";
        break;

    case 'cms':
        $urlmenu = "menusb.php";
        $url = "scan-barcode/cncmachiningstart.php";
        $pageTitle = "Production Joblist - CNC Machining Start";
        break;

    case 'cme':
        $urlmenu = "menusb.php";
        $url = "scan-barcode/cncmachiningend.php";
        $pageTitle = "Production Joblist - CNC Machining End";
        break;

    case 'mcs':
        $urlmenu = "menusb.php";
        $url = "scan-barcode/manualcutstart.php";
        $pageTitle = "Production Joblist - Manual Cut Start";
        break;
    
    case 'mce':
        $urlmenu = "menusb.php";
        $url = "scan-barcode/manualcutend.php";
        $pageTitle = "Production Joblist - Manual Cut End";
        break;    
    default:
        $urlmenu = "menusb.php";
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
