@extends('layouts.panel')

@section('content')
<div class="pcoded-content">
  <!-- [ breadcrumb ] start -->
  <div class="page-header card" id="grv_margin">

    <div class="row">
      <div class="col-lg-8">
        <div class="page-header-title">
          <i class="fas fa-map-signs mr-2"></i>
          <div class="d-inline">
            <h5>Update Vehicle</h5>
            <p class="heading_Bottom">Update Vehicle Record</p>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid bg-white mt-2 mb-3 border_radius box">
      <div class="row">
        <div class="col-md-12 mt-3 mb-3">
          <form action="{{route('Vehicle.update' , $vehicle_info->id)}}" method="post">
            @csrf
            @method('patch')
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
                  <input value="{{$vehicle_info->vehicle_Number}}" type="text" name="vehicle_Number" id="vehicle_Number" class="form-control" placeholder="Vehicle Number" data-toggle="tooltip" data-placement="bottom" required>
                  <!-- <p class="heading_Bottom">Please Enter Your Vehicle Number Carefully</p> -->
                </div>
                <div class="col-md-3">
                  <label style="margin-bottom:0px" for="vehicle_Type" class="yash_star">Vehicle Type</label>
                  <select class="form-control fstdropdown-select" id="vehicle_Type" name="vehicle_Type" required>
                  <option value="">Select</option>
                    @foreach($vehicle_type as $vehicletype)
                    @if($vehicle_info->vehicle_Type==$vehicletype->id)
                    <option selected value="{{$vehicletype->id}}">{{$vehicletype->vehicle_type }}</option>
                    @else
                    <option  value="{{$vehicletype->id}}">{{$vehicletype->vehicle_type }}</option>
                    @endif
                    @endforeach

                  </select>
                </div>
              
                <div class="col-md-3">
                  <label style="margin-bottom:0px" for="manufacturer" class="yash_star">Manufacturer</label>
                  <select class="form-control fstdropdown-select" id="manufacturer" name="manufacturer" required>
                    <option value="">select</option>
                    @foreach($manufacturer as $menuf)
                    @if($menuf->id==$vehicle_info->manufacturer)
                    <option selected value="{{$menuf->id}}">{{$menuf->manufacturer}}</option>
                    @else
                    <option value="{{$menuf->id}}">{{$menuf->manufacturer}}</option>
                    @endif
                    @endforeach

                  </select>
                </div>
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="model" class="yash_star">Model</label>
                 <select class="form-control fstdropdown-select" id="model" name="model" required>
                    <option value="">Select</option>
                    @foreach($models as $model)
                    @if($model->id==$vehicle_info->model)
                    <option selected value="{{$model->id}}">{{$model->model}}</option>
                    @else
                       <option  value="{{$model->id}}">{{$model->model}}</option>
                       @endif
                    @endforeach

                  </select>
                </div>
                
                        <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="fitness_Valid">GPS Device IMEI Number</label>
                  <input type="text" value="{{$vehicle_info->gps_device_imei_number}}" name="gps_device_imei_number" id="" class="form-control" data-toggle="tooltip" data-placement="bottom" >
                 
                </div>
                
                
                <div class="col-md-3 px-3">
                  <label style="margin-bottom:0px" for="onBoard" class="yash_star">On Board?</label>
                  <select class="form-control fstdropdown-select" id="onBoard" name="onBoard" required>
                    <option value="">select</option>
                    @if($vehicle_info->onBoard==1)
                    <option value="1" selected>YES</option>
                    <option value="0">NO</option>
                    @elseif($vehicle_info->onBoard==0)
                    <option value="1" >YES</option>
                    <option value="0" selected>NO</option>
                    @else
                    <option value="1" >YES</option>
                    <option value="0" >NO</option>
                    @endif
                  </select>
                </div>
               
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="vehicle_policy_no">Vehicle Insurance policy No </label>
                  <input value="{{$vehicle_info->vehicle_policy_no}}" type="text" name="vehicle_policy_no" id="vehicle_policy_no" class="form-control" placeholder="Vehicle Insurance policy No." data-toggle="tooltip" data-placement="bottom"  >
                  <!-- <p class="heading_Bottom">Please Enter Vehicle Insurance Policy Number</p> -->
                </div>
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="vehicle_policy_valid_upto">Vehicle Insurance policy Validity </label>
                  <input value="{{!empty($vehicle_info->vehicle_policy_valid_upto)?date('d-m-Y',strtotime($vehicle_info->vehicle_policy_valid_upto)):''}}" type="text" name="vehicle_policy_valid_upto" id="vehicle_policy_valid_upto" class="form-control datepicker" placeholder="Vehicle Insurance policy Validity." data-toggle="tooltip" data-placement="bottom" >
                  <!-- <p class="heading_Bottom">Date on that day Insurance Policy End</p> -->
                </div>
                   <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="fitness_Valid">Fitness Validity</label>
                  <input value="{{!empty($vehicle_info->fitness_Valid)?date('d-m-Y',strtotime($vehicle_info->fitness_Valid)):''}}" type="text" name="fitness_Valid" id="fitness_Valid" class="form-control datepicker" data-toggle="tooltip" data-placement="bottom"  >
                  <!-- <p class="heading_Bottom">Date on that day Fitness Validity End</p> -->
                </div>
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="vehicle_pucc_no">Vehicle PUCC No </label>
                  <input value="{{$vehicle_info->vehicle_Pucc_no}}" type="text" name="vehicle_Pucc_no" id="vehicle_pucc_no" class="form-control" placeholder="Vehicle Pollution Number" data-toggle="tooltip" data-placement="bottom" >
                  <!-- <p class="heading_Bottom">Please Enter Vehicle PUCC Number</p> -->
                </div>
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="vehicle_Pucc_valid_end">Vehicle PUCC Validity </label>
                  <input value="{{!empty($vehicle_info->vehicle_Pucc_end)?(date('d-m-Y',strtotime($vehicle_info->vehicle_Pucc_end))):''}}" type="text" name="vehicle_Pucc_valid_end" id="vehicle_Pucc_valid_end" class="datepicker form-control" placeholder="Vehicle Pollution Validity" data-toggle="tooltip" data-placement="bottom"  >
                  <!-- <p class="heading_Bottom">Date on that day PUCC End </p> -->
                </div>
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="road_Tax_Date">Road Tax Date </label>
                  <input value="{{!empty($vehicle_info->road_Tax_Date)?(date('d-m-Y',strtotime($vehicle_info->road_Tax_Date))):''}}" type="text" name="road_Tax_Date" id="road_Tax_Date" class="datepicker form-control" placeholder="Vehicle Pollution Number" data-toggle="tooltip" data-placement="bottom"  >
                  <!-- <p class="heading_Bottom">Date of Road Tax</p> -->
                </div>
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="road_Tax_Type">Road Tax Type </label>
                  <select class="form-control fstdropdown-select" id="road_Tax_Type" name="road_Tax_Type" >
                    <option value="">Select</option>
                    @foreach($road_tax as $roadtax)
                    @if($vehicle_info->road_Tax_Type==$roadtax->id)
                    <option selected value="{{$roadtax->id}}">{{$roadtax->road_tax}}</option>
                    @else
                    <option value="{{$roadtax->id}}">{{$roadtax->road_tax}}</option>
                    @endif
                    @endforeach
                  </select>
                </div>
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="registration_Date">Registration Date </label>
                  <input value="{{!empty($vehicle_info->registration_Date)?(date('d-m-Y',strtotime($vehicle_info->registration_Date))):''}}" type="text" name="registration_Date" id="registration_Date" class="datepicker form-control" data-toggle="tooltip" data-placement="bottom" required>
                  <!-- <p class="heading_Bottom">Date of Road Tax</p> -->
                </div>
                    <div class="col-md-3 px-3 ">
                  <label style="margin-bottom:0px" for="service_Date" class="yash_star">Service Start Date</label>
                  <input value="{{!empty($vehicle_info->service_Date)?(date('d-m-Y',strtotime($vehicle_info->service_Date))):''}}" type="text" name="service_Date" id="service_Date" class="datepicker form-control" data-toggle="tooltip" data-placement="bottom"  required>
                  <!-- <p class="heading_Bottom">Date on that day service starts</p> -->
                </div>
                <div class="col-md-3 px-3">
                  <label style="margin-bottom:0px" for="fuel_Type" class="yash_star">Fuel Type</label>
                  <select class="form-control fstdropdown-select" id="fuel_Type" name="fuel_Type" required>
                 
                    <option value="">Select</option>
                    @foreach($fuel_type as $fuel_types)
                    @if($vehicle_info->fuel_Type==$fuel_types->id)
                    <option selected value="{{$fuel_types->id}}">{{$fuel_types->fuel_type}}</option>
                    @else
                    <option value="{{$fuel_types->id}}">{{$fuel_types->fuel_type}}</option>
                    @endif
                    @endforeach

                  </select>
                </div>
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="rate_perkm" class="yash_star">Rate Per Km</label>
                  <input value="{{$vehicle_info->rate_perkm}}" type="text" name="rate_perkm" id="rate_perkm" class="form-control" placeholder="Rate Per Km" required>
                </div>
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="route">Fixed Petrol Charges</label>
                  <input value="{{!empty($vehicle_info->fixed_petrol_charges)?$vehicle_info->fixed_petrol_charges:0}}" type="text" name="fixed_petrol_charges" id="fixed_petrol_charges" class="form-control" placeholder="Fixed Petrol Charges" data-toggle="tooltip" data-placement="bottom"  >
                </div>
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="signee_Name">Agreement Signee</label>
                  <input value="{{$vehicle_info->signee_Name}}" type="text" name="signee_Name" id="signee_Name" class="form-control" placeholder="Agreement Signee" data-toggle="tooltip" data-placement="bottom"  >
                  <!-- <p class="heading_Bottom">Person Signing Agreement On Synergy's Behalf</p> -->
                </div>
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="signee_Designation">Signee Designation</label>
                  <input value="{{$vehicle_info->signee_Designation}}" type="text" name="signee_Designation" id="signee_Designation" class="form-control" placeholder="Signee Designation" data-toggle="tooltip" data-placement="bottom"  >
                  <!-- <p class="heading_Bottom">Designation Of Signee</p> -->
                </div>
                 <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="agreement_date" class="yash_star">Agreement Start Date</label>
                  <input  value="{{!empty($vehicle_info->agreement_date)?(date('d-m-Y',strtotime($vehicle_info->agreement_date))):''}}" type="text" name="agreement_date" id="agreement_date" class="form-control datepicker" data-toggle="tooltip" data-placement="bottom"  required>
                  <!-- <p class="heading_Bottom">Date on that day Agreement Start</p> -->
                </div>
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="valid_upto" class="yash_star">Agreement End Date</label>
                  <input  value="{{!empty($vehicle_info->valid_upto)?(date('d-m-Y',strtotime($vehicle_info->valid_upto))):''}}" type="text" name="valid_upto" id="valid_upto" class="datepicker form-control" data-toggle="tooltip" data-placement="bottom" required>
                  <!-- <p class="heading_Bottom">Date on that day Agreement End</p> -->
                </div>
               
             
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="Agreement_Certification_no">Agreement Certificate Number</label>
                  <input value="{{$vehicle_info->agreement_Certification_no}}" type="text" name="Agreement_Certification_no" id="Agreement_Certification_no" class="form-control" placeholder="Certificate Number On Agreement" data-toggle="tooltip" data-placement="bottom"  >
                  <!-- <p class="heading_Bottom">E-Stamp Cerificate Number On Agreement  </p> -->
                </div>
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="e_stamp_Date">Certificate Date E-Stamp</label>
                  <input value="{{!empty($vehicle_info->e_stamp_Date)?(date('d-m-Y',strtotime($vehicle_info->e_stamp_Date))):''}}" type="text" name="e_stamp_Date" id="e_stamp_Date" class="datepicker form-control" data-toggle="tooltip" data-placement="bottom" >
                  <!-- <p class="heading_Bottom">Date of E Stamp Certificate Issue </p> -->
                </div>
                <div class="col-md-6 mb-3 px-3">
                  <label style="margin-bottom:0px" for="vehicle_Comment">Vehicle Comments</label>
                  <textarea class="form-control" id="vehicle_Comment" name="vehicle_Comment" rows="3" placeholder="Vehicle Comments">{{$vehicle_info->vehicle_Comment}}</textarea>
                </div>
                 <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="route">Route</label>
                  <input value="{{$vehicle_info->route}}" type="text" name="route" id="route" class="form-control" placeholder="Route" data-toggle="tooltip" data-placement="bottom"  >
                  <!-- <p class="heading_Bottom">Route on Which Vehicle Will Run </p> -->
                </div>
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="route">Executive</label>
                  <select name="executive_id" id="" class="chosen-select">
                    <option value="">Select</option>
                    @foreach($executives as $executive)
                    @if($vehicle_info->executive_id==$executive->id)
                    <option selected value="{{$executive->id}}">{{$executive->full_name}}</option>
                    @else
                    <option value="{{$executive->id}}">{{$executive->full_name}}</option>
                    @endif
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
                    @if($vehicle_info->plant_Type==$plants->id)
                    <option selected value="{{$plants->id}}">{{$plants->name}}</option>
                    @else
                    <option value="{{$plants->id}}">{{$plants->name}}</option>
                    @endif
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
                  <input value="{{$vehicle_info->owner_Name}}" type="text" name="owner_Name" id="owner_Name" class="form-control" placeholder="Owner Name" data-toggle="tooltip" data-placement="bottom" required>
                  <!-- <p class="heading_Bottom">Please Enter Vehicle Owner Name</p> -->
                </div>
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="owner_Father">Owner Father </label>
                  <input value="{{$vehicle_info->owner_Father}}" type="text" name="owner_Father" id="owner_Father" class="form-control" placeholder="Owner Father" data-toggle="tooltip" data-placement="bottom" >
                  <!-- <p class="heading_Bottom">Name of vehicle owner's father </p> -->
                </div>
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="owner_Contact">Owner Contact Number </label>
                  <input value="{{$vehicle_info->owner_Contact}}" type="text" name="owner_Contact" id="owner_Contact" class="form-control" placeholder="Owner Contact Number" maxlength="10" onkeypress="return /[0-9]/i.test(event.key)">
                </div>
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="owner_Pan_Number">Owner Pan Number </label>
                  <input value="{{$vehicle_info->owner_Pan_Number}}" type="text" name="owner_Pan_Number" id="owner_Pan_Number" class="form-control" placeholder="Owner Pan Number">
                </div>
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="address_1" class="yash_star">Address Line 1</label>
                  <input value="{{$vehicle_info->address_1}}" type="text" name="address_1" id="address_1" class="form-control" placeholder="Address Line 1" required>
                </div>
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="address_2">Address Line 2</label>
                  <input value="{{$vehicle_info->address_2}}" type="text" name="address_2" id="address_2" class="form-control" placeholder="Address Line 2">
                </div>
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="state">State </label>
                  <select class="form-control fstdropdown-select" id="state" name="state" required onchange="get_district(this.value)">
                    <option value="">Select</option>
                    @foreach ($state as $states)
                    @if($vehicle_info->state_id==$states->id)
                    <option selected value="{{$states->id}}">{{$states->states}}</option>
                    @else
                    <option value="{{$states->id}}">{{$states->states}}</option>
                    @endif
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
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="pincode">PinCode</label>
                  <input value="{{$vehicle_info->pincode}}" type="text" name="pincode" id="pincode" class="form-control" maxlength="6" onkeypress="return /[0-9]/i.test(event.key)" placeholder="XXXXXX" required>
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
                  <input value="{{$vehicle_info->driver_Name}}" type="text" name="driver_Name" id="driver_Name" class="form-control" placeholder="Driver Name">
                  
                </div>
                
                <div class="col-md-3 mb-3 px-3 ">
                  <label style="margin-bottom:0px" for="driver_contact">Driver Contact Number</label>
                  <input value="{{$vehicle_info->driver_Contact}}" type="text" name="driver_contact" id="driver_contact" class="form-control" placeholder="Driver Contact Number" maxlength="10" onkeypress="return /[0-9]/i.test(event.key)">
                </div>
                
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="helper_Name">Helper Name</label>
                  <input value="{{$vehicle_info->helper_Name}}" type="text" name="helper_Name" id="helper_Name" class="form-control" placeholder="Helper Name">
            
                </div>
                
                <div class="col-md-3 mb-3 px-3 ">
                  <label style="margin-bottom:0px" for="helper_Number">Helper Contact Number</label>
                  <input value="{{$vehicle_info->helper_Contact}}" type="text" name="helper_Number" id="helper_Number" class="form-control" placeholder="Helper Contact Number" maxlength="10" onkeypress="return /[0-9]/i.test(event.key)">
                </div>
                
                <div class="col-md-3 mb-3 px-3">
                  <label style="margin-bottom:0px" for="driver_Father">Driver Father</label>
                  <input value="{{$vehicle_info->driver_Father}}" type="text" name="driver_Father" id="driver_Father" class="form-control" placeholder="Driver Father">
                 
                </div>
                <div class="col-md-6 mb-3 px-3">
                  <label style="margin-bottom:0px" for="driver_Address">Driver Residence</label>
                  <textarea class="form-control" id="driver_Address" name="driver_Address" rows="3" placeholder="Driver Residence" style="height:40px;">{{$vehicle_info->driver_Address}}</textarea>
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

    <script>
     var state= document.getElementById('state').value;
                   
       var district= "<?php echo $vehicle_info->district_id; ?>" ;
 
       window.onload= function(){
         get_district(state , district);
       }
                    

       
        </script>

    @endsection