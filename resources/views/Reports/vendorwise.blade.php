@extends("layouts.panel")

@section('content')
    <style>
        ::-webkit-scrollbar {
            /* width: px; */
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background-color: navy;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #888;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #5556;
        }

        table.dataTable th,
        table.dataTable td {
            white-space: nowrap;
        }

        tbody {
            border-right: 1px solid #ccc;
            border-left: 1px solid #ccc;
        }

        thead {
            border-right: 1px solid #ccc;
            border-left: 1px solid #ccc;
        }

        .pagination>li>a,
        .pagination>li>span {
            position: relative;
            float: left;
            padding: 6px 12px;
            margin-left: -1px;
            line-height: 1.42857143;
            color: #337ab7;
            text-decoration: none;
            background-color: #fff;
            border: 1px solid #ddd;
        }

        .pagination>.active>a,
        .pagination>.active>a:focus,
        .pagination>.active>a:hover,
        .pagination>.active>span,
        .pagination>.active>span:focus,
        .pagination>.active>span:hover {
            z-index: 2;
            color: #fff;
            cursor: default;
            background-color: #337ab7;
            border-color: #337ab7;
        }

        .pagination>.disabled>a,
        .pagination>.disabled>a:focus,
        .pagination>.disabled>a:hover,
        .pagination>.disabled>span,
        .pagination>.disabled>span:focus,
        .pagination>.disabled>span:hover {
            color: #777;
            cursor: not-allowed;
            background-color: #fff;
            border-color: #ddd;
        }

        .dropdown-menu.show {
            padding-left: 10px;
        }

    </style>
    <div class="pcoded-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header card" id="grv_margin">
            <div class="container-fluid">
                <div class="row first_row_margin">
                    <div class="col-lg-4">
                        <div class="page-header-title">
                            <i class="fas fa-users"></i>
                            <h5>Vendor Wise Challans</h5>
                            <!-- <p class="heading_Bottom"> Complete list of designations</p> -->
                        </div>
                    </div>
                    <div class="col-lg-8 mt-3">
                        <div class="page-header-breadcrumb">
                            <div class="buttons" style="text-align:right;margin:4px;">
                            </div>
                        </div>
                    </div>
                </div>


                <div class="container-fluid bg-white mt-2 mb-5 border_radius box">
                    <div class="row">
                        <div class="col-md-12 mt-3 ">

                            <div class="container-fluid mt-3">
                                <form action="" method="GET" id="user-search">
                                    @csrf
                                    <div class="row">
                                        @php
                                            $slip_no_requested = !empty(Request::get('slip_no')) ? Request::get('slip_no') : '';
                                            $kanta_reqquested  = !empty(Request::get('kanta_slip_no')) ? Request::get('kanta_slip_no') : '';
                                            $vehicle_requested = !empty(Request::get('vehicle')) ? Request::get('vehilce') : ''; 
                                        @endphp
                                        <div class="col-md-2">
                                            <label for="client_id">Slip No</label>
                                            <fieldset>
                                                <div class="input-group client_margin">
                                                    <span class="input-group-addon bg-primary border-primary white"
                                                        id="basic-addon7"
                                                        style="width: 43px;display: flex;justify-content: center;align-items: center;font-size: 23px;color: white;background-color: darkslategray !important;border: darkslategray;"><i
                                                            class="fas fa-briefcase"></i></span>
                                                    <input type="text" value="{{ $slip_no_requested }}" name="slip_no"
                                                        class="form-control" id="file_no"
                                                        placeholder="Enter Slip No">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="client_id"> Weighbridge Slip No.</label>
                                            <fieldset>
                                                <div class="input-group client_margin">
                                                    <span class="input-group-addon bg-primary border-primary white"
                                                        id="basic-addon7"
                                                        style="width: 43px;display: flex;justify-content: center;align-items: center;font-size: 23px;color: white;background-color: darkslategray !important;border: darkslategray;"><i
                                                            class="fas fa-briefcase"></i></span>
                                                    <input type="text" value="{{ $kanta_reqquested }}" name="kanta_slip_no"
                                                        class="form-control" id="file_no"
                                                        placeholder="Enter Weighbridge Slip No">
                                                </div>
                                            </fieldset>
                                        </div>  
                                        <div class="col-md-2">              
                                            <label for="client_id">From Date</label>
                                            <input value="{{!empty($from_date) ? date('Y-m-d' , strtotime($from_date)) : ''}}" type="text" class="form-control datepicker client_margin" name="from_date">
                                        </div>    
                                        <div class="col-md-2">              
                                            <label>To Date</label>
                                            <input type="text" value="{{ !empty($to_date) ? date('Y-m-d' , strtotime($to_date)) : '' }}"  class="form-control datepicker client_margin" name="to_date">
                                        </div>                                            
                                        @php
                                            $site_requested  = !empty(Request::get('site')) ? Request::get('site') : '';
                                        @endphp
                                    @php
                                        $requested_item = !empty(Request::get('item')) ? Request::get('item') : '';
                                    @endphp
                                    <div class="col-md-2"><label for="vehicle">Item</label>
                                        <fieldset>
                                            <div class="input-group client_margin">
                                                <select name="item" class="fstdropdown-select">
                                                    <option value="">Select</option>
                                                    @if(!empty($items))
                                                        @foreach($items as $key => $value)
                                                            @if($key == $requested_item)
                                                            <option selected="true" value="{{$key}}">{{$value}}</option>
                                                            @else
                                                            <option value="{{$key}}">{{$value}}</option>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </fieldset>
                                    </div>        


                                    @php
                                        $requested_plant = !empty(Request::get('plant')) ? Request::get('plant') : '';
                                    @endphp
                                    <div class="col-md-2"><label for="vehicle">Plant</label>
                                        <fieldset>
                                            <div class="input-group client_margin">
                                                <select name="plant" class="fstdropdown-select">
                                                    <option value="">Select</option>
                                                    @if(!empty($plants))
                                                        @foreach($plants as $key => $value)
                                                            @if($key == $requested_plant)
                                                            <option selected="true" value="{{$key}}">{{$value}}</option>
                                                            @else
                                                            <option value="{{$key}}">{{$value}}</option>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </fieldset>
                                    </div>

                                    @php
                                        $requested_vendor = !empty(Request::get('vendor')) ? Request::get('vendor') : '';
                                    @endphp
                                    <div class="col-md-2"><label for="vehicle">Vendor</label>
                                        <fieldset>
                                            <div class="input-group client_margin">
                                                <select name="vendor" class="fstdropdown-select">
                                                    <option value="">Select</option>
                                                    @if(!empty($vendors))
                                                        @foreach($vendors as $key => $value)
                                                            @if($key == $requested_vendor)
                                                            <option selected="true" value="{{$key}}">{{$value}}</option>
                                                            @else
                                                            <option value="{{$key}}">{{$value}}</option>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </fieldset>
                                    </div>                                                                                       
                                        <div class="col-md-2 mb-3 px-3">
                                            <label></label>
                                            <input style="margin-top:23px" type="submit" name="find" value="find" class="btn btn-success">
                                            <input style="margin-top:23px" type="submit" name="export_to_excel" value="Export To Csv" class="btn btn-primary">
  <!--                                           <input style="margin-top:23px" type="submit" name="export_to_pdf" value="Export To PDF" class="btn btn-info"> -->
                                        </div>

                                    </div>

                                </form>


                            </div>
                            <div id="hide_2" class="table-responsive">

                            </div>
                        </div>

                    </div>
                        <div class="col-md-12  mb-3">

                            <div class="container-fluid mt-3">
                            </div>
                            <div id="hide_2" class="table-responsive">

                                <table id="table" data-toggle="table" data-search="true" 
                                     data-toolbar="#toolbar">
                                        <h2 class="form-control-sm yash_heading form_style"><i
                                                class="fas fa-database mr-2"></i><b>No. Of Trips : {{$data->total()}}</b></h2>
                                    <thead>
                                        <tr>
                                            <th data-field="state" data-checkbox="true"></th>
                                            <th data-field="dae3te" data-sortable="true">Slip No</th>
                                            <th data-field="dat32e" data-sortable="true">WeightBridge<br> Slip No</th>
                                            <th data-sortable = "true">Unloading Site</th>
                                            <th data-field="d33at2323ew" data-sortable="true">loading Site</th>
                                            <th data-field="datq32e" data-sortable="true">Vehicle No.</th>
                                            <th>Vehicle Pass<br> Weight</th>
                                            <th  data-sortable="true">Vendor</th>
                                            <th data-field="dat2323e" data-sortable="true">Net Weight</th>
                                            <th data-field="dat2323sse" data-sortable="true">Tare Weight</th>
                                            <th data-sortable="true">Gross Weight</th>
                                            <th data-field="d33at2323e" data-sortable="true">loading Plant</th>
                                            <th data-sortable="true">Supervisor</th>
                                            <th data-sortable="true">Loading Date</th>
                                            <th data-sortable="true">Loading Time</th>
                                            <th data-sortable="true">Dispatch Date</th>
                                            <th  data-sortable="true">Dispatch Time</th>
                                            <th>Item</th>
                                            <th data-sortable="true">Created By</th>
                                            <th data-sortable="true">Created At</th>
                                        </tr>
                                    </thead>
                                  
                                    <tbody>
                                        @if(!empty($data))
                                            @foreach($data as $key => $value)
                                                @php
                                                    if(!empty($value->items_included)){
                                                        $real_item_arr = [];
                                                        $json_array  = json_decode($value->items_included);
                                                        foreach($json_array as $key2 => $value2){
                                                            $real_item_arr[] = !empty($items[$value2]) ? $items[$value2] : ''; 
                                                        }
                                                    }
                                                    else{
                                                            $real_item_arr = [];
                                                    }
                                                @endphp
                                                <tr>
                                                    <td> {{ $key + 1 }} </td>
                                                    <td> {{ !empty( $value->slip_no ) ? $value->slip_no : '' }} </td>
                                                    <td> {{ !empty( $value->kanta_slip_no ) ? $value->kanta_slip_no : '' }} </td>
                                                    <td> {{ !empty( $sites[$value->site] ) ? $sites[$value->site] : '' }} </td>
                                                    <td> {{ !empty( $sites[$value->owner_site] ) ? $sites[$value->owner_site] : '' }} </td>
                                                    <td> {{ !empty( $vehicles[$value->vehicle] ) ? $vehicles[$value->vehicle] : ''}} </td>
                                                    <td> {{ !empty( $value->vehicle_pass ) ? $value->vehicle_pass.' KG' : '0 KG' }}</td>
                                                    <td> {{ !empty( $vendors[$value->vendor_id] ) ? $vendors[$value->vendor_id] : '' }}</td>
                                                    <td> {{ !empty( $value->net_weight) ? $value->net_weight.' KG' : '0 KG' }} </td>
                                                    <td> {{ !empty( $value->entry_weight ) ? $value->entry_weight.' KG' : '0 KG' }} </td>
                                                    <td> {{ !empty( $value->gross_weight) ? $value->gross_weight.' KG' : '0 KG' }}</td>
                                                    <td> {{ !empty( $plants[$value->plant] ) ? $plants[$value->plant] : ''}} </td>
                                                    <td> {{ !empty( $supervisors[$value->supervisor]) ? $supervisors[$value->supervisor] : '' }} </td>
                                                    <td> {{ !empty( $value->datetime ) ? date('d-m-Y' , strtotime($value->datetime)) : '' }}</td>
                                                    <td> {{ !empty($value->loading_minutehours) ? date('h:i:A' , strtotime($value->loading_minutehours)) : '' }} </td>
                                                    <td> {{ !empty( $value->generation_time ) ? date('d-m-Y' , strtotime($value->generation_time)) : '' }} </td>
                                                    <td> {{ !empty( $value->generation_minutehours ) ? date('h:i:A' , strtotime($value->generation_minutehours)) : '' }} </td>
                                                    <td>{{ !empty($real_item_arr) ? implode(',' , $real_item_arr) : '' }}</td>
                                                    <td> {{ !empty($users[$value->created_by]) ? $users[$value->created_by] : '' }} </td>
                                                    <td> {{ !empty($value->created_at) ? date('d-m-Y' , strtotime($value->crated_at)) : '' }} </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table><br>
                                <div class="d-felx justify-content-center">
                                     {{ $data->links() }}
                                </div>                                
                            </div>
                        </div>

                    <!-- Close Row -->
                </div>

                <!-- Close Container -->
            </div>
           

        @endsection
