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
            <div class="row first_row_margin">
                <div class="col-lg-4">
                    <div class="page-header-title">
                        <h5>Diesel Consumption Details</h5>
                        <p class="heading_Bottom">All Diesel Consumption Details Are Here</p>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="buttons" style="text-align:right;margin:4px;">

                        <a href="{{ url(url('DieselConsumption/create')) }}"><button type="button" class="btn btn-success">Add
                                New</button></a>
                    </div>
                </div>
            </div>
                <div class="container-fluid bg-white mt-2 mb-5 border_radius box">
                    <div class="row">
                        <div class="col-md-12 mt-3 mb-3">
                            
                               
                                <div class="container-fluid">
                                    <div class="row">

                                        <div class="col-md-3">
                                            <label for="client">Pharma Client</label>
                                            <input type="text" name="client" id="client" class="form-control client_margin">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="gr_number">GR Number</label>
                                            <input type="text" name="gr_number" id="gr_number"
                                                class="form-control client_margin">

                                        </div>
                                        <div class="col-md-3">
                                            <label for="transporter_name">Transporter Name</label>
                                            <input type="text" name="transporter_name" id="transporter_name"
                                                class="form-control client_margin">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="file_no"></label>
                                            <input type="text" name="file_no" id="file_no"
                                                class="form-control client_margin">
                                        </div>
                                    </div>
                                </div>
                        
                        <hr class="border-dark bold">
                        <div id="hide_2" class="table-responsive">
                            <div id="toolbar">
                                <select class="form-control">
                                    <option value="">Export Basic</option>
                                    <option value="all">Export All</option>
                                    <option value="selected">Export Selected</option>
                                </select>
                            </div>

                            <table id="table" data-toggle="table" data-search="true" data-filter-control="true"
                                data-show-export="true" data-show-refresh="true" data-show-toggle="true"
                                data-pagination="true" data-toolbar="#toolbar" class="table-responsive">
                                <thead>
                                    <tr>
                                        <th data-field="state" data-checkbox="true"></th>
                                        <th data-field="prenom" data-sortable="true">ID</th>
                                        <th data-field="date" data-sortable="true">Plant</th>
                                        <th data-field="examen" data-sortable="true">Diesel In Incinerator</th>
                                        <th data-field="examen2" data-sortable="true">Diesel In Digiset</th>
                                        <th data-field="note" data-sortable="true">Diesel In Boiler</th>
                                        <th data-field="note2" data-sortable="true"> Notes </th>
                                        
                                        <th data-field="note5" data-sortable="true">Updated At  </th>
                                        <th data-field="note7" data-sortable="true">Created At </th>
                                        <th data-field="note8" data-sortable="true">Created By </th>
                                        <th data-field="note9" data-sortable="true">Updated By </th>
                                        <th data-field="note26" data-sortable="true">Action </th>
                                       
                                       


                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php
                                        $i = 1;
                                        ?>
                                        @foreach ($diesel as $details)
                                         
                                         

                                            <td class="bs-checkbox "><input data-index="0" name="btSelectItem"
                                                    type="checkbox"></td>

                                            <td>{{ $i }}</td>
                                            <td>{{ $details->plant }}</td>
                                            <td>{{ $details->diesel_in_incinerator }}</td>
                                            <td>{{ $details->diesel_in_degiset }}</td>
                                            <td>{{ $details->diesel_in_boiler }}</td>
                                            <td>{{ $details->date }}</td>
                                            
                                            <td>{{ $details->updated_at }}</td>
                                            <td>{{ $details->created_at }}</td>
                                            <td>{{ $details->created_by }}</td>
                                            <td>{{ $details->updated_by}}</td>
                                            <td>
                                                <span class="dropdown open">
                                                    <button id="btnGroup" type="button" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="true"
                                                        class="btn btn-primary btn-sm dropdown-toggle dropdown-menu-right">
                                                        <i class="fas fa-cog"></i>
                                                    </button>
                                                    <span aria-labelledby="btnGroup"
                                                        class="dropdown-menu mt-1 dropdown-menu-right">


                                                       

                                                            
                                                    
                                                           <form action="{{ route('DieselConsumption.edit', $details->id) }}"
                                                            method="GET">
                                                            @csrf
                                                            
                                                            <button type="submit"><i class="fas fa-pencil-alt"></i>Edit</button>
                                                        </form>
                                                        
                                                        <form action="{{ route('DieselConsumption.destroy', $details->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"><i class="fas fa-pencil-alt"></i>Delete</button>
                                                        </form>
                                                        

                                                    </span>
                                                </span></td>

                                    </tr>
                                    <?php
                                    $i++; ?>
                                    @endforeach
                                </tbody>

                                
                        </div>
                        <!-- Close Row -->
                    </div>
                    <!-- Close Container -->
                </div>
            </div>

            <svg xmlns="" version="1.1">
                <defs>
                    <filter id="goo">
                        <feGaussianBlur in="SourceGraphic" result="blur" stdDeviation="10"></feGaussianBlur>
                        <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0 0 1 0 0 0 0 0 1 0 0 0 0 0 21 -7"
                            result="goo"></feColorMatrix>
                        <feBlend in2="goo" in="SourceGraphic" result="mix"></feBlend>
                    </filter>
                </defs>
            </svg>
        @endsection





{{-- <table>
    <tr>
        <th>id</th>
        <th>plant</th>
        <th>diesel_in_incinerator</th>
        <th>diesel_in_degiset</th>
        <th>diesel_in_boiler</th>
        <th>date</th>
        <th>notes</th>
    </tr>

    @foreach($diesel as $dieseldetails)
    <tr>
        <td>{{$dieseldetails->id }}</td>
        <td>{{$dieseldetails->plant }}</td>
        <td>{{$dieseldetails->diesel_in_incinerator }}</td>
        <td>{{$dieseldetails->diesel_in_degiset }}</td>
        <td>{{$dieseldetails->diesel_in_boiler }}</td>
        <td>{{$dieseldetails->date }}</td>
        <td>{{$dieseldetails->notes }}</td>
        <td> <form action="{{route('DieselConsumption.edit' , $dieseldetails->id)}}" method="GET">
            @csrf
            <button type="submit">Edit</button>
          </form></td>
          <td> <form action="{{route('DieselConsumption.destroy' , $dieseldetails->id)}}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">Delete</button>
          </form></td>
    </tr>

    @endforeach
</table> --}}