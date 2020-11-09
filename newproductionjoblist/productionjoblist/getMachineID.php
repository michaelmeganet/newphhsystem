<?php 
include_once("../include/mysql_connect.php");
//require_once("../include/session.php");
//include_once("../include/admin_check.php");

session_start();

if($_GET['mcid']){ 

  $mcid = $_GET['mcid'];

  $mactab = "machine";
?>

<table width="100%" cellspacing="0" cellpadding="2" border="0">
  
<?php
  $sqlmac = "SELECT * FROM $mactab WHERE machineid = '$mcid'";
  $resultmac = $rundb->Query($sqlmac);
  
  if(!$resultmac){
	echo "<input type=\"hidden\" name=\"machinefound\" id=\"machinefound\" value=\"no\" />
		
	<tr>
	  <td>&nbsp;There is <font color=\"#FF0000\">error in the Machine ID</font>.<br /><br />
	  
	  &nbsp;If you believe this is an error, please contact your administrator regarding this thing.</td>
	</tr>";  
  }
  else{
    $numrowsmac = $rundb->NumRows($resultmac);

    if($numrowsmac != 0){
	  $rowmac = $rundb->FetchArray($resultmac);
	  
	  echo "<input type=\"hidden\" name=\"machinefound\" id=\"machinefound\" value=\"yes\" />
	  <input type=\"hidden\" name=\"mcid\" id=\"mcid\" value=\"{$rowmac['mcid']}\" />
      
      <tr>
	    <td>&nbsp;<strong><font color=\"#FFFF00\">{$rowmac['name']}</td>
	  </tr>";
    }
    else{
	  echo "<input type=\"hidden\" name=\"machinefound\" id=\"machinefound\" value=\"no\" />
	  
	  <tr>
	    <td>&nbsp;Machine ID <strong><font color=\"#FFFF00\">$mcid</font></strong> not found. Please try again.</td>
	  </tr>";
	}
  }
} 
?>
</table>
