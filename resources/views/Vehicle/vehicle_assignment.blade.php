@extends('layouts.panel')

@section('content')
    <style>
        button .list-group-item :hover {
            /* background-color: red;  */
        }
    </style>
    <div class="pcoded-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header card" id="grv_margin">
            <div class="row first_row_margin">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class=" fas fa-university mr-2"></i>
                        <div class="d-inline">
                            <h5>Vehicle Access Information</h5>
                            <p class="heading_Bottom">Assign Vehicle To Users</p>
                        </div>
                    </div>
                </div>
             
            
                <div class="container-fluid bg-white mt-2 mb-3 border_radius box">
                    <div class="row">
                        <div class="col-md-12 mt-3 mb-3">

                            <form action="{{route('AssignVehicle.store')}}" method="POST">
                                @csrf
                                <div class="container-fluid">
                                    <div class="row first_row_margin">
                                        <div class="col-md-6">
                                            <h2 class="form-control-sm form_style yash_heading"><i
                                                    class="fas fa-university mr-2"></i><b>User Vehicle Information</b>
                                            </h2>
                                        </div>
                                        <div class="col-md-6" style="text-align:right;">
                                            <a class="btn btn-link btn-primary" data-toggle="collapse"
                                                data-target="#collapseExample" aria-expanded="true"
                                                aria-controls="collapseExample" style="margin-top: 10px;">
                                                <i class="fa" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                    <hr class="border-dark bold">
                                    <div class="form-row mt-3 mb-3 collapse show" id="collapseExample">

                                        <div class="col-md-3 mb-3 ">
                                            <label class="yash_star" style="margin-bottom:0px;">Select User
                                            </label>

                                            <select name="user_id" id="user" class="chosen-select"
                                                onchange="getVehiclePrevAccess(this.value)">
                                                <option value="">Select</option>
                                                @foreach ($user as $key)
                                                    @if (Request::get('user_id') == $key->id)
                                                        <option selected value="{{ $key->id }}">{{ $key->full_name }}
                                                        @else
                                                        <option value="{{ $key->id }}">{{ $key->full_name }}
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>



                                   <div class="col-md-6 mb-3 mt-3 ">
                                    <button class="blob-btn" id="cancelbtn" action="action"
                                    type="reset"><i
                                       class="fas fa-times pr-2"></i>
                                   Cancel
                                   <span class="blob-btn__inner">
                                       <span class="blob-btn__blobs">
                                           <span class="blob-btn__blob"></span>
                                           <span class="blob-btn__blob"></span>
                                           <span class="blob-btn__blob"></span>
                                           <span class="blob-btn__blob"></span>
                                       </span>
                                   </span>
                               </button>
                               <button id="submitbtn" type="submit" class="blob-btn1"><i
                                       class="fas fa-check pr-2"></i>
                                   Save Changes
                                   <span class="blob-btn__inner1">
                                       <span class="blob-btn__blobs1">
                                           <span class="blob-btn__blob1"></span>
                                           <span class="blob-btn__blob1"></span>
                                           <span class="blob-btn__blob1"></span>
                                           <span class="blob-btn__blob1"></span>
                                       </span>
                                   </span>
                               </button>
                                   </div>
                                    </div>


                                    <div class="col-md-12">
                                        <table id="vehiclecontainer" data-toggle="table" class="table table-bordered w-100"
                                            style="display: none">
                                            <thead>
                                                <tr>
                                                    <th>Char Id</th>
                                                    <th>Vehicle Type</th>
                                                    <th>Number</th>
                                                    <th>Permisson</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($vehicles as $key => $value)
                                                <td>{{$value->vehicle_char_id}}</td>
                                                <td>{{$value->vehicle_type}}</td>
                                                    <td><input type="hidden" name="vehicle_ids[]"
                                                            value="{{ $value->id }}">{{ $value->vehicle_Number }}</td>
                                                    <td ><input id="vehicle{{ $value->id }}"
                                                            name="permission[{{$value->id}}]" class="permission_checkbox" value="1"
                                                            type="checkbox"></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>

                                        </table>
                                    </div>






                              

                                  
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                <!-- Close Row -->
            </div>
            <!-- Close Container -->
        </div>
    @endsection

    @section('js')
        <script>
            function getVehiclePrevAccess(user) {
                document.getElementById("vehiclecontainer").style.display = "none";
               

                $(".permission_checkbox").each(function() {
                    $(this).attr('checked', false);
                })

                var id = user;
                document.getElementById("vehiclecontainer").style.display = "block";

                $.ajax({
                    type: "GET",
                    url: app_url + 'vehicle_prev_access',
                    data: {'user_id':user},
                    success: function(data) {
                        $.each(data, function(key, value) {
                           var ab =value.id;
                         $("#vehicle"+ab).attr('checked', true);
                        });


                    }
                });




            }
        </script>

    @endsection
