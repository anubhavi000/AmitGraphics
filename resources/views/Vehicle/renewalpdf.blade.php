<!DOCTYPE html>

<html lang="en">

    <head>
        <style>
            body{
                text-align:justify;
            }
        </style>
        </head>
  
              <body style="line-height:30px; font-size:15px;margin-right:50px;margin-left:50px;">

        <p style="height: 750px;"></p>

        <center><b><u><font size="4">RENEWAL OF VEHICLE HIRING AGREEMENT</font></b></u></center>

       That the previous Agreement executed on <b>{{$vehicle->agreement_date?date('d M Y',strtotime($vehicle->agreement_date)):''}}</b> at New Delhi on Non-Judicial Stamp Paper no. <b>{{$vehicle->agreement_Certification_no}}</b> of Rs.50/- and renewals are as follows: </b> 
         <ul>
             @for($i=0; $i< count($vehicle_renewal); $i++)
             <li>
                 Renewed on   {{$vehicle_renewal[$i]->renewal_date}} on Stamp Paper No : {{$vehicle_renewal[$i]->stamp_paper_no}}
             </li>
           @endfor
         </ul>
        
        
        
   

         <center ><b>BY AND BETWEEN</b></center>
          <p> Synergy Waste Management Pvt. Ltd., having its Registered Office at 517-518, 5th Floor, DMall, Sector-10, Rohini, New Delhi – 110085 and workplace at :<br>
<b><font size = "2"><center><b>{{isset($plant->name)?$plant->name:'';}}, {{isset($plant->address1)?$plant->address1:''}}, {{isset($plant->address2)?$plant->address2:''}}</b> (hereinafter called First Party).</b></center></p> 
            <center><b>AND</b></center>
            <center>Name:- Mr./Mrs. <b><u>{{$vehicle->owner_Name}} S/O {{$vehicle->owner_Father}}</u></b></center>
<center>Address :{{!empty($vehicle->address_1)?$vehicle->address_1:''}}  {{!empty($vehicle->address_2)?$vehicle->address_2:''}} {{!empty($district)?$district->district:''}}  {{!empty($state)?$state->states:''}}  {{!empty($vehicle->pincode)?$vehicle->pincode:''}} 
</center>
   <center>For</center>
Hiring of vehicle No. <b><u>{{$vehicle->vehicle_Number}}</u></b> Make/Model <b><u>{{$model->model}}</u></b> of SECOND PARTY is owner of the said
vehicle.
For Collection of Bio-Medical Waste from designated Healthcare Facilities & Transportation to Common Bio-Medical Waste Treatment Facility of FIRST PARTY at Meerut
Both the parties have agreed to renew the agreement on the same terms & conditions of the existing Agreement of 10 (Ten) pages executed on {{!empty($vehicle->agreement_date)?date('d-M-Y',strtotime($vehicle->agreement_date)):'________'}} at New Delhi on Non-Judicial Stamp Paper no. <b><u>{{$vehicle->agreement_Certification_no}}</u></b> of Rs.50/- including annexures and undertakings and further renewals are as follows: 
<br>
<table style="  border-collapse: collapse;width: 100%;">
  <tr>
    <th style=" border: 1px solid #dddddd;text-align: left;padding: 8px;">Renewed Date</th>
    <th style=" border: 1px solid #dddddd;text-align: left;padding: 8px;">Stamp Paper No</th>
    <th style=" border: 1px solid #dddddd;text-align: left;padding: 8px;">Start Date</th>
    <th style=" border: 1px solid #dddddd;text-align: left;padding: 8px;">End Date</th>
  </tr>
  @foreach($vehicle_renewal as $vehicle_renewals)
  <tr>
    <td style=" border: 1px solid #dddddd;text-align: left;padding: 8px;">{{$vehicle_renewals->renewal_date}}</td>
    <td style=" border: 1px solid #dddddd;text-align: left;padding: 8px;">{{$vehicle_renewals->stamp_paper_no}}</td>
    <td style=" border: 1px solid #dddddd;text-align: left;padding: 8px;">{{$vehicle_renewals->after_renew_start_date}}</td>
    <td style=" border: 1px solid #dddddd;text-align: left;padding: 8px;">{{$vehicle_renewals->after_renew_end_date}}</td>
  </tr>
  @endforeach
</table>


<!--Existing agreement has / will be expired on <b>31 Mar,2020</b><br>-->
<!--This agreement shall remain valid for a period of 01 (One) year w.e.f. 01 Apr,2021 to 31 Mar,2022-->

            <br>

         

                    <div style="margin-top:5px; height:70px;">
            <p style=" float: left; width: 55%">
                <b>FIRST PARTY</b>
            </p>
            <p style=" float: right; width: 45%;">
                <b>SECOND PARTY</b>
            </p>
        </div>
        <div>
            <p style=" float: left; width: 55%">
                <b>AUTHORIZED SIGNATORY</b>
                <br> 
                Dr. NEERAJ AGGARWAL 
                <br>
                (DIRECTOR)
                <br><br>
                Witness
                <br>
                1. 
            </p>
            <p style="float: right;  width: 45%;">
                {{$vehicle->owner_Name}}
                <br>
                Vehicle Number : {{$vehicle->vehicle_Number}} 
                <br>
                PAN Number : {{$vehicle->owner_Pan_Number}} 
                <br><br>
                Witness
                <br>
                1. 
            </p>
        </div>

                    

                     

                     

    </body>

</html>