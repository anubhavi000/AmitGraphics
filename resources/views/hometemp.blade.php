@extends('layouts.panel')

@section('content')

<!-- Loader -->

<!-- <div id="global-loader">

<img src="{{ asset('themed/panel/assets/img/loader.svg') }}" class="loader-img" alt="Loader">

</div> -->

<!-- /Loader -->


<div class="pcoded-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header card" id="grv_margin">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="feather icon-home bg-c-blue"></i>
                    <div class="d-inline">
                        <h1>
                            <a href="{{ config('app.account_app_url') }}" target="_blank" style="font-size: 20px;">Go to Account Software</a>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-header-breadcrumb">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="#" target="_blank"><i class="feather icon-home"></i></a>
                            
                        </li>
                        <li class="breadcrumb-item"><a href="#" target="_blank">Dashboard Analytics</a> </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- [ page content ] start -->
                    {{-- <div class="row">



                        <!-- Sales Analytics start -->

                        <div class="col-xl-12 col-md-12">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="card prod-p-card card-red">
                                        <div class="card-body">
                                            <div class="row align-items-center m-b-30">
                                                <div class="col">
                                                    <h6 class="m-b-5 text-white">Total Profit</h6>
                                                    <h3 class="m-b-0 f-w-700 text-white">$1,783</h3>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-money-bill-alt text-c-red f-18"></i>
                                                </div>
                                            </div>
                                            <p class="m-b-0 text-white"><span class="label label-danger m-r-10">+11%</span>From Previous Month</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card prod-p-card card-blue">
                                        <div class="card-body">
                                            <div class="row align-items-center m-b-30">
                                                <div class="col">
                                                    <h6 class="m-b-5 text-white">Total Orders</h6>
                                                    <h3 class="m-b-0 f-w-700 text-white">15,830</h3>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-database text-c-blue f-18"></i>
                                                </div>
                                            </div>
                                            <p class="m-b-0 text-white"><span class="label label-primary m-r-10">+12%</span>From Previous Month</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card prod-p-card card-blue">
                                        <div class="card-body">
                                            <div class="row align-items-center m-b-30">
                                                <div class="col">
                                                    <h6 class="m-b-5 text-white">Total Orders</h6>
                                                    <h3 class="m-b-0 f-w-700 text-white">15,830</h3>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-database text-c-blue f-18"></i>
                                                </div>
                                            </div>
                                            <p class="m-b-0 text-white"><span class="label label-primary m-r-10">+12%</span>From Previous Month</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card prod-p-card card-blue">
                                        <div class="card-body">
                                            <div class="row align-items-center m-b-30">
                                                <div class="col">
                                                    <h6 class="m-b-5 text-white">Total Orders</h6>
                                                    <h3 class="m-b-0 f-w-700 text-white">15,830</h3>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-database text-c-blue f-18"></i>
                                                </div>
                                            </div>
                                            <p class="m-b-0 text-white"><span class="label label-primary m-r-10">+12%</span>From Previous Month</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            

                            <!-- <div class="card prod-p-card card-green">
                                <div class="card-body">
                                    <div class="row align-items-center m-b-30">
                                        <div class="col">
                                            <h6 class="m-b-5 text-white">Average Price</h6>
                                            <h3 class="m-b-0 f-w-700 text-white">$6,780</h3>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign text-c-green f-18"></i>
                                        </div>
                                    </div>
                                    <p class="m-b-0 text-white"><span class="label label-success m-r-10">+52%</span>From Previous Month</p>
                                </div>
                            </div>
                            <div class="card prod-p-card card-yellow">
                                <div class="card-body">
                                    <div class="row align-items-center m-b-30">
                                        <div class="col">
                                            <h6 class="m-b-5 text-white">Product Sold</h6>
                                            <h3 class="m-b-0 f-w-700 text-white">6,784</h3>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-tags text-c-yellow f-18"></i>
                                        </div>
                                    </div>
                                    <p class="m-b-0 text-white"><span class="label label-warning m-r-10">+52%</span>From Previous Month</p>
                                </div>
                            </div> -->

                        </div>
                        <!-- Sales Analytics end -->

                        <!-- peoduct statustic start -->
                        <div class="col-xl-12">
                            <div class="card product-progress-card">
                                <div class="card-block">
                                    <div class="row pp-main">
                                        <div class="col-xl-3 col-md-6">
                                            <div class="pp-cont">
                                                <div class="row align-items-center m-b-20">
                                                    <div class="col-auto">
                                                        <i class="fas fa-cube f-24 text-mute"></i>
                                                    </div>
                                                    <div class="col text-right">
                                                        <h2 class="m-b-0 text-c-blue">2476</h2>
                                                    </div>
                                                </div>
                                                <div class="row align-items-center m-b-15">
                                                    <div class="col-auto">
                                                        <p class="m-b-0">Total Product</p>
                                                    </div>
                                                    <div class="col text-right">
                                                        <p class="m-b-0 text-c-blue"><i class="fas fa-long-arrow-alt-up m-r-10"></i>64%</p>
                                                    </div>
                                                </div>
                                                <div class="progress">
                                                    <div class="progress-bar bg-c-blue" style="width:45%"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-md-6">
                                            <div class="pp-cont">
                                                <div class="row align-items-center m-b-20">
                                                    <div class="col-auto">
                                                        <i class="fas fa-tag f-24 text-mute"></i>
                                                    </div>
                                                    <div class="col text-right">
                                                        <h2 class="m-b-0 text-c-red">843</h2>
                                                    </div>
                                                </div>
                                                <div class="row align-items-center m-b-15">
                                                    <div class="col-auto">
                                                        <p class="m-b-0">New Orders</p>
                                                    </div>
                                                    <div class="col text-right">
                                                        <p class="m-b-0 text-c-red"><i class="fas fa-long-arrow-alt-down m-r-10"></i>34%</p>
                                                    </div>
                                                </div>
                                                <div class="progress">
                                                    <div class="progress-bar bg-c-red" style="width:75%"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-md-6">
                                            <div class="pp-cont">
                                                <div class="row align-items-center m-b-20">
                                                    <div class="col-auto">
                                                        <i class="fas fa-random f-24 text-mute"></i>
                                                    </div>
                                                    <div class="col text-right">
                                                        <h2 class="m-b-0 text-c-yellow">63%</h2>
                                                    </div>
                                                </div>
                                                <div class="row align-items-center m-b-15">
                                                    <div class="col-auto">
                                                        <p class="m-b-0">Conversion Rate</p>
                                                    </div>
                                                    <div class="col text-right">
                                                        <p class="m-b-0 text-c-yellow"><i class="fas fa-long-arrow-alt-up m-r-10"></i>64%</p>
                                                    </div>
                                                </div>
                                                <div class="progress">
                                                    <div class="progress-bar bg-c-yellow" style="width:65%"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-md-6">
                                            <div class="pp-cont">
                                                <div class="row align-items-center m-b-20">
                                                    <div class="col-auto">
                                                        <i class="fas fa-dollar-sign f-24 text-mute"></i>
                                                    </div>
                                                    <div class="col text-right">
                                                        <h2 class="m-b-0 text-c-green">41M</h2>
                                                    </div>
                                                </div>
                                                <div class="row align-items-center m-b-15">
                                                    <div class="col-auto">
                                                        <p class="m-b-0">Conversion Rate</p>
                                                    </div>
                                                    <div class="col text-right">
                                                        <p class="m-b-0 text-c-green"><i class="fas fa-long-arrow-alt-up m-r-10"></i>54%</p>
                                                    </div>
                                                </div>
                                                <div class="progress">
                                                    <div class="progress-bar bg-c-green" style="width:35%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- peoduct statustic end -->

                        <!-- Application Sales start -->
                        <div class="col-xl-8 col-md-12">
                            <div class="card table-card">
                                <div class="card-header">
                                    <h5>Application Sales</h5>
                                    <div class="card-header-right">
                                        <ul class="list-unstyled card-option">
                                            <li class="first-opt"><i class="feather icon-chevron-left open-card-option"></i></li>
                                            <li><i class="feather icon-maximize full-card"></i></li>
                                            <li><i class="feather icon-minus minimize-card"></i></li>
                                            <li><i class="feather icon-refresh-cw reload-card"></i></li>
                                            <li><i class="feather icon-trash close-card"></i></li>
                                            <li><i class="feather icon-chevron-left open-card-option"></i></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="table-responsive">
                                        <table class="table table-hover m-b-0  table-borderless">
                                            <thead>
                                                <tr>
                                                    <th>Application</th>
                                                    <th>Sales</th>
                                                    <th>Change</th>
                                                    <th>Avg Price</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="d-inline-block align-middle">
                                                            <h6>Able Pro</h6>
                                                            <p class="text-muted m-b-0">Powerful Admin Theme</p>
                                                        </div>
                                                    </td>
                                                    <td>16,300</td>
                                                    <td>
                                                        <div id="app-sale1" style="height: 50px; padding: 0px; position: relative;"><canvas class="flot-base" width="109" height="75" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 73.1771px; height: 50px;"></canvas><div class="flot-text" style="position: absolute; inset: 0px; font-size: smaller; color: rgb(84, 84, 84);"><div class="flot-x-axis flot-x1-axis xAxis x1Axis" style="position: absolute; inset: 0px;"><div style="position: absolute; max-width: 24px; top: 50px; font: 400 0px / 0px &quot;Open Sans&quot;, sans-serif; color: transparent; left: 0px; text-align: center;">0</div><div style="position: absolute; max-width: 24px; top: 50px; font: 400 0px / 0px &quot;Open Sans&quot;, sans-serif; color: transparent; left: 41px; text-align: center;">50</div></div><div class="flot-y-axis flot-y1-axis yAxis y1Axis" style="position: absolute; inset: 0px;"><div style="position: absolute; top: 50px; font: 400 0px / 0px &quot;Open Sans&quot;, sans-serif; color: transparent; left: 0px; text-align: right;">0</div><div style="position: absolute; top: 33px; font: 400 0px / 0px &quot;Open Sans&quot;, sans-serif; color: transparent; left: 0px; text-align: right;">10</div><div style="position: absolute; top: 17px; font: 400 0px / 0px &quot;Open Sans&quot;, sans-serif; color: transparent; left: 0px; text-align: right;">20</div><div style="position: absolute; top: 0px; font: 400 0px / 0px &quot;Open Sans&quot;, sans-serif; color: transparent; left: 0px; text-align: right;">30</div></div></div><canvas class="flot-overlay" width="109" height="75" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 73.1771px; height: 50px;"></canvas></div>
                                                    </td>
                                                    <td>$53</td>
                                                    <td class="text-c-blue">$15,652</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-inline-block align-middle">
                                                            <h6>Photoshop</h6>
                                                            <p class="text-muted m-b-0">Design Software</p>
                                                        </div>
                                                    </td>
                                                    <td>26,421</td>
                                                    <td>
                                                        <div id="app-sale2" style="height: 50px; padding: 0px; position: relative;"><canvas class="flot-base" width="109" height="75" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 73.1771px; height: 50px;"></canvas><div class="flot-text" style="position: absolute; inset: 0px; font-size: smaller; color: rgb(84, 84, 84);"><div class="flot-x-axis flot-x1-axis xAxis x1Axis" style="position: absolute; inset: 0px;"><div style="position: absolute; max-width: 24px; top: 50px; font: 400 0px / 0px &quot;Open Sans&quot;, sans-serif; color: transparent; left: 0px; text-align: center;">0</div><div style="position: absolute; max-width: 24px; top: 50px; font: 400 0px / 0px &quot;Open Sans&quot;, sans-serif; color: transparent; left: 41px; text-align: center;">50</div></div><div class="flot-y-axis flot-y1-axis yAxis y1Axis" style="position: absolute; inset: 0px;"><div style="position: absolute; top: 50px; font: 400 0px / 0px &quot;Open Sans&quot;, sans-serif; color: transparent; left: 0px; text-align: right;">0</div><div style="position: absolute; top: 33px; font: 400 0px / 0px &quot;Open Sans&quot;, sans-serif; color: transparent; left: 0px; text-align: right;">10</div><div style="position: absolute; top: 17px; font: 400 0px / 0px &quot;Open Sans&quot;, sans-serif; color: transparent; left: 0px; text-align: right;">20</div><div style="position: absolute; top: 0px; font: 400 0px / 0px &quot;Open Sans&quot;, sans-serif; color: transparent; left: 0px; text-align: right;">30</div></div></div><canvas class="flot-overlay" width="109" height="75" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 73.1771px; height: 50px;"></canvas></div>
                                                    </td>
                                                    <td>$35</td>
                                                    <td class="text-c-blue">$18,785</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-inline-block align-middle">
                                                            <h6>Flatable</h6>
                                                            <p class="text-muted m-b-0">Admin App</p>
                                                        </div>
                                                    </td>
                                                    <td>10,652</td>
                                                    <td>
                                                        <div id="app-sale4" style="height: 50px; padding: 0px; position: relative;"><canvas class="flot-base" width="109" height="75" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 73.1771px; height: 50px;"></canvas><div class="flot-text" style="position: absolute; inset: 0px; font-size: smaller; color: rgb(84, 84, 84);"><div class="flot-x-axis flot-x1-axis xAxis x1Axis" style="position: absolute; inset: 0px;"><div style="position: absolute; max-width: 24px; top: 50px; font: 400 0px / 0px &quot;Open Sans&quot;, sans-serif; color: transparent; left: 0px; text-align: center;">0</div><div style="position: absolute; max-width: 24px; top: 50px; font: 400 0px / 0px &quot;Open Sans&quot;, sans-serif; color: transparent; left: 41px; text-align: center;">50</div></div><div class="flot-y-axis flot-y1-axis yAxis y1Axis" style="position: absolute; inset: 0px;"><div style="position: absolute; top: 50px; font: 400 0px / 0px &quot;Open Sans&quot;, sans-serif; color: transparent; left: 0px; text-align: right;">0</div><div style="position: absolute; top: 33px; font: 400 0px / 0px &quot;Open Sans&quot;, sans-serif; color: transparent; left: 0px; text-align: right;">10</div><div style="position: absolute; top: 17px; font: 400 0px / 0px &quot;Open Sans&quot;, sans-serif; color: transparent; left: 0px; text-align: right;">20</div><div style="position: absolute; top: 0px; font: 400 0px / 0px &quot;Open Sans&quot;, sans-serif; color: transparent; left: 0px; text-align: right;">30</div></div></div><canvas class="flot-overlay" width="109" height="75" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 73.1771px; height: 50px;"></canvas></div>
                                                    </td>
                                                    <td>$20</td>
                                                    <td class="text-c-blue">$7,856</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-12">
                            <div class="card latest-update-card">
                                <div class="card-header">
                                    <h5>Latest Activity</h5>
                                    <div class="card-header-right">
                                        <ul class="list-unstyled card-option">
                                            <li class="first-opt"><i class="feather icon-chevron-left open-card-option"></i></li>
                                            <li><i class="feather icon-maximize full-card"></i></li>
                                            <li><i class="feather icon-minus minimize-card"></i></li>
                                            <li><i class="feather icon-refresh-cw reload-card"></i></li>
                                            <li><i class="feather icon-trash close-card"></i></li>
                                            <li><i class="feather icon-chevron-left open-card-option"></i></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 290px;"><div class="scroll-widget" style="overflow: hidden; width: auto; height: 290px;">
                                        <div class="latest-update-box">
                                            <div class="row p-t-20 p-b-30">
                                                <div class="col-auto text-right update-meta p-r-0">
                                                    <i class="b-primary update-icon ring"></i>
                                                </div>
                                                <div class="col p-l-5">
                                                    <a href="#!"><h6>Devlopment &amp; Update</h6></a>
                                                    <p class="text-muted m-b-0">Lorem ipsum dolor sit amet, <a href="#!" class="text-c-blue"> More</a></p>
                                                </div>
                                            </div>
                                            <div class="row p-b-30">
                                                <div class="col-auto text-right update-meta p-r-0">
                                                    <i class="b-primary update-icon ring"></i>
                                                </div>
                                                <div class="col p-l-5">
                                                    <a href="#!"><h6>Showcases</h6></a>
                                                    <p class="text-muted m-b-0">Lorem dolor sit amet, <a href="#!" class="text-c-blue"> More</a></p>
                                                </div>
                                            </div>
                                            <div class="row p-b-30">
                                                <div class="col-auto text-right update-meta p-r-0">
                                                    <i class="b-success update-icon ring"></i>
                                                </div>
                                                <div class="col p-l-5">
                                                    <a href="#!"><h6>Miscellaneous</h6></a>
                                                    <p class="text-muted m-b-0">Lorem ipsum dolor sit ipsum amet, <a href="#!" class="text-c-green"> More</a></p>
                                                </div>
                                            </div>
                                            <div class="row p-b-30">
                                                <div class="col-auto text-right update-meta p-r-0">
                                                    <i class="b-danger update-icon ring"></i>
                                                </div>
                                                <div class="col p-l-5">
                                                    <a href="#!"><h6>Your Manager Posted.</h6></a>
                                                    <p class="text-muted m-b-0">Lorem ipsum dolor sit amet, <a href="#!" class="text-c-red"> More</a></p>
                                                </div>
                                            </div>
                                            <div class="row p-b-30">
                                                <div class="col-auto text-right update-meta p-r-0">
                                                    <i class="b-primary update-icon ring"></i>
                                                </div>
                                                <div class="col p-l-5">
                                                    <a href="#!"><h6>Showcases</h6></a>
                                                    <p class="text-muted m-b-0">Lorem dolor sit amet, <a href="#!" class="text-c-blue"> More</a></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-auto text-right update-meta p-r-0">
                                                    <i class="b-success update-icon ring"></i>
                                                </div>
                                                <div class="col p-l-5">
                                                    <a href="#!"><h6>Miscellaneous</h6></a>
                                                    <p class="text-muted m-b-0">Lorem ipsum dolor sit ipsum amet, <a href="#!" class="text-c-green"> More</a></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div><div class="slimScrollBar" style="background: rgb(0, 0, 0); width: 5px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 160.803px;"></div><div class="slimScrollRail" style="width: 5px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
                                </div>
                            </div>
                        </div>
                        <!-- Application Sales end -->

                        <!-- map card start -->
                        <div class="col-md-12">
                            <div class="card table-card">
                                <div class="card-header">
                                    <h5>New Products</h5>
                                    <div class="card-header-right">
                                        <ul class="list-unstyled card-option">
                                            <li class="first-opt"><i class="feather icon-chevron-left open-card-option"></i></li>
                                            <li><i class="feather icon-maximize full-card"></i></li>
                                            <li><i class="feather icon-minus minimize-card"></i></li>
                                            <li><i class="feather icon-refresh-cw reload-card"></i></li>
                                            <li><i class="feather icon-trash close-card"></i></li>
                                            <li><i class="feather icon-chevron-left open-card-option"></i></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-block p-b-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover m-b-0">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Product Code</th>
                                                    <th>Customer</th>
                                                    <th>Status</th>
                                                    <th>Rating</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Sofa</td>
                                                    <td>#PHD001</td>
                                                    <td>abc@gmail.com</td>
                                                    <td><label class="label label-danger">Out Stock</label></td>
                                                    <td>
                                                        <a href="#!"><i class="fa fa-star f-12 text-c-yellow"></i></a>
                                                        <a href="#!"><i class="fa fa-star f-12 text-c-yellow"></i></a>
                                                        <a href="#!"><i class="fa fa-star f-12 text-c-yellow"></i></a>
                                                        <a href="#!"><i class="fa fa-star f-12 text-default"></i></a>
                                                        <a href="#!"><i class="fa fa-star f-12 text-default"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Computer</td>
                                                    <td>#PHD002</td>
                                                    <td>cdc@gmail.com</td>
                                                    <td><label class="label label-success">In Stock</label></td>
                                                    <td>
                                                        <a href="#!"><i class="fa fa-star f-12 text-c-yellow"></i></a>
                                                        <a href="#!"><i class="fa fa-star f-12 text-c-yellow"></i></a>
                                                        <a href="#!"><i class="fa fa-star f-12 text-default"></i></a>
                                                        <a href="#!"><i class="fa fa-star f-12 text-default"></i></a>
                                                        <a href="#!"><i class="fa fa-star f-12 text-default"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Mobile</td>
                                                    <td>#PHD003</td>
                                                    <td>pqr@gmail.com</td>
                                                    <td><label class="label label-danger">Out Stock</label></td>
                                                    <td>
                                                        <a href="#!"><i class="fa fa-star f-12 text-c-yellow"></i></a>
                                                        <a href="#!"><i class="fa fa-star f-12 text-c-yellow"></i></a>
                                                        <a href="#!"><i class="fa fa-star f-12 text-c-yellow"></i></a>
                                                        <a href="#!"><i class="fa fa-star f-12 text-c-yellow"></i></a>
                                                        <a href="#!"><i class="fa fa-star f-12 text-default"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Coat</td>
                                                    <td>#PHD004</td>
                                                    <td>bcs@gmail.com</td>
                                                    <td><label class="label label-success">In Stock</label></td>
                                                    <td>
                                                        <a href="#!"><i class="fa fa-star f-12 text-c-yellow"></i></a>
                                                        <a href="#!"><i class="fa fa-star f-12 text-c-yellow"></i></a>
                                                        <a href="#!"><i class="fa fa-star f-12 text-c-yellow"></i></a>
                                                        <a href="#!"><i class="fa fa-star f-12 text-default"></i></a>
                                                        <a href="#!"><i class="fa fa-star f-12 text-default"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Watch</td>
                                                    <td>#PHD005</td>
                                                    <td>cdc@gmail.com</td>
                                                    <td><label class="label label-success">In Stock</label></td>
                                                    <td>
                                                        <a href="#!"><i class="fa fa-star f-12 text-c-yellow"></i></a>
                                                        <a href="#!"><i class="fa fa-star f-12 text-c-yellow"></i></a>
                                                        <a href="#!"><i class="fa fa-star f-12 text-default"></i></a>
                                                        <a href="#!"><i class="fa fa-star f-12 text-default"></i></a>
                                                        <a href="#!"><i class="fa fa-star f-12 text-default"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Shoes</td>
                                                    <td>#PHD006</td>
                                                    <td>pqr@gmail.com</td>
                                                    <td><label class="label label-danger">Out Stock</label></td>
                                                    <td>
                                                        <a href="#!"><i class="fa fa-star f-12 text-c-yellow"></i></a>
                                                        <a href="#!"><i class="fa fa-star f-12 text-c-yellow"></i></a>
                                                        <a href="#!"><i class="fa fa-star f-12 text-c-yellow"></i></a>
                                                        <a href="#!"><i class="fa fa-star f-12 text-c-yellow"></i></a>
                                                        <a href="#!"><i class="fa fa-star f-12 text-default"></i></a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- map card end -->


                    </div> --}}
                    <!-- [ page content ] end -->
                </div>


@endsection