<!doctype html>
<html lang="en">

  <head>
    <!-- Required meta tags -->
 <style>
            body{
                text-align:justify;
            }
        </style>
      </head>

  <body style="line-height:30px ;font-size:15px;margin-right:50px;margin-left:50px;">
         
           
    <center><h3><u><b>UNDERTAKING (ANNEXURE-A)</b></u></h3></center>

<div>
    <p> I <b><u>{{$vehicle->owner_Name}} {{$vehicle->owner_Father}}</u></b> R/o <b><u>{{$vehicle->address_1}}</u></b> hereby state and undertake as under:-</p>
</div>

<div>
    <p><b>1. </b>That I am the registered owner of Vehicle No. <u><b>{{$vehicle->vehicle_Number}}</b></u> used for collection & transportation of Bio-Medical Waste on behalf of <b> Synergy Waste Management (P) Ltd.</b> having its registered office at <b> 517-518, 5th Floor, D-Mall, Sector-10, Rohini, New Delhi-110085</b> Having its CBWTF Plant at <b>{{isset($plant->name)?$plant->name:'';}}, {{isset($plant->address1)?$plant->address1:''}}, {{isset($plant->address2)?$plant->address2:''}}</b> (hereinafter called First Party).<br></p>
    <p><b>2. </b> I operate the said vehicle on route no <b>{{isset($vehicle->route)?$vehicle->route:'N.A.'}}</b> as given to me by First Party.<br></p>
    <p><b>3. </b> That Bio-Medical Waste Rules 2016 have been duly explained to me and I understand the same very well.<br></p>
    <p><b>4. </b> That I undertake in case I fail to provide daily service to any of the clients (both Private and Government) and if deductions are made by the client in FIRST PARTY (Healthcare establishments) bills. I shall have no objections if similar deductions are deducted from monthly payment against the Vehicle Hiring Charges made to me.<br></p>
    <p><b>5. </b> That I undertake in case of termination of Vehicle Hiring Agreement, I shall return the GPS Device to the First Party and if the GPS Devise is not returned or GPS device found tampered or not in working condition then the company at its sole discretion has right to deduct the cost of GPS Devise from the Full and Final payment against the Vehicle Hiring Charges.<br></p>
    <p><b>6. </b> That I undertake to collect & transport Bio-Medical Waste in proper manner from health care facilities to be serviced under assigned route.<br></p>
    <p><b>7. </b> That I fully understand that any unauthorized use, sale of plastic or use of untreated bio-medical waste, collected from various health care facilities is unlawful.<br></p>
    <p><b>8. </b> I undertake to bring bio-medical waste to CBWFT Plant site and no unauthorized pilferage shall be done during its transportation.<br></p>
    <p><b>9. </b> That I undertake all legal as well as financial obligation and responsibilities arising in case of any negligence or misuse of bio-medical waste lying under my custody (i.e. my vehicle or any storage place). <br></p>
    <p><b>10. </b>  That I hereby agree to indemnify and keep the First Party harmless and indemnified from and against all and any damages, penalties, fines that may be initiated by third parties and or by the appropriate authority under the Bio- Medical Waste Rules, 2016 arising out of or in connection with the failure, refusal and neglect on the part of myself or my employees to comply with the provisions of the Bio-Medical Waste Rules, 2016 after collection of Bio-Medical Waste.<br></p>
    <p><b>11. </b>  That I shall keep and hold First party, its, shareholders, directors and officers, employees, or any such person indemnified and harmless from and against any losses, damages, liabilities, expenses (including attorney’s reasonable fees), costs, and charges of any kind whatsoever, resulting from any third party claims, suits, demands, actions, proceedings, judgments, assessments, against First Party occasioned by, arising out of or resulting from
    <br>(i) Any breach of the terms of this Agreement by myself or my employees;
    <br>(ii) Claims by third parties, including on account of injury, damage or illness directly arising from the provision of the Services or
    <br>(iii) If any claims against First Party arising from any negligent act or omission of myself or my employees.
    </p>
</div>

<div style="">
    
    <p style="float: left; width: 35%;">
        Date : {{!empty($custom_date)?date('d-M-Y',strtotime($custom_date)):date('d-M-Y',strtotime($vehicle->agreement_date))}}<br>
        Place : New Delhi
    </p>
    
    <p style="float: right; width: 60%">
        <b>
            {{$vehicle->owner_Name}} <br>
            {{$vehicle->address_1}}<br>
            Vehicle Number : {{$vehicle->vehicle_Number}} <br>
            Pan Card Number : {{$vehicle->owner_Pan_Number}} <br>
            <u>Witness </u><br>
            1.
        </b>
    </p>
</div>
             
     
    
    </body>

  </html>