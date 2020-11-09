<?php
include_once("include/mysql_connect.php");

session_start();
?>

<table width="100%" cellspacing="0" cellpadding="2" border="0">
  <tr>
    <td width="49%" valign="top">LOGISTIC DELIVERY - SEARCH BY RUNNING NO</td>
    <td width="2%">&nbsp;</td>
    <td width="49%" class="mmfont" valign="top">အေထြေထြထုပ္ပိုးမႈဌာန - ကုန္မွာလႊာအမွတ္စဥ္ျဖင့္ရွာျခင္း</td>
  </tr>
</table>

<br /><br />
	
<table width="100%" cellspacing="0" cellpadding="2" border="0">
  <tr>
    <td width="49%"><font style="font-size:0px">&nbsp;</font></td>
    <td width="2%"><font style="font-size:0px">&nbsp;</font></td>
    <td width="49%"><font style="font-size:0px">&nbsp;</font></td>
  </tr>
  <?php
	if($_POST['submit']){	  
	  //running no date
	  if(!empty($_POST['runningno_date'])){
	    $rdt = $_POST['runningno_date'];
	  }
	  else{
		$rdt = FALSE;
	  }
	  
	  //running no
	  if(!empty($_POST['runningno'])){
	    $rno = $_POST['runningno'];
	  }
	  else{
		$rno = FALSE;
	  }

	  if($rdt && $rno){		
		$year = substr($rdt, 0, 2);
		$month = substr($rdt, 2, 2);
		$yeda = $year."-".$month."-01";
		
		$protab = "production_scheduling_".$rdt;
		
		$rno = $rno * 1;
		$rno2 = sprintf("%04d", $rno);
		 
		$sqlpro = "SELECT * FROM $protab WHERE runningno = '$rno' AND status = 'active' ORDER BY ABS(noposition)";
		$resultpro = $rundb->Query($sqlpro);
		$numrowspro = $rundb->NumRows($resultpro);
						  
		if($numrowspro == 0){
		  echo "<tr>
		    <td>Running no $rno2 not found on Month ".date('m-Y', strtotime($yeda))."</td>
			<td>&nbsp;</td>
			<td><font class=\"mmfont\">ကုန္မွာလႊာအမွတ္စဥ္ $rno2 ကို ".date('m-Y', strtotime($yeda))." တြင္မရွာေတြ႔ပါ။.</font></td>
		  </tr>";
		}
		else{		  
		  echo "<tr>
		    <td>Running no $rno2 found on Month ".date('m-Y', strtotime($yeda)).".</td>
			<td>&nbsp;</td>
			<td><font class=\"mmfont\">ကုန္မွာလႊာအမွတ္စဥ္ $rno2 ကို ".date('m-Y', strtotime($yeda))." တြင္မရွာေတြ႔ပါ။.</font></td>
		  </tr>
		  <tr>
		    <td colspan=\"3\">&nbsp;</td>
		  </tr>
		  <tr>
		    <td colspan=\"3\">
			  <table width=\"100%\" cellspacing=\"0\" cellpadding=\"2\" border=\"1\">
				<tr>
				  <td width=\"8%\" class=\"borcol\">Date</td>
				  <td width=\"6%\" class=\"borcol\">Company</td>
				  <td width=\"16%\" class=\"borcol\">Job No</td>
				  <td width=\"10%\" class=\"borcol\">Packing / Complete Item</td>
				  <td width=\"10%\" class=\"borcol\">Delivery Out<br />Attempt 1</td>
				  <td width=\"10%\" class=\"borcol\">Delivery In<br />Attempt 1</td>
				  <td width=\"10%\" class=\"borcol\">Delivery Out<br />Attempt 2</td>
				  <td width=\"10%\" class=\"borcol\">Delivery In<br />Attempt 2</td>
				  <td width=\"10%\" class=\"borcol\">Delivery Out<br />Attempt 3</td>
				  <td width=\"10%\" class=\"borcol\">Delivery In<br />Attempt 3</td>
				</tr>
				<tr class=\"borcol\">
				  <td class=\"mmfont\">ရက္စြဲ</td>
				  <td class=\"mmfont\">ကုမၼဏီ</td>
				  <td class=\"mmfont\">အလုပ္အမွတ္စဥ္</td>
				  <td class=\"mmfont\">ထုပ္ပိုးျခင္း / ျပီးဆံုးသည့္ပစၥည္း</td>
				  <td class=\"mmfont\">ျပင္ပပို႔ကုန္လုပ္ေဆာင္မႈ ၁</td>
				  <td class=\"mmfont\">ျပင္ပမွတင္သြင္း ကုန္လုပ္ေဆာင္မႈ ၁</td>
				  <td class=\"mmfont\">ျပင္ပပို႔ကုန္လုပ္ေဆာင္မႈ ၂</td>
				  <td class=\"mmfont\">ျပင္ပမွတင္သြင္း ကုန္လုပ္ေဆာင္မႈ ၂</td>
				  <td class=\"mmfont\">ျပင္ပပို႔ကုန္လုပ္ေဆာင္မႈ ၃</td>
				  <td class=\"mmfont\">ျပင္ပမွတင္သြင္း ကုန္လုပ္ေဆာင္မႈ ၃</td>
				</tr>";
		
		  while($rowpro = $rundb->FetchArray($resultpro)){			
			/* old version
			$branch = $rowpro['jlfor']; //CJ or SB
			$quono = substr($rowpro['quono'], 0, 3);
			$runningno = sprintf("%04d", $rowpro['runningno']);
			$orderno = sprintf("%02d", $rowpro['noposition']);
			
			$manualquo = substr($rowpro['quono'], 9, 1);
			
			if($manualquo == "M"){			  
		      $dateissue = substr($rowpro['quono'], 4, 4);
			}
			else{
			  $yedat = substr($rowpro['date_issue'], 2, 2);
		      $modat = substr($rowpro['date_issue'], 5, 2);
		      $dateissue = $yedat.$modat;
			}
			*/
			
			$ivye = substr($rowpro['ivdate'], 2, 2);
		    $ivmo = substr($rowpro['ivdate'], 5, 2);
	 
		    $runningno = sprintf("%04d", $rowpro['runningno']);  
	
		    if($rowpro['noposition'] != "" && $rowpro['noposition'] != 0){
		  	  $jobno = sprintf("%02d", $rowpro['noposition']);  
		    }
		    else{
			  $jobno = sprintf("%02d", $rowpro['jobno']);
		    }
		  
		    $branchjoblist = $rowpro['jlfor'];
		  
		    $quono = substr($rowpro['quono'], 0, 3);
		  
		    //manual orderlist use quotation number to get date due to date of issue can be on october 2011 and replacement of the joblist can be on june 2011
		    if($rowpro['omid'] != NULL && $rowpro['omid'] != ""){
			  $dateissue = substr($rowpro['quono'], 4, 4);
		    }
		    else{
			  $yedat = substr($rowpro['date_issue'], 2, 2);
			  $modat = substr($rowpro['date_issue'], 5, 2);
			  $dateissue = $yedat.$modat;
		    }
			
			if($rowpro['additional'] == "Replacement"){
			  $additional = "(R)";
			  $dateissue = substr($rowpro['quono'], 4, 4);
		    }
		    else if($rowpro['additional'] == "Amendment"){
			  $additional = "(A)"; 
			  $dateissue = substr($rowpro['quono'], 4, 4);
		    }
		    else{
			  $additional = "";  
		    }

			echo "<tr>
			  <td>".date("d-m-y", strtotime($rowpro['ivdate']))."</td>
			  <td>{$rowpro['company']}</td>
			  <td>$branchjoblist $quono $dateissue $runningno $jobno $additional</td>";
			  //$branch $quono $dateissue $runningno $orderno
			  
			  if($rowpro['packing'] == "" || $rowpro['packing'] == NULL){
			    echo "<td>&nbsp;</td>";
			  }
			  else{
				echo "<td>".date("d-m-y", strtotime($rowpro['packing']))."</td>";  
			  }
			  
			  if($rowpro['delivery_out1'] == "" || $rowpro['delivery_out1'] == NULL){
			    echo "<td>&nbsp;</td>";
			  }
			  else{
				echo "<td>".date("d-m-y", strtotime($rowpro['delivery_out1']))."</td>";  
			  }
			  
			  if($rowpro['delivery_in1'] == "" || $rowpro['delivery_in1'] == NULL){
			    echo "<td>&nbsp;</td>";
			  }
			  else{
				echo "<td>".date("d-m-y", strtotime($rowpro['delivery_in1']))."</td>";  
			  }
			  
			  if($rowpro['delivery_out2'] == "" || $rowpro['delivery_out2'] == NULL){
			    echo "<td>&nbsp;</td>";
			  }
			  else{
				echo "<td>".date("d-m-y", strtotime($rowpro['delivery_out2']))."</td>";  
			  }
			  
			  if($rowpro['delivery_in2'] == "" || $rowpro['delivery_in2'] == NULL){
			    echo "<td>&nbsp;</td>";
			  }
			  else{
				echo "<td>".date("d-m-y", strtotime($rowpro['delivery_in2']))."</td>";  
			  }
			  
			  if($rowpro['delivery_out3'] == "" || $rowpro['delivery_out3'] == NULL){
			    echo "<td>&nbsp;</td>";
			  }
			  else{
				echo "<td>".date("d-m-y", strtotime($rowpro['delivery_out3']))."</td>";  
			  }
			  
			  if($rowpro['delivery_in3'] == "" || $rowpro['delivery_in3'] == NULL){
			    echo "<td>&nbsp;</td>";
			  }
			  else{
				echo "<td>".date("d-m-y", strtotime($rowpro['delivery_in3']))."</td>";  
			  }
			  
			echo "</tr>";
		  }
		}
	  }
	  else{
		$err = "Please enter running no.";	
	  }
	}
	else{
		
	  $sqlbra = "SELECT * FROM branch_location";
      $resultbra = $rundb->Query($sqlbra);
      $rowbra = $rundb->FetchArray($resultbra);
      $branch = $rowbra['bid'];
  ?>
  <tr>
    <td>
      <form name="searchinvoicedo" enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
      <input type="text" name="com_select" value="<?php echo $com; ?>" style="width:0px;" />
      <!-- <input type="hidden" name="bid" id="bid" value="<?php echo $branch; ?>" /> -->
    </td>
  </tr>
  <tr>
	<td>Date / <font class="mmfont">ရက္စြဲ</font> : 
    <select name="runningno_date" id="runningno_date">
      <option value="">Select date...</option>";
      <?php
      for($y = date('Y'); $y >= 2010 ; $y--){
		$yrs = $y + 1;
		$yrsyrs = $yrs + 1;  
		  
        if($y != date('Y')){
          for($m = 12; $m >= 1; $m--){
            echo "<option value=\"".date('y', mktime(0, 0, 0, 0, 0, $yrs)).sprintf("%02d", $m)."\">$y-".sprintf("%02d", $m)."</option>";	
          }
        }
        else{
          for($m = date('m') + 1; $m >= 1; $m--){
			if($m > 12){
			  echo "<option value=\"".date('y', mktime(0, 0, 0, 0, 0, $yrsyrs)).sprintf("%02d", 1)."\" selected=\"selected\">$yrs-".sprintf("%02d", 1)."</option>";
		    }
			else{
			  if($m == date('m')){
                echo "<option value=\"".date('y', mktime(0, 0, 0, 0, 0, $yrs)).sprintf("%02d", $m)."\" selected=\"selected\">$y-".sprintf("%02d", $m)."</option>";	
			  }
			  else{
			    echo "<option value=\"".date('y', mktime(0, 0, 0, 0, 0, $yrs)).sprintf("%02d", $m)."\">$y-".sprintf("%02d", $m)."</option>";	
			  }
			}
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
    <td>Enter running no / <font class="mmfont">ကုန္မွာလႊာအမွတ္စဥ္ရိုက္ထည့္ျခင္း</font> : <input type="text" name="runningno" maxlength="4" id="invoiceno" class="swidth4" /></td>
  </tr>
  <tr>
	<td>&nbsp;</td>
  </tr>
  <tr>
	<td><p><?php echo "$errcid $errmat"; ?><?php echo "<font color='#FF0000'>$err</font>"; ?><?php echo "$noerr"; ?></p></td>
  </tr>
  <tr>
	<td><input type="submit" name="submit" value="Search">&nbsp;&nbsp;<input type="reset" name="reset" value="Reset" /></td>
  </tr>
  </form>
  <?php
	}
  ?>
</table>
