<?php
#include_once("include/mysql_connect.php");
include_once("includes/dbh.inc.php");
include_once("includes/variables.inc.php");
//require_once("include/session.php");
//include_once("include/admin_check.php");
include_once("includes/input_modechange.php");
#session_start();

//cProductionJoblist('bandsawcutend');
if (isset($_GET['jlstaffid'])) {
    $jlstaffid = $_GET['jlstaffid'];
}
if (isset($_GET['jljobcode'])) {
    $jljobcode = $_GET['jljobcode'];
}

$aid = 19;

$sqladmin = "SELECT * FROM admin WHERE aid = $aid";
$objSqladmin = new SQL($sqli);
$rowadmin = $objSqladmin->getResultOneRowArray();
#$resultadmin = $rundb->Query($sqladmin);
#$rowadmin = $rundb->FetchArray($resultadmin);
$branch = $rowadmin['branch'];
?>

<script src='https://cdn.jsdelivr.net/npm/vue/dist/vue.js'></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script language="javascript" type="text/javascript" src="productionjoblist/ajax_getAll.js"></script>
<script language="javascript" type="text/javascript" src="productionjoblist/autodate.js"></script>
<input type="hidden" id="input_mode" value="<?php echo $getPage; ?>" />
<table width="100%" cellspacing="0" cellpadding="2" border="0">
    <tr>
        <td width="49%" valign="top">PRODUCTION JOBLIST - BANDSAW CUT END - <b><?php echo $pageMode; ?></b></td>
        <td width="2%">&nbsp;</td>
        <td width="49%" class="mmfont" valign="top">ကုန္ထုတ္လုပ္မႈအလုပ္စာရင္း - BANDSAW CUT - <b><?php echo $pageMode; ?></b> မွျဖတ္ေတာက္မႈစတင္ျခင္း</td>
    </tr>
    <tr>
        <td><button onclick="window.location.href = '<?php echo $link; ?>'">Change Mode (current :<?php echo $pageMode; ?>)</button>
    </tr>
</table>

<br /><br />
<div id='mainArea'>
    <table width="100%" cellspacing="0" cellpadding="2" border="0">
        <tr>
            <td>
                <form name="bandsawcutend" enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF']; ?>" onSubmit="return jobliststart_validator(this)" method="post">
                    <input type="hidden" name="bid" id="bid" value="<?php echo $branch; ?>" />

                    <table width="100%" cellspacing="0" cellpadding="2" border="0">
                        <td width="49%" valign="top">Scan the <strong style="color:#00FF00">Joblist Barcode Job No</strong> or <strong style="color:#00FF00">Enter the Job No manually</strong> to begin the Bandsaw Cut Joblist.<br />
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
                        <td width="2%">&nbsp;</td>
                        <td width="49%" class="mmfont" valign="top">Bandsaw Cut မစားမွီစာရင္းသြင္းရန္ႏွင့္စားျပီးစာရင္းသြင္းရန္ <strong style="color:#00FF00">အလုပ္စာရင္းအား scan ဖတ္ပါ</strong> (သို႔မဟုတ္) <strong style="color:#00FF00">အလုပ္နံပါတ္အား ရိုက္ထည့္ပါ။</strong><br />
                            ကိုယ္တိုင္ရိုက္ထည့္ရန္ပံုစံမွာ <strong><font color="#00FFFF">AA BBB CCDD EEEE FF GGG HHII</font></strong>.<br /><br />

                            AA = စက္ရံုခြဲ<br />
                            BBB = ကုမၼဏီသေကၤတ<br />
                            CC = တန္ဖိုးသတ္မွတ္လိုက္ေသာႏွစ္<br />
                            DD = တန္ဖိုးသတ္မွတ္လိုက္ေသာလ<br />
                            EEEE = ကုန္မွာလႊာအမွတ္စဥ္<br />
                            FF = ကုန္ပစၥည္းအမွတ္စဥ္<br />
                            GGG = အစားထိုးျခင္း (သို႔မဟုတ္) ျပန္လည္ျပဳျပင္ျခင္း<br />
                            HH = ကုန္ပစၥည္းျပီးစီးသည့္ႏွစ္<br />
                            II = ကုန္ပစၥည္းျပီးစီးသည့္လ</td>
                        </tr>
                        <tr>
                            <td colspan="3">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                    <tr>
                                        <td width="15%">Staff ID</td>
                                        <td width="75%">: 
                                            <input type="text" v-model='staffid' name="staffid" id="staffid" maxlength="6" style="width:200px"
                                                   v-on:keyup.enter='getStaffName()' value='<?php echo (isset($jlstaffid)) ? $jlstaffid : ''; ?>' />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td> <!-- Show Staff Name here, or show Error if nothing found -->
                                            <div id="staffid_data" v-if='staff_response.indexOf("Cannot") >= 0'><span style="color:red">{{staff_response}}</span></div>
                                            <div id="staffid_data" v-else><span style="color:yellow">{{staff_response}}</span></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Job No / <font class="mmfont">အလုပ္အမွတ္စဥ္</font></td>
                                        <td>: <input v-model='jobcode' type="text" name="jobno" id="jobno" maxlength="80" style="width:200px" 
                                                     v-on:keyup.enter='getParseJobCode();getJobUpdate()' value='<?php echo (isset($jljobcode)) ? $jljobcode : ''; ?>' /></td>

                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td> <!-- Show Staff Name here, or show Error if nothing found -->
                                            <div id="jobno_data"><span style="color:red" v-html='jobcode_response'>{{jobcode_response}}</span></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><div id="bandsawcutend_data" v-html='quantity_response'>{{quantity_response}}</div></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3"><input type="reset" name="clear" id="clear" value="Clear" onclick="getStaffIDEnd(0);
                                    getBandsawCutEnd(0);
                                    document.forms['bandsawcutend'].elements['staffid'].focus()" /></td>
                        </tr>
                        <tr>
                            <td>
                                <input type='hidden' value='bandsaw' id='proc' name='proc'/>
                            </td>
                        </tr>
                    </table>
                </form>
            </td>
        </tr>
    </table>
</div>
<script src ='productionjoblist/scan_EndProc.js'>
</script>