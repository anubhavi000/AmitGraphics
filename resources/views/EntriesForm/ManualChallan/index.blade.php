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
                            <h5>Manual Challans</h5>
                            <!-- <p class="heading_Bottom"> Complete list of designations</p> -->
                        </div>
                    </div>
                    <div class="col-lg-8 mt-3">
                        <div class="page-header-breadcrumb">
                            <div class="buttons" style="text-align:right;margin:4px;">
                                {{--
                                <a href="{{ route('GeneratedSlips') }}"><button type="button"
                                        class="btn btn-success btn_new"><i class="fas fa-plus mr-2"></i>Generated Slips</button>
                                </a>
                                --}}
                                <a href="{{ url('ManualChallan/create') }}"><button type="button"
                                        class="btn btn-success btn_new"><i class="fas fa-plus mr-2"></i>Add New</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="container-fluid bg-white mt-2 mb-5 border_radius box">
                    <div class="row">
                        <div class="col-md-12 mt-3 mb-0">

                            <div class="container-fluid mt-3">
                                <form action="" method="GET" id="user-search">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label for="client_id">Slip No</label>
                                            <fieldset>
                                                <div class="input-group client_margin">
                                                    <span class="input-group-addon bg-primary border-primary white"
                                                        id="basic-addon7"
                                                        style="width: 43px;display: flex;justify-content: center;align-items: center;font-size: 23px;color: white;background-color: darkslategray !important;border: darkslategray;"><i
                                                            class="fas fa-briefcase"></i></span>
                                                    <input type="text" value="{{ Request::get('slip_no') }}" name="slip_no"
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
                                                    <input type="text" value="{{ Request::get('kanta_slip_no') }}" name="kanta_slip_no"
                                                        class="form-control" id="file_no"
                                                        placeholder="Enter Kanta Slip No">
                                                </div>
                                            </fieldset>
                                        </div>  
                                        <div class="col-md-2">
                                            <label class="mb-0">From Date</label>
                                            <input type="text" value="{{!empty(Request::get('from_date')) ? Request::get('from_date') : ''}}" placeholder="From Date" name="from_date" class="form-control datepicker">
                                        </div>              
                                        <div class="col-md-2">
                                            <label class="mb-0">To Date</label>
                                            <input type="text" value="{{!empty(Request::get('from_date')) ? Request::get('from_date') : ''}}" name="to_date" placeholder="To Date" class="form-control datepicker">
                                        </div>    
                                        @php
                                            $statusval = !empty(Request::get('status')) ? Request::get('status') : ''; 
                                            $opt_arr = [
                                                    0 => 'Generated',
                                                    1 => 'Not Generated'
                                                 ];
                                            $vendorval = !empty(Request::get('vendor')) ? Request::get('vendor') : '';
                                        @endphp
                                        {{--
                                        <div class="col-md-2">
                                            <fieldset>
                                                <div class="input-group client_margin mt-1">
                                                    <label class="mb-0">Generation Status</label>
                                                    <select value="{{$statusval}}" name="status" class="fstdropdown-select col-md-3">
                                                        <option value="">Select</option>
                                                        @foreach($opt_arr as $key => $value)
                                                            @if($statusval == $key)
                                                                <option selected="true" value="{{$key}}">{{$value}}</option>
                                                            @else
                                                                <option  value="{{$key}}">{{$value}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                        --}} 
                                        <div class="col-md-2">
                                            <label class="mb-0">Vendor</label>
                                            <select name="vendor" class="fstdropdown-select">
                                                <option value="">Select</option>
                                                @if(!empty($vendors))
                                                    @foreach($vendors as $key => $value)
                                                        @if($key == $vendorval)
                                                            <option selected="true" value="{{$key}}">{{$value}}</option>
                                                        @else
                                                            <option value="{{$key}}">{{$value}}</option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>
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
                                        <div class="col-md-3 mb-3 px-3">
                                            <label></label>
                                            <input style="margin-top:23px" type="submit" name="find" value="find" class="btn btn-success">
                                            <input style="margin-top:23px" type="submit" name="export_to_excel" value="Export To Csv" class="btn btn-primary">
                                        </div>

                                    </div>

                                </form>


                            </div>
                            <div id="hide_2" class="table-responsive">

                            </div>
                        </div>

                    </div>
                    @if(!empty($entries))
                        <div class="col-md-12 mt-3 mb-4">

                            <div class="container-fluid mt-3">
                            </div>
                            <div id="hide_2" class="table-responsive">

                        </div>
                                <table id="table" data-toggle="table" data-search="true" export-all="true" data-filter-control="true"
                                    data-show-export="true" data-show-refresh="true" data-show-toggle="true"
                                     data-toolbar="#toolbar">
<div class="row " style="margin-bottom:16px">
                                    <div class="col-md-6">
                                        <h2 class="form-control-sm yash_heading form_style"><i
                                                class="fas fa-database mr-2"></i><b>No. Of Trips : {{$entries->total()}}</b></h2>
                                    </div>
                                </div>                                                                     
                                    <thead>
                                        <tr>
                                            <th data-field="state" data-checkbox="true"></th>
                                            <th data-field="dae3te" data-sortable="true">Slip No</th>
                                            <th data-field="dat32e" data-sortable="true">Kanta Slip No</th>
                                            <th data-field="datq32e" data-sortable="true">Vehicle No.</th>
                                            <th>Vehicle Pass Weight</th>
                                            <th data-sortable="true">Vendor</th>

                                            <th data-field="dat2323e" data-sortable="true">Net Weight</th>
                                            <th data-field="dat2323sse" data-sortable="true">Tare Weight</th>
                                            <th data-sortable="true">Gross Weight</th>
                                            <th data-field="d33at2323e" data-sortable="true">Loading Plant</th>
                                            <th data-sortable="true">Supervisor</th>

                                            <th data-field="d33at2323ew" data-sortable="true">Unloading Site</th>
                                            <th data-sortable="true">Loading Date</th>
                                            <th data-sortable="true">Loading Time</th>
                                            <th data-sortable="true">Dispatch Date</th>
                                            <th  data-sortable="true">Dispatch Time</th>
                                            <th>Item</th>
                                            <th data-sortable="true">Created By</th>
                                            <th data-sortable="true">Created At</th>
                                            <th data-field="note13" data-sortable="true">Action</th>
                                            <th>Print Slip</th>
                                            <th>Print Challan</th>
                                        </tr>
                                    </thead>
                                  
                                    <tbody>
                                        @foreach ($entries as $key => $value)
                                            <?php
                                            $encrypt_id = enCrypt($value->slip_no);
                                            $item  = !empty($value->items_included) ? json_decode($value->items_included) : [];
                                            $main_item_arr = [];
                                            if(!empty($item)){
                                                foreach($item as $i => $tem){
                                                    $main_item_arr[] = $items[$tem]; 
                                                }
                                            }
                                            else{
                                                $main_item_arr = [];
                                            }
                                            ?>
                                            <tr>
                                                <td></td>
                                               
                                                <td>{{ !empty($value->series) ? $value->series.$value->slip_no: $value->slip_no }}</td>
                                                <td>{{ !empty($value->kanta_slip_no) ? $value->kanta_slip_no : ''}}</td>
                                                <td>{{ !empty($vehciles[$value->vehicle]) ? $vehciles[$value->vehicle] : ''}}</td>
                                                <td>{{ !empty($value->vehicle_pass) ? $value->vehicle_pass : ''}} KG</td>
                                                <td>{{ !empty($vendors[$value->vendor_id]) ? $vendors[$value->vendor_id ] : ''}}</td>
                                                <td>{{ !empty($value->net_weight) ? $value->net_weight : '0'}} KG</td>
                                                <td>{{!empty($value->entry_weight) ? $value->entry_weight : '' }} KG</td>
                                                <td>{{ !empty($value->gross_weight) ? $value->gross_weight.' KG ' : '0 KG' }}</td>
                                                <td>{{ !empty($plants[$value->plant]) ? $plants[$value->plant] : '' }}</td>
                                                <td>{{ !empty($supervisors[$value->supervisor]) ? $supervisors[$value->supervisor] : '' }}</td>
                                                <td>{{ !empty( $sites[$value->site] ) ? $sites[$value->site] : '' }}</td>
                                                <td>{{ !empty($value->datetime) ? date('d-m-Y' , strtotime($value->datetime)) : ''}}</td>
                                                <td>{{!empty($value->loading_minutehours) ? date('h:i:A' , strtotime($value->loading_minutehours)) : '' }}</td>
                                                <td>{{ !empty($value->generation_time) ? date('d-m-Y' , strtotime($value->generation_time)) : '' }}</td>
                                                <td>{{ !empty($value->generation_minutehours) ? date('h:i:A' , strtotime($value->generation_minutehours)) : '' }}</td>
                                                <td>{{ !empty($main_item_arr) ? implode(',' , $main_item_arr) : '' }}</td>
                                                <td> {{ !empty($users[$value->created_by]) ? $users[$value->created_by] : '' }} </td>
                                                <td> {{ !empty($value->created_at) ? date('d-m-Y' , strtotime($value->created_at)) : '' }} </td>
                                               <td> 
                                                <span class="dropdown open">
                                                    <button style="width: 100%;" id="btnGroup" type="button" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="true"
                                                        class="btn btn-primary btn-sm dropdown-toggle dropdown-menu-right">
                                                        <i class="fas fa-cog"></i>
                                                    </button>
                                                    <span  aria-labelledby="btnGroup"
                                                        class="dropdown-menu mt-1 dropdown-menu-right">
                                                            @php
                                                                $admin  = App\Models\User::is_admin();
                                                                $supervisor = App\Models\User::is_supervisor();
                                                            @endphp
                                                        <form action="{{ url('ManualChallan/edit', $value->id) }}"
                                                            method="GET" class="blockuie dropdown-item"
                                                            style="margin-bottom:-10px">
                                                            @csrf

                                                            <button style="background:none;border: none;"
                                                                type="submit"><i class="fas fa-pencil-alt"></i>
                                                                {{$value->is_generated == 1 ? 'Edit Challan' : 'Generate Challan'}}</button>     
                                                        </form>
                                                        @if($value->is_generated == 0)
                                                        @php
                                                            $show = 0;
                                                            if(date('Y-m-d' , strtotime($value->datetime)) == date('Y-m-d')){
                                                                $show = 1;
                                                            }
                                                            if($admin || $supervisor){
                                                                $show = 1;
                                                            }
                                                        @endphp
                                                        @if($show == 1)
                                                        <form action="{{ url('EntryForm_action', $encrypt_id) }}"
                                                            method="GET" class="blockuie dropdown-item"
                                                            style="margin-bottom:-10px">
                                                            @csrf
                                                            <button style="background:none;border: none;"
                                                                type="submit"><i class="fas fa-pencil-alt"></i>
                                                                Generate Challan</button>
                                                        </form>
                                                        @endif
                                                        @endif
                                                        @php
                                                            $show = 0;
                                                            if(date('Y-m-d' , strtotime($value->datetime)) == date('Y-m-d')){
                                                                $show = 1;
                                                            }
                                                            if($admin || $supervisor){
                                                                $show = 1;
                                                            }                                           
                                                        @endphp
                                                        @if($show == 1)
                                                        <form action="" method="GET" class="blockuie dropdown-item"
                                                                style="margin-bottom:-10px">
                                                                @csrf
                                                                <input type="text" id="route_id{{$value->id}}" name="route" hidden
                                                                    value="{{ 'EntryForm_delete' }}">
                                                                <input type="text" id="delete_id{{$value->id}}"  name="id" hidden
                                                                    value="{{ $encrypt_id }}">
                                                                <button style="background:none;border: none;"
                                                                    type="button" onclick="confirMationAlert({{$value->id}})"><i
                                                                        class="fas fa-trash"
                                                                         ></i> Cancel Slip
                                                                </button>
                                                        </form>        
                                                        @endif           
                                                    </span>
                                                </span>
                                               </td>
                                        <td>
                                                @if(empty($value->excess_weight) || $value->excess_weight <= 0)
                                                    <a style="width: 100%;" target="_blank" href="{{ url('PrintEntrySlip'.'/'.$value->slip_no) }}" id="btnGroup" type="button" 
                                                        aria-haspopup="true" aria-expanded="true"
                                                        class="btn btn-primary btn-sm ">
                                                        Print Loading slip : {{$value->slip_no}}
                                                    </a>                                            
                                                @else
                                                    <span class="text-danger mt-2">Excess</span>
                                                @endif
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
                                     {{ $entries->links() }}
                                </div>                                 
                            </div>
                        </div>
                    @endif

                    <!-- Close Row -->
                </div>

                <!-- Close Container -->
            </div>
           

        @endsection
