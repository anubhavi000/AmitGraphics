 @extends('layouts.panel')

@section('content')
<div class="pcoded-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header card" id="grv_margin">
        <div class="row">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="fas fa-map-signs mr-2"></i>
                    <div class="d-inline">
                        <h5 class="mt-2">Generated Slips</h5>
                        <!-- <p class="heading_Bottom"> Client Bill Payment Ledger</p> -->
                    </div>
                </div>
            </div>
        </div>
        @php
            $slip = !empty(Request::get('slip_no')) ? Request::get('slip_no') : '';
            $from_date = !empty(Request::get('from_date')) ? Request::get('from_date') : '';
            $to_date  = !empty(Request::get('to_date')) ? Request::get('to_date') : '';  
        @endphp
        <div class="container-fluid bg-white  border_radius box">
            <div class="row">
                <div class="col-md-12 mt-3 mb-3">
                    <form action="" id="user-search" method="get">
                        @csrf
                        <div class="container-fluid">
                            <div class="row " style="margin-bottom:-11px">
                                <div class="col-md-6">
                                    <h2 class="form-control-sm yash_heading form_style"><i
                                            class="fas fa-database mr-2"></i><b>Filter Data</b></h2>
                                </div>
                                <div class="col-md-6" style="text-align:right;">
                                    <a class="btn btn-link btn-primary collapsed" data-toggle="collapse"
                                        data-target="#collapseExample1" aria-expanded="true"
                                        aria-controls="collapseExample" style="margin-top: 10px;">
                                        <i class="fa" aria-hidden="true"></i></a>
                                </div>
                                
                            </div>

                            <hr class="border-dark bold">
                            <div class="form-row mt-3 mb-3 collapse show" id="collapseExample1">
                                <div class="row col-md-12" style="margin-bottom:-11px">
                                    <div class="col-md-2 mb-3 px-3">
                                        <label style="margin-bottom:0px" for="slip_no"
                                            class="yash_star">SLip No.</label>
                                        <input type="text" placeholder="Enter Slip No." value="{{$slip}}" name="slip_no"class="form-control" >
                                    </div>
                                    <div class="col-md-2"><label for="from_date">From Date</label>
                                        <fieldset>
                                            <div class="input-group client_margin">
                                                <span class="input-group-addon bg-primary border-primary white"
                                                    id="basic-addon7"
                                                    style="width: 43px;display: flex;justify-content: center;align-items: center;font-size: 23px;color: white;background-color: darkslategray !important;border: darkslategray;"><i
                                                        class="fas fa-briefcase"></i></span>
                                                <input type="text" placeholder="From Date" value="{{$from_date}}" name="from_date" class="form-control datepicker"
                                                    id="from_date" 
                                                    value=" ">
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-2"><label for="to_date">To Date</label>
                                        <fieldset>
                                            <div class="input-group client_margin">
                                                <span class="input-group-addon bg-primary border-primary white"
                                                    id="basic-addon7"
                                                    style="width: 43px;display: flex;justify-content: center;align-items: center;font-size: 23px;color: white;background-color: darkslategray !important;border: darkslategray;"><i
                                                        class="fas fa-briefcase"></i></span>
                                                <input type="text" value="{{$to_date}}" placeholder="To Date" name="to_date" class="form-control datepicker" id="to_date"
                                                    value="">
                                            </div>
                                        </fieldset>
                                    </div>
                                    @php
                                        $requested_vehicle = !empty(Request::get('vehicle')) ? Request::get('vehicle') : '';
                                    @endphp
                                    <div class="col-md-2"><label for="vehicle">Vehicle</label>
                                        <fieldset>
                                            <div class="input-group client_margin">
                                                <select name="vehicle" class="fstdropdown-select">
                                                    <option value="">Select</option>
                                                    @if(!empty($vehicles))
                                                        @foreach($vehicles as $key => $value)
                                                            @if($key == $requested_vehicle)
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
                                        $requested_site = !empty(Request::get('site')) ? Request::get('site') : '';
                                    @endphp
                                    <div class="col-md-2"><label for="vehicle">Unloading Site</label>
                                        <fieldset>
                                            <div class="input-group client_margin">
                                                <select name="site" class="fstdropdown-select">
                                                    <option value="">Select</option>
                                                    @if(!empty($sites))
                                                        @foreach($sites as $key => $value)
                                                            @if($key == $requested_site)
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
                                    <div class="col-md-2 mt-3">
                                        <input type="submit" name="find" value="find" class="btn btn-success">
                                        <input type="submit" name="export_to_excel" value="Export To Csv" class="btn btn-primary">
                                        <!-- <input type="submit" class="btn btn-primary" name="export_pdf" value="Export Pdf"> -->
                                    </div>  
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Close Row -->
                    <div id="hide_2" class="table-responsive mb-4">

                        <div class="row " style="margin-bottom:10px">
                            <div class="col-md-6">
                                <h2 class="form-control-sm yash_heading form_style"><i
                                        class="fas fa-database mr-2"></i><b>No. Of Trips : {{$data->total()}}</b></h2>
                            </div>
                        </div>
                        <table id="table" data-toggle="table" data-search="true" data-filter-control="true"
                                    data-show-export="true" data-show-refresh="true" data-show-toggle="true"
                                     data-toolbar="#toolbar">
                            <thead>
                                <tr style="background-color:darkslategray; color: white;">
                                            <th data-field="state" data-checkbox="true"></th>
                                            <th data-field="dae3te" data-sortable="true">Slip No</th>
                                            <th data-field="dat32e" data-sortable="true">Kanta Slip No</th>
                                            <th data-field="datq32e" data-sortable="true">Vehicle No.</th>
                                            <th>Vehicle Pass Weight</th>
                                            <th data-sortable="true">Vendor</th>

                                            <th data-field="dat2323e" data-sortable="true">Net Weight</th>
                                            <th data-field="dat2323sse" data-sortable="true">Tare Weight</th>
                                            <th data-sortable="true">Gross Weight</th>
                                            <th data-field="d33at2323e" data-sortable="true">loading Plant</th>
                                            <th data-sortable="true">Supervisor</th>

                                            <th data-field="d33at2323ew" data-sortable="true">Unloading Site</th>
                                            <th data-sortable="true">Loading Date</th>
                                            <th data-sortable="true">Loading Time</th>
                                            <th data-sortable="true">Dispatch Date</th>
                                            <th  data-sortable="true">Dispatch Time</th>
                                            <th>Item</th>
                                            <th data-sortable="true">Created By</th>
                                            <th data-sortable="true">Created_at</th>
                                            <th>Print Slip</th>
                                            <th>Print Challan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $key => $value)
                                                                         <?php
                                            $encrypt_id = enCrypt($value->slip_no);
                                            if(!empty($value->items_included)){
                                            $items_arr = json_decode($value->items_included);
                                            $arr_item_real = [];
                                            foreach ($items_arr as $key2 => $value2) {
                                                $arr_item_real[] = !empty($items[$value2]) ? $items[$value2] : '';
                                              }  
                                            }
                                            else{
                                                $items_arr = [];
                                            }
                                            ?>
                                    <tr>
                                                 <td></td>
                                               
                                                <td>{{ !empty($value->slip_no) ? $value->slip_no : '' }}</td>
                                                <td>{{ !empty($value->kanta_slip_no) ? $value->kanta_slip_no : ''}}</td>
                                                <td>{{ !empty($vehicles[$value->vehicle]) ? $vehicles[$value->vehicle] : ''}}</td>
                                                <td>{{ !empty($value->vehicle_pass) ? $value->vehicle_pass.' KG' : '0 KG' }}</td>
                                                <td>{{ !empty($vendors[$value->vendor_id]) ? $vendors[$value->vendor_id] : '' }}</td>
                                                <td>{{ !empty($value->net_weight) ? $value->net_weight : '0'}} KG</td>
                                                <td>{{!empty($value->entry_weight) ? $value->entry_weight : '' }} KG</td>
                                                <td>{{ !empty($value->gross_weight) ? $value->gross_weight.' KG' :'0 KG' }}</td>
                                                <td>{{ !empty($plants[$value->plant]) ? $plants[$value->plant] : '' }}</td>
                                                <td>{{ !empty($supervisors[$value->supervisor]) ? $supervisors[$value->supervisor] : '' }}</td>
                                                <td>{{ !empty( $sites[$value->site] ) ? $sites[$value->site] : '' }}</td>
                                                <td>{{ !empty($value->datetime) ? date('Y-m-d' , strtotime($value->datetime)) : '' }}</td>
                                                <td>{{ !empty($value->loading_minutehours) ? date('h:i:A' , strtotime($value->loading_minutehours)) : ''}}</td>
                                                <td>{{ !empty($value->generation_time) ? date('d-m-Y' , strtotime($value->generation_time)) : ''}}</td>
                                                <td>{{ !empty($value->generation_time) ? date('h:i:A' , strtotime($value->generation_time)) : ''}}</td>
                                                <td>{{ !empty($arr_item_real) ? implode(',' , $arr_item_real) : '' }}</td>
                                                <td> {{ !empty( $users[$value->created_by] ) ? $users[$value->created_by] : '' }} </td>
                                                <td> {{ !empty($value->created_at) ? date('d-m-Y' , strtotime($value->created_at)) : '' }} </td>
                                                <td>
                                            <a style="width: 100%;" target="_blank" href="{{ url('PrintEntrySlip'.'/'.$value->slip_no) }}" id="btnGroup" type="button" 
                                                aria-haspopup="true" aria-expanded="true"
                                                class="btn btn-primary btn-sm ">
                                                Print Slip : {{$value->slip_no}}
                                            </a>                                                    
                                                </td>
                                        <td>
                                            @if($value->is_generated == 1)
                                            @if(empty($value->excess_weight) || $value->excess_weight <= 0)
                                            <a style="width: 100%;" target="_blank" href="{{ url('print_invoice/'.$value->plant.'/'.$value->slip_no) }}" id="btnGroup" type="button" 
                                                aria-haspopup="true" aria-expanded="true"
                                                class="btn btn-primary btn-sm ">
                                                Print Challan : {{$value->slip_no}}
                                            </a>             
                                            @else
                                                <span class="text-danger mt-2">Excess</span>
                                            @endif            
                                            @else
                                                <span class="mt-2"> Not generated </span>
                                            @endif                   
                                        </td> 
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-felx justify-content-center">
                             {{ $data->links() }}
                        </div>                         
                    </div>
                </div>
            </div>
        </div>
    </div>

        @endsection