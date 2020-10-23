<?php 
include_once("../include/mysql_connect.php");
//require_once("../include/session.php");
//include_once("../include/admin_check.php");

session_start();

//cProductionJoblist('viewdailyproductiontarget');

if($_GET['ye'] && $_GET['mo'] && $_GET['da'] && $_GET['jt'] && $_GET['bid']){ 

  $year = $_GET['ye']; //year
  $month = $_GET['mo']; //month
  $day = $_GET['da']; //day
  $jtype = $_GET['jt']; //job type
  $bid = $_GET['bid']; //branch id
  
  $yearyear = $year;
  $dat = sprintf("%02d", substr($year, 2,2)).sprintf("%02d", $month);

  $protartab = "production_target_".$dat;

  $sqlptt = "SELECT * FROM $protartab";
  $resultptt = $rundb->Query($sqlptt);
	  
  if(!$resultptt){
	$sqlprotardef = "SELECT * FROM production_target_default";
    $resultprotardef = $rundb->Query($sqlprotardef);
 
    while($rowprotardef = $rundb->FetchArray($resultprotardef)){
	  $protarinfo .= "`{$rowprotardef['ptid']}` int(10) unsigned NOT NULL,";
	  $protarheader .= "`{$rowprotardef['ptid']}`,";
	  $protardata .= "\"{$rowprotardef['quantity']}\",";
    }
  
    $protarheader = substr($protarheader, 0, -1); //remove last comma so that can use Insert in mysql later
    $protardata = substr($protardata, 0, -1); //remove last comma so that can use Insert in mysql later
	  
    //create table production target
	$sqlctbptt = "CREATE TABLE IF NOT EXISTS `$protartab` (
				 `ptdid` int(10) unsigned NOT NULL AUTO_INCREMENT,
				 `days` int(10) unsigned NOT NULL,
				 $protarinfo
				 PRIMARY KEY (`ptdid`)
				 ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

    if($rundb->Query($sqlctbptt)){
	  $numdays = cal_days_in_month(CAL_GREGORIAN, $month, $yearyear);
	  
	  for($x = 1; $x <= $numdays; $x++){
		$sqlpttin = "INSERT INTO $protartab (ptdid, days, $protarheader) VALUES (NULL, $x, $protardata);"; 
		
		if($rundb->Query($sqlpttin)){
		  $pass = 1;
	    }
		else{
		  $pass = 0;	
		}
	  }

	  if($pass == 1){
	  }
	  else{
		$sqlpttdrop = "DROP TABLE $protartab";
	 	$rundb->Query($sqlpttdrop);
		  
	    echo "<font color=\"#FF0000\">Production Target data cannot be insert. Please contact administrator regarding this thing.</font>";
	    exit();
	  }
    }
    else{			
	  echo "<font color=\"#FF0000\">Production Target table cannot be created. Please contact administrator regarding this thing.</font>";
	  exit();
	}
  }
  ?>

<table width="60%" cellspacing="0" cellpadding="2" border="0">
  <?php
  $yesterdaytarget = 0;
  $todaytarget = 0;
  $yesterdaybacklog = 0;
  $todaybacklog = 0;
  $yesterdaymorningoutput = 0;
  $yesterdaynightoutput = 0;
  $todayinput = 0;
  $yesterdayoutput = 0;
  $todaymorningoutput = 0;
  $todaynightoutput = 0;
  $yesterdaybalance = 0;
  $todaybalance = 0;
  $yesterdaybalancetarget = 0;
  $todaybalancetarget = 0;
  
  $sqlprotardef = "SELECT * FROM production_target_default WHERE ptid = $jtype";
  $resultprotardef = $rundb->Query($sqlprotardef);
  $rowprotardef = $rundb->FetchArray($resultprotardef);
  
  if($jtype == 1){ //MANUAL CUT <= 1000
    $prodtype = "cuttingtype = 'MANUAL CUT'";
	$prodouttype = "jobtype = 'bandsaw'";
	
	$prodtype2 = "PS.cuttingtype = 'MANUAL CUT'";
	$prodouttype2 = "PO.jobtype = 'bandsaw'"; 
  }
  else if($jtype == 2){ //CNC CUT <= 1500
	$prodtype = "(cuttingtype = 'CNC FLAME CUT' OR cuttingtype = 'CNC PLASMA CUT')";
	$prodouttype = "jobtype = 'bandsaw'";  
	
	$prodtype2 = "(PS.cuttingtype = 'CNC FLAME CUT' OR PS.cuttingtype = 'CNC PLASMA CUT')";
	$prodouttype2 = "PO.jobtype = 'bandsaw'"; 
  }
  else if($jtype == 3){ //BANDSAW CUT <= 1000
	$prodtype = "cuttingtype = 'BANDSAW CUT'";
	$prodouttype = "jobtype = 'bandsaw'"; 
	
	$prodtype2 = "PS.cuttingtype = 'BANDSAW CUT'";
	$prodouttype2 = "PO.jobtype = 'bandsaw'"; 
  }
  else if($jtype == 4){ //MILLING <= 600
    $processtype = "process LIKE '%W%'";
	$prodtype = "(process NOT LIKE '' AND process IS NOT NULL) AND mdl <= 600";
	$prodouttype = "jobtype = 'milling'"; 
	
	$processtype2 = "PM.process LIKE '%W%'";
	$prodtype2 = "(PS.process NOT LIKE '' AND PS.process IS NOT NULL) AND PS.mdl <= 600";
	$prodouttype2 = "PO.jobtype = 'milling'"; 
  }
  else if($jtype == 5){ //MILLING > 600
    $processtype = "process LIKE '%W%'";
	$prodtype = "(process NOT LIKE '' AND process IS NOT NULL) AND mdl > 600";
	$prodouttype = "jobtype = 'milling'"; 
	
	$processtype2 = "PM.process LIKE '%W%'";
	$prodtype2 = "(PS.process NOT LIKE '' AND PS.process IS NOT NULL) AND PS.mdl > 600";
	$prodouttype2 = "PO.jobtype = 'milling'"; 
  }
  else if($jtype == 6){ //ROUGH GRIND <= 800
    $processtype = "process LIKE '%RG%'";
	$prodtype = "(process NOT LIKE '' AND process IS NOT NULL)";
	$prodouttype = "jobtype = 'roughgrinding'"; 
	
	$processtype2 = "PM.process LIKE '%RG%'";
	$prodtype2 = "(PS.process NOT LIKE '' AND PS.process IS NOT NULL)";
	$prodouttype2 = "PO.jobtype = 'roughgrinding'"; 
  }
  else if($jtype == 7){ //SURFACE GRIND <= 500
    $processtype = "process LIKE '%SG%'";
	$prodtype = "(process NOT LIKE '' AND process IS NOT NULL) AND mdl <= 500";
	$prodouttype = "jobtype = 'precisiongrinding'"; 
	
	$processtype2 = "PM.process LIKE '%SG%'";
	$prodtype2 = "(PS.process NOT LIKE '' AND PS.process IS NOT NULL) AND PS.mdl <= 500";
	$prodouttype2 = "PO.jobtype = 'precisiongrinding'"; 
  }
  else if($jtype == 8){ //SURFACE GRIND > 500
    $processtype = "process LIKE '%SG%'";
	$prodtype = "(process NOT LIKE '' AND process IS NOT NULL) AND mdl > 500";
	$prodouttype = "jobtype = 'precisiongrinding'"; 
	
	$processtype2 = "PM.process LIKE '%SG%'";
	$prodtype2 = "(PS.process NOT LIKE '' AND PS.process IS NOT NULL) AND PS.mdl > 500";
	$prodouttype2 = "PO.jobtype = 'precisiongrinding'";  
  }
  else if($jtype == 9){ //CNC MACHINING <= 1000
	$prodtype = "(cncmach NOT LIKE '0.00' AND cncmach IS NOT NULL)";
	$prodouttype = "jobtype = 'cncmachining'"; 
	
	$prodtype2 = "(PS.cncmach NOT LIKE '0.00' AND PS.cncmach IS NOT NULL)";
	$prodouttype2 = "PO.jobtype = 'bandsaw'"; 
  }

  
  //get yesterday and today tab due to possible of different month
  $yesterday = date('Y-m-d', mktime(0, 0, 0, $month, $day - 1, $year));
  $today = date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));
  $tomorrow = date('Y-m-d', mktime(0, 0, 0, $month, $day + 1, $year));
  
  $protaryesdat = sprintf("%02d", substr($yesterday, 2,2)).sprintf("%02d", substr($yesterday, 5, 2));
  $yesdat = date('d', strtotime($yesterday));
  $protartoddat = sprintf("%02d", substr($today, 2,2)).sprintf("%02d", substr($today, 5, 2));
  $toddat = date('d', strtotime($today));
  $protartomdat = sprintf("%02d", substr($today, 2,2)).sprintf("%02d", substr($today, 5, 2));
  $tomdat = date('d', strtotime($tomorrow));
  
  $protaryestab = "production_target_".$protaryesdat; 
  $protartodtab = "production_target_".$protartoddat;
  $protartomtab = "production_target_".$protartomdat;
  
  $sqlprotaryes = "SELECT * FROM $protaryestab WHERE days = '$yesdat'";
  $resultprotaryes = $rundb->Query($sqlprotaryes);
  $rowprotaryes = $rundb->FetchArray($resultprotaryes);
  
  $yesterdaytarget = $rowprotaryes[$jtype];
  
  $sqlprotartod = "SELECT * FROM $protartodtab WHERE days = '$toddat'";
  $resultprotartod = $rundb->Query($sqlprotartod);
  $rowprotartod = $rundb->FetchArray($resultprotartod);
  
  $todaytarget = $rowprotartod[$jtype];
 
  
  //get yesterday and today tab due to possible of different month
  $proyestab = "production_scheduling_".$protaryesdat; 
  $protodtab = "production_scheduling_".$protartoddat;
  $protomtab = "production_scheduling_".$protartomdat;
  $prooutyestab = "production_output_".$protaryesdat; 
  $proouttodtab = "production_output_".$protartoddat;
  $proouttomtab = "production_output_".$protartomdat;


  //get last month and this month tab for calculating all the backlog
  $lastmonth = date('Y-m-d', mktime(0, 0, 0, $month - 1, $day, $year));
  $thismonth = date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));
  
  $prolastmonthdat = sprintf("%02d", substr($lastmonth, 2,2)).sprintf("%02d", substr($lastmonth, 5, 2));
  $prothismonthdat = sprintf("%02d", substr($thismonth, 2,2)).sprintf("%02d", substr($thismonth, 5, 2));
  
  $prolastmonthtab = "production_scheduling_".$prolastmonthdat; 
  $prothismonthtab = "production_scheduling_".$prothismonthdat;
  $prooutlastmonthtab = "production_output_".$prolastmonthdat; 
  $prooutthismonthtab = "production_output_".$prothismonthdat;
  
  
  //calculating yesterday backlog
  /*
  $sqlproyesbl = "SELECT * FROM (
  				      SELECT * FROM $prolastmonthtab WHERE $prodtype AND DATE_FORMAT(date_issue, '%Y-%m-%d') < '$yesterday' AND status = 'active' AND bid = $bid
  				  	  UNION ALL
				      SELECT * FROM $prothismonthtab WHERE $prodtype AND DATE_FORMAT(date_issue, '%Y-%m-%d') < '$yesterday' AND status = 'active' AND bid = $bid
				  ) AS tab";
  $resultproyesbl = $rundb->Query($sqlproyesbl);
  
  while($rowproyesbl = $rundb->FetchArray($resultproyesbl)){
	if($jtype == 1 || $jtype == 2 || $jtype == 3 || $jtype == 9){  
	  $sqlprotaryesbl = "SELECT SUM(quantity) AS quantity FROM (
  					       SELECT quantity FROM $prooutlastmonthtab WHERE $prodouttype AND DATE_FORMAT(date_end, '%Y-%m-%d') < '$yesterday' AND sid = {$rowproyesbl['sid']}
  					 	   UNION ALL
					 	   SELECT quantity FROM $prooutthismonthtab WHERE $prodouttype AND DATE_FORMAT(date_end, '%Y-%m-%d') < '$yesterday' AND sid = {$rowproyesbl['sid']}
					   ) AS tab";
      $resultprotaryesbl = $rundb->Query($sqlprotaryesbl);
      $rowprotaryesbl = $rundb->FetchArray($resultprotaryesbl);
	
	  $proyesbl += $rowproyesbl['quantity'];
	  $protaryesbl += $rowprotaryesbl['quantity'];	
	}
	else if($jtype == 4 || $jtype == 5 || $jtype == 6 || $jtype == 7 || $jtype == 8){
      $sqlpre = "SELECT * FROM premachining WHERE pmid = {$rowproyesbl['process']} AND $processtype";	
	  $resultpre = $rundb->Query($sqlpre);
	  $numrowspre = $rundb->NumRows($resultpre);
	  
	  if($numrowspre == 1){	
	    $sqlprotaryesbl = "SELECT SUM(quantity) AS quantity FROM (
  					       SELECT quantity FROM $prooutlastmonthtab WHERE $prodouttype AND DATE_FORMAT(date_end, '%Y-%m-%d') < '$yesterday' AND sid = {$rowproyesbl['sid']}
  					 	   UNION ALL
					 	   SELECT quantity FROM $prooutthismonthtab WHERE $prodouttype AND DATE_FORMAT(date_end, '%Y-%m-%d') < '$yesterday' AND sid = {$rowproyesbl['sid']}
					   ) AS tab";
        $resultprotaryesbl = $rundb->Query($sqlprotaryesbl);
        $rowprotaryesbl = $rundb->FetchArray($resultprotaryesbl);
		
		$proyesbl += $rowproyesbl['quantity'];
	    $protaryesbl += $rowprotaryesbl['quantity'];	
	  }
	}  
  }
  */
  if($jtype == 1 || $jtype == 2 || $jtype == 3 || $jtype == 9){ 
    //production yesterday LAST month balance (proyeslmbl), getting all YESTERDAY INPUT quantity
	$sqlproyeslmblqty = "SELECT SUM(quantity) AS proyesblqty
						 FROM $prolastmonthtab
						 WHERE $prodtype AND DATE_FORMAT(date_issue, '%Y-%m-%d') < '$yesterday' AND status = 'active' AND(( bid = 1 )OR (operation = 1 OR operation = 3))";
    $resultproyeslmblqty = $rundb->Query($sqlproyeslmblqty);
    $rowproyeslmblqty = $rundb->FetchArray($resultproyeslmblqty);
	
	//production yesterday LAST month balance (proyeslmbl), getting all YESTERDAY COMPLETED quantity
	//SELECT PS.sid, SUM(PS.quantity) AS proyesbl, PS.mdl, PS.cuttingtype, SUM(PO.quantity) AS protaryesbl
    $sqlproyeslmbl = "SELECT SUM(PO.quantity) AS protaryesbl
				        FROM $prolastmonthtab PS
				        INNER JOIN $prooutlastmonthtab PO ON PS.sid = PO.sid
				    WHERE $prodtype2 AND $prodouttype2 AND DATE_FORMAT(PS.date_issue, '%Y-%m-%d') < '$yesterday' AND DATE_FORMAT(PO.date_end, '%Y-%m-%d') < '$yesterday' AND PS.status = 'active' AND (( bid = 1 )OR (operation = 1 OR operation = 3))";
    $resultproyeslmbl = $rundb->Query($sqlproyeslmbl);
    $rowproyeslmbl = $rundb->FetchArray($resultproyeslmbl);


    //production yesterday THIS month balance (proyestmbl), getting all YESTERDAY INPUT quantity
	$sqlproyestmblqty = "SELECT SUM(quantity) AS proyesblqty
						 FROM $prothismonthtab
						 WHERE $prodtype AND DATE_FORMAT(date_issue, '%Y-%m-%d') < '$yesterday' AND status = 'active' AND (( bid = 1 )OR (operation = 1 OR operation = 3))";
    $resultproyestmblqty = $rundb->Query($sqlproyestmblqty);
    $rowproyestmblqty = $rundb->FetchArray($resultproyestmblqty);
	
	//production yesterday THIS month balance (proyestmbl), getting all YESTERDAY COMPLETED quantity
    $sqlproyestmbl = "SELECT SUM(PO.quantity) AS protaryesbl
				        FROM $prothismonthtab PS
				        INNER JOIN $prooutthismonthtab PO ON PS.sid = PO.sid
				    WHERE $prodtype2 AND $prodouttype2 AND DATE_FORMAT(PS.date_issue, '%Y-%m-%d') < '$yesterday' AND DATE_FORMAT(PO.date_end, '%Y-%m-%d') < '$yesterday' AND PS.status = 'active' AND bid = 1";
    $resultproyestmbl = $rundb->Query($sqlproyestmbl);
    $rowproyestmbl = $rundb->FetchArray($resultproyestmbl);	
  }
  else if($jtype == 4 || $jtype == 5 || $jtype == 6 || $jtype == 7 || $jtype == 8){
	//production yesterday LAST month balance (proyeslmbl), getting all YESTERDAY INPUT quantity
	$sqlproyeslmblqty = "SELECT SUM(PS.quantity) AS proyesblqty
				        FROM $prolastmonthtab PS
				        INNER JOIN premachining PM ON PS.process = PM.pmid
				    WHERE $prodtype2 AND $processtype2 AND DATE_FORMAT(PS.date_issue, '%Y-%m-%d') < '$yesterday' AND PS.status = 'active' AND bid = 1";
    $resultproyeslmblqty = $rundb->Query($sqlproyeslmblqty);
    $rowproyeslmblqty = $rundb->FetchArray($resultproyeslmblqty);
	
	//production yesterday LAST month balance (proyeslmbl), getting all YESTERDAY COMPLETED quantity  
    //SELECT PS.sid, SUM(PS.quantity) AS proyesbl, PS.mdl, PS.cuttingtype, PS.process, PM.process, SUM(PO.quantity) AS protaryesbl    
    $sqlproyeslmbl = "SELECT SUM(PO.quantity) AS protaryesbl
				        FROM $prolastmonthtab PS
				        INNER JOIN premachining PM ON PS.process = PM.pmid
				        INNER JOIN $prooutlastmonthtab PO ON PS.sid = PO.sid
				    WHERE $prodtype2 AND $processtype2 AND $prodouttype2 AND DATE_FORMAT(PS.date_issue, '%Y-%m-%d') < '$yesterday' AND DATE_FORMAT(PO.date_end, '%Y-%m-%d') < '$yesterday' AND PS.status = 'active' AND bid = 1";
    $resultproyeslmbl = $rundb->Query($sqlproyeslmbl);
    $rowproyeslmbl = $rundb->FetchArray($resultproyeslmbl);


	//production yesterday THIS month balance (proyestmbl), getting all YESTERDAY INPUT quantity
	$sqlproyestmblqty = "SELECT SUM(PS.quantity) AS proyesblqty
				        FROM $prothismonthtab PS
				        INNER JOIN premachining PM ON PS.process = PM.pmid
				    WHERE $prodtype2 AND $processtype2 AND DATE_FORMAT(PS.date_issue, '%Y-%m-%d') < '$yesterday' AND PS.status = 'active' AND bid = 1";
    $resultproyestmblqty = $rundb->Query($sqlproyestmblqty);
    $rowproyestmblqty = $rundb->FetchArray($resultproyestmblqty);

    //production yesterday THIS month balance (proyestmbl), getting all YESTERDAY COMPLETED quantity
    $sqlproyestmbl = "SELECT SUM(PO.quantity) AS protaryesbl
				        FROM $prothismonthtab PS
				        INNER JOIN premachining PM ON PS.process = PM.pmid
				        INNER JOIN $prooutthismonthtab PO ON PS.sid = PO.sid
				    WHERE $prodtype2 AND $processtype2 AND $prodouttype2 AND DATE_FORMAT(PS.date_issue, '%Y-%m-%d') < '$yesterday' AND DATE_FORMAT(PO.date_end, '%Y-%m-%d') < '$yesterday' AND PS.status = 'active' AND bid = 1";
    $resultproyestmbl = $rundb->Query($sqlproyestmbl);
    $rowproyestmbl = $rundb->FetchArray($resultproyestmbl);
  }

  $proyesblqty = $rowproyeslmblqty['proyesblqty'] + $rowproyestmblqty['proyesblqty'];
  $protaryesbl = $rowproyeslmbl['protaryesbl'] + $rowproyestmbl['protaryesbl'];
				  
  $yesterdaybacklog = $proyesblqty - $protaryesbl;
  
  
  //calculating today backlog
  /*    
  $sqlprotodbl = "SELECT * FROM (
  				      SELECT * FROM $prolastmonthtab WHERE $prodtype AND DATE_FORMAT(date_issue, '%Y-%m-%d') < '$today' AND status = 'active' AND bid = $bid
  				  	  UNION ALL
				      SELECT * FROM $prothismonthtab WHERE $prodtype AND DATE_FORMAT(date_issue, '%Y-%m-%d') < '$today' AND status = 'active' AND bid = $bid
				  ) AS tab";
  
  $resultprotodbl = $rundb->Query($sqlprotodbl);
  
  while($rowprotodbl = $rundb->FetchArray($resultprotodbl)){
	if($jtype == 1 || $jtype == 2 || $jtype == 3 || $jtype == 9){  
	  $sqlprotartodbl = "SELECT * FROM (
							 SELECT quantity FROM $prooutlastmonthtab WHERE $prodouttype AND DATE_FORMAT(date_end, '%Y-%m-%d') < '$today' AND sid = {$rowprotodbl['sid']}
							 UNION ALL
							 SELECT quantity FROM $prooutthismonthtab WHERE $prodouttype AND DATE_FORMAT(date_end, '%Y-%m-%d') < '$today' AND sid = {$rowprotodbl['sid']}
						 ) AS tab";
	  $resultprotartodbl = $rundb->Query($sqlprotartodbl);
	  
	  while($rowprotartodbl = $rundb->FetchArray($resultprotartodbl)){	
	    $protodbl += $rowprotodbl['quantity'];
	    $protartodbl += $rowprotartodbl['quantity'];
	  }
	}
	else if($jtype == 4 || $jtype == 5 || $jtype == 6 || $jtype == 7 || $jtype == 8){
	  $sqlprotartodbl = "SELECT SUM(quantity) AS quantity FROM (
  				             SELECT quantity FROM $prooutlastmonthtab WHERE $prodouttype AND DATE_FORMAT(date_end, '%Y-%m-%d') < '$today' AND sid = {$rowprotodbl['sid']}
  					 	     UNION ALL
					 	     SELECT quantity FROM $prooutthismonthtab WHERE $prodouttype AND DATE_FORMAT(date_end, '%Y-%m-%d') < '$today' AND sid = {$rowprotodbl['sid']}
					     ) AS tab";
      $resultprotartodbl = $rundb->Query($sqlprotartodbl);
      $rowprotartodbl = $rundb->FetchArray($resultprotartodbl);
	
	  $protodbl += $rowprotodbl['quantity'];
	  $protartodbl += $rowprotartodbl['quantity'];	  
	}
  }
  */
  if($jtype == 1 || $jtype == 2 || $jtype == 3 || $jtype == 9){ 
    //production today LAST month balance (protodlmbl), getting all TODAY INPUT quantity
	$sqlprotodlmblqty = "SELECT SUM(quantity) AS protodblqty
						 FROM $prolastmonthtab
						 WHERE $prodtype AND DATE_FORMAT(date_issue, '%Y-%m-%d') < '$today' AND status = 'active' AND (( bid = 1 )OR (operation = 1 OR operation = 3))";
    $resultprotodlmblqty = $rundb->Query($sqlprotodlmblqty);
    $rowprotodlmblqty = $rundb->FetchArray($resultprotodlmblqty);
	
	//production today LAST month balance (protodlmbl), getting all TODAY COMPLETED quantity
	//SELECT PS.sid, SUM(PS.quantity) AS protodbl, PS.mdl, PS.cuttingtype, SUM(PO.quantity) AS protartodbl
    $sqlprotodlmbl = "SELECT SUM(PO.quantity) AS protartodbl
				        FROM $prolastmonthtab PS
				        INNER JOIN $prooutlastmonthtab PO ON PS.sid = PO.sid
				    WHERE $prodtype2 AND $prodouttype2 AND DATE_FORMAT(PS.date_issue, '%Y-%m-%d') < '$today' AND DATE_FORMAT(PO.date_end, '%Y-%m-%d') < '$today' AND PS.status = 'active' AND bid = 1";
    $resultprotodlmbl = $rundb->Query($sqlprotodlmbl);
    $rowprotodlmbl = $rundb->FetchArray($resultprotodlmbl);


    //production today THIS month balance (protodtmbl), getting all TODAY INPUT quantity
	$sqlprotodtmblqty = "SELECT SUM(quantity) AS protodblqty
						 FROM $prothismonthtab
						 WHERE $prodtype AND DATE_FORMAT(date_issue, '%Y-%m-%d') < '$today' AND status = 'active' AND (( bid = 1)OR (operation = 1 OR operation = 3))";
    $resultprotodtmblqty = $rundb->Query($sqlprotodtmblqty);
    $rowprotodtmblqty = $rundb->FetchArray($resultprotodtmblqty);
	
	//production today THIS month balance (protodtmbl), getting all TODAY COMPLETED quantity
    $sqlprotodtmbl = "SELECT SUM(PO.quantity) AS protartodbl
				        FROM $prothismonthtab PS
				        INNER JOIN $prooutthismonthtab PO ON PS.sid = PO.sid
				    WHERE $prodtype2 AND $prodouttype2 AND DATE_FORMAT(PS.date_issue, '%Y-%m-%d') < '$today' AND DATE_FORMAT(PO.date_end, '%Y-%m-%d') < '$today' AND PS.status = 'active' AND bid = 1";
    $resultprotodtmbl = $rundb->Query($sqlprotodtmbl);
    $rowprotodtmbl = $rundb->FetchArray($resultprotodtmbl);	
  }
  else if($jtype == 4 || $jtype == 5 || $jtype == 6 || $jtype == 7 || $jtype == 8){
	//production today LAST month balance (protodlmbl), getting all TODAY INPUT quantity
	$sqlprotodlmblqty = "SELECT SUM(PS.quantity) AS protodblqty
				        FROM $prolastmonthtab PS
				        INNER JOIN premachining PM ON PS.process = PM.pmid
				    WHERE $prodtype2 AND $processtype2 AND DATE_FORMAT(PS.date_issue, '%Y-%m-%d') < '$today' AND PS.status = 'active' AND bid = 1";
    $resultprotodlmblqty = $rundb->Query($sqlprotodlmblqty);
    $rowprotodlmblqty = $rundb->FetchArray($resultprotodlmblqty);
	
	//production today LAST month balance (protodlmbl), getting all TODAY COMPLETED quantity  
    //SELECT PS.sid, SUM(PS.quantity) AS protodbl, PS.mdl, PS.cuttingtype, PS.process, PM.process, SUM(PO.quantity) AS protartodbl    
    $sqlprotodlmbl = "SELECT SUM(PO.quantity) AS protartodbl
				        FROM $prolastmonthtab PS
				        INNER JOIN premachining PM ON PS.process = PM.pmid
				        INNER JOIN $prooutlastmonthtab PO ON PS.sid = PO.sid
				    WHERE $prodtype2 AND $processtype2 AND $prodouttype2 AND DATE_FORMAT(PS.date_issue, '%Y-%m-%d') < '$today' AND DATE_FORMAT(PO.date_end, '%Y-%m-%d') < '$today' AND PS.status = 'active' AND bid = 1";
    $resultprotodlmbl = $rundb->Query($sqlprotodlmbl);
    $rowprotodlmbl = $rundb->FetchArray($resultprotodlmbl);


	//production today THIS month balance (protodtmbl), getting all TODAY INPUT quantity
	$sqlprotodtmblqty = "SELECT SUM(PS.quantity) AS protodblqty
				        FROM $prothismonthtab PS
				        INNER JOIN premachining PM ON PS.process = PM.pmid
				    WHERE $prodtype2 AND $processtype2 AND DATE_FORMAT(PS.date_issue, '%Y-%m-%d') < '$today' AND PS.status = 'active' AND bid = 1";
    $resultprotodtmblqty = $rundb->Query($sqlprotodtmblqty);
    $rowprotodtmblqty = $rundb->FetchArray($resultprotodtmblqty);

    //production today THIS month balance (protodtmbl), getting all TODAY COMPLETED quantity
    $sqlprotodtmbl = "SELECT SUM(PO.quantity) AS protartodbl
				        FROM $prothismonthtab PS
				        INNER JOIN premachining PM ON PS.process = PM.pmid
				        INNER JOIN $prooutthismonthtab PO ON PS.sid = PO.sid
				    WHERE $prodtype2 AND $processtype2 AND $prodouttype2 AND DATE_FORMAT(PS.date_issue, '%Y-%m-%d') < '$today' AND DATE_FORMAT(PO.date_end, '%Y-%m-%d') < '$today' AND PS.status = 'active' AND bid = 1";
    $resultprotodtmbl = $rundb->Query($sqlprotodtmbl);
    $rowprotodtmbl = $rundb->FetchArray($resultprotodtmbl);
  }

  $protodblqty = $rowprotodlmblqty['protodblqty'] + $rowprotodtmblqty['protodblqty'];
  $protartodbl = $rowprotodlmbl['protartodbl'] + $rowprotodtmbl['protartodbl'];
				  
  $todaybacklog = $protodblqty - $protartodbl;
  
  
  //get the rest of the yesterday information
  if($jtype == 1 || $jtype == 2 || $jtype == 3 || $jtype == 9){  
    $sqlproyesinfo = "SELECT SUM(quantity) AS quantity FROM $protodtab WHERE $prodtype AND date_issue = '$yesterday' AND status = 'active' AND (( bid = $bid )OR (operation = 1 OR operation = 3))";
    $resultproyesinfo = $rundb->Query($sqlproyesinfo);
    $rowproyesinfo = $rundb->FetchArray($resultproyesinfo);
  
    $yesterdayinput = $rowproyesinfo['quantity'];
  }
  else if($jtype == 4 || $jtype == 5 || $jtype == 6 || $jtype == 7 || $jtype == 8){
	$sqlproyesinfo = "SELECT * FROM $proyestab WHERE $prodtype AND date_issue = '$yesterday' AND status = 'active' AND (( bid = $bid )OR (operation = 1 OR operation = 3))";
    $resultproyesinfo = $rundb->Query($sqlproyesinfo);
    
	while($rowproyesinfo = $rundb->FetchArray($resultproyesinfo)){
	  $sqlpre = "SELECT * FROM premachining WHERE pmid = {$rowproyesinfo['process']} AND $processtype";	
	  $resultpre = $rundb->Query($sqlpre);
	  $numrowspre = $rundb->NumRows($resultpre);
	  
	  if($numrowspre == 1){
	    $yesterdayinput += $rowproyesinfo['quantity']; 
	  }
	}
  }

  //do checking on production output, then dsearch all from production scheduling, do matching manual cut = manual cut, if match then take the quantity, else dont take... if no will get all lump sump of data since manual cut, bandsaw, cnc all share same pc
  $sqlprotaryesmorinfo = "SELECT * FROM $proouttodtab WHERE $prodouttype AND (DATE_FORMAT(date_end, '%Y-%m-%d %H:%i:%s') >= '$yesterday 08:00:00' AND DATE_FORMAT(date_end, '%Y-%m-%d %H:%i:%s') < '$yesterday 20:00:00')";
  $resultprotaryesmorinfo = $rundb->Query($sqlprotaryesmorinfo);
  
  while($rowprotaryesmorinfo = $rundb->FetchArray($resultprotaryesmorinfo)){
	$sqlprotabyesmorinfo = "SELECT * FROM $protodtab WHERE $prodtype AND sid = {$rowprotaryesmorinfo['sid']}";
	$resultprotabyesmorinfo = $rundb->Query($sqlprotabyesmorinfo); 
	$numrowsprotabyesmorinfo = $rundb->NumRows($resultprotabyesmorinfo);
	
	if($numrowsprotabyesmorinfo == 1){
	  $yesterdaymorningoutput += $rowprotaryesmorinfo['quantity'];
	}
  }
   

  $sqlprotaryesniginfo = "SELECT * FROM $proouttodtab WHERE $prodouttype AND (DATE_FORMAT(date_end, '%Y-%m-%d %H:%i:%s') >= '$yesterday 20:00:00' AND DATE_FORMAT(date_end, '%Y-%m-%d %H:%i:%s') < '$today 08:00:00')";
  $resultprotaryesniginfo = $rundb->Query($sqlprotaryesniginfo);
  
  while($rowprotaryesniginfo = $rundb->FetchArray($resultprotaryesniginfo)){
	$sqlprotabyesniginfo = "SELECT * FROM $protodtab WHERE $prodtype AND sid = {$rowprotaryesniginfo['sid']}";
	$resultprotabyesniginfo = $rundb->Query($sqlprotabyesniginfo); 
	$numrowsprotabyesniginfo = $rundb->NumRows($resultprotabyesniginfo);
	
	if($numrowsprotabyesniginfo == 1){
      $yesterdaynightoutput += $rowprotaryesniginfo['quantity'];
	}
  }
  
  
  $yesterdaybalance = $yesterdayinput - $yesterdaymorningoutput - $yesterdaynightoutput + $yesterdaybacklog;
  
  $yesterdaybalancetarget = max($yesterdaytarget - $yesterdaymorningoutput - $yesterdaynightoutput, 0); //put figures to 0 if the quantity is less than 0
  
  
  //get the rest of the today information  
  if($jtype == 1 || $jtype == 2 || $jtype == 3 || $jtype == 9){
    $sqlprotodinfo = "SELECT SUM(quantity) AS quantity FROM $protodtab WHERE $prodtype AND date_issue = '$today' AND status = 'active' AND (( bid = $bid )OR (operation = 1 OR operation = 3))";
    $resultprotodinfo = $rundb->Query($sqlprotodinfo);
    $rowprotodinfo = $rundb->FetchArray($resultprotodinfo);
  
    $todayinput = $rowprotodinfo['quantity'];
  }
  else if($jtype == 4 || $jtype == 5 || $jtype == 6 || $jtype == 7 || $jtype == 8){
	$sqlprotodinfo = "SELECT * FROM $protodtab WHERE $prodtype AND date_issue = '$today' AND status = 'active' AND (( bid = $bid )OR (operation = 1 OR operation = 3))";
    $resultprotodinfo = $rundb->Query($sqlprotodinfo);
    
	while($rowprotodinfo = $rundb->FetchArray($resultprotodinfo)){
	  $sqlpre = "SELECT * FROM premachining WHERE pmid = {$rowprotodinfo['process']} AND $processtype";	
	  $resultpre = $rundb->Query($sqlpre);
	  $numrowspre = $rundb->NumRows($resultpre);
	  
	  if($numrowspre == 1){
	    $todayinput += $rowprotodinfo['quantity']; 
	  }
	}
  }
  

  $sqlprotartodmorinfo = "SELECT * FROM $proouttodtab WHERE $prodouttype AND (DATE_FORMAT(date_end, '%Y-%m-%d %H:%i:%s') >= '$today 08:00:00' AND DATE_FORMAT(date_end, '%Y-%m-%d %H:%i:%s') < '$today 20:00:00')";
  $resultprotartodmorinfo = $rundb->Query($sqlprotartodmorinfo);
  
  while($rowprotartodmorinfo = $rundb->FetchArray($resultprotartodmorinfo)){
    $sqlprotabtodmorinfo = "SELECT * FROM $protodtab WHERE $prodtype AND sid = {$rowprotartodmorinfo['sid']}";
	$resultprotabtodmorinfo = $rundb->Query($sqlprotabtodmorinfo); 
	$numrowsprotabtodmorinfo = $rundb->NumRows($resultprotabtodmorinfo);
	
	if($numrowsprotabtodmorinfo == 1){
  	  $todaymorningoutput += $rowprotartodmorinfo['quantity'];
	}
  }
  

  $sqlprotartodniginfo = "SELECT * FROM $proouttomtab WHERE $prodouttype AND (DATE_FORMAT(date_end, '%Y-%m-%d %H:%i:%s') >= '$today 20:00:00' AND DATE_FORMAT(date_end, '%Y-%m-%d %H:%i:%s') < '$tomorrow 08:00:00')";
  $resultprotartodniginfo = $rundb->Query($sqlprotartodniginfo);
  
  while($rowprotartodniginfo = $rundb->FetchArray($resultprotartodniginfo)){
	$sqlprotabtodniginfo = "SELECT * FROM $protodtab WHERE $prodtype AND sid = {$rowprotartodniginfo['sid']}";
	$resultprotabtodniginfo = $rundb->Query($sqlprotabtodniginfo); 
	$numrowsprotabtodniginfo = $rundb->NumRows($resultprotabtodniginfo);
	
	if($numrowsprotabtodniginfo == 1){
	  $todaynightoutput += $rowprotartodniginfo['quantity'];
	}
  }
  
  
  $todaybalance = $todayinput - $todaymorningoutput - $todaynightoutput + $todaybacklog;
  
  $todaybalancetarget = max($todaytarget - $todaymorningoutput - $todaynightoutput, 0); //put figures to 0 if the quantity is less than 0
  ?>
  <tr>
    <td colspan="5">PRODUCTION DAILY TARGET - <?php echo "{$rowprotardef['jobtype']} {$rowprotardef['size']}"; ?></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td width="25%">Date</td>
    <td width="20%"><?php echo date('d-m-Y', strtotime($yesterday)); ?></td>
    <td width="10%">&nbsp;</td>
    <td width="25%">Date</td>
    <td width="20%"><?php echo date('d-m-Y', strtotime($today)); ?></td>
  </tr>
  <tr>
    <td>Target Quantity</td>
    <td><?php echo $yesterdaytarget; ?></td>
    <td>&nbsp;</td>
    <td>Target Quantity</td>
    <td><?php echo $todaytarget; ?></td>
  </tr>
  <tr>
    <td>Backlog C/F</td>
    <td><?php echo $yesterdaybacklog; ?></td>
    <td>&nbsp;</td>
    <td>Backlog C/F</td>
    <td><?php echo $todaybacklog; ?></td>
  </tr>
  <tr>
    <td>Yesterday Input</td>
    <td><?php echo $yesterdayinput; ?></td>
    <td>&nbsp;</td>
    <td>Today Input</td>
    <td><?php echo $todayinput; ?></td>
  </tr>
  <tr>
    <td>Yesterday Output (Morning)</td>
    <td><?php echo $yesterdaymorningoutput; ?></td>
    <td>&nbsp;</td>
    <td>Today Output (Morning)</td>
    <td><?php echo $todaymorningoutput; ?></td>
  </tr>
  <tr>
    <td>Yesterday Output (Night)</td>
    <td><?php echo $yesterdaynightoutput; ?></td>
    <td>&nbsp;</td>
    <td>Today Output (Night)</td>
    <td><?php echo $todaynightoutput; ?></td>
  </tr>
  <tr>
    <td>Balance Quantity</td>
    <td><?php echo $yesterdaybalance; ?></td>
    <td>&nbsp;</td>
    <td>Balance Quantity</td>
    <td><?php echo $todaybalance; ?></td>
  </tr>
  <tr>
    <td>Balance To Achieve Target</td>
    <td><?php echo $yesterdaybalancetarget; ?></td>
    <td>&nbsp;</td>
    <td>Balance To Achieve Target</td>
    <td><?php echo $todaybalancetarget; ?></td>
  </tr>
</table>
<?php
}
?>