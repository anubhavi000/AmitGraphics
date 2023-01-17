<!DOCTYPE html>

<html lang="en">

    <head>
        <style>
            body{text-align:justify;}

            footer {
                position: fixed; 
                bottom: -40px; 
                left: 0px; 
                right: 0px;
                height: 60px; 
                font-size: 10px !important;

                /* Extra personal styles */
             
                text-align: center;
                line-height: 15px;
            }


            big{
                position: absolute; 
                bottom: -40px; 
                left: 0px; 
                right: 0px;
                height: 60px; 
                
                font-size: 13px !important;

                /* Extra personal styles */
             
                text-align: center;
                line-height: 10px;
            }
            small{
                position: absolute;
                right: 55px;
                top: -55px;
            }

            h6::before{
                counter-increment:section;
                content: "Page : "counter(section);
            }


        </style>

    
    </head>

    <body style="line-height:30px; font-size:15px; margin-right:50px; margin-left:50px;">
<!-- 
        <footer>
   Certificate no : <span style="font-weight: 600"> {{!empty($vehicle->agreement_Certification_no)?$vehicle->agreement_Certification_no:''}}</span> , stamp date : <span style="font-weight: 600"> {{!empty($vehicle->e_stamp_Date)?date('d-m-Y' , strtotime($vehicle->e_stamp_Date)):''}}</span>
</footer>
 -->


      <!--   <footer>
            <hr >
           
           <div style=" text-align:left ; margin:0px; margin-left:200px ; margin-top:-10px ; padding-left: 5px">
            <p><b>Vehicle Hiring Agreement</b><img height="20px"  style="margin-bottom:-8px" src="{{public_path('assets/images/hindi.jpg')}}" alt="hindi"></p>
            <p><b> Certificate no : {{!empty($vehicle->agreement_Certification_no)?$vehicle->agreement_Certification_no:''}} , Dated : {{!empty($vehicle->e_stamp_Date)?date('d-m-Y' , strtotime($vehicle->e_stamp_Date)):''}}</b></p>
           </div>
         </footer>

         <i><img src="{{public_path('assets/images/white_space_img.jpg')}}" height="60px" width="100%"  alt=""></i> -->

         <footer>
            <hr >
            <h6 style="float: right; font-size:13px ; margin-top:-1px ; margin-right: 20px"></h6>
           <div style=" text-align:left ; margin:0px; margin-left:200px ; margin-top:-10px ; padding-left: 5px">
            <p><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Vehicle Hiring Agreement</b><img height="20px"  style="margin-bottom:-8px" src="{{public_path('assets/images/hindi.jpg')}}" alt="hindi"></p>
            <p style="margin-top:-5px; font-size: 13px;"><b> Certificate no : {{!empty($vehicle->agreement_Certification_no)?$vehicle->agreement_Certification_no:''}} &nbsp;&nbsp; Dated : {{!empty($vehicle->e_stamp_Date)?date('d-m-Y' , strtotime($vehicle->e_stamp_Date)):''}}</b></p>
           </div>
         </footer>
         
         <big> 
             <img src="{{public_path('assets/images/white_space_img.jpg')}}" height="60px"  style="width:100% ;"  alt=""> <small style="font-size: 15px"><b>Page : 1</b></small></big>
         


        <p style="height: 720px;"></p>

        <center><b><u><font size="4">VEHICLE HIRING AGREEMENT</font></b></u></center>

@if ($custom_date!=null)
 This Agreement is made and Executed at New Delhi on <b>{{$custom_date?date('d M Y',strtotime($custom_date)):''}}</b>

@else 
 This Agreement is made and Executed at New Delhi on <b>{{$vehicle->agreement_date?date('d M Y',strtotime($vehicle->agreement_date)):''}}</b>

@endif

        
         <center style="margin-top: -5px"><b>BY AND BETWEEN</b></center>
            <p style="text-align:justify; margin-top:-10px"><b>Synergy Waste Management (P) Ltd.</b> , having its registered
            office at <b>517-518, 5th Floor, D-Mall, Sector-10, Rohini, New
                Delhi-110085 </b>having its CBWTF Plant at <b><u>{{isset($plant->address1)?$plant->address1:''}}, {{isset($plant->address2)?$plant->address2:''}}, {{isset($plant->name)?$plant->name:'';}}</u></b> duly represented by
            <b><u>Dr. NEERAJ AGGARWAL, DIRECTOR.</u></b> (Hereinafter referred to as 'First Party')</p>
          
<div style="page-break-before:always">&nbsp;</div> 
    
            <center style="margin-top: -20px;">AND</center>
            Name of Vehicle Owner & Address : <b><u>{{isset($vehicle->owner_Name)?$vehicle->owner_Name:''}}</u> <u>{{isset($vehicle->owner_Father)?$vehicle->owner_Father:''}}</u></b> R/O 
            <b><u>{{isset($vehicle->address_1)?$vehicle->address_1:''}}, {{isset($vehicle->address_2)?$vehicle->address_2:''}},{{isset($district_name)?$district_name->district:''}},{{isset($state_name)?$state_name->states:''}}, {{isset($vehicle->pincode)?$vehicle->pincode:''}}</u></b> Vehicle Number <b><u>{{isset($vehicle->vehicle_Number)?$vehicle->vehicle_Number:''}}</u></b>

            (Hereinafter referred to as <b>'Second Party'</b>)

            And both the parties jointly shall be referred to as <b>'Parties'</b>.

            The expression of both the parties shall mean and include the parties, their respective legal heirs, successors, legal representatives, administrators, executors and assignees.
<br>
<div>
            <center><b><u>RECITALS</u></b></center>
            
                WHEREAS the First party is a duly incorporated and registered company under Indian Companies Act, 1956 has its office and work place at the address mentioned above.The first party registered with Haryana State Pollution Control Board (HSPCB), Uttar Pradesh Pollution Control Board (UPPCB), Bihar State Pollution Control Board (BSPCB) and has been duly authorized under the Rule 10 of Bio-Medical Waste Rules 2016 and engaged in the business of collection, treatment, storage and disposal of bio-medical waste from its member Health Care Facilities. Whereas the Second Party desirous to outsource its Vehicle Number <b><u>{{isset($vehicle->vehicle_Number)?$vehicle->vehicle_Number:''}}</u></b> for Collection and Transportation of Bio-Medical Waste (herein after referred to as 'BMW'), has approached the First Party for providing its services in this regard at CBWTF <b><u> {{isset($plant->name)?$plant->name:'';}} Plant </u></b> and after discussions and due negotiations both the parties have agreed to enter into this agreement on the terms and conditions narrated herein after. Whereas the installation of GPS device is mandatory as per the new guidelines amended under Rule 8(4) of BMW rule 2016. The Second Party has to install the GPS device in its vehicle from the vendor authorised by the First Party before providing its services to the First Party.The purchase,installation and monthly service charges of the GPS Device will be borne by the First Party. Moreover, Second Party shall sign the undertaking as <b>Annexure - A </b> and <b> Annexure - B </b> after understanding all the points mentioned in the undertaking of this Agreement.
            
            
            <p>
                <b> NOW THIS INDENTURE WITNESSETH and it is hereby covenant as follows:</b>
            </p>
                <b> 1. Validity of the Agreement </b><br>   
                This agreement shall remain in force for a period of<b><u> {{($years==0)?'':$number_to_text[$years].' years '}} {{($days==0 &&( $years!=0 && $months!=0))?'and ':''}} {{($months==0)?'':$number_to_text[$months].' months '}} {{($days!=0 &&( $years!=0 || $months!=0))?'and ':''}} {{($days==0)?'':$number_to_text[$days].' days '}} ({{($years==0)?'':$years.'years '}} {{($months==0)?'':$months.'months '}} {{($days==0)?'':$days.'days'}})  </u></b> w.e.f. <b><u>{{isset($vehicle->agreement_date)?date('d-m-Y', strtotime($vehicle->agreement_date)):''}}</u></b> to <br><b><u>{{isset($vehicle->valid_upto)?date('d-m-Y', strtotime($vehicle->valid_upto)):''}}</u></b> (both days inclusive), which may be renewed further with mutual consent of both the parties.
            </p>

            <p>
                <b>2. Payment Terms</b> <br>
                <?php
                    if($fuel_type->fuel_type=='Diesel') {
                 ?>
                    (i) In case of Diesel Vehicle <br>
                    a. That the First Party will pay to the Second Party <b><u> @Rs.{{($fuel_type->fuel_type=='Diesel')?$vehicle->rate_perkm . ' ('.$per_km_amount_in_words.'Only.)' : 'N.A.'}} per km </u></b> as hiring charges of vehicle <b><u>({{($fuel_type->fuel_type=='Diesel')?$vehicle->vehicle_Number:''}}, {{($fuel_type->fuel_type=='Diesel')?$model->model:''}})</u></b> for the shortest route or the route defined by the First Party. <br> 
                    b. The cost of the fuel shall be borne by First Party <br>
                <?php
                    }
                    else {
                ?>
                (i) In case of CNG Vehicle <br>
                a. That the First Party will pay to the Second Party <b><u> @Rs.{{($fuel_type->fuel_type=='CNG')?$vehicle->rate_perkm . ' ('.$per_km_amount_in_words.'Only.)' : 'N.A.'}} per km </u></b> as hiring charges of vehicle <b><u>({{($fuel_type->fuel_type=='CNG')?$model->model:'N.A.'}}, {{($fuel_type->fuel_type=='CNG')?$vehicle->vehicle_Number:'N.A.'}})</u></b> for the shortest route or the route defined by the <b>First Party</b>. <br>
                b. The cost of the CNG on daily basis as per GPS Reading (excluding holiday & Truancy) shall be borne by First Party as per the route defined by First Party. Fixed petrol charges Rs. {{!empty($vehicle->fixed_petrol_charges)?$vehicle->fixed_petrol_charges:0}}/- per month pro-rata as per the attendence will be paid by the first party in
                addition to the CNG charges on the actual basis. <br>
                <?php
                    }
                ?>
                (ii) That TDS as applicable shall be deducted by the <b>First Party</b> from the monthly payment. <br> 
                (iii) That the <b>Second Party</b> if fails to provide PAN card, 20% TDS deduction shall be made, as applicable.<br>
                (iv) That GST or any other Tax, if applicable shall be borne by the <b>Second Party</b>. <br>
            </p>

            <p>
                <b>3. Responsibilities of the First Party</b><br>
                3.1 That the <b>First Party</b> shall provide route chart of a defined territory including each and every client in that route.<br> 
                3.2 That the helper shall be provided by the <b>First Party</b> in the vehicle for the collection of bio medical waste.<br>
                3.3 If required, whenever needed the <b>First Party</b> will provide No Entry Permission to the <b>Second Party</b>.<br>
                3.4 That the <b>First Party</b> retains the right to terminate this contract without assigning any reason thereof.<br>
                3.5 That in case of any loss to the Driver due to accident / incident such as handicap, injury or demise, The <b>First Party</b> shall not be liable to pay any compensation in any loss to the Second Party.
            </p>

            <p>
                <b>4. Responsibilities of the Second Party </b><br>
                4.1 That Bio-Medical Waste (M&H) Rules 2016 as amended till date have been duly explained to me and I understand the same very well. <br>
                4.2 That the Second Party shall be responsible to pick up BMW from each and every client on the defined route on daily basis as per route chart given. The Second Party has no objection in addition / deletion in the route chart provided by the <b>First Party</b>.<br>
                4.3 That the Second Party shall provide covered vehicle/s with separate compartments for waste & shall be painted as stipulated in BMW Handling Rule 2016 at their own cost.<br>
                4.4 That the Vehicle shall not be engaged for any other purpose even if the vehicle is idle. <br>
                4.5 That in order to perform the job under this contract, the <b>Second Party</b> shall have to provide skilled Driver along with the following documents:<br>
                <b>
                    1. 2 Color PASSPORT SIZE Photos of Vehicle owner and Driver<br> 
                    2. Copy of valid Driving License of Vehicle owner and Driver<br>
                    3. Copy of vehicle Registration Certificate<br>
                    4. Copy of Vehicle Fitness Certificate<br>  
                    5. Copy of Vehicle Insurance Policy/Cover Note<br>
                    6. Copy of Road Tax Receipt <br>
                    7. Copy of Pollution under Control Certificate <br>
                    8. Copy of PAN Card<br>
                    9. NEFT details viz. , copy of Bank Passbook (First Page) / Cancelled Cheque.
                </b><br> 
                4.6 That <b>Second Party</b> shall provide the details of the Driver/ Change in Driver along with the relevant documents as per Annexure B of this agreement.<br> 
                4.7 That in case the <b>Second Party</b> fails to provide the Registered Vehicle for service on any working day, replacement of the same shall be arranged by the Second Party at their own risk and cost. If the Second Party fails to provide replacement & the <b>First Party</b> has to arrange replacement under such circumstances the <b>First Party</b> shall be at liberty to deduct <b><u>@ Rs.1000.00</u></b> per day as penal charges from the <b>Second Party</b>. <br> 
                4.8 That all cost of vehicle maintenance, fitness, Road Tax or any Challans or any other expenses whatsoever payable to Government or any other authorities including the salary of driver shall be borne by Second Party.<br> 
                4.9 That in case of any loss to the Driver due to accident / incident such as handicap, injury or demise, The Second Party shall be liable to pay compensation under Workmen’s Compensation Act. <br> 
                4.10 That the Driver employed by the <b>Second Party</b> shall be well trained/qualified and well behaved and ensure that the <b>First Party</b> should not receive any complaint(s) from their clients. <br>
                4.11 That the <b>Second Party</b> shall ensure that entire Bio Medical waste including Autoclave waste collected from our member Health care facilities is not pilferaged in any manner viz. confining BMW in any private place, selling/bartering in open market or dumping in any isolated place. If found doing such mischief <b>First Party</b> may take suitable administrative as well as legal action against the <b>Second Party</b>.<br> 
                4.12 In case the <b>Second Party</b> fails to provide daily service to any of the clients (both Private and Government) and if deduction is made by the client in <b>First Party</b> (Healthcare establishments) bills, similar deductions shall be deducted from the monthly payment against the Vehicle Hiring Charges made to the Second Party.
            </p>

            <p>
                <b>5 GPS Devises Maintenance & Safe Keeping</b> <br> 
                <b>a. Maintenance & Safe Keeping:</b> That <b>Second Party</b> will keep the GPS Device safe from any physical damages, mishandling, theft, liquid damages, short- circuit or any other form of damage which may destroy the GPS Devise. <br> 
                b. That the GPS Device will be sealed and closed by the GPS Service Company, <b>in any circumstances if the seal is found to be damaged due to electrical short circuit or theft or broken or other physical damage /tempering or any other reason where the fault has been done by Second Party or Second Party Driver or any person travelling in the vehicle, / damaged due to liquid damage, which may be due to washing of the vehicle or due to rain or due to any other reason, even the seal of the GPS Devise is open or not</b>, then <b>Second Party</b> shall be responsible of any such damage caused to the GPS Device and the cost of repair or replacement as charged by the GPS Service Company shall be borne by <b>Second Party</b>. <br> 
                c. That <b>First Party</b> shall not be charging for any purchase, installation and monthly service charges for usage of GPS Devise from Second Party, however in case of any damage as mentioned in Point 5.2, the cost of replacement or repair shall be deducted from the monthly payment against the Vehicle Hiring Charges. <br> 
                d. That <b>Second Party</b> agrees that in case of termination of Vehicle Hiring Agreement, the <b>Second Party</b> shall return the GPS Device to the <b>First Party</b> and if the GPS Devise is not returned or GPS device found tampered or not in working condition then the company has right to deduct the cost of GPS Devise from the Full and Final payment against the Vehicle Hiring Charges. </b>
            </p>

            <p>
                <b>6 Limitation of Liability</b><br>
                That neither party will be liable to the other for any indirect, special, or consequential damages of any kind, including, but not limited to, loss of profits arising in any manner from this agreement regardless of the foresee ability thereof. 
            </p>

            <p>
                <b>7 Indemnification</b> <br>
                That the <b>Second Party</b> shall indemnify, defend and hold harmless the <b>First Party</b>, its shareholder, officers, directors, employees, representatives, agents and assignees from and against any and all Claims asserted against, imposed upon or incurred, due to, arising out of or relating to any breach of this contract by <b>Second Party</b> of any representation, warranty, term, condition or covenant set forth in this Agreement. 
            </p>
<div style="page-break-before:always">&nbsp;</div> 
            <p style="margin-top: -40px">
                <b>8 Termination Clause</b> <br>
                8.1 That both the Parties shall be at liberty to terminate this contract by serving a notice of 1 Month well in advance or alternately compensating the other party by an amount equal to 1 month’s service charges. <br> 
                8.2 That the <b>First Party</b> shall be at liberty to serve the notice of termination of this agreement without prejudice if Second Party/Second Party Staff misbehaves with <b>First Party</b> clients or with any of First Party staff leading to misconduct. <br>
                8.3 That if it is found that the Odometer/ GPS device is tempered intentionally by <b>Second Party</b>, <b>First Party</b> may serve an immediate termination notice. <br>
                8.4 That if it is found that Second Party /Second Party Driver found engaged in any illegal activities, then First Party may serve an immediate termination notice. <br>
                8.5 That by applicability of para 8.2, 8.3 and 8.4 clause of termination notice of one month shall not apply. <br>
                <b> 9 Miscellaneous Provisions: </b> <br>
                9.1 <b>Notices:</b>
                Any notice, consent or other communication required or permitted hereunder shall be in writing.<br>
                9.2 <b>ARBITRATION: </b>
                Both parties undertake that if any dispute arises in respect to the terms of this Agreement shall be resolved by the Sole Arbitrator which will be decided mutually. The decision of the Sole Arbitrator shall be final and binding on both the parties.<br>
                9.3 <b>Governing Law and Court Jurisdiction:</b>
                The present agreement shall be governed by the laws of Republic of India and any dispute arising out of or incidental to this Agreement shall be subject to the jurisdiction of the Courts at New Delhi.<br>
                9.4 <b>Validity:</b>
                This agreement is valid for the period from date of signing of this agreement till 31st, March of same financial year. This agreement supersedes all previous agreements.<br>
                9.5 <b>FORCE MAJEURE:</b> 
                That both the Parties are not liable for any default or delay in the performance of their respective obligations under the terms of this Agreement; to the extent such default or delay is caused by an event beyond the reasonable control of the Service Provider, whichever entity is unable to perform (the “Non -Performing Party”). A Force Majeure Event includes but is not limited to, fire, flood, earthquake, elements of nature, acts of war, terrorism, riots, civil disorders, rebellion, strike, lockouts, or any other act or omission of God, government or any other party beyond the Party’s control or responsibility. Force Majeure Events shall not give rise to any claim against the other Party; nor shall any default or delay, due to a Force Majeure Event, be deemed a breach of this Agreement. <br>
            </p>    


</div>
       

  <div style="page-break-before:always">&nbsp;</div>      

       <div style="height: 100px;">

           <p style="float:left ; width:48%">

                <b>All address of communication shall be</b><br>

                    If to <b>:Synergy Waste Management Pvt Ltd;</b>

           </p>

           <p style="float:right;  width:48%;margin-top:13px;">
                   <br>    517 - 518, 5th Floor, D Mall, Sector - 10,  Rohini , New Delhi - 110085 , India
           </p>

           

       </div>

         <div style="height: 10px;  margin-top:40px">

           <p style="float:left ;width:48%">

               If to :Vehicle Number : <b> {{$vehicle->vehicle_Number}}</b>

             

           </p>

         <p style="float:right ; width: 48%;margin-top: 10px;">
                Owner Name : {{$vehicle->owner_Name}} <br>
                Address: {{$vehicle->address_1}}, {{$vehicle->address_2}}, {{!empty($district->district)?$district->district:''}}, {{$state->states}} - {{$vehicle->pincode}}

            </p>

           

       </div>

       <div style="margin-top:110px;">
            <p>
                IN WITNESS WHERE OF, each party hereto has duly entered and executed this Agreement as of the Effective Dare and represents and warrants that the party executing this Agreement on its behalf is duly authorized to do so. This Agreement shall be prepared in two originals, one each to be retained by all the two parties.
                <br><br>Date : {{!empty($custom_date)?date('d-M-Y',strtotime($custom_date)):date('d-M-Y',strtotime($vehicle->agreement_date))}}
                <br>Place : New Delhi
            </p>           
       </div>

          

        <div style="margin-top:15px; height:70px;">
            <p style=" float: left; width: 55%">
                <b>FIRST PARTY</b>
            </p>
            <p style=" float: right; width: 45%;">
                <b>SECOND PARTY</b>
            </p>
        </div>
        <div>
            <p style=" float: left; width: 55%; margin-top:60px;">
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
            <p style="float: right;  width: 45%; margin-top: 60px;">
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

<div style="page-break-before:always">&nbsp;</div> 



<center><h3><u><b>UNDERTAKING (ANNEXURE-A)</b></u></h3></center>

<div>
    <p> I <b><u>{{$vehicle->owner_Name}} {{$vehicle->owner_Father}}</u></b> R/o <b><u>{{$vehicle->address_1}}
            
        </u></b> hereby state and undertake as under:-</p>
</div>

<div>
    <p><b>1. </b>That I am the registered owner of Vehicle No. <u><b>{{$vehicle->vehicle_Number}}</b></u> used for collection & transportation of Bio-Medical Waste on behalf of <b> Synergy Waste Management (P) Ltd.</b> having its registered office at <b> 517-518, 5th Floor, D-Mall, Sector-10, Rohini, New Delhi-110085</b> Having its CBWTF Plant at <b>{{isset($plant->name)?$plant->name:'';}}, {{isset($plant->address1)?$plant->address1:''}}, {{isset($plant->address2)?$plant->address2:''}}</b> (hereinafter called First Party).<br></p>
    <p><b>2. </b>	I operate the said vehicle on route no <b>{{isset($vehicle->route)?$vehicle->route:'N.A.'}}</b> as given to me by First Party.<br></p>
    <p><b>3. </b>	That Bio-Medical Waste Rules 2016 have been duly explained to me and I understand the same very well.<br></p>
    <p><b>4. </b>	That I undertake in case I fail to provide daily service to any of the clients (both Private and Government) and if deductions are made by the client in FIRST PARTY (Healthcare establishments) bills. I shall have no objections if similar deductions are deducted from monthly payment against the Vehicle Hiring Charges made to me.<br></p>
    <p><b>5. </b>	That I undertake in case of termination of Vehicle Hiring Agreement, I shall return the GPS Device to the First Party and if the GPS Devise is not returned or GPS device found tampered or not in working condition then the company at its sole discretion has right to deduct the cost of GPS Devise from the Full and Final payment against the Vehicle Hiring Charges.<br></p>
    <p><b>6. </b>	That I undertake to collect & transport Bio-Medical Waste in proper manner from health care facilities to be serviced under assigned route.<br></p>
    <p><b>7. </b>	That I fully understand that any unauthorized use, sale of plastic or use of untreated bio-medical waste, collected from various health care facilities is unlawful.<br></p>
    <p><b>8. </b>	I undertake to bring bio-medical waste to CBWFT Plant site and no unauthorized pilferage shall be done during its transportation.<br></p>
    <p><b>9. </b>	That I undertake all legal as well as financial obligation and responsibilities arising in case of any negligence or misuse of bio-medical waste lying under my custody (i.e. my vehicle or any storage place). <br></p>
    <p><b>10. </b>	That I hereby agree to indemnify and keep the First Party harmless and indemnified from and against all and any damages, penalties, fines that may be initiated by third parties and or by the appropriate authority under the Bio- Medical Waste Rules, 2016 arising out of or in connection with the failure, refusal and neglect on the part of myself or my employees to comply with the provisions of the Bio-Medical Waste Rules, 2016 after collection of Bio-Medical Waste.<br></p>
    <p><b>11. </b>	That I shall keep and hold First party, its, shareholders, directors and officers, employees, or any such person indemnified and harmless from and against any losses, damages, liabilities, expenses (including attorney’s reasonable fees), costs, and charges of any kind whatsoever, resulting from any third party claims, suits, demands, actions, proceedings, judgments, assessments, against First Party occasioned by, arising out of or resulting from
    <br>(i)	Any breach of the terms of this Agreement by myself or my employees;
    <br>(ii) Claims by third parties, including on account of injury, damage or illness directly arising from the provision of the Services or
    <br>(iii) If any claims against First Party arising from any negligent act or omission of myself or my employees.
    </p>
</div>

<div style="">
    
    <p style="float: left; width: 35%; margin-top: 80px;">
        Date : {{!empty($custom_date)?date('d-M-Y',strtotime($custom_date)):date('d-M-Y',strtotime($vehicle->agreement_date))}}<br>
        Place : New Delhi
    </p>
    
    <p style="float: right; width: 60%;  margin-top: 80px;">
        <b>
            {{$vehicle->owner_Name}} <br>
            {{$vehicle->address_1}} <br>
            Vehicle Number : {{$vehicle->vehicle_Number}} <br>
            Pan Card Number : {{$vehicle->owner_Pan_Number}} <br>
            <u>Witness </u><br>
            1.
        </b>
    </p>
</div>


                   
<div style="page-break-before:always">&nbsp;</div> 
                     

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
    <p>I <b> <u>{{$vehicle->owner_Name}} {{$vehicle->owner_Father}}</u></b> R/o <b><u>{{$vehicle->address_1}}, {{$vehicle->address_2}}, {{!empty($district->district)?$district->district:''}}, {{$state->states}} - {{$vehicle->pincode}}</u></b> hereby state and undertake as under:-
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
        3. That the above vehicle is being driven by the driver Mr. <u><b>{{!empty($vehicle->driver_Name)?$vehicle->driver_Name:'____'}}</b></u> S/o <u><b>{{!empty($vehicle->driver_Father)?$vehicle->driver_Father:'____'}}</b></u> R/o <u><b>{{!empty($vehicle->driver_Address)?$vehicle->driver_Address:'____'}}</b></u> employed by me.
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
    
    <p style="float: left; width: 35%; margin-top: 10px;">
        <br><br>Date : {{!empty($custom_date)?date('d-M-Y',strtotime($custom_date)):date('d-M-Y',strtotime($vehicle->agreement_date))}}<br>
        Place : New Delhi
    </p>
    
    <p style="float: right; width: 60%; margin-top: 70px;">
        <b>
            {{$vehicle->owner_Name}} <br>
            {{$vehicle->address_1}} <br>
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