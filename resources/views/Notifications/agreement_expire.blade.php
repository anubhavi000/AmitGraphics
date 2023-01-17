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
                <div class="row first_row_margin" style="margin-bottom: -12px;">
                    <div class="col-lg-12">
                        <div class="page-header-title">
                            <i class="fas fa-users"></i>
                            <h5>Complete list of Clients Whose Agreement Is Going To Expire In 15 Days</h5>
                          
                        </div>
                    </div>
                    <div class="col-lg-8">

                    </div>
                </div>


                <div class="container-fluid bg-white mt-2 mb-5 border_radius box">
                    <div class="row">
                        <div class="col-md-12 mt-3 mb-3">

                            <hr class="border-dark bold">
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
                                            <th data-field="state" data-checkbox="true">S.no </th>
                                            <th data-field="date12" data-sortable="true">Id</th>
                                            <th data-field="date" data-sortable="true">Client Name</th>
                                            <th data-field="examen" data-sortable="true">Agreement Start Date</th>
                                            <th data-field="note" data-sortable="true">Agreement End Date</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                       @foreach($clients as $i=>$client)
                                       @php
                                       $encrypt_id= enCrypt($client->id);
                                       @endphp
                                       <tr>
                                        <td>{{$i+1}}</td>
                                        <td>
                                            <a href='{{url("clientpdf/{$encrypt_id}")}}' class="text-primary" target="_blank" style="font-size:14px;">{{$client->client_char_id}}</a>
                                        </td>
                                        <td>{{$client->business_name}}</td>
                                        <td>{{date('d-m-Y' , strtotime($client->agreement_start_date))}}</td>
                                        <td>{{date('d-m-Y' , strtotime($client->agreement_end_date))}}</td>
                                        
                                       </tr>
                                       @endforeach
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
