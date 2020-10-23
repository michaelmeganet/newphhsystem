<?php
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Pragma: no-cache'); 
 
//include_once("include/mysql_connect.php");
include_once("includes/dbh.inc.php");
include_once("includes/variables.inc.php");
//require_once("include/session.php");

session_start();

if(!isset($pageTitle) || $pageTitle == ''){
  $pageTitle = "PHH System - PHH Group of Companies";
}
else{
  $pageTitle .= ' - '."PHH System - PHH Group of Companies";
}
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $pageTitle; ?></title>

<link type="text/css" rel="stylesheet" href="include/mainstyle.css">
<script src='https://cdn.jsdelivr.net/npm/vue/dist/vue.js'></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<script src="include/AC_RunActiveContent.js" type="text/javascript"></script>

<script language="javascript" type="text/javascript" src="include/validator.js"></script>

</head>

<body>

<center>

<table width="520" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td valign="top">

<table width="100%" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td><img src="display/phhlogo.png" width="400" height="39"></td>
  </tr>
</table>

<br />
