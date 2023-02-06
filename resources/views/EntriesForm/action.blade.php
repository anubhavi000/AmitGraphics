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
                                <h5>Slip</h5>
                                <p class="heading_Bottom">Action Slip</p>
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
  @php
    $encrypted_id = encrypt($entry->slip_no);
  @endphp
<form action="{{route('SlipGeneration' , $encrypted_id)}}" method="POST">
    @csrf
    @method('post')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
    <h2 class="form-control-sm yash_heading form_style"><i class="far fa-building mr-2"></i><b></b> Slip No <b style="font-weight: 700;">:</b> {{$entry->slip_no}}</h2>
      </div>
       <div class="col-md-6" style="text-align:right;">
                  <a class="btn btn-link btn-primary" data-toggle="collapse" data-target="#collapseExample" aria-expanded="true" aria-controls="collapseExample" style="margin-top: 10px;">        
                  <i class="fa" aria-hidden="true"></i></a>            
                  </div>
                </div>
      <hr class="border-dark bold">
  <div class="form-row mb-3">
    <div class="col-md-3">
      <label class="form-label">Vehicle</label>
      <select name = "vehicle"  class="fstdropdown-select" id="vehicle" required="true">
          <option value="">Select</option>
          @if(!empty($vehicles))
            @foreach($vehicles as $key => $value)
              @if($key == $entry->vehicle)
              <option selected="true" value="{{$key}}">{{$value}}</option>
              @else
              <option value="{{$key}}">{{$value}}</option>
              @endif
            @endforeach
          @endif
      </select>
    </div>
    
    <div class="col-md-3 ">
        <label for="description">Tare Weight ( In Kgs )</label>
        <input type="text" required="true"  onkeypress='return FillNetWeight(event)' onkeyup = "CalculateNetWeight()" name="entry_weight" id="TareWeight" value="{{!empty($entry->entry_weight) ? $entry->entry_weight : ''}}" placeholder ="Enter Entry Weight"  class="form-control ">
    </div>

    <div class="col-md-3 ">
        <label for="description">Gross Weight ( In Kgs )</label>
        <input required="true" type="text" id="GrossWeight" name="gross_weight" onkeyup="CalculateNetWeight()" onkeypress='return FillNetWeight(event)' value="{{!empty($entry->gross_weight) ? $entry->gross_weight : ''}}" placeholder ="Enter Gross Weight"  class="form-control ">
    </div>    

    <div class="col-md-3 ">
        <label for="description">Net Weight</label>
        <input type="text" required="true" name="net_weight" readonly="true" id="NetWeight"  value="{{!empty($entry->net_weight) ? $entry->net_weight : ''}}" placeholder ="Enter Net Weight"  class="form-control ">
    </div>
    <div class="col-md-3 mt-2">
        <label for="description">Excess Weight</label>
        <input type="text" name="excess_weight" id="excess_weight" readonly="true" value="{{!empty($entry->excess_weight) ? $entry->excess_weight : 0}}" placeholder ="Enter Excess Weight"  class="form-control ">
    </div>        

    <div class="col-md-3 mt-2">
      <label class="form-label">Loading Plant</label>
      <select name = "plant"  class="fstdropdown-select" required="true">
          <option value="">Select</option>
          @if(!empty($plants))
            @foreach($plants as $key => $value)
              @if($entry->plant == $key)
                <option selected="true" value="{{$key}}">{{$value}}</option>
              @else
                <option value="{{$key}}">{{$value}}</option>
              @endif
            @endforeach
          @endif
      </select>
    </div>

   <div class="col-md-3 mb-3 px-3 mt-2">
     <label for="department_Name" class="yash_star">  Weighbridge Slip No. </label>
     <input type="text" name="kanta_slip_no"  value="{{ !empty($entry->kanta_slip_no) ? $entry->kanta_slip_no : ''}}" id="slip_no" class="form-control " placeholder="Enter Kanta Slip Here" required>
   </div>

    <div class="col-md-3 mt-2">
      <label class="">Unloading Place ( Site ) </label>
      <select  class="fstdropdown-select" required="true" name = "site">
          <option value="">Select</option>
          @if(!empty($sites))
            @foreach($sites as $key => $value)
              @if($entry->site == $key)
                <option selected="true" value="{{$key}}">{{$value}}</option>
              @else
                <option value="{{$key}}">{{$value}}</option>
              @endif
            @endforeach
          @endif
      </select>
    </div>    

    <div class="col-md-3">
      <label class="form-label">Supervisor</label>
      <select name = "supervisor" required="true" class="fstdropdown-select">
          <option value="">Select</option>
          @if(!empty($supervisors))
            @foreach($supervisors as $key => $value)
              @if($entry->supervisor == $key)
                <option selected="true" value="{{$key}}">{{$value}}</option>
              @else
              <option value="{{$key}}">{{$value}}</option>
              @endif
            @endforeach
          @endif
      </select>
    </div>
    <div class="col-md-3">
      <label> Date And Time </label>
      <input type="text" class="form-control" readonly="true" value="{{!empty($entry->datetime) ? date('d-m-Y' , strtotime($entry->datetime)) : ''}}">
    </div>

    <div class="col-md-3 ">
        <label for="description">Vehicle Pass WT</label>
        <input readonly="true" type="text" name="vehicle_pass" id="vehicle_pass" onkeyup="calculateexcessweight()" required="true" value="{{!empty($vehicle_pass_weight) ? $vehicle_pass_weight : 0}}" placeholder ="Enter Vehicle Pass WT"  class="form-control ">
    </div>
    <div class="col-md-3">
      <label class="form-label">Driver</label>
      <input type="text" class="form-control" name="driver" value="{{!empty($entry->driver) ? $entry->driver : ''}}" placeholder="Enter Driver Name" required="true">
    </div>
    {{--
    <div class="col-md-3 mb-3 px-3">
        <label for="description">Entry Weight ( In Kgs )</label>
        <input type="text" name="entry_weight" value="{{!empty($entry->entry_weight ) ? $entry->entry_weight : ''}}" name="entry_weight" placeholder ="Enter Entry Weight"  class="form-control client_margin">
    </div>


    <div class="col-md-3 mb-3 px-3">
        <label for="description">Date And Time</label>
        <input type="text" name="datetime" value="{{!empty($entry->datetime) ? date('d-m-Y h:i:A' , strtotime($entry->datetime)) : ''}}"  name="entry_weight" placeholder ="Enter Entry Weight"  class="form-control client_margin">
    </div>

    <div class="col-md-3">
      <label class="form-label">Transporter Name</label>
      <select name = "vendor_id" onchange="get_transporter(this.value)" class="fstdropdown-select">
          <option value="">Select</option>
          @if(!empty($transporters))
            @foreach($transporters as $key => $value)
              @if($entry->vendor_id == $key)
                <option selected="true" value="{{$key}}">{{$value}}</option>
              @else
                <option value="{{$key}}">{{$value}}</option>
              @endif
            @endforeach
          @endif
      </select>
    </div>  
            
  </div>
   <div class="form-row mt-3 mb-3 collapse show" id="collapseExample">
   <div class="col-md-3 mb-3 px-3">
      <label class="form-label"><b>Acess Weight (In Kg)</b></label>
      <input class="form-control" type="number" value="{{!empty($entry->acess_weight_quantity) ? $entry->acess_weight_quantity : ''}}" name="acess_weight_quantity">
   </div>
   
    <div class="col-md-3 mb-3 px-3">
      <label class="form-label">Plant</label>
      <select name="plant" class="chosen-select">
        <option value="">Select</option>
        @if(!empty($plants))
          @foreach($plants as $key => $value)
            @if($entry->plant == $key)
              <option selected="true" value="{{$key}}">{{$value}}</option>
            @else
              <option value="{{$key}}">{{$value}}</option>
            @endif
          @endforeach
        @endif
      </select>
    </div>
    --}}
        <div id="infodiv" class="col-md-3">
          @if(!empty($selected_vendor))
          <label class="form-label">Vendor Details</label>
          <br><span style="margin-top:10px;" class="text-success"> Transporter Name:  {{$selected_vendor->v_name}}<br> Contact: {{$selected_vendor->phone}}</span>
          @endif
    </div>
    <div class="col-md-12 mb-2">
<!--       <div class="col-md-3">
        <label class="form-label">Sort Items By Name</label>
        <input onkeyup="sort_items(this.value)" type="text" id="sortinput" class="form-control">
      </div> -->
    </div>
    @php
      if(!empty($entry->items_included)){
        $items_checked = json_decode($entry->items_included);
      }
      else{
        $items_checked = [];
      }
    @endphp
    <div class="col-md-12 mt-4">
      <h4> Select Items </h4>
      <div id="hide_2" class="table-responsive">

          <table style="background-color: #BCCEFB;" id="table" data-toggle="table" data-search="true" data-filter-control="true">
              <tbody>
                @php
                  $count = 0;
                @endphp
                  @foreach ($items as $key => $value)
                    @if($count == 0)
                      <tr> 
                    @endif
                      @if(!in_array($key , $items_checked))
                        <td style="border: none !important;"><input type ="radio" value="{{$key}}" name="items_included[]"><span style="margin-left: 10px;font-size: 20px;">{{$value}}</span></td>
                      @else
                      <td style="border: none !important;"><input checked="true" type ="radio" value="{{$key}}" name="items_included[]"><span style="margin-left: 10px;font-size: 20px;">{{$value}}</span></td>
                      @endif
                    @if($count == 2)
                      <?php $count = 0; ?>
                      </tr>
                    @else
                      <?php $count += 1; ?>
                    @endif
                  @endforeach
              </tbody>
          </table>
          <div class="mt-3 text-danger" id="danger"></div>
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
  <button  id="submitbtn" onclick="checkform()" type="submit" class="blob-btn1"><i class="fas fa-check pr-2"></i>
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
  function FillNetWeight(e){
       var x = e.which || e.keycode;
       if(x>=48 && x<=57){
        var first = true;
       }
       if(x== 46){
        var second = true;
       }
    if((first || second))
      CalculateNetWeight();  
    else
      return false;
   }
   function CalculateNetWeight(){
      var tare = $("#TareWeight").val();
      var gross = $("#GrossWeight").val();

      if(tare != '' && gross != ''){
        var NewWeight = gross - tare;
      }
        if(!isNaN(NewWeight)){
          $("#NetWeight").val(NewWeight);
        }
        else{
          $("#NetWeight").val(0);
        }
        calculateexcessweight();
   }
function calculateexcessweight(){
  // we require to take net weight as gross weight for calculation so changing
     var net_wt = parseFloat($("#GrossWeight").val());
     var pass_wt = parseFloat($("#vehicle_pass").val());
     var excess_wt_allowed = parseFloat("{{!empty($entry->excess_wt_allowance) ? $entry->excess_wt_allowance : 0}}");
     if(net_wt != '' && pass_wt != ''){
       var new_wt = parseFloat($("#GrossWeight").val());
       var limit =  pass_wt + (pass_wt/100*excess_wt_allowed);
          if(net_wt >= limit){
            var excess = parseFloat(limit) - parseFloat(net_wt);
            excess = -1*(excess);
          }
          else{
            var excess = 0;
          } 
          $("#excess_weight").val(excess);
     }
  }   
   function calculateexcessweight_old(){
     var net_weight = $("#NetWeight").val();
     var pass = $("#vehicle_pass").val();
     var excess_wt_allowance = "{{!empty($entry->excess_wt_allowance) ? $entry->excess_wt_allowance : 0}}";
     if(net_weight != '' && pass != ''){
          if(parseInt(net_weight) > parseInt(pass)){
            console.log('excess');
              var excess = net_weight - pass;
              $("#submitbtn").prop('disabled' , true);
              $("#danger").html('<h3>Vehicle Capacity Has Been Reached Excess Quantity Should be 0 To Submit<h3>'); 
          }
          else{
            console.log('not excess');
              $("#submitbtn").prop('disabled' , false);
              var excess = 0;
              $("#danger").html('');
          }
            $("#excess_weight").val(excess);
        }
     }
  </script>
