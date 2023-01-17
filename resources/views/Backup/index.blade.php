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
                            <h5> Backup Client Routes</h5>
                            <p class="heading_Bottom"> Backup Client Routes</p>
                            <div class="col-lg-8">
                              <div class="page-header-breadcrumb">
                                  <div class="buttons" style="text-align:right;margin:4px;">
      
                                    <div class="col-lg-8">
                                       
                              
                                      </div>
                                       <div class="buttons" style="text-align:right;margin:4px;">

                                          <a href="{{url('backup/clone')}}"><button type="button" class="btn btn-success btn_new">Backup Client Routes</button></a>
                                      </div>
                                  </div>
                              </div>
                          </div>
                        </div>
                    </div>
                   
                </div>


                <div class="container-fluid bg-white mt-2 mb-5 border_radius box">
                   
                    <hr class="border-dark bold">
                    <div id="hide_2" class="table-responsive">
                        <!--<div id="toolbar">-->
                        <!--    <select class="form-control">-->
                        <!--        <option value="">Export Basic</option>-->
                        <!--        <option value="all">Export All</option>-->
                        <!--        <option value="selected">Export Selected</option>-->
                        <!--    </select>-->
                        <!--</div>-->

                        <table id="table" data-toggle="table" data-filter-control="true"
                              data-pagination="false"
                            data-toolbar="#toolbar">
                            <thead>
                                <tr>



                                    <th data-field="examen223" data-sortable="true">SR.no</th>
                                    <th data-field="examen2231" data-sortable="true">Backup Name</th>
                                    <th data-field="examen223ss1" data-sortable="true">Backup</th>
                                    <th data-field="3254" data-sortable="true">Delete</th>

                                    

                                    {{-- <th data-field="examen22" data-sortable="true">GO</th> --}}

                                </tr>
                            </thead>
                            <tbody>

                        
                                   
                                    @foreach($data as $key=>$value)    
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        {{-- <td>Backup Now</td> --}}
                                        <td>{{$value->clone_name}}</td>
                                        @php
                                        $id = enCrypt($value->id)
                                        @endphp
                                        <td><a href="{{url('backup/reverse' , $id)}}"><button type="submit" class="btn btn-primary" style=" font-weight:300;  padding:3px; "><i class="fas fa-refresh">&nbsp;&nbsp;</i>Restore</button></a>
                                        </td>
                                      <td><a href="{{url('backup/delete' , $id)}}"><button type="submit" class="btn  btn-danger " style=" font-weight:300;  padding:3px; ">Delete</button></a>
                                        </td> 
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
