<?php

include_once('includes/dbh.inc.php');
include_once('includes/variables.inc.php');
//require_once("include/session.php");

#session_start();

//check branch is set or not
function checkBranch() {
    global $rundb, $return;

    #$sql = "SELECT * FROM branch_location";
    #$result = $rundb->Query($sql);
    #$numrows = $rundb->NumRows($result);
    $sqlcount = "SELECT * FROM branch_location";
    $objSqlcount = new SQL($sqlcount);
    $numrows = $objSqlcount->getRowCount();

    if ($numrows != 0) {
        $return = "yes";
    } else {
        echo "Your current branch location has not been set. Please contact our administrator regarding this matter or this system is unusable.";

        exit();
    }
}

//denying access PHH & PST
function cPhhpst($subtable) {
    global $rundb, $return;

    $aid = $_SESSION['phhsystemAdmin'];

    #$sql = "SELECT * FROM admin_cpanel WHERE aid = $aid && m_pstphh = 'yes' && $subtable = 'yes'";
    #$result = $rundb->Query($sql);
    #$numrows = $rundb->NumRows($result);
    $sqlcount = "SELECT count(*) FROM admin_cpanel WHERE aid = $aid && m_pstphh = 'yes' && $subtable = 'yes'";
    $objSqlcount = new SQL($sqlcount);
    $numrows = $objSqlcount->getRowCount();
    if ($numrows != 0) {
        $return = "yes";
    } else {
        echo "You have no privileges to access this function. If you believe you have access to this function, please contact our administrator regarding this matter.";

        exit();
    }
}

//checking PHH & PST
function ePhhpst($subtable) {
    global $rundb, $return;

    $aid = $_SESSION['phhsystemAdmin'];

    #$sql = "SELECT * FROM admin_cpanel WHERE aid = $aid && m_career = 'yes' && $subtable = 'yes'";
    #$result = $rundb->Query($sql);
    #$numrows = $rundb->NumRows($result);
    $sqlcount = "SELECT count(*) FROM admin_cpanel WHERE aid = $aid && m_career = 'yes' && $subtable = 'yes'";
    $objSqlcount = new SQL($sqlcount);
    $numrows = $objSqlcount->getRowCount();
    if ($numrows != 0) {
        $return = "yes";
    } else {
        $return = "no";
    }
}

//denying access invoice do
function cInvoicedo($subtable) {
    global $rundb, $return;

    $aid = $_SESSION['phhsystemAdmin'];

    #$sql = "SELECT * FROM admin_cpanel WHERE aid = $aid && m_invoicedo = 'yes' && $subtable = 'yes'";
    #$result = $rundb->Query($sql);
    #$numrows = $rundb->NumRows($result);
    $sqlcount = "SELECT count(*) FROM admin_cpanel WHERE aid = $aid && m_invoicedo = 'yes' && $subtable = 'yes'";
    $objSqlcount = new SQL($sqlcount);
    $numrows = $objSqlcount->getRowCount();

    if ($numrows != 0) {
        $return = "yes";
    } else {
        echo "You have no privileges to access this function. If you believe you have access to this function, please contact our administrator regarding this matter.";

        exit();
    }
}

//checking invoice do
function eInvoicedo($subtable) {
    global $rundb, $return;

    $aid = $_SESSION['phhsystemAdmin'];

    #$sql = "SELECT * FROM admin_cpanel WHERE aid = $aid && m_invoicedo = 'yes' && $subtable = 'yes'";
    #$result = $rundb->Query($sql);
    #$numrows = $rundb->NumRows($result);
    $sqlcount = "SELECT count(*) FROM admin_cpanel WHERE aid = $aid && m_invoicedo = 'yes' && $subtable = 'yes'";
    $objSqlcount = new SQL($sqlcount);
    $numrows = $objSqlcount->getRowCount();

    if ($numrows != 0) {
        $return = "yes";
    } else {
        $return = "no";
    }
}

//checking quotation log
function eQuotationlog($subtable) {
    global $rundb, $return;

    $aid = $_SESSION['phhsystemAdmin'];

    #$sql = "SELECT * FROM admin_cpanel WHERE aid = $aid && m_quotationlog = 'yes' && $subtable = 'yes'";
    #$result = $rundb->Query($sql);
    #$numrows = $rundb->NumRows($result);
    $sqlcount = "SELECT count(*) FROM admin_cpanel WHERE aid = $aid && m_quotationlog = 'yes' && $subtable = 'yes'";
    $objSqlcount = new SQL($sqlcount);
    $numrows = $objSqlcount->getRowCount();

    if ($numrows != 0) {
        $return = "yes";
    } else {
        $return = "no";
    }
}

//denying quotation log
function cQuotationlog($subtable) {
    global $rundb, $return;

    $aid = $_SESSION['phhsystemAdmin'];

    #$sql = "SELECT * FROM admin_cpanel WHERE aid = $aid && m_quotationlog = 'yes' && $subtable = 'yes'";
    #$result = $rundb->Query($sql);
    #$numrows = $rundb->NumRows($result);
    $sqlcount = "SELECT count(*) FROM admin_cpanel WHERE aid = $aid && m_quotationlog = 'yes' && $subtable = 'yes'";
    $objSqlcount = new SQL($sqlcount);
    $numrows = $objSqlcount->getRowCount();

    if ($numrows != 0) {
        $return = "yes";
    } else {
        echo "You have no privileges to access this function. If you believe you have access to this function, please contact our administrator regarding this matter.";

        exit();
    }
}

//checking production joblist
function eProductionJoblist($subtable) {
    global $rundb, $return;

    $aid = $_SESSION['phhsystemAdmin'];

    #$sql = "SELECT * FROM admin_cpanel WHERE aid = $aid && m_productionjoblist = 'yes' && $subtable = 'yes'";
    #$result = $rundb->Query($sql);
    #$numrows = $rundb->NumRows($result);
    $sqlcount = "SELECT count(*) FROM admin_cpanel WHERE aid = $aid && m_productionjoblist = 'yes' && $subtable = 'yes'";
    $objSqlcount = new SQL($sqlcount);
    $numrows = $objSqlcount->getRowCount();

    if ($numrows != 0) {
        $return = "yes";
    } else {
        $return = "no";
    }
}

//denying production joblist
function cProductionJoblist($subtable) {
    global $rundb, $return;

    $aid = $_SESSION['phhsystemAdmin'];

    #$sql = "SELECT * FROM admin_cpanel WHERE aid = $aid && m_productionjoblist = 'yes' && $subtable = 'yes'";
    #$result = $rundb->Query($sql);
    #$numrows = $rundb->NumRows($result);
    $sqlcount = "SELECT count(*) FROM admin_cpanel WHERE aid = $aid && m_productionjoblist = 'yes' && $subtable = 'yes'";
    $objSqlcount = new SQL($sqlcount);
    $numrows = $objSqlcount->getRowCount();

    if ($numrows != 0) {
        $return = "yes";
    } else {
        echo "You have no privileges to access this function. If you believe you have access to this function, please contact our administrator regarding this matter.";

        exit();
    }
}

//checking production stock record
function eProductionStockRecord($subtable) {
    global $rundb, $return;

    $aid = $_SESSION['phhsystemAdmin'];

    #$sql = "SELECT * FROM admin_cpanel WHERE aid = $aid && m_productionstockrecord = 'yes' && $subtable = 'yes'";
    #$result = $rundb->Query($sql);
    #$numrows = $rundb->NumRows($result);
    $sqlcount = "SELECT count(*) FROM admin_cpanel WHERE aid = $aid && m_productionstockrecord = 'yes' && $subtable = 'yes'";
    $objSqlcount = new SQL($sqlcount);
    $numrows = $objSqlcount->getRowCount();

    if ($numrows != 0) {
        $return = "yes";
    } else {
        $return = "no";
    }
}

//denying production stock record
function cProductionStockRecord($subtable) {
    global $rundb, $return;

    $aid = $_SESSION['phhsystemAdmin'];

    #$sql = "SELECT * FROM admin_cpanel WHERE aid = $aid && m_productionstockrecord = 'yes' && $subtable = 'yes'";
    #$result = $rundb->Query($sql);
    #$numrows = $rundb->NumRows($result);
    $sql = "SELECT * FROM admin_cpanel WHERE aid = $aid && m_productionstockrecord = 'yes' && $subtable = 'yes'";
    $objSqlcount = new SQL($sqlcount);
    $numrows = $objSqlcount->getRowCount();

    if ($numrows != 0) {
        $return = "yes";
    } else {
        echo "You have no privileges to access this function. If you believe you have access to this function, please contact our administrator regarding this matter.";

        exit();
    }
}

//checking production
function eProduction($subtable) {
    global $rundb, $return;

    $aid = $_SESSION['phhsystemAdmin'];

    #$sql = "SELECT * FROM admin_cpanel WHERE aid = $aid && m_production = 'yes' && $subtable = 'yes'";
    #$result = $rundb->Query($sql);
    #$numrows = $rundb->NumRows($result);
    $sqlcount = "SELECT count(*) FROM admin_cpanel WHERE aid = $aid && m_production = 'yes' && $subtable = 'yes'";
    $objSqlcount = new SQL($sqlcount);
    $numrows = $objSqlcount->getRowCount();

    if ($numrows != 0) {
        $return = "yes";
    } else {
        $return = "no";
    }
}

//denying production
function cProduction($subtable) {
    global $rundb, $return;

    $aid = $_SESSION['phhsystemAdmin'];

    #$sql = "SELECT * FROM admin_cpanel WHERE aid = $aid && m_production = 'yes' && $subtable = 'yes'";
    #$result = $rundb->Query($sql);
    #$numrows = $rundb->NumRows($result);
    $sqlcount = "SELECT count(*) FROM admin_cpanel WHERE aid = $aid && m_production = 'yes' && $subtable = 'yes'";
    $objSqlcount = new SQL($sqlcount);
    $numrows = $objSqlcount->getRowCount();

    if ($numrows != 0) {
        $return = "yes";
    } else {
        echo "You have no privileges to access this function. If you believe you have access to this function, please contact our administrator regarding this matter.";

        exit();
    }
}

//denying access payment receive
function cPaymentReceive($subtable) {
    global $rundb, $return;

    $aid = $_SESSION['phhsystemAdmin'];

    #$sql = "SELECT * FROM admin_cpanel WHERE aid = $aid && m_paymentreceive = 'yes' && $subtable = 'yes'";
    #$result = $rundb->Query($sql);
    #$numrows = $rundb->NumRows($result);
    $sql = "SELECT * FROM admin_cpanel WHERE aid = $aid && m_paymentreceive = 'yes' && $subtable = 'yes'";
    $objSqlcount = new SQL($sqlcount);
    $numrows = $objSqlcount->getRowCount();

    if ($numrows != 0) {
        $return = "yes";
    } else {
        echo "You have no privileges to access this function. If you believe you have access to this function, please contact our administrator regarding this matter.";

        exit();
    }
}

//checking Payment Receive
function ePaymentReceive($subtable) {
    global $rundb, $return;

    $aid = $_SESSION['phhsystemAdmin'];

    #$sql = "SELECT * FROM admin_cpanel WHERE aid = $aid && m_paymentreceive = 'yes' && $subtable = 'yes'";
    #$result = $rundb->Query($sql);
    #$numrows = $rundb->NumRows($result);
    $sqlcount = "SELECT count(*) FROM admin_cpanel WHERE aid = $aid && m_paymentreceive = 'yes' && $subtable = 'yes'";
    $objSqlcount = new SQL($sqlcount);
    $numrows = $objSqlcount->getRowCount();

    if ($numrows != 0) {
        $return = "yes";
    } else {
        echo "You have no privileges to access this function. If you believe you have access to this function, please contact our administrator regarding this matter.";

        exit();
    }
}

//denying access Sales Analysis
function cSalesAnalysis($subtable) {
    global $rundb, $return;

    $aid = $_SESSION['phhsystemAdmin'];

    #$sql = "SELECT * FROM admin_cpanel WHERE aid = $aid && m_salesanalysis = 'yes' && $subtable = 'yes'";
    #$result = $rundb->Query($sql);
    #$numrows = $rundb->NumRows($result);
    $sqlcount = "SELECT count(*) FROM admin_cpanel WHERE aid = $aid && m_salesanalysis = 'yes' && $subtable = 'yes'";
    $objSqlcount = new SQL($sqlcount);
    $numrows = $objSqlcount->getRowCount();

    if ($numrows != 0) {
        $return = "yes";
    } else {
        echo "You have no privileges to access this function. If you believe you have access to this function, please contact our administrator regarding this matter.";

        exit();
    }
}

//checking Sales Analysis
function eSalesAnalysis($subtable) {
    global $rundb, $return;

    $aid = $_SESSION['phhsystemAdmin'];

    #$sql = "SELECT * FROM admin_cpanel WHERE aid = $aid && m_salesanalysis = 'yes' && $subtable = 'yes'";
    #$result = $rundb->Query($sql);
    #$numrows = $rundb->NumRows($result);
    $sqlcount = "SELECT count(*) FROM admin_cpanel WHERE aid = $aid && m_salesanalysis = 'yes' && $subtable = 'yes'";
    $objSqlcount = new SQL($sqlcount);
    $numrows = $objSqlcount->getRowCount();

    if ($numrows != 0) {
        $return = "yes";
    } else {
        echo "You have no privileges to access this function. If you believe you have access to this function, please contact our administrator regarding this matter.";

        exit();
    }
}

//denying access Customer
function cCustomer($subtable) {
    global $rundb, $return;

    $aid = $_SESSION['phhsystemAdmin'];

    #$sql = "SELECT * FROM admin_cpanel WHERE aid = $aid && m_customer = 'yes' && $subtable = 'yes'";
    #$result = $rundb->Query($sql);
    #$numrows = $rundb->NumRows($result);
    $sqlcount = "SELECT count(*) FROM admin_cpanel WHERE aid = $aid && m_customer = 'yes' && $subtable = 'yes'";
    $objSqlcount = new SQL($sqlcount);
    $numrows = $objSqlcount->getRowCount();

    if ($numrows != 0) {
        $return = "yes";
    } else {
        echo "You have no privileges to access this function. If you believe you have access to this function, please contact our administrator regarding this matter.";

        exit();
    }
}

//checking Customer
function eCustomer($subtable) {
    global $rundb, $return;

    $aid = $_SESSION['phhsystemAdmin'];

    #$sql = "SELECT * FROM admin_cpanel WHERE aid = $aid && m_customer = 'yes' && $subtable = 'yes'";
    #$result = $rundb->Query($sql);
    #$numrows = $rundb->NumRows($result);
    $sqlcount = "SELECT count(*) FROM admin_cpanel WHERE aid = $aid && m_customer = 'yes' && $subtable = 'yes'";
    $objSqlcount = new SQL($sqlcount);
    $numrows = $objSqlcount->getRowCount();

    if ($numrows != 0) {
        $return = "yes";
    } else {
        echo "You have no privileges to access this function. If you believe you have access to this function, please contact our administrator regarding this matter.";

        exit();
    }
}

//denying access Material
function cMaterial($subtable) {
    global $rundb, $return;

    $aid = $_SESSION['phhsystemAdmin'];

    #$sql = "SELECT * FROM admin_cpanel WHERE aid = $aid && m_material = 'yes' && $subtable = 'yes'";
    #$result = $rundb->Query($sql);
    #$numrows = $rundb->NumRows($result);
    $sqlcount = "SELECT count(*) FROM admin_cpanel WHERE aid = $aid && m_material = 'yes' && $subtable = 'yes'";
    $objSqlcount = new SQL($sqlcount);
    $numrows = $objSqlcount->getRowCount();

    if ($numrows != 0) {
        $return = "yes";
    } else {
        echo "You have no privileges to access this function. If you believe you have access to this function, please contact our administrator regarding this matter.";

        exit();
    }
}

//checking Material
function eMaterial($subtable) {
    global $rundb, $return;

    $aid = $_SESSION['phhsystemAdmin'];

    #$sql = "SELECT * FROM admin_cpanel WHERE aid = $aid && m_material = 'yes' && $subtable = 'yes'";
    #$result = $rundb->Query($sql);
    #$numrows = $rundb->NumRows($result);
    $sqlcount = "SELECT count(*) FROM admin_cpanel WHERE aid = $aid && m_material = 'yes' && $subtable = 'yes'";
    $objSqlcount = new SQL($sqlcount);
    $numrows = $objSqlcount->getRowCount();

    if ($numrows != 0) {
        $return = "yes";
    } else {
        $return = "no";
    }
}

//denying access branch settings
function cBranchSettings($subtable) {
    global $rundb, $return;

    $aid = $_SESSION['phhsystemAdmin'];

    #$sql = "SELECT * FROM admin_cpanel WHERE aid = $aid && m_branchsettings = 'yes' && $subtable = 'yes'";
    #$result = $rundb->Query($sql);
    #$numrows = $rundb->NumRows($result);
    $sqlcount = "SELECT count(*) FROM admin_cpanel WHERE aid = $aid && m_branchsettings = 'yes' && $subtable = 'yes'";
    $objSqlcount = new SQL($sqlcount);
    $numrows = $objSqlcount->getRowCount();

    if ($numrows != 0) {
        $return = "yes";
    } else {
        echo "You have no privileges to access this function. If you believe you have access to this function, please contact our administrator regarding this matter.";

        exit();
    }
}

//checking branch settings
function eBranchSettings($subtable) {
    global $rundb, $return;

    $aid = $_SESSION['phhsystemAdmin'];

    #$sql = "SELECT * FROM admin_cpanel WHERE aid = $aid && m_branchsettings = 'yes' && $subtable = 'yes'";
    #$result = $rundb->Query($sql);
    #$numrows = $rundb->NumRows($result);
    $sqlcount = "SELECT count(*) FROM admin_cpanel WHERE aid = $aid && m_branchsettings = 'yes' && $subtable = 'yes'";
    $objSqlcount = new SQL($sqlcount);
    $numrows = $objSqlcount->getRowCount();

    if ($numrows != 0) {
        $return = "yes";
    } else {
        echo "You have no privileges to access this function. If you believe you have access to this function, please contact our administrator regarding this matter.";

        exit();
    }
}

//denying access Staff
function cStaff($subtable) {
    global $rundb, $return;

    $aid = $_SESSION['phhsystemAdmin'];

    #$sql = "SELECT * FROM admin_cpanel WHERE aid = $aid && m_staff = 'yes' && $subtable = 'yes'";
    #$result = $rundb->Query($sql);
    #$numrows = $rundb->NumRows($result);
    $sqlcount = "SELECT count(*) FROM admin_cpanel WHERE aid = $aid && m_staff = 'yes' && $subtable = 'yes'";
    $objSqlcount = new SQL($sqlcount);
    $numrows = $objSqlcount->getRowCount();

    if ($numrows != 0) {
        $return = "yes";
    } else {
        echo "You have no privileges to access this function. If you believe you have access to this function, please contact our administrator regarding this matter.";

        exit();
    }
}

//checking Staff
function eStaff($subtable) {
    global $rundb, $return;

    $aid = $_SESSION['phhsystemAdmin'];

    #$sql = "SELECT * FROM admin_cpanel WHERE aid = $aid && m_staff = 'yes' && $subtable = 'yes'";
    #$result = $rundb->Query($sql);
    #$numrows = $rundb->NumRows($result);
    $sqlcount = "SELECT count(*) FROM admin_cpanel WHERE aid = $aid && m_staff = 'yes' && $subtable = 'yes'";
    $objSqlcount = new SQL($sqlcount);
    $numrows = $objSqlcount->getRowCount();

    if ($numrows != 0) {
        $return = "yes";
    } else {
        echo "You have no privileges to access this function. If you believe you have access to this function, please contact our administrator regarding this matter.";

        exit();
    }
}

//denying access Login
function cLogin($subtable) {
    global $rundb, $return;

    $aid = $_SESSION['phhsystemAdmin'];

    #$sql = "SELECT * FROM admin_cpanel WHERE aid = $aid && m_login = 'yes' && $subtable = 'yes'";
    #$result = $rundb->Query($sql);
    #$numrows = $rundb->NumRows($result);
    $sqlcount = "SELECT count(*) FROM admin_cpanel WHERE aid = $aid && m_login = 'yes' && $subtable = 'yes'";
    $objSqlcount = new SQL($sqlcount);
    $numrows = $objSqlcount->getRowCount();

    if ($numrows != 0) {
        $return = "yes";
    } else {
        echo "You have no privileges to access this function. If you believe you have access to this function, please contact our administrator regarding this matter.";

        exit();
    }
}

//checking Login
function eLogin($subtable) {
    global $rundb, $return;

    $aid = $_SESSION['phhsystemAdmin'];

    #$sql = "SELECT * FROM admin_cpanel WHERE aid = $aid && m_login = 'yes' && $subtable = 'yes'";
    #$result = $rundb->Query($sql);
    #$numrows = $rundb->NumRows($result);
    $sqlcount = "SELECT count(*) FROM admin_cpanel WHERE aid = $aid && m_login = 'yes' && $subtable = 'yes'";
    $objSqlcount = new SQL($sqlcount);
    $numrows = $objSqlcount->getRowCount();

    if ($numrows != 0) {
        $return = "yes";
    } else {
        $return = "no";
    }
}

?>