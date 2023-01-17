<html lang="en">

  <head>

    <!-- Required meta tags -->

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">



    <!-- Bootstrap CSS -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">

    <link rel="stylesheet" type="text/css" href="{{asset('/css/pdf/fstdropdown.css')}}">

    <link rel="stylesheet" href="{{ asset('theme/assets/css/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/assets/css/light_ness.min.css') }}">
    {{-- <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet"> --}}

    <title>Synergy</title>

  </head>

<style>
  .syn_font{
color: #818A91;
  }
  .syn_drop{
    left: -150px !important;
  }
  .tag{
    display: inline-block;
padding: .35em .4em;
font-size: 85%;
font-weight: 600;
line-height: 1;
color: #FFF;
text-align: center;
vertical-align: baseline;
border-radius: .18rem;
  }
  .tag-danger{
    background-color: #FFB64D;
  }
  .tag-success {
    background-color: #37BC9B;
  }
.dwn{
  background-color: #4f81a4;
  border: 1px solid #4f81a4;
}
.fnt{
  font-weight: bold;
}
</style>



  <body style="background: #f3f3f3">

      @php 

      $encrypt_id= enCrypt($vehicle->id);

      @endphp

    <div class="container-fluid" style="padding: 10px;">

      <div class="row" style="margin: 10px;">

     <div class="col-md-6">

      <h3 class="content-header-title mb-0">Vehicle Details</h3>

       <p class="syn_font"><i class="fas fa-suitcase"></i>Vehicle ID: <strong style="font-weight: bolder;">{{$vehicle->vehicle_char_id}}</strong></p> 

     </div>

     <div class="col-md-6" style="display: flex;justify-content: right;">

      <div class="mr-2">

       <button class="btn btn-secondary hidden-print btn-sm" onclick="myFunction()"><i class="fas fa-print"></i> Print</button>

      </div>

      <div class="mr-2" id="certificateissuebtn">

         <a href='{{url("downloadvehiclepdf/agreement/{$encrypt_id}")}}' class="btn btn-primary  btn-sm" ><i class="fas fa-download"></i>  Agreement (Pdf)</a>

      </div>

       <div class="mr-2"  id="certificatebtn">

        <a href='{{url("downloadvehiclepdf/annexure_a/{$encrypt_id}")}}' class="btn btn-primary  btn-sm" ><i class="fas fa-download"></i>  Annexure A (Pdf)</a>

      </div>

      <div class="mr-2">

  <a href='{{url("downloadvehiclepdf/annexure_b/{$encrypt_id}")}}' class="btn btn-primary  btn-sm" ><i class="fas fa-download"></i> Annexure B (Pdf)</a>

      </div>

      <div class="mr-2">

   <a href='{{url("downloadvehiclepdf/renewal/{$encrypt_id}")}}' class="btn btn-primary btn-sm" ><i class="fas fa-download"></i> Vehicle Renewal (Pdf)</a>

   

      </div>

      <div class="mr-2">

            <a href='{{url("downloadvehiclepdf/renewalpdf/{$encrypt_id}")}}' class="btn btn-primary btn-sm"> <i class="fas fa-download "></i> Download Last Renewal Pdf</a>

      </div>

  

       

     </div>

    </div>

    <div class="row bg-white" style="margin: 20px;margin-top: -4px; padding:30px">

    <div class="col-md-12 ">

    <div class="row">

      <div class="col-md-4 ">

      <p class="syn_font text-center " style="margin-bottom:0px"> <strong style="font-weight: bolder; "><u>{{$vehicle->vehicle_char_id}}</u></strong></p> 

       <p class="syn_font text-center" style="margin-bottom:0px">{{$vehicle->vehicle_Number}}</p>

      <img id="barcode" class="img-responsive" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAiwAAAA+CAYAAAAI9kBQAAAHbUlEQVR4nO2WUWpcQRADfStDyP2vFd8gtpBaI0wV7N9OT6ERj/74BwAAADDOx2sBAAAAgO9gYQEAAIB5WFgAAABgHhYWAAAAmIeFBQAAAOZhYQEAAIB5WFgAAABgHhYWAAAAmIeFBQAAAOb58cLy+efvf3/f/V+d7+LOS59P55W+L+3rvj99+N19uPZz57XzVe9r56NynW/a//X7qbg+6jw375QvC0vp/NoHol3QtL8Kfdjqw7WfO6+dr3pfOx+V63zT/q/fT8X1Uee5ead8WVhK59c+EO2Cpv1V6MNWH6793HntfNX72vmoXOeb9n/9fiqujzrPzTvly8JSOr/2gWgXNO2vQh+2+nDt585r56ve185H5TrftP/r91NxfdR5bt4pXxaW0vm1D0S7oGl/Ffqw1YdrP3deO1/1vnY+Ktf5pv1fv5+K66POc/NO+bKwlM6vfSDaBU37q9CHrT5c+7nz2vmq97XzUbnON+3/+v1UXB91npt3ypeFpXR+7QPRLmjaX4U+bPXh2s+d185Xva+dj8p1vmn/1++n4vqo89y8U74sLKXzax+IdkHT/ir0YasP137uvHa+6n3tfFSu8037v34/FddHnefmnfJlYSmdX/tAtAua9lehD1t9uPZz57XzVe9r56NynW/a//X7qbg+6jw375QvC0vp/NoHol3QtL8Kfdjqw7WfO6+dr3pfOx+V63zT/q/fT8X1Uee5ead8WVhK59c+EO2Cpv1V6MNWH6793HntfNX72vmoXOeb9n/9fiqujzrPzTvly8JSOr/2gWgXNO2vQh+2+nDt585r56ve185H5TrftP/r91NxfdR5bt4pXxaW0vm1D0S7oGl/Ffqw1YdrP3deO1/1vnY+Ktf5pv1fv5+K66POc/NO+bKwlM6vfSDaBU37q9CHrT5c+7nz2vmq97XzUbnON+3/+v1UXB91npt3ypeFpXR+7QPRLmjaX4U+bPXh2s+d185Xva+dj8p1vmn/1++n4vqo89y8U74sLKXzax+IdkHT/ir0YasP137uvHa+6n3tfFSu8037v34/FddHnefmnfJlYSmdX/tAtAua9lehD1t9uPZz57XzVe9r56NynW/a//X7qbg+6jw375QvC0vp/NoHol3QtL8Kfdjqw7WfO6+dr3pfOx+V63zT/q/fT8X1Uee5ead8WVhK59c+EO2Cpv1V6MNWH6793HntfNX72vmoXOeb9n/9fiqujzrPzTvly8JSOr/2gWgXNO2vQh+2+nDt585r56ve185H5TrftP/r91NxfdR5bt4pXxaW0vm1D0S7oGl/Ffqw1YdrP3deO1/1vnY+Ktf5pv1fv5+K66POc/NO+bKwlM6vfSDaBU37q9CHrT5c+7nz2vmq97XzUbnON+3/+v1UXB91npt3ypeFpXR+7QPRLmjaX4U+bPXh2s+d185Xva+dj8p1vmn/1++n4vqo89y8U74sLKXzax+IdkHT/ir0YasP137uvHa+6n3tfFSu8037v34/FddHnefmnfJlYSmdX/tAtAua9lehD1t9uPZz57XzVe9r56NynW/a//X7qbg+6jw375QvC0vp/NoHol3QtL8Kfdjqw7WfO6+dr3pfOx+V63zT/q/fT8X1Uee5ead8WVhK59c+EO2Cpv1V6MNWH6793HntfNX72vmoXOeb9n/9fiqujzrPzTvly8JSOr/2gWgXNO2vQh+2+nDt585r56ve185H5TrftP/r91NxfdR5bt4pXxaW0vm1D0S7oGl/Ffqw1YdrP3deO1/1vnY+Ktf5pv1fv5+K66POc/NO+bKwlM6vfSDaBU37q9CHrT5c+7nz2vmq97XzUbnON+3/+v1UXB91npt3ypeFpXR+7QPRLmjaX4U+bPXh2s+d185Xva+dj8p1vmn/1++n4vqo89y8U74sLKXzax+IdkHT/ir0YasP137uvHa+6n3tfFSu8037v34/FddHnefmnfJlYSmdX/tAtAua9lehD1t9uPZz57XzVe9r56NynW/a//X7qbg+6jw375QvC0vp/NoHol3QtL8Kfdjqw7WfO6+dr3pfOx+V63zT/q/fT8X1Uee5ead8WVhK59c+EO2Cpv1V6MNWH6793HntfNX72vmoXOeb9n/9fiqujzrPzTvly8JSOr/2gWgXNO2vQh+2+nDt585r56ve185H5TrftP/r91NxfdR5bt4pXxaW0vm1D0S7oGl/Ffqw1YdrP3deO1/1vnY+Ktf5pv1fv5+K66POc/NO+bKwlM6vfSDaBU37q9CHrT5c+7nz2vmq97XzUbnON+3/+v1UXB91npt3ypeFpXR+7QPRLmjaX4U+bPXh2s+d185Xva+dj8p1vmn/1++n4vqo89y8U74sLKXzax+IdkHT/ir0YasP137uvHa+6n3tfFSu8037v34/FddHnefmnfL98cICAAAA8AoWFgAAAJiHhQUAAADmYWEBAACAeVhYAAAAYB4WFgAAAJiHhQUAAADmYWEBAACAeVhYAAAAYB4WFgAAAJiHhQUAAADmYWEBAACAeb4AKoM7OJCH/N4AAAAASUVORK5CYII=" style="width: 371px;">

    

      </div>

      <div class="col-md-4  text-center">

        <h4 ><u><b>{{$vehicle->vehicle_Number }} </b></u></h4>

      </div>

   <form action='{{url("downloadvehiclepdf/agreement/{$encrypt_id}")}}' method="GET"> 
   <div class="col-md-12">
        <div class="form-group">
        <label for="exampleInputEmail1" style="font-weight: bold;font-size: 14px;"> Select Date To Download Custom Dated Agreement</label>
        <input class="form-control datepicker" onfocus="date_format()" name="custom_date" data-date-format="dd/mm/yyyy" type="text" style="border: 2px solid #ccc; border-radius: 7px;padding: 4px;" required>
      </div>
      {{--<a class="btn btn-primary btn-sm dwn" href='{{url("downloadvehiclepdf/agreement/{$encrypt_id}")}}'><i class="fas fa-arrow-down"></i> Download Custom Dated Agreement</a>--}}
     <button class="btn btn-primary btn-sm dwn" type="submit"><i class="fas fa-arrow-down" ></i> Download Custom Dated Agreement</button>
      </div>
</form>
      </div>

      <hr>

    </div>

    



    

<div class="col-md-12 ">

<h4><u>Vehicle Details</u></h4>

<div class="row">

<div class="col-md-3">

<h6 class="fnt">Certificate Number On Agreement</h6>

<p> {{!empty($vehicle->agreement_Certification_no)?$vehicle->agreement_Certification_no:'---'}} </p>

</div>

 <div class="col-md-3">

 <h6 class="fnt">Agreement Start Date</h6>

 <p> {{!empty($vehicle->agreement_date)?date('d-m-Y',strtotime($vehicle->agreement_date)):'---'}} </p>

</div>

 <div class="col-md-3">

 <h6 class="fnt">Agreement End Date</h6>



  

 <p> {{!empty($vehicle->valid_upto)?date('d-m-Y',strtotime($vehicle->valid_upto)):'---'}} </p>



</div>

 <div class="col-md-3">

 <h6 class="fnt">Agreement Signee</h6>

 <p> {{!empty($vehicle->signee_Name)?$vehicle->signee_Name:'---'}} </p>

</div>

</div>

<div class="row">

 <div class="col-md-3">

 <h6 class="fnt">Signee Designation</h6>

 <p> {{!empty($vehicle->signee_Designation)?$vehicle->signee_Designation:'---'}} </p>



</div>

 <div class="col-md-3">

 <h6 class="fnt">Rate Per Km.</h6>

 <p> {{!empty($vehicle->rate_perkm)?$vehicle->rate_perkm:'---'}} </p>

</div>







<div class="col-md-3">

<h6 class="fnt">Road Tax Date</h6>

<p> {{!empty($vehicle->road_Tax_Date)?date('d-m-Y',strtotime($vehicle->road_Tax_Date)):'---'}} </p>

</div>

<div class="col-md-3">

 <h6 class="fnt">Road Tax Type</h6>



 <p> {{!empty($vehicle->road_Tax_Type)?$vehicle->road_Tax_Type:'---'}} </p>

</div>

</div>

<div class="row">

{{--<div class="col-md-3">

 <h6 class="fnt">Registration Number</h6>

 <p> {{!empty($vehicle->regs_Number)?$vehicle->regs_Number:'---'}} </p>

</div> --}}

<div class="col-md-3">

 <h6 class="fnt">Registration Date</h6>

 <p>{{!empty($vehicle->registration_Date)?date('d-m-Y',strtotime($vehicle->registration_Date)):'---'}} </p>

</div>



 <div class="col-md-3">

 <h6 class="fnt">Vehicle Type</h6>

 <p> {{!empty($vehicle_type)?$vehicle_type->vehicle_type:'---'}} </p>

</div>

 <div class="col-md-3">

 <h6 class="fnt">Vehicle Manufacturer</h6>

 <p> {{!empty($manufacturer)?$manufacturer->manufacturer:'---'}} </p>

</div>



<!--</div>-->



<!--<div class="row">-->

 <div class="col-md-3">

 <h6 class="fnt">Vehicle Model </h6>

<p> {{!empty($model)?$model->model:'---'}} </p>

</div>

 <div class="col-md-3">

 <h6 class="fnt">Policy Number</h6>

 <p> {{!empty($vehicle->vehicle_policy_no)?$vehicle->vehicle_policy_no:'----'}} </p>

</div>

 <div class="col-md-3">

 <h6 class="fnt">Policy Validity</h6>

 <p> {{!empty($vehicle->vehicle_policy_valid_upto)?date('d-m-Y',strtotime($vehicle->vehicle_policy_valid_upto)):'---'}} </p>

</div>



<div class="col-md-3">

 <h6 class="fnt">Enabled</h6>

 @if(4<3)

 <p><span class="tag tag tag-success">Yes</span></p>

 @else

 <p><span class="tag tag tag-danger">No</span></p>

 @endif

</div>

<!--</div>-->



<!--<div class="row">-->

<div class="col-md-3">

 <h6 class="fnt">Service Start Date</h6>

 <p> {{!empty($vehicle->service_Date)?date('d-m-Y',strtotime($vehicle->service_Date)):'---'}} </p>

</div>

<div class="col-md-3">

 <h6 class="fnt">Pollution Number</h6>

 <p> {{!empty($vehicle->vehicle_Pucc_no)?$vehicle->vehicle_Pucc_no:'---'}} </p>

</div>

<div class="col-md-3">

 <h6 class="fnt">Pollution Validity</h6>

 <p> {{!empty($vehicle->vehicle_Pucc_end)?date('d-m-Y',strtotime($vehicle->vehicle_Pucc_end)):'---'}} </p>

</div>

<div class="col-md-3">

 <h6 class="fnt">Fitness Validity</h6>

 <p> {{!empty($vehicle->fitness_Valid)?date('d-m-Y',strtotime($vehicle->fitness_Valid)):'---'}} </p>

</div>





<!--</div>-->

<!--<div class="row">-->

<div class="col-md-3">

 <h6 class="fnt">Owner's Name</h6>

 <p> {{!empty($vehicle->owner_Name)?$vehicle->owner_Name:'---'}} </p>

</div>

<div class="col-md-3">

 <h6 class="fnt">Owner's Father Name</h6>

 <p> {{!empty($vehicle->owner_Father)?$vehicle->owner_Father:'---'}} </p>

</div>

<div class="col-md-3">

 <h6 class="fnt">Owner's Contact Number</h6>

 <p> {{!empty($vehicle->owner_Contact)?$vehicle->owner_Contact:'---'}} </p>

</div>

<div class="col-md-3">

 <h6 class="fnt">Owner's Pan Number</h6>

 <p> {{!empty($vehicle->owner_Pan_Number)?$vehicle->owner_Pan_Number:'---'}} </p>

</div>





<!--</div>-->

<!--<div class="row">-->

  <div class="col-md-3">

    <h6 class="fnt">Owner's Address</h6>

    <p>{{!empty($vehicle->address_1)?$vehicle->address_1:'---'}}</p>

  </div>

  <div class="col-md-3">

    <h6 class="fnt">Helper Name</h6>

    <p>{{!empty($vehicle->helper_Name)?$vehicle->helper_Name:'---'}}</p>

  </div>

  <div class="col-md-3">

    <h6 class="fnt">Helper Contact</h6>

    <p>{{!empty($vehicle->helper_Contact)?$vehicle->helper_Contact:'---'}}</p>

  </div>

    <div class="col-md-3">

    <h6 class="fnt">Route Alloted</h6>

    <p>{{!empty($vehicle->route)?$vehicle->route:'---'}}</p>

  </div>

<!--</div>-->

<!--<div class="row">-->



  <div class="col-md-3">

    <h6 class="fnt">Plant</h6>

 <p> {{!empty($plant)?$plant->name:'---'}} </p>

  </div>

  <div class="col-md-3">

    <h6 class="fnt">Security Deposit</h6>

    <p>******</p>

  </div>

  <div class="col-md-3">

    <h6 class="fnt">Contract Rent</h6>

    <p>******</p>

  </div>

    <div class="col-md-3">

    <h6 class="fnt">Dues</h6>

    <p>*****</p>

  </div>

<!--</div>-->

<!--<div class="row">-->



  <div class="col-md-3">

    <h6 class="fnt">Created On</h6>

    <p>{{!empty($vehicle->created_at)?date('d-m-Y',strtotime($vehicle->created_at)):'---'}}</p>

  </div>

  <div class="col-md-3">

    <h6 class="fnt">Created By</h6>

    <p>{{!empty($vehicle->created_by)?$vehicle->created_by:'---'}}</p>

  </div>

  <div class="col-md-3">

    <h6 class="fnt">Vehicle Comments</h6>

    <p>{{!empty($vehicle->vehicle_Comment)?$vehicle->vehicle_Comment:'---'}}</p>

  </div>



</div>



  

</div>

</div> 

    </div>

  </div>

    <!-- Optional JavaScript -->

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

    <script>

      function myFunction() {

    window.print();

}



  function showCertificate(){

    //   window.location.reload()

       document.getElementById("certificateissuebtn").style.display="none";

      document.getElementById("certificatebtn").style.display="block";

  }

    </script>
    // <script>
    // function empty() {
    //   if (document.getElementById('custom_date').value == '') {
    //     alert("Please Enter a Date");
    //   }
    //   else if (document.getElementById('custom_date').value != '') {
    //     alert("Download pdf");
    //   }
    //   else {
    //       alert('check');
    //   }
      
    // }
    // </script>

  <script src="{{asset('/js/pdf/fstdropdown.js')}}"></script>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    {{-- for datepicker  --}}
    <script src="{{ asset('theme/bower_components/jquery/js/jquery.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/jquery-ui.min.js') }}"></script>
    <script>
         $(document).ready( function() {
                  $(".datepicker").datepicker({
        dateFormat:"dd-mm-yy"
    });
                    date_format();
  } ) 


    

      var isShift = false;
    var seperator = "-";
    // window.onload = function () {
        function date_format(){
        //Reference the Table.
        var tblForm = document.getElementById("tblForm");
 
        //Reference all INPUT elements in the Table.
        var inputs = document.getElementsByClassName("datepicker");
        // console.log(inputs);
        //Loop through all INPUT elements.
        for (var i = 0; i < inputs.length; i++) {
            //Check whether the INPUT element is TextBox.
            if (inputs[i].type == "text") {
                //Check whether Date Format Validation is required.
                if (inputs[i].className.indexOf("datepicker") != 1) {
                       
                    //Set Max Length.
                    inputs[i].setAttribute("maxlength", 10);
 
                    //Only allow Numeric Keys.
                    inputs[i].onkeydown = function (e) {
                        return IsNumeric(this, e.keyCode);
                    };
 
                    //Validate Date as User types.
                    inputs[i].onkeyup = function (e) {
                        ValidateDateFormat(this, e.keyCode);
                    };
                }
            }
        }
    };
 
    function IsNumeric(input, keyCode) {
        if (keyCode == 16) {
            isShift = true;
        }
        //Allow only Numeric Keys.
        if (((keyCode >= 48 && keyCode <= 57) || keyCode == 8 || keyCode <= 37 || keyCode <= 39 || (keyCode >= 96 && keyCode <= 105)) && isShift == false) {
            if ((input.value.length == 2 || input.value.length == 5) && keyCode != 8) {
                input.value += seperator;
            }
 
            return true;
        }
        else {
            return false;
        }
    };
 
    function ValidateDateFormat(input, keyCode) {
        var dateString = input.value;
        if (keyCode == 16) {
            isShift = false;
        }
        var regex = /(((0|1)[0-9]|2[0-9]|3[0-1])\/(0[1-9]|1[0-2])\/((19|20)\d\d))$/;
 
        //Check whether valid dd/MM/yyyy Date Format.
        if (regex.test(dateString) || dateString.length == 0) {
            ShowHideError(input, "none");
        } else {
            ShowHideError(input, "block");
        }
    };
    </script>
  </body>

</html>