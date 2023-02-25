@extends('layouts.panel')

@section('content')
@php
  if(empty($data)){
    $data = [];
  }

@endphp

<div class="pcoded-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header card"  id="grv_margin">
                <div class="row first_row_margin">
                    <div class="col-lg-8">
                        <div class="page-header-title">
                            <i class=" far fa-building mr-2"></i>
                            <div class="d-inline">
                                <h5>Edit Entry</h5>
                                <p class="heading_Bottom">Edit New Payment Entry</p>
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
  @php
    $encrypt_id = encrypt($data->id);
  @endphp
<form id="storeform" action="{{url('PaymentForm_update' , $encrypt_id)}}" method="POST">
    @csrf
<div class="container-fluid">
    <div class="row first_row_margin">
      <div class="col-md-6">
        <h2 class="form-control-sm yash_heading form_style"><i class="far fa-building mr-2"></i><b>Payment Information</b></h2>
      </div>
      <div class="col-md-6" style="text-align:right;">
        <a class="btn btn-link btn-primary" data-toggle="collapse" data-target="#collapseExample" aria-expanded="true" aria-controls="collapseExample" style="margin-top: 10px;">        
        <i class="fa" aria-hidden="true"></i></a>            
      </div>

    </div>
    <hr class="border-dark bold">
    <div class=" mt-3 mb-3 collapse show" id="collapseExample">
        <div class="form-row mt-3 ">
            <div class="col-md-3">
              <label> Payment Date  </label>
              <input type="text" required="true" value="{{!empty($data->date) ? date('d-m-Y' , strtotime($data->date)) : ''}}" class="form-control datepicker"  name="date" id="payment_date"  placeholder="Payment Date ">
            </div>
            <div class="col-md-3">
              <label class="form-label">Vendors</label>
              <select name = "vendor" required="true" id="vendor" class="fstdropdown-select">
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
            <div class="col-md-3">
                <label for="description">Amount</label>
                <input type="text" value="{{!empty($data->amount) ? $data->amount : ''}}" name="amt" id="amt" required="true" placeholder ="Enter Amount"  class="form-control ">
            </div>
            <div class="col-md-3">
                <label for="description">Narration</label>
                <input type="text" name="narration" id="narration" value="{{!empty($data->narration) ? $data->narration : ''}}" required="true" placeholder ="Enter Narration"  class="form-control ">
            </div>                                                  
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
  <button   type="submit" class="blob-btn1"><i class="fas fa-check pr-2"></i>
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
<script type="text/javascript"> 


</script>
