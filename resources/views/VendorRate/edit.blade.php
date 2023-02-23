@extends('layouts.panel')

@section('content')
<div class="pcoded-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header card"  id="grv_margin">
                <div class="row first_row_margin">
                    <div class="col-lg-8">
                        <div class="page-header-title">
                            <i class=" far fa-building mr-2"></i>
                            <div class="d-inline">
                                <h5>Add vendor Rate</h5>
                                <p class="heading_Bottom">Create New Vendor Rate</p>
                            </div>
                        </div>
                  </div>
                  <div class="col-lg-4">
                <div class="page-header-breadcrumb">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="../home"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="../home">Dashboard Analytics</a> </li>
                    </ul>
                </div>
                </div>
</div>
 <div class="container-fluid bg-white mt-2 mb-3 border_radius box">
<div class="row">
<div class="col-md-12 mt-3 mb-3">
  @php
    $encrypted_id = encrypt($data->id);
  @endphp
<form action="{{route('VendorRateMaster.update' , $encrypted_id)}}" method="POST">
  @method('patch')
    @csrf
<div class="container-fluid">
    <div class="row first_row_margin">
         <div class="col-md-6">
    <h2 class="form-control-sm yash_heading form_style"><i class="far fa-building mr-2"></i><b>Designation Information</b></h2>
      </div>
       <div class="col-md-6" style="text-align:right;">
                  <a class="btn btn-link btn-primary" data-toggle="collapse" data-target="#collapseExample" aria-expanded="true" aria-controls="collapseExample" style="margin-top: 10px;">        
                  <i class="fa" aria-hidden="true"></i></a>            
                  </div>
                </div> 
      <hr class="border-dark bold"> 
<div class="row">
    <div class="col-md-2">
        <label>From Date</label>
        <input type="text" value="{{ !empty($data->from_date) ? date('d-m-Y' , strtotime($data->from_date)) : '' }}" placeholder="From Date" name="from_date" class="form-control datepicker">
    </div>              
    <div class="col-md-2">
        <label>To Date</label>
        <input type="text" value="{{ !empty($data->to_date) ? date('d-m-Y' , strtotime($data->to_date)) : '' }}" name="to_date" placeholder="To Date" class="form-control datepicker">
    </div>
    <div class="col-md-2">
        <label>Vendor</label>
        <select id="vendor" class="fstdropdown-select" name="vendor">
            <option value="">Select</option>
            @if(!empty($vendors))
                @foreach($vendors as $key => $value)
                    @if($key == $data->vendor)
                    <option selected="true" value="{{$key}}">{{$value}}</option>
                    @else
                    <option value="{{$key}}">{{$value}}</option>
                    @endif
                @endforeach
            @endif
        </select>
    </div>
    <div class="col-md-2">
        <label>Site</label>
        <select id="vendor" class="fstdropdown-select" name="site">
            <option value="">Select</option>
            @if(!empty($sites))
                @foreach($sites as $key => $value)
                    @if($key == $data->site)
                    <option selected="true" value="{{$key}}">{{$value}}</option>
                    @else
                    <option value="{{$key}}">{{$value}}</option>
                    @endif
                @endforeach
            @endif
        </select>
    </div>        
  <div class="col-md-2">
     <label>  Rate / Ton </label>
     <input type="text" value="{{ !empty($data->rate_ton) ? $data->rate_ton : '' }}" name="rate_ton" id="rate_ton" placeholder="Enter Rate / Ton" onkeypress='return restrictAlphabets(event)' class="form-control " >
   </div>
 </div>

   <div class="col-md-3 mb-3 px-3">
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
    Save Changes
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
 <svg xmlns="" version="1.1">
  <defs>
    <filter id="goo">
      <feGaussianBlur in="SourceGraphic" result="blur" stdDeviation="10"></feGaussianBlur>
      <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0 0 1 0 0 0 0 0 1 0 0 0 0 0 21 -7" result="goo"></feColorMatrix>
      <feBlend in2="goo" in="SourceGraphic" result="mix"></feBlend>
    </filter>
  </defs>
</svg> 
<!-- Close Row -->
</div>
<!-- Close Container -->
</div>


@endsection
