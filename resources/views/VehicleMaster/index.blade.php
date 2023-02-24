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
                            <h5>Vehicles</h5>
                            <p class="heading_Bottom"> Complete list of Vehicle</p>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="page-header-breadcrumb">
                            <div class="buttons" style="text-align:right;margin:4px;">

                                <a href="{{ route('VehicleMast.create') }}"><button type="button"
                                        class="btn btn-success btn_new"><i class="fas fa-plus mr-2"></i>Add New</button></a>
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
                                                $vehicle_requested = !empty(Request::get('vehicle')) ? Request::get('vehicle') : '';
                                            @endphp
                                        <div class="col-md-2">
                                            <label class="mb-0">Vehicle No.</label>
                                                <select  name="vehicle" class="fstdropdown-select col-md-3">
                                                    <option value="">Select</option>
                                                    @foreach($vehicles as $key => $value)
                                                        @if($vehicle_requested == $key)
                                                            <option selected="true" value="{{$key}}">{{$value}}</option>
                                                        @else
                                                            <option  value="{{$key}}">{{$value}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>                                            
                                        </div>
                                        @php
                                            $statusval = !empty(Request::get('status')) ? Request::get('status') : '';
                                            $status_arr = [
                                                1 => 'Active',
                                                0 => 'Deactivated'
                                            ];
                                        @endphp
                                        <div class="col-md-2">
                                            <label class="mb-0">Status</label>
                                                <select  name="status" class="fstdropdown-select col-md-3">
                                                    <option value="">Select</option>
                                                    @foreach($status_arr as $key => $value)
                                                        @if($key == $statusval)
                                                        <option selected="true" value="{{ $key }}">{{ $value }}</option>
                                                        @else
                                                        <option value="{{ $key }}">{{ $value }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                        </div>
                                        <div class="col-md-1 mt-3">
                                            <button type="submit" name="find" value="find" class="btn btn-primary">Find</button>
                                        </div>
                                        <div class="col-md-1 mt-3">
                                            <input type="submit" value="Export CSV" name="export_to_excel" class="btn btn-primary">
                                        </div>
                                    </div>
                                </form>
                            


                            </div>
                            <div id="hide_2" class="table-responsive">
                                <!--<div id="toolbar">-->
                                <!--  <select class="form-control">-->
                                <!--    <option value="">Export Basic</option>-->
                                <!--    <option value="all">Export All</option>-->
                                <!--    <option value="selected">Export Selected</option>-->
                                <!--  </select>-->
                                <!--</div>-->

                                <table id="table" data-toggle="table" data-search="true" data-filter-control="true"
                                    data-show-export="true" data-show-refresh="true" data-show-toggle="true"
                                    data-pagination="true" data-toolbar="#toolbar">
                                    <thead>
                                        <tr>
                                            <th data-field="state" data-checkbox="true"></th>
                                            <th data-field="date23" data-sortable="true">Serial No</th>

                                            <th data-field="date" data-sortable="true">Vehicle No</th>

                                            <th data-field="type" data-sortable="true">Vehicle Type</th>

                                            {{--<th data-field="code" data-sortable="true">Vehicle Code</th>--}}

                                            <th data-field="pass" data-sortable="true">Vehicle Pass</th>

                                            <th data-field="note" data-sortable="true">Description</th>

                                            <th data-field="link" data-sortable="true">Transporter ID</th>
                                            <th data-sortable="true">Created At</th>
                                            <th data-sortable="true">Created By</th>
                                            <th data-field="note13" data-sortable="true">Action</th>
                                            
                                        </tr>
                                    </thead>
                                  
                                    <tbody>
                                        @if(!empty($data))
                                        @foreach ($data as $key => $value)
                                            <?php
                                                $encrypt_id = enCrypt($value->id);
                                            ?>
                                            <tr>
                                                <td></td>
                                               <td>{{$key+1}}</td>
                                               
                                                <td>{{ !empty($value->vehicle_no) ? $value->vehicle_no : ''}}</td>

                                                <td>{{ !empty($value->type) ? $value->type :''  }}</td>

                                                {{--<td>{{ !empty($value->v_code) ? $value->v_code : '' }}</td>--}}

                                                <td>{{ !empty($value->pass_wt) ? $value->pass_wt : '' }}</td>

                                                <td>{{ !empty($value->descr) ? $value->descr : '' }}</td>

                                                <td>{{ !empty($value->transporter) ? $value->transporter : '' }}</td>
                                                <td> {{ !empty($value->created_at) ? date('d-m-Y' , strtotime($value->created_at)) : '' }} </td>
                                                <td> {{ !empty($value->created_by) ? $users[$value->created_by] : '' }} </td>


                                               <td>
                                                <span class="dropdown open">
                                                    <button id="btnGroup" type="button" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="true"
                                                        class="btn btn-primary btn-sm dropdown-toggle dropdown-menu-right">
                                                        <i class="fas fa-cog"></i>
                                                    </button>
                                                    <span aria-labelledby="btnGroup"
                                                        class="dropdown-menu mt-1 dropdown-menu-right">
                                                        <form action="{{ route('VehicleMast.edit', $encrypt_id) }}"
                                                            method="GET" class="blockuie dropdown-item"
                                                            style="margin-bottom:-10px">
                                                            @csrf

                                                            <button style="background:none;border: none;"
                                                                type="submit"><i class="fas fa-pencil-alt"></i>
                                                                Edit</button>
                                                        </form>
                                                        <form action="" method="GET" class="blockuie dropdown-item"
                                                                style="margin-bottom:-10px">
                                                                @csrf
                                                                <input type="text" id="route_id{{$value->id}}" name="route" hidden
                                                                    value="{{ 'VehicleMast_delete' }}">
                                                                <input type="text" id="delete_id{{$value->id}}"  name="id" hidden
                                                                    value="{{ $encrypt_id }}">
                                                                <button style="background:none;border: none;"
                                                                    type="button" onclick="confirMationAlert({{$value->id}})"><i
                                                                        class="fas fa-trash"
                                                                         ></i> Deactivate</button>
                                                        </form> 

                                                       

                                                    </span>
                                                </span>
                                               </td>

                                            </tr>
                                        @endforeach
                                        @endif
                                    </tbody> 
                                </table>
                            </div>
                        </div>

                    </div>
                    {{-- <svg xmlns="" version="1.1">
                        <defs>
                            <filter id="goo">
                                <feGaussianBlur in="SourceGraphic" result="blur" stdDeviation="10"></feGaussianBlur>
                                <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0 0 1 0 0 0 0 0 1 0 0 0 0 0 21 -7"
                                    result="goo"></feColorMatrix>
                                <feBlend in2="goo" in="SourceGraphic" result="mix"></feBlend>
                            </filter>
                        </defs>
                    </svg> --}}
                    <!-- Close Row -->
                </div>
                <!-- Close Container -->
            </div>
        @endsection
