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
                            <h5>Item Wise Average Report</h5>
                            <!-- <p class="heading_Bottom"> Complete list of designations</p> -->
                        </div>
                    </div>
                    <div class="col-lg-8 mt-3">
                        <div class="page-header-breadcrumb">
                            <div class="buttons" style="text-align:right;margin:4px;">
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
                                        <div class="col-md-2">              
                                            <label for="client_id">From Date</label>
                                            <input value="{{!empty($from_date) ? date('Y-m-d' , strtotime($from_date)) : ''}}" type="text" class="form-control datepicker client_margin" placeholder="Enter To Date" name="from_date">
                                        </div>    
                                        <div class="col-md-2">              
                                            <label>To Date</label>
                                            <input type="text" value="{{ !empty($to_date) ? date('Y-m-d' , strtotime($to_date)) : '' }}"  class="form-control datepicker client_margin" placeholder="Enter To Date" name="to_date">
                                        </div>                                            
                                                   
                                        <div class="col-md-2 mb-3 px-3">
                                            <label></label>
                                            <input style="margin-top:23px" type="submit" name="find" value="find" class="btn btn-success">
                                            <input style="margin-top:23px" type="submit" name="export_to_excel" value="Export To Csv" class="btn btn-primary">
  <!--                                           <input style="margin-top:23px" type="submit" name="export_to_pdf" value="Export To PDF" class="btn btn-info"> -->
                                        </div>
                                    </div>


                                </form>


                            </div>
                            <div id="hide_2" class="table-responsive">

                            </div>
                        </div>

                    </div>
                        <div class="col-md-12 mt-3 mb-3">

                            <div class="container-fluid mt-3">
                            </div>
                            <div id="hide_2" class="table-responsive">

                                <table id="table" data-toggle="table" data-search="true" 
                                    data-pagination="true" data-toolbar="#toolbar">
                                    <thead>
                                        <tr>
                                            <th colspan="4" class="text-center">Item Wise Average Report</th>
                                        </tr>
                                        <tr>
                                            <th>S.no</th>
                                            <th>Item Name</th>
                                            <th>Total Wieght</th>
                                            <th>Percentage</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($data))
                                            <?php $row = 1; ?>
                                            @foreach($data as $key => $value)
                                                <tr>
                                                    <td>{{ $row }}</td>
                                                    <td> {{ !empty( $items[$key] ) ? $items[$key] : '' }} </td>
                                                    <td class="text-right"> {{ !empty($value) ? str_replace('.00' , '' ,number_format($value , 2)) : '' }} KG</td>
                                                    <td class="text-right">  
                                                        @if($total_weight != 0)
                                                            @php
                                                                $val = $value/$total_weight *100;
                                                            @endphp
                                                            {{ round($val , 2) }}%
                                                        @else
                                                            0%
                                                        @endif
                                                     </td>
                                                </tr>
                                                <?php $row++; ?>
                                            @endforeach
                                        @endif
                                                <tr>
                                                    <td class="text-bold"><b style="font-weight: 650;font-size: 18px;" class="text-bold">Grand Total</b></td>
                                                    <td></td>
                                                    <td   class="text-right"><b style="font-weight: 650;font-size: 18px;"> {{ !empty($total_weight) ? str_replace('.00' ,'', number_format($total_weight  , 2)) : 0 }} KG</b></td>
                                                    <td></td>
                                                </tr>                                        
                                    </tbody>
                                </table>                                
                            </div>
                        </div>

                    <!-- Close Row -->
                </div>

                <!-- Close Container -->
            </div>
           

        @endsection
