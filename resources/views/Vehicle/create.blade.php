@extends('layouts.panel')

@section('content')

<div class="pcoded-content">
  <!-- [ breadcrumb ] start -->
  <div class="page-header card" id="grv_margin">

    <!--<div class="row">-->
    <!--  <div class="col-lg-8">-->
    <!--    <div class="page-header-title">-->
    <!--      <i class="fas fa-map-signs mr-2"></i>-->
    <!--      <div class="d-inline">-->
    <!--        <h5>Add Vehicle</h5>-->
    <!--        <p class="heading_Bottom">Add New Vehicle</p>-->
    <!--      </div>-->
    <!--    </div>-->
    <!--  </div>-->
    <!--</div>-->
    <div class="container-fluid bg-white mt-2 mb-3 border_radius box">
      <div class="row">
        <div class="col-md-12 mt-3 mb-3">
          <form action="{{route('Vehicle.store')}}" method="post">
            @csrf
            <div class="container-fluid">
              <div class="row" style="margin-bottom:-11px">
                <div class="col-md-6">
                  <h2 class="form-control-sm yash_heading form_style"><i class="fas fa-truck mr-2"></i><b>Vehicle Details</b></h2>
                </div>
                <div class="col-md-6" style="text-align:right;">
                  <a class="btn btn-link btn-primary" data-toggle="collapse" data-target="#collapseExample" aria-expanded="true" aria-controls="collapseExample" style="margin-top: 10px;">
                    <i class="fa" aria-hidden="true"></i></a>
                </div>
              </div>
              <hr class="border-dark bold">
              <div class="form-row mt-3 mb-3 collapse show" id="collapseExample">
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="vehicle_Number" class="yash_star">Vehicle Number</label>
                  <input type="text" name="vehicle_Number" id="vehicle_Number" class="form-control" placeholder="Vehicle Number" data-toggle="tooltip" data-placement="bottom"  required>
                  <!-- <p class="heading_Bottom">Please Enter Your Vehicle Number Carefully</p> -->
                </div>
                <div class="col-md-3 px-3">
                  <label style="margin-bottom:0px" for="vehicle_Type" class="yash_star">Vehicle Type</label>
                  <select class="form-control fstdropdown-select" id="vehicle_Type" name="vehicle_Type" required>
                    <option value="">Select</option>
                    @foreach($vehicle_type as $vehicletype)
                    <option value="{{$vehicletype->id}}">{{$vehicletype->vehicle_type }}</option>
                    @endforeach
                  </select>
                </div>
               
                <div class="col-md-3 px-3">
                  <label style="margin-bottom:0px" for="manufacturer" class="yash_star">Manufacturer</label>
                  <select class="form-control fstdropdown-select" id="manufacturer" name="manufacturer" required>
                    <option value="">Select</option>
                    @foreach($manufacturer as $menuf)
                    <option value="{{$menuf->id}}">{{$menuf->manufacturer}}</option>
                    @endforeach

                  </select>
                </div>
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="model" class="yash_star">Model</label>
                  <select class="form-control fstdropdown-select" id="model" name="model" required>
                    <option value="">Select</option>
                    @foreach($models as $model)
                    <option value="{{$model->id}}">{{$model->model}}</option>
                    @endforeach

                  </select>
                 
                </div>
                     <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="fitness_Valid">GPS Device IMEI Number</label>
                  <input type="text" name="gps_device_imei_number" id="" class="form-control" data-toggle="tooltip" data-placement="bottom" >
                 
                </div>
                
                <div class="col-md-3 px-3">
                  <label style="margin-bottom:0px" for="onBoard" class="yash_star">On Board?</label>
                  <select class="form-control fstdropdown-select" id="onBoard" name="onBoard" required>
                    <option value="">select</option>
                    <option value="1">YES</option>
                    <option value="0">NO</option>
                  </select>
                </div>
               
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="vehicle_policy_no">Vehicle Insurance policy No </label>
                  <input type="text" name="vehicle_policy_no" id="vehicle_policy_no" class="form-control" placeholder="Vehicle Insurance policy No." data-toggle="tooltip" data-placement="bottom" >
                  <!-- <p class="heading_Bottom">Please Enter Vehicle Insurance Policy Number</p> -->
                </div>
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="vehicle_policy_valid_upto">Vehicle Insurance policy Validity </label>
                  <input type="text" name="vehicle_policy_valid_upto" id="vehicle_policy_valid_upto" class=" datepicker form-control" onfocus="date_format()" placeholder="Vehicle Insurance policy Validity." data-toggle="tooltip" data-placement="bottom"  >
                  <!-- <p class="heading_Bottom">Date on that day Insurance Policy End</p> -->
                </div>
                  <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="fitness_Valid">Fitness Validity</label>
                  <input type="text" name="fitness_Valid" id="fitness_Valid" class="form-control datepicker" data-toggle="tooltip" data-placement="bottom"  >
                  <!-- <p class="heading_Bottom">Date on that day Fitness Validity End</p> -->
                </div>
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="vehicle_pucc_no">Vehicle PUCC No </label>
                  <input type="text" name="vehicle_Pucc_no" id="vehicle_pucc_no" class="form-control" placeholder="Vehicle Pollution Number" data-toggle="tooltip" data-placement="bottom" >
                  <!-- <p class="heading_Bottom">Please Enter Vehicle PUCC Number</p> -->
                </div>
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="vehicle_Pucc_valid_end">Vehicle PUCC Validity </label>
                  <input type="text" name="vehicle_Pucc_valid_end" id="vehicle_Pucc_valid_end" class="form-control datepicker" placeholder="Vehicle Pollution Validity" data-toggle="tooltip" data-placement="bottom" >
                  <!-- <p class="heading_Bottom">Date on that day PUCC End </p> -->
                </div>
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="road_Tax_Date">Road Tax Date </label>
                  <input type="text" name="road_Tax_Date" id="road_Tax_Date" class="form-control datepicker" placeholder="Vehicle Pollution Number" data-toggle="tooltip" data-placement="bottom" >
                  <!-- <p class="heading_Bottom">Date of Road Tax</p> -->
                </div>
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="road_Tax_Type">Road Tax Type </label>
                  <select class="form-control fstdropdown-select" id="road_Tax_Type" name="road_Tax_Type" >
                  <option value="">Select</option>
                    @foreach($road_tax as $roadtax)
                    <option value="{{$roadtax->id}}">{{$roadtax->road_tax}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="registration_Date">Registration Date </label>
                  <input type="text" name="registration_Date" id="registration_Date" class="form-control datepicker" data-toggle="tooltip" data-placement="bottom"  >
                  <!-- <p class="heading_Bottom">Date of Road Tax</p> -->
                </div>
                  <div class="col-md-3 px-3 ">
                  <label style="margin-bottom:0px" for="service_Date" class="yash_star">Service Start Date</label>
                  <input type="text" name="service_Date" id="service_Date" class="form-control datepicker" data-toggle="tooltip" data-placement="bottom"  required>
                  <!-- <p class="heading_Bottom">Date on that day service starts</p> -->
                </div>
                <div class="col-md-3 px-3">
                  <label style="margin-bottom:0px" for="fuel_Type" class="yash_star">Fuel Type</label>
                  <select class="form-control fstdropdown-select" id="fuel_Type" name="fuel_Type" required>
                  <option value="">Select</option>
                    @foreach($fuel_type as $fuel_types)
                    <option value="{{$fuel_types->id}}">{{$fuel_types->fuel_type}}</option>
                    @endforeach

                  </select>
                </div>
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="rate_perkm" class="yash_star">Rate Per Km</label>
                  <input type="text" name="rate_perkm" id="rate_perkm" class="form-control" placeholder="Rate Per Km" required>
                </div>
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="route">Fixed Petrol Charges</label>
                  <input type="text" name="fixed_petrol_charges" id="fixed_petrol_charges" class="form-control" placeholder="Fixed Petrol Charges" data-toggle="tooltip" data-placement="bottom"  >
                </div>
                
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="signee_Name">Agreement Signee</label>
                  <input type="text" name="signee_Name" id="signee_Name" class="form-control" placeholder="Agreement Signee" data-toggle="tooltip" data-placement="bottom"  >
                  <!-- <p class="heading_Bottom">Person Signing Agreement On Synergy's Behalf</p> -->
                </div>
                 <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="signee_Designation">Signee Designation</label>
                  <input type="text" name="signee_Designation" id="signee_Designation" class="form-control" placeholder="Signee Designation" data-toggle="tooltip" data-placement="bottom" >
                  <!-- <p class="heading_Bottom">Designation Of Signee</p> -->
                </div>
                 <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="agreement_date" class="yash_star">Agreement Start Date</label>
                  <input type="text" name="agreement_date" id="agreement_date" class="form-control datepicker" data-toggle="tooltip" data-placement="bottom" required>
                  <!-- <p class="heading_Bottom">Date on that day Agreement Start</p> -->
                </div>
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="valid_upto" class="yash_star">Agreement End Date</label>
                  <input type="text" name="valid_upto" id="valid_upto" class="form-control datepicker" data-toggle="tooltip" data-placement="bottom" required>
                  <!-- <p class="heading_Bottom">Date on that day Agreement End</p> -->
                </div>
                 <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="Agreement_Certification_no">Agreement Certificate Number</label>
                  <input type="text" name="Agreement_Certification_no" id="Agreement_Certification_no" class="form-control" placeholder="Certificate Number On Agreement" data-toggle="tooltip" data-placement="bottom"  >
                  <!-- <p class="heading_Bottom">E-Stamp Cerificate Number On Agreement  </p> -->
                </div>
                
               
             
              
               
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="e_stamp_Date">Certificate Date E-Stamp</label>
                  <input type="text" name="e_stamp_Date" id="e_stamp_Date" class="form-control datepicker" data-toggle="tooltip" data-placement="bottom" >
                  <!-- <p class="heading_Bottom">Date of E Stamp Certificate Issue </p> -->
                </div>
                <div class="col-md-6 mb-3 px-3">
                  <label style="margin-bottom:0px" for="vehicle_Comment">Vehicle Comments</label>
                  <textarea class="form-control" id="vehicle_Comment" name="vehicle_Comment" rows="3" placeholder="Vehicle Comments"></textarea>
                </div>
                   <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="route">Route</label>
                  <input type="text" name="route" id="route" class="form-control" placeholder="Route" data-toggle="tooltip" data-placement="bottom"  >
                 
                </div>
                   <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="route">Executive</label>
                  <select name="executive_id" id="" class="chosen-select">
                    <option value="">Select</option>
                    @foreach($executives as $executive)
                    <option value="{{$executive->id}}">{{$executive->full_name}}</option>
                    @endforeach
                  </select>
                </div>
                
              </div>
            </div>
            <div class="container-fluid">
              <div class="row" style="margin-bottom:-11px">
                <div class="col-md-6">
                  <h2 class="form-control-sm yash_heading form_style"><i class="fas fa-database mr-2"></i><b>Plant Information</b></h2>
                </div>
                <div class="col-md-6" style="text-align:right;">
                  <a class="btn btn-link btn-primary collapsed" data-toggle="collapse" data-target="#collapseExample1" aria-expanded="true" aria-controls="collapseExample" style="margin-top: 10px;">
                    <i class="fa" aria-hidden="true"></i></a>
                </div>
              </div>
              <hr class="border-dark bold">
              <div class="form-row mt-3 mb-3 collapse" id="collapseExample1">
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="plant_Type">Plant</label>
                  <select class="form-control fstdropdown-select" id="plant_Type" name="plant_Type" >
                  <option value="">Select</option>
                    @foreach($plant as $plants)
                    <option value="{{$plants->id}}">{{$plants->name}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="container-fluid">
              <div class="row" style="margin-bottom:-11px">
                <div class="col-md-6">
                  <h2 class="form-control-sm yash_heading form_style"><i class="fas fa-address-book mr-2"></i><b>Owner Details</b></h2>
                </div>
                <div class="col-md-6" style="text-align:right;">
                  <a class="btn btn-link btn-primary collapsed" data-toggle="collapse" data-target="#collapseExample2" aria-expanded="true" aria-controls="collapseExample" style="margin-top: 10px;">
                    <i class="fa" aria-hidden="true"></i></a>
                </div>
              </div>
              <hr class="border-dark bold">
              <div class="form-row mt-3 mb-3 collapse" id="collapseExample2">
                   <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="owner_Name" class="yash_star">Owner Name </label>
                  <input type="text" name="owner_Name" id="owner_Name" class="form-control" placeholder="Owner Name" data-toggle="tooltip" data-placement="bottom"  required>
                  <!-- <p class="heading_Bottom">Please Enter Vehicle Owner Name</p> -->
                </div>
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="owner_Father">Owner Father </label>
                  <input type="text" name="owner_Father" id="owner_Father" class="form-control" placeholder="Owner Father" data-toggle="tooltip" data-placement="bottom"  >
                  <!-- <p class="heading_Bottom">Name of vehicle owner's father </p> -->
                </div>
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="owner_Contact">Owner Contact Number </label>
                  <input type="text" name="owner_Contact" id="owner_Contact" class="form-control" placeholder="Owner Contact Number" maxlength="10" onkeypress="return /[0-9]/i.test(event.key)">
                </div>
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="owner_Pan_Number">Owner Pan Number </label>
                  <input type="text" name="owner_Pan_Number" id="owner_Pan_Number" class="form-control" placeholder="Owner Pan Number">
                </div>
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="address_1" class="yash_star">Address Line 1</label>
                  <input type="text" name="address_1" id="address_1" class="form-control" placeholder="Address Line 1" required>
                </div>
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="address_2">Address Line 2</label>
                  <input type="text" name="address_2" id="address_2" class="form-control" placeholder="Address Line 2">
                </div>
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="state">State </label>
                  <select class="form-control fstdropdown-select" name="state" required onchange="get_district(this.value)">
                    <option value="">Select</option>
                    @foreach ($state as $state)
                    <option value="{{$state->id}}">{{$state->states}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-3 mb-3 px-3" id="districtDropdownHere">
                  <label style="margin-bottom:0px" for="district_name">District</label>
                  <select class="form-control fstdropdown-select" id="district_name" name="district_name" >
                    <option value="">Select </option>
                    <!-- Dropdown List Option -->
                  </select>
                </div>
                <!--<div class="col-md-3 mb-3 px-3">-->
                <!--  <label style="margin-bottom:0px" for="city" class="yash_star">City</label>-->
                <!--  <input type="text" name="city" id="city" class="form-control" placeholder="Enter City Here" required>-->
                <!--</div>-->
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="pincode">PinCode</label>
                  <input type="text" name="pincode" id="pincode" class="form-control" maxlength="6" onkeypress="return /[0-9]/i.test(event.key)" placeholder="XXXXXX" required>
                </div>
              </div>
            </div>
            <div class="container-fluid">
              <div class="row" style="margin-bottom:-11px">
                <div class="col-md-6">
                  <h2 class="form-control-sm yash_heading form_style"><i class="fas fa-truck mr-2"></i>Driver Details</h2>
                </div>
                <div class="col-md-6" style="text-align:right;">
                  <a class="btn btn-link btn-primary collapsed" data-toggle="collapse" data-target="#collapseExample3" aria-expanded="true" aria-controls="collapseExample" style="margin-top: 10px;">
                    <i class="fa" aria-hidden="true"></i></a>
                </div>
              </div>
              <hr class="border-dark bold">
              <div class="form-row mt-3 mb-3 collapse" id="collapseExample3">
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="driver_Name">Driver Name</label>
                  <input type="text" name="driver_Name" id="driver_Name" class="form-control" placeholder="Driver Name">
                
                </div>
                <div class="col-md-3 mb-3 px-3 ">
                  <label style="margin-bottom:0px" for="driver_contact">Driver Contact Number</label>
                  <input type="text" name="driver_contact" id="driver_contact" class="form-control" placeholder="Driver Contact Number" maxlength="10" onkeypress="return /[0-9]/i.test(event.key)">
                </div>
                
                
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="helper_Name">Helper Name</label>
                  <input type="text" name="helper_Name" id="helper_Name" class="form-control" placeholder="Helper Name">
              
                </div>
                
                <div class="col-md-3 mb-3 px-3 ">
                  <label style="margin-bottom:0px" for="helper_Number">Helper Contact Number</label>
                  <input type="text" name="helper_Number" id="helper_Number" class="form-control" placeholder="Helper Contact Number" maxlength="10" onkeypress="return /[0-9]/i.test(event.key)">
                </div>
                
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="driver_Father">Driver Father</label>
                  <input type="text" name="driver_Father" id="driver_Father" class="form-control" placeholder="Driver Father">
               
                </div>
                <div class="col-md-6 mb-3 px-3">
                  <label style="margin-bottom:0px" for="driver_Address">Driver Residence</label>
                  <textarea class="form-control" id="driver_Address" name="driver_Address" rows="3" placeholder="Driver Residence" style="height:40px;"></textarea>
                </div>
                
                

                <div class="col-md-12" style="text-align: right;">
                  <hr class="mt-3 border-dark bold">

                  <button class="blob-btn" id="cancelbtn"  action="action"
    
    type="button"><i class="fas fa-times pr-2"></i>
    Cancel
                    <span class="blob-btn__inner">
                      <span class="blob-btn__blobs">
                        <span class="blob-btn__blob"></span>
                        <span class="blob-btn__blob"></span>
                        <span class="blob-btn__blob"></span>
                        <span class="blob-btn__blob"></span>
                      </span>
                    </span>
                  </button>
                  <button  id="submitbtn" type="submit" class="blob-btn1"><i class="fas fa-check pr-2"></i>
                    Submit
                    <span class="blob-btn__inner1">
                      <span class="blob-btn__blobs1">
                        <span class="blob-btn__blob1"></span>
                        <span class="blob-btn__blob1"></span>
                        <span class="blob-btn__blob1"></span>
                        <span class="blob-btn__blob1"></span>
                      </span>
                    </span>
                  </button>
                </div>
              </div>
            </div>
          </form>
        </div>
        <!-- Close Row -->
        <svg xmlns="" version="1.1">
          <defs>
            <filter id="goo">
              <feGaussianBlur in="SourceGraphic" result="blur" stdDeviation="10"></feGaussianBlur>
              <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0 0 1 0 0 0 0 0 1 0 0 0 0 0 21 -7" result="goo"></feColorMatrix>
              <feBlend in2="goo" in="SourceGraphic" result="mix"></feBlend>
            </filter>
          </defs>
        </svg>
      </div>
      <!-- Close Container -->
    </div>


    

    @endsection
    @section('js')
    <script type="text/javascript">
     
    </script>
    @endsection