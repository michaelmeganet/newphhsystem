<?php
#include_once("include/mysql_connect.php");
include_once("includes/dbh.inc.php");
include_once("includes/variables.inc.php");
//require_once("include/session.php");
//include_once("include/admin_check.php");

#session_start();

//cProductionJoblist('printsticker');

$aid = $_SESSION['phhsystemAdmin'];
	
$sqladmin = "SELECT * FROM admin WHERE aid = $aid";
$objSqladmin = new SQL($sqli);
$rowadmin = $objSqladmin->getResultOneRowArray();
#$resultadmin = $rundb->Query($sqladmin);
#$rowadmin = $rundb->FetchArray($resultadmin);

$branch = $rowadmin['branch'];
?>

<script language="javascript" type="text/javascript" src="productionjoblist/ajax_getAll.js"></script>

<table width="100%" cellspacing="0" cellpadding="2" border="0">
  <tr>
    <td>PRODUCTION JOBLIST - PRINT STICKER</td>
  </tr>
</table>

<br /><br />

<table width="100%" cellspacing="0" cellpadding="2" border="0">
  <tr>
    <td>
<form name="printsticker" enctype="multipart/form-data" action="productionjoblist/getPrintStickerPopup.php" onSubmit="return printsticker_validator(this)" method="post" target="_blank">
<input type="hidden" name="bid" id="bid" value="<?php echo $branch; ?>" />

<table width="100%" cellspacing="0" cellpadding="2" border="0">
  <tr> 
    <td>Date Issue : 
    <select name="year" id="year" onChange="getPrintSticker();">
      <option value="">Year...</option>";
    <?php
	for($y = date('Y') + 1; $y >= 2009 ; $y--){
	  if($yearqu != ""){
	    if($yearqu == $y){
		  echo "<option value=\"$y\" selected=\"selected\">$y</option>";	
	    }
	    else{
		  echo "<option value=\"$y\">$y</option>";	
	    }
	  }
	  else{
		if($y == date('Y')){
		  echo "<option value=\"$y\" selected=\"selected\">$y</option>";	
	    }
	    else{
		  echo "<option value=\"$y\">$y</option>";	
	    }  
	  }
	}
	?>
    </select>
    <select name="month" id="month" onChange="getPrintSticker();">
      <option value="">Month...</option>";
    <?php
	for($m = 1; $m <= 12; $m++){
	  if($monthqu != ""){
	    if($monthqu == $m){
		  echo "<option value=\"$m\" selected=\"selected\">$m</option>";	
	    }
	    else{
		  echo "<option value=\"$m\">$m</option>";	
	    }
	  }
	  else{
	    if($m == date('m')){
		  echo "<option value=\"$m\" selected=\"selected\">$m</option>";	
	    }
	    else{
		  echo "<option value=\"$m\">$m</option>";	
	    }
	  }
	}
	?>
    </select>
    <select name="day" id="day" onChange="getPrintSticker();">
      <option value="">Day...</option>";
    <?php
	for($d = 1; $d <= 31; $d++){
	  if($dayqu != ""){
	    if($dayqu == $d){
		  echo "<option value=\"$d\" selected=\"selected\">$d</option>";	
	    }
	    else{
		  echo "<option value=\"$d\">$d</option>";	
	    }
	  }
	  else{
		if($d == date('d')){
		  echo "<option value=\"$d\" selected=\"selected\">$d</option>";	
	    }
	    else{
		  echo "<option value=\"$d\">$d</option>";	
	    } 
	  }
	}
	?>
    </select>
    </td>
  </tr>
  <tr>
	<td>&nbsp;</td>
  </tr> 
  <tr>
	<td><div id="printsticker_data"></div></td>
  </tr> 
  <tr>
	<td>&nbsp;</td>
  </tr>
  <tr>
	<td><p><?php echo "$errcid"; ?><?php echo "<font color='#FF0000'>$err</font>"; ?><?php echo "$noerr"; ?></p></td>
  </tr>
  <tr>
	<td><input type="submit" name="submit" value="Submit">&nbsp;&nbsp;<input type="reset" name="reset" value="Reset" /></td>
  </tr>
</table>
</form>
<script language="javascript" type="text/javascript">
getPrintSticker();
</script>
	</td>
  </tr>
</table>

