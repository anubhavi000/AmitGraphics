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
                                {{--
                                <a href="{{ route('GeneratedSlips') }}"><button type="button"
                                        class="btn btn-success btn_new"><i class="fas fa-plus mr-2"></i>Generated Slips</button>
                                </a>
                                --}}
                                <a href="{{ url('EntryForm/create') }}"><button type="button"
                                        class="btn btn-success btn_new"><i class="fas fa-plus mr-2"></i>Add New</button>
                                </a>
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
                                                        placeholder="Enter Weighbridge Slip No">
                                                </div>
                                            </fieldset>
                                        </div>  
                                        <div class="col-md-2">
                                            <label class="mb-0">From Date</label>
                                            <input type="text" class="datepicker form-control" value="{{ !empty( Request::get('from_date')) ? Request::get('from_date') : date('d-m-Y') }}" placeholder="From Date" class="datepicker form-control" name="from_date">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="mb-0">To Date</label>
                                            <input type="text" class="datepicker form-control" placeholder="To Date" value="{{ !empty(Request::get('to_date')) ? Request::get('to_date') : date('d-m-Y') }}" name="to_date">
                                        </div>    
                                        @php
                                            $statusval = !empty(Request::get('status')) ? Request::get('status') : ''; 
                                            $opt_arr = [
                                                    0 => 'Generated',
                                                    1 => 'Not Generated'
                                                 ];
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
                                            <label class="mb-0">Vehicle</label>
                                            <select name="vehicle" class="fstdropdown-select">
                                                        <option value="">Please Select</option>
                                                @if(!empty($vehicle_mast))
                                                    @foreach($vehicle_mast as $key => $value)
                                                        <option {{(Request::get('vehicle') == $key)?'selected':''}} value="{{$key}}">{{$value}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>           
                                        <div class="col-md-3 mb-3 px-3">
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
                    @if(!empty($entries))
                        <div class="col-md-12 mt-3 mb-3">

                            <div class="container-fluid mt-3">
                            </div>
                            <div id="hide_2" class="table-responsive">

                                <table id="table" data-toggle="table" data-search="true" data-filter-control="true"
                                    data-show-export="true" data-show-refresh="true" data-show-toggle="true"
                                    data-pagination="true" data-toolbar="#toolbar">
                                    <thead>
                                        <tr>
                                            <th data-field="state" data-checkbox="true"></th>
                                            <th data-field="dae3te" data-sortable="true">Slip No</th>
                                            <th data-field="dat32e" data-sortable="true">Weighbridge Slip No</th>
                                            <th data-field="da1t32e" data-sortable="true">Vehicle Number</th>
                                            <th data-field="dat2323sse" data-sortable="true">Tare Weight</th>
                                            <th data-field="d33at2323e" data-sortable="true">Unloading Site</th>
                                            <th data-field="d33at2323ew" data-sortable="true">Loading Plant</th>
                                            <th>Date</th>
                                            <th data-sortable="true">Crated By</th>
                                            <th data-sortable= "true">Created At</th>
                                            <th data-field="note13" data-sortable="true">Action</th>
                                            <th>Print Slip</th>
                                        </tr>
                                    </thead>
                                  
                                    <tbody>
                                        @foreach ($entries as $key => $value)
                                            <?php
                                            $encrypt_id = enCrypt($value->slip_no);
                                            ?>
                                            <tr>
                                                <td></td>
                                               
                                                <td>{{ !empty($value->series) ? $value->series.$value->slip_no: $value->slip_no }}</td>
                                                <td>{{ !empty($value->kanta_slip_no) ? $value->kanta_slip_no : ''}}</td>
                                                <td>{{ !empty($vehicle_mast[$value->vehicle]) ? $vehicle_mast[$value->vehicle] : ''}}</td>
                                                <td>{{!empty($value->entry_weight) ? $value->entry_weight : '' }} KG</td>
                                                <td>{{ !empty($sites[$value->site]) ? $sites[$value->site] : '' }}</td>
                                                <td>{{ !empty( $plants[$value->plant] ) ? $plants[$value->plant] : '' }}</td>
                                                <td>{{ !empty($value->datetime) ? date('d-m-Y' , strtotime($value->datetime)) : ''}}</td>
                                                <td> {{ !empty($users[$value->created_by]) ? $users[$value->created_by] : ''}} </td>
                                                <td> {{ !empty($value->created_at) ? date('d-m-Y' , strtotime($value->created_at)) : ''}} </td>
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
                                                        {{--
                                                        <form action="{{ url('EntryForm_action', $encrypt_id) }}"
                                                            method="GET" class="blockuie dropdown-item"
                                                            style="margin-bottom:-10px">
                                                            @csrf

                                                            @if($value->is_generated == 0)
                                                            <button style="background:none;border: none;"
                                                                type="submit"><i class="fas fa-pencil-alt"></i>
                                                                {{$value->is_generated == 1 ? 'Edit Challan' : 'Generate Challan'}}</button>
                                                            @elseif($admin || $supervisor)
                                                            <button style="background:none;border: none;"
                                                                type="submit"><i class="fas fa-pencil-alt"></i>
                                                                {{$value->is_generated == 1 ? 'Edit Challan' : 'Generate Challan'}}</button>     
                                                            @endif
                                                        </form>
                                                        --}}
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
                                                        <form action="{{ route('EntryForm.edit', $encrypt_id) }}"
                                                            method="GET" class="blockuie dropdown-item"
                                                            style="margin-bottom:-10px">
                                                            @csrf
                                                            <button style="background:none;border: none;"
                                                                type="submit"><i class="fas fa-pencil-alt"></i>
                                                                Edit Slip</button>
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
                                                        @if($value->is_generated == 0)
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
                                        {{--
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
                                        --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    <!-- Close Row -->
                </div>

                <!-- Close Container -->
            </div>
           

        @endsection
