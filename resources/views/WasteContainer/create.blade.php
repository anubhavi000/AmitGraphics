@extends('layouts.panel')

@section('content')

<div class="pcoded-content">
  <!-- [ breadcrumb ] start -->
  <div class="page-header card" id="grv_margin">
      <div class=" cotntainer-fluid row first_row_margin">
          <div class="col-lg-8">
              <div class="page-header-title">
                  <i class="fas fa-map-signs mr-2"></i>
                  <div class="d-inline">
                      <h5>Add Waste Container</h5>
                      <p class="heading_Bottom">Write Something About Waste Container</p>
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
    <form action="{{route('WasteContainer.store')}}" method="POST">
        @csrf
    <div class="container-fluid">
        <div class="row first_row_margin">
            <div class="col-md-6">
        <h2 class="form-control-sm yash_heading form_style"><i class="fas fa-trash-alt mr-2"></i><b>Waste Container Information</b></h2>
    </div>
     <div class="col-md-6" style="text-align:right;">
                  <a class="btn btn-link btn-primary" data-toggle="collapse" data-target="#collapseExample" aria-expanded="true" aria-controls="collapseExample" style="margin-top: 10px;">        
                  <i class="fa" aria-hidden="true"></i></a>            
                  </div>
                </div>
          <hr class="border-dark bold">
          <div class="form-row mt-3 mb-3 collapse show" id="collapseExample">
            <div class="col-md-3 mb-3 px-3">
              <label for="container_Name" class="yash_star">Container Name</label>
              <input type="text" name="name" id="container_Name" class="form-control client_margin" placeholder=" Container Name" required>
            </div>
            <div class="col-md-3 mb-3 px-3">
                <label for="container_Volume" class="yash_star">Container Volume</label>
                <input type="text" name="volume" id="container_Volume" class="form-control client_margin" placeholder=" Container Volume">
            </div>
            <div class="col-md-3 mb-3 px-3">
                <label for="enabled" class="yash_star" style="margin-bottom:0px;">Enabled </label>
                <select class="form-control fstdropdown-select" id="enabled" name="enabled" required>
                <option value="">Select</option>
                 <option value="1">Yes</option>
                 <option value="0">No</option>
                 </select>
                </div>
                <div class="col-md-3 mb-3 px-3">
                    <label for="Price" class="yash_star">Price </label>
                    <input type="text" name="price" id="Price" class="form-control client_margin" placeholder="Container Price" onkeypress="return /[0-9]/i.test(event.key)">
                  </div>
            <div class="col-md-6 mb-3 px-3">
                <label for="description">Container Description</label>
                <textarea class="form-control client_margin" name="description" id="description" rows="3" placeholder="Description" style="height: 40px;"></textarea>
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
  <button class="blob-btn1" id="submitbtn" type="submit"><i class="fas fa-check pr-2"></i>
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
    </div>
    <!-- Close Container -->
</div>
{{-- <svg xmlns="" version="1.1">
  <defs>
    <filter id="goo">
      <feGaussianBlur in="SourceGraphic" result="blur" stdDeviation="10"></feGaussianBlur>
      <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0 0 1 0 0 0 0 0 1 0 0 0 0 0 21 -7" result="goo"></feColorMatrix>
      <feBlend in2="goo" in="SourceGraphic" result="mix"></feBlend>
    </filter>
  </defs>
</svg> --}}
@endsection