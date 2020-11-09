<?php 
include_once("../include/mysql_connect.php");
//require_once("../include/session.php");
//include_once("../include/admin_check.php");

session_start();

if($_GET['jobno'] && $_GET['bid']){ 

  $jobno = $_GET['jobno']; //jobno
  $bid = $_GET['bid']; //branch id
  
  $branch = substr($jobno, 0, 2); //CJ or SB
  $companycode = substr($jobno, 3, 3); //company code
  $quodat = sprintf("%04d", substr($jobno, 7, 4)); //quotation date
  $runningno = sprintf("%04d", substr($jobno, 12, 4)); //running number
  $runningno = ltrim($runningno, '0'); // trim the leading zero
  $itemno = sprintf("%02d", substr($jobno, 17, 2)); //item number
  
  $endchar = strlen($jobno);

  if($endchar == 24){
	$additional = NULL;
	$comdat = sprintf("%04d", substr($jobno, 20, 4)); //completion date
  }
  else if($endchar == 28){
	$additional = substr($jobno, 20, 3); //item number
	$comdat = sprintf("%04d", substr($jobno, 24, 4)); //completion date  
  }
  
  if($additional == "(R)"){
	$addi = "additional = 'Replacement'";  
  }
  else if($additional == "(A)"){
	$addi = "additional = 'Amendment'"; 
  }
  else if($additional == NULL || $additional == ""){
	$addi = "(additional = '' OR additional IS NULL)";  
  }
  else{
	$addi = "ERROR";  
  }
  	
  $daterev = explode("-", $datestart);
  krsort($daterev);
  $datestartrev = implode("-", $daterev);
  
  $timehourminute = $timehour.":".$timeminute.":00";
  
  $fulldatetime = $datestartrev." ".$timehourminute;

  $dat = $comdat;
  //$quono = $companycode." ".$quodat;
  $quono = $companycode;
  
  $protab = "production_scheduling_".$dat;
?>

<table width="100%" cellspacing="0" cellpadding="2" border="0">
  
<?php
  $sqlpro = "SELECT * FROM $protab WHERE quono LIKE '$quono%' AND runningno = $runningno AND noposition = $itemno AND (jlfor = '$branch' OR (operation = 1 OR operation = 3)) AND $addi";
  $resultpro = $rundb->Query($sqlpro);
  
  if(!$resultpro){
	echo "<input type=\"hidden\" name=\"jobnofound\" id=\"jobnofound\" value=\"no\" />
		
	<tr>
	  <td>&nbsp;There is <font color=\"#FF0000\">error in the Job No</font>.<br /><br />
	  
	  &nbsp;If you believe this is an error, please contact your administrator regarding this thing.</td>
	</tr>";  
  }
  else{
    $numrowspro = $rundb->NumRows($resultpro);

    if($numrowspro != 0){
	  $rowpro = $rundb->FetchArray($resultpro);
	  
	  echo "<input type=\"hidden\" name=\"jobnofound\" id=\"jobnofound\" value=\"yes\" />
	  <input type=\"hidden\" name=\"jbno\" id=\"jbno\" value=\"$jobno\" />
      
      <tr>
	    <td>&nbsp;<strong><font color=\"#FFFF00\">$branch $companycode $quodat $runningno $itemno $additional</td>
	  </tr>";
    }
    else{
	  echo "<input type=\"hidden\" name=\"jobnofound\" id=\"jobnofound\" value=\"no\" />
	  
	  <tr>
	    <td>&nbsp;Job No <strong><font color=\"#FFFF00\">$branch $companycode $quodat $runningno $itemno $additional</font></strong> not found. Please try again.</td>
	  </tr>";
	}
  }
} 
?>
</table>
