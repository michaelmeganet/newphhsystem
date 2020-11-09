<?php
include_once("include/mysql_connect.php");
include_once("includes/input_modechange.php");
//require_once("include/session.php");
//include_once("include/admin_check.php");

session_start();

//cProductionJoblist('joblistend');

$aid = 19;

$sqladmin = "SELECT * FROM admin WHERE aid = $aid";
$resultadmin = $rundb->Query($sqladmin);
$rowadmin = $rundb->FetchArray($resultadmin);

$branch = $rowadmin['branch'];
?>

<script language="javascript" type="text/javascript" src="productionjoblist/ajax_getAll.js"></script>
<script language="javascript" type="text/javascript" src="productionjoblist/autodate.js"></script>
<input type="hidden" id="input_mode" value="<?php echo $getPage;?>" />
<table width="100%" cellspacing="0" cellpadding="2" border="0">
    <tr>
        <td>PRODUCTION JOBLIST - JOBLIST END - <b><?php echo $pageMode;?></b></td>
    </tr>
    <tr>
        <td><button onclick="window.location.href='<?php echo $link;?>'">Change Mode (current :<?php echo $pageMode;?>)</button>
    </tr>
</table>
<br />

<table width="100%" cellspacing="0" cellpadding="2" border="0">
    <tr>
        <td>
            
            <form name="joblistend" enctype="multipart/form-data" action="<?php #$_SERVER['PHP_SELF']; ?>" onsubmit="return joblistend_validator(this);" method="post">
             
                <input type="hidden" name="bid" id="bid" value="<?php echo $branch; ?>" />
<input type="" style="width:0%;height: 0%" readonly/>

                <table width="100%" cellspacing="0" cellpadding="2" border="0">
                    <tr> 
                        <td colspan="2">Scan the <strong style="color:#00FF00">Joblist Barcode Job No</strong> or <strong style="color:#00FF00">Enter the Job No manually</strong> to end the Joblist.<br />
                            Manual entry should begin with <strong><font color="#00FFFF">AA BBB CCDD EEEE FF GGHH III JJKK</font></strong>.<br /><br />

                            AA = Branch<br />
                            BBB = Company Code<br />
                            CC = Year of Quotation Issued<br />
                            DD = Month of Quotation Issued<br />
                            EEEE = Running Number<br />
                            FF = Item Number<br />
                            GG = Year of Completion Date<br />
                            HH = Month of Completion Date<br />
                            III = (R) Replacement or (A) Amendment if any<br />
                            JJ = Year of Completion Date<br />
                            KK = Month of Completion Date</td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Job No :</td>
                        <td>: <input type="text" name="jobno" id="jobno" maxlength="80" style="width:200px" onkeypress="
                                pageMode = document.getElementById('input_mode').value;
                                if (pageMode == 'normal'){
                                    return handleEnter(getJoblistEnd,this.value,event);
                                }
                                        //    if (this.value.length == '26') {
                                        //        getJoblistEnd(this.value);
                                        //    } else if (this.value.length == '30') {
                                        //        if (this.value.charAt(30) == ']'g) {
                                        //            getJoblistEnd(this.value);
                                        //        }
                                        //    }
                                     "; /></td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="2"><div id="joblistend_data"></div></td>
                    </tr>
                </table>
            </form>
        </td>
    </tr>
</table>
<script language="javascript" type="text/javascript">
    window.onload = function () {
        document.forms['joblistend'].elements['jobno'].focus();
        var pageMode = document.getElementById('input_mode').value;
        var modeTimeout = null;
        if(pageMode == 'normal'){
            input.addEventListener('keyup',function(e){
            clearTimeout(modeTimeout);
            modeTimeout = setTimeout(function(){
                var data = <?php echo json_encode($link,JSON_HEX_TAG);?>;
                //console.log(data);
                window.location = data;
                },30000)
            })
        }
    }
</script>
<script>
    var input = document.getElementById('jobno');
    var pageMode = document.getElementById('input_mode').value;
    var timeout = null;
    var modeTimeout = null;
    if (pageMode == 'scan'){
        //console.log('scan mode selected');
        input.addEventListener('keyup',function(e){
            clearTimeout(timeout);
            timeout = setTimeout(function(){
                return getJoblistEnd(input.value);
            },700);
            
        })
    }
</script>
<!--
<script language="javascript" type="text/javascript">
    let input = document.getElementById('jobno');
    let timeout = null;
    
    input.addEventListener('keyup', function(e){
        if (input.value.length == '28' && input.value.charAt(20) == '('){
            var numtimeout = 700;
        } else if (input.value.charAt(0) == '['){
            var numtimeout = 4000;
            if (input.value.charAt(21) == '(' && input.value.charAt(29) == ']'){
                var numtimeout = 700;
            }else if (input.value.charAt(25) == ']'){
                var numtimeout = 700;
            }

        } else if (input.value.length == '24'){
            var numtimeout = 900;
        }else{
            var numtimeout = 4000;
        }
        clearTimeout(timeout);
        
        timeout = setTimeout(function(){
            return getJoblistEnd(input.value);
        },numtimeout);
    })
</script>
-->