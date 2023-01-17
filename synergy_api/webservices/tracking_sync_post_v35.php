<?php
// echo 'php';
// echo 'php'; die;
// 
date_default_timezone_set('Asia/Calcutta');
$current_date_time = date("Y-m-d H:i:s");
require_once('../admin/include/conectdb.php');
//$dbc = @mysqli_connect('localhost','root','Dcatch','msell-dsgroup-dms') OR die ('could not connect:');
require_once('../admin/include/config.inc.php');
require_once 'functions.php';
$unique_id = array();
// if (isset($_POST['response'])) {
//     $check = $_POST['response'];
// } else {
//     $check = '';

// }
// $check = str_replace("'", "", $check);
// $data = json_decode($check);
 #Added By Deepak At 28-01-2019
 #Removing special character from post JSON 

// if(isset($_POST['response']))
// {
// $checkRes  = str_replace("'","",$_POST['response']);
// $str = str_replace('\\', ' ', $checkRes);
// // $checkRes  = str_replace("'","",$_POST['response']);
// } 
// else $str='';

// $check=cleanSpecialChar($str);

// #This method used for removing special charactor
// function cleanSpecialChar($string) 
// {
//    return preg_replace('/[^A-Za-z0-9\s:"{}/\,[]]/', '', $string); // Removes special chars.
// }

// $utf8 = utf8_encode($check);
// $data = json_decode($utf8);
// pre($_POST['response']);die;
#----------------------------Phase -2 -------------------------------#

if(isset($_POST['response']))
{
$checkRes  = str_replace("'","",$_POST['response']);
$str_test= str_replace('\"', '|', $checkRes);
$str = str_replace('\\', '|', $str_test);
// $str = str_replace('\\', '|', $checkRes);
} 
else $str='';
$check=cleanSpecialChar($str);

#This method used for removing special charactor
function cleanSpecialChar($string) 
{
   return preg_replace('/[^A-Za-z0-9\s:\/"{},[]]/', '', $string); // Removes special chars.
}
$utf8 = utf8_encode($check);

// echo $utf8;die;

$data = json_decode($utf8);

// print_r($data); die;



if($data) 
{

    

    $user_id = $data->response->user_id;
    $company_id = $data->response->company_id;
    $company_id_new = $data->response->company_id;


     $q = "SELECT * From person_login WHERE person_id='$user_id' AND `company_id` = '$company_id'";

    $user_res = mysqli_query($dbc, $q);
    $q_person = mysqli_fetch_assoc($user_res);
    // print_r($q_person);
    $person_id = $q_person['person_id'];
    $status = $q_person['person_status'];

    mysqli_query($dbc, "update person_login SET last_mobile_access_on=NOW(), app_type='SFA' Where person_id='$person_id'");
    if ($status == '1') {

        // print_r($status);
        $unique_id_array = array();
        $tracking = $data->response->Tracking;


        if (!empty($tracking)) {
            $track = count($tracking);
            $tr = 0;
            while ($tr < $track) {
                $track_date = $tracking[$tr]->track_date;
                $track_time = $tracking[$tr]->track_time;
                $mnc_mcc_lat_cellid = $tracking[$tr]->mnc_mcc_lat_cellid;
                $lat_lng = $tracking[$tr]->lat_lng;
                $track_address = $tracking[$tr]->track_address;
                $battery_status = $tracking[$tr]->battery_status;
                $gps_status = $tracking[$tr]->gps_status;
                // $notifi_status = !empty($tracking[$tr]->notifi_status)?$tracking[$tr]->notifi_status:'0';
                $ll = explode(",", $lat_lng);
                if ($track_address == '$$') {
                    $user_location = getLocationByLatLng($ll[0], $ll[1]);
                } else {

                    $user_location = $track_address;
                }
                $q2 = "SELECT count(user_id) as num from user_track_details where user_id='" . $user_id . "' AND "
                    . " DATE_FORMAT(track_date,'%Y-%m-%d') ='" . $date . "' AND track_time= '" . $time . "' AND `company_id` = '$company_id' ";
                $sql = mysqli_fetch_assoc(mysqli_query($dbc, $q2));
                $num = $sql['num'];
                if ($num < 1) {
                   

                   $qd="INSERT INTO `user_track_details`(`user_id`, `track_date`, `track_time`, `mnc_mcc_lat_cellid`, `lat_lng`, `track_address`, `status`, `server_date_time`,`battery_status`,`gps_status`,`company_id`) VALUES ('$user_id','$track_date','$track_time','$mnc_mcc_lat_cellid','$lat_lng','$user_location','Tracking',NOW(),'$battery_status','$gps_status','$company_id')";
                $rd = mysqli_query($dbc, $qd);


            
                }
                
                $tr++;
            }
        }


   

    } else {
        // echo 'N';
    }


    ob_start();
    ob_clean();
    //$uniqueId = implode(',', $unique_id);
    // print_r($unique_id_array);
    $uniqueId="'". implode("','", $unique_id_array) ."'";
    $essential = array("response" => "Y", "unique_id" => $uniqueId);
    $data = json_encode($essential);
    echo $data;

    ob_get_flush();
    ob_end_flush();

} else {
    $essential = array("response" => "N", "unique_id" => 'null');
    $data = json_encode($essential);
    echo $data;
}
