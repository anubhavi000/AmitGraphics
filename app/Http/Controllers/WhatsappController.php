<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class WhatsappController extends Controller
{
    public function index(Request $request){
        // echo "code will be here";
        return view('Whatsapp.index');
    }
public function store(Request $request){
  $json = [
    'userId' => $request->userid,
    'phoneNumber'=>"$request->phone",
    'countryCode' => "+91",
    'traits'=>[
     'name' =>$request->name,
     'email'=>$request->email
    ],
    'tags'=> ["testing", "update"]
  ];
  $json2 = json_encode($json);
  echo $json2;
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.interakt.ai/v1/public/track/users/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>json_encode($json),
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Authorization: Basic bWxDc2Y5LWphVnBlNlpEWTJQVXRVaG44d3pNdWFRX3RsZ183bmZlbXBTUTo=',
    'Cookie: ApplicationGatewayAffinity=a8f6ae06c0b3046487ae2c0ab287e175; ApplicationGatewayAffinityCORS=a8f6ae06c0b3046487ae2c0ab287e175'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;


        return view('Whatsapp.index');
    }

    public function send(Request $request){
    
        $json =[
            'countryCode' => '+91',
            'phoneNumber' => $request->phone,
            'callbackData' =>"ved sent",
             'type'=> 'Template',
             'template'=>[
                'name'=>"shop_from_us_on_whatsapp",
                'languageCode'=>"en",
                'bodyValues'=>[
                    $request->reciever,
                    //"iu888",
                    //$request->bill_no,
                  // "https://synergy.msell.in/public/pdf/UP_22-23_10500(382552811).pdf"   
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
        echo $json2;
      
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
echo $response;

    }
}
