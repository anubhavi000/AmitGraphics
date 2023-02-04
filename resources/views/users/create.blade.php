
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
                                <h5>Add users</h5>
                                <p class="heading_Bottom">Create New User</p>
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
<!-- <div class="container">
 <div class="row">
  <div class="col-md-6">
    <h3>Add Designation</h3>
    <p class="heading_Bottom"><i class="far fa-building mr-2"></i> Create New Designation</p>
    </div> -->
</div>
 <div class="container-fluid bg-white mt-2 mb-3 border_radius box">
<div class="row">
<div class="col-md-12 mt-3 mb-3">
<form action="{{route('Users.store')}}" method="POST">
    @csrf
<div class="container-fluid">
    <div class="row first_row_margin">
        <div class="col-md-6">
    <h2 class="form-control-sm yash_heading form_style"><i class="far fa-building mr-2"></i><b>User Information</b></h2>
      </div>
       <div class="col-md-6" style="text-align:right;">
                  <a class="btn btn-link btn-primary" data-toggle="collapse" data-target="#collapseExample" aria-expanded="true" aria-controls="collapseExample" style="margin-top: 10px;">        
                  <i class="fa" aria-hidden="true"></i></a>            
                  </div>
                </div> 
      <hr class="border-dark bold">

   <div class="form-row mt-3 mb-3 collapse show" id="collapseExample">
   
    <div class="col-md-3">
        <label for="vehicle_no" class="yash_star">Name</label>
        <input type="text" name="name" id="vehicle_no" class="form-control " placeholder="Enter user Name" required>
    </div>
    <div class="col-md-3">
        <label for="item_Name" class="yash_star">Email</label>
        <input type="text" name="email" id="item_Name" class="form-control" placeholder="Enter Email" required>
    </div>
    <div class="col-md-3">
      <label for="item_Name" class="yash_star">Password</label>
      <input type="text" name="password" id="vehicle_pass"   class="form-control" placeholder="Enter Password" required>
  </div>
      <div class="col-md-3">
      
      <label for="">Site</label>
      <br>
      <select  class="fstdropdown-select col-md-3" name="site" id="" required="true">
        <option value="">Select</option>
        @if(!empty($sites))
        @foreach ($sites as $key => $value)
          <option value="{{$key}}">{{$value}}</option>
        @endforeach
        @endif
      </select>
    </div> 
      <div class="col-md-3 mt-3">
      
      <label for="">Designation</label>
      <br>
      <select  class="fstdropdown-select col-md-3" name="designation_id" id="" required="true">
        <option value="">Select</option>
        @if(!empty($designations))
        @foreach ($designations as $key => $value)
          <option value="{{$key}}">{{$value}}</option>
        @endforeach
        @endif
      </select>
    </div> 

    <div id="infodiv" class="col-md-3">

    </div> 
   <div class="col-md-12" style="text-align: right;">
  <hr class="mt-3 border-dark bold">

  @php
   $defaulturl= "Users";   
  @endphp

 <button class="blob-btn"  id="cancelbtn"   
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
@section('js')
@endsection  
