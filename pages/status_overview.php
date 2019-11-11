<?php
header("Access-Control-Allow-Origin: *");
include('../config/sql/connect_db.php');
include('../config/nosql/connect_db.php');

$result = array();

if( $_GET['project_id']!="" ){
    
    /* Select Project */
    $ck = " SELECT * FROM project WHERE _id = ".$_GET['project_id']." ";
    $ckr = pg_query( $connect, $ck ) or die(pg_last_error());
    if(pg_num_rows($ckr) <= 0){
        
        $result['status'] = 400;
        $result['msg'] = 'Not Found Info.';
    }else{
        /* Device Status */
        $q=" SELECT get_project_status( ".$_GET['project_id'].") as project_status";
        $qr = pg_query( $connect, $q ) or die(pg_last_error());
        if(pg_num_rows($qr)>0){
            $row = pg_fetch_array($qr, null, PGSQL_ASSOC);
            $result['status'] = 200;
            $result['msg']    = 'OK';
            $cnt_data = explode(",", substr($row['project_status'],1,-1));

            $all             = array();
            $all['online']   = intval($cnt_data[0]);
            $all['lost']     = intval($cnt_data[1]);
            $all['offline']  = intval($cnt_data[2]);

            $abox            = array();
            $abox['online']  = intval($cnt_data[3]);
            $abox['lost']    = intval($cnt_data[4]);
            $abox['offline'] = intval($cnt_data[5]);

            $wbox            = array();
            $wbox['online']  = intval($cnt_data[6]);
            $wbox['lost']    = intval($cnt_data[7]);
            $wbox['offline'] = intval($cnt_data[8]);

            $thbox            = array();
            $thbox['online']  = intval($cnt_data[9]);
            $thbox['lost']    = intval($cnt_data[10]);
            $thbox['offline'] = intval($cnt_data[11]);

            $vabox            = array();
            $vabox['online']  = intval($cnt_data[12]);
            $vabox['lost']    = intval($cnt_data[13]);
            $vabox['offline'] = intval($cnt_data[14]);

            $rbox            = array();
            $rbox['online']  = intval($cnt_data[15]);
            $rbox['lost']    = intval($cnt_data[16]);
            $rbox['offline'] = intval($cnt_data[17]);




            /* Sensor Count */
            $devices_collection = new MongoCollection($db, 'devices');
            /* A_box */
            $ft_abox_normal = array( '$and' => array( 
                                        array( 'rawdata.AC' => '1', 
                                               'device_info.device_type' => '1', 
                                               'device_info.project_id' => $_GET['project_id']
                                             )
                                        )
                                    );
            $cursor = $devices_collection->find( $ft_abox_normal );
            $abox['sensor']['nomal'] = count( iterator_to_array($cursor) );

            $ft_abox_failure = array( '$and' => array( 
                                        array( 'rawdata.AC' => '0', 
                                               'device_info.device_type' => '1', 
                                               'device_info.project_id' => $_GET['project_id']
                                             )
                                        )
                                    );
            $cursor = $devices_collection->find( $ft_abox_failure );
            $abox['sensor']['ac_failure'] = count( iterator_to_array($cursor) );
            /* END A-Box */

            /* W_box */
            $ft_wbox_normal = array( '$and' => array( 
                                        array( 'rawdata.AC'  => '1',
                                               'rawdata.OPT' => '1',
                                               'device_info.device_type' => '2', 
                                               'device_info.project_id'  => $_GET['project_id']
                                             )
                                        )
                                    );
            $cursor = $devices_collection->find( $ft_wbox_normal );
            $wbox['sensor']['nomal'] = count( iterator_to_array($cursor) );

            $ft_wbox_failure = array( '$and' => array( 
                                        array( 'rawdata.AC'  => '0',
                                               'rawdata.OPT' => '1',
                                               'device_info.device_type' => '2', 
                                               'device_info.project_id' => $_GET['project_id']
                                             )
                                        )
                                    );
            $cursor = $devices_collection->find( $ft_wbox_failure );
            $wbox['sensor']['ac_failure'] = count( iterator_to_array($cursor) );

            $ft_wbox_optical_disconnect = array( '$and' => array( 
                                        array( 'rawdata.AC'  => '1',
                                               'rawdata.OPT' => '0', 
                                               'device_info.device_type' => '2', 
                                               'device_info.project_id' => $_GET['project_id']
                                             )
                                        )
                                    );
            $cursor = $devices_collection->find( $ft_wbox_optical_disconnect );
            $wbox['sensor']['opt_failure'] = count( iterator_to_array($cursor) );

            $ft_wbox_both_failure = array( '$and' => array( 
                                        array( 'rawdata.OPT' => '0',
                                               'rawdata.AC' => '0',
                                               'device_info.device_type' => '2', 
                                               'device_info.project_id' => $_GET['project_id']
                                             )
                                        )
                                    );
            $cursor = $devices_collection->find( $ft_wbox_both_failure );
            $wbox['sensor']['opt_both_failure'] = count( iterator_to_array($cursor) );
            /* END W-Box */


            /* TH_box */
            $ft_thbox_normal = array( '$and' => array( 
                                        array( 'rawdata.AC' => '1', 
                                               'device_info.device_type' => '3', 
                                               'device_info.project_id' => $_GET['project_id']
                                             )
                                        )
                                    );
            $cursor = $devices_collection->find( $ft_thbox_normal );
            $thbox['sensor']['normal'] = count( iterator_to_array($cursor) );

            $ft_thbox_failure = array( '$and' => array( 
                                        array( 'rawdata.AC' => '0', 
                                               'device_info.device_type' => '3', 
                                               'device_info.project_id' => $_GET['project_id']
                                             )
                                        )
                                    );
            $cursor = $devices_collection->find( $ft_thbox_failure );
            $thbox['sensor']['ac_failure'] = count( iterator_to_array($cursor) );
            /* END TH-Box */

            /* VA_box */
            $ft_vabox_normal = array( '$and' => array( 
                                        array( 'rawdata.AC' => '1', 
                                               'device_info.device_type' => '4', 
                                               'device_info.project_id' => $_GET['project_id']
                                             )
                                        )
                                    );
            $cursor = $devices_collection->find( $ft_vabox_normal );
            $vabox['sensor']['normal'] = count( iterator_to_array($cursor) );

            $ft_vabox_failure = array( '$and' => array( 
                                        array( 'rawdata.AC' => '0', 
                                               'device_info.device_type' => '4', 
                                               'device_info.project_id' => $_GET['project_id']
                                             )
                                        )
                                    );
            $cursor = $devices_collection->find( $ft_vabox_failure );
            $vabox['sensor']['ac_failure'] = count( iterator_to_array($cursor) );
            /* END VA-Box */

            /* R_box */
            $ft_rbox_normal = array( '$and' => array( 
                                        array( 'rawdata.AC' => '1', 
                                               'device_info.device_type' => '5', 
                                               'device_info.project_id' => $_GET['project_id']
                                             )
                                        )
                                    );
            $cursor = $devices_collection->find( $ft_rbox_normal );
            $rbox['sensor']['normal'] = count( iterator_to_array($cursor) );

            $ft_rbox_failure = array( '$and' => array( 
                                        array( 'rawdata.AC' => '0', 
                                               'device_info.device_type' => '5', 
                                               'device_info.project_id' => $_GET['project_id']
                                             )
                                        )
                                    );
            $cursor = $devices_collection->find( $ft_rbox_failure );
            $rbox['sensor']['ac_failure'] = count( iterator_to_array($cursor) );
            /* END R-Box */

            $status          = array();
            $status['all']   = $all;
            $status['abox']  = $abox;
            $status['wbox']  = $wbox;
            $status['thbox'] = $thbox;
            $status['vabox'] = $vabox;
            $status['rbox']  = $rbox;
            $result['data']['device_status'] = $status;

        }else{
            $result['status'] = 400;
            $result['sql']    = $sql;
            $result['msg']    = 'Error SQL : ( Device Status )';
        }
        /* END Device Status */
    }
}else{
    $result['status'] = 400;
    $result['msg'] = 'Not Found Input';
}

pg_close($connect);
$result = json_encode($result);
echo $result;
?>
