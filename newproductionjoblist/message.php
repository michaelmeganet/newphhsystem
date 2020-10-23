<?php
include_once("include/osdetection.php");
//include_once("include/formatting.php");

$os_type =  browser_detection('os');
$os_version = browser_detection('os_number');
$browser_type = browser_detection('browser_working');
$browser_version = browser_detection('browser_number');

if($os_type == "nt"){
  if($os_version == "6.1"){
	$os_name = "<font color=\"#00FF00\">Microsoft Windows 7</font>";
  }
  else if($os_version == "nt 6.0"){
	$os_name = "<font color=\"#00FF00\">Microsoft Windows Vista</font>";
  }
  else if($os_version == "5.1"){
	$os_name = "<font color=\"#00FF00\">Microsoft Windows XP</font>";
  }
  else{
	$os_name = "<font color=\"#FF0000\">an unknown Operating System</font>";
  }
}
else{
  $os_name = "<font color=\"#FF0000\">an unknown Operating System</font>";
}

if($browser_type == "ie"){
  if($browser_version >= "8"){
	$browser_name = "<font color=\"#00FF00\">Internet Explorer $browser_version</font>";
  }
  else if($browser_version < "8"){
	$browser_name = "<font color=\"#FF0000\">Internet Explorer $browser_version</font>";
  }
  else{
	$browser_name = "<font color=\"#FF0000\">an unknown Browser</font>";
  }
}
else if($browser_type == "moz"){
  $browser_name = "<font color=\"#FF0000\">Mozilla Firefox</font>";
}
else{
  $browser_name = "<font color=\"#FF0000\">an unknown Browser</font>";
}
?>

<table width="800" cellspacing="0" cellpadding="0" border="0" align="center">
  <tr>
	<td valign="top" align="center">Select menu from your left to continue.</td>
  </tr>
  <tr>
	<td><br /><br /></td>
  </tr>
  <tr>
	<td valign="top" align="center" style="font-size:16px;">You are running on <strong><?php echo $os_name; ?></strong> with using <strong><?php echo $browser_name; ?></strong>.</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
  </tr>
  <tr>
	<td valign="top" align="center">The most recommended settings for <strong><font color="#00FFFF">PHHSystem</font></strong> is <strong><font color="#00FFFF">Microsoft Windows XP and above</font></strong> with using <strong><font color="#00FFFF">Internet Explorer 8.0 and above</font></strong>.</td>
  </tr>
  <tr>
	<td valign="top" align="center">If your current system is lower than recommended, <font color="#FF0000">please contact your administrator regarding this thing</font>.</td>
  </tr>
</table>