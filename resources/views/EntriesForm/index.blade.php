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
                                <a href="{{ route('GeneratedSlips') }}"><button type="button"
                                        class="btn btn-success btn_new"><i class="fas fa-plus mr-2"></i>Generated Slips</button>
                                </a>
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
                                            <label for="client_id">Kanta Slip No</label>
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
                                            <fieldset>
                                                @php
                                                    $val = !empty(Request::get('from_date')) ?Request::get('from_date') : '';
                                                    
                                                    $opt_arr = [
                                                        'today' => 'Today',
                                                        'last_seven_days' => 'Last 7 Days',
                                                        'last_fifteen_days' => 'Last 15 Days',
                                                        'last_thirty_days' => 'Last 30 Days' 
                                                        ];  
                                                @endphp
                                                <div class="input-group client_margin">
                                                    <label>Datetime</label>
                                                    <select name="from_date" class="fstdropdown-select col-md-3">
                                                        <option value="">Select</option>
                                                        @foreach($opt_arr as $key => $value)
                                                            @if($key == $val)
                                                            <option selected="true" value="{{$key}}">{{$value}}</option>
                                                            @else
                                                                <option value="{{$key}}">{{$value}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </fieldset>                                            
                                        </div>    
                                        @php
                                            $statusval = !empty(Request::get('status')) ? Request::get('status') : ''; 
                                        @endphp
                                        <div class="col-md-2">
                                            <fieldset>
                                                <div class="input-group client_margin">
                                                    <label>Generation Status</label>
                                                    <select value="{{$statusval}}" name="status" class="fstdropdown-select col-md-3">
                                                        <option value="">Select</option>
                                                        <option value="1">Generated</option>
                                                        <option value="0"> Not Generated</option>
                                                    </select>
                                                </div>                                                
                                            </fieldset>
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
                                            <th data-field="date23" width="10" data-sortable="true">S.No</th>

                                            <th data-field="dae3te" data-sortable="true">Slip No</th>
                                            <th data-field="dat32e" data-sortable="true">Kanta Slip No</th>
                                            <th data-field="dat2323e" data-sortable="true">Net Weight</th>
                                            <th data-field="d33at2323e" data-sortable="true">Site</th>
                                            <th data-field="d33at2323ew" data-sortable="true">Plant</th>
                                            <th data-field="note13" data-sortable="true">Action</th>
                                            <th>Print Slip</th>
                                            <th>Print Invoice</th>
                                        </tr>
                                    </thead>
                                  
                                    <tbody>
                                        @foreach ($entries as $key => $value)
                                            <?php
                                            $encrypt_id = enCrypt($value->slip_no);
                                            ?>
                                            <tr>
                                                <td></td>
                                               <td>{{$key+1}}</td>
                                               
                                                <td>{{ !empty($value->series) ? $value->series.$value->slip_no: $value->slip_no }}</td>
                                                <td>{{ !empty($value->kanta_slip_no) ? $value->kanta_slip_no : ''}}</td>
                                                <td>{{ !empty($value->net_weight) ? $value->net_weight : ''}}</td>
                                                <td>{{ !empty($plants[$value->plant]) ? $plants[$value->plant] : '' }}</td>
                                                <td>{{ !empty( $sites[$value->site] ) ? $sites[$value->site] : '' }}</td>
                                               <td> 
                                                <span class="dropdown open">
                                                    <button id="btnGroup" type="button" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="true"
                                                        class="btn btn-primary btn-sm dropdown-toggle dropdown-menu-right">
                                                        <i class="fas fa-cog"></i>
                                                    </button>
                                                    <span aria-labelledby="btnGroup"
                                                        class="dropdown-menu mt-1 dropdown-menu-right">
                                                        <form action="{{ url('EntryForm_action', $encrypt_id) }}"
                                                            method="GET" class="blockuie dropdown-item"
                                                            style="margin-bottom:-10px">
                                                            @csrf
                                                            <button style="background:none;border: none;"
                                                                type="submit"><i class="fas fa-pencil-alt"></i>
                                                                Action</button>
                                                        </form>
                                                        <form action="" method="GET" class="blockuie dropdown-item"
                                                                style="margin-bottom:-10px">
                                                                @csrf
                                                                <input type="text" id="route_id{{$value->id}}" name="route" hidden
                                                                    value="{{ 'Entry_delete' }}">
                                                                <input type="text" id="delete_id{{$value->id}}"  name="id" hidden
                                                                    value="{{ $encrypt_id }}">
                                                                <button style="background:none;border: none;"
                                                                    type="button" onclick="confirMationAlert({{$value->id}})"><i
                                                                        class="fas fa-trash"
                                                                         ></i> delete</button>
                                                            </form>
                                                    </span>
                                                </span>
                                               </td>
                                        <td>
                                                    <a target="blank" href="{{ url('PrintEntrySlip/'.$value->plant.'/'.$value->slip_no) }}" id="btnGroup" type="button" 
                                                        aria-haspopup="true" aria-expanded="true"
                                                        class="btn btn-primary btn-sm ">
                                                        Print slip
                                                    </a>                                            
                                        </td>
                                        <td>
                                            <a target="blank" href="{{ url('print_invoice/'.$value->plant.'/'.$value->slip_no) }}" id="btnGroup" type="button" 
                                                aria-haspopup="true" aria-expanded="true"
                                                class="btn btn-primary btn-sm ">
                                                Print Invoice
                                            </a>                                            
                                        </td>                                               

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
