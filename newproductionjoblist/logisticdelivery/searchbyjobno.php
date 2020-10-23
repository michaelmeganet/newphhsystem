<?php
include_once("include/mysql_connect.php");

session_start();
?>

<table width="100%" cellspacing="0" cellpadding="2" border="0">
  <tr>
    <td width="49%" valign="top">LOGISTIC DELIVERY - SEARCH BY JOB NO</td>
    <td width="2%">&nbsp;</td>
    <td width="49%" class="mmfont" valign="top">အေထြေထြထုပ္ပိုးမႈဌာန - အလုပ္အမွတ္စဥ္ျဖင့္ရွာျခင္း</td>
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
	  //job no
	  if(!empty($_POST['jobno'])){
	    $jno = $_POST['jobno'];
	  }
	  else{
		$jno = FALSE;
	  }

	  if($jno){
		$jobno = $jno; //jobno
	  
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
		
		$daterev = explode("-", $dateout);
		krsort($daterev);
		$dateoutrev = implode("-", $daterev);
		
		$dat = $comdat;
		//$quono = $companycode." ".$quodat;
		$quono = $companycode;
		  
		$protab = "production_scheduling".$com."_".$dat;
		
		//$sqlpro = "SELECT * FROM $protab WHERE jlfor = '$branch' AND quono LIKE '$quono%' AND runningno = $runningno AND noposition = $itemno AND status = 'active' AND bid = $bid AND $addi";
		$sqlpro = "SELECT * FROM $protab WHERE jlfor = '$branch' AND quono LIKE '$quono%' AND runningno = $runningno AND noposition = $itemno AND status = 'active' AND $addi";
  		$resultpro = $rundb->Query($sqlpro);
		if(!$resultpro){
		  echo "<tr>
		    <td>There is <font color=\"#FF0000\">error in the Job No</font>.<br /><br />
		  
		    If you believe this is an error, please contact your administrator regarding this thing.</td>
		  </tr>";  
	    }
	    else{
		  $numrowspro = $rundb->NumRows($resultpro);
						  
		  if($numrowspro == 0){
		    echo "<tr>
			  <td>Job no $jno not found.</td>
			  <td>&nbsp;</td>
			  <td><font class=\"mmfont\">အလုပ္္အမွတ္စဥ္ $jno မေတြ႔ရွိပါ။။.</font></td>
			</tr>";
		  }
		  else{
			$rowpro = $rundb->FetchArray($resultpro);
			
		    echo "<tr>
		      <td>Job no $jno found.</td>
			  <td>&nbsp;</td>
			  <td class=\"mmfont\">အလုပ္္အမွတ္စဥ္ $jno ေတြ႕ရွိသည္။</td>
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
			  
			  	  echo "</tr>
			    </table>
			  </td>
			</tr>";
		  }
		}
	  }
	  else{
		$err = "Please enter Job no.";	
	  }
	}
	else{
		
	  $sqlbra = "SELECT * FROM branch_location";
      $resultbra = $rundb->Query($sqlbra);
      $rowbra = $rundb->FetchArray($resultbra);
      $branch = $rowbra['bid'];
  ?>
  <tr>
    <td colspan="3">
      <form name="searchinvoicedo" enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
      <input type="text" name="com_select" value="<?php echo $com; ?>" style="width:0px;" />
      <!-- <input type="hidden" name="bid" id="bid" value="<?php echo $branch; ?>" /> -->
    </td>
  </tr>
  <tr> 
    <td width="49%" valign="top">Job No entry should begin with <strong><font color="#00FFFF">AA BBB CCDD EEEE FF GGG HHII</font></strong>.<br /><br />
    
    AA = Branch<br />
    BBB = Company Code<br />
    CC = Year of Quotation Issued<br />
    DD = Month of Quotation Issued<br />
    EEEE = Running Number<br />
    FF = Item Number<br />
    GGG = (R) Replacement or (A) Amendment if any<br />
    HH = Year of Completion Date<br />
    II = Month of Completion Date</td>
    <td width="2%">&nbsp;</td>
    <td width="49%" class="mmfont" valign="top">အလုပ္နံပါတ္္ပံုစံမွာ <strong><font color="#00FFFF">AA BBB CCDD EEEE FF GGG HHII</font></strong>.<br /><br />
    
    AA = စက္ရံုခြဲ<br />
    BBB = ကုမၼဏီသေကၤတ<br />
    CC = တန္ဖိုးသတ္မွတ္လိုက္ေသာႏွစ္<br />
    DD = တန္ဖိုးသတ္မွတ္လိုက္ေသာလ<br />
    EEEE = ကုန္မွာလႊာအမွတ္စဥ္<br />
    FF = ကုန္ပစၥည္းအမွတ္စဥ္<br />
    GGG = အစားထိုးျခင္း (သို႔မဟုတ္) ျပန္လည္ျပဳျပင္ျခင္း<br />
    HH = ကုန္ပစၥည္းျပီးစီးသည့္ႏွစ္<br />
    II = ကုန္ပစၥည္းျပီးစီးသည့္လ</td>
  </tr>
  <tr>
	<td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">Enter job no / <font class="mmfont">အလုပ္္အမွတ္စဥ္ရိုက္ထည့္ျခင္း</font> : <input type="text" name="jobno" id="jobno" maxlength="28" style="width:200px" /></td>
  </tr>
  <tr>
	<td colspan="3">&nbsp;</td>
  </tr>
  <tr>
	<td colspan="3"><p><?php echo "$errcid $errmat"; ?><?php echo "<font color='#FF0000'>$err</font>"; ?><?php echo "$noerr"; ?></p></td>
  </tr>
  <tr>
	<td colspan="3"><input type="submit" name="submit" value="Search">&nbsp;&nbsp;<input type="reset" name="reset" value="Reset" /></td>
  </tr>
  </form>
  <?php
	}
  ?>
</table>
