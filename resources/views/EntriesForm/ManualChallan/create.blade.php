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
                                <h5>Add Entry</h5>
                                <p class="heading_Bottom">Create New Manual Challan</p>
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
<form id="storeform" action="{{route('ManualChallanStore')}}" method="POST">
    @csrf
<div class="container-fluid">
    <div class="row first_row_margin">
      <div class="col-md-6">
        <h2 class="form-control-sm yash_heading form_style"><i class="far fa-building mr-2"></i><b>Manual Entry Information</b></h2>
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
               <label for="department_Name" class="yash_star">  Slip No. </label>
               <input type="text" name="slip_no" onkeypress='return restrictAlphabets(event)' onblur="checkslipduplicate(this.value)" value="{{!empty($data['slip_no']) ? $data['slip_no']  : ''}}" id="main_slip_no"  class="form-control " placeholder="Enter Slip No. Here" >
             </div>
            <div class="col-md-3">
              <label class="form-label">Vehicle</label>
              <select name = "vehicle"   class="fstdropdown-select" id="vehicle" onchange="get_pass_wt(this.value);setfocus(this,'storeform');" required="true">
                  <option value="">Select</option>
                  @if(!empty($vehicles))
                    @foreach($vehicles as $key => $value)
                      <option value="{{$key}}">{{$value}}</option>
                    @endforeach
                  @endif
              </select>
            </div>
        
            <div class="col-md-3 ">
                <label for="description">Gross Weight ( In Kgs )</label>
                <input required="true" type="text" id="GrossWeight" name="gross_weight" onkeyup="CalculateNetWeight()" onkeypress='return FillNetWeight(event)'  placeholder ="Enter Gross Weight"  class="form-control ">
            </div>    

            <div class="col-md-3 ">
                <label for="description">Tare Weight ( In Kgs )</label>
                <input type="text" required="true"  onkeypress='return FillNetWeight(event)' onkeyup = "CalculateNetWeight()" name="entry_weight" id="TareWeight"  placeholder ="Enter Entry Weight"  class="form-control ">
            </div>
        </div>
        <div class="form-row mt-3 ">
            <div class="col-md-3">
                <label for="description">Net Weight</label>
                <input type="text" required="true" name="net_weight" readonly="true" id="NetWeight" placeholder ="Enter Net Weight"  class="form-control ">
            </div>
            <div class="col-md-3">
                <label for="description">Excess Weight</label>
                <input type="text" name="excess_weight" id="excess_weight" readonly="true" placeholder ="Enter Excess Weight"  class="form-control ">
            </div>        

            <div class="col-md-3">
              <label class="form-label">Loading Plant</label>
              <select name = "plant"  class="fstdropdown-select" id="plant" required="true">
                  <option value="">Select</option>
                  @if(!empty($plant))
                    @foreach($plant as $key => $value)
                        <option value="{{$key}}">{{$value}}</option>
                    @endforeach
                  @endif
              </select>
            </div>

            <div class="col-md-3">
                 <label for="department_Name" class="yash_star">  Weighbridge Slip No. </label>
                 <input type="text" name="kanta_slip_no" id="slip_no" class="form-control " onkeypress='return restrictAlphabets(event)' placeholder="Enter Kanta Slip Here" required>
            </div>
        </div>
        <div class="form-row mt-3 ">

            <div class="col-md-3">
              <label class="">Unloading Place ( Site ) </label>
              <select  class="fstdropdown-select" required="true" id="Unloading_place" name = "site">
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
              <select name = "supervisor" required="true" id="supervisor" class="fstdropdown-select">
                  <option value="">Select</option>
                  @if(!empty($supervisors))
                    @foreach($supervisors as $key => $value)
                      <option value="{{$key}}">{{$value}}</option>
                    @endforeach
                  @endif
              </select>
            </div>
            <div class="col-md-3">
              <label> In Date  </label>
              <input type="text" class="form-control datepicker"  name="datetime" id="loadingdate"  placeholder="Loading Date time">
            </div>
            <div class="col-md-3">
              <label> In Time </label>
              <input type="time" class="form-control" onblur = "setminval(this.value)" name="loading_minutehours" id="loadingtime"  placeholder="Loading time">
            </div>            
          </div>
        <div class="form-row mt-3 ">

            <div class="col-md-3 ">
                <label for="description">Vehicle Pass WT</label>
                <input readonly="true" type="text" name="vehicle_pass" id="vehicle_pass" onkeyup="calculateexcessweight()" required="true" placeholder ="Enter Vehicle Pass WT"  class="form-control ">
            </div>
    <div class="col-md-3">
      <label class="form-label">Driver</label>
      <input type="text" class="form-control" name="driver" id="driver" placeholder="Enter Driver Name" >
    </div>
    <div class="col-md-3">
      <label> Out Date  </label>
      <input type="text" id="generationdate"  name="generation_time" class="form-control datepicker" required="true"  placeholder="Loading Date ">
    </div> 
   <div class="col-md-3">
      <label>  Out Time </label>
      <input type="time" id="generationtime"  name="generation_minutehours"  class="form-control" required="true"  placeholder="Loading time">
    </div>        
  </div>
        <div class="form-row mt-3 ">
  
    <div class="col-md-3">
      <label>Remarks</label>
      <textarea name="remarks" placeholder="Remarks" class="form-control"></textarea>
    </div>            
        </div>
        <div class="form-row mt-3 ">

  
        </div>

        <div id="infodiv" class="col-md-3">
            @if(!empty($selected_vendor))
            <label class="form-label">Vendor Details</label>
            <br><span style="margin-top:10px;" class="text-success"> Transporter Name:  {{$selected_vendor->v_name}}<br> Contact: {{$selected_vendor->phone}}</span>
            @endif
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
                      <td style="border: none !important;"><input required="true"  type ="radio" value="{{$key}}"  name="items_included[]"><span style="margin-left: 10px;font-size: 20px;">{{$value}}</span></td>
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
 function setfocus(obj , formid){
  // $("#GrossWeight").trigger('mousedown');
  // var element = $("#"+obj.id);
  // var form = $("#"+formid);

  // focusable = form.find('input:not([readonly]) , select').filter(':visible');
  // next = focusable.eq(focusable.index(element) +1);
  // console.log(next[0].id);
  //     $(this).preventDefault();
  // $("#GrossWeight").focus();
  // $("#"+next[0].id).focus();
  // console.log($(this));
  
  // console.log('focus needed');
    // var press = jQuery.Event("keypress");
// press.ctrlKey = false;
// press.which = 9;
// press.keyCode = 9;
// $(this).closest('select').trigger(press);
    // console.log($(this).next().find('input select').focus());
    // $(this).closest('select2').select2('close');
    //   var self = $(this).closest('select2'), form = self.parents('form:eq(0)'), focusable, next;
    //   focusable = form.find('input:not([readonly]) , select').filter(':visible'); 
    //   next = focusable.eq(focusable.index(this) + 1);
 }
  function setminval(val){
      $("#generationtime").attr('min' , val);
  }
  function checkslipduplicate(val){
      var main_slip_no = val;
      $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });

      $.ajax({
          type: "POST",
          url:  '{{url("checkslipduplicate")}}',
          dataType: 'json',
          data: {'slip_no': val},
          success: function (data) 
          {
            if(data){
              return true;
            }
            else{
              $("#main_slip_no").val('');
                alert('A Slip No With '+val+' Already Exists');
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
     if(pass_wt == ''){
        alert('Select Vehicle First');
     }
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
  function validateinputs(){
      var main_slip_no = $("#main_slip_no").val();
      var slip      = $("#slip_no").val();
      var sliplenth = slip.length;
      var tare      = $("#TareWeight").val();
      var vehicle   = $("#vehicle").val();
      var plant     = $("#plant").val();
      var site      = $("#site").val();  
      var supervisor= $("#supervisor").val();
      var Unloading_place = $("#Unloading_place").val();
      var gross_weight = $("#GrossWeight").val();

      var loadingdate = $("#loadingdate").val();
      var generationdate = $("#generationdate").val();
      var loadingtime = $("#loadingtime").val();
      var generationtime = $("#generationtime").val();
      // alert(loadingtime);
      // alert(generationtime);
      // return false;
      //checking dates  

      // if(sliplenth = 0 || slip == ''){
      //   alert('Filling Slip Number Is Neccessary');
      //   return;
      // } 
      if(tare == ''){
        alert('Filling Tare Weight Is Neccessary');
        return false;
      }
      else if(vehicle == ''){
        alert('Vehcile Must Be Selected');
        return false;
      }
      else if(main_slip_no == ''){
        alert('Slip No must be Filled');
        return false;
      }
      else if(slip == ''){
        alert('Weighbridge Slip No. Must Be Filled');
          return false;
      }
      else if(Unloading_place == ''){
        alert('Unloading Place Must be Selected');
        return false;
      }
      else if(plant == ''){
        alert("Plant Must be Selected");
        return false;
      }
      else if(gross_weight == ''){
        alert('Gross Weight Must Be Filled');
        return false;
      }
      else if(supervisor  == '' ){
        alert('Supervisor Must be Selected');
        return false;
      }
      else if(generationtime  == '' ){
        alert('Out Time Must be Filled');
        return false;
      }      
      else if(generationdate == ''){
        alert('Out Date Must be Filled');
      }
      else if(loadingtime == ''){
        alert('In Time Must be Filled');
      }
      else if(loadingdate == ''){
        alert('Loading Date Must be Filled');
      }
      else{
        $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

        $.ajax({
            type: "POST",
            url:  '{{url("check_duplicacy_both_slips")}}',
            dataType: 'json',
            data: {'slip_no': main_slip_no,
                    'kanta_slip_no':slip,
                      'generationdate':generationdate,
                      'generationtime':generationtime,
                      'loadingdate':loadingdate,
                      'loadingtime':loadingtime},
            success: function (data) 
            {
              if(data.res == 200){
                  if(data.date == 1){
                  $("#storeform").submit();
                  }
                  else{
                    alert('Out Date and Out Time Must be Greated Than In Date and In Time');
                    return false;
                  }
              }
              else if(data.res == 400){
                if(data.kanta == false && data.slip == false){
                  alert('Both Weighbridge Slip No. And Slip No. already exists');
                  return false;
                }
                else if(data.kanta == false && data.slip == true){
                  alert('Weighbridge Slip No. already exists');
                  return false;
                }
                else if(data.kanta == true && data.slip ==false){
                  alert('slip no. already exists');
                  return false;
                }
              }
            }
        });        
      }
  }

  function get_pass_wt(val){
       $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

        $.ajax({
            type: "POST",
            url:  '{{url("get_vehicle_pass_wt")}}',
            dataType: 'json',
            data: {'vehicle': val},
            success: function (data) 
            {
              if(data.res == 200){
                $("#vehicle_pass").val(data.pass_wt);
              }
            }
        });    
  }

</script>
