<?php
class MySQL{

  function Connect($host, $username, $password, $database){
    $this->dbc = mysql_connect($host, $username, $password) or die(mysql_error());
	$db = mysql_select_db($database, $this->dbc) or die(mysql_error());
  }

  function Query($query){
    return mysql_query($query);
  }

  function FetchArray($farray){
    return mysql_fetch_array($farray);
  }

  function FetchAssoc($fassoc){
    return mysql_fetch_assoc($fassoc);
  }

  function NumRows($num){
    return mysql_num_rows($num);
  }

  function InsertId(){
    return mysql_insert_id();
  }

  function Close(){
    mysql_close($this->dbc);
  }
}

$rundb = new MySQL();

// $host = "192.168.100.21";
$host = "localhost";
$username = "phhsystem";
$password = "cnAfahrenheit5t";
$database = "phhsystem";

$rundb->Connect($host, $username, $password, $database);

putenv("TZ=Asia/Kuala_Lumpur");
date_default_timezone_set('Asia/Kuala_Lumpur'); //can be search from php manual

ini_set("memory_limit", "1536M"); //1.5GB Ram
set_time_limit(3600); //30 Minutes
//ini_set("max_execution_time", "600");
?>
