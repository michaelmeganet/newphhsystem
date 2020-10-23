<?php 
include_once("../include/mysql_connect.php");
//require_once("../include/session.php");
//include_once("../include/admin_check.php");

session_start();

//cProductionJoblist('changefinishingquantity');

if($_GET['jte'] && $_GET['sfid'] && $_GET['jno'] && $_GET['bid']){ 
  $jobtype = $_GET['jte']; //job type
  $staffid = $_GET['sfid']; //staff id
  $jobno = $_GET['jno']; //jobno
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
  
  
  if($jobtype == "bandsawcut"){
	$jobtypename = "Bandsaw Cut";  
  }
  else if($jobtype == "milling"){
	$jobtypename = "Milling";  
  }
  else if($jobtype == "millingwidth"){
	$jobtypename = "Milling Width";   
  }
  else if($jobtype == "millinglength"){
	$jobtypename = "Milling Length"; 
  }
  else if($jobtype == "roughgrinding"){
	$jobtypename = "Rough Grinding"; 
  }
  else if($jobtype == "precisiongrinding"){
	$jobtypename = "Precision Grinding";   
  }
  else if($jobtype == "cncmachining"){
	$jobtypename = "CNC Machining";   
  }
  
    	
  $daterev = explode("-", $dateend);
  krsort($daterev);
  $dateendrev = implode("-", $daterev);

  $dat = $comdat;
  $quono = $companycode;
  
  $protab = "production_scheduling_".$dat;
  $pottab = "production_output_".$dat;
?>

<input type="hidden" name="dat" value="<?php echo $dat; ?>" />

<table width="50%" cellspacing="0" cellpadding="2" border="0">
  <tr>
    <td width="5%"><u>No</u></td>
    <td width="25%"><u>Job Type</u></td>
    <td width="25%"><u>Date Start</u></td>
    <td width="25%"><u>Date End</u></td>
    <td width="20%"><u>Quantity</u></td>
  </tr>
<?php
  $i = 1;
  
  $sqlpro = "SELECT * FROM $protab WHERE quono LIKE '$quono%' AND runningno = $runningno AND noposition = $itemno  AND (jlfor = '$branch' OR (operation = 1 OR operation = 3)) AND $addi";
  $resultpro = $rundb->Query($sqlpro);
  
  if(!$resultpro){
	echo "<tr>
	  <td colspan=\"5\">There is <font color=\"#FF0000\">error in the Job No</font>.<br /><br />
	  
	  If you believe this is an error, please contact your administrator regarding this thing.</td>
	</tr>";  
  }
  else{
    $numrowspro = $rundb->NumRows($resultpro);

    if($numrowspro != 0){
	  $rowpro = $rundb->FetchArray($resultpro);
	  
	  $sqlpot = "SELECT * FROM $pottab WHERE sid = {$rowpro['sid']} AND jobtype = '$jobtype' ORDER BY poid";
	  $resultpot = $rundb->Query($sqlpot);
	  $numrowspot = $rundb->NumRows($resultpot);
	  
	  if($numrowspot == 0){	   
	    echo "<tr>
	      <td colspan=\"5\">$jobtypename Job No <strong><font color=\"#FFFF00\">$branch $companycode $quodat $runningno $itemno $additional</font></strong> has not been started.</td>
	    </tr>";
	  }
	  else{
		while($rowpot = $rundb->FetchArray($resultpot)){	
		  echo "<tr>
		    <td>$i</td>
			<td>{$rowpot['jobtype']}</td>
			<td>".date('d-m-Y H:i:s', strtotime($rowpot['date_start']))."</td>";
		    
		  if($rowpot['date_end'] == NULL || $rowpot['date_end'] == ""){			
	        echo "<td>&nbsp;</td>
			<td><input type=\"hidden\" name=\"poid[]\" id=\"poid$i\" value=\"{$rowpot['poid']}\" />
			<input type=\"hidden\" name=\"oldquantity[]\" id=\"oldquantity$i\" value=\"{$rowpot['quantity']}\" />
			<input type=\"hidden\" name=\"quantity[]\" id=\"quantity$i\" value=\"{$rowpot['quantity']}\" /></td>";
	      }
		  else{
			echo "<td>".date('d-m-Y H:i:s', strtotime($rowpot['date_end']))."</td>
			<td><input type=\"hidden\" name=\"poid[]\" id=\"poid$i\" value=\"{$rowpot['poid']}\" />
			<input type=\"hidden\" name=\"oldquantity[]\" id=\"oldquantity$i\" value=\"{$rowpot['quantity']}\" />
			<input type=\"text\" name=\"quantity[]\" id=\"quantity$i\" value=\"{$rowpot['quantity']}\" size=\"10\" /></td>";  
		  }
		  
		  $i++;
		}
	  }
    }
    else{
	  echo "<tr>
	    <td colspan=\"5\">$jobtypename Job No <strong><font color=\"#FFFF00\">$branch $companycode $quodat $runningno $itemno $additional</font></strong> not found. Please try again.</td>
	  </tr>";
	}
  }
} 
?>
</table>
