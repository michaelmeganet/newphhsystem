<?php 
include_once("../include/mysql_connect.php");
//require_once("../include/session.php");
//include_once("../include/admin_check.php");

session_start();

if($_GET['sfid']){ 

  $sfid = $_GET['sfid'];

  $stafftab = "admin_staff";
?>

<table width="100%" cellspacing="0" cellpadding="2" border="0">
  
<?php
  $sqlstaff = "SELECT * FROM $stafftab WHERE staffid = '$sfid' AND status = 'active'";
  $resultstaff = $rundb->Query($sqlstaff);
  
  if(!$resultstaff){
	echo "<input type=\"hidden\" name=\"stafffound\" id=\"stafffound\" value=\"no\" />
	
	<tr>
	  <td>&nbsp;There is <font color=\"#FF0000\">error in the Staff ID</font>.<br /><br />
	  
	  &nbsp;If you believe this is an error, please contact your administrator regarding this thing.</td>
	</tr>";  
  }
  else{
    $numrowsstaff = $rundb->NumRows($resultstaff);

    if($numrowsstaff != 0){
	  $rowstaff = $rundb->FetchArray($resultstaff);
	  
	  echo "<input type=\"hidden\" name=\"stafffound\" id=\"stafffound\" value=\"yes\" />
	  <input type=\"hidden\" name=\"sfid\" id=\"sfid\" value=\"{$rowstaff['sfid']}\" />
      
      <tr>
	    <td>&nbsp;<strong><font color=\"#FFFF00\">{$rowstaff['name']}</td>
	  </tr>";
    }
    else{
	  echo "<input type=\"hidden\" name=\"stafffound\" id=\"stafffound\" value=\"no\" />
	  
	  <tr>
	    <td>&nbsp;Staff ID <strong><font color=\"#FFFF00\">$sfid</font></strong> not found. Please try again.</td>
	  </tr>";
	}
  }
} 
?>
</table>
