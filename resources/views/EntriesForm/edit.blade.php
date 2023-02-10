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
                                <h5>Edit Entry</h5>
                                <p class="heading_Bottom">Edit Entry</p>
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
<form id="storeform" action="{{route('EntryForm.update' , encrypt($entry->id))}}" method="POST">
    @csrf
    @method('patch')
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
      <select  name = "vehicle"  class="fstdropdown-select" required="true">
          <option value="">Select</option>
          @if(!empty($vehicles))
            @foreach($vehicles as $key => $value)
              @if($entry->vehicle == $key)
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
        <input type="text" name="entry_weight" required="true"  onkeypress='return restrictAlphabets(event)' value="{{!empty($entry->entry_weight) ? $entry->entry_weight : ''}}" name="entry_weight" placeholder ="Enter Entry Weight"  class="form-control ">
    </div>

    <div class="col-md-3">
      <label class="form-label">Plant</label>
      <select name = "plant"  class="fstdropdown-select">
          <option value="">Select</option>
          @if(!empty($plant))
            @foreach($plant as $key => $value)
              @if($entry->plant == $key)
              <option selected="true" value="{{$key}}">{{$value}}</option>
              @else
              <option value="{{$key}}">{{$value}}</option>
              @endif
            @endforeach
          @endif
      </select>
    </div>

   <div class="col-md-3 mb-3 px-3">
     <label for="department_Name" class="yash_star">  Weighbridge Slip No. </label>
     <input type="text" name="kanta_slip_no" value="{{!empty($entry->kanta_slip_no) ? $entry->kanta_slip_no : ''}}" id="slip_no" class="form-control " placeholder="Enter Slip Here" required>
   </div>

    <div class="col-md-3">
      <label class="form-label">Unloading Place ( Site ) </label>
      <select  class="fstdropdown-select" name = "site">
          <option value="">Select</option>
          @if(!empty($sites))
            @foreach($sites as $key => $value)
              @if($key == $entry->site)
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
      <select name = "supervisor"  class="fstdropdown-select" required="true">
          <option value="">Select</option>
          @if(!empty($supervisors))
            @foreach($supervisors as $key => $value)
              @if($key == $entry->supervisor)
              <option selected="true" value="{{$key}}">{{$value}}</option>
              @else
              <option value="{{$key}}">{{$value}}</option>              
              @endif
            @endforeach
          @endif
      </select>
    </div>

    <div class="col-md-3">
      <label class="form-label">Driver</label>
      <input type="text" value="{{!empty($entry->driver) ? $entry->driver : ''}}" class="form-control" name="driver" placeholder="Enter Driver Name">
    </div>    

    <div class="col-md-3">
      <label> Date And Time </label>
      <input type="text" class="form-control" readonly="true" value="{{date('d-m-Y')}}">
    </div>

    <div id="infodiv" class="col-md-3">
    </div>
    @php
      $items_selected = json_decode($entry->items_included);
      $items_selected = !empty($items_selected) ? $items_selected : [];
    @endphp
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
                      @if(in_array($key , $items_selected))
                      <td style="border: none !important;"><input checked="true"  type ="radio" value="{{$key}}" name="items_included[]"><span style="margin-left: 10px;font-size: 20px;">{{$value}}</span></td>
                      @else
                      <td style="border: none !important;"><input  type ="radio" value="{{$key}}" name="items_included[]"><span style="margin-left: 10px;font-size: 20px;">{{$value}}</span></td>
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
        var prev_slip_no = "{{!empty($entry->kanta_slip_no) ? $entry->kanta_slip_no : ''}}";
        // alert(parseInt(slip) == parseInt(prev_slip_no));
        // alert(prev_slip_no);
        if(parseInt(slip) != parseInt(prev_slip_no)){
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
</script>
