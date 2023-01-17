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
                <div class="row first_row_margin" style="margin-bottom: -12px;">
                    <div class="col-lg-4">
                        <div class="page-header-title">
                            <i class="fas fa-users"></i>
                            <h5>All Modules</h5>
                            <p class="heading_Bottom"> Complete list of Modules</p>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="page-header-breadcrumb">
                            <div class="buttons" style="text-align:right;margin:4px;">

                                <a href="{{ url('Module/create') }}"><button type="button"
                                        class="btn btn-success btn_new"><i class="fas fa-plus mr-2"></i>Add New</button></a>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="container-fluid bg-white mt-2 mb-5 border_radius box">
                    <div class="row">

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
                                data-pagination="true" data-toolbar="#toolbar">
                                <thead>
                                    <tr>
                                        <th data-field="state" data-checkbox="true"></th>
                                        <th data-field="date12" data-sortable="true">Id</th>
                                        <th data-field="date" data-sortable="true">Module Name</th>
                                        <th data-field="dateee" data-sortable="true">Parent Module</th>
                                        <th data-field="datsseee" data-sortable="true">Route </th>
                                        <th data-field="datsseesse" data-sortable="true">Icon</th>
                                        <th data-field="daddteee" data-sortable="true">Sequence</th>

                                        <th data-field="date2343" data-sortable="true">Status</th>
                                        <th data-field="note13" data-sortable="true">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $sr = 1;
                                    @endphp
                                    @foreach ($all_modules as $module)
                                        <?php
                                        $encrypt_id = enCrypt($module->id);
                                        
                                        ?>
                                        <tr>
                                            <td class="bs-checkbox "><input data-index="0" name="btSelectItem"
                                                    type="checkbox"></td>
                                            <td>{{ $sr }}</td>
                                            <td>{{ $module->module_name }}</td>
                                            <td>{{ $module->parent ? $module->parent->module_name : '-' }}</td>

                                            <td>{{ $module->route_name }}</td>
                                            <td>{{ $module->icon }}</td>
                                            <td>{{ $module->sequence }}</td>
                                            <td>{{ $module->status }}</td>


                                            <td><span class="dropdown open">
                                                    <button id="btnGroup" type="button" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="true"
                                                        class="btn btn-primary btn-sm dropdown-toggle dropdown-menu-right">
                                                        <i class="fas fa-cog"></i>
                                                    </button>
                                                    <span aria-labelledby="btnGroup"
                                                        class="dropdown-menu mt-1 dropdown-menu-right">
                                                        <form action="{{ route('Module.edit', $encrypt_id) }}"
                                                            method="GET" class="blockuie dropdown-item"
                                                            style="margin-bottom:-10px">
                                                            @csrf

                                                            <button style="background:none;border: none;" type="submit"><i
                                                                    class="fas fa-pencil-alt"></i> Edit</button>
                                                        </form>
                                                        <form action="{{ route('Module.destroy', $module->id) }}"
                                                            method="POST" class="blockuie dropdown-item">
                                                            @csrf
                                                            @method('delete')
                                                            <button style="background:none;border: none;" type="submit"><i
                                                                    class="fas fa-trash"></i> Delete</button>
                                                        </form>


                                                    </span>
                                                </span></td>

                                        </tr>
                                        @php
                                            $sr++;
                                        @endphp
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
