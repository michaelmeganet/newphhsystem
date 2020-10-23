<?php 
include_once("../include/mysql_connect.php");
//require_once("../include/session.php");
//include_once("../include/admin_check.php");

session_start();

//cLogisticDelivery('deliveryreturn');

//if($_GET['jobno'] && $_GET['dre'] && $_GET['bid']){ 
if($_GET['jobno'] && $_GET['bid']){ 

  $jobno = $_GET['jobno']; //jobno
  //$datereturn = $_GET['dre']; //date return
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

  //$daterev = explode("-", $datereturn);
  //krsort($daterev);
  //$datereturnrev = implode("-", $daterev);

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
	  
	  ထိုမွားယြင္းမႈကို သင္ယံုၾကည္ပါလွ်င္၊ ေက်းဇူးျပဳ၍ ထိုအေၾကာင္းအရာႏွင့္စပ္လ်ဥ္း၍ အုပ္ခ်ဳပ္ေရးမႈးႏွင့္ဆက္သြယ္ပါ။
	</tr>";  
  }
  else{
    $numrowspro = $rundb->NumRows($resultpro);

    if($numrowspro != 0){
	  $rowpro = $rundb->FetchArray($resultpro);
	  /* removal of material not yet complete then cannot do delivery
	  if($rowpro['dateofcompletion'] == NULL || $rowpro['dateofcompletion'] == "" || $rowpro['dateofcompletion'] == "0000-00-00"){ //if material not yet complete
		echo "<tr>
	      <td>Job No <strong><font color=\"#FFFF00\">$branch $companycode $quodat $runningno $itemno $additional</font></strong> has not yet been completed.</td>
	    </tr>";
	  }
	  else{ //if material completed and send for delivery
	  */
	    for($x = 1; $x <= 3; $x++){
		  $y = $x + 1;
	  
	      $delout = "delivery_out".$x;
		  $delout2 = "delivery_out".$y;
	      $delin = "delivery_in".$x;
		  
		  if($x == 1){
		    $mmattempt = "၁";
		  }
		  else if($x == 2){
			$mmattempt = "၂";  
		  }
		  else if($x == 3){
			$mmattempt = "၃";
		  }
		  
		  if($y == 1){
		    $mmattempt2 = "၁";
		  }
		  else if($y == 2){
			$mmattempt2 = "၂";  
		  }
		  else if($y == 3){
			$mmattempt2 = "၃";
		  }  

		  if($rowpro[$delout] != NULL || $rowpro[$delout] != ""){
			if($rowpro[$delin] == NULL || $rowpro[$delin] == ""){
	          $sqlup = "UPDATE $protab
	  		            SET $delin = NOW()
				        WHERE sid = {$rowpro['sid']}"; 
	  	  
		      if($rundb->Query($sqlup)){
	            echo "<tr>
	              <td valign=\"top\">Job No <strong><font color=\"#FFFF00\">$branch $companycode $quodat $runningno $itemno $additional</font></strong> <strong><font color=\"#00FF00\">Attempt $x</font></strong> has been set to Return Delivery.</td>
				  <td>&nbsp;</td>
	              <td class=\"mmfont\" valign=\"top\">အလုပ္္အမွတ္စဥ္္ <strong><font color=\"#FFFF00\">$branch $companycode $quodat $runningno $itemno $additional</font></strong> <strong><font color=\"#00FF00\">လုပ္ေဆာင္မႈ $mmattempt</font></strong> ကိုပို႔ကုန္အျဖစ္အတည္ျပဳသည္။.</td>
	            </tr>";
			    break;
		      }
		      else{
		        echo "<tr>
	              <td>Job No <strong><font color=\"#FFFF00\">$branch $companycode $quodat $runningno $itemno $additional</font></strong> <strong><font color=\"#00FF00\">Attempt $x</font></strong> cannot be set to Return Delivery. Please contact your administrator regarding this thing.</td>
				  <td class=\"mmfont\" valign=\"top\">အလုပ္အမွတ္စဥ္ <strong><font color=\"#FFFF00\">$branch $companycode $quodat $runningno $itemno $additional</font></strong> <strong><font color=\"#00FF00\">လုပ္ေဆာင္မႈ $mmattempt</font></strong> ကို ျပန္ပါလာေသာပို႔ကုန္အျဖစ္အတည္ျပဳ၍မရႏိုင္ပါ။.</td>
	            </tr>";
			
			    break;
			  }
			}
			else if($rowpro[$delin] != NULL || $rowpro[$delin] != ""){
			  if($rowpro[$delout2] == NULL || $rowpro[$delout2] == ""){
				echo "<tr>
	              <td valign=\"top\">Job No <strong><font color=\"#FFFF00\">$branch $companycode $quodat $runningno $itemno $additional</font></strong> <strong><font color=\"#00FF00\">Attempt $x</font></strong> has already been set to Return Delivery on ".date('d-m-Y', strtotime($rowpro[$delin])).".</td>
				  <td>&nbsp;</td>
				  <td class=\"mmfont\" valign=\"top\">အလုပ္္အမွတ္စဥ္္ <strong><font color=\"#FFFF00\">$branch $companycode $quodat $runningno $itemno $additional</font></strong> <strong><font color=\"#00FF00\">လုပ္ေဆာင္မႈ $mmattempt</font></strong> ကို ".date('d-m-Y', strtotime($rowpro[$delin]))." ျပန္ပါလာေသာပို႔ကုန္အျဖစ္အတည္ျပဳျပီးျဖစ္သည္။.</td>
	            </tr>";		  
			    break;
			  }
			}
		  }
		  else{
			echo "<tr>
	          <td>Job No <strong><font color=\"#FFFF00\">$branch $companycode $quodat $runningno $itemno $additional</font></strong> <strong><font color=\"#00FF00\">Attempt $x</font></strong> has not been set to Return Delivery due to haven't Delivery Out.</td>
			  <td>&nbsp;</td>
			  <td class=\"mmfont\" valign=\"top\">အလုပ္အမွတ္စဥ္ <strong><font color=\"#FFFF00\">$branch $companycode $quodat $runningno $itemno $additional</font></strong> <strong><font color=\"#00FF00\">လုပ္ေဆာင္မႈ $mmattempt</font></strong> ကိုပို႔ကုန္အျဖစ္အတည္မျပဳရေသး၍ ျပန္ပါလာေသာပို႔ကုန္အျဖစ္အတည္ျပဳ၍မရႏိုင္ပါ။.</td>
	        </tr>";
			
			break;
		  }	
	    } //end if material completed and send for delivery
	  //}
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
if($_GET['sid'] && $_GET['comdat'] && $_GET['att']){ 

  $sid = $_GET['sid']; //sid
  $comdat = sprintf("%04d", $_GET['comdat']); //completion date
  $att = $_GET['att']; //attempt

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
  $itemno = sprintf("%02d",$rowpro['jobno']); //item number
  
  if($rowpro['additional'] == "Replacement"){
	$addi = "(R)";  
  }
  else if($rowpro['additional'] == "Amendment"){
	$addi = "(A)";  
  }
  else{
	$addi = NULL;  
  }
  
  $delout = "delivery_in".$att;

  $sqlup = "UPDATE $protab
	  		SET $delout = NULL
			WHERE sid = $sid";

  if($rundb->Query($sqlup)){
	echo "<tr>
	  <td>Job No <strong>$branch $companycode $quodat $runningno $itemno $addi</strong> <strong>Attempt $att</strong> Return Delivery has been undo. Click <a href=\"../index.php?view=dyr\" class=\"link\">here</a> to go back.</td>
	</tr>";
  }
  else{
	echo "<tr>
	  <td>Job No <strong>$branch $companycode $quodat $runningno $itemno $addi</strong> <strong>Attempt $att</strong> Return Delivery cannot be undo. Please contact your administrator regarding this thing. Click <a href=\"../index.php?view=dyr\" class=\"link\">here</a> to go back.</td>
	</tr>";
  }
} 
?>
</table>