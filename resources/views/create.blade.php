@extends('layouts.panel')

@section('content')
<div class="pcoded-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header card">
                <div class=" cotntainer-fluid row first_row_margin">
                    <div class="col-lg-8">
                        <div class="page-header-title">
                            <i class="fas fa-map-signs mr-2"></i>
                            <div class="d-inline">
                                <h5>Add Diesel Consumption</h5>
                                <p class="heading_Bottom">Create new Diesel Consumption record</p>
                            </div>
                        </div>
                  </div>
                  <div class="col-lg-4">
                <div class="page-header-breadcrumb">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="../home"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Dashboard Analytics</a> </li>
                    </ul>
                </div>
                </div>
                </div>
  <!-- <div class="container">
 <div class="row">
  <div class="col-md-6">
    <h3>Add Diesel Consumption</h3>
    <p class="heading_Bottom"><i class="fas fa-map-signs mr-1"></i>Create new Diesel Consumption record</p>
    </div>
</div> -->
<div class="container-fluid bg-white mt-2 mb-3 border_radius box">
<div class="row">
<div class="col-md-12 mt-3 mb-3">
<form action="{{route('DieselConsumption.store')}}" method="POST">
    @csrf
    <div class="container-fluid">
      <!-- consumption details -->
      <div class="row">
        <div class="col-md-6">
<h2 class="form-control-sm yash_heading"><i class="fas fa-burn"></i> <b>Consumption Details</b></h2>
</div>
<div class="col-md-6" style="text-align:right;">
                  <a class="btn btn-link btn-primary" data-toggle="collapse" data-target="#collapseExample" aria-expanded="true" aria-controls="collapseExample" style="margin-top: 10px;">        
                  <i class="fa" aria-hidden="true"></i></a>
                  </a>            
                  </div>
                </div>
      <hr class="border-dark bold">
      <div id="hide_1">
      <div class="form-row client_margin mt-3 mb-3 collapse show" id="collapseExample">
  <div class="col-md-3 mb-3 px-3">
  <label for="Plant12" class="yash_star">Plant </label>
  <select class="form-control client_margin" id="Plant12" name="plant"  required>
		@foreach ($plant as $plant)
        <option value="{{$plant->name}}">{{$plant->name}}</option>
    @endforeach
	</select>
  </div>
        <div class="col-md-3 mb-3 px-3">
            <label for="ince" class="yash_star" >Diesel in Incinerator(In litre)</label>
            <input type="text" name="ince" id="ince" class="client_margin form-control" placeholder="Diesel in Incinerator" data-toggle="tooltip" data-placement="bottom" title="Diesel Consumtion in Incinerator(in litre)" required>
            <!-- <p class="heading_Bottom">Diesel Consumtion in Incinerator(in litre)</p> -->
          </div>
        <div class="col-md-3 mb-3 px-3">
            <label for="degeset" class="yash_star" >Diesel in Degiset(In litre)</label>
            <input type="text" name="degeset" id="degeset" class="form-control client_margin" placeholder="Diesel in Degiset" data-toggle="tooltip" data-placement="bottom" title="Diesel Consumtion in Degiset(in litre)" required>
           <!-- <p class="heading_Bottom">Diesel Consumtion in Degiset(in litre)</p> -->
          </div>
        <div class="col-md-3 mb-3 px-3">
            <label for="boiler" class="yash_star" >Diesel in Boiler(In litre)</label>
            <input type="text" name="boiler" id="boiler" class="form-control client_margin" placeholder="Diesel in Boiler" data-toggle="tooltip" data-placement="bottom" title="Diesel Consumtion in Boiler(in litre)" required>
            <!-- <p class="heading_Bottom">Diesel Consumtion in Boiler(in litre)</p> -->
          </div>
        <div class="col-md-3 mb-2 px-3">
            <label for="daet123" class="yash_star" >Date</label>
            <input type="date" name="daet123" id="daet123" class="form-control client_margin" placeholder="dd/mm/yy" data-toggle="tooltip" data-placement="bottom" title="Date on which information is add on" required>
           <!-- <p class="heading_Bottom">Date on which information is add on</p> -->
          </div>
          </div>
  <!-- consumption details -->
  <div class="row hr_margin">
    <div class="col-md-6">
<h2 class="form-control-sm yash_heading form_style">
    <i class="fas fa-file-alt"></i><b> Additional Remarks</b></h2>
</div>
<div class="col-md-6" style="text-align:right;">
                  <a class="btn btn-link btn-primary collapsed" data-toggle="collapse" data-target="#collapseExample1" aria-expanded="true" aria-controls="collapseExample" style="margin-top: 10px;">        
                  <i class="fa" aria-hidden="true"></i></a>
                  </a>            
                  </div>
                </div>
      <hr class="border-dark bold">
      <div class="form-row mt-3 mb-3 collapse" id="collapseExample1">
    <div class="col-md-6 mb-3 px-3">
        <label for="Notes">Notes</label>
        <textarea class="form-control client_margin" name="Notes" id="Notes" rows="3" placeholder="Notes" style="height:40px;"></textarea>
    </div>
   <div class="col-md-12" style="text-align: right;">
  <hr class="mt-3 border-dark bold">
<svg xmlns="" version="1.1">
  <defs>
    <filter id="goo">
      <feGaussianBlur in="SourceGraphic" result="blur" stdDeviation="10"></feGaussianBlur>
      <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0 0 1 0 0 0 0 0 1 0 0 0 0 0 21 -7" result="goo"></feColorMatrix>
      <feBlend in2="goo" in="SourceGraphic" result="mix"></feBlend>
    </filter>
  </defs>
</svg>
  <button class="blob-btn" type="reset"><i class="fas fa-times pr-2"></i>
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
  <button class="blob-btn1"><i class="fas fa-check pr-2"></i>
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
<!-- Close Row -->
</div>
<!-- Close Container -->
</div>


@endsection