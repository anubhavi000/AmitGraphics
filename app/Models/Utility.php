<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\EntryMast;
use App\Models\VendorMast;
use App\Models\PlantMast;
use App\Models\Utility;
use App\Models\SupervisorMast;
use App\Models\VehicleMast;
use App\Models\ItemMast;
use App\Models\sites;
use App\Models\ExportData as CSV;
use Session;
use PDF;
use Auth;

class Utility extends Model
{
    use HasFactory;

    static function Excesswhatsappnotify($slip_no){
       $json =[
            'countryCode' => '+91',
            'phoneNumber' => '8448686361',
            'callbackData' =>"ved sent",
             'type'=> 'Template',
             'template'=>[
                'name'=>"shop_from_us_on_whatsapp",
                'languageCode'=>"en",
                'bodyValues'=>[
                    'ved',
                ],
                'buttonValues' => [
                "1"=>
                [
                  "UP_22-23_10500(382552811).pdf"
                ]
             ]
             ]
        ];
        $json2 = json_encode($json);
        // echo $json2;
      
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.interakt.ai/v1/public/message/',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS =>json_encode($json)
		,

		  
		  CURLOPT_HTTPHEADER => array(
		    'Authorization: Basic Basic VTlLNW9Vd3NCdTNqb1ZTcVZrS3VCd0VSa24xVDhCUk5heUdXU1Q0VnJrYzo=\'',
		    'Content-Type: application/json',
		    'Cookie: ApplicationGatewayAffinity=a8f6ae06c0b3046487ae2c0ab287e175; ApplicationGatewayAffinityCORS=a8f6ae06c0b3046487ae2c0ab287e175'
		  ),
		));

		$response = curl_exec($curl);
		curl_close($curl);
    }
}
