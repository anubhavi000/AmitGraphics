<!DOCTYPE html>
<html lang="en">

<head>
   
  <title>Synergy | Manacle Technologies Pvt. Lmt.</title>
    @yield('title')
    <meta name="csrf-token" content="{{ csrf_token() }}">

      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="description" content="Admindek Bootstrap admin template made using Bootstrap 4 and it has huge amount of ready made feature, UI components, pages which completely fulfills any dashboard needs.">
      <meta name="keywords" content="bootstrap, bootstrap admin template, admin theme, admin dashboard, dashboard template, admin template, responsive">
      <meta name="author" content="colorlib">
      <!-- Favicon icon -->
      <link rel="icon" href="{{asset('theme/assets/images/favicon.ico')}}" type="image/x-icon">
      <!-- Google font-->
      <link rel="stylesheet" type="text/css" href="{{asset('theme/bower_components/bootstrap/css/bootstrap.min.css')}}">
      <!-- waves.css')}} -->
      <link rel="stylesheet" href="{{asset('theme/assets/pages/waves/css/waves.min.css')}}" type="text/css" media="all">
      <!-- feather icon -->
      <link rel="stylesheet" type="text/css" href="{{asset('theme/assets/icon/feather/css/feather.css')}}">
      <!-- themify-icons line icon -->
      <link rel="stylesheet" type="text/css" href="{{asset('theme/assets/icon/themify-icons/themify-icons.css')}}">
      <!-- ico font -->
      <link rel="stylesheet" type="text/css" href="{{asset('theme/assets/icon/icofont/css/icofont.css')}}">
      <!-- Font Awesome -->
      <link rel="stylesheet" type="text/css" href="{{asset('theme/assets/icon/font-awesome/css/font-awesome.min.css')}}">
      <!-- Style.css')}} -->
      <link rel="stylesheet" type="text/css" href="{{asset('theme/assets/css/style.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('theme/assets/css/pages.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('theme/assets/css/grv.css')}}">
      




    @yield('css')

    </head>

    @php 
        $layout_status = Auth::user()->layout_status;
    @endphp
    <body>
      <!-- [ Pre-loader ] start -->
      <div class="loader-bg">
        <div class="loader-bar"></div>
      </div>
      <!-- [ Pre-loader ] end -->
      <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">
          <!-- [ Header ] start -->
          <nav class="navbar header-navbar pcoded-header">
            <div class="navbar-wrapper">
              <div class="navbar-logo">
                <a href="index.html">
                  <img class="img-fluid" src="https://synergyworld.me/static/images/logosynergyin.png" alt="Theme-Logo" style="width: 70%;">
                </a>
                <a class="mobile-menu" id="mobile-collapse" href="#!">
                  <i class="feather icon-menu icon-toggle-right"></i>
                </a>
                <a class="mobile-options waves-effect waves-light">
                  <i class="feather icon-more-horizontal"></i>
                </a>
              </div>
              <div class="navbar-container container-fluid">
                <ul class="nav-left">
                  <li class="header-search">
                    <div class="main-search morphsearch-search">
                      <div class="input-group">
                        <span class="input-group-prepend search-close">
                          <i class="feather icon-x input-group-text"></i>
                        </span>
                        <input type="text" class="form-control" placeholder="Enter Keyword">
                        <span class="input-group-append search-btn">
                          <i class="feather icon-search input-group-text"></i>
                        </span>
                      </div>
                    </div>
                  </li>
                  <li>
                    <a href="#!" onclick="javascript:toggleFullScreen()" class="waves-effect waves-light">
                      <i class="full-screen feather icon-maximize"></i>
                    </a>
                  </li>
                </ul>
                <ul class="nav-right">
                  <li class="header-notification">
                    <div class="dropdown-primary dropdown">
                      <div class="dropdown-toggle" data-toggle="dropdown">
                        <i class="feather icon-bell"></i>
                        <span class="badge bg-c-red">5</span>
                      </div>
                      <ul class="show-notification notification-view dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                        <li>
                          <h6>Notifications</h6>
                          <label class="label label-danger">New</label>
                        </li>
                        <li>
                          <div class="media">
                            <img class="img-radius" src="{{asset('theme/assets/images/avatar-4.jpg')}}" alt="Generic placeholder image">
                            <div class="media-body">
                              <h5 class="notification-user">Gaurav Kumar</h5>
                              <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                              <span class="notification-time">30 minutes ago</span>
                            </div>
                          </div>
                        </li>
                        <li>
                          <div class="media">
                            <img class="img-radius" src="{{asset('theme/assets/images/avatar-3.jpg')}}" alt="Generic placeholder image">
                            <div class="media-body">
                              <h5 class="notification-user">Joseph William</h5>
                              <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                              <span class="notification-time">30 minutes ago</span>
                            </div>
                          </div>
                        </li>
                        <li>
                          <div class="media">
                            <img class="img-radius" src="{{asset('theme/assets/images/avatar-4.jpg')}}" alt="Generic placeholder image">
                            <div class="media-body">
                              <h5 class="notification-user">Sara Soudein</h5>
                              <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                              <span class="notification-time">30 minutes ago</span>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </li>
                  <li class="header-notification">
                               <div class="dropdown-primary dropdown">
                                   <div class="displayChatbox dropdown-toggle" data-toggle="dropdown">
                                       <i class="feather icon-message-square"></i>
                                       <span class="badge bg-c-green">3</span>
                                   </div>
                               </div>
                           </li>
                           <li class="user-profile header-notification">

                    <div class="dropdown-primary dropdown">
                      <div class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{asset('theme/assets/images/avatar-4.jpg')}}" class="img-radius" alt="User-Profile-Image">
                        <span>Gaurav Kumar</span>
                        <i class="feather icon-chevron-down"></i>
                      </div>
                      <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                        <li>
                          <a href="#!">
                            <i class="feather icon-settings"></i> Settings

                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <i class="feather icon-user"></i> Profile

                          </a>
                        </li>
                        <li>
                          <a href="email-inbox.html">
                            <i class="feather icon-mail"></i> My Messages

                          </a>
                        </li>
                        <li>
                          <a href="auth-lock-screen.html">
                            <i class="feather icon-lock"></i> Lock Screen

                          </a>
                        </li>
                        <li>
                          <a  onclick="sidebarFunction()">
                            <i class="feather icon-lock"></i> Side Bar Layout

                          </a>
                        </li>
                        <li>
                          <a  onclick="upperbarFunction()">
                            <i class="feather icon-lock"></i> Upper Bar Layout

                          </a>
                        </li>
                        <li>
                          <a href="auth-sign-in-social.html">
                            <i class="feather icon-log-out"></i> Logout

                          </a>
                        </li>
                      </ul>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </nav>
         <!-- [ chat user list ] start -->
            <div id="sidebar" class="users p-chat-user showChat">
                <div class="had-container">
                    <div class="p-fixed users-main">
                        <div class="user-box">
                            <div class="chat-search-box">
                                <a class="back_friendlist">
                                    <i class="feather icon-x"></i>
                                </a>
                                <div class="right-icon-control">
                                    <div class="input-group input-group-button">
                                        <input type="text" id="search-friends" name="footer-email" class="form-control" placeholder="Search Friend">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary waves-effect waves-light" type="button"><i class="feather icon-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="main-friend-list">
                                <div class="media userlist-box waves-effect waves-light" data-id="1" data-status="online" data-username="Josephin Doe">
                                    <a class="media-left" href="#!">
                                                <img class="media-object img-radius img-radius" src="{{asset('theme/assets/images/avatar-3.jpg')}}" alt="Generic placeholder image ">
                                                <div class="live-status bg-success"></div>
                                            </a>
                                    <div class="media-body">
                                        <div class="chat-header">Josephin Doe</div>
                                    </div>
                                </div>
                                <div class="media userlist-box waves-effect waves-light" data-id="2" data-status="online" data-username="Lary Doe">
                                    <a class="media-left" href="#!">
                                                <img class="media-object img-radius" src="{{asset('theme/assets/images/avatar-2.jpg')}}" alt="Generic placeholder image">
                                                <div class="live-status bg-success"></div>
                                            </a>
                                    <div class="media-body">
                                        <div class="f-13 chat-header">Lary Doe</div>
                                    </div>
                                </div>
                                <div class="media userlist-box waves-effect waves-light" data-id="3" data-status="online" data-username="Alice">
                                    <a class="media-left" href="#!">
                                                <img class="media-object img-radius" src="{{asset('theme/assets/images/avatar-4.jpg')}}" alt="Generic placeholder image">
                                                <div class="live-status bg-success"></div>
                                            </a>
                                    <div class="media-body">
                                        <div class="f-13 chat-header">Alice</div>
                                    </div>
                                </div>
                                <div class="media userlist-box waves-effect waves-light" data-id="4" data-status="offline" data-username="Alia">
                                    <a class="media-left" href="#!">
                                                <img class="media-object img-radius" src="{{asset('theme/assets/images/avatar-3.jpg')}}" alt="Generic placeholder image">
                                                <div class="live-status bg-default"></div>
                                            </a>
                                    <div class="media-body">
                                        <div class="f-13 chat-header">Alia<small class="d-block text-muted">10 min ago</small></div>
                                    </div>
                                </div>
                                <div class="media userlist-box waves-effect waves-light" data-id="5" data-status="offline" data-username="Suzen">
                                    <a class="media-left" href="#!">
                                                <img class="media-object img-radius" src="{{asset('theme/assets/images/avatar-2.jpg')}}" alt="Generic placeholder image">
                                                <div class="live-status bg-default"></div>
                                            </a>
                                    <div class="media-body">
                                        <div class="f-13 chat-header">Suzen<small class="d-block text-muted">15 min ago</small></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ chat user list ] end -->

            <!-- [ chat message ] start -->
            <div class="showChat_inner">
                <div class="media chat-inner-header">
                    <a class="back_chatBox">
                                <i class="feather icon-x"></i> Josephin Doe
                            </a>
                </div>
                <div class="main-friend-chat">
                    <div class="media chat-messages">
                        <a class="media-left photo-table" href="#!">
                                        <img class="media-object img-radius img-radius m-t-5" src="{{asset('theme/assets/images/avatar-2.jpg')}}" alt="Generic placeholder image">
                                    </a>
                        <div class="media-body chat-menu-content">
                            <div class="">
                                <p class="chat-cont">I'm just looking around. Will you tell me something about yourself?</p>
                            </div>
                            <p class="chat-time">8:20 a.m.</p>
                        </div>
                    </div>
                    <div class="media chat-messages">
                        <div class="media-body chat-menu-reply">
                            <div class="">
                                <p class="chat-cont">Ohh! very nice</p>
                            </div>
                            <p class="chat-time">8:22 a.m.</p>
                        </div>
                    </div>
                    <div class="media chat-messages">
                        <a class="media-left photo-table" href="#!">
                                        <img class="media-object img-radius img-radius m-t-5" src="{{asset('theme/assets/images/avatar-2.jpg')}}" alt="Generic placeholder image">
                                    </a>
                        <div class="media-body chat-menu-content">
                            <div class="">
                                <p class="chat-cont">can you come with me?</p>
                            </div>
                            <p class="chat-time">8:20 a.m.</p>
                        </div>
                    </div>
                </div>
                <div class="chat-reply-box">
                    <div class="right-icon-control">
                        <div class="input-group input-group-button">
                            <input type="text" class="form-control" placeholder="Write hear . . ">
                            <div class="input-group-append">
                                <button class="btn btn-primary waves-effect waves-light" type="button"><i class="feather icon-message-circle"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ chat message ] end -->


          <div class="pcoded-main-container">
            <div class="pcoded-wrapper">
              <!-- [ navigation menu ] start -->
              <nav class="pcoded-navbar">
                <div class="pcoded-inner-navbar">
                    <ul class="pcoded-item">
                        <li class="pcoded-hasmenu">
                         <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="feather icon-sidebar"></i></span>
                            <span class="pcoded-mtext">Waste Collection</span>
                        </a>
                            <ul class="pcoded-submenu">
                                <li class="">
                                    <a class="slide-item" href="{{url('HCFCollection/create')}}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">HCFCollection</span>
                                </a>
                                </li>
                            </ul>
                        </li>
                        <li class="pcoded-hasmenu">
                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="feather icon-box"></i></span>
                            <span class="pcoded-mtext">Billing/Payment</span>
                        </a>
                            <ul class="pcoded-submenu">
                                <li class="">
                                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Mannual task</span>
                                </a>
                                </li>
                                <li class="">
                                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">BillingOccupancy</span>
                                </a>
                                </li>
                                <li class="">
                                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">ChequeReceipt</span>
                                </a>
                                </li>
                                <li class=" ">
                                    <a href="animation.html" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Custom Billing</span>
                                </a>
                                </li>
                            </ul>
                        </li>
                        <li class="pcoded-hasmenu">
                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="feather icon-clipboard"></i></span>
                            <span class="pcoded-mtext">Accounting</span>
                        </a>
                            <ul class="pcoded-submenu">
                                <li class="">
                                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Group Head</span>
                                </a>                                    
                                </li>
                                <li class=" ">
                                    <a href="form-picker.html" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Accounting head</span>
                                </a>
                                </li>

                                <li class=" ">
                                    <a href="form-select.html" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">TransferVoucher</span>
                                </a>
                                </li>
                                <li class=" ">
                                    <a href="form-masking.html" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Party Ledger</span>
                                </a>
                                </li>
                                <li class=" ">
                                    <a href="form-wizard.html" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Trail Report</span>
                                </a>
                                </li>
                                <li class=" ">
                                    <a href="form-wizard.html" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">ProfitLoss</span>
                                </a>
                                </li>
                                <li class=" ">
                                    <a href="form-wizard.html" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Inventory</span>
                                </a>
                                </li>
                                <li class=" ">
                                    <a href="form-wizard.html" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">ExcelUpload</span>
                                </a>
                                </li>
                                <li class=" ">
                                    <a href="form-wizard.html" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Outstanding</span>
                                </a>
                                </li>
                            </ul>
                        </li>
                        <li class="pcoded-hasmenu">
                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="feather icon-credit-card"></i></span>
                            <span class="pcoded-mtext">Organization</span>
                        </a>
                            <ul class="pcoded-submenu">
                                <li class="">
                                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Diesel Consumption</span>
                                </a>                                    
                                </li>
                            </ul>
                        </li>
                        <li class="pcoded-hasmenu">
                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="feather icon-pie-chart"></i></span>
                            <span class="pcoded-mtext">User</span>

                        </a>
                            <ul class="pcoded-submenu">
                                <li class="">
                                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Employee</span>
                                </a>
                                    
                                </li>
                            </ul>
                        </li>
                        <li class="pcoded-hasmenu">
                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="feather icon-unlock"></i></span>
                                <span class="pcoded-mtext">Client</span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li class="">
                                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Client</span>
                                    </a>                                    
                                </li>
                                <li class="">
                                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Client Group</span>
                                </a>                                    
                                </li>
                              <li class="">
                                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Client Type</span>
                                </a>                                    
                                </li>
                                <li class="">
                                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Bulk Client Update</span>
                                </a>                                    
                                </li>
                                <li class="">
                                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Debtor List</span>
                                </a>                                    
                                </li>
                            </ul>
                        </li>
                        <li class="pcoded-hasmenu">
                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="feather icon-award"></i></span>
                            <span class="pcoded-mtext">Pharma Clients</span>
                        </a>
                            <ul class="pcoded-submenu">
                               <li class="">
                                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Pharma Client</span>
                                </a>
                                </li>
                                   <li class="">
                                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Pharma Waste</span>
                                </a>
                                </li>

                                <li class="">
                                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Pharma Debtor</span>
                                </a>
                                </li>
                            </ul>
                        </li>
                        <li class="pcoded-hasmenu">
                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="feather icon-watch"></i></span>
                            <span class="pcoded-mtext">Support</span>
                        </a>
                            <ul class="pcoded-submenu">
                                <li class="">
                                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Raise Support</span>
                                </a>
                                </li>
                                <li class="">
                                    <a href="javascript:void(0)" class="disabled waves-effect waves-dark">
                                    <span class="pcoded-mtext">Tickets</span>
                                </a>
                                </li>
                            </ul>
                        </li>
                         <li class="pcoded-hasmenu">
                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="feather icon-watch"></i></span>
                            <span class="pcoded-mtext">Masters</span>
                        </a>
                            <ul class="pcoded-submenu">
                                <li class="">
                                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Consumable</span>
                                </a>
                                </li>
                                <li class="">
                                    <a href="javascript:void(0)" class="disabled waves-effect waves-dark">
                                    <span class="pcoded-mtext">Department</span>
                                </a>
                                </li>
                                 <li class="">
                                    <a href="javascript:void(0)" class="disabled waves-effect waves-dark">
                                    <span class="pcoded-mtext">Designation</span>
                                </a>
                                </li>
                                 <li class="">
                                    <a href="javascript:void(0)" class="disabled waves-effect waves-dark">
                                    <span class="pcoded-mtext">Bank</span>
                                </a>
                                </li>
                                 <li class="">
                                    <a href="javascript:void(0)" class="disabled waves-effect waves-dark">
                                    <span class="pcoded-mtext">Plant</span>
                                </a>
                                </li>
                                 <li class="">
                                    <a href="javascript:void(0)" class="disabled waves-effect waves-dark">
                                    <span class="pcoded-mtext">Routes</span>
                                </a>
                                </li>
                                <li class="">
                                    <a href="javascript:void(0)" class="disabled waves-effect waves-dark">
                                    <span class="pcoded-mtext">Vehical</span>
                                </a>
                                </li>
                                <li class="">
                                    <a href="javascript:void(0)" class="disabled waves-effect waves-dark">
                                    <span class="pcoded-mtext">Vendor Details</span>
                                </a>
                                </li>
                                <li class="">
                                    <a href="javascript:void(0)" class="disabled waves-effect waves-dark">
                                    <span class="pcoded-mtext">Waste Container</span>
                                </a>
                                </li>
                            </ul>
                        </li>
                         <li class="pcoded-hasmenu">
                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="feather icon-watch"></i></span>
                            <span class="pcoded-mtext">User ID</span>
                        </a>
                            <ul class="pcoded-submenu">
                                <li class="">
                                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">User Acc Setting</span>
                                </a>
                                </li>
                                <li class="">
                                    <a href="javascript:void(0)" class="disabled waves-effect waves-dark">
                                    <span class="pcoded-mtext">Personal Details</span>
                                </a>
                                </li>
                                <li class="">
                                    <a href="javascript:void(0)" class="disabled waves-effect waves-dark">
                                    <span class="pcoded-mtext">BillingConfiguration</span>
                                </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
              @yield('body')
              @yield('content')

            
            </div>
          </div>
        </div>
      </div>


<!-- Required Jquery -->
    @yield('js')

<?php
?>

    <script src="{{asset('theme/bower_components/jquery/js/jquery.min.js')}}"></script>
    <script src="{{asset('theme/bower_components/jquery-ui/js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('theme/bower_components/popper.js/js/popper.min.js')}}"></script>
    <script src="{{asset('theme/bower_components/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('theme/assets/pages/waves/js/waves.min.js')}}"></script>
    <script src="{{asset('theme/bower_components/jquery-slimscroll/js/jquery.slimscroll.js')}}"></script>
    <script src="{{asset('theme/bower_components/Sortable/js/Sortable.js')}}"></script>
    <script src="{{asset('theme/assets/pages/sortable-custom.js')}}"></script>
    <script src="{{asset('theme/bower_components/modernizr/js/modernizr.js')}}"></script>
    <script src="{{asset('theme/bower_components/modernizr/js/css-scrollbars.js')}}"></script>
    <script src="{{asset('theme/assets/js/pcoded.min.js')}}"></script>
    <script type="text/javascript">
       
        function sidebarFunction(){
            var status = 2;
            // var user_id = 0;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "{{route('layout-set-auth')}}",
                dataType: 'json',
                data: "status=" + status,
                success: function (data) 
                {
                    location.reload(); 
                }
            });
        }
        function upperbarFunction(){
            var status = 1;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "{{route('layout-set-auth')}}",
                dataType: 'json',
                data: "status=" + status,
                success: function (data) 
                {
                    location.reload(); 
                }
            });
        }
    </script>

    <?php
    if($layout_status == '2' ) {
        ?>

       
        <script src="{{asset('theme/assets/js/vertical/vertical-layout.min.js')}}"></script>
        <?php
    } 
    else if($layout_status == '1') {
        ?>

       
        <script src="{{asset('theme/assets/js/vertical/menu/menu-hori-fixed.js')}}"></script>
        <?php
    }
    else {
        ?>
        
        <!-- <script src="{{asset('theme/assets/js/vertical/menu/menu-hori-fixed.js')}}"></script> -->
        <?php
    }
    ?>

    <script src="{{asset('theme/assets/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('theme/assets/js/script.js')}}"></script>

 

</body>

</html>
