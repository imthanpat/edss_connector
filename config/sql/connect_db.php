<?php
session_start();
include('config.inc.php');
date_default_timezone_set("Asia/Bangkok");

/* Prepare Conn */
$conn  = " host=".$_SESSION['server']['host']." port=".$_SESSION['server']['port'];
$conn .= " dbname=".$_SESSION['server']['dbname']." user=".$_SESSION['server']['username'];
$conn .= " password=".$_SESSION['server']['passwd'];

//Connect Database
$str = "host=".$_SESSION['server']['host']." port=".$_SESSION['server']['port'];
$str .= " dbname=".$_SESSION['server']['dbname']." user=".$_SESSION['server']['username'];
$str .= " password=".$_SESSION['server']['passwd'];

$connect = pg_connect($str) or die("Couldn't Connect data will be Optimise Database....... Please Try again later !!! ". pg_last_error($connect));

//echo 'Connected';

function sql_dateformat($date){
	if($date=="now()" && $_SESSION['server']['db'] == "oracle")$date= "sysdate";
	if($date=="now()" && $_SESSION['server']['db'] == "mssql")$date= "getdate()";
	if($_SESSION['server']['db'] == 'postgresql' || $_SESSION['server']['db'] == 'oracle')
		$date = "to_char(".$date.",'YYYYMMDDHH24MISS')";
	else if($_SESSION['server']['db'] == 'mssql')
		$date = "convert(varchar(19),".$date.",21)";
	return $date;
}
function sql_dateformat2($date){
	if($date=="now()" && $_SESSION['server']['db'] == "oracle")$date= "sysdate";
	if($date=="now()" && $_SESSION['server']['db'] == "mssql")$date= "getdate()";
	if($_SESSION['server']['db'] == 'postgresql' || $_SESSION['server']['db'] == 'oracle')
		$date = "to_char(".$date.",'YYYYMMDD')";
	else if($_SESSION['server']['db'] == 'mssql')
		$date = "convert(varchar(10),".$date.",21)";
	return $date;
}

function sql_exec($connect,$sql){
	if($_SESSION['server']['connect'] == 'odbc')$exec = odbc_exec($connect,$sql);
	else if($_SESSION['server']['connect'] == 'radius' && $_SESSION['server']['db']=='postgresql')
$exec = pg_query($connect , $sql);
	return $exec;
}
function sql_result($exec, $col){ 
	if($_SESSION['server']['connect'] == 'odbc')$result = odbc_result($exec,$col);
	else if($_SESSION['server']['connect'] == 'radius' && $_SESSION['server']['db']=="postgresql")
$result = pg_fetch_result($exec,$col);
	return $result;
}
function sql_fetch_result($fetch, $exec, $col){
	if($_SESSION['server']['connect'] == 'odbc')$result = odbc_result($exec,$col);
	else if($_SESSION['server']['connect'] == 'radius' && $_SESSION['server']['db']=="postgresql")
$result = $fetch[$col];
	return $result;
}
function sql_fetch_array($fetch,$exec){ 
	
	if($_SESSION['server']['connect'] == 'odbc'){$fetch = odbc_fetch_into($exec, $fetch); }
	else if($_SESSION['server']['connect'] == 'radius' && $_SESSION['server']['db']=="postgresql")
$fetch = "pg_fetch_array($exec)";
	return $fetch;
}
function sql_while($exec,$fetch){
	if($_SESSION['server']['connect'] == 'odbc')$result = "odbc_fetch_into($exec, $fetch)";
	else if($_SESSION['server']['connect'] == 'radius' && $_SESSION['server']['db']=="postgresql")
$result = "$fetch = pg_fetch_array($exec)";
	return $result;	
}
function sql_free_result($exec){
	if($_SESSION['server']['connect'] == 'odbc')$result = odbc_free_result($exec);
	else if($_SESSION['server']['connect'] == 'radius' && $_SESSION['server']['db']=="postgresql")
$result = pg_free_result($exec);
	return $result;
}
function sql_close($connect){
	if($_SESSION['server']['connect'] == 'odbc')$result = odbc_close($connect);
	else if($_SESSION['server']['connect'] == 'radius' && $_SESSION['server']['db']=="postgresql")
$result = pg_close($connect);
	return $result;
}

function sql_num_rows($exec){
	if($_SESSION['server']['connect'] == 'odbc')$result = odbc_num_rows($exec);
	else if($_SESSION['server']['connect'] == 'radius' && $_SESSION['server']['db']=="postgresql")
$result = pg_num_rows($exec);
	return $result;
}
function sql_commit($connect){
	if($_SESSION['server']['connect'] == 'odbc')$result = odbc_commit($connect);
	else if($_SESSION['server']['connect'] == 'radius' && $_SESSION['server']['db']=="postgresql")
    $result = pg_field_type($exec);
	return $result;
}
?>