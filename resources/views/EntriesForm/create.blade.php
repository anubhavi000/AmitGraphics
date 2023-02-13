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
    <div class="col-md-3">
      <label class="form-label">Vehicle</label>
      <select name = "vehicle" {{-- onchange="CheckAvailiblity(this.value)" --}} class="fstdropdown-select" id="vehicle" required="true">
          <option value="">Select</option>
          @if(!empty($vehicles))
            @foreach($vehicles as $key => $value)
              <option value="{{$key}}">{{$value}}</option>
            @endforeach
          @endif
      </select>
    </div>
    
    <div class="col-md-3 ">
        <label for="description">Tare Weight ( In Kgs )</label>
        <input type="text" name="entry_weight" id="tare_weight" required="true"  onkeypress='return restrictAlphabets(event)' name="entry_weight" placeholder ="Enter Entry Weight"  class="form-control ">
    </div>

    <div class="col-md-3">
      <label class="form-label">Plant</label>
      <select name = "plant"  class="fstdropdown-select" id="plant">
          <option value="">Select</option>
          @if(!empty($plant))
            @foreach($plant as $key => $value)
              <option value="{{$key}}">{{$value}}</option>
            @endforeach
          @endif
      </select>
    </div>

   <div class="col-md-3 mb-3 px-3">
     <label for="department_Name" class="yash_star">  Weighbridge Slip No. </label>
     <input type="text" name="kanta_slip_no" id="slip_no" value="{{!empty($latest_kanta_slip) ? $latest_kanta_slip : ''}}" class="form-control " placeholder="Enter Slip Here" >
   </div>

    <div class="col-md-3">
      <label class="form-label">Unloading Place ( Site ) </label>
      <select  class="fstdropdown-select" id="site" name = "site">
          <option value="">Select</option>
          @if(!empty($sites))
            @foreach($sites as $key => $value)
              <option value="{{$key}}">{{$value}}</option>
            @endforeach
          @endif
      </select>
    </div>    


    <div class="col-md-3">
      <label class="form-label">Supervisor</label>
      <select name = "supervisor"  class="fstdropdown-select" id="supervisor" >
          <option value="">Select</option>
          @if(!empty($supervisors))
            @foreach($supervisors as $key => $value)
              <option value="{{$key}}">{{$value}}</option>
            @endforeach
          @endif
      </select>
    </div>

    <div class="col-md-3">
      <label class="form-label">Driver</label>
      <input type="text" class="form-control" name="driver" placeholder="Enter Driver Name">
    </div>

    <div class="col-md-3 px-3">
      <label> Date And Time </label>
      <input type="text" class="form-control" readonly="true" value="{{date('d-m-Y')}}">
    </div>

    <div id="infodiv" class="col-md-3">
    </div>
      <div class="col-md-12 mt-4">
      <div id="hide_2" class="table-responsive">
        <h4><b>Select Items</b></h4>
          <table style="background-color: #BCCEFB;" id="table" data-toggle="table" data-search="true" data-filter-control="true">
              <tbody>
                @php
                  $count = 0;
                @endphp
                  @foreach ($items as $key => $value)
                    @if($count == 0)
                      <tr> 
                    @endif
                      <td style="border: none !important;"><input  type ="radio" value="{{$key}}" name="items_included[]"><span style="margin-left: 10px;font-size: 20px;">{{$value}}</span></td>
                    @if($count == 2)
                      <?php $count = 0; ?>
                      </tr>
                    @else
                      <?php $count += 1; ?>
                    @endif
                  @endforeach
              </tbody>
          </table>
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
              var html  = '<label class="form-label">Vendor Details</label><br><span style="margin-top:10px;" class="text-success"> Transporter Name: ';
               html += data.v_name;
               html += "<br> Contact: ";
               html += data.phone;
               html += "</span>";
               $("#infodiv").html(html);
            }
          }
      });    
  }
  function select2hander(e){
    var key = e.which || e.keycode;
    if(key == 13){
      alert('ved');
      $('#vehicle').select2('close');

      // $(".fstdropdown-select").select2('close');
      $("#tare_weight").focus();
      return false;
          // var class = $('.select2-results__option--highlighted').text();        
          // alert(class);s
          // var closest = $(this).closest('.select2');
          // console.log(closest);
          // $(this).parent('.select2-results__options').attr('aria-hidden' , false);
          // $(e.target).data("select2").$selection.one('focus focusin', function (e) {
          // e.stopPropagation();
        // });
    }
}
  function validateinputs(){
      var slip      = $("#slip_no").val();
      var sliplenth = slip.length;
      var tare      = $("#tare_weight").val();
      var vehicle   = $("#vehicle").val();
      var plant     = $("#plant").val();
      var site      = $("#site").val();  
      var supervisor= $("#supervisor").val();
      
      // if(sliplenth = 0 || slip == ''){
      //   alert('Filling Slip Number Is Neccessary');
      //   return;
      // } 
      if(tare = 0 || tare == ''){
        alert('Filling Tare Weight Is Neccessary');
        return false;
      }
      else if(vehicle == ''){
        alert('Vehcile Must Be Selected');
        return false;
      }
      else{
        if(slip != ''){
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
                  alert('Kanta Slip no.: '+slip+' Already Exist');
                  return false;
              }
            }
        });        
      }
      else{
        $("#storeform").submit();        
      }
    }
  }

  // function CheckAvailiblity(val){
  //       $.ajaxSetup({
  //                   headers: {
  //                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  //                   }
  //               });

  //       $.ajax({
  //           type: "GET",
  //           url:  '{{url("check_vehicle_Availiblity")}}',
  //           dataType: 'json',
  //           data: {'vehicle_id': val},
  //           success: function (data) 
  //           {

  //           }
  //       }); 
  // }
  // var vehicle = document.getElementById('vehicle');
//   $(document).on('select2:open', function(e) {
//   document.querySelector(`[aria-controls="select2-${e.target.id}-results"]`).focus();
// });
//   document.addEventListener('keydown', function(e) {
//     alert(event.keyCode);
// if (event.keyCode === 13 && event.target.nodeName == 'SELECT') {
//   alert('select');
//   var form = event.target.closest('form');
//   var index = Array.prototype.indexOf.call(form, event.target);
//   form.elements[index + 1].focus();
//   return false;
// }
// });
</script>

