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
                        <h5>Departments</h5>
                        <p class="heading_Bottom"> Complete list of Departments</p>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="page-header-breadcrumb">
                        <div class="buttons" style="text-align:right;margin:4px;">

                            <a href="{{url('Department/create')}}"><button type="button" class="btn btn-success btn_new"><i class="fas fa-plus mr-2"></i>Add New</button></a>
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
                                    <div class="col-md-4">
                                        <label for="client_id">Department Name</label>
                                        <fieldset>
                                            <div class="input-group client_margin">
                                                <span class="input-group-addon bg-primary border-primary white"
                                                    id="basic-addon7"
                                                    style="width: 43px;display: flex;justify-content: center;align-items: center;font-size: 23px;color: white;background-color: #4f81a4 !important;border: #4f81a4;"><i
                                                        class="fas fa-briefcase"></i></span>
                                                <input type="text" value="{{ Request::get('name') }}" name="name"
                                                    class="form-control" id="file_no"
                                                    placeholder="Enter  Name">


                                            </div>
                                        </fieldset>
                                    </div>

                                    <div class="col-md-4"><label for="enabled"
                                            style="margin-bottom: -1px;">Enabled</label>
                                        <select class='fstdropdown-select' id="first" name="status">
                                            @if(Request::get('status')=="1")
                                            <option value="">Select</option>
                                            <option selected value="1">Yes</option>
                                            <option  value="0">No</option>
                                            @elseif(Request::get('status')=="0")
                                            <option value="">Select</option>
                                            <option  value="1">Yes</option>
                                            <option selected value="0">No</option>
                                            @else
                                            <option value="">Select</option>
                                            <option  value="1">Yes</option>
                                            <option  value="0">No</option>
                                            @endif
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

                            </form>
                            <hr class="border-dark bold">
                            <div id="hide_2" class="table-responsive">
                                <!--<div id="toolbar">-->
                                <!--    <select class="form-control">-->
                                <!--        <option value="">Export Basic</option>-->
                                <!--        <option value="all">Export All</option>-->
                                <!--        <option value="selected">Export Selected</option>-->
                                <!--    </select>-->
                                <!--</div>-->

                                <table id="table" data-toggle="table" data-search="true" data-filter-control="true" data-show-export="true" data-show-refresh="true" data-show-toggle="true" data-pagination="true" data-toolbar="#toolbar">
                                    <thead>
                                        <tr>
                                            <th data-field="state" data-checkbox="true"></th>
                                             <th data-field="date12" data-sortable="true">Id</th>

                                            <th data-field="date1" data-sortable="true">Name</th>

                                           
                                            <th data-field="date4" data-sortable="true">Description</th>
                                            <th data-field="note13" data-sortable="true">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($department as $department_details)
                                            <?php
                                            $encrypt_id = enCrypt($department_details->id);

                                            ?>
                                        <tr>
                                            <td class="bs-checkbox "><input data-index="0" name="btSelectItem" type="checkbox"></td>
                                           <td ><a href='{{url("departmentpdf/{$encrypt_id}")}}' class="text-primary">{{$department_details->char_id}}</a></td>
                                            <td>{{$department_details->name}}</td>
                                         
                                            <td>{{$department_details->description}}</td>
                                        
                                            <td><span class="dropdown open">
                                                    <button id="btnGroup" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="btn btn-primary btn-sm dropdown-toggle dropdown-menu-right">
                                                        <i class="fas fa-cog"></i>
                                                    </button>
                                                    <span aria-labelledby="btnGroup" class="dropdown-menu mt-1 dropdown-menu-right">
                                                         <form action="{{route('Department.edit' , $encrypt_id)}}" method="GET" class="blockuie dropdown-item" style="margin-bottom:-10px">
                                                            @csrf
                                                       
                                                            <button  type="submit" style="background:none;border: none;"> <i class="fas fa-pencil-alt"></i>  Edit</button>
                                                        </form>
                                                        {{-- <form action="{{ url('confirmationAlert') }}" method="GET"
                                                        class="blockuie dropdown-item"
                                                        style="margin-bottom:-10px">
                                                        @csrf
                                                        <input type="text" name="route" hidden
                                                            value="{{'Department.destroy'}}">
                                                            <input type="text" name="id" hidden
                                                            value="{{$encrypt_id}}">
                                                        <button style="background:none;border: none;"
                                                            type="submit" data-toggle="modal"
                                                            data-target="#confirmationModal"><i
                                                                class="fas fa-trash"></i> delete</button>
                                                    </form> --}}


                                                                <form action="" method="GET" class="blockuie dropdown-item"
                                                                style="margin-bottom:-10px">
                                                                @csrf
                                                                <input type="text" id="route_id{{$department_details->id}}" name="route" hidden
                                                                    value="{{ 'Department' }}">
                                                                <input type="text" id="delete_id{{$department_details->id}}"  name="id" hidden
                                                                    value="{{ $department_details->id }}">
                                                                <button style="background:none;border: none;"
                                                                    type="button" onclick="confirMationAlert({{$department_details->id}})"><i
                                                                        class="fas fa-trash"
                                                                         ></i> delete</button>
                                                            </form>
                                                        
                                                    </span>
                                                </span></td>

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