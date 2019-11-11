<?php
@session_start();
/**
 ****************************
 * Configuration File
 ****************************
 */
 
$cfg['server']['db']       = 'postgresql';        // Database such as postgresql, mssql, oracle
$cfg['server']['connect']  = 'odbc';         // Connection type such as odbc, database
$cfg['server']['username'] = 'postgres';    // Username
$cfg['server']['passwd']   = 'edss';        // Password
$cfg['server']['dsn']      = 'edss';           // DSN 


//********** only needed with $cfg['server']['connect'] = 'database' **********
$cfg['server']['host']   = '10.10.17.30' ; //Host ip address
$cfg['server']['port']   = '5432' ; //Database Port
$cfg['server']['dbname'] = 'edss'; // Database name
//********** end only needed with 'database' connect **********

/*
*****************************************
* Don't modify anything below this line *
*****************************************
*/
$_SESSION['server']['db']	    = $cfg['server']['db'];
$_SESSION['server']['connect']  = $cfg['server']['connect'];
$_SESSION['server']['dsn']	    = $cfg['server']['dsn'];
$_SESSION['server']['host']		= $cfg['server']['host'];
$_SESSION['server']['port']		= $cfg['server']['port'];
$_SESSION['server']['dbname']	= $cfg['server']['dbname'];
$_SESSION['server']['username']	= $cfg['server']['username'];
$_SESSION['server']['passwd']	= $cfg['server']['passwd'];

?>