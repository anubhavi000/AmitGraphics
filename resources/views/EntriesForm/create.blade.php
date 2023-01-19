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
                                <h5>Add Entry</h5>
                                <p class="heading_Bottom">Create New Entry</p>
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
<form id="storeform" action="{{route('EntryForm.store')}}" method="POST">
    @csrf
<div class="container-fluid">
    <div class="row first_row_margin">
        <div class="col-md-6">
    <h2 class="form-control-sm yash_heading form_style"><i class="far fa-building mr-2"></i><b>Entry Information</b></h2>
      </div>
       <div class="col-md-6" style="text-align:right;">
                  <a class="btn btn-link btn-primary" data-toggle="collapse" data-target="#collapseExample" aria-expanded="true" aria-controls="collapseExample" style="margin-top: 10px;">        
                  <i class="fa" aria-hidden="true"></i></a>            
                  </div>
                </div>
      <hr class="border-dark bold">
   <div class="form-row mt-3 mb-3 collapse show" id="collapseExample">
   <div class="col-md-3 mb-3 px-3">
     <label for="department_Name" class="yash_star"> Slip No. </label>
     <input type="text" name="slip_no" id="slip_no" class="form-control client_margin" placeholder="Enter Slip Here" required>
   </div>

    <div class="col-md-4 mb-3 px-3">
        <label for="description">Series</label>
        <input type="text" name="series" id="series" placeholder="Enter Series" required class="form-control client_margin">
    </div>
    <div class="col-md-4 mb-3 px-3">
        <label for="description">Date And  Time</label>
        <input type="text"   readonly="true" placeholder ="{{date('d-m-Y h:i:A')}}"  class="form-control client_margin">
    </div>
    <div class="col-md-4 mb-3 px-3">
        <label for="description">Entry Rate</label>
        <input type="text"   name="entry_rate" placeholder ="Enter Entry Rate"  class="form-control client_margin">
    </div>
    <div class="col-md-4 mb-3 px-3">
        <label for="description">Entry Weight ( In Kgs )</label>
        <input type="text" name="entry_weight"  name="entry_weight" placeholder ="Enter Entry Weight"  class="form-control client_margin">
    </div>
        
    <div class="col-md-3">
      <label class="form-label">Transporter Name</label>
      <select name = "transporter" onchange="get_transporter(this.value)" class="chosen-select">
          <option value="">Select</option>
          @if(!empty($transporters))
            @foreach($transporters as $key => $value)
              <option value="{{$key}}">{{$value}}</option>
            @endforeach
          @endif
      </select>
    </div>  
    <div id="infodiv" class="col-md-3">
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
  <button  onclick="validateinputs()" type="button" class="blob-btn1"><i class="fas fa-check pr-2"></i>
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
  function get_transporter(val){

      $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });

      $.ajax({
          type: "POST",
          url:  '{{route("return_tranporter")}}',
          dataType: 'json',
          data: {'transporter': val},
          success: function (data) 
          {
            if(data){
              var html  = '<label class="form-label">Transporter Details</label><br><span style="margin-top:10px;" class="text-success"> Transporter Name: ';
               html += data.name;
               html += "<br> Contact: ";
               html += data.contact_no;
               html += "</span>";
               $("#infodiv").html(html);
            }
          }
      });    
  }
  function validateinputs(){
      var slip    = $("#slip_no").val();
      var sliplenth = slip.length;
      if(sliplenth = 0 || slip == ''){
        alert('Filling Slip Number Is Neccessary');
        return;
      } 
      else{
        $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

        $.ajax({
            type: "POST",
            url:  '{{url("check_duplicacy")}}',
            dataType: 'json',
            data: {'slip_no': slip},
            success: function (data) 
            {
              if(data){
                  $("#storeform").submit();
              }
              else{
                  alert('Slip no. Already Exist');
              }
            }
        });        
      }
  }
</script>
