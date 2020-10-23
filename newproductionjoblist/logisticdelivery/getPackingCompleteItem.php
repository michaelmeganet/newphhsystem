<?php 
include_once("../include/mysql_connect.php");

session_start();

if($_GET['jobno'] && $_GET['bid']){ 

  $jobno = $_GET['jobno']; //jobno
  $bid = $_GET['bid']; //branch id
  
  $branch = substr($jobno, 0, 2); //CJ or SB
  $companycode = substr($jobno, 3, 3); //company code
  $quodat = sprintf("%04d", substr($jobno, 7, 4)); //quotation date
  $runningno = sprintf("%04d", substr($jobno, 12, 4)); //running number
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
  <tr>
    <td width="49%">&nbsp;</td>
    <td width="2%">&nbsp;</td>
    <td width="49%">&nbsp;</td>
  </tr>
<?php
  //$sqlpro = "SELECT * FROM $protab WHERE jlfor = '$branch' AND quono LIKE '$quono%' AND runningno = $runningno AND jobno = $itemno AND status = 'active' AND bid = $bid AND (additional = '' OR additional IS NULL)";
  //$sqlpro = "SELECT * FROM $protab WHERE jlfor = '$branch' AND quono LIKE '$quono%' AND runningno = $runningno AND noposition = $itemno AND status = 'active' AND bid = $bid AND (additional = '' OR additional IS NULL)";
  $sqlpro = "SELECT * FROM $protab WHERE jlfor = '$branch' AND quono LIKE '$quono%' AND runningno = $runningno AND noposition = $itemno AND status = 'active' AND bid = $bid AND $addi";
  $resultpro = $rundb->Query($sqlpro);
  
  if(!$resultpro){
	echo "<tr>
	  <td>There is <font color=\"#FF0000\">error in the Job No</font>.<br /><br />
	  
	  If you believe this is an error, please contact your administrator regarding this thing.</td>
	  <td>&nbsp;</td>
      <td class=\"mmfont\" valign=\"top\"><font color=\"#FF0000\">အလုပ္အမွတ္စဥ္တြင္ မွားယြင္းမႈ</font> ျဖစ္ေနသည္။.<br /><br />
	  
	  ထိုမွားယြင္းမႈကို သင္ယံုၾကည္ပါလွ်င္၊ ေက်းဇူးျပဳ၍ ထိုအေၾကာင္းအရာႏွင့္စပ္လ်ဥ္း၍ အုပ္ခ်ဳပ္ေရးမႈးႏွင့္ဆက္သြယ္ပါ။</td>
	</tr>";  
  }
  else{
    $numrowspro = $rundb->NumRows($resultpro);

    if($numrowspro != 0){
	  $rowpro = $rundb->FetchArray($resultpro);
	  
	  if($rowpro['packing'] == NULL || $rowpro['packing'] == ""){
		if($rowpro['dateofcompletion'] == NULL || $rowpro['dateofcompletion'] == ""){	  
	      $sqlup = "UPDATE $protab
	  			    SET packing = NOW(), dateofcompletion = NOW()
				    WHERE sid = {$rowpro['sid']}";
		}
		else{
		  $sqlup = "UPDATE $protab
	  			    SET packing = NOW()
				    WHERE sid = {$rowpro['sid']}";
		}
		
		if($rundb->Query($sqlup)){
	      echo "<tr>
		    <td valign=\"top\">Job No <strong><font color=\"#FFFF00\">$branch $companycode $quodat $runningno $itemno $additional</font></strong> has been set item Packing/Complete.</td>
			<td>&nbsp;</td>
	        <td class=\"mmfont\" valign=\"top\">အလုပ္အမွတ္စဥ္ <strong><font color=\"#FFFF00\">$branch $companycode $quodat $runningno $itemno $additional</font></strong> ထုပ္ပိုးျခင္း/ျပီးဆံုးသည့္ပစၥည္းအျဖစ္ အတည္ျပဳသည္။</td>
	      </tr>";
		}
		else{
		  echo "<tr>
	        <td>Job No <strong><font color=\"#FFFF00\">$branch $companycode $quodat $runningno $itemno $additional</font></strong> cannot be set item Packing/Complete. Please contact your administrator regarding this thing.</td>
			<td>&nbsp;</td>
		    <td class=\"mmfont\" valign=\"top\">အလုပ္အမွတ္စဥ္ <strong><font color=\"#FFFF00\">$branch $companycode $quodat $runningno $itemno $additional</font></strong> တြင္ ထုပ္ပိုးျခင္း/ျပီးဆံုးသည့္ပစၥည္းအျဖစ္ အတည္ျပဳ၍မရႏိုင္ပါ။. ထိုမွားယြင္းမႈကို သင္ယံုၾကည္ပါလွ်င္၊ ေက်းဇူးျပဳ၍ ထိုအေၾကာင္းအရာႏွင့္စပ္လ်ဥ္း၍ အုပ္ခ်ဳပ္ေရးမႈးႏွင့္ဆက္သြယ္ပါ။.</td>
	      </tr>";
		}
	  }
	  else{
		echo "<tr>
	      <td valign=\"top\">Job No <strong><font color=\"#FFFF00\">$branch $companycode $quodat $runningno $itemno $additional</font></strong> has already been set item Packing/Complete on ".date('d-m-Y', strtotime($rowpro['packing'])).".</td>
		  <td>&nbsp;</td>
	      <td class=\"mmfont\" valign=\"top\">အလုပ္အမွတ္စဥ္  <strong><font color=\"#FFFF00\">$branch $companycode $quodat $runningno $itemno $additional</font></strong> ကို ".date('d-m-Y', strtotime($rowpro['packing']))." တြင္ ထုပ္ပိုးျခင္း/ျပီးဆံုးသည့္ပစၥည္းအျဖစ္ အတည္ျပဳျပီးျဖစ္သည္။.</td>
	    </tr>";
	  }
    }
    else{
	  echo "<tr>
	    <td valign=\"top\">Job No <strong><font color=\"#FFFF00\">$branch $companycode $quodat $runningno $itemno $additional</font></strong> not found. Please try again.</td>
		<td>&nbsp;</td>
		<td class=\"mmfont\" valign=\"top\">အလုပ္္အမွတ္စဥ္ <strong><font color=\"#FFFF00\">$branch $companycode $quodat $runningno $itemno $additional</font></strong> မေတြ႔ရွိပါ။.</td>
	  </tr>";
	}
  }
} 
?>
</table>

<?php
if($_GET['sid'] && $_GET['comdat']){ 

  $sid = $_GET['sid']; //sid
  $comdat = sprintf("%04d", $_GET['comdat']); //completion date

  $dat = $comdat;
  
  $protab = "production_scheduling".$com."_".$dat;
?>

<input type="hidden" name="dat" value="<?php echo $dat; ?>" />

<table width="100%" cellspacing="0" cellpadding="2" border="0">
  
<?php
  $sqlpro = "SELECT * FROM $protab WHERE sid = $sid";
  $resultpro = $rundb->Query($sqlpro);
  $rowpro = $rundb->FetchArray($resultpro);
  
  $branch = $rowpro['jlfor']; //CJ or SB
  $companycode = substr($rowpro['quono'], 0, 3); //company code
  $quodat = sprintf("%04d", substr($rowpro['quono'], 4, 4)); //quotation date
  $runningno = sprintf("%04d", $rowpro['runningno']); //running number
  $itemno = sprintf("%02d", $rowpro['jobno']); //item number
  
  if($rowpro['additional'] == "Replacement"){
	$addi = "(R)";  
  }
  else if($rowpro['additional'] == "Amendment"){
	$addi = "(A)";  
  }
  else{
	$addi = NULL;  
  }

  $sqlup = "UPDATE $protab
	  		SET packing = NULL
			WHERE sid = $sid";

  if($rundb->Query($sqlup)){
	echo "<tr>
	  <td>Job No <strong>$branch $companycode $quodat $runningno $itemno $addi</strong> set item Packing/Complete has been undo. Click <a href=\"../index.php?view=pkg\" class=\"link\">here</a> to go back.</td>
	</tr>";
  }
  else{
	echo "<tr>
	  <td>Job No <strong>$branch $companycode $quodat $runningno $itemno $addi</strong> set item Packing/Complete cannot be undo. Please contact your administrator regarding this thing. Click <a href=\"../index.php?view=pkg\" class=\"link\">here</a> to go back.</td>
	</tr>";
  }
} 
?>
</table>
