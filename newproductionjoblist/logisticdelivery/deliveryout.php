<?php
include_once("include/mysql_connect.php");

session_start();

$aid = 19;
	  
$sqladmin = "SELECT * FROM admin WHERE aid = $aid";
$resultadmin = $rundb->Query($sqladmin);
$rowadmin = $rundb->FetchArray($resultadmin);

$branch = $rowadmin['branch'];
?>

<script language="javascript" type="text/javascript" src="logisticdelivery/ajax_getAll.js"></script>
<script language="javascript" type="text/javascript" src="logisticdelivery/autodate.js"></script>

<table width="100%" cellspacing="0" cellpadding="2" border="0">
  <tr>
    <td width="49%" valign="top">LOGISTIC DELIVERY - DELIVERY OUT</td>
    <td width="2%">&nbsp;</td>
    <td width="49%" class="mmfont" valign="top">အေထြေထြထုပ္ပိုးမႈဌာန - ျပင္ပပို႔ကုန္</td>
  </tr>
</table>

<br /><br />

<table width="100%" cellspacing="0" cellpadding="2" border="0">
  <tr>
    <td>
<form name="deliveryout" enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF']; ?>" onSubmit="return deliveryout_validator(this)" method="post">
<input type="hidden" name="bid" id="bid" value="<?php echo $branch; ?>" />

<table width="100%" cellspacing="0" cellpadding="2" border="0">
  <tr> 
    <td width="49%" valign="top">Scan the <strong style="color:#00FF00">Joblist Barcode Job No</strong> or <strong style="color:#00FF00">Enter the Job No manually</strong> to Deliver Out the item.<br />
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
    <td width="49%" class="mmfont" valign="top">ျပင္ပသို႔ပို႔ကုန္ေပးပို႔ရန္ <strong style="color:#00FF00">အလုပ္စာရင္းအား scan ဖတ္ပါ</strong> (သို႔မဟုတ္) <strong style="color:#00FF00">အလုပ္နံပါတ္အား ရိုက္ထည့္ပါ။</strong><br />
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
	<td>Job No / <font class="mmfont">အလုပ္အမွတ္စဥ္</font> : <input type="text" name="jobno" id="jobno" maxlength="28" style="width:200px" onkeyup="
        if(this.value.charAt(20) == '('){
          if(this.value.length == '28'){
            getDeliveryOut(this.value);
          }
        }
        else{
          if(this.value.length == '24'){
            getDeliveryOut(this.value);
          }
        }
      "; /></td>
  </tr>
  <tr>
	<td colspan="3">&nbsp;</td>
  </tr>
  <tr>
	<td colspan="3"><div id="deliveryout_data"></div></td>
  </tr>
</table>
</form>
	</td>
  </tr>
</table>
<script language="javascript" type="text/javascript">
window.onload = function(){
				  document.forms['deliveryout'].elements['jobno'].focus();
				} 
</script>