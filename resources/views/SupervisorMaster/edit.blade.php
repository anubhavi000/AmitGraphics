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
                                <h5>Edit Supervisor</h5>
                                <p class="heading_Bottom">Edit Name</p>
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
 <div class="container-fluid bg-white mt-2 mb-3 border_radius box">
<div class="row">
<div class="col-md-12 mt-3 mb-3">
<form action="{{route('SupervisorMast.update' , $encrypt_id )}}" method="POST">
    @csrf
    @method('patch')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
    <h2 class="form-control-sm yash_heading form_style"><i class="far fa-building mr-2"></i><b>Supervisor</b></h2>
      </div>
       <div class="col-md-6" style="text-align:right;">
                  <a class="btn btn-link btn-primary" data-toggle="collapse" data-target="#collapseExample" aria-expanded="true" aria-controls="collapseExample" style="margin-top: 10px;">        
                  <i class="fa" aria-hidden="true"></i></a>            
                  </div>
                </div>
      <hr class="border-dark bold">
   <div class="form-row mt-3 mb-3 collapse show" id="collapseExample">
   <div class="col-md-3 mb-3 px-3">
     <label for="department_Name" class="yash_star" style="margin-bottom: 0px;">Supervisor Name</label>
     <input value="{{$edit->name}}" type="text" name="name" id="department_Name" class="form-control" placeholder="Name" required>
   </div>

   <div class="col-md-3 mb-3 px-3">
    <label for="department_Name" class="yash_star" style="margin-bottom: 0px;">Supervisor Email</label>
    <input value="{{$edit->email}}" type="text" name="email" id="department_Name" class="form-control" placeholder="Email" >
    </div>

    <div class="col-md-3 mb-3 px-3">
        <label for="department_Name" class="yash_star" style="margin-bottom: 0px;">Contact Number</label>
        <input value="{{$edit->phone}}" type="text" name="num" id="department_Name" class="form-control" placeholder="Contact Number" >
      </div>

   
    <div class="col-md-6 mb-3 px-3">
        <label for="description" style="margin-bottom: 0px;">Description</label>
        <textarea class="form-control" name="description" id="description" rows="3" placeholder="Enter Description Here" style="height:40px;">{{$edit->descr}}</textarea>
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
