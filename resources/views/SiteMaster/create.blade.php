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
                                <h5>Add Sites</h5>
                                <p class="heading_Bottom">Create New unloading Place ( Site )</p>
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
<form action="{{route('SiteMaster.store')}}" method="POST">
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

   <div class="form-row mt-3 mb-3 collapse show" id="collapseExample">
   <div class="col-md-3 mb-3 px-3">
     <label for="item_Name" class="yash_star"> Site Name </label>
     <input type="text" name="name" id="site_name" class="form-control client_margin" placeholder="Enter Site Name" required>
   </div>
     <div class="col-md-3 mb-3 px-3">
     <label for="item_Name" class="yash_star"> Address </label>
     <input type="text" name="address" id="address" class="form-control client_margin" placeholder="Enter Site Address" required>
   </div>
     <div class="col-md-3 mb-3 px-3">
     <label for="item_Name" class="yash_star"> Latitude </label>
     <input type="text" name="latitude" id="latitude" class="form-control client_margin" placeholder="Enter Latitude" >
   </div>
  <div class="col-md-3 mb-3 px-3">
     <label for="item_Name" class="yash_star"> Longitude </label>
     <input type="text" name="longitude" id="longitude" class="form-control client_margin" placeholder="Enter Longitude" >
   </div>

     <div class="col-md-3 mb-3 px-3">
     <label for="item_Name" class="yash_star"> Series </label>
     <input type="text" name="series" id="series" class="form-control client_margin" placeholder="Enter Series" >
   </div>

    <div class="col-md-3 mb-3 px-3">
     <label for="item_Name" class="yash_star">  Owner </label>
     <input type="checkbox" name="is_owner" value="1" style="height: 1.5vw;width: 1.5vw;" id="series" class="form-check client_margin" >
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
