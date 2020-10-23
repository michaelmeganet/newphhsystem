<?php
include_once("include/mysql_connect.php");
//require_once("include/session.php");
//include_once("include/admin_check.php");

session_start();

//cProductionJoblist('viewdailyproductiontarget');

$aid = 19;
	  
$sqladmin = "SELECT * FROM admin WHERE aid = $aid";
$resultadmin = $rundb->Query($sqladmin);
$rowadmin = $rundb->FetchArray($resultadmin);

$branch = $rowadmin['branch'];

$jobtype = $_GET['jt'];

if($jobtype == "bw"){
  $targetpage = "bws";
  $viewtarget1 = 1;
  $viewtarget2 = 2;
  $viewtarget3 = 3;
}
else if($jobtype == "mg"){
  $targetpage = "mgs";
  $viewtarget1 = 4;
  $viewtarget2 = 5;
}
else if($jobtype == "rg"){
  $targetpage = "rgs";
  $viewtarget1 = 6;
}
else if($jobtype == "pg"){
  $targetpage = "pgs";
  $viewtarget1 = 7;
  $viewtarget2 = 8;
}
else if($jobtype == "cm"){ 
  $targetpage = "cms";
  $viewtarget1 = 9;
}
?>

<script language="javascript" type="text/javascript" src="productionjoblist/ajax_getAll.js"></script>
<script language="javascript" type="text/javascript" src="productionjoblist/autodate.js"></script>

<link type="text/css" rel="stylesheet" href="include/mainstyle.css">

<table width="100%" cellspacing="0" cellpadding="2" border="0">
  <tr>
    <td>PRODUCTION JOBLIST - VIEW DAILY PRODUCTION TARGET</td>
  </tr>
</table>

<br /><br />

<form name="viewdailyproductiontarget" enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF']; ?>" onSubmit="return enterscheduling_validator(this)" method="post">
<input type="hidden" name="bid" id="bid" value="<?php echo $branch; ?>" />
<input type="hidden" name="year" id="year" value="<?php echo date('Y'); ?>" />
<input type="hidden" name="month" id="month" value="<?php echo date('m'); ?>" />
<input type="hidden" name="day" id="day" value="<?php echo date('d'); ?>" />
<input type="hidden" name="jobtype" id="jobtype" value="<?php echo $targetpage; ?>" />
<input type="hidden" name="jobtype1" id="jobtype1" value="<?php echo $viewtarget1; ?>" />
<input type="hidden" name="jobtype2" id="jobtype2" value="<?php echo $viewtarget2; ?>" />
<input type="hidden" name="jobtype3" id="jobtype3" value="<?php echo $viewtarget3; ?>" />

<script type="text/JavaScript">
var jobtype = document.getElementById("jobtype").value;

document.onkeypress = onUserActivity; //when any key press, it redirects back to original page
//document.onmousemove = onUserActivity; //when mouse is moved, it redirects back to original page
 
function onUserActivity(){
  location.href = 'index.php?view=' + jobtype;
}
</script>

<table width="100%" cellspacing="0" cellpadding="2" border="0">
  <tr>
	<td><div id="viewdailyproductiontarget1_data"></div></td>
  </tr>
  <tr>
	<td>&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
  </tr>
  <tr>
	<td><div id="viewdailyproductiontarget2_data"></div></td>
  </tr>
  <tr>
	<td>&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
  </tr>
  <tr>
	<td><div id="viewdailyproductiontarget3_data"></div></td>
  </tr> 
</table>
</form>
<script language="javascript" type="text/javascript">
//delay time before calling functions, this is diff with setTimeout(getViewDailyProductionTarget(1), 1000 * 1)
//because it is calling same functions but different input value
setTimeout(function(){
  getViewDailyProductionTarget(1)	
}, 1000 * 1);
	
setTimeout(function(){
  getViewDailyProductionTarget(2)	
}, 3000 * 1);
	
setTimeout(function(){
  getViewDailyProductionTarget(3)	
}, 5000 * 1);
</script>