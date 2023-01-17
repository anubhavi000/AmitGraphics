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

                            <h5>Vehicles</h5>

                            <p class="heading_Bottom">Complete list of Vehicles</p>

                        </div>

                    </div>

                    <div class="col-lg-8">

                        <div class="row justify-content-end mr-2">

                            <div class="buttons" style="margin:4px;">



                                <a href="{{ url('Vehicle/create') }}"><button type="button"
                                        class="btn btn-success btn_new"><i class="fas fa-plus mr-2"></i>Add New</button></a>

                            </div>

                            <div class="buttons" style="margin:4px;">



                                <a href="{{ url('VehicleConsumption') }}"><button type="button" class="btn btn-success"><i
                                            class="fas fa-plus mr-2"></i>Consumption</button></a>

                            </div>



                            <!--<div class=" buttons dropdown" style="margin-top:5px ; margin-left:5px ; margin-right:21px">-->

                            <!--         <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-file-alt"></i> Reports-->

                            <!--         </button>-->

                            <!--         <div class="dropdown-menu syn_drop" aria-labelledby="dropdownMenuButton">-->

                            <!--             <a class="dropdown-item" href='{{ url('report/vehicle') }}'><i class="fas fa-file-alt mr-2"></i> View</a>-->



                            <!--             <a class="dropdown-item" href='{{ url('report/vehicle_pdf') }}'><i class="fas fa-file-alt mr-2"></i> Download PDF</a>-->

                            <!--             <a class="dropdown-item" href="#"><i class="fas fa-address-book mr-2"></i> Download XLS</a>-->





                            <!--         </div>-->

                            <!--     </div>-->

                        </div>

                    </div>

                </div>





                <div class="container-fluid bg-white mt-2 mb-5 border_radius box">
                    <form class="form-horizontal" action="" method="get" id="user-search" role="form"
                        enctype="multipart/form-data">
                        <div class="row">

                            <div class="col-md-12 mt-3 mb-3">



                                <div class="container-fluid mt-3">

                                    <div class="row">

                                        <div class="col-md-3">

                                            <label for="client_id">Vehicle Id</label>

                                            <fieldset>

                                                <div class="input-group client_margin">

                                                    <span class="input-group-addon bg-primary border-primary white"
                                                        id="basic-addon7"
                                                        style="width: 43px;display: flex;justify-content: center;align-items: center;font-size: 23px;color: white;background-color: #4f81a4 !important;border: #4f81a4;"><i
                                                            class="fas fa-briefcase"></i></span>

                                                    <input type="text" name="vehicle_id" class="form-control" id="file_no"
                                                        placeholder="Enter Vehicle Id Here"
                                                        value="{{ Request::get('vehicle_id') }}">





                                                </div>

                                            </fieldset>

                                        </div>

                                        {{-- <div class="col-md-3">

                <label for="client_id">Vehicle Name</label>

                  <fieldset>

                    <div class="input-group client_margin">

                        <span class="input-group-addon bg-primary border-primary white" id="basic-addon7" style="width: 43px;display: flex;justify-content: center;align-items: center;font-size: 23px;color: white;background-color: #4f81a4 !important;border: #4f81a4;"><i class="fas fa-briefcase"></i></span>

                <input type="text" name="vehicle_name" class="form-control" id="file_no" placeholder="Enter Vehicle Name Here" value="{{ Request::get('vehicle_name') }}">



                        

                    </div>

                </fieldset>

              </div> --}}

                                        <div class="col-md-3">

                                            <label for="select_client" style="margin-bottom: -1px;">Plant</label>

                                            <select class='fstdropdown-select' id="first" name="plant">

                                                <option value="">Select</option>

                                                @foreach ($plant as $each_plant)
                                                    @if (Request::get('plant') == $each_plant->id)
                                                        <option value="{{ $each_plant->id }}" selected>
                                                            {{ $each_plant->name }}</option>
                                                    @else
                                                        <option value="{{ $each_plant->id }}">{{ $each_plant->name }}
                                                        </option>
                                                    @endif
                                                @endforeach

                                            </select>

                                        </div>

                                        <div class="col-md-3">
                                            <label for="select_client" style="margin-bottom: -1px;">Status</label>

                                            <select class='fstdropdown-select' id="first" name="status">

                                                <option value="">Select</option>


                                                @if (Request::get('status') == 1)
                                                    <option value="1" selected>Active</option>
                                                    <option value="0">Inactive</option>
                                                @elseif(Request::get('status') == 0 && Request::get('status')!=null)
                                                    <option value="1">Active</option>
                                                    <option value="0" selected>Inactive</option>
                                                @else
                                                    <option value="1" >Active</option>
                                                    <option value="0">Inactive</option>
                                                @endif

                                            </select>

                                        </div>

                                        <div class="col-md-3">

                                            <label for="client_id">Driver Name</label>

                                            <fieldset>

                                                <div class="input-group client_margin">

                                                    <span class="input-group-addon bg-primary border-primary white"
                                                        id="basic-addon7"
                                                        style="width: 43px;display: flex;justify-content: center;align-items: center;font-size: 23px;color: white;background-color: #4f81a4 !important;border: #4f81a4;"><i
                                                            class="fas fa-briefcase"></i></span>

                                                    <input type="text" name="driver_name" class="form-control"
                                                        id="file_no" placeholder="Enter Driver Name Here"
                                                        value="{{ Request::get('driver_name') }}">





                                                </div>

                                            </fieldset>

                                        </div>

                                        <div class="col-md-3">

                                            <label for="client_id">Helper Name</label>

                                            <fieldset>

                                                <div class="input-group client_margin">

                                                    <span class="input-group-addon bg-primary border-primary white"
                                                        id="basic-addon7"
                                                        style="width: 43px;display: flex;justify-content: center;align-items: center;font-size: 23px;color: white;background-color: #4f81a4 !important;border: #4f81a4;"><i
                                                            class="fas fa-briefcase"></i></span>

                                                    <input type="text" name="helper_name" class="form-control"
                                                        id="file_no" placeholder="Enter Helper Name Here"
                                                        value="{{ Request::get('helper_name') }}">





                                                </div>

                                            </fieldset>

                                        </div>

                                        <div class="col-md-3">

                                            <label for="client_id">Helper Number</label>

                                            <fieldset>

                                                <div class="input-group client_margin">

                                                    <span class="input-group-addon bg-primary border-primary white"
                                                        id="basic-addon7"
                                                        style="width: 43px;display: flex;justify-content: center;align-items: center;font-size: 23px;color: white;background-color: #4f81a4 !important;border: #4f81a4;"><i
                                                            class="fas fa-briefcase"></i></span>

                                                    <input type="text" name="helper_no" class="form-control" id="file_no"
                                                        placeholder="Enter Helper Contact Number"
                                                        value="{{ Request::get('helper_no') }}">





                                                </div>

                                            </fieldset>

                                        </div>

                                        <div class="col-md-3">

                                            <label for="client_id">Driver Number</label>

                                            <fieldset>

                                                <div class="input-group client_margin">

                                                    <span class="input-group-addon bg-primary border-primary white"
                                                        id="basic-addon7"
                                                        style="width: 43px;display: flex;justify-content: center;align-items: center;font-size: 23px;color: white;background-color: #4f81a4 !important;border: #4f81a4;"><i
                                                            class="fas fa-briefcase"></i></span>

                                                    <input type="text" name="driver_no" class="form-control" id="file_no"
                                                        placeholder="Enter Driver Contact Number"
                                                        value="{{ Request::get('driver_no') }}">





                                                </div>

                                            </fieldset>

                                        </div>

                                        <div class="col-md-3"><label for="select_client"
                                                style="margin-bottom: -1px;">Vehicle Type</label>

                                            <select class='fstdropdown-select' name="vehicle_type">

                                                <option value="">Select</option>

                                                @foreach ($vehicle_type as $vehicletypes)
                                                    @if (Request::get('vehicle_type') == $vehicletypes->id)
                                                        <option value="{{ $vehicletypes->id }}" selected>
                                                            {{ $vehicletypes->vehicle_type }}</option>
                                                    @else
                                                        <option value="{{ $vehicletypes->id }}">
                                                            {{ $vehicletypes->vehicle_type }}</option>
                                                    @endif
                                                @endforeach

                                            </select>

                                        </div>
                                        <div class="col-md-4 mb-3 px-3">
                                            <label></label>
                                            <input style="margin-top:23px" type="submit" name="find" value="find"
                                            class="btn btn-success">
                                        <input style="margin-top:23px" type="submit" name="export_to_excel"
                                            value="Export To Csv" class="btn btn-primary">
                                            <input style="margin-top:23px" type="submit" name="export_to_pdf"
                                            value="Export To PDF" class="btn btn-info">
                                        </div>

                                    </div>

                                    <hr class="border-dark bold">

                                    <div id="hide_2" class="table-responsive">

                                        <!--<div id="toolbar">-->

                                        <!--    <select class="form-control">-->

                                        <!--        <option value="">Export Basic</option>-->

                                        <!--        <option value="all">Export All</option>-->

                                        <!--        <option value="selected">Export Selected</option>-->

                                        <!--    </select>-->

                                        <!--</div>-->



                                        <table id="table" data-toggle="table" data-search="true" data-filter-control="true"
                                            data-show-export="true" data-show-refresh="true" data-show-toggle="true"
                                            data-pagination="true" data-toolbar="#toolbar">

                                            <thead>

                                                <tr>

                                                    <th data-field="state" data-checkbox="true"></th>

                                                    <th data-field="prenom" data-sortable="true">Id</th>

                                                    <th data-field="date" data-sortable="true">Vehicle No.</th>

                                                    {{-- <th data-field="note3" data-sortable="true">Vehicle Type </th> --}}
                                                    <th data-field="note3" data-sortable="true">Fuel Type </th>

                                                    <th data-field="note31" data-sortable="true">Manufacturer</th>

                                                    <th data-field="note32" data-sortable="true">Owner Name</th>

                                                    <th data-field="note33" data-sortable="true">Driver Name</th>
                                                    {{-- <th data-field="notse33" data-sortable="true">Executive Name</th> --}}
                                                    <th data-field="notse3dd3" data-sortable="true">Plant</th>
                                                    <th data-field="notsegddg33" data-sortable="true">IMEI No</th>
                                                    <th data-field="notsegg33" data-sortable="true">Status</th>

                                                    <th data-field="note13" data-sortable="true">Action</th>

                                                </tr>

                                            </thead>

                                            <tbody>

                                                <?php
                                                
                                                $i = 1;
                                                
                                                $flag = 0;
                                                
                                                ?>

                                                @foreach ($vehicle_info as $vehicle)
                                                    <?php $encrypt_id = enCrypt($vehicle->id); ?>

                                                    <tr>

                                                        <td class="bs-checkbox "><input data-index="0" name="btSelectItem"
                                                                type="checkbox"></td>

                                                        <td><a href='{{ url("vehiclepdf/{$encrypt_id}") }}'
                                                                class="text-primary">{{ $vehicle->vehicle_char_id }}</a>
                                                        </td>

                                                        <td>{{ $vehicle->number }}</td>

                                                        <td>{{ !empty($vehicle->fuel_type)?$vehicle->fuel_type:'' }}</td>



                                                        <td>{{ $vehicle->manufacturername }}</td>

                                                
                                                        <td>{{ $vehicle->ownername }}</td>

                                                        <td>{{ $vehicle->drivername }}</td>
                                                        {{-- <td>{{ $vehicle->emp_full_name }}</td> --}}
                                                        <td>{{ $vehicle->plant_name }}</td>
                                                        <td>{{ $vehicle->gps_device_imei_number }}</td>
                                                        <td>{{ $vehicle->onBoard==1?'Active':'In Active' }}</td>
                                                        <?php $encrypt_id = enCrypt($vehicle->id); ?>
                                                        <td><span class="dropdown open">
                                                                <button id="btnGroup" type="button" data-toggle="dropdown"
                                                                    aria-haspopup="true" aria-expanded="true"
                                                                    class="btn btn-primary btn-sm dropdown-toggle dropdown-menu-right">
                                                                    <i class="fas fa-cog"></i>
                                                                </button>
                                                                <span aria-labelledby="btnGroup"
                                                                    class="dropdown-menu mt-1 dropdown-menu-right">
                                                                    <form
                                                                        action="{{ route('Vehicle.edit', $encrypt_id) }}"
                                                                        method="GET">
                                                                        @csrf
                                                                        <button type="submit"
                                                                            style="background:none;border: none;"> <i
                                                                                class="fas fa-pencil-alt"></i> Edit</button>

                                                                    </form>

                                                                

                                                                    <form action="" method="GET" class="blockuie dropdown-item"
                                                                    style="margin-bottom:-10px">
                                                                    @csrf
                                                                    <input type="text" id="route_id{{$vehicle->id}}" name="route" hidden
                                                                        value="{{ 'Vehicle' }}">
                                                                    <input type="text" id="delete_id{{$vehicle->id}}"  name="id" hidden
                                                                        value="{{ $vehicle->id}}">
                                                                    <button style="background:none;border: none; margin-left:-20px;"
                                                                        type="button" onclick="confirMationAlert({{$vehicle->id}})"><i
                                                                            class="fas fa-trash"
                                                                             ></i> delete</button>
                                                                </form>


                                                                </span>

                                                            </span></td>
                                                    </tr>
                                                    <?php
                                                    $i++; ?>
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

                <!-- <svg xmlns="" version="1.1">

          <defs>

            <filter id="goo">

              <feGaussianBlur in="SourceGraphic" result="blur" stdDeviation="10"></feGaussianBlur>

              <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0 0 1 0 0 0 0 0 1 0 0 0 0 0 21 -7" result="goo"></feColorMatrix>

              <feBlend in2="goo" in="SourceGraphic" result="mix"></feBlend>

            </filter>

          </defs>

        </svg> -->
            @endsection
