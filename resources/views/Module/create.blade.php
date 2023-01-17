@extends('layouts.panel')

@section('content')
    <div class="pcoded-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header card" id="grv_margin">
            <div class="row first_row_margin">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class=" fas fa-university mr-2"></i>
                        <div class="d-inline">
                            <h5>Add Module</h5>
                            <p class="heading_Bottom">Add New Module</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="page-header-breadcrumb">
                        <ul class=" breadcrumb breadcrumb-title">
                            <li class="breadcrumb-item">
                                <a href="../home"><i class="feather icon-home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="../home">Dashboard Analytics</a> </li>
                        </ul>
                    </div>
                </div>
                <!-- <div class="container">
     <div class="row">
      <div class="col-md-6">
        <h3>Add Bank</h3>
        <p class="heading_Bottom"><i class="fas fa-university mr-2"></i> Add New Bank</p>
        </div>
    </div> -->
                <div class="container-fluid bg-white mt-2 mb-3 border_radius box">
                    <div class="row">
                        <div class="col-md-12 mt-3 mb-3">
                            <form action="{{ route('Module.store') }}" method="POST">
                                @csrf
                                <div class="container-fluid">
                                    <div class="row first_row_margin">
                                        <div class="col-md-6">
                                            <h2 class="form-control-sm form_style yash_heading"><i
                                                    class="fas fa-university mr-2"></i><b>Module Information</b></h2>
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
                                            <label for="bank_Name" class="yash_star" style="margin-bottom:0px;">Module
                                                Name</label>
                                            <input type="text" name="module_name" id="model_Name" class="form-control"
                                                required>
                                        </div>
                                        <div class="col-md-3 mb-3 ">
                                            <label class="yash_star" style="margin-bottom:0px;">Parent Module</label>

                                            <select name="parent_id" class="fstdropdown-select">
                                                <option value="">Select</option>
                                                @foreach ($all_modules as $module)
                                                    <option value="{{ $module->id }}">{{ $module->module_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <div class="col-md-3 mb-3 ">
                                            <label for="bank_Name" class="yash_star"
                                                style="margin-bottom:0px;">Route</label>
                                            <input type="text" name="route_name" id="model_Name" class="form-control">
                                        </div>
                                        <div class="col-md-3 mb-3 ">
                                            <label for="bank_Name" class="yash_star"
                                                style="margin-bottom:0px;">Icon</label>
                                            <input type="text" name="icon" id="model_Name" class="form-control">
                                        </div>
                                        <div class="col-md-3 mb-3 ">
                                            <label for="bank_Name" class="yash_star"
                                                style="margin-bottom:0px;">Sequence</label>
                                            <input type="text" name="sequence" id="model_Name" class="form-control"
                                                required>
                                        </div>
                                        <div class="col-md-3 mb-3 ">
                                            <label class="yash_star" style="margin-bottom:0px;">Status</label>

                                            <select name="status" class="fstdropdown-select" required>
                                                <option value="">Select</option>
                                                <option value="active">Active</option>
                                                <option value="inactive">In Active</option>
                                            </select>
                                        </div>

                                        <div class="col-md-12" style="text-align: right;">
                                            <hr class="mt-3 border-dark bold">

                                            <button class="blob-btn" id="cancelbtn" action="action"
                                                onclick="window.history.go(-1); return false;" type="submit"><i
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
                                </div>
                            </form>
                        </div>
                        <!-- Close Row -->
                    </div>
                    <!-- Close Container -->
                </div>
                {{-- <svg xmlns="" version="1.1">
  <defs>
    <filter id="goo">
      <feGaussianBlur in="SourceGraphic" result="blur" stdDeviation="10"></feGaussianBlur>
      <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0 0 1 0 0 0 0 0 1 0 0 0 0 0 21 -7" result="goo"></feColorMatrix>
      <feBlend in2="goo" in="SourceGraphic" result="mix"></feBlend>
    </filter>
  </defs>
</svg> --}}
            @endsection
