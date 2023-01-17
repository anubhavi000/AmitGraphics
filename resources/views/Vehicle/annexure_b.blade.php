<!doctype html>
<html lang="en">

  <head>
   
  </head>
  <style>
  .synergy_img {
    border: 2px black solid;
    height: 100px;
    }
   body{
                text-align:justify; 
                font-size:14px;
            }
</style>


        <body style="line-height:30px; font-size:15px;margin-right:50px;margin-left:50px;">
           <div style="height: 100px; ">
    <table style="border:1px solid; height:90px; width:100px; float:left;">
        <tr>
            <td><center>Vehicle Owner Photo</center></td>
        </tr>
    </table>
    <center style=" margin-left: -70px;margin-top:-20px;"> 
        <h3>
            <u><b>
                UNDERTAKING<br>
                (Driver Details/ Change in Driver)<br>
                (ANNEXURE-B)
            </b></u>
        </h3>
    </center>

    <table style="border:1px solid; height:90px; width:100px; margin-top: -100px; float:right;">
        <tr>
            <td><center>Driver Photo</center></td>
        </tr>
    </table>
</div>

<div>
    <p>I <b> <u>{{$vehicle->owner_Name}} {{$vehicle->owner_Father}}</u></b> R/o <b><u>{{$vehicle->address_1}}</u></b> hereby state and undertake as under:-
    </p>
    <p>
        1. That I operate Vehicle No. <u><b>{{$vehicle->vehicle_Number}}</b></u> used for collection & transportation of Bio-Medical Waste on behalf of <b>Synergy Waste Management (P) Ltd.</b> having its registered office at <b> 517-518, 5th Floor, D-Mall, Sector-10, Rohini, New Delhi-110085 </b> Having its CBWTF Plant at <b> {{isset($plant->name)?$plant->name:'';}}, {{isset($plant->address1)?$plant->address1:''}}, {{isset($plant->address2)?$plant->address2:''}},</b> (hereinafter called First Party).
    </p>
    <p>
        2. I operate the said vehicle on route no <b> {{isset($vehicle->route)?$vehicle->route:'N.A.'}} </b>  as given to me by First Party. 
    </p>
    <p>
        @if(empty($vehicle->driver_Name))
        3. That I  <b><u>{{$vehicle->owner_Name}}</u></b> myself drive above said vehicle. 
        @else
        3. That the above vehicle is being driven by the driver Mr. <u><b>{{!empty($vehicle->driver_Name)?$vehicle->driver_Name:'____________'}}</b></u> S/o <u><b>{{!empty($vehicle->driver_Father)?$vehicle->driver_Father:'____________'}}</b></u> R/o <u><b>{{!empty($vehicle->driver_Address)?$vehicle->driver_Address:'____________'}}</b></u> employed by me.
        @endif 
    </p>
    <p>
        4. The details of the driver along with the Self Attested documents mentioned in point 4.5 are enclosed for our reference.
    </p>
    <p>
        5. That I undertake if I change the driver. I will inform the First Party immediately as (per Annexure B) and provide his details and submit all the Self attested documents mentioned below:<br>
        <b>
            1. 2 Color PASSPORT SIZE Photos of Vehicle owner and Driver, <br>
            2. Copy of valid Driving License of Vehicle owner and Driver.
        </b>
    </p>
</div>

<div style="">
    
    <p style="float: left; width: 35%; margin-top: -40px;">
        <br><br>Date : {{!empty($custom_date)?date('d-M-Y',strtotime($custom_date)):date('d-M-Y',strtotime($vehicle->agreement_date))}}<br>
        Place : New Delhi
    </p>
    
    <p style="float: right; width: 60%">
        <b>
            {{$vehicle->owner_Name}} <br>
            {{$vehicle->address_1}}<br>
            Vehicle Number : {{$vehicle->vehicle_Number}} <br>
            Pan Card Number : {{$vehicle->owner_Pan_Number}} <br>
            <u>Witness </u><br>
            1.<br>
            2.
        </b>
    </p>
</div>

     
    
    </body>

  </html>