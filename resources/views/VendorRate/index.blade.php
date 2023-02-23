@extends('layouts.panel')



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

                            <h5>Vendor Rate</h5>

                            <p class="heading_Bottom">Complete list of Vendor Rate</p>

                        </div>

                    </div>

                    <div class="col-lg-8">

                        <div class="row justify-content-end mr-2">

                            <div class="buttons" style="margin:4px;">


                                {{--
                                <a href="{{ url('VendorRateMaster/create') }}"><button type="button"
                                        class="btn btn-success btn_new"><i class="fas fa-plus mr-2"></i>Add New</button></a>
                                --}}
                            </div>

                        </div>

                    </div>

                </div>





                <div class="container-fluid bg-white mt-2 mb-5 border_radius box">
                    <form class="form-horizontal" action="" method="get" id="user-search" role="form"
                        enctype="multipart/form-data">
                        <div class="row">

                            <div class="col-md-12 mt-3 mb-3">
                            <div class="container-fluid mt-3">
                                <form action="" method="GET" id="user-search">
                                    @csrf
                                    <div class="row">
                                        @php
                                            $vendor_requested = !empty(Request::get('vendor')) ? Request::get('vendor') : '';
                                        @endphp
                                        <div class="col-md-2">
                                            <label>Vendor</label>
                                            <select required="true" class="fstdropdown-select" name="vendor">
                                                <option value="">Select</option>
                                                @if(!empty($vendors))
                                                    @foreach($vendors as $key => $value)
                                                        @if($key == $vendor_requested)
                                                        <option selected="true" value="{{$key}}">{{$value}}</option>
                                                        @else
                                                        <option value="{{$key}}">{{$value}}</option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>                                        
                                        @php
                                            $requested_site = !empty(Request::get('site')) ? Request::get('site') : '';
                                        @endphp
                                        <div class="col-md-2">
                                            <fieldset>
                                            <label>unloading Site</label>
                                            <select required="true" name="site" id="site" class="fstdropdown-select">
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
                                            </fieldset>                                            
                                        </div>   
                                        <div class="col-md-2">
                                            <label>From Date</label>
                                            <input type="text" value="{{!empty(Request::get('from_date')) ? Request::get('from_date') : ''}}" placeholder="From Date" name="from_date" class="form-control datepicker">
                                        </div>              
                                        <div class="col-md-2">
                                            <label>To Date</label>
                                            <input type="text" value="{{!empty(Request::get('to_date')) ? Request::get('to_date') : ''}}" name="to_date" placeholder="To Date" class="form-control datepicker">
                                        </div>
                                        <div class="col-md-3 mb-3 px-3">
                                            <label></label>
                                            <input style="margin-top:23px" type="submit" name="find" value="find" class="btn btn-success">
                                        </div>                                        
                                    </div>
                                </form>
                                @if($createform != 0)
                                <div class="container-fluid mt-3">
                                    <form id="storeform" method="post" action="{{route('VendorRateMaster.store')}}">
                                        @csrf
                                    @if(!empty(Request::get('from_date')) && !empty(Request::get('to_date')))
                                        <h6 class="text-success">Create New Entry For {{$vendors[$vendor_requested]}} And site {{$sites[$requested_site]}} From {{Request::get('from_date')}} To {{Request::get('to_date')}}</h6>                     
                                    @endif
                                    <div class="row">
                                        <input type="hidden" name="vendor" value="{{Request::get('vendor')}}">
                                        <input type="hidden" name="site" value="{{Request::get('site')}}">
                                        <input type="hidden" name="from_date" value="{{Request::get('from_date')}}">
                                        <input type="hidden" name="to_date" value="{{Request::get('to_date')}}">
                                        <div class="col-md-2">
                                            <label>Rate / Ton</label>
                                            <input type="text" placeholder="Enter Rate / Ton" class="form-control" name="rate_ton">
                                        </div>
                                        <div class="col-md-2">
                                            <label></label>
                                            <input style="margin-top:23px" type="submit" name="create" value="Assign" class="btn btn-success">
                                        </div>     
                                    </div>                                                   
                                    </form>
                                </div> 
                                @endif      
                                    <div id="hide_2" class="table-responsive">

                                        <table id="table" data-toggle="table" data-search="true" data-filter-control="true"
                                            data-show-export="true" data-show-refresh="true" data-show-toggle="true"
                                            data-pagination="true" data-toolbar="#toolbar">

                                            <thead>

                                                <tr>

                                                    <th data-field="prenom" data-sortable="true">S.No</th>

                                                    <th data-field="date" data-sortable="true">Vendor Name</th>

                                                    <th data-sortable="true">Site Name</th>

                                                    <th data-field="note31" data-sortable="true">From Date</th>

                                                    <th data-field="note322" data-sortable="true">To Date</th>

                                                    <th data-sortable = "true">Rate / Ton</th>

                                                    <th data-field="note32" data-sortable="true">Action</th>
                                                </tr>

                                            </thead>

                                            <tbody>
                                                @if(!empty($data))
                                                @foreach ($data as $key => $value)
                                                    <?php $encrypt_id = enCrypt($value->id); ?>

                                                    <tr>

                                                        <td class="bs-checkbox "><input data-index="0" name="btSelectItem"
                                                                type="checkbox"></td>

                                                        <td>{{ $key + 1 }}</td>

                                                        <td>{{ !empty($vendors[$value->vendor]) ? $vendors[$value->vendor] : '' }}</td>

                                                        <td>{{ !empty($value->from_date) ? date('d-m-Y' , strtotime($value->from_date)) : ''}}</td>

                                                        <td>{{ !empty($value->to_date) ? date('d-m-Y' , strtotime($value->to_date)) : '' }}</td>

                                                        <td>{{ !empty($value->rate_ton) ? $value->rate_ton : '' }}</td>
                                                                                                        <td>
                                                <span class="dropdown open">
                                                    <button id="btnGroup" type="button" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="true"
                                                        class="btn btn-primary btn-sm dropdown-toggle dropdown-menu-right">
                                                        <i class="fas fa-cog"></i>
                                                    </button>
                                                    <span aria-labelledby="btnGroup"
                                                        class="dropdown-menu mt-1 dropdown-menu-right">
                                                        <a href ="{{ route('VendorRateMaster.edit', $encrypt_id) }}"
                                                            method="GET" class="blockuie dropdown-item"
                                                            style="margin-bottom:-10px;margin-left: -17px;">
                                                                <i  class="fas fa-pencil-alt"></i>
                                                                <span style="font-size: 16px;color: black;"><b>Edit</b></span>
                                                        </a>

                                                                

                                                                    <form action="" method="GET" class="blockuie dropdown-item"
                                                                    style="margin-bottom:-10px">
                                                                    @csrf
                                                                    <input type="text" id="route_id{{$value->id}}" name="route" hidden
                                                                        value="{{ 'vendorrate_delete' }}">
                                                                    <input type="text" id="delete_id{{$value->id}}"  name="id" hidden
                                                                        value="{{ $value->id}}">
                                                                    <button style="background:none;border: none; margin-left:-20px;"
                                                                        type="button" onclick="confirMationAlert({{$value->id}})"><i
                                                                           style="margin-left: 5px;" class="fas fa-trash"
                                                                             ></i> delete</button>
                                                                </form>


                                                                </span>

                                                            </span></td>
                                                    </tr>
                                                @endforeach
                                                @endif
                                            </tbody>

                                        </table>

                                    </div>

                                </div>

                            </div>

                            <!-- Close Row -->

                        </div>

                        <!-- Close Container -->
                </div>

            @endsection
