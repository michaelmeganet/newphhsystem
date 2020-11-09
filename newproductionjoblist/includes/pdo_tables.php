<?php
//create table quotation of the current year and month if not exist

function createQuotationPSVPMB($quotab){
  $sqlctbqu = "CREATE TABLE IF NOT EXISTS `$quotab` (
		  	  `qid` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `bid` int(10) unsigned NOT NULL,
			  `currency` int(10) NOT NULL,
			  `quono` varchar(20) NOT NULL,
			  `company` varchar(10) NOT NULL,
			  `pagetype` varchar(15) NOT NULL,
			  `custype` varchar(15) DEFAULT NULL,
			  `cusstatus` varchar(10) DEFAULT NULL,
		      `cid` int(10) unsigned NOT NULL,
		      `accno` varchar(8) DEFAULT NULL,
		      `date` date NOT NULL,
		      `terms` varchar(30) NOT NULL,
		      `item` varchar(5) NOT NULL,
		      `quantity` int(10) NOT NULL,
		      `grade` varchar(30) NOT NULL,
			  `description` text NOT NULL,
		      `mat` decimal(20,2) NOT NULL,
		      `pmach` decimal(20,2) DEFAULT NULL,
		      `cncmach` decimal(20,2) DEFAULT NULL,
		      `other` decimal(20,2) DEFAULT NULL,
		      `unitprice` decimal(20,2) NOT NULL,
		      `amount` decimal(20,2) NOT NULL,
		      `discount` decimal(20,2) DEFAULT NULL,
			  `vat` decimal(20,2) DEFAULT NULL,
			  `gst` decimal(20,2) DEFAULT NULL,
			  `ftz` varchar(5) DEFAULT NULL,
			  `amountmat` decimal(10,2) DEFAULT NULL,
			  `discountmat` decimal(10,2) DEFAULT NULL,
			  `gstmat` decimal(10,2) DEFAULT NULL,
			  `totalamountmat` decimal(10,2) DEFAULT NULL,
			  `amountpmach` decimal(10,2) DEFAULT NULL,
			  `discountpmach` decimal(10,2) DEFAULT NULL,
			  `gstpmach` decimal(10,2) DEFAULT NULL,
			  `totalamountpmach` decimal(10,2) DEFAULT NULL,
			  `amountcncmach` decimal(10,2) DEFAULT NULL,
			  `discountcncmach` decimal(10,2) DEFAULT NULL,
			  `gstcncmach` decimal(10,2) DEFAULT NULL,
			  `totalamountcncmach` decimal(10,2) DEFAULT NULL,
			  `amountother` decimal(10,2) DEFAULT NULL,
			  `discountother` decimal(10,2) DEFAULT NULL,
			  `gstother` decimal(10,2) DEFAULT NULL,
			  `totalamountother` decimal(10,2) DEFAULT NULL,
			  `totalamount` decimal(20,2) NOT NULL,
		      `mat_disc` decimal(5,2) DEFAULT NULL,
		      `pmach_disc` decimal(5,2) DEFAULT NULL,
		      `aid_quo` int(10) unsigned NOT NULL,
		      `aid_cus` int(10) unsigned NOT NULL,
		      `datetimeissue` datetime NOT NULL,
		      `odissue` varchar(10) NOT NULL DEFAULT 'no',
		      PRIMARY KEY (`qid`)
		      ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
  
//  $rundb->Query($sqlctbqu);
  $objPDO = new SQL($sqlctbqu);
  $result = $objPDO->getExecute();
  if ($result == 'Executed ok!') {
      $respone = "$result  executed createQuotationPSVPMB of $quotab  <br>";
  }elseif ($result == 'Execution failed!') {
      $respone = "$result  Fail in execution for createQuotationPSVPMB  of $quotab <br>";
    }
 
  return $respone;
}
function createQuotation($quotab){
  $sqlctbqu = "CREATE TABLE IF NOT EXISTS `$quotab` (
		  	  `qid` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `bid` int(10) unsigned NOT NULL,
			  `currency` int(10) NOT NULL,
		  	  `quono` varchar(20) NOT NULL,
		  	  `company` varchar(10) NOT NULL,
		      `pagetype` varchar(15) NOT NULL,
		      `custype` varchar(15) DEFAULT NULL,
			  `cusstatus` varchar(10) DEFAULT NULL,
		      `cid` int(10) unsigned NOT NULL,
		      `accno` varchar(8) DEFAULT NULL,
		      `date` date NOT NULL,
		      `terms` varchar(30) NOT NULL,
		      `item` varchar(5) NOT NULL,
		      `quantity` int(10) NOT NULL,
		      `grade` varchar(30) NOT NULL,
		      `mdt` varchar(15) DEFAULT NULL,
		      `mdw` varchar(15) DEFAULT NULL,
		      `mdl` varchar(15) DEFAULT NULL,
		      `fdt` varchar(15) DEFAULT NULL,
		      `fdw` varchar(15) DEFAULT NULL,
		      `fdl` varchar(15) DEFAULT NULL,
		      `process` varchar(20) DEFAULT NULL,
		      `mat` decimal(20,2) NOT NULL,
		      `pmach` decimal(20,2) DEFAULT NULL,
		      `cncmach` decimal(20,2) DEFAULT NULL,
		      `other` decimal(20,2) DEFAULT NULL,
		      `unitprice` decimal(20,2) NOT NULL,
		      `amount` decimal(20,2) NOT NULL,
		      `discount` decimal(20,2) DEFAULT NULL,
			  `vat` decimal(20,2) DEFAULT NULL,
			  `gst` decimal(20,2) DEFAULT NULL,
			  `ftz` varchar(5) DEFAULT NULL,
			  `amountmat` decimal(10,2) DEFAULT NULL,
			  `discountmat` decimal(10,2) DEFAULT NULL,
			  `gstmat` decimal(10,2) DEFAULT NULL,
			  `totalamountmat` decimal(10,2) DEFAULT NULL,
			  `amountpmach` decimal(10,2) DEFAULT NULL,
			  `discountpmach` decimal(10,2) DEFAULT NULL,
			  `gstpmach` decimal(10,2) DEFAULT NULL,
			  `totalamountpmach` decimal(10,2) DEFAULT NULL,
			  `amountcncmach` decimal(10,2) DEFAULT NULL,
			  `discountcncmach` decimal(10,2) DEFAULT NULL,
			  `gstcncmach` decimal(10,2) DEFAULT NULL,
			  `totalamountcncmach` decimal(10,2) DEFAULT NULL,
			  `amountother` decimal(10,2) DEFAULT NULL,
			  `discountother` decimal(10,2) DEFAULT NULL,
			  `gstother` decimal(10,2) DEFAULT NULL,
			  `totalamountother` decimal(10,2) DEFAULT NULL,
			  `totalamount` decimal(20,2) NOT NULL,
		      `mat_disc` decimal(5,2) DEFAULT NULL,
		      `pmach_disc` decimal(5,2) DEFAULT NULL,
		      `aid_quo` int(10) unsigned NOT NULL,
		      `aid_cus` int(10) unsigned NOT NULL,
		      `datetimeissue` datetime NOT NULL,
		      `odissue` varchar(10) NOT NULL DEFAULT 'no',
		      PRIMARY KEY (`qid`)
		      ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

  $objPDO = new SQL($sqlctbqu);
  $result = $objPDO->getExecute();
  if ($result == 'Executed ok!') {
      $respone = "$result  executed createQuotation  of $quotab <br>";
  }elseif ($result == 'Execution failed!') {
      $respone = "$result  Fail in execution for createQuotation  of $quotab <br>";
    }
 
  return $respone;
}


//create table quotation remarks of the current year and month if not exist
function createQuotationRemarks($quoremtab){
  $sqlctbqr = "CREATE TABLE IF NOT EXISTS `$quoremtab` (
			  `bid` int(10) unsigned NOT NULL,
			  `quono` varchar(20) NOT NULL,
			  `cid` int(10) unsigned NOT NULL,
			  `remarks1` varchar(100) DEFAULT NULL,
			  `remarks2` varchar(100) DEFAULT NULL,
			  `remarks3` varchar(100) DEFAULT NULL,
			  `remarks4` varchar(100) DEFAULT NULL
			  ) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
  
  
  $objPDO = new SQL($sqlctbqr);
  $result = $objPDO->getExecute();
  if ($result == 'Executed ok!') {
      $respone = "$result  executed createQuotationRemarks  of $quoremtab <br>";
  }elseif ($result == 'Execution failed!') {
      $respone = "$result  Fail in execution for createQuotationRemarks  of $quoremtab <br>";
    }
 
  return $respone;          
  
}


//create table quotation log of the current year and month if not exist
function createQuotationLog( $quologtab){
  $sqlctbql = "CREATE TABLE IF NOT EXISTS `$quologtab` (
			  `qlid` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `bid` int(10) unsigned NOT NULL,
			  `quono` varchar(20) NOT NULL,
			  `company` varchar(10) NOT NULL,
			  `date` date NOT NULL,
			  `1st_date` date DEFAULT NULL,
			  `1st_status` varchar(15) DEFAULT NULL,
			  `2nd_date` date DEFAULT NULL,
			  `2nd_status` varchar(15) DEFAULT NULL,
			  `3rd_date` date DEFAULT NULL,
			  `3rd_status` varchar(15) DEFAULT NULL,
			  `remarks` varchar(50) DEFAULT NULL,
			  `cid` int(10) unsigned NOT NULL,
			  `aid_cus` int(10) unsigned NOT NULL,
			  `aid_quo` int(10) unsigned NOT NULL,
			  PRIMARY KEY (`qlid`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
  $objPDO = new SQL($sqlctbql);
  $result = $objPDO->getExecute();
  if ($result == 'Executed ok!') {
      $respone = "$result  executed createQuotationLog of $quologtab <br>";
  }elseif ($result == 'Execution failed!') {
      $respone = "$result  Fail in execution for createQuotationLog of $quologtab <br>";
    }
 
  return $respone;
  
  
}


//create table quotation delete of the current year and month if not exist
function createQuotationDeletePSVPMB($quodeltab){
  $sqlctbqd = "CREATE TABLE IF NOT EXISTS `$quodeltab` (
			  `qdid` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `qid` int(10) unsigned NOT NULL,
			  `bid` int(10) unsigned NOT NULL,
			  `currency` int(10) NOT NULL,
			  `quono` varchar(20) NOT NULL,
			  `company` varchar(10) NOT NULL,
			  `pagetype` varchar(15) NOT NULL,
			  `custype` varchar(15) DEFAULT NULL,
			  `cusstatus` varchar(10) DEFAULT NULL,
			  `cid` int(10) unsigned NOT NULL,
			  `accno` varchar(8) DEFAULT NULL,
			  `date` date NOT NULL,
			  `terms` varchar(30) NOT NULL,
			  `item` varchar(5) NOT NULL,
		      `quantity` int(10) NOT NULL,
		      `grade` varchar(30) NOT NULL,
			  `description` text NOT NULL,
		      `mat` decimal(20,2) NOT NULL,
			  `pmach` decimal(20,2) DEFAULT NULL,
			  `cncmach` decimal(20,2) DEFAULT NULL,
			  `other` decimal(20,2) DEFAULT NULL,
		      `unitprice` decimal(20,2) NOT NULL,
			  `amount` decimal(20,2) NOT NULL,
			  `discount` decimal(20,2) DEFAULT NULL,
			  `vat` decimal(20,2) DEFAULT NULL,
			  `gst` decimal(20,2) DEFAULT NULL,
			  `ftz` varchar(5) DEFAULT NULL,
			  `amountmat` decimal(10,2) DEFAULT NULL,
			  `discountmat` decimal(10,2) DEFAULT NULL,
			  `gstmat` decimal(10,2) DEFAULT NULL,
			  `totalamountmat` decimal(10,2) DEFAULT NULL,
			  `amountpmach` decimal(10,2) DEFAULT NULL,
			  `discountpmach` decimal(10,2) DEFAULT NULL,
			  `gstpmach` decimal(10,2) DEFAULT NULL,
			  `totalamountpmach` decimal(10,2) DEFAULT NULL,
			  `amountcncmach` decimal(10,2) DEFAULT NULL,
			  `discountcncmach` decimal(10,2) DEFAULT NULL,
			  `gstcncmach` decimal(10,2) DEFAULT NULL,
			  `totalamountcncmach` decimal(10,2) DEFAULT NULL,
			  `amountother` decimal(10,2) DEFAULT NULL,
			  `discountother` decimal(10,2) DEFAULT NULL,
			  `gstother` decimal(10,2) DEFAULT NULL,
			  `totalamountother` decimal(10,2) DEFAULT NULL,
			  `totalamount` decimal(20,2) NOT NULL,
			  `mat_disc` decimal(5,2) DEFAULT NULL,
			  `pmach_disc` decimal(5,2) DEFAULT NULL,
			  `aid_quo` int(10) unsigned NOT NULL,
			  `aid_cus` int(10) unsigned NOT NULL,
			  `datetimeissue` datetime NOT NULL,
			  `odissue` varchar(10) NOT NULL DEFAULT 'no',
			  `remarks1` varchar(100) DEFAULT NULL,
			  `remarks2` varchar(100) DEFAULT NULL,
			  `remarks3` varchar(100) DEFAULT NULL,
			  `remarks4` varchar(100) DEFAULT NULL,
			  `deleteby` int(10) unsigned NOT NULL,
			  `datetimedelete_quo` date NOT NULL,
			  PRIMARY KEY (`qdid`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
  $objPDO = new SQL($sqlctbqd);
  $result = $objPDO->getExecute();
  if ($result == 'Executed ok!') {
      $respone = "$result  executed createQuotationDeletePSVPMB of $quodeltab <br>";
  }elseif ($result == 'Execution failed!') {
      $respone = "$result  Fail in execution for createQuotationDeletePSVPMB  of $quodeltab<br>";
    }
 
  return $respone;
  
}


//create table quotation delete of the current year and month if not exist
function createQuotationDelete($quodeltab){
  $sqlctbqd = "CREATE TABLE IF NOT EXISTS `$quodeltab` (
			  `qdid` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `qid` int(10) unsigned NOT NULL,
			  `bid` int(10) unsigned NOT NULL,
			  `currency` int(10) NOT NULL,
			  `quono` varchar(20) NOT NULL,
			  `company` varchar(10) NOT NULL,
			  `pagetype` varchar(15) NOT NULL,
			  `custype` varchar(15) DEFAULT NULL,
			  `cusstatus` varchar(10) DEFAULT NULL,
			  `cid` int(10) unsigned NOT NULL,
			  `accno` varchar(8) DEFAULT NULL,
			  `date` date NOT NULL,
			  `terms` varchar(30) NOT NULL,
			  `item` varchar(5) NOT NULL,
			  `quantity` int(10) NOT NULL,
			  `grade` varchar(30) NOT NULL,
			  `mdt` varchar(10) NOT NULL,
			  `mdw` varchar(10) DEFAULT NULL,
			  `mdl` varchar(10) NOT NULL,
			  `fdt` varchar(10) DEFAULT NULL,
			  `fdw` varchar(10) DEFAULT NULL,
			  `fdl` varchar(10) DEFAULT NULL,
			  `process` varchar(20) DEFAULT NULL,
			  `mat` decimal(20,2) NOT NULL,
			  `pmach` decimal(20,2) DEFAULT NULL,
			  `cncmach` decimal(20,2) DEFAULT NULL,
			  `other` decimal(20,2) DEFAULT NULL,
			  `unitprice` decimal(20,2) NOT NULL,
			  `amount` decimal(20,2) NOT NULL,
			  `discount` decimal(20,2) DEFAULT NULL,
			  `vat` decimal(20,2) DEFAULT NULL,
			  `gst` decimal(20,2) DEFAULT NULL,
			  `ftz` varchar(5) DEFAULT NULL,
			  `amountmat` decimal(10,2) DEFAULT NULL,
			  `discountmat` decimal(10,2) DEFAULT NULL,
			  `gstmat` decimal(10,2) DEFAULT NULL,
			  `totalamountmat` decimal(10,2) DEFAULT NULL,
			  `amountpmach` decimal(10,2) DEFAULT NULL,
			  `discountpmach` decimal(10,2) DEFAULT NULL,
			  `gstpmach` decimal(10,2) DEFAULT NULL,
			  `totalamountpmach` decimal(10,2) DEFAULT NULL,
			  `amountcncmach` decimal(10,2) DEFAULT NULL,
			  `discountcncmach` decimal(10,2) DEFAULT NULL,
			  `gstcncmach` decimal(10,2) DEFAULT NULL,
			  `totalamountcncmach` decimal(10,2) DEFAULT NULL,
			  `amountother` decimal(10,2) DEFAULT NULL,
			  `discountother` decimal(10,2) DEFAULT NULL,
			  `gstother` decimal(10,2) DEFAULT NULL,
			  `totalamountother` decimal(10,2) DEFAULT NULL,
			  `totalamount` decimal(20,2) NOT NULL,
			  `mat_disc` decimal(5,2) DEFAULT NULL,
			  `pmach_disc` decimal(5,2) DEFAULT NULL,
			  `aid_quo` int(10) unsigned NOT NULL,
			  `aid_cus` int(10) unsigned NOT NULL,
			  `datetimeissue` datetime NOT NULL,
			  `odissue` varchar(10) NOT NULL DEFAULT 'no',
			  `remarks1` varchar(100) DEFAULT NULL,
			  `remarks2` varchar(100) DEFAULT NULL,
			  `remarks3` varchar(100) DEFAULT NULL,
			  `remarks4` varchar(100) DEFAULT NULL,
			  `deleteby` int(10) unsigned NOT NULL,
			  `datetimedelete_quo` date NOT NULL,
			  PRIMARY KEY (`qdid`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

    $objPDO = new SQL($sqlctbqd);
    $result = $objPDO->getExecute();
    if ($result == 'Executed ok!') {
      $respone = "$result  executed createQuotationDelete of $quodeltab <br>";
    }elseif ($result == 'Execution failed!') {
      $respone = "$result  Fail in execution for createQuotationDelete of $quodeltab<br>";
    }

    return $respone;
  
   
}


//create table runningno of the current year and month if not exist
function createRunningNo($runtab){
  $sqlctbru = "CREATE TABLE IF NOT EXISTS `$runtab` (
			  `rnid` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `bid` int(10) unsigned NOT NULL,
			  `date_issue` date NOT NULL,
			  `runno` int(10) unsigned NOT NULL,
			  `todayorderno` int(10) unsigned NOT NULL,
			  `qid` int(10) NOT NULL,
			  `quono` varchar(20) NOT NULL,
			  `cid` int(10) unsigned NOT NULL,
			  `company` varchar(10) NOT NULL,
			  PRIMARY KEY (`rnid`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

    $objPDO = new SQL($sqlctbru);
    $result = $objPDO->getExecute();
    if ($result == 'Executed ok!') {
     $respone = "$result  executed createRunningNo of $runtab <br>";
    }elseif ($result == 'Execution failed!') {
     $respone = "$result  Fail in execution for createRunningNo of $runtab<br>";
    }

    return $respone;
//  $rundb->Query($sqlctbru);
//  $result = "executed createRunningNo of $runtab<br>";
//  return $result;   
}


//create table orderlist of the current year and month if not exist
function createOrderlistPSVPMB($ordtab){
  $sqlctbor = "CREATE TABLE IF NOT EXISTS `$ordtab` (
			  `oid` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `bid` int(10) unsigned NOT NULL,
			  `currency` int(10) NOT NULL,
			  `qid` int(10) unsigned NOT NULL,
			  `quono` varchar(20) NOT NULL,
			  `company` varchar(10) NOT NULL,
			  `cusstatus` varchar(10) NOT NULL,
			  `cid` int(10) unsigned NOT NULL,
			  `accno` varchar(8) DEFAULT NULL,
			  `date` date NOT NULL,
			  `terms` varchar(30) NOT NULL,
			  `noposition` int(10) unsigned NOT NULL,
			  `item` varchar(5) NOT NULL,
			  `quantity` int(10) NOT NULL,
			  `grade` varchar(30) NOT NULL,
			  `description` text NOT NULL,
			  `mat` decimal(20,2) NOT NULL,
			  `pmach` decimal(20,2) DEFAULT NULL,
			  `cncmach` decimal(20,2) DEFAULT NULL,
			  `other` decimal(20,2) DEFAULT NULL,
			  `unitprice` decimal(20,2) NOT NULL,
			  `amount` decimal(20,2) NOT NULL,
			  `discount` decimal(20,2) DEFAULT NULL,
			  `vat` decimal(20,2) DEFAULT NULL,
			  `gst` decimal(20,2) DEFAULT NULL,
			  `ftz` varchar(5) DEFAULT NULL,
			  `amountmat` decimal(10,2) DEFAULT NULL,
			  `discountmat` decimal(10,2) DEFAULT NULL,
			  `gstmat` decimal(10,2) DEFAULT NULL,
			  `totalamountmat` decimal(10,2) DEFAULT NULL,
			  `amountpmach` decimal(10,2) DEFAULT NULL,
			  `discountpmach` decimal(10,2) DEFAULT NULL,
			  `gstpmach` decimal(10,2) DEFAULT NULL,
			  `totalamountpmach` decimal(10,2) DEFAULT NULL,
			  `amountcncmach` decimal(10,2) DEFAULT NULL,
			  `discountcncmach` decimal(10,2) DEFAULT NULL,
			  `gstcncmach` decimal(10,2) DEFAULT NULL,
			  `totalamountcncmach` decimal(10,2) DEFAULT NULL,
			  `amountother` decimal(10,2) DEFAULT NULL,
			  `discountother` decimal(10,2) DEFAULT NULL,
			  `gstother` decimal(10,2) DEFAULT NULL,
			  `totalamountother` decimal(10,2) DEFAULT NULL,
			  `totalamount` decimal(20,2) NOT NULL,
			  `aid_quo` int(10) unsigned NOT NULL,
			  `aid_cus` int(10) unsigned NOT NULL,
			  `datetimeissue_quo` datetime NOT NULL,
			  `olremarks` varchar(100) DEFAULT NULL,
			  `date_issue` date NOT NULL,
			  `completion_date` varchar(15) NOT NULL,
			  `source` varchar(10) NOT NULL,
			  `cuttingtype` varchar(20) NOT NULL,
			  `tol_thkp` varchar(4) NOT NULL,
			  `tol_thkm` varchar(4) NOT NULL,
			  `tol_wdtp` varchar(4) NOT NULL,
			  `tol_wdtm` varchar(4) NOT NULL,
			  `tol_lghp` varchar(4) NOT NULL,
			  `tol_lghm` varchar(4) NOT NULL,
			  `chamfer` varchar(5) NOT NULL,
			  `flatness` varchar(5) NOT NULL,
			  `ihremarks` int(10) DEFAULT NULL,
			  `ivremarks` varchar(30) DEFAULT NULL,
			  `ivpono` varchar(20) DEFAULT NULL,
			  `custoolcode` varchar(20) DEFAULT NULL,
			  `runningno` varchar(4) NOT NULL,
			  `jobno` varchar(3) NOT NULL,
			  `ivdate` date NOT NULL,
			  `aid_ol` int(10) unsigned NOT NULL,
			  `datetimeissue_ol` datetime NOT NULL,
			  `jlissue` varchar(10) NOT NULL DEFAULT 'no',
			  `jlreprint` varchar(10) NOT NULL DEFAULT 'no',
			  `jlreprintcount` int(10) NOT NULL DEFAULT '0',
			  `docount` int(10) DEFAULT NULL,
			  `dodate` date DEFAULT NULL,
			  `doissue` varchar(10) NOT NULL DEFAULT 'no',
			  `doreprint` varchar(10) NOT NULL DEFAULT 'no',
			  `doreprintcount` varchar(10) NOT NULL DEFAULT '0',
			  `driver` varchar(10) DEFAULT NULL,
			  `policyno` varchar(20) DEFAULT 'MOULDBASE',
			  `aid_do` int(10) unsigned DEFAULT NULL,
			  `stampsignature` varchar(5) NOT NULL DEFAULT 'no',
			  `aid_stampsignature` int(10) DEFAULT NULL,
			  `datetime_stampsignature` datetime DEFAULT NULL,
			  `ivissue` varchar(10) NOT NULL DEFAULT 'no',
			  `ivreprint` varchar(10) NOT NULL DEFAULT 'no',
			  `ivreprintcount` int(10) NOT NULL DEFAULT '0',
			  PRIMARY KEY (`oid`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

  
    $objPDO = new SQL($sqlctbor);
    $result = $objPDO->getExecute();
    if ($result == 'Executed ok!') {
    $respone = "$result  executed createOrderlistPSVPMB of $ordtab <br>";
    }elseif ($result == 'Execution failed!') {
    $respone = "$result  Fail in execution for createOrderlistPSVPMB of $ordtab<br>";
    }

    return $respone;

}


//create table orderlist of the current year and month if not exist
function createOrderlist($ordtab){
  $sqlctbor = "CREATE TABLE IF NOT EXISTS `$ordtab` (
			  `oid` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `bid` int(10) unsigned NOT NULL,
			  `currency` int(10) NOT NULL,
			  `qid` int(10) unsigned NOT NULL,
			  `quono` varchar(20) NOT NULL,
			  `company` varchar(10) NOT NULL,
			  `cusstatus` varchar(10) NOT NULL,
			  `cid` int(10) unsigned NOT NULL,
			  `accno` varchar(8) DEFAULT NULL,
			  `date` date NOT NULL,
			  `terms` varchar(30) NOT NULL,
			  `noposition` int(10) unsigned NOT NULL,
			  `item` varchar(5) NOT NULL,
			  `quantity` int(10) NOT NULL,
			  `grade` varchar(30) NOT NULL,
			  `mdt` varchar(15) DEFAULT NULL,
			  `mdw` varchar(15) DEFAULT NULL,
			  `mdl` varchar(15) DEFAULT NULL,
			  `fdt` varchar(15) DEFAULT NULL,
			  `fdw` varchar(15) DEFAULT NULL,
			  `fdl` varchar(15) DEFAULT NULL,
			  `process` varchar(20) DEFAULT NULL,
			  `mat` decimal(20,2) NOT NULL,
			  `pmach` decimal(20,2) DEFAULT NULL,
			  `cncmach` decimal(20,2) DEFAULT NULL,
			  `other` decimal(20,2) DEFAULT NULL,
			  `unitprice` decimal(20,2) NOT NULL,
			  `amount` decimal(20,2) NOT NULL,
			  `discount` decimal(20,2) DEFAULT NULL,
			  `vat` decimal(20,2) DEFAULT NULL,
			  `gst` decimal(20,2) DEFAULT NULL,
			  `ftz` varchar(5) DEFAULT NULL,
			  `amountmat` decimal(10,2) DEFAULT NULL,
			  `discountmat` decimal(10,2) DEFAULT NULL,
			  `gstmat` decimal(10,2) DEFAULT NULL,
			  `totalamountmat` decimal(10,2) DEFAULT NULL,
			  `amountpmach` decimal(10,2) DEFAULT NULL,
			  `discountpmach` decimal(10,2) DEFAULT NULL,
			  `gstpmach` decimal(10,2) DEFAULT NULL,
			  `totalamountpmach` decimal(10,2) DEFAULT NULL,
			  `amountcncmach` decimal(10,2) DEFAULT NULL,
			  `discountcncmach` decimal(10,2) DEFAULT NULL,
			  `gstcncmach` decimal(10,2) DEFAULT NULL,
			  `totalamountcncmach` decimal(10,2) DEFAULT NULL,
			  `amountother` decimal(10,2) DEFAULT NULL,
			  `discountother` decimal(10,2) DEFAULT NULL,
			  `gstother` decimal(10,2) DEFAULT NULL,
			  `totalamountother` decimal(10,2) DEFAULT NULL,
			  `totalamount` decimal(20,2) NOT NULL,
			  `aid_quo` int(10) unsigned NOT NULL,
			  `aid_cus` int(10) unsigned NOT NULL,
			  `datetimeissue_quo` datetime NOT NULL,
			  `olremarks` varchar(100) DEFAULT NULL,
			  `date_issue` date NOT NULL,
			  `completion_date` varchar(15) NOT NULL,
			  `source` varchar(10) NOT NULL,
			  `cuttingtype` varchar(20) NOT NULL,
			  `tol_thkp` varchar(4) NOT NULL,
			  `tol_thkm` varchar(4) NOT NULL,
			  `tol_wdtp` varchar(4) NOT NULL,
			  `tol_wdtm` varchar(4) NOT NULL,
			  `tol_lghp` varchar(4) NOT NULL,
			  `tol_lghm` varchar(4) NOT NULL,
			  `chamfer` varchar(5) NOT NULL,
			  `flatness` varchar(5) NOT NULL,
			  `ihremarks` int(10) DEFAULT NULL,
			  `ivremarks` varchar(30) DEFAULT NULL,
			  `ivpono` varchar(20) DEFAULT NULL,
			  `custoolcode` varchar(20) DEFAULT NULL,
			  `runningno` varchar(4) NOT NULL,
			  `jobno` varchar(3) NOT NULL,
			  `ivdate` date NOT NULL,
			  `aid_ol` int(10) unsigned NOT NULL,
			  `datetimeissue_ol` datetime NOT NULL,
			  `jlissue` varchar(10) NOT NULL DEFAULT 'no',
			  `jlreprint` varchar(10) NOT NULL DEFAULT 'no',
			  `jlreprintcount` int(10) NOT NULL DEFAULT '0',
			  `docount` int(10) DEFAULT NULL,
			  `dodate` date DEFAULT NULL,
			  `doissue` varchar(10) NOT NULL DEFAULT 'no',
			  `doreprint` varchar(10) NOT NULL DEFAULT 'no',
			  `doreprintcount` varchar(10) NOT NULL DEFAULT '0',
			  `driver` varchar(10) DEFAULT NULL,
			  `policyno` varchar(20) DEFAULT 'PST',
			  `aid_do` int(10) unsigned DEFAULT NULL,
			  `stampsignature` varchar(5) NOT NULL DEFAULT 'no',
			  `aid_stampsignature` int(10) DEFAULT NULL,
			  `datetime_stampsignature` datetime DEFAULT NULL,
			  `ivissue` varchar(10) NOT NULL DEFAULT 'no',
			  `ivreprint` varchar(10) NOT NULL DEFAULT 'no',
			  `ivreprintcount` int(10) NOT NULL DEFAULT '0',
			  `operation` int(3) NOT NULL DEFAULT '1',
			  PRIMARY KEY (`oid`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

    $objPDO = new SQL($sqlctbor);
    $result = $objPDO->getExecute();
    if ($result == 'Executed ok!') {
    $respone = "$result  executed createOrderlist of $ordtab<br>";
    }elseif ($result == 'Execution failed!') {
    $respone = "$result  Fail in execution for createOrderlist of $ordtab<br>";
    }

    return $respone;

}


//create table joblist reissue of the current year and month if not exist
function createJoblistReissue($jobridtab){
  $sqlctbjr = "CREATE TABLE IF NOT EXISTS `$jobridtab` (
			   `jrid` int(10) unsigned NOT NULL AUTO_INCREMENT,
			   `bid` int(10) unsigned NOT NULL,
			   `quono` varchar(20) NOT NULL,
			   `company` varchar(10) NOT NULL,
			   `cid` int(10) unsigned NOT NULL,
			   `date_reissue` datetime NOT NULL,
			   `request_by` int(10) unsigned NOT NULL,
			   `reason` varchar(255) NOT NULL,
			   `reissue_by` int(10) unsigned NOT NULL,
			   PRIMARY KEY (`jrid`)
			 ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

    $objPDO = new SQL($sqlctbjr);
    $result = $objPDO->getExecute();
    if ($result == 'Executed ok!') {
    $respone = "$result  executed createJoblistReissue of $jobridtab<br>";
    }elseif ($result == 'Execution failed!') {
    $respone = "$result  Fail in execution for createJoblistReissue of $jobridtab<br>";
    }

    return $respone;  

}


//create table joblist manual reissue of the current year and month if not exist
function createJoblistManualReissue($jobmanridtab){
  $sqlctbjm = "CREATE TABLE IF NOT EXISTS `$jobmanridtab` (
			   `jmrid` int(10) unsigned NOT NULL AUTO_INCREMENT,
			   `bid` int(10) unsigned NOT NULL,
			   `quono` varchar(20) NOT NULL,
			   `company` varchar(10) NOT NULL,
			   `cid` int(10) unsigned NOT NULL,
			   `date_reissue` datetime NOT NULL,
			   `request_by` int(10) unsigned NOT NULL,
			   `reason` varchar(255) NOT NULL,
			   `reissue_by` int(10) unsigned NOT NULL,
			   PRIMARY KEY (`jmrid`)
			 ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

    $objPDO = new SQL($sqlctbjm);
    $result = $objPDO->getExecute();
    if ($result == 'Executed ok!') {
    $respone = "$result  executed createJoblistManualReissue of $jobmanridtab<br>";
    }elseif ($result == 'Execution failed!') {
    $respone = "$result  Fail in execution for createJoblistManualReissue of $jobmanridtab<br>";
    }

    return $respone; 
    
}


//create table invoiceno of the current year and month if not exist
function createInvoice($invtab){
  $sqlctbin = "CREATE TABLE IF NOT EXISTS `$invtab` (
			  `inid` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `bid` int(10) unsigned NOT NULL,
			  `date_issue` date NOT NULL,
			  `invcotype` varchar(4) NOT NULL,
			  `invrunno` varchar(10) NOT NULL,
			  `qid` int(10) NOT NULL,
			  `quono` varchar(20) NOT NULL,
			  `cid` int(10) unsigned NOT NULL,
			  `ivpono` varchar(20) DEFAULT NULL,
        `policyno` varchar(20) DEFAULT NULL,
			  PRIMARY KEY (`inid`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
 
  echo "\$sqlctbin = $sqlctbin <br>";
    $objPDO = new SQL($sqlctbin);
    $result = $objPDO->getExecute();
    if ($result == 'Executed ok!') {
    $respone = "$result  executed createInvoice of $invtab<br>";
    }elseif ($result == 'Execution failed!') {
    $respone = "$result  Fail in execution for createInvoice of $invtab<br>";
    }

    return $respone; 
  $rundb->Query($sqlctbin);
  $result = "executed createInvoice of $invtab<br>";
  return $result;      
}


//create table invoice log of the current year and month if not exist
function createInvoiceLog($invlogtab){
    
  $sqlctbin = "CREATE TABLE IF NOT EXISTS `$invlogtab` (
			  `inid` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `invcotype` varchar(4) NOT NULL,
			  `invrunno` varchar(10) NOT NULL,
			  `datetime_print` datetime NOT NULL,
			  `printby` int(10) unsigned NOT NULL,
			  `ivreprintcount` int(10) unsigned NOT NULL DEFAULT '0',
			  PRIMARY KEY (`inid`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
//echo "\$sqlctbin = $sqlctbin<br>";

    $objPDO = new SQL($sqlctbin);
    $result = $objPDO->getExecute();
    if ($result == 'Executed ok!') {
    $respone = "$result  executed createInvoiceLog of $invlogtab<br>";
    }elseif ($result == 'Execution failed!') {
    $respone = "$result  Fail in execution for createInvoiceLog of $invlogtab<br>";
    }

    return $respone;   
//  
//  if( $rundb->Query($sqlctbin)){
//     
//  $result = "executed createInvoiceLog of $invlogtab<br>";
//  return $result;        
// }else{
//     $db = dbConn::getConnection();
//     $sth = $db->prepare($sqlctbin);
//     $sth -> execute();
//     $result = "executed createInvoiceLog of $invlogtab<br>";
//     return $result;
// }
}


//create table invoice reissue of the current year and month if not exist
function createInvoiceReissue($invridtab){
  $sqlctbin = "CREATE TABLE IF NOT EXISTS `$invridtab` (
		      `irid` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `bid` int(10) unsigned NOT NULL,
			  `quono` varchar(20) NOT NULL,
			  `company` varchar(10) NOT NULL,
			  `cid` int(10) unsigned NOT NULL,
			  `invcotype` varchar(4) NOT NULL,
			  `invrunno` varchar(10) NOT NULL,
			  `date_reissue` datetime NOT NULL,
			  `request_by` int(10) unsigned NOT NULL,
			  `reason` varchar(255) NOT NULL,
			  `reissue_by` int(10) unsigned NOT NULL,
			  PRIMARY KEY (`irid`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

    $objPDO = new SQL($sqlctbin);
    $result = $objPDO->getExecute();
    if ($result == 'Executed ok!') {
    $respone = "$result  executed createInvoiceReissue of $invridtab<br>";
    }elseif ($result == 'Execution failed!') {
    $respone = "$result  Fail in execution for createInvoiceReissue of $invridtab<br>";
    }

    return $respone;  
     
}


//create table customer payment of the current year and month if not exist
function createCustomerPayment($custab){
  $sqlctbcu = "CREATE TABLE IF NOT EXISTS `$custab` (
			  `pid` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `bid` int(10) unsigned NOT NULL,
			  `currency` int(10) NOT NULL,
			  `cusstatus` varchar(10) DEFAULT NULL,
			  `accno` varchar(8) DEFAULT NULL,
			  `cid` int(10) unsigned NOT NULL,
			  `aid_cus` int(10) unsigned NOT NULL,
			  `quono` varchar(20) NOT NULL,
			  `company` varchar(10) NOT NULL,
			  `invcotype` varchar(4) NOT NULL,
			  `invno` varchar(10) NOT NULL,
			  `invdate` date DEFAULT NULL,
			  `invamount` decimal(20,2) DEFAULT NULL,
			  `vat` decimal(20,2) DEFAULT NULL,
			  `gst` decimal(20,2) DEFAULT NULL,
			  `invdatetime` datetime DEFAULT NULL,
			  `ortype` varchar(2) DEFAULT NULL,
			  `orno` int(10) unsigned DEFAULT NULL,
			  `accountpayment` int(10) unsigned DEFAULT NULL,
			  `paymentdate` date DEFAULT NULL,
			  `paymentamount` decimal(20,2) DEFAULT NULL,
			  `paymentmethod` int(10) unsigned DEFAULT NULL,
			  `chequeno` varchar(10) DEFAULT NULL,
			  `remarks` varchar(100) DEFAULT NULL,
			  `aid_pay` int(10) unsigned DEFAULT NULL,
			  `datetime` varchar(14) DEFAULT NULL,
			  `reference` varchar(20) DEFAULT NULL,
                          `docount` int(10) DEFAULT NULL,
			  PRIMARY KEY (`pid`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

    $objPDO = new SQL($sqlctbcu);
    $result = $objPDO->getExecute();
    if ($result == 'Executed ok!') {
    $respone = "$result  executed createCustomerPayment of $custab<br>";
    }elseif ($result == 'Execution failed!') {
    $respone = "$result  Fail in execution for createCustomerPayment of $custab<br>";
    }

    return $respone;    
  
  
}


//create table delivery address of the current year and month if not exist
function createDeliveryAddress($deltab){
  $sqlctbda = "CREATE TABLE IF NOT EXISTS `$deltab` (
			  `did` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `bid` int(10) unsigned NOT NULL,
			  `quono` varchar(20) NOT NULL,
			  `company` varchar(10) NOT NULL,
			  `cid` int(10) unsigned NOT NULL,
			  `address` text NOT NULL,
			  PRIMARY KEY (`did`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

    $objPDO = new SQL($sqlctbda);
    $result = $objPDO->getExecute();
    if ($result == 'Executed ok!') {
    $respone = "$result  executed createDeliveryAddress of $deltab<br>";
    }elseif ($result == 'Execution failed!') {
    $respone = "$result  Fail in execution for createDeliveryAddress of $deltab<br>";
    }

    return $respone;   
    
//  $rundb->Query($sqlctbda);
//  $result = "executed createDeliveryAddress of $deltab<br>";
//  return $result;   
}


//create table password overwrite of the current year and month if not exist
function createPasswordOverwrite($pastab){
  $sqlctbpa = "CREATE TABLE IF NOT EXISTS `$pastab` (
			  `poid` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `bid` int(10) NOT NULL,
			  `currency` int(10) NOT NULL,
			  `cid` int(10) unsigned NOT NULL,
			  `quono` varchar(20) NOT NULL,
			  `amount` decimal(20,2) NOT NULL,
			  `aid` int(10) NOT NULL,
			  `overwrite_aid` int(10) NOT NULL,
			  `datetime` datetime NOT NULL,
			  PRIMARY KEY (`poid`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

    $objPDO = new SQL($sqlctbpa);
    $result = $objPDO->getExecute();
    if ($result == 'Executed ok!') {
    $respone = "$result  executed createPasswordOverwrite of $pastab<br>";
    }elseif ($result == 'Execution failed!') {
    $respone = "$result  Fail in execution for createPasswordOverwrite of $pastab<br>";
    }

    return $respone; 
    
  
}


//create table production scheduling of the current year and month if not exist
function createProductionScheduling($protab){
  $sqlctbpro = "CREATE TABLE IF NOT EXISTS `$protab` (
			   `sid` int(10) unsigned NOT NULL AUTO_INCREMENT,
			   `omid` int(10) DEFAULT NULL,
			   `bid` int(10) unsigned NOT NULL,
			   `qid` int(10) unsigned NOT NULL,
			   `quono` varchar(20) NOT NULL,
			   `company` varchar(10) NOT NULL,
			   `cid` int(10) unsigned NOT NULL,
			   `aid_cus` int(10) unsigned NOT NULL,
			   `quantity` int(10) NOT NULL,
			   `grade` varchar(30) NOT NULL,
			   `mdt` varchar(15) DEFAULT NULL,
			   `mdw` varchar(15) DEFAULT NULL,
			   `mdl` varchar(15) DEFAULT NULL,
			   `fdt` varchar(15) DEFAULT NULL,
			   `fdw` varchar(15) DEFAULT NULL,
			   `fdl` varchar(15) DEFAULT NULL,
			   `process` varchar(20) DEFAULT NULL,
			   `source` varchar(10) DEFAULT NULL,
			   `cuttingtype` varchar(20) DEFAULT NULL,
			   `custoolcode` varchar(20) DEFAULT NULL,
			   `cncmach` decimal(20,2) DEFAULT NULL,
			   `noposition` int(10) unsigned NOT NULL,
			   `runningno` varchar(4) NOT NULL,
			   `jobno` varchar(3) NOT NULL,
			   `date_issue` date NOT NULL,
			   `completion_date` date NOT NULL,
			   `ivdate` date NOT NULL,
			   `cst` varchar(10) DEFAULT NULL,
			   `csw` varchar(10) DEFAULT NULL,
			   `csl` varchar(10) DEFAULT NULL,
			   `dateofcompletion` date DEFAULT NULL,
			   `additional` varchar(20) DEFAULT NULL,
			   `jlfor` varchar(5) NOT NULL,
			   `status` varchar(10) NOT NULL,
			   `pcst` varchar(10) DEFAULT NULL,
			   `pcsw` varchar(10) DEFAULT NULL,
			   `pcsl` varchar(10) DEFAULT NULL,
			   `pdateofcompletion` date DEFAULT NULL,
			   `datecncstart` date DEFAULT NULL,
			   `datecnccomplete` date DEFAULT NULL,
			   `checking` varchar(5) DEFAULT NULL,
			   `date_start` date DEFAULT NULL,
			   `bandsawcut_start` datetime DEFAULT NULL,
			   `bandsawcut_startby` int(10) unsigned DEFAULT NULL,
			   `bandsawcut_machine` int(10) unsigned DEFAULT NULL,
			   `bandsawcut_end` datetime DEFAULT NULL,
			   `bandsawcut_endby` int(10) unsigned DEFAULT NULL,
			   `milling_start` datetime DEFAULT NULL,
			   `milling_startby` int(10) unsigned DEFAULT NULL,
			   `milling_machine` int(10) unsigned DEFAULT NULL,
			   `milling_end` datetime DEFAULT NULL,
			   `milling_endby` int(10) unsigned DEFAULT NULL,
			   `roughgrinding_start` datetime DEFAULT NULL,
			   `roughgrinding_startby` int(10) unsigned DEFAULT NULL,
			   `roughgrinding_machine` int(10) unsigned DEFAULT NULL,
			   `roughgrinding_end` datetime DEFAULT NULL,
			   `roughgrinding_endby` int(10) unsigned DEFAULT NULL,
			   `precisiongrinding_start` datetime DEFAULT NULL,
			   `precisiongrinding_startby` int(10) unsigned DEFAULT NULL,
			   `precisiongrinding_machine` int(10) unsigned DEFAULT NULL,
			   `precisiongrinding_end` datetime DEFAULT NULL,
			   `precisiongrinding_endby` int(10) unsigned DEFAULT NULL,
			   `cncmachining_start` datetime DEFAULT NULL,
			   `cncmachining_startby` int(10) unsigned DEFAULT NULL,
			   `cncmachining_machine` int(10) unsigned DEFAULT NULL,
			   `cncmachining_end` datetime DEFAULT NULL,
			   `cncmachining_endby` int(10) unsigned DEFAULT NULL,
			   `packing` datetime DEFAULT NULL,
			   `delivery_out1` datetime DEFAULT NULL,
			   `delivery_in1` datetime DEFAULT NULL,
			   `delivery_out2` datetime DEFAULT NULL,
			   `delivery_in2` datetime DEFAULT NULL,
			   `delivery_out3` datetime DEFAULT NULL,
			   `delivery_in3` datetime DEFAULT NULL,
			   `ownremarks` varchar(5) DEFAULT NULL,
			   `prodremarks` varchar(100) DEFAULT NULL,
			   `stock_size` varchar(5) NULL DEFAULT NULL,
			   `stock_month` varchar(10) NULL DEFAULT NULL,
			   `operation` int(3) NOT NULL DEFAULT '1',
			   PRIMARY KEY (`sid`)
			 ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

    $objPDO = new SQL($sqlctbpro);
    $result = $objPDO->getExecute();
    if ($result == 'Executed ok!') {
    $respone = "$result  executed createProductionScheduling of $protab<br>";
    }elseif ($result == 'Execution failed!') {
    $respone = "$result  Fail in execution for createProductionScheduling of $protab <br>";
    }

    return $respone;   
  

}


//create table production output of the current year and month if not exist
function createProductionOutput($pottab){
  $sqlctbpot = "CREATE TABLE IF NOT EXISTS `$pottab` (
			   `poid` int(10) unsigned NOT NULL AUTO_INCREMENT,
			   `sid` int(10) unsigned NOT NULL,
			   `jobtype` varchar(20) NOT NULL,
			   `date_start` datetime NOT NULL,
			   `start_by` varchar(50) NOT NULL,
			   `machine_id` int(10) unsigned NOT NULL,
			   `date_end` datetime DEFAULT NULL,
			   `end_by` varchar(50) NOT NULL,
			   `quantity` int(10) unsigned DEFAULT NULL,
			   PRIMARY KEY (`poid`)
			 ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";


    $objPDO = new SQL($sqlctbpot);
    $result = $objPDO->getExecute();
    if ($result == 'Executed ok!') {
    $respone = "$result  executed createProductionOutput of $pottab<br>";
    }elseif ($result == 'Execution failed!') {
    $respone = "$result  Fail in execution for createProductionOutput of $pottab <br>";
    }

    return $respone;   
  
}


//create table production output report of the current year and month if not exist
function createProductionOutputReport($pottabrep){
  $sqlctbpot = "CREATE TABLE IF NOT EXISTS `$pottabrep` (
			   `poid` int(10) unsigned NOT NULL AUTO_INCREMENT,
			   `sid` int(10) unsigned NOT NULL,
			   `jobtype` varchar(20) NOT NULL,
			   `date_start` datetime NOT NULL,
			   `start_by` int(10) unsigned NOT NULL,
			   `machine_id` int(10) unsigned NOT NULL,
			   `date_end` datetime DEFAULT NULL,
			   `end_by` int(10) unsigned DEFAULT NULL,
			   `quantity` int(10) unsigned DEFAULT NULL,
			   PRIMARY KEY (`poid`)
			 ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

    $objPDO = new SQL($sqlctbpot);
    $result = $objPDO->getExecute();
    if ($result == 'Executed ok!') {
    $respone = "$result  executed createProductionOutputReport of $pottabrep<br>";
    }elseif ($result == 'Execution failed!') {
    $respone = "$result  Fail in execution for createProductionOutputReport of $pottabrep <br>";
    }

    return $respone;
    
 
}


//create table production target of the current year and month if not exist
/* this table cannot be automatically created here due to default info that need to be query and generated
under these 2 files, getSetDailyProductionTarget.php and getViewDailyProductionTarget.php */
/*
function createProductionTarget($rundb, $pottabrep, $protarinfo){
  $sqlctbpot = "CREATE TABLE IF NOT EXISTS `$protartab` (
			   `ptdid` int(10) unsigned NOT NULL AUTO_INCREMENT,
			   `days` int(10) unsigned NOT NULL,
			   $protarinfo
			   PRIMARY KEY (`ptdid`)
			 ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

  $rundb->Query($sqlctbpot);
}
*/


//create table orderlist report of the current year and month if not exist
function createOrderlistReport($ordreptab){
  $sqlctbrt = "CREATE TABLE IF NOT EXISTS `$ordreptab` (
			  `orid` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `bid` int(10) unsigned NOT NULL,
			  `qid` int(10) unsigned DEFAULT NULL,
			  `quono` varchar(20) NOT NULL,
			  `cid` int(10) unsigned NOT NULL,
			  `item` varchar(5) DEFAULT NULL,
			  `remarks` varchar(255) NOT NULL,
			  `aid` int(10) NOT NULL,
			  `datetime` datetime NOT NULL,
			  PRIMARY KEY (`orid`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

    $objPDO = new SQL($sqlctbrt);
    $result = $objPDO->getExecute();
    if ($result == 'Executed ok!') {
    $respone = "$result  executed createOrderlistReport of $ordreptab<br>";
    }elseif ($result == 'Execution failed!') {
    $respone = "$result  Fail in execution for createOrderlistReport of $ordreptab <br>";
    }

    return $respone;

      
}


//create table orderlist delete of the current year and month if not exist
function createOrderlistDeletePSVPMB($orddeltab){
  $sqlctbor = "CREATE TABLE IF NOT EXISTS `$orddeltab` (
			  `odid` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `oid` int(10) unsigned NOT NULL,
			  `bid` int(10) unsigned NOT NULL,
			  `currency` int(10) NOT NULL,
			  `qid` int(10) unsigned NOT NULL,
			  `quono` varchar(20) NOT NULL,
			  `company` varchar(10) NOT NULL,
			  `cusstatus` varchar(10) NOT NULL,
			  `cid` int(10) unsigned NOT NULL,
			  `accno` varchar(8) DEFAULT NULL,
			  `date` date NOT NULL,
			  `terms` varchar(30) NOT NULL,
			  `noposition` int(10) unsigned NOT NULL,
			  `item` varchar(5) NOT NULL,
			  `quantity` int(10) NOT NULL,
			  `grade` text NOT NULL,
			  `cncmach` decimal(20,2) DEFAULT NULL,
			  `unitprice` decimal(20,2) NOT NULL,
			  `amount` decimal(20,2) NOT NULL,
			  `discount` decimal(20,2) DEFAULT NULL,
			  `vat` decimal(20,2) DEFAULT NULL,
			  `gst` decimal(20,2) DEFAULT NULL,
			  `ftz` varchar(5) DEFAULT NULL,
			  `amountmat` decimal(10,2) DEFAULT NULL,
			  `discountmat` decimal(10,2) DEFAULT NULL,
			  `gstmat` decimal(10,2) DEFAULT NULL,
			  `totalamountmat` decimal(10,2) DEFAULT NULL,
			  `amountpmach` decimal(10,2) DEFAULT NULL,
			  `discountpmach` decimal(10,2) DEFAULT NULL,
			  `gstpmach` decimal(10,2) DEFAULT NULL,
			  `totalamountpmach` decimal(10,2) DEFAULT NULL,
			  `amountcncmach` decimal(10,2) DEFAULT NULL,
			  `discountcncmach` decimal(10,2) DEFAULT NULL,
			  `gstcncmach` decimal(10,2) DEFAULT NULL,
			  `totalamountcncmach` decimal(10,2) DEFAULT NULL,
			  `amountother` decimal(10,2) DEFAULT NULL,
			  `discountother` decimal(10,2) DEFAULT NULL,
			  `gstother` decimal(10,2) DEFAULT NULL,
			  `totalamountother` decimal(10,2) DEFAULT NULL,
			  `totalamount` decimal(20,2) NOT NULL,
			  `aid_quo` int(10) unsigned NOT NULL,
			  `aid_cus` int(10) unsigned NOT NULL,
			  `datetimeissue_quo` datetime NOT NULL,
			  `olremarks` varchar(100) DEFAULT NULL,
			  `date_issue` date NOT NULL,
			  `completion_date` varchar(15) NOT NULL,
			  `source` varchar(10) NOT NULL,
			  `cuttingtype` varchar(20) NOT NULL,
			  `tol_thkp` varchar(4) NOT NULL,
			  `tol_thkm` varchar(4) NOT NULL,
			  `tol_wdtp` varchar(4) NOT NULL,
			  `tol_wdtm` varchar(4) NOT NULL,
			  `tol_lghp` varchar(4) NOT NULL,
			  `tol_lghm` varchar(4) NOT NULL,
			  `chamfer` varchar(5) NOT NULL,
			  `flatness` varchar(5) NOT NULL,
			  `ihremarks` int(10) DEFAULT NULL,
			  `ivremarks` varchar(30) DEFAULT NULL,
			  `ivpono` varchar(20) DEFAULT NULL,
			  `custoolcode` varchar(20) DEFAULT NULL,
			  `runningno` varchar(4) NOT NULL,
			  `jobno` varchar(3) NOT NULL,
			  `ivdate` date NOT NULL,
			  `aid_ol` varchar(4) NOT NULL,
			  `datetimeissue_ol` datetime NOT NULL,
			  `jlissue` varchar(10) NOT NULL DEFAULT 'no',
			  `docount` int(10) DEFAULT NULL,
			  `dodate` date DEFAULT NULL,
			  `doissue` varchar(10) NOT NULL DEFAULT 'no',
			  `doreprint` varchar(10) NOT NULL DEFAULT 'no',
			  `doreprintcount` varchar(10) NOT NULL DEFAULT '0',
			  `driver` varchar(10) DEFAULT NULL,
			  `policyno` varchar(20) DEFAULT NULL,
			  `aid_do` int(10) unsigned DEFAULT NULL,
			  `stampsignature` varchar(5) NOT NULL DEFAULT 'no',
			  `aid_stampsignature` int(10) DEFAULT NULL,
			  `datetime_stampsignature` datetime DEFAULT NULL,
			  `ivissue` varchar(10) NOT NULL DEFAULT 'no',
			  `ivreprint` varchar(10) NOT NULL DEFAULT 'no',
			  `ivreprintcount` int(10) NOT NULL DEFAULT '0',
			  `invcotype` varchar(4) DEFAULT NULL,
 			  `invno` varchar(10) DEFAULT NULL,
			  `requestby` int(10) unsigned NOT NULL,
			  `deleteby` int(10) unsigned NOT NULL,
			  `datetimedelete_ol` date NOT NULL,
			  `remarks` varchar(255) NOT NULL,
			  PRIMARY KEY (`odid`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

    $objPDO = new SQL($sqlctbor);
    $result = $objPDO->getExecute();
    if ($result == 'Executed ok!') {
    $respone = "$result  executed createOrderlistDeletePSVPMB of $orddeltab<br>";
    }elseif ($result == 'Execution failed!') {
    $respone = "$result  Fail in execution for createOrderlistDeletePSVPMB of $orddeltab <br>";
    }

    return $respone;
    
}


//create table orderlist delete of the current year and month if not exist
function createOrderlistDelete($orddeltab){
  $sqlctbor = "CREATE TABLE IF NOT EXISTS `$orddeltab` (
			  `odid` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `oid` int(10) unsigned NOT NULL,
			  `bid` int(10) unsigned NOT NULL,
			  `currency` int(10) NOT NULL,
			  `qid` int(10) unsigned NOT NULL,
			  `quono` varchar(20) NOT NULL,
			  `company` varchar(10) NOT NULL,
			  `cusstatus` varchar(10) NOT NULL,
			  `cid` int(10) unsigned NOT NULL,
			  `accno` varchar(8) DEFAULT NULL,
			  `date` date NOT NULL,
			  `terms` varchar(30) NOT NULL,
			  `noposition` int(10) unsigned NOT NULL,
			  `item` varchar(5) NOT NULL,
			  `quantity` int(10) NOT NULL,
			  `grade` varchar(30) NOT NULL,
			  `mdt` varchar(15) DEFAULT NULL,
			  `mdw` varchar(15) DEFAULT NULL,
			  `mdl` varchar(15) DEFAULT NULL,
			  `fdt` varchar(15) DEFAULT NULL,
			  `fdw` varchar(15) DEFAULT NULL,
			  `fdl` varchar(15) DEFAULT NULL,
			  `process` varchar(20) DEFAULT NULL,
			  `mat` decimal(20,2) NOT NULL,
			  `pmach` decimal(20,2) DEFAULT NULL,
			  `cncmach` decimal(20,2) DEFAULT NULL,
			  `other` decimal(20,2) DEFAULT NULL,
			  `unitprice` decimal(20,2) NOT NULL,
			  `amount` decimal(20,2) NOT NULL,
			  `discount` decimal(20,2) DEFAULT NULL,
			  `vat` decimal(20,2) DEFAULT NULL,
			  `gst` decimal(20,2) DEFAULT NULL,
			  `ftz` varchar(5) DEFAULT NULL,
			  `amountmat` decimal(10,2) DEFAULT NULL,
			  `discountmat` decimal(10,2) DEFAULT NULL,
			  `gstmat` decimal(10,2) DEFAULT NULL,
			  `totalamountmat` decimal(10,2) DEFAULT NULL,
			  `amountpmach` decimal(10,2) DEFAULT NULL,
			  `discountpmach` decimal(10,2) DEFAULT NULL,
			  `gstpmach` decimal(10,2) DEFAULT NULL,
			  `totalamountpmach` decimal(10,2) DEFAULT NULL,
			  `amountcncmach` decimal(10,2) DEFAULT NULL,
			  `discountcncmach` decimal(10,2) DEFAULT NULL,
			  `gstcncmach` decimal(10,2) DEFAULT NULL,
			  `totalamountcncmach` decimal(10,2) DEFAULT NULL,
			  `amountother` decimal(10,2) DEFAULT NULL,
			  `discountother` decimal(10,2) DEFAULT NULL,
			  `gstother` decimal(10,2) DEFAULT NULL,
			  `totalamountother` decimal(10,2) DEFAULT NULL,
			  `totalamount` decimal(20,2) NOT NULL,
			  `aid_quo` int(10) unsigned NOT NULL,
			  `aid_cus` int(10) unsigned NOT NULL,
			  `datetimeissue_quo` datetime NOT NULL,
			  `olremarks` varchar(100) DEFAULT NULL,
			  `date_issue` date NOT NULL,
			  `completion_date` varchar(15) NOT NULL,
			  `source` varchar(10) NOT NULL,
			  `cuttingtype` varchar(20) NOT NULL,
			  `tol_thkp` varchar(4) NOT NULL,
			  `tol_thkm` varchar(4) NOT NULL,
			  `tol_wdtp` varchar(4) NOT NULL,
			  `tol_wdtm` varchar(4) NOT NULL,
			  `tol_lghp` varchar(4) NOT NULL,
			  `tol_lghm` varchar(4) NOT NULL,
			  `chamfer` varchar(5) NOT NULL,
			  `flatness` varchar(5) NOT NULL,
			  `ihremarks` int(10) DEFAULT NULL,
			  `ivremarks` varchar(30) DEFAULT NULL,
			  `ivpono` varchar(20) DEFAULT NULL,
			  `custoolcode` varchar(20) DEFAULT NULL,
			  `runningno` varchar(4) NOT NULL,
			  `jobno` varchar(3) NOT NULL,
			  `ivdate` date NOT NULL,
			  `aid_ol` varchar(4) NOT NULL,
			  `datetimeissue_ol` datetime NOT NULL,
			  `jlissue` varchar(10) NOT NULL DEFAULT 'no',
			  `docount` int(10) DEFAULT NULL,
			  `dodate` date DEFAULT NULL,
			  `doissue` varchar(10) NOT NULL DEFAULT 'no',
			  `doreprint` varchar(10) NOT NULL DEFAULT 'no',
			  `doreprintcount` varchar(10) NOT NULL DEFAULT '0',
			  `driver` varchar(10) DEFAULT NULL,
			  `policyno` varchar(20) DEFAULT NULL,
			  `aid_do` int(10) unsigned DEFAULT NULL,
			  `stampsignature` varchar(5) NOT NULL DEFAULT 'no',
			  `aid_stampsignature` int(10) DEFAULT NULL,
			  `datetime_stampsignature` datetime DEFAULT NULL,
			  `ivissue` varchar(10) NOT NULL DEFAULT 'no',
			  `ivreprint` varchar(10) NOT NULL DEFAULT 'no',
			  `ivreprintcount` int(10) NOT NULL DEFAULT '0',
			  `invcotype` varchar(4) DEFAULT NULL,
 			  `invno` varchar(10) DEFAULT NULL,
			  `requestby` int(10) unsigned NOT NULL,
			  `deleteby` int(10) unsigned NOT NULL,
			  `datetimedelete_ol` date NOT NULL,
			  `remarks` varchar(255) NOT NULL,
			  PRIMARY KEY (`odid`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

    $objPDO = new SQL($sqlctbor);
    $result = $objPDO->getExecute();
    if ($result == 'Executed ok!') {
    $respone = "$result  executed createOrderlistDelete of $orddeltab<br>";
    }elseif ($result == 'Execution failed!') {
    $respone = "$result  Fail in execution for createOrderlistDelete of $orddeltab <br>";
    }

    return $respone;
   
}


//create table orderlist manual of the current year and month if not exist
function createOrderlistManual($ordmantab){
  $sqlctbmo = "CREATE TABLE IF NOT EXISTS `$ordmantab` (
			  `omid` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `bid` int(10) unsigned NOT NULL,
			  `currency` int(10) NOT NULL,
			  `quono` varchar(20) NOT NULL,
			  `runningno` varchar(4) NOT NULL,
			  `jobno` varchar(3) NOT NULL,
			  `company` varchar(10) NOT NULL,
			  `cid` int(10) unsigned NOT NULL,
			  `accno` varchar(8) NOT NULL,
			  `date` date NOT NULL,
			  `terms` varchar(30) NOT NULL,
			  `aid_cus` int(10) unsigned NOT NULL,
			  `item` varchar(5) NOT NULL,
			  `quantity` int(10) unsigned NOT NULL,
			  `grade` varchar(30) NOT NULL DEFAULT '',
			  `mdt` varchar(15) DEFAULT NULL,
			  `mdw` varchar(15) DEFAULT NULL,
			  `mdl` varchar(15) DEFAULT NULL,
			  `fdt` varchar(15) DEFAULT NULL,
			  `fdw` varchar(15) DEFAULT NULL,
			  `fdl` varchar(15) DEFAULT NULL,
			  `process` varchar(20) DEFAULT NULL,
			  `olremarks` varchar(100) NOT NULL,
			  `dateissue` date NOT NULL,
			  `completion_date` varchar(15) NOT NULL,
			  `source` varchar(10) NOT NULL,
			  `cuttingtype` varchar(20) NOT NULL,
			  `tol_thkp` varchar(4) NOT NULL,
			  `tol_thkm` varchar(4) NOT NULL,
			  `tol_wdtp` varchar(4) NOT NULL,
			  `tol_wdtm` varchar(4) NOT NULL,
			  `tol_lghp` varchar(4) NOT NULL,
			  `tol_lghm` varchar(4) NOT NULL,
			  `chamfer` varchar(5) NOT NULL,
			  `flatness` varchar(5) NOT NULL,
			  `custoolcode` varchar(20) DEFAULT NULL,
			  `cncmach` decimal(20,2) DEFAULT NULL,
			  `additional` varchar(20) DEFAULT NULL,
			  `jlfor` varchar(5) NOT NULL,
			  `aid_ol` int(10) unsigned NOT NULL,
			  `datetimeissue_ol` datetime NOT NULL,
			  `jlissue` varchar(10) NOT NULL,
			  `jlreprint` varchar(10) NOT NULL DEFAULT 'no',
			  `jlreprintcount` int(10) unsigned NOT NULL DEFAULT '0',
			  PRIMARY KEY (`omid`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

    $objPDO = new SQL($sqlctbmo);
    $result = $objPDO->getExecute();
    if ($result == 'Executed ok!') {
    $respone = "$result  executed createOrderlistManual of $ordmantab<br>";
    }elseif ($result == 'Execution failed!') {
    $respone = "$result  Fail in execution for createOrderlistManual of $ordmantab <br>";
    }

    return $respone;
   
}


//create table orderlist manual delete of the current year and month if not exist
function createOrderlistManualDelete($ordmandeltab){
  $sqlctbor = "CREATE TABLE IF NOT EXISTS `$ordmandeltab` (
	  		  `omdid` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `omid` int(10) unsigned NOT NULL,
			  `bid` int(10) unsigned NOT NULL,
			  `currency` int(10) NOT NULL,
			  `quono` varchar(20) NOT NULL,
			  `runningno` varchar(4) NOT NULL,
			  `jobno` varchar(3) NOT NULL,
			  `company` varchar(10) NOT NULL,
			  `cid` int(10) unsigned NOT NULL,
			  `accno` varchar(8) NOT NULL,
			  `date` date NOT NULL,
			  `terms` varchar(30) NOT NULL,
			  `aid_cus` int(10) unsigned NOT NULL,
			  `item` varchar(5) NOT NULL,
			  `quantity` int(10) unsigned NOT NULL,
			  `grade` varchar(30) NOT NULL DEFAULT '',
			  `mdt` varchar(10) NOT NULL,
			  `mdw` varchar(10) DEFAULT NULL,
			  `mdl` varchar(10) NOT NULL,
			  `fdt` varchar(10) DEFAULT NULL,
			  `fdw` varchar(10) DEFAULT NULL,
			  `fdl` varchar(10) DEFAULT NULL,
			  `process` varchar(20) DEFAULT NULL,
			  `olremarks` varchar(100) NOT NULL,
			  `dateissue` date NOT NULL,
			  `completion_date` varchar(15) NOT NULL,
			  `source` varchar(10) NOT NULL,
			  `cuttingtype` varchar(20) NOT NULL,
			  `tol_thkp` varchar(4) NOT NULL,
			  `tol_thkm` varchar(4) NOT NULL,
			  `tol_wdtp` varchar(4) NOT NULL,
			  `tol_wdtm` varchar(4) NOT NULL,
			  `tol_lghp` varchar(4) NOT NULL,
			  `tol_lghm` varchar(4) NOT NULL,
			  `cncmach` decimal(10,2) DEFAULT NULL,
			  `custoolcode` varchar(20) DEFAULT NULL,
			  `additional` varchar(20) DEFAULT NULL,
			  `jlfor` varchar(5) NOT NULL,
			  `aid_ol` int(10) unsigned NOT NULL,
			  `datetimeissue_ol` varchar(10) NOT NULL,
			  `jlissue` varchar(10) NOT NULL,
			  `remarks` varchar(255) NOT NULL,
			  PRIMARY KEY (`omdid`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

    $objPDO = new SQL($sqlctbor);
    $result = $objPDO->getExecute();
    if ($result == 'Executed ok!') {
    $respone = "$result  executed createOrderlistManualDelete of $ordmandeltab<br>";
    }elseif ($result == 'Execution failed!') {
    $respone = "$result  Fail in execution for createOrderlistManualDelete of $ordmandeltab <br>";
    }

    return $respone;

 
}


//create table do report of the current year and month if not exist
function createDOReport($doreptab){
  $sqlctbrt = "CREATE TABLE IF NOT EXISTS `$doreptab` (
			  `doid` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `bid` int(10) unsigned NOT NULL,
			  `qid` int(10) unsigned DEFAULT NULL,
			  `quono` varchar(20) NOT NULL,
			  `cid` int(10) unsigned NOT NULL,
			  `item` varchar(5) DEFAULT NULL,
			  `remarks` varchar(255) NOT NULL,
			  `aid` int(10) NOT NULL,
			  `datetime` datetime NOT NULL,
			  PRIMARY KEY (`doid`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
    echo "$sqlctbrt = $sqlctbrt <br>";

    $objPDO = new SQL($sqlctbrt);
    $result = $objPDO->getExecute();
    if ($result == 'Executed ok!') {
    $respone = "$result  executed createDOReport of $doreptab<br>";
    }elseif ($result == 'Execution failed!') {
    $respone = "$result  Fail in execution for createDOReport of $doreptab <br>";
    }
    return $respone;    
   
}


//create table dono of the current year and month if not exist
function createDO($dotab){
  $sqlctbdo = "CREATE TABLE IF NOT EXISTS `$dotab` (
			  `doid` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `bid` int(10) unsigned NOT NULL,
			  `date_issue` date NOT NULL,
			  `docotype` varchar(4) NOT NULL,
			  `dorunno` varchar(10) NOT NULL,
			  `docount` int(10) NOT NULL,
			  `qid` int(10) NOT NULL,
			  `quono` varchar(20) NOT NULL,
			  `cid` int(10) unsigned NOT NULL,
			  `ivpono` varchar(20) DEFAULT NULL,
			  PRIMARY KEY (`doid`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

    $objPDO = new SQL($sqlctbdo);
    $result = $objPDO->getExecute();
    if ($result == 'Executed ok!') {
    $respone = "$result  executed createDO of $dotab<br>";
    }elseif ($result == 'Execution failed!') {
    $respone = "$result  Fail in execution for createDO of $dotab <br>";
    }  
    return $respone;  
     
}


//create table do log of the current year and month if not exist
function createDoLog($dologtab){
  $sqlctbin = "CREATE TABLE IF NOT EXISTS `$dologtab` (
			  `doid` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `docotype` varchar(4) NOT NULL,
			  `dorunno` varchar(10) NOT NULL,
			  `docount` int(10) NOT NULL,
			  `datetime_print` datetime NOT NULL,
			  `printby` int(10) unsigned NOT NULL,
			  `doreprintcount` int(10) unsigned NOT NULL DEFAULT '0',
			  PRIMARY KEY (`doid`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

    $objPDO = new SQL($sqlctbin);
    $result = $objPDO->getExecute();
    if ($result == 'Executed ok!') {
    $respone = "$result  executed createDoLog of $dologtab<br>";
    }elseif ($result == 'Execution failed!') {
    $respone = "$result  Fail in execution for createDoLog of $dologtab<br>";
    }   
    return $respone;  
}


//create table dono search of the current year and month if not exist
function createDOSearch($dosearchtab){
  $sqlctbdo = "CREATE TABLE IF NOT EXISTS `$dosearchtab` (
			  `dosid` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `bid` int(10) unsigned NOT NULL,
			  `date_issue` date NOT NULL,
			  `docotype` varchar(4) NOT NULL,
			  `dorunno` varchar(10) NOT NULL,
			  `docount` int(10) NOT NULL,
			  `qid` int(10) NOT NULL,
			  `quono` varchar(20) NOT NULL,
			  `cid` int(10) unsigned NOT NULL,
			  `ivpono` varchar(20) DEFAULT NULL,
			  `invoicedate` date DEFAULT NULL,
			  PRIMARY KEY (`dosid`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

    $objPDO = new SQL($sqlctbdo);
    $result = $objPDO->getExecute();
    if ($result == 'Executed ok!') {
    $respone = "$result  executed createDOSearch of $dosearchtab<br>";
    }elseif ($result == 'Execution failed!') {
    $respone = "$result  Fail in execution for createDOSearch of $dosearchtab<br>";
    }  
    return $respone;    
    
}


//create table do reissue of the current year and month if not exist
function createDoReissue($doridtab){
  $sqlctbin = "CREATE TABLE IF NOT EXISTS `$doridtab` (
			  `irid` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `bid` int(10) unsigned NOT NULL,
			  `quono` varchar(20) NOT NULL,
			  `company` varchar(10) NOT NULL,
			  `cid` int(10) unsigned NOT NULL,
			  `docotype` varchar(4) NOT NULL,
			  `dorunno` varchar(10) NOT NULL,
			  `docount` int(10) NOT NULL,
			  `date_reissue` datetime NOT NULL,
			  `request_by` int(10) unsigned NOT NULL,
			  `reason` varchar(255) NOT NULL,
			  `reissue_by` int(10) unsigned NOT NULL,
			  PRIMARY KEY (`irid`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

    $objPDO = new SQL($sqlctbin);
    $result = $objPDO->getExecute();
    if ($result == 'Executed ok!') {
    $respone = "$result  executed createDoReissue of $doridtab<br>";
    }elseif ($result == 'Execution failed!') {
    $respone = "$result  Fail in execution for createDoReissue of $doridtab<br>";
    }   
    return $respone;  
   
}


//create table stock of the current year and month if not exist
function createStockStore($stockstoretab){
  $sqlctbst = "CREATE TABLE IF NOT EXISTS `$stockstoretab` (
			  `ssid` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `bid` int(10) unsigned NOT NULL,
			  `materialcode` varchar(30) NOT NULL,
			  `thickness` decimal(10,2) NOT NULL,
			  `width` decimal(10,2) DEFAULT NULL,
			  `length` decimal(10,2) NOT NULL,
			  `plate_no` int(10) unsigned NOT NULL,
			  `millcertno` varchar(20) DEFAULT NULL,
			  `heatno` varchar(20) DEFAULT NULL,
			  `newthickness` decimal(10,2) DEFAULT NULL,
			  `newplate_no` int(10) unsigned DEFAULT NULL,
			  `stockin_date` date NOT NULL,
			  `stockout_date` date DEFAULT NULL,
			  `stickerprint` varchar(5) NOT NULL DEFAULT 'no',
			  `lot` varchar(10) NOT NULL,
			  `datetime_added` datetime NOT NULL,
			  `stockin_origin` date DEFAULT NULL,
			  `store_origin` varchar(5) DEFAULT NULL,
			  `lastplate_runno` int(10) unsigned DEFAULT NULL,
			  `previous_ssid` int(10) unsigned DEFAULT NULL,
			  `previous_month` varchar(10) DEFAULT NULL,
			  `previous_origin` varchar(5) DEFAULT NULL,
			  `status` varchar(10) NOT NULL,
			  `sfid_stockin` int(10) unsigned NOT NULL,
			  `sfid_stockout` int(10) unsigned DEFAULT NULL,
			  `pro_sch_month` varchar(10) DEFAULT NULL,
			  `pro_sid` int(10) unsigned DEFAULT NULL,
			  PRIMARY KEY (`ssid`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

    $objPDO = new SQL($sqlctbst);
    $result = $objPDO->getExecute();
    if ($result == 'Executed ok!') {
    $respone = "$result  executed createStockStore of $stockstoretab<br>";
    }elseif ($result == 'Execution failed!') {
    $respone = "$result  Fail in execution for createStockStore of $stockstoretab<br>";
    } 
    return $respone;

}

function createInvRunno($invruntab){
 $sqlctbqu = "CREATE TABLE IF NOT EXISTS `$invruntab` (
		  `inid` int(10) unsigned NOT NULL AUTO_INCREMENT,
		  `bid` int(10) unsigned NOT NULL,
		  `period` varchar(20) DEFAULT NULL,
		  `invcotype` varchar(4) NOT NULL,
		  `invrunno` varchar(10) NOT NULL,
		  `qid` int(10) NOT NULL DEFAULT '0',
		  `quono` varchar(20) NOT NULL,
		  `cid` int(10) unsigned NOT NULL DEFAULT '0',
		  `ivpono` varchar(20) DEFAULT NULL,
		  `policyno` varchar(20) NOT NULL DEFAULT 'PST',
		  `occupied` varchar(10) NOT NULL DEFAULT 'no',
		  `timerecord` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
		  PRIMARY KEY (`inid`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

    $objPDO = new SQL($sqlctbqu);
    $result = $objPDO->getExecute();
    if ($result == 'Executed ok!') {
    $respone = "$result  executed createInvRunno of $invruntab<br>";
    }elseif ($result == 'Execution failed!') {
    $respone = "$result  Fail in execution for createInvRunno of $invruntab<br>";
    } 
    return $respone;                  
		    
 
}
?>
