 @extends('layouts.panel')

@section('content')
<div class="pcoded-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header card" id="grv_margin">
        <div class="row">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="fas fa-map-signs mr-2"></i>
                    <div class="d-inline">
                        <h5 class="mt-2">Generated Slips</h5>
                        <!-- <p class="heading_Bottom"> Client Bill Payment Ledger</p> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid bg-white mt-2 mb-3 border_radius box">
            <div class="row">
                <div class="col-md-12 mt-3 mb-3">
                    <form action="" method="get">
                        @csrf
                        <div class="container-fluid">
                            <div class="row " style="margin-bottom:-11px">
                                <div class="col-md-6">
                                    <h2 class="form-control-sm yash_heading form_style"><i
                                            class="fas fa-database mr-2"></i><b>Filter Data</b></h2>
                                </div>
                                <div class="col-md-6" style="text-align:right;">
                                    <a class="btn btn-link btn-primary collapsed" data-toggle="collapse"
                                        data-target="#collapseExample1" aria-expanded="true"
                                        aria-controls="collapseExample" style="margin-top: 10px;">
                                        <i class="fa" aria-hidden="true"></i></a>
                                </div>
                                
                            </div>

                            <hr class="border-dark bold">
                            <div class="form-row mt-3 mb-3 collapse show" id="collapseExample1">
                                <div class="row col-md-12" style="margin-bottom:-11px">
                                    <div class="col-md-3 mb-3 px-3">
                                        <label style="margin-bottom:0px" for="slip_no"
                                            class="yash_star">SLip No.</label>
                                        <input type="text" name="slip_no"class="form-control" >
                                    </div>
                                    <div class="col-md-2"><label for="from_date">From Date</label>
                                        <fieldset>
                                            <div class="input-group client_margin">
                                                <span class="input-group-addon bg-primary border-primary white"
                                                    id="basic-addon7"
                                                    style="width: 43px;display: flex;justify-content: center;align-items: center;font-size: 23px;color: white;background-color: #4f81a4 !important;border: #4f81a4;"><i
                                                        class="fas fa-briefcase"></i></span>
                                                <input type="text"  name="from_date" class="form-control datepicker"
                                                    id="from_date" 
                                                    value=" ">
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-2"><label for="to_date">To Date</label>
                                        <fieldset>
                                            <div class="input-group client_margin">
                                                <span class="input-group-addon bg-primary border-primary white"
                                                    id="basic-addon7"
                                                    style="width: 43px;display: flex;justify-content: center;align-items: center;font-size: 23px;color: white;background-color: #4f81a4 !important;border: #4f81a4;"><i
                                                        class="fas fa-briefcase"></i></span>
                                                <input type="text" name="to_date" class="form-control datepicker" id="to_date"
                                                    value="">
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <input type="submit" name="find" value="find" class="btn btn-success">
                                        <input type="submit" name="export_to_excel" value="Export To Csv" class="btn btn-primary">
                                        <input type="submit" class="btn btn-info" name="export_pdf" value="Export Pdf">
                                    </div>  
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Close Row -->
                    <div id="hide_2" class="table-responsive">
                        <table id="table1" class=" table table-bordered"  >
                        </table>
                        <div class="row " style="margin-bottom:16px">
                            <div class="col-md-6">
                                <h2 class="form-control-sm yash_heading form_style"><i
                                        class="fas fa-database mr-2"></i><b>Slip Details </b></h2>
                            </div>
                        </div>
                        <table id="table" class="table table-bordered" style="padding-top: 30px;">
                            <thead>
                                <tr style="background-color:crimson; color: white;">
                                    <th >S.no</th>
                                    <th  >Slip No</th>
                                    <th> Excess Weight (in kgs)</th>
                                    <th  >Created At</th>
                                    <th  >Last Updated</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $key => $value)
                                    <tr>
                                        <td>{{$key +1}}</td>
                                        <td>{{!empty($value->slip_no) ? $value->slip_no : ''}}</td>
                                        <td>{{ !empty($value->acess_weight_quantity) ? $value->acess_weight_quantity.' KG' : '' }}</td>
                                        <td>{{ !empty($value->created_at) ? date('d-m-Y h:i:A' , strtotime($value->created_at)) : '' }}</td>
                                        <td>{{ !empty($value->updated_at) ? $value->updated_at : ''}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
            </div>
        </div>
    </div>
</div>

        @endsection