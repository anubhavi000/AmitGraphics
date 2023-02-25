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
                                            <label class="mb-0">From Date</label>
                                            <input type="text" value="" placeholder="From Date" name="from_date" class="form-control datepicker">
                                        </div>              
                                        <div class="col-md-2">
                                            <label class="mb-0">To Date</label>
                                            <input type="text" value="" name="to_date" placeholder="To Date" class="form-control datepicker">
                                        </div>
                                        @php
                                            $vendorval = !empty(Request::get('vendor')) ? Request::get('vendor') : '';
                                        @endphp    
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
                    @if(!empty($data))
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
                                                class="fas fa-database mr-2"></i><b>No. Of Trips : {{$data->total()}}</b></h2>
                                    </div>
                                </div>                                                                     
                                    <thead>
                                        <tr>
                                            <th data-field="state" data-checkbox="true"></th>
                                            <th data-field="dae3te" data-sortable="true">Payment Date</th>
                                            <th data-field="dat32e" data-sortable="true">Vendor</th>
                                            <th data-field="datq32e" data-sortable="true">Amount</th>
                                            <th>Narration</th>
                                            <th data-sortable="true">Created At</th>
                                            <th data-sortable="true">Created By</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                  
                                    <tbody>
                                        @foreach ($data as $key => $value)
                                        <?php
                                            $encrypt_id = encrypt($value->id);
                                        ?>
                                            <tr>
                                                <td></td>
                                                <td> {{ !empty($value->date) ? date('d-m-Y' , strtotime($value->date))  : '' }} </td>
                                                <td> {{ !empty($vendors[$value->vendor]) ? $vendors[$value->vendor] : '' }} </td>
                                                <td> {{ !empty($value->amount) ? number_format($value->amount) : '' }} </td>
                                                <td> {{ !empty($value->narration) ? $value->narration : '' }} </td>
                                                <td> {{ !empty($value->created_at) ? date('d-m-Y' , strtotime($value->created_at)) : '' }} </td>
                                                <td> {{ !empty($users[$value->created_by]) ? $users[$value->created_by] : '' }} </td>
                                               <td> 
                                                <span class="dropdown open">
                                                    <button id="btnGroup" type="button" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="true"
                                                        class="btn btn-primary btn-sm dropdown-toggle dropdown-menu-right">
                                                        <i class="fas fa-cog"></i>
                                                    </button>
                                                    <span aria-labelledby="btnGroup"
                                                        class="dropdown-menu mt-1 dropdown-menu-right">
                                                        <form action="{{ route('PaymentForm.edit', $encrypt_id) }}"
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
                                                                    value="{{ 'PaymentForm_delete' }}">
                                                                <input type="text" id="delete_id{{$value->id}}"  name="id" hidden
                                                                    value="{{ $encrypt_id }}">
                                                                <button style="background:none;border: none;"
                                                                    type="button" onclick="confirMationAlert({{$value->id}})"><i
                                                                        class="fas fa-trash"
                                                                         ></i> Delete</button>
                                                            </form>
                                                    </span>
                                                </span>
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
                    @endif

                    <!-- Close Row -->
                </div>

                <!-- Close Container -->
            </div>
           

        @endsection
