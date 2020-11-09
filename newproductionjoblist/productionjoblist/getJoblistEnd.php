<?php 
include_once("../include/mysql_connect.php");
//require_once("../include/session.php");
//include_once("../include/admin_check.php");

session_start();

//cProductionJoblist('joblistend');

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

  $dat = $comdat;
  //$quono = $companycode." ".$quodat;
  $quono = $companycode;
  
  $protab = "production_scheduling".$com."_".$dat;
?>

<input type="hidden" name="dat" value="<?php echo $dat; ?>" />

<table width="100%" cellspacing="0" cellpadding="2" border="0">
  
<?php
  //$sqlpro = "SELECT * FROM $protab WHERE jlfor = '$branch' AND quono LIKE '$quono%' AND runningno = $runningno AND jobno = $itemno AND status = 'active' AND bid = $bid AND (additional = '' OR additional IS NULL)";
  //$sqlpro = "SELECT * FROM $protab WHERE jlfor = '$branch' AND quono LIKE '$quono%' AND runningno = $runningno AND noposition = $itemno AND status = 'active' AND bid = $bid AND (additional = '' OR additional IS NULL)";
  $sqlpro = "SELECT * FROM $protab WHERE quono LIKE '$quono%' AND runningno = $runningno AND noposition = $itemno AND (jlfor = '$branch' OR (operation = 1 OR operation = 3)) AND $addi";
  $resultpro = $rundb->Query($sqlpro);
  
  if(!$resultpro){
	echo "<tr>
	  <td>There is <font color=\"#FF0000\">error in the Job No</font>.<br /><br />
	  
	  If you believe this is an error, please contact your administrator regarding this thing.</td>
	</tr>";  
  }
  else{
    $numrowspro = $rundb->NumRows($resultpro);

    if($numrowspro != 0){
	  $rowpro = $rundb->FetchArray($resultpro);
	  
	  if($rowpro['dateofcompletion'] == NULL || $rowpro['dateofcompletion'] == "" ||  $rowpro['dateofcompletion'] == "0000-00-00"){	  
	    $sqlup = "UPDATE $protab
	  			  SET dateofcompletion = NOW()
				  WHERE sid = {$rowpro['sid']}";
		
		if($rundb->Query($sqlup)){
	      echo "<tr>
	        <td>Job No <strong><font color=\"#FFFF00\">$branch $companycode $quodat $runningno $itemno $additional</font></strong> has been ended.</td>
	      </tr>";
		}
		else{
		  echo "<tr>
	        <td>Job No <strong><font color=\"#FFFF00\">$branch $companycode $quodat $runningno $itemno $additional</font></strong> cannot be ended. Please contact your administrator regarding this thing.</td>
	      </tr>";
		}
	  }
	  else{
		echo "<tr>
	      <td>Job No <strong><font color=\"#FFFF00\">$branch $companycode $quodat $runningno $itemno $additional</font></strong> has already been ended on ".date('d-m-Y', strtotime($rowpro['dateofcompletion'])).".</td>
	    </tr>"; 
	  }
    }
    else{
	  echo "<tr>
	    <td>Job No <strong><font color=\"#FFFF00\">$branch $companycode $quodat $runningno $itemno $additional</font></strong> not found. Please try again.</td>
	  </tr>";
	}
  }
} 
?>
</table>
