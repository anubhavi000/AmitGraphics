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
                            <h5>Entry Form</h5>
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
                        <div class="col-md-12 mt-3 mb-3">

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
                                        <div class="col-md-2 client_margin">
                                            <label for="client_id">Vehicle</label>
                                            <select name="vehicle" class="fstdropdown-select">
                                                        <option value="">Please Select</option>
                                                @if(!empty($vehicles))
                                                    @foreach($vehicles as $key => $value)
                                                        @if($key == $vehicle_requested)
                                                            <option {{(Request::get('vehicle') == $key)?'selected':''}}  value="{{$key}}" selected="true">{{$value}}</option>
                                                        @else
                                                            <option {{(Request::get('vehicle') == $key)?'selected':''}} value="{{$key}}">{{$value}}</option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>
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
                        <div class="col-md-12 mt-3 mb-3">

                            <div class="container-fluid mt-3">
                            </div>
                            <div id="hide_2" class="table-responsive">

                                <table id="table" data-toggle="table" data-search="true" 
                                    data-pagination="true" data-toolbar="#toolbar">
                                    <thead>
                                        <tr>
                                            <th data-field="dssazze3te" data-sortable="true">S.NO</th>
                                            <th data-field="dazze3te" data-sortable="true">Slip No</th>
                                            <th data-field="dat3zz2e" data-sortable="true">Weighbridge Slip No</th>
                                            <th data-field="da1t32zze" data-sortable="true">Vehicle Number</th>
                                            <th data-sortable="true">Vehicle Pass Weight</th>
                                            <th data-field="dat2zz323sse" data-sortable="true">Tare Weight</th>
                                            <th data-sortable = "true">Gross Weight</th>
                                            <th data-field="sszzd33at2323e" data-sortable="true">Loading Site</th>
                                            <th data-field="d33at2323e" data-sortable="true">Unloading Site</th>
                                            <th data-field="d33at2323ew" data-sortable="true">Loading Plant</th>
                                            <th data-sortable ="true">Supervisor</th>
                                            <th>Loading Date</th>
                                            <th>Loading Time</th>
                                            <th data-field="dww33at2323ew" data-sortable="true">Dispatch Date</th>
                                            <th data-sortable="true">Dispatch Time</th>
                                            <th data-field="note13" data-sortable="true">Print Slip</th>
                                            <th data-field="d3ede3at2323ew" data-sortable="true">Print Challan</th>
                                        </tr>
                                    </thead>
                                  
                                    <tbody>
                                        @if(!empty($data))
                                            @foreach($data as $key => $value)
                                                <tr>
                                                    <td> {{ $key + 1 }} </td>
                                                    <td> {{ !empty( $value->slip_no ) ? $value->slip_no : '' }} </td>
                                                    <td> {{ !empty( $value->kanta_slip_no ) ? $value->kanta_slip_no : '' }} </td>
                                                    <td> {{ !empty( $vehicles[$value->vehicle] ) ? $vehicles[$value->vehicle] : ''}} </td>
                                                    <td>{{ !empty($value->vehicle_pass) ? $value->vehicle_pass.' KG' : '0 KG' }}</td>
                                                    <td> {{ !empty( $value->entry_weight ) ? $value->entry_weight.' KG' : '0 KG' }} </td>
                                                    <td>{{ !empty($value->gross_weight) ? $value->gross_weight.' KG' : '0 KG' }}</td>
                                                    <td> {{ !empty( $sites[$value->owner_site] ) ? $sites[$value->owner_site] : '' }} </td>
                                                    <td> {{ !empty( $sites[$value->site] ) ? $sites[$value->site] : '' }} </td>
                                                    <td> {{ !empty( $plants[$value->plant] ) ? $plants[$value->plant] : '' }} </td>
                                                    <td>{{ !empty($supervisors[$value->supervisor]) ? $supervisors[$value->supervisor] : '' }}</td>
                                                    <td>{{ !empty($value->datetime) ? date('d-m-Y' , strtotime($value->datetime)) : '' }}</td>
                                                    <td>{{ !empty($value->loading_minutehours) ? date('h:i:A' , strtotime($value->loading_minutehours)) : '' }}</td>
                                                    <td> {{ !empty( $value->generation_time ) ? date('d-m-Y' , strtotime($value->generation_time)) : '' }} </td>
                                                    <td>{{ !empty($value->generation_minutehours) ? 
                                                        date('h:i:A' , strtotime($value->generation_minutehours)) : ''}}</td>
                                                    <td> 
                                                        @if(empty($value->excess_weight) || $value->excess_weight <= 0)
                                                            <a style="width: 100%;" target="_blank" href="{{ url('PrintEntrySlip'.'/'.$value->slip_no) }}" id="btnGroup" type="button" 
                                                                aria-haspopup="true" aria-expanded="true"
                                                                class="btn btn-primary btn-sm ">
                                                                 slip : {{$value->slip_no}}
                                                            </a>                                            
                                                        @else
                                                            <span class="text-danger mt-2">Excess</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(empty($value->excess_weight) || $value->excess_weight <= 0)
                                                        <a style="width: 100%;" target="_blank" href="{{ url('print_invoice/'.$value->plant.'/'.$value->slip_no) }}" id="btnGroup" type="button" 
                                                            aria-haspopup="true" aria-expanded="true"
                                                            class="btn btn-primary btn-sm ">
                                                            Challan : {{$value->slip_no}}
                                                        </a>             
                                                        @else
                                                            <span class="text-danger mt-2">Excess</span>
                                                        @endif                                                        
                                                    </td>
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
