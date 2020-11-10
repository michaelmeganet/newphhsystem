<?php
include_once("include/mysql_connect.php");
//require_once("include/session.php");
//include_once("include/admin_check.php");

session_start();

//cProductionJoblist('changefinishingquantity');
function convertTojobno($input){
    preg_match('/\[[a-zA-Z].+\]/',$input,$results);
    $str0 = $results[0]; //still contains bracket
    $str1 = str_replace('[','',$str0);
    $str2 = str_replace(']','',$str1);
    #echo "\$str2 = $str2";
    return $str2;
}

function updateQty() {
    global $rundb, $err, $noerr, $dat;
    //jobtype
    if (!empty($_POST['jobtype'])) {
        $jte = $_POST['jobtype'];
    } else {
        $jte = FALSE;
    }

    //staffid
    if (!empty($_POST['staffid'])) {
        $sfid = $_POST['staffid'];
    } else {
        $sfid = FALSE;
    }

    //jobno
    if (!empty($_POST['jobno'])) {
        $jno = $_POST['jobno'];
    } else {
        $jno = FALSE;
    }

    //date
    if (!empty($_POST['dat'])) {
        $dat = $_POST['dat'];
    } else {
        $dat = FALSE;
    }

    //bid
    if (!empty($_POST['bid'])) {
        $bid = $_POST['bid'];
    } else {
        $bid = FALSE;
    }

    if ($jte && $sfid && $jno && $dat && $bid) {
        //poid
        foreach ($_POST['poid'] as $poidkey => $poidvalue) {
            $poid[] = $poidvalue;
        }

        //old quantity
        foreach ($_POST['oldquantity'] as $oldqtykey => $oldqtyvalue) {
            $oldquantity[] = $oldqtyvalue;
        }

        //quantity
        foreach ($_POST['quantity'] as $qtykey => $qtyvalue) {
            $quantity[] = $qtyvalue;
        }

        $sqladm = "SELECT * FROM admin_staff WHERE staffid = '$sfid' AND (staff_level = 'admin' OR staff_level = 'supervisor')";
        $resultadm = $rundb->Query($sqladm);
        $numrowsadm = $rundb->NumRows($resultadm);

        if ($numrowsadm == 1) {
            $pottab = "production_output_" . $dat;
            $pottabrep = "production_output_report_" . $dat;

            //create track log report table and add data
            $sqlct = "SELECT * FROM $pottabrep";
            $resultct = $rundb->Query($sqlct);

            if (!$resultct) {
                $sqlctbpottabrep = "CREATE TABLE IF NOT EXISTS `$pottabrep` (
							`porid` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
							`poid` INT( 10 ) UNSIGNED NOT NULL ,
							`old_quantity` INT( 10 ) UNSIGNED NOT NULL ,
							`new_quantity` INT( 10 ) UNSIGNED NOT NULL ,
							`sfid` VARCHAR( 10 ) NOT NULL ,
							`datetime` DATETIME NOT NULL 
							) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

                if ($rundb->Query($sqlctbpottabrep)) {
                    
                } else {
                    echo "<font color=\"#FF0000\">Production Output Report table cannot be created. Please contact administrator regarding this thing.</font>";
                    exit();
                }
            }

            for ($x = 0; $x < sizeof($poid); $x++) {
                if ($quantity[$x] != "" || $quantity[$x] != NULL) {
                    $sqlupdprotar = "UPDATE $pottab
						   SET quantity = $quantity[$x]
						   WHERE poid = $poid[$x];";

                    $sqlpottabrep = "INSERT INTO $pottabrep (porid, poid, old_quantity, new_quantity, sfid, datetime) VALUES (NULL, $poid[$x], $oldquantity[$x], $quantity[$x], '$sfid', NOW());";

                    if ($rundb->Query($sqlupdprotar) && $rundb->Query($sqlpottabrep)) {
                        $noerror = 0;
                    } else {
                        $noerror = 1;
                        break;
                    }
                }
            }

            if ($noerror == 0) {
                $noerr = "Production Output has been updated.";
            } else {
                $err = "Production Output cannot be updated. Please contact administrator regarding this thing.";
            }
        } else {
            $err = "Only Admin or Supervisor can update the Production Output.";
        }
    } else {
        $noerr = "Production Output cannot be submitted. Please contact administrator regarding this thing.";
    }
}

if ($_POST['submit']) {
    updateQty();
}

$aid = $_SESSION['phhsystemAdmin'];

$sqladmin = "SELECT * FROM admin WHERE aid = 19";
$resultadmin = $rundb->Query($sqladmin);
$rowadmin = $rundb->FetchArray($resultadmin);

$branch = $rowadmin['branch'];
?>

<script language="javascript" type="text/javascript" src="productionjoblist/ajax_getAll.js"></script>
<script language="javascript" type="text/javascript" src="productionjoblist/autodate.js"></script>

<table width="100%" cellspacing="0" cellpadding="2" border="0">
    <tr>
        <td>PRODUCTION JOBLIST - CHANGE FINISHING QUANTITY</td>
    </tr>
</table>

<br /><br />

<table width="100%" cellspacing="0" cellpadding="2" border="0">
    <tr>
        <td>
            <form name="changefinishingquantity" enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF']; ?>" onSubmit="return jobliststart_validator(this)" method="post">
                <input type="hidden" name="bid" id="bid" value="<?php echo $branch; ?>" />

                <table width="100%" cellspacing="0" cellpadding="2" border="0">
                    <tr> 
                        <td colspan="2">Scan the <strong style="color:#00FF00">Joblist Barcode Job No</strong> or <strong style="color:#00FF00">Enter the Job No manually</strong> to Change  Finishing Quantity Joblist.<br />
                            Manual entry should begin with <strong><font color="#00FFFF">AA BBB CCDD EEEE FF GGG HHII</font></strong>.<br /><br />

                            AA = Branch<br />
                            BBB = Company Code<br />
                            CC = Year of Quotation Issued<br />
                            DD = Month of Quotation Issued<br />
                            EEEE = Running Number<br />
                            FF = Item Number<br />
                            GGG = (R) Replacement or (A) Amendment if any<br />
                            HH = Year of Completion Date<br />
                            II = Month of Completion Date</td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="10%">Job Type</td>
                        <td width="90%">: <select name="jobtype" id="jobtype" onchange="getChangeFinishingQuantity()">
                                <option value="">Select job type...</option>
                                <option value="bandsaw">Bandsaw Cut</option>
                                <option value="milling">Milling Thickness</option>
                                <option value="millingwidth">Milling Width</option>
                                <option value="millinglength">Milling Length</option>
                                <option value="roughgrinding">Rough Grinding</option>
                                <option value="precisiongrinding">Precision Grinding</option>
                                <option value="cncmachining">CNC Machining</option>
                            </select></td>
                    </tr>
                    <tr>
                        <td>Staff ID</td>
                        <td>: <input type="text" name="staffid" id="staffid" maxlength="6" style="width:200px" onkeyup="
                                if (this.value.length == '6') {
                                    getStaffIDEnd(this.value);
                                }
                                     "; /></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><div id="staffid_data"></div></td>
                    </tr> 
                    <tr>
                        <td>Job No</td>
                        <td>: <input type="text" name="jobno" id="jobno" maxlength="50" style="width:200px" onkeypress="
                                handleEnter(getJobNoCFQ,this.value,event);
                                return handleEnter(getChangeFinishingQuantity,this.value,event);
                                        
                            //    if (this.value.charAt(20) == '(') {
                            //        if (this.value.length == '28') {
                            //            getJobNoCFQ(this.value);
                            //            getChangeFinishingQuantity();
                            //        }
                            //    } else {
                            //        if (this.value.length == '24') {
                            //            getJobNoCFQ(this.value);
                            //            getChangeFinishingQuantity();
                            //        }
                            //    }
                                     "; /></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><div id="jobno_data"></div></td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr> 
                    <tr>
                        <td colspan="2"><div id="changefinishingquantity_data"></div></td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit" name="submit" id="submit" value="Update" />&nbsp;&nbsp;&nbsp;<input type="reset" name="clear" id="clear" value="Clear" onclick="getStaffIDEnd(0); getJobNoCFQ(0); getChangeFinishingQuantity(); document.forms['changefinishingquantity'].elements['staffid'].focus()" /></td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="2"><p><?php echo "<font color='#FF0000'>$err</font>"; ?><?php echo "$noerr"; ?></p></td>
                    </tr>
                </table>
            </form>
        </td>
    </tr>
</table>
<script language="javascript" type="text/javascript">
    window.onload = function () {
        document.forms['changefinishingquantity'].elements['staffid'].focus();
    }
</script>