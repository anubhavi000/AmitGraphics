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
                            <h5>Notification Management </h5>
                            <p class="heading_Bottom">Add Notification and Access </p>
                        </div>
                    </div>


                    <div class="container-fluid bg-white mt-2 mb-5 border_radius box">
                        <form action="{{ url('Notifications/store') }}" method="POST">
                            @csrf
                        <div class="row">
                    
                            <div class="card-body">



                            <div class="row">

                            <div class="col-md-4"><label for="management"> Title</label>
                                  <input type="text" name="title" class="form-control">
                               
                            </div>
                            <div class="col-md-4"><label for="management"> Description</label>
                                  <input type="text" name="description" class="form-control">
                               
                            </div>
                            <div class="col-md-4"><label for="management"> Url </label>
                                  <input type="text" name="url" class="form-control">
                               
                            </div>

                        </div>
                    </div>


                            <table class="table table-bordered p-4">


                                <tr>

                                    <th>User Id </th>
                                   
                                    <th>Approve / <span> Approve All <input type="checkbox" name="approveall123" id="approveall123"
                                                onclick="approveall(this)"> </span> </th>
                                   
                                </tr>
                              

                                    @foreach ($userdata as $user)
                                        
                                        <tr>

                                            <td>{{ $user->full_name }} </td>
                                            
                                            
                                                <td>
                                                    <input type="checkbox"  name="approval[{{$user->id}}]"  value="1" class="approval">
                                                </td>
                                             
                                              
                                          
                                        </tr>
                                   
                                    @endforeach
                                    


                            </table>

                            <div class="col-md-12"> <button type="submit" class="btn btn-success m-2 "
                                    style="float:right">Save Changes</button></div>
                            </form>

                        </div>

                    </div>
                    <!-- Close Row -->
                </div>
                <!-- Close Container -->
            </div>
            @endsection

            @section('js')
            <script>
       

                function approveall(elem) {
                   
                    approval = document.querySelectorAll(".approval");
                   
                    if (elem.checked == true) {
                      
                        approval.forEach(each => {
                            
                        each.checked = true;
                    });
                } else {

                    approval.forEach(each => {
                        each.checked = false;
                    });
                }
                      
            }

             
            </script>
        @endsection
