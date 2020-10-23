<?php
include_once("include/mysql_connect.php");

session_start();
?>

<table width="100%" cellspacing="0" cellpadding="2" border="0">
  <tr>
    <td width="49%" valign="top">PRODUCTION JOBLIST - SEARCH BY RUNNING NO</td>
    <td width="2%">&nbsp;</td>
    <td width="49%" class="mmfont" valign="top">ကုန္ထုတ္လုပ္မႈအလုပ္စာရင္း - ကုန္မွာလႊာအမွတ္စဥ္ျဖင့္ရွာျခင္း</td>
  </tr>
</table>

<br /><br />
	
<table width="1800" cellspacing="0" cellpadding="2" border="0">
  <tr>
    <td width="34%"><font style="font-size:0px">&nbsp;</font></td>
    <td width="2%"><font style="font-size:0px">&nbsp;</font></td>
    <td width="64%"><font style="font-size:0px">&nbsp;</font></td>
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
		$pottab = "production_output_".$rdt;
		
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
				  <td width=\"5%\" class=\"borcol\">Date</td>
				  <td width=\"5%\" class=\"borcol\">Company</td>
				  <td width=\"10s%\" class=\"borcol\">Job No</td>
				  <td width=\"11%\" class=\"borcol\">Process</td>
				  <td width=\"1%\" class=\"borcol\">CNC</td>
				  <td width=\"1%\" class=\"borcol\">Qty</td>
				  <td width=\"4%\" class=\"borcol\">Packing / Complete Item</td>
				  <td width=\"3%\" class=\"borcol\">Bandsaw Cut Start</td>
				  <td width=\"3%\" class=\"borcol\">Bandsaw Cut End</td>
				  <td width=\"1%\" class=\"borcol\">Qty</td>
				  <td width=\"3%\" class=\"borcol\">Manual Cut Start</td>
				  <td width=\"3%\" class=\"borcol\">Manaul Cut End</td>
				  <td width=\"1%\" class=\"borcol\">Qty</td>
				  <td width=\"3%\" class=\"borcol\">Milling Thickness Start</td>
				  <td width=\"3%\" class=\"borcol\">Milling Thickness End</td>
				  <td width=\"1%\" class=\"borcol\">Qty</td>
				  <td width=\"3%\" class=\"borcol\">Milling Width Start</td>
				  <td width=\"3%\" class=\"borcol\">Milling Width End</td>
				  <td width=\"1%\" class=\"borcol\">Qty</td>
				  <td width=\"3%\" class=\"borcol\">Milling Length Start</td>
				  <td width=\"3%\" class=\"borcol\">Milling Length End</td>
				  <td width=\"1%\" class=\"borcol\">Qty</td>
				  <td width=\"3%\" class=\"borcol\">Rough Grinding Start</td>
				  <td width=\"3%\" class=\"borcol\">Rough Grinding End</td>
				  <td width=\"1%\" class=\"borcol\">Qty</td>
				  <td width=\"3%\" class=\"borcol\">Precision Grinding Start</td>
				  <td width=\"3%\" class=\"borcol\">Precision Grinding End</td>
				  <td width=\"1%\" class=\"borcol\">Qty</td>
				  <td width=\"3%\" class=\"borcol\">CNC Machining Start</td>
				  <td width=\"3%\" class=\"borcol\">CNC Machining End</td>
				  <td width=\"1%\" class=\"borcol\">Qty</td>
				</tr>
				<tr class=\"borcol\">
				  <td class=\"mmfont\">ရက္စြဲ</td>
				  <td class=\"mmfont\">ကုမၼဏီ</td>
				  <td class=\"mmfont\">အလုပ္အမွတ္စဥ္</td>
				  <td class=\"borcol\">Process</td>
				  <td class=\"borcol\">CNC</td>
				  <td class=\"borcol\">Qty</td>
				  <td class=\"mmfont\">ထုပ္ပိုးျခင္း / ျပီးဆံုးသည့္ပစၥည္း</td>
				  <td class=\"mmfont\">Bandsaw Cut အလုပ္စာရင္း စတင္ခ်ိန္</td>
				  <td class=\"mmfont\">Bandsaw Cut အလုပ္စာရင္း အဆံုးသတ္ခ ်ိန္</td>
				  <td class=\"borcol\">Qty</td>
				  <td class=\"mmfont\">Manual Cut Start</td>
				  <td class=\"mmfont\">Manual Cut End</td>
				  <td class=\"borcol\">Qty</td>
				  <td class=\"mmfont\">Milling Thickness အလုပ္စာရင္း စတင္ခ်ိန္</td>
				  <td class=\"mmfont\">Milling Thickness အလုပ္စာရင္း အဆံုးသတ္ခ ်ိန္</td>
				  <td class=\"borcol\">Qty</td>
				  <td class=\"mmfont\">Milling Width အလုပ္စာရင္း စတင္ခ်ိန္</td>
				  <td class=\"mmfont\">Milling Width အလုပ္စာရင္း အဆံုးသတ္ခ ်ိန္</td>
				  <td class=\"borcol\">Qty</td>
				  <td class=\"mmfont\">Milling Length အလုပ္စာရင္း စတင္ခ်ိန္</td>
				  <td class=\"mmfont\">Milling Length အလုပ္စာရင္း အဆံုးသတ္ခ ်ိန္</td>
				  <td class=\"borcol\">Qty</td>
				  <td class=\"mmfont\">Rough Grinding အလုပ္စာရင္း စတင္ခ်ိန္</td>
				  <td class=\"mmfont\">Rough Grinding အလုပ္စာရင္း အဆံုးသတ္ခ ်ိန္</td>
				  <td class=\"borcol\">Qty</td>
				  <td class=\"mmfont\">Precision Grinding အလုပ္စာရင္း စတင္ခ်ိန္</td>
				  <td class=\"mmfont\">Precision Grinding အလုပ္စာရင္း အဆံုးသတ္ခ ်ိန္</td>
				  <td class=\"borcol\">Qty</td>
				  <td class=\"mmfont\">CNC Machining အလုပ္စာရင္း စတင္ခ်ိန္</td>
				  <td class=\"mmfont\">CNC Machining အလုပ္စာရင္း အဆံုးသတ္ခ ်ိန္</td>
				  <td class=\"borcol\">Qty</td>
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
			  
			  if($rowpro['process'] == "" || $rowpro['process'] == NULL){
			    echo "<td>&nbsp;</td>";
			  }
			  else{
				if($rowpro['company'] == "PTPHH"){
				  $pretab = "premachining_ptphh";	
				}
				else{
				  $pretab = "premachining";
				}
				
			    $sqlpre = "SELECT * FROM $pretab WHERE pmid = {$rowpro['process']}";
			    $resultpre = $rundb->Query($sqlpre);
			    $rowpre = $rundb->FetchArray($resultpre);
			  
			    echo "<td>{$rowpre['process']}</td>";
			  }
			  
			  if($rowpro['cncmach'] == "0.00" || $rowpro['cncmach'] == NULL){
			    echo "<td>&nbsp;</td>";
			  }
			  else{
			    echo "<td valign=\"top\">&radic;</td>";
			  }
					
			  
			  echo "<td valign=\"top\">{$rowpro['quantity']}</td>";
			  
			  if($rowpro['packing'] == "" || $rowpro['packing'] == NULL){
			    echo "<td>&nbsp;</td>";
			  }
			  else{
			    echo "<td valign=\"top\">".date("d-m-y", strtotime($rowpro['packing']))."</td>";  
			  }
			  
			  //begin bandsaw start date
			  echo "<td valign=\"top\">
			    <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
			  			  
			    $sqlpotbws = "SELECT * FROM $pottab WHERE sid = {$rowpro['sid']} AND jobtype = 'bandsaw'";
			    $resultpotbws = $rundb->Query($sqlpotbws);
			  	$numrowspotbws = $rundb->NumRows($resultpotbws);
				
				if($numrowspotbws == 0){ //begin if new version of tracking date dont have, take old date
				  if($rowpro['bandsawcut_start'] == "" || $rowpro['bandsawcut_start'] == NULL){
					echo "<tr>
					  <td>&nbsp;</td>
					</tr>";
				  }
				  else{
					echo "<tr>
					  <td>".date("d-m-y", strtotime($rowpro['bandsawcut_start']))."</td>
					</tr>";  
				  }	  
				}  //end if new version of tracking date dont have, take old date
				else{
			      while($rowpotbws = $rundb->FetchArray($resultpotbws)){
  				    if($rowpotbws['date_start'] == "" || $rowpotbws['date_start'] == NULL){
					  echo "<tr>
					    <td>&nbsp;</td>
					  </tr>";
				    }
				    else{
					  echo "<tr>
					    <td>".date("d-m-y", strtotime($rowpotbws['date_start']))."</td>
					  </tr>";  
				    }	
				  }
			    }
				
			  echo "</table>
			  </td>";
			  //end bandsaw start date
			  
			  //begin bandsaw end date
			  echo "<td valign=\"top\">
			    <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
			  			  
			    $sqlpotbwe = "SELECT * FROM $pottab WHERE sid = {$rowpro['sid']} AND jobtype = 'bandsaw'";
			    $resultpotbwe = $rundb->Query($sqlpotbwe);
			  	$numrowspotbwe = $rundb->NumRows($resultpotbwe);
				
				if($numrowspotbws == 0){ //begin if new version of tracking date dont have, take old date
				  if($rowpro['bandsawcut_end'] == "" || $rowpro['bandsawcut_end'] == NULL){
					echo "<tr>
					  <td>&nbsp;</td>
					</tr>";
				  }
				  else{
					echo "<tr>
					  <td>".date("d-m-y", strtotime($rowpro['bandsawcut_end']))."</td>
					</tr>";  
				  }
				}  //end if new version of tracking date dont have, take old date
				else{	  
			      while($rowpotbwe = $rundb->FetchArray($resultpotbwe)){
  				    if($rowpotbwe['date_end'] == "" || $rowpotbwe['date_end'] == NULL){
					  echo "<tr>
					    <td>&nbsp;</td>
					  </tr>";
				    }
				    else{
					  echo "<tr>
					    <td>".date("d-m-y", strtotime($rowpotbwe['date_end']))."</td>
					  </tr>";  
					}
				  }	
			    }
				
			  echo "</table>
			  </td>";
			  //end bandsaw end date
			  
			  //begin bandsaw quantity
			  echo "<td valign=\"top\">
			    <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
			  			  
			    $sqlpotbwq = "SELECT * FROM $pottab WHERE sid = {$rowpro['sid']} AND jobtype = 'bandsaw'";
			    $resultpotbwq = $rundb->Query($sqlpotbwq);
			  	$numrowspotbwq = $rundb->NumRows($resultpotbwq);
				
				if($numrowspotbwq == 0){ //begin if new version of tracking dont have quantity, take old no quantity
				  echo "<tr>
				      <td>&nbsp;</td>
				    </tr>";
				}  //end if new version of tracking dont have quantity, take old no quantity
				else{
			      while($rowpotbwq = $rundb->FetchArray($resultpotbwq)){
  				    echo "<tr>
				      <td>{$rowpotbwq['quantity']}</td>
				    </tr>";	
				  }
			    }
				
			  echo "</table>
			  </td>";
			  //end bandsaw quantity
##############################################################################
#Manual cut start
			  //begin manual cut start date
			  echo "<td valign=\"top\">
			    <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
			  			  
			    $sqlpotbws = "SELECT * FROM $pottab WHERE sid = {$rowpro['sid']} AND jobtype = 'manual'";
			   
			    $resultpotbws = $rundb->Query($sqlpotbws);
			  	$numrowspotbws = $rundb->NumRows($resultpotbws);
				
				if($numrowspotbws == 0){ //begin if new version of tracking date dont have, take old date
				  if($rowpro['manual_start'] == "" || $rowpro['manual_start'] == NULL){
					echo "<tr>
					  <td>&nbsp;</td>
					</tr>";
				  }
				  else{
					echo "<tr>
					  <td>".date("d-m-y", strtotime($rowpro['manual_start']))."</td>
					</tr>";  
				  }	  
				}  //end if new version of tracking date dont have, take old date
				else{
			      while($rowpotbws = $rundb->FetchArray($resultpotbws)){
  				    if($rowpotbws['date_start'] == "" || $rowpotbws['date_start'] == NULL){
					  echo "<tr>
					    <td>&nbsp;</td>
					  </tr>";
				    }
				    else{
					  echo "<tr>
					    <td>".date("d-m-y", strtotime($rowpotbws['date_start']))."</td>
					  </tr>";  
				    }	
				  }
			    }
				
			  echo "</table>
			  </td>";
			  //end manual cut start date
			  
			  //begin manual cut end date
			  echo "<td valign=\"top\">
			    <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
			  			  
			    $sqlpotbwe = "SELECT * FROM $pottab WHERE sid = {$rowpro['sid']} AND jobtype = 'manual'";
			    $resultpotbwe = $rundb->Query($sqlpotbwe);
			  	$numrowspotbwe = $rundb->NumRows($resultpotbwe);
				// echo "\$sqlpotbwe = $sqlpotbwe <br>";
				if($numrowspotbws == 0){ //begin if new version of tracking date dont have, take old date
				  if($rowpro['manual'] == "" || $rowpro['manual'] == NULL){
					echo "<tr>
					  <td>&nbsp;</td>
					</tr>";
				  }
				  else{
					echo "<tr>
					  <td>".date("d-m-y", strtotime($rowpro['manual_end']))."</td>
					</tr>";  
				  }
				}  //end if new version of tracking date dont have, take old date
				else{	  
			      while($rowpotbwe = $rundb->FetchArray($resultpotbwe)){
  				    if($rowpotbwe['date_end'] == "" || $rowpotbwe['date_end'] == NULL){
					  echo "<tr>
					    <td>&nbsp;</td>
					  </tr>";
				    }
				    else{
					  echo "<tr>
					    <td>".date("d-m-y", strtotime($rowpotbwe['date_end']))."</td>
					  </tr>";  
					}
				  }	
			    }
				
			  echo "</table>
			  </td>";
			  //end manual cut end date
			  
			  //begin manual cut quantity
			  echo "<td valign=\"top\">
			    <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
			  			  
			    $sqlpotbwq = "SELECT * FROM $pottab WHERE sid = {$rowpro['sid']} AND jobtype = 'manual'";
			    $resultpotbwq = $rundb->Query($sqlpotbwq);
			  	$numrowspotbwq = $rundb->NumRows($resultpotbwq);
				
				if($numrowspotbwq == 0){ //begin if new version of tracking dont have quantity, take old no quantity
				  echo "<tr>
				      <td>&nbsp;</td>
				    </tr>";
				}  //end if new version of tracking dont have quantity, take old no quantity
				else{
			      while($rowpotbwq = $rundb->FetchArray($resultpotbwq)){
  				    echo "<tr>
				      <td>{$rowpotbwq['quantity']}</td>
				    </tr>";	
				  }
			    }
				
			  echo "</table>
			  </td>";
			  //end manual cut quantity
#####Manual Cut End                          
################################################################################3\\\			  
			  
			  //begin milling start date
			  echo "<td valign=\"top\">
			    <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
			  			  
			    $sqlpotmgs = "SELECT * FROM $pottab WHERE sid = {$rowpro['sid']} AND jobtype = 'milling'";
			    $resultpotmgs = $rundb->Query($sqlpotmgs);
			  	$numrowspotmgs = $rundb->NumRows($resultpotmgs);
				
				if($numrowspotmgs == 0){ //begin if new version of tracking date dont have, take old date
				  if($rowpro['milling_start'] == "" || $rowpro['milling_start'] == NULL){
					echo "<tr>
					  <td>&nbsp;</td>
					</tr>";
				  }
				  else{
					echo "<tr>
					  <td>".date("d-m-y", strtotime($rowpro['milling_start']))."</td>
					</tr>";  
				  }	  
				}  //end if new version of tracking date dont have, take old date
				else{	  
			      while($rowpotmgs = $rundb->FetchArray($resultpotmgs)){
  				    if($rowpotmgs['date_start'] == "" || $rowpotmgs['date_start'] == NULL){
					  echo "<tr>
					    <td>&nbsp;</td>
					  </tr>";
				    }
				    else{
					  echo "<tr>
					    <td>".date("d-m-y", strtotime($rowpotmgs['date_start']))."</td>
					  </tr>";
					}
				  }	
			    }
				
			  echo "</table>
			  </td>";
			  //end milling start date
			  
			  //begin milling end date
			  echo "<td valign=\"top\">
			    <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
			  			  
			    $sqlpotmge = "SELECT * FROM $pottab WHERE sid = {$rowpro['sid']} AND jobtype = 'milling'";
			    $resultpotmge = $rundb->Query($sqlpotmge);
			  	$numrowspotmge = $rundb->NumRows($resultpotmge);
				
				if($numrowspotmge == 0){ //begin if new version of tracking date dont have, take old date
				  if($rowpro['milling_end'] == "" || $rowpro['milling_end'] == NULL){
					echo "<tr>
					  <td>&nbsp;</td>
					</tr>";
				  }
				  else{
					echo "<tr>
					  <td>".date("d-m-y", strtotime($rowpro['milling_end']))."</td>
					</tr>";  
				  }	  
				}  //end if new version of tracking date dont have, take old date
				else{	  
			      while($rowpotmge = $rundb->FetchArray($resultpotmge)){
  				    if($rowpotmge['date_end'] == "" || $rowpotmge['date_end'] == NULL){
					  echo "<tr>
					    <td>&nbsp;</td>
					  </tr>";
				    }
				    else{
					  echo "<tr>
					    <td>".date("d-m-y", strtotime($rowpotmge['date_end']))."</td>
					  </tr>";  
					}
				  }	
			    }
				
			  echo "</table>
			  </td>";
			  //end milling end date
			  
			  //begin milling quantity
			  echo "<td valign=\"top\">
			    <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
			  			  
			    $sqlpotmgq = "SELECT * FROM $pottab WHERE sid = {$rowpro['sid']} AND jobtype = 'milling'";
			    $resultpotmgq = $rundb->Query($sqlpotmgq);
			  	$numrowspotmgq = $rundb->NumRows($resultpotmgq);
				
				if($numrowspotmgq == 0){ //begin if new version of tracking dont have quantity, take old no quantity
				  echo "<tr>
				      <td>&nbsp;</td>
				    </tr>";
				}  //end if new version of tracking dont have quantity, take old no quantity
				else{	  
			      while($rowpotmgq = $rundb->FetchArray($resultpotmgq)){
  				    echo "<tr>
				      <td>{$rowpotmgq['quantity']}</td>
				    </tr>";	
				  }
			    }
				
			  echo "</table>
			  </td>";
			  //end milling quantity
			  
			  //begin milling width start date
			  echo "<td valign=\"top\">
			    <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
			  			  
			    $sqlpotmgs = "SELECT * FROM $pottab WHERE sid = {$rowpro['sid']} AND jobtype = 'millingwidth'";
			    $resultpotmgs = $rundb->Query($sqlpotmgs);
	  
			    while($rowpotmgs = $rundb->FetchArray($resultpotmgs)){
  				  if($rowpotmgs['date_start'] == "" || $rowpotmgs['date_start'] == NULL){
					echo "<tr>
					  <td>&nbsp;</td>
					</tr>";
				  }
				  else{
					echo "<tr>
					  <td>".date("d-m-y", strtotime($rowpotmgs['date_start']))."</td>
					</tr>";
				  }
				}	
				
			  echo "</table>
			  </td>";
			  //end milling width start date
			  
			  //begin milling width end date
			  echo "<td valign=\"top\">
			    <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
			  			  
			    $sqlpotmge = "SELECT * FROM $pottab WHERE sid = {$rowpro['sid']} AND jobtype = 'millingwidth'";
			    $resultpotmge = $rundb->Query($sqlpotmge);
  
			    while($rowpotmge = $rundb->FetchArray($resultpotmge)){
  				  if($rowpotmge['date_end'] == "" || $rowpotmge['date_end'] == NULL){
				    echo "<tr>
					  <td>&nbsp;</td>
					</tr>";
				  }
				  else{
					echo "<tr>
					  <td>".date("d-m-y", strtotime($rowpotmge['date_end']))."</td>
					</tr>";  
				  }	
			    }
				
			  echo "</table>
			  </td>";
			  //end milling width end date
			  
			  //begin milling width quantity
			  echo "<td valign=\"top\">
			    <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
			  			  
			    $sqlpotmgq = "SELECT * FROM $pottab WHERE sid = {$rowpro['sid']} AND jobtype = 'millingwidth'";
			    $resultpotmgq = $rundb->Query($sqlpotmgq);
  
			    while($rowpotmgq = $rundb->FetchArray($resultpotmgq)){
  				  echo "<tr>
				    <td>{$rowpotmgq['quantity']}</td>
				  </tr>";	
			    }
				
			  echo "</table>
			  </td>";
			  //end milling width quantity
			  
			  //begin milling length start date
			  echo "<td valign=\"top\">
			    <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
			  			  
			    $sqlpotmgs = "SELECT * FROM $pottab WHERE sid = {$rowpro['sid']} AND jobtype = 'millinglength'";
			    $resultpotmgs = $rundb->Query($sqlpotmgs);
	  
			    while($rowpotmgs = $rundb->FetchArray($resultpotmgs)){
  				  if($rowpotmgs['date_start'] == "" || $rowpotmgs['date_start'] == NULL){
					echo "<tr>
					  <td>&nbsp;</td>
					</tr>";
				  }
				  else{
					echo "<tr>
					  <td>".date("d-m-y", strtotime($rowpotmgs['date_start']))."</td>
					</tr>";
				  }	
			    }
				
			  echo "</table>
			  </td>";
			  //end milling length start date
			  
			  //begin milling length end date
			  echo "<td valign=\"top\">
			    <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
			  			  
			    $sqlpotmge = "SELECT * FROM $pottab WHERE sid = {$rowpro['sid']} AND jobtype = 'millinglength'";
			    $resultpotmge = $rundb->Query($sqlpotmge);
  
			    while($rowpotmge = $rundb->FetchArray($resultpotmge)){
  				  if($rowpotmge['date_end'] == "" || $rowpotmge['date_end'] == NULL){
					echo "<tr>
					  <td>&nbsp;</td>
					</tr>";
				  }
				  else{
					echo "<tr>
					  <td>".date("d-m-y", strtotime($rowpotmge['date_end']))."</td>
					</tr>";  
				  }	
			    }
				
			  echo "</table>
			  </td>";
			  //end milling length end date
			  
			  //begin milling length quantity
			  echo "<td valign=\"top\">
			    <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
			  			  
			    $sqlpotmgq = "SELECT * FROM $pottab WHERE sid = {$rowpro['sid']} AND jobtype = 'millinglength'";
			    $resultpotmgq = $rundb->Query($sqlpotmgq);
				  
			    while($rowpotmgq = $rundb->FetchArray($resultpotmgq)){
  				  echo "<tr>
				    <td>{$rowpotmgq['quantity']}</td>
				  </tr>";	
			    }
				
			  echo "</table>
			  </td>";
			  //end milling length quantity
			  
			  //begin rough grinding start date
			  echo "<td valign=\"top\">
			    <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
			  			  
			    $sqlpotrgs = "SELECT * FROM $pottab WHERE sid = {$rowpro['sid']} AND jobtype = 'roughgrinding'";
			    $resultpotrgs = $rundb->Query($sqlpotrgs);
			  	$numrowspotrgs = $rundb->NumRows($resultpotrgs);
				
				if($numrowspotrgs == 0){ //begin if new version of tracking date dont have, take old date
				  if($rowpro['roughgrinding_start'] == "" || $rowpro['roughgrinding_start'] == NULL){
					echo "<tr>
					  <td>&nbsp;</td>
					</tr>";
				  }
				  else{
					echo "<tr>
					  <td>".date("d-m-y", strtotime($rowpro['roughgrinding_start']))."</td>
					</tr>";  
				  }	  
				}  //end if new version of tracking date dont have, take old date
				else{	  
			      while($rowpotrgs = $rundb->FetchArray($resultpotrgs)){
  				    if($rowpotrgs['date_start'] == "" || $rowpotrgs['date_start'] == NULL){
					  echo "<tr>
					    <td>&nbsp;</td>
					  </tr>";
				    }
				    else{
				  	  echo "<tr>
					    <td>".date("d-m-y", strtotime($rowpotrgs['date_start']))."</td>
					  </tr>";  
					}
				  }	
			    }
				
			  echo "</table>
			  </td>";
			  //end rough grinding start date
			  
			  //begin rough grinding end date
			  echo "<td valign=\"top\">
			    <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
			  			  
			    $sqlpotrge = "SELECT * FROM $pottab WHERE sid = {$rowpro['sid']} AND jobtype = 'roughgrinding'";
			    $resultpotrge = $rundb->Query($sqlpotrge);
			  	$numrowspotrge = $rundb->NumRows($resultpotrge);
				
				if($numrowspotrge == 0){ //begin if new version of tracking date dont have, take old date
				  if($rowpro['roughgrinding_end'] == "" || $rowpro['roughgrinding_end'] == NULL){
					echo "<tr>
					  <td>&nbsp;</td>
					</tr>";
				  }
				  else{
					echo "<tr>
					  <td>".date("d-m-y", strtotime($rowpro['roughgrinding_end']))."</td>
					</tr>";  
				  }	  
				}  //end if new version of tracking date dont have, take old date
				else{		  
			      while($rowpotrge = $rundb->FetchArray($resultpotrge)){
  				    if($rowpotrge['date_end'] == "" || $rowpotrge['date_end'] == NULL){
					  echo "<tr>
					    <td>&nbsp;</td>
					  </tr>";
				    }
				    else{
					  echo "<tr>
					    <td>".date("d-m-y", strtotime($rowpotrge['date_end']))."</td>
					  </tr>"; 
					}
				  }	
			    }
				
			  echo "</table>
			  </td>";
			  //end rough grinding end date
			  
			  //begin rough grinding quantity
			  echo "<td valign=\"top\">
			    <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
			  			  
			    $sqlpotrgq = "SELECT * FROM $pottab WHERE sid = {$rowpro['sid']} AND jobtype = 'roughgrinding'";
			    $resultpotrgq = $rundb->Query($sqlpotrgq);
			  	$numrowspotrgq = $rundb->NumRows($resultpotrgq);
				
				if($numrowspotrgq == 0){ //begin if new version of tracking dont have quantity, take old no quantity
				  echo "<tr>
				      <td>&nbsp;</td>
				    </tr>";
				}  //end if new version of tracking dont have quantity, take old no quantity
				else{	  
			      while($rowpotrgq = $rundb->FetchArray($resultpotrgq)){
  				    echo "<tr>
				      <td>{$rowpotrgq['quantity']}</td>
				    </tr>";	
				  }
			    }
				
			  echo "</table>
			  </td>";
			  //end rough grinding quantity
			  
			  //begin precision grinding start date
			  echo "<td valign=\"top\">
			    <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
			  			  
			    $sqlpotpgs = "SELECT * FROM $pottab WHERE sid = {$rowpro['sid']} AND jobtype = 'precisiongrinding'";
			    $resultpotpgs = $rundb->Query($sqlpotpgs);
			  	$numrowspotpgs = $rundb->NumRows($resultpotpgs);
				
				if($numrowspotpgs == 0){ //begin if new version of tracking date dont have, take old date
				  if($rowpro['precisiongrinding_start'] == "" || $rowpro['precisiongrinding_start'] == NULL){
					echo "<tr>
					  <td>&nbsp;</td>
					</tr>";
				  }
				  else{
					echo "<tr>
					  <td>".date("d-m-y", strtotime($rowpro['precisiongrinding_start']))."</td>
					</tr>";  
				  }	  
				}  //end if new version of tracking date dont have, take old date
				else{	  
			      while($rowpotpgs = $rundb->FetchArray($resultpotpgs)){
  				    if($rowpotpgs['date_start'] == "" || $rowpotpgs['date_start'] == NULL){
					  echo "<tr>
					    <td>&nbsp;</td>
					  </tr>";
				    }
				    else{
					  echo "<tr>
					    <td>".date("d-m-y", strtotime($rowpotpgs['date_start']))."</td>
					  </tr>";  
					}
				  }	
			    }
				
			  echo "</table>
			  </td>";
			  //end precision grinding start date
			  
			  //begin precision grinding end date
			  echo "<td valign=\"top\">
			    <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
			  			  
			    $sqlpotpge = "SELECT * FROM $pottab WHERE sid = {$rowpro['sid']} AND jobtype = 'precisiongrinding'";
			    $resultpotpge = $rundb->Query($sqlpotpge);
			  	$numrowspotpge = $rundb->NumRows($resultpotpge);
				
				if($numrowspotpge == 0){ //begin if new version of tracking date dont have, take old date
				  if($rowpro['precisiongrinding_end'] == "" || $rowpro['precisiongrinding_end'] == NULL){
					echo "<tr>
					  <td>&nbsp;</td>
					</tr>";
				  }
				  else{
					echo "<tr>
					  <td>".date("d-m-y", strtotime($rowpro['precisiongrinding_end']))."</td>
					</tr>";  
				  }	  
				}  //end if new version of tracking date dont have, take old date
				else{	  
			      while($rowpotpge = $rundb->FetchArray($resultpotpge)){
  				    if($rowpotpge['date_end'] == "" || $rowpotpge['date_end'] == NULL){
					  echo "<tr>
					    <td>&nbsp;</td>
					  </tr>";
				    }
				    else{
					  echo "<tr>
					    <td>".date("d-m-y", strtotime($rowpotpge['date_end']))."</td>
					  </tr>"; 
					}
				  }	
			    }
				
			  echo "</table>
			  </td>";
			  //end precision grinding end date
			  
			  //begin precision grinding quantity
			  echo "<td valign=\"top\">
			    <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
			  			  
			    $sqlpotpgq = "SELECT * FROM $pottab WHERE sid = {$rowpro['sid']} AND jobtype = 'precisiongrinding'";
			    $resultpotpgq = $rundb->Query($sqlpotpgq);
			  	$numrowspotpgq = $rundb->NumRows($resultpotpgq);
				
				if($numrowspotpgq == 0){ //begin if new version of tracking dont have quantity, take old no quantity
				  echo "<tr>
				      <td>&nbsp;</td>
				    </tr>";
				}  //end if new version of tracking dont have quantity, take old no quantity
				else{		  
			      while($rowpotpgq = $rundb->FetchArray($resultpotpgq)){
  				    echo "<tr>
				      <td>{$rowpotpgq['quantity']}</td>
				    </tr>";	
				  }
			    }
				
			  echo "</table>
			  </td>";
			  //end precision grinding quantity
			  
			  //begin cncmachining start date
			  echo "<td valign=\"top\">
			    <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
			  			  
			    $sqlpotcms = "SELECT * FROM $pottab WHERE sid = {$rowpro['sid']} AND jobtype = 'cncmachining'";
			    $resultpotcms = $rundb->Query($sqlpotcms);
			  	$numrowspotcms = $rundb->NumRows($resultpotcms);
				
			  	if($numrowspotcms == 0){ //begin if new version of tracking date dont have, take old date
				  if($rowpro['cncmachining_start'] == "" || $rowpro['cncmachining_start'] == NULL){
					echo "<tr>
					  <td>&nbsp;</td>
					</tr>";
				  }
				  else{
					echo "<tr>
					  <td>".date("d-m-y", strtotime($rowpro['cncmachining_start']))."</td>
					</tr>";  
				  }	  
				}  //end if new version of tracking date dont have, take old date
				else{		  
			      while($rowpotcms = $rundb->FetchArray($resultpotcms)){
  				    if($rowpotcms['date_start'] == "" || $rowpotcms['date_start'] == NULL){
					  echo "<tr>
					    <td>&nbsp;</td>
					  </tr>";
				    }
				    else{
					  echo "<tr>
					    <td>".date("d-m-y", strtotime($rowpotcms['date_start']))."</td>
					  </tr>"; 
					}
				  }	
			    }
				
			  echo "</table>
			  </td>";
			  //end cncmachining start date
			  
			  //begin cncmachining end date
			  echo "<td valign=\"top\">
			    <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
			  			  
			    $sqlpotcme = "SELECT * FROM $pottab WHERE sid = {$rowpro['sid']} AND jobtype = 'cncmachining'";
			    $resultpotcme = $rundb->Query($sqlpotcme);
				$numrowspotcme = $rundb->NumRows($resultpotcme);
				
			  	if($numrowspotcme == 0){ //begin if new version of tracking date dont have, take old date
				  if($rowpro['cncmachining_end'] == "" || $rowpro['cncmachining_end'] == NULL){
					echo "<tr>
					  <td>&nbsp;</td>
					</tr>";
				  }
				  else{
					echo "<tr>
					  <td>".date("d-m-y", strtotime($rowpro['cncmachining_end']))."</td>
					</tr>";  
				  }	  
				}  //end if new version of tracking date dont have, take old date
				else{		  
			      while($rowpotcme = $rundb->FetchArray($resultpotcme)){
  				    if($rowpotcme['date_end'] == "" || $rowpotcme['date_end'] == NULL){
					  echo "<tr>
					    <td>&nbsp;</td>
					  </tr>";
				    }
				    else{
					  echo "<tr>
					    <td>".date("d-m-y", strtotime($rowpotcme['date_end']))."</td>
					  </tr>";  
					}
				  }	
			    }
				
			  echo "</table>
			  </td>";
			  //end cncmachining end date
			  
			  //begin cncmachining quantity
			  echo "<td valign=\"top\">
			    <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
			  			  
			    $sqlpotcmq = "SELECT * FROM $pottab WHERE sid = {$rowpro['sid']} AND jobtype = 'cncmachining'";
			    $resultpotcmq = $rundb->Query($sqlpotcmq);
			  	$numrowspotcmq = $rundb->NumRows($resultpotcmq);
				
				if($numrowspotcmq == 0){ //begin if new version of tracking dont have quantity, take old no quantity
				  echo "<tr>
				      <td>&nbsp;</td>
				    </tr>";
				}  //end if new version of tracking dont have quantity, take old no quantity
				else{	  
			      while($rowpotcmq = $rundb->FetchArray($resultpotcmq)){
  				    echo "<tr>
				      <td>{$rowpotcmq['quantity']}</td>
				    </tr>";
				  }
			    }
				
			  echo "</table>
			  </td>";
			  //end cncmachining quantity
			  
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
