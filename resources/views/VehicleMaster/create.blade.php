
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
                                <h5>Add Vehicles</h5>
                                <p class="heading_Bottom">Create New Vehicle</p>
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
<form action="{{route('VehicleMast.store')}}" method="POST">
    @csrf
<div class="container-fluid">
    <div class="row first_row_margin">
        <div class="col-md-6">
    <h2 class="form-control-sm yash_heading form_style"><i class="far fa-building mr-2"></i><b>Vehicle Information</b></h2>
      </div>
       <div class="col-md-6" style="text-align:right;">
                  <a class="btn btn-link btn-primary" data-toggle="collapse" data-target="#collapseExample" aria-expanded="true" aria-controls="collapseExample" style="margin-top: 10px;">        
                  <i class="fa" aria-hidden="true"></i></a>            
                  </div>
                </div> 
      <hr class="border-dark bold">

   <div class="form-row mt-3 mb-3 collapse show" id="collapseExample">
   
    <div class="col-md-3">
        <label for="vehicle_no" class="yash_star">Vehicle No. </label>
        <input type="text" name="number" id="vehicle_no" class="form-control " placeholder="Enter Vehicle No. Here" required>
    </div>
    <div class="col-md-3">
        <label for="item_Name" class="yash_star">Vehicle Type </label>
        <input type="text" name="type" id="item_Name" class="form-control" placeholder="Enter Vehicle Type Here" required>
    </div>
    <div class="col-md-3">
      <label for="item_Name" class="yash_star">Vehicle Pass WT </label>
      <input type="text" name="wt" id="vehicle_pass"  onkeypress='return restrictAlphabets(event)' class="form-control" placeholder="Enter Vehicle Pass Here" required>
  </div>
      <div class="col-md-3">
      
      <label for="">vendor (Transporter)</label>
      <br>
      <select onchange="get_vendor(this.value)" class="fstdropdown-select col-md-3" name="vendor" id="" required="true">
        <option value="">Select</option>
        @foreach ($vendors as $key => $value)
          <option value="{{$key}}">{{$value}}</option>
        @endforeach
      </select>
    </div> 
   
    <div class="col-md-3 mb-3  mt-3">
      <label for="item_Name" class="yash_star">Excess Weight Allowed (In %) </label>
      <input type="text" name="excess_wt_allowance" id="excess_wt_allowance"  onkeypress='return restrictAlphabets(event)' class="form-control" placeholder="Enter Vehicle Pass Here" required>
  </div>
    <div class="col-md-6 mb-3  mt-3">
        <label for="description">Description</label>
        <textarea class="form-control " name="description" id="description" rows="3" placeholder="Enter Description Here" style="height:40px;"></textarea>
    </div>
    <div class="col-md-3  mt-3">
        <label for="description">Fitness Valid Till</label>
        <input type="date" name="fitness_valid_till" class="form-control" value="">
    </div>
    <div id="infodiv" class="col-md-3 mt-3">

    </div> 
   <div class="col-md-12" style="text-align: right;">
  <hr class="mt-3 border-dark bold">

  @php
   $defaulturl= "VehicleMast";   
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
<script type="text/javascript">

        $('#vehicle_no').on('keypress', function(e) {
            if (e.which <= 47 && (e.which < 48 || e.which > 57)) {
                return false;
            }

        });
    function get_vendor(val){
      $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });

      $.ajax({
          type: "POST",
          url:  '{{route("return_vendor")}}',
          dataType: 'json',
          data: {'vendor': val},
          success: function (data) 
          {
            if(data){
              var html  = '<label class="form-label">Transporter Details</label><br><span style="margin-top:10px;" class="text-success"> Transporter Name: ';
               html += data.name;
               html += "<br> Code: ";
               html += data.code;
               html += "</span>";
               $("#infodiv").html(html);
            }
          }
      });        
  }
     function restrictAlphabets(e){
       var x = e.which || e.keycode;
    if((x>=48 && x<=57))
      return true;
    else
      return false;
   }
// $("input").focus(function(){
//     $("#e1").trigger('select2:open');
// });   
// $("input").on('blur' , function(){
//   $this = $(this);

//   if($(this).next()){
//     if($(this).next().hasClass('fstdropdown-select')){
//         $(this).next('select .fstdropdown-select').select2('ope');
//     }
//   }
  // $(this).next('select .fstdropdown-select').closest('span .select2-container').RemoveClass('select2-container--focus');
  // $(this).next('.fstdropdown-select').addClass('ved');
  // alert('done');
  // console.log($(this).next('select .fstdropdown-select').closest('span .select2-container'));


  // if($(this).next().hasClass('form-control')){
    // alert('ved');
  // }
 // if($(this).next(':has(.fstdropdown-select)')){
 //  alert('ved');
//}
// if($(this).next().hasClass("fstdropdown-select")){
  // alert('ved');
// }

 

  // alert(next_elem); 
// });
</script>

<!-- <script type="text/javascript">
 
$('input').keypress(function (e){
  if(e.keyCode == 13){
      alert('you pressed enter key');
  }
  else{
    alert(e.keyCode);
  }
});
</script> -->
@endsection  
