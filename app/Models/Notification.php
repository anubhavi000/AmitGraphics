<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Exception;
use DB;
use App\Helpers\ConstantHelper;

class Notification extends Model
{
    protected $table = 'notification';
    protected $guarded = [];
    protected $timestamp = false;

	public static function notification($fcm_token,$data){
		$url = "https://fcm.googleapis.com/fcm/send";
        $fields = array(
            'to' => $fcm_token,
            'notification' => $data,
            'data' => ['complaint_id' =>  'Test', 'notify_type' => 1], #1 for complaint notification
           

        );
        // dd(json_encode($fields));
        $headers = array(
            'Authorization: key=AAAAa0sARMo:APA91bGlmS7x8GHoxEfEs5_brpFPK9fMLa5jZTSmKL_L7xFy9d4LVvbAqyMftOba7qNsOdb_PIA0wd0NK-tXDDnJW8OW8teu_3CM_us92cahxLuNTx1W2EtZkKWhAZBYyDV_dHfsFrq5',
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        if ($result === FALSE) {
            die('Curl Failed: ' . curl_error($ch));
        }
        // dd($result);
        return $result;
	}
}