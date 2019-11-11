<?php
    //connect to server
    $connection= new MongoClient("mongodb://ais:edss@10.10.17.30:2727/edss");
    /// connect to a database
    $db = $connection->selectDB('edss');

    //Access collection
    //$dev_collection = new MongoCollection($db, 'ais_edss_dev');
    //$conf_collection = new MongoCollection($db, 'ais_edss_conf');
    //$dev_collection = new MongoCollection($db, 'device');
    //$conf_collection = new MongoCollection($db, 'config');
?>
