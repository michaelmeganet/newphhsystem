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
    case 'pkg':
        $urlmenu = "menu.php";
        $url = "logisticdelivery/packingcompleteitem.php";
        $pageTitle = "Logistic Delivery - Packing/Complete Item";
        break;

    case 'dyo':
        $urlmenu = "menu.php";
        $url = "logisticdelivery/deliveryout.php";
        $pageTitle = "Logistic Delivery - Delivery Out";
        break;

    case 'dyr':
        $urlmenu = "menu.php";
        $url = "logisticdelivery/deliveryreturn.php";
        $pageTitle = "Logistic Delivery - Delivery Return";
        break;

    case 'sbj':
        $urlmenu = "menu.php";
        $url = "logisticdelivery/searchbyjobno.php";
        $pageTitle = "Logistic Delivery - Search By Joblist No";
        break;

    case 'sbr':
        $urlmenu = "menu.php";
        $url = "logisticdelivery/searchbyrunningno.php";
        $pageTitle = "Logistic Delivery - Search By Running No";
        break;

    //production joblist

    case 'jwc':
        $urlmenu = "menu.php";
        $url = "productionjoblist/searchjoblistbystaff.php";
        $pageTitle = "Production Joblist - Search Joblist Details By Staff";
        break;
    case 'jss':
        $urlmenu = "menu.php";
        $url = "productionjoblist/singlejobliststatus.php";
        $pageTitle = "Production Joblist - Search Joblist Details";
        break;
    case 'jsn':
        $urlmenu = "menu.php";
        $url = "productionjoblist/newjoblistscan.php";
        $pageTitle = "Production Joblist - NEW JOBLIST SCAN";
        break;
    case 'jte':
        $urlmenu = "menu.php";
        $url = "productionjoblist/joblistend.php";
        $pageTitle = "Production Joblist - Joblist End";
        break;

    case 'bws':
        $urlmenu = "menubw.php";
        $url = "productionjoblist/bandsawcutstart.php";
        $pageTitle = "Production Joblist - Bandsaw Cut Start";
        break;

    case 'bwe':
        $urlmenu = "menubw.php";
        $url = "productionjoblist/bandsawcutend.php";
        $pageTitle = "Production Joblist - Bandsaw Cut End";
        break;

    case 'mgs':
        $urlmenu = "menumg.php";
        $url = "productionjoblist/millingstart.php";
        $pageTitle = "Production Joblist - Milling Thickness Start";
        break;

    case 'mge':
        $urlmenu = "menumg.php";
        $url = "productionjoblist/millingend.php";
        $pageTitle = "Production Joblist - Milling Thickness End";
        break;

    case 'mws':
        $urlmenu = "menumg.php";
        $url = "productionjoblist/millingwidthstart.php";
        $pageTitle = "Production Joblist - Milling Width Start";
        break;

    case 'mwe':
        $urlmenu = "menumg.php";
        $url = "productionjoblist/millingwidthend.php";
        $pageTitle = "Production Joblist - Milling Width End";
        break;

    case 'mls':
        $urlmenu = "menumg.php";
        $url = "productionjoblist/millinglengthstart.php";
        $pageTitle = "Production Joblist - Milling Length Start";
        break;

    case 'mle':
        $urlmenu = "menumg.php";
        $url = "productionjoblist/millinglengthend.php";
        $pageTitle = "Production Joblist - Milling Length End";
        break;

    case 'rgs':
        $urlmenu = "menurg.php";
        $url = "productionjoblist/roughgrindingstart.php";
        $pageTitle = "Production Joblist - Rough Grinding Start";
        break;

    case 'rge':
        $urlmenu = "menurg.php";
        $url = "productionjoblist/roughgrindingend.php";
        $pageTitle = "Production Joblist - Rough Grinding End";
        break;

    case 'pgs':
        $urlmenu = "menupg.php";
        $url = "productionjoblist/precisiongrindingstart.php";
        $pageTitle = "Production Joblist - Precision Grinding Start";
        break;

    case 'pge':
        $urlmenu = "menupg.php";
        $url = "productionjoblist/precisiongrindingend.php";
        $pageTitle = "Production Joblist - Precision Grinding End";
        break;

    case 'cms':
        $urlmenu = "menucm.php";
        $url = "productionjoblist/cncmachiningstart.php";
        $pageTitle = "Production Joblist - CNC Machining Start";
        break;

    case 'cme':
        $urlmenu = "menucm.php";
        $url = "productionjoblist/cncmachiningend.php";
        $pageTitle = "Production Joblist - CNC Machining End";
        break;

    case 'vdp':
        $urlmenu = "menublank.php";
        $url = "productionjoblist/viewdailyproductiontarget.php";
        $pageTitle = "Production Joblist - View Daily Production Target";
        break;

    case 'cfq':
        $urlmenu = "menu.php";
        $url = "productionjoblist/changefinishingquantity.php";
        $pageTitle = "Production Joblist - Change Finishing Quantity";
        break;

    case 'pbj':
        $urlmenu = "menu.php";
        $url = "productionjoblist/searchbyjobno.php";
        $pageTitle = "Production Joblist - Search By Joblist No";
        break;

    case 'pbr':
        $urlmenu = "menu.php";
        $url = "productionjoblist/searchbyrunningno.php";
        $pageTitle = "Production Joblist - Search By Running No";
        break;

    case 'psr':
        $urlmenu = "menu.php";
        $url = "productionjoblist/printsticker.php";
        $pageTitle = "Production Joblist - Print Sticker";
        break;
    case 'mcs':
        $urlmenu = "menumc.php";
        $url = "productionjoblist/manualcutstart.php";
        $pageTitle = "Production Joblist - Manual Cut Start";
        break;
    case 'mce':
        $urlmenu = "menumc.php";
        $url = "productionjoblist/manualcutend.php";
        $pageTitle = "Production Joblist - Manual Cut End";
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
