<?php 
#include_once("../include/mysql_connect.php");
include_once("../includes/dbh.inc.php");
include_once("../includes/variables.inc.php");
//require_once("../include/session.php");
//include_once("../include/admin_check.php");

#session_start();
function debug_to_console( $data ) {

    if ( is_array( $data ) ){
        $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
    }else{
        $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";
 
    echo $output;
    }
}
//cProductionJoblist('printsticker');

if($_GET['ye'] && $_GET['mo'] && $_GET['da'] && $_GET['bid']) { 

  $year = $_GET['ye']; //year
  $month = $_GET['mo']; //month
  $day = $_GET['da']; //date
  $bid = $_GET['bid']; //branch id
  // echo "\$year =  $year <br>";
  // echo "\$month =  $month <br>";
  // echo "\$day =  $day <br>";
  // echo "\$bid =  $bid <br>";
  $dat = $year."-".sprintf("%02d", $month)."-".sprintf("%02d", $day);  
  $datdat = sprintf("%02d", substr($year, 2, 2)).sprintf("%02d", $month);
  if (!isset($com)){
      $com = '';
  }
  $protab = "production_scheduling".$com."_".$datdat; 
  
  if($month == 12){
	$yearnext = $year + 1;
	$monthnext = 1;  
  }
  else{
	$yearnext = $year;
	$monthnext = $month + 1;   
  }
  
  $datdatnext = sprintf("%02d", substr($yearnext, 2, 2)).sprintf("%02d", $monthnext);
  $protabnext = "production_scheduling".$com."_".$datdatnext;
  
  if($month == 1){
	$yearlast = $year - 1;
	$monthlast = 12;  
  }
  else{
	$yearlast = $year;
	$monthlast = $month - 1;   
  }
  
  $datdatlast = sprintf("%02d", substr($yearlast, 2, 2)).sprintf("%02d", $monthlast);
  $protablast = "production_scheduling".$com."_".$datdatlast;
  
  $sqlbra = "SELECT * FROM branch_location WHERE bid = $bid";
  $objSqlbra = new SQL($sqlbra);
  $rowbra = $objSqlbra->getResultOneRowArray();
#  $resultbra = $rundb->Query($sqlbra);
#  $rowbra = $rundb->FetchArray($resultbra);
  //$branchjoblist = $rowbra['bjlindicator'];
?>

<input type="hidden" name="datdat" value="<?php echo $datdat; ?>" />

<table width="100%" cellspacing="0" cellpadding="2" border="0">
  <tr>
    <td>
      <select name="sid[]" id="sid[]" multiple="multiple" style="width:200px; height:200px;">
        <option value="all">All</option>
        <?php
        $sqlpro = "SELECT * FROM $protab WHERE date_issue = '$dat' AND (bid = $bid OR (operation = 1 OR operation = 3)) AND status = 'active'
				   UNION ALL
				   SELECT * FROM $protablast WHERE date_issue = '$dat' AND (bid = $bid OR (operation = 1 OR operation = 3)) AND status = 'active'
				   UNION ALL
				   SELECT * FROM $protabnext WHERE date_issue = '$dat' AND (bid = $bid OR (operation = 1 OR operation = 3)) AND status = 'active'";
		$sqlpro .= " ORDER BY ABS(runningno), ABS(noposition)";
		echo "\$sqlpro = $sqlpro <br>";
		debug_to_console("\$sqlpro = $sqlpro");
  		$resultpro = $rundb->Query($sqlpro);
            
        if($resultpro){
		  while($rowpro = $rundb->FetchArray($resultpro)){
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
			  //$dateissue = substr($rowpro['quono'], 4, 4);
		    }
		    else if($rowpro['additional'] == "Amendment"){
			  $additional = "(A)"; 
			  //$dateissue = substr($rowpro['quono'], 4, 4);
		    }
		    else{
			  $additional = "";  
		    }
			
			echo "<option value=\"{$rowpro['sid']}\">$branchjoblist $quono $dateissue $runningno $jobno $additional</option>";		
		  }
		}
		else{
		  $sqlpro = "SELECT * FROM $protab WHERE date_issue = '$dat' AND (bid = $bid OR (operation = 1 OR operation = 3)) AND status = 'active'
				     UNION ALL
				     SELECT * FROM $protablast WHERE date_issue = '$dat' AND (bid = $bid OR (operation = 1 OR operation = 3)) AND status = 'active'";
		  $sqlpro .= " ORDER BY ABS(runningno), ABS(noposition)";
		  echo "\$sqlpro = $sqlpro <br>";
		  debug_to_console("\$sqlpro = $sqlpro");
  		  $resultpro = $rundb->Query($sqlpro);
		  
		  while($rowpro = $rundb->FetchArray($resultpro)){
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
			  //$dateissue = substr($rowpro['quono'], 4, 4);
		    }
		    else if($rowpro['additional'] == "Amendment"){
			  $additional = "(A)"; 
			  //$dateissue = substr($rowpro['quono'], 4, 4);
		    }
		    else{
			  $additional = "";  
		    }
			
			echo "<option value=\"{$rowpro['sid']}\">$branchjoblist $quono $dateissue $runningno $jobno $additional</option>";		
		  }
		}
        ?>
      </select>
    </td>
  </tr>
</table>

<?php
}
?>
