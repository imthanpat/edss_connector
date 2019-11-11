<?php
header("Access-Control-Allow-Origin: *");
include('../config/sql/connect_db.php');
include('../config/nosql/connect_db.php');

// Success
$result = array();
$result['status'] = 200;
$result['msg'] = 'Success';

$result = json_encode($result);
echo $result;