<?php
require_once("mysql_connect.php");

set_time_limit(120);

session_start();

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action){		
	case 'doLogout':
		doLogout();
		break;
		
	default:
		//header('Location: index.php');
		//break;
}


//admin logout
function doLogout(){
 if(isset($_SESSION['phhsystemAdmin'])){
    unset($_SESSION['phhsystemAdmin']);
	session_unregister('phhsystemAdmin');
  }
		
  header('Location: ../index.php');
}
?>

