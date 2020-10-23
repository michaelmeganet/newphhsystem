<?php
session_start();

$session_gap = 3600;

if(!isset($_SESSION['phhsystemAdmin'])){
  echo "<font style=\"font-size:30px;\">Please login first. You can click <a href=\"index.php\" target=\"_parent\">here</a> to login.</font>";
  exit();
}

if(time() - $_SESSION['phhsystemTimeout'] > $session_gap){ 
  unset($_SESSION['phhsystemAdmin']);
  session_unregister('phhsystemAdmin');
  unset($_SESSION['phhsystemTimeout']);
  session_unregister('phhsystemTimeout');

  echo "<font style=\"font-size:30px;\">Your session has expired. Click <a href=\"index.php\" target=\"_parent\">here</a> to login again.</font>";
  exit();
} 
else{ 
  $_SESSION['phhsystemTimeout'] = time(); 
}
?>