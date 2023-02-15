<!DOCTYPE html>
<html lang="en">

<head>
    <title>Atswask Logicedge</title>

    @yield('title')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description"
        content="Admindek Bootstrap admin template made using Bootstrap 4 and it has huge amount of ready made feature, UI components, pages which completely fulfills any dashboard needs.">
    <meta name="keywords"
        content="bootstrap, bootstrap admin template, admin theme, admin dashboard, dashboard template, admin template, responsive">
    <meta name="author" content="colorlib">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon icon -->
    <link rel='stylesheet'
        href='https://rawgit.com/vitalets/x-editable/master/dist/bootstrap3-editable/css/bootstrap-editable.css'>
    <link rel='stylesheet' href="{{ asset('assets/css/bootstrap-table.min.css') }}">
    <!-- <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon" style="width: 10px;"> -->
    <!-- Google font-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('theme/bower_components/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/assets/css/bootstrap-select.min.css') }}">
    <!--<link rel="stylesheet" href="{{ asset('theme/assets/css/fstdropdown.css') }}">-->

    <!-- waves.css')}} -->
    <link rel="stylesheet" href="{{ asset('theme/assets/pages/waves/css/waves.min.css') }}" type="text/css"
        media="all">
    <!-- feather icon -->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/assets/icon/feather/css/feather.css') }}">
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/assets/icon/themify-icons/themify-icons.css') }}">
    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/assets/icon/icofont/css/icofont.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('theme/assets/icon/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">

    <!-- Style.css')}} -->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/assets/css/style.css') }}">
    <!--       <link rel="stylesheet" type="text/css" href="{{ asset('theme/assets/css/style1.css') }}"> -->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/assets/css/pages.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/assets/css/widget.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/assets/css/grv.css') }}">

    <link rel="stylesheet" href="{{ asset('theme/assets/css/dropdown_search.css') }}">


    <link rel="stylesheet" href="{{ asset('theme/assets/css/chosen.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('theme/assets/css/jquery-ui.theme.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('theme/assets/css/jquery-ui.min.css') }}">
   
    {{-- <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet"> --}}

    <link rel="stylesheet" href="{{ asset('theme/assets/css/sweet_alert.min.css') }}">

    <link rel="stylesheet" href="{{ asset('theme/assets/css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('msell/css/bootstrap-datepicker3.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('msell/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/assets/css/light_ness.min.css') }}">
    <script src="{{ asset('theme/assets/js/tableExport.js') }}"></script>

    <script src="{{ asset('theme/assets/js/ace-extra.min.js') }}"></script>

    <script>
        if (location.hostname == "localhost") {
            var domain = '{{ Request::root() }}';
        } else {
            var domain = '{{ Request::root() }}'.replace("https", "https");

        }
    </script>


    <style>
        li[data-type^="json"],
        li[data-type^="txt"],
        li[data-type^="sql"] {
            display: none;
        }
.pagination>.active>a, .pagination>.active>a:focus, .pagination>.active>a:hover, .pagination>.active>span, .pagination>.active>span:focus, .pagination>.active>span:hover {
    background-color: darkslategray !important;
}
    .ui-datepicker-title , .ui-datepicker-header {
        background-color: darkslategray !important;
    }
    .ui-state-default , .ui-state-highlight{
        background-color: #fff;
    }
    .ui-state-default{
        color : darkslategray !important;
    }
        #overlay {
            position: fixed;
            top: 0;
            z-index: 100;
            width: 100%;
            height: 100%;
            display: none;
            background: darkslategray;
        }

        .cv-spinner {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px #ddd solid;
            border-top: 4px #2e93e6 solid;
            border-radius: 50%;
            animation: sp-anime 0.8s infinite linear;
        }

        .grv__margin {
            margin-top: 50px !important;
        }
        .switch {
            position: relative;
            display: inline-block;
            width: 46px;
            height: 18px;
            border: 2px solid white;
            border-radius: 28px;
            top: 27px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            /*background-color: #ccc;*/
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 10px;
            width: 10px;
            left: 4px;
            bottom: 2px;
            /*background-color: white;*/
            -webkit-transition: .4s;
            transition: .4s;
            border: 2px white solid;
            background: white;
        }

        input:checked+.slider {
            /*background-color: #2196F3;*/
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 43%;
            /*background: white;*/
        }

        .slider.round:before {
            border-radius: 44%;
        }

        .loader {
            filter: url("#goo");
            position: relative;
            width: 310px;
            height: 100px;
        }

        .loader::after {
            content: "";
            display: block;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #ffffff;
            margin: 0 auto;
            position: absolute;
            top: 25px;
            left: 225px;
            -webkit-animation: scale 2.5s ease-in-out infinite;
            animation: scale 2.5s ease-in-out infinite;
        }

        .loader .action_loader {
            position: absolute;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #ffffff;
            top: 35px;
            left: 235px;
            -webkit-animation: move 2.5s ease-in-out infinite alternate;
            animation: move 2.5s ease-in-out infinite alternate;
        }

        .loader .action_loader::after,
        .loader div::before {
            content: "";
            display: block;
            position: absolute;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #ffffff;
        }

        .loader .action_loader::before {
            left: -75px;
        }

        .loader .action_loader::after {
            left: 75px;
        }

        @-webkit-keyframes move {
            0% {
                transform: translateX(-150px);
            }

            100% {
                transform: translateX(150px);
            }
        }

        @keyframes move {
            0% {
                transform: translateX(-150px);
            }

            100% {
                transform: translateX(150px);
            }
        }

        @-webkit-keyframes scale {
            10% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.25);
            }

            90% {
                transform: scale(1);
            }
        }

        @keyframes scale {
            10% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.25);
            }

            90% {
                transform: scale(1);
            }
        }

        .body1 {
            background: darkslategray;
            width: 100vw;
            height: 100vh;
        }

        .body1 {
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        svg {
            position: absolute;
            z-index: -100;
            pointer-events: none;
        }

        #select2-district_name-container {
            height: 30px;
        }

        #select2-state-container:focus {
            color: #495057;
            background-color: #fff;
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 .2rem rgba(0, 123, 255, .25);
            border: 1px solid #4099ff;
        }

        .select2.select2-container.select2-container--default.select2-container--below.select2-container--open:focus {
            color: #495057;
            background-color: #fff;
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 .2rem rgba(0, 123, 255, .25);
            border: 1px solid #4099ff;
        }

        #constitution_chosen {
            width: 100% !important;
        }

        #first_chosen {
            width: 100% !important;
        }

        .chosen-container.chosen-container-single {
            width: 100% !important;
        }

        #overlay {
            position: fixed;
            top: 0;
            z-index: 100;
            width: 100%;
            height: 100%;
            display: none;
            background: darkslategray;
        }

        .cv-spinner {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px #ddd solid;
            border-top: 4px #2e93e6 solid;
            border-radius: 50%;
            animation: sp-anime 0.8s infinite linear;
        }

        @keyframes sp-anime {
            100% {
                transform: rotate(360deg);
            }
        }

        .header-navbar .navbar-wrapper .navbar-container .badge {
            position: unset;
            width: auto;
        }
body{
  margin: 0;
  overflow: scroll;
}

.drawing{
    width: 100vw;
    height: 100vh;
    position: relative;
    display: block;
    background-color: darkslategray;
}
@if(!empty((session()->get('SlipStored'))) && session()->get('SlipStored') != '')
.swal2-popup{
    width : auto !important;
}
.swal2-title{
    text-align: left !important;
}
@endif


/* -- Loading thingy --*/
.loading-dot {
    border-radius:100%;
    height:20px;
    width:20px;
    background-color: darkslategray;
    position:absolute;
    left:0;
    right:0;
    margin:auto;
    top:0;
    bottom:0;
    box-shadow: 0px 40px 0px 0px #ffffff,0px -40px 0px 0px #ffffff,40px 0px 0px 0px #ffffff,-40px 0px 0px 0px #ffffff,
    40px 40px 0px 0px #ffffff,-40px -40px 0px 0px #ffffff,40px -40px 0px 0px #ffffff,-40px 40px 0px 0px #ffffff;
    -webkit-animation: load 3s infinite linear;
    -moz-animation: load 3s infinite linear;
    -o-animation: load 3s infinite linear;
    animation:load 3s infinite linear;
}


@-webkit-keyframes load {
  0%   {
    -webkit-transform: translate(0px,0px),rotate(0deg); 
    box-shadow: 0px 40px 0px 0px #ffffff,0px -40px 0px 0px #ffffff,40px 0px 0px 0px #ffffff,-40px 0px 0px 0px #ffffff,
    40px 40px 0px 0px #ffffff,-40px -40px 0px 0px #ffffff,40px -40px 0px 0px #ffffff,-40px 40px 0px 0px #ffffff;
  }

  25%{
    box-shadow: 0px 60px 0px 0px #ffffff,0px -60px 0px 0px #ffffff,60px 0px 0px 0px #ffffff,-60px 0px 0px 0px #ffffff,
    -60px -60px 0px 0px #ffffff,60px 60px 0px 0px #ffffff,-60px 60px 0px 0px #ffffff,60px -60px 0px 0px #ffffff;
  }

  50%{
    box-shadow: 0px -60px 0px 0px #ffffff,0px 60px 0px 0px #ffffff,-60px 0px 0px 0px #ffffff,60px 0px 0px 0px #ffffff,
    -60px -60px 0px 0px #ffffff,60px 60px 0px 0px #ffffff,-60px 60px 0px 0px #ffffff,60px -60px 0px 0px #ffffff;
  }

  70%{
    box-shadow: 0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,
    0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff;
  }

  75%{
    box-shadow: 0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,
    0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff;
    height:10px;
    width:10px;
  }

  80%{
    -webkit-transform: translate(0px,0px) rotate(360deg); 
    box-shadow: 0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,
    0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff;
    background-color: #ffffff;
    height:40px;
    width:40px;
  }

  85%{
    -webkit-transform: translate(0px,0px) rotate(360deg);
    box-shadow: 0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,
    0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff;
    background-color: #ffffff; 
    height:40px;
    width:40px;
  }

  90%{
    -webkit-transform: translate(0px,0px) rotate(360deg); 
    box-shadow: 0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,
    0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff;
    background-color: #ffffff; 
    height:10px;
    width:10px;
  }

  95{
    box-shadow: 0px 40px 0px 0px #ffffff,0px -40px 0px 0px #ffffff,40px 0px 0px 0px #ffffff,-40px 0px 0px 0px #ffffff,
    40px 40px 0px 0px #ffffff,-40px -40px 0px 0px #ffffff,40px -40px 0px 0px #ffffff,-40px 40px 0px 0px #ffffff;
  }

  100%{
    -webkit-transform: rotate(360deg);
    box-shadow: 0px 40px 0px 0px #ffffff,0px -40px 0px 0px #ffffff,40px 0px 0px 0px #ffffff,-40px 0px 0px 0px #ffffff,
    40px 40px 0px 0px #ffffff,-40px -40px 0px 0px #ffffff,40px -40px 0px 0px #ffffff,-40px 40px 0px 0px #ffffff;
  }

}

@-moz-keyframes load {
  0%   {
    -moz-transform: translate(0px,0px),rotate(0deg); 
    box-shadow: 0px 60px 0px 0px #ffffff,0px -60px 0px 0px #ffffff,60px 0px 0px 0px #ffffff,-60px 0px 0px 0px #ffffff,
    60px 60px 0px 0px #ffffff,-60px -60px 0px 0px #ffffff,60px -60px 0px 0px #ffffff,-60px 60px 0px 0px #ffffff;
  }

  25%{
    box-shadow: 0px 60px 0px 0px #ffffff,0px -60px 0px 0px #ffffff,60px 0px 0px 0px #ffffff,-60px 0px 0px 0px #ffffff,
    -60px -60px 0px 0px #ffffff,60px 60px 0px 0px #ffffff,-60px 60px 0px 0px #ffffff,60px -60px 0px 0px #ffffff;
  }

  50%{
    box-shadow: 0px -60px 0px 0px #ffffff,0px 90px 0px 0px #ffffff,-90px 0px 0px 0px #ffffff,90px 0px 0px 0px #ffffff,
    -90px -90px 0px 0px #ffffff,90px 90px 0px 0px #ffffff,-90px 90px 0px 0px #ffffff,90px -90px 0px 0px #ffffff;
  }

  70%{
    box-shadow: 0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,
    0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff;
  }

  75%{
    box-shadow: 0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,
    0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff;
    height:10px;
    width:10px;
  }

  80%{
    -moz-transform: translate(0px,0px) rotate(360deg); 
    box-shadow: 0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,
    0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff;
    background-color: #ffffff;
    height:90px;
    width:90px;
  }

  85%{
    -moz-transform: translate(0px,0px) rotate(360deg);
    box-shadow: 0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,
    0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff;
    background-color: #ffffff; 
    height:90px;
    width:90px;
  }

  90%{
    -moz-transform: translate(0px,0px) rotate(360deg); 
    box-shadow: 0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,
    0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff;
    background-color: #ffffff; 
    height:10px;
    width:10px;
  }

  95{
    box-shadow: 0px 90px 0px 0px #ffffff,0px -90px 0px 0px #ffffff,90px 0px 0px 0px #ffffff,-90px 0px 0px 0px #ffffff,
    90px 90px 0px 0px #ffffff,-90px -90px 0px 0px #ffffff,90px -90px 0px 0px #ffffff,-90px 90px 0px 0px #ffffff;
  }

  100%{
    -moz-transform: rotate(360deg);
    box-shadow: 0px 90px 0px 0px #ffffff,0px -90px 0px 0px #ffffff,90px 0px 0px 0px #ffffff,-90px 0px 0px 0px #ffffff,
    90px 90px 0px 0px #ffffff,-90px -90px 0px 0px #ffffff,90px -90px 0px 0px #ffffff,-90px 90px 0px 0px #ffffff;
  }

}

@keyframes load {
  0%   {
    transform: translate(0px,0px),rotate(0deg); 
    box-shadow: 0px 90px 0px 0px #ffffff,0px -90px 0px 0px #ffffff,90px 0px 0px 0px #ffffff,-90px 0px 0px 0px #ffffff,
    90px 90px 0px 0px #ffffff,-90px -90px 0px 0px #ffffff,90px -90px 0px 0px #ffffff,-90px 90px 0px 0px #ffffff;
  }

  25%{
    box-shadow: 0px 90px 0px 0px #ffffff,0px -90px 0px 0px #ffffff,90px 0px 0px 0px #ffffff,-90px 0px 0px 0px #ffffff,
    -90px -90px 0px 0px #ffffff,90px 90px 0px 0px #ffffff,-90px 90px 0px 0px #ffffff,90px -90px 0px 0px #ffffff;
  }

  50%{
    box-shadow: 0px -90px 0px 0px #ffffff,0px 90px 0px 0px #ffffff,-90px 0px 0px 0px #ffffff,90px 0px 0px 0px #ffffff,
    -90px -90px 0px 0px #ffffff,90px 90px 0px 0px #ffffff,-90px 90px 0px 0px #ffffff,90px -90px 0px 0px #ffffff;
  }

  70%{
    box-shadow: 0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,
    0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff;
  }

  75%{
    box-shadow: 0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,
    0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff;
    height:10px;
    width:10px;
  }

  80%{
    transform: translate(0px,0px) rotate(360deg); 
    box-shadow: 0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,
    0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff;
    background-color: #ffffff;
    height:90px;
    width:90px;
  }

  85%{
    transform: translate(0px,0px) rotate(360deg);
    box-shadow: 0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,
    0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff;
    background-color: #ffffff; 
    height:90px;
    width:90px;
  }

  90%{
    transform: translate(0px,0px) rotate(360deg); 
    box-shadow: 0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,
    0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff;
    background-color: #ffffff; 
    height:10px;
    width:10px;
  }

  95{
    box-shadow: 0px 90px 0px 0px #ffffff,0px -90px 0px 0px #ffffff,90px 0px 0px 0px #ffffff,-90px 0px 0px 0px #ffffff,
    90px 90px 0px 0px #ffffff,-90px -90px 0px 0px #ffffff,90px -90px 0px 0px #ffffff,-90px 90px 0px 0px #ffffff;
  }

  100%{
    transform: rotate(360deg);
    box-shadow: 0px 90px 0px 0px #ffffff,0px -90px 0px 0px #ffffff,90px 0px 0px 0px #ffffff,-90px 0px 0px 0px #ffffff,
    90px 90px 0px 0px #ffffff,-90px -90px 0px 0px #ffffff,90px -90px 0px 0px #ffffff,-90px 90px 0px 0px #ffffff;
  }

}
@-o-keyframes load {
  0%   {
    -o-transforms: translate(0px,0px),rotate(0deg); 
    box-shadow: 0px 90px 0px 0px #ffffff,0px -90px 0px 0px #ffffff,90px 0px 0px 0px #ffffff,-90px 0px 0px 0px #ffffff,
    90px 90px 0px 0px #ffffff,-90px -90px 0px 0px #ffffff,90px -90px 0px 0px #ffffff,-90px 90px 0px 0px #ffffff;
  }

  25%{
    box-shadow: 0px 90px 0px 0px #ffffff,0px -90px 0px 0px #ffffff,90px 0px 0px 0px #ffffff,-90px 0px 0px 0px #ffffff,
    -90px -90px 0px 0px #ffffff,90px 90px 0px 0px #ffffff,-90px 90px 0px 0px #ffffff,90px -90px 0px 0px #ffffff;
  }

  50%{
    box-shadow: 0px -90px 0px 0px #ffffff,0px 90px 0px 0px #ffffff,-90px 0px 0px 0px #ffffff,90px 0px 0px 0px #ffffff,
    -90px -90px 0px 0px #ffffff,90px 90px 0px 0px #ffffff,-90px 90px 0px 0px #ffffff,90px -90px 0px 0px #ffffff;
  }

  70%{
    box-shadow: 0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,
    0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff;
  }

  75%{
    box-shadow: 0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,
    0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff;
    height:10px;
    width:10px;
  }

  80%{
    -o-transforms: translate(0px,0px) rotate(360deg); 
    box-shadow: 0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,
    0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff;
    background-color: #ffffff;
    height:90px;
    width:90px;
  }

  85%{
    -o-transforms: translate(0px,0px) rotate(360deg);
    box-shadow: 0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,
    0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff;
    background-color: #ffffff; 
    height:90px;
    width:90px;
  }

  90%{
    -o-transforms: translate(0px,0px) rotate(360deg); 
    box-shadow: 0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,
    0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff,0px 0px 0px 0px #ffffff;
    background-color: #ffffff; 
    height:10px;
    width:10px;
  }

  95{
    box-shadow: 0px 90px 0px 0px #ffffff,0px -90px 0px 0px #ffffff,90px 0px 0px 0px #ffffff,-90px 0px 0px 0px #ffffff,
    90px 90px 0px 0px #ffffff,-90px -90px 0px 0px #ffffff,90px -90px 0px 0px #ffffff,-90px 90px 0px 0px #ffffff;
  }

  100%{
    -o-transforms: rotate(360deg);
    box-shadow: 0px 90px 0px 0px #ffffff,0px -90px 0px 0px #ffffff,90px 0px 0px 0px #ffffff,-90px 0px 0px 0px #ffffff,
    90px 90px 0px 0px #ffffff,-90px -90px 0px 0px #ffffff,90px -90px 0px 0px #ffffff,-90px 90px 0px 0px #ffffff;
  }

}
label{
    font-weight: 600;
}
    </style>

   

    @yield('css')

</head>

@php
$layout_status = Auth::user()->layout_status;
@endphp

<body>
    @if (!empty((session()->get('newtab'))) && session()->get('newtab') != '')
        @php
            $newtabstatus = 1;
            $newtab = !empty(session()->get('newtab')) ? session()->get('newtab') : ''; 
            session()->forget('newtab');
        @endphp
    @else
            @php
            $newtabstatus = 0;     
            $newtab = '';
            @endphp
    @endif     
    @if (!empty((session()->get('error'))) && session()->get('error') != '')
        @php
            $errorstatus = 1;
            $errormessage = !empty(session()->get('error')) ? session()->get('error') : ''; 
            session()->forget('error');
        @endphp
    @else
            @php
            $errorstatus = 0;     
            $errormessage = '';
            @endphp
    @endif   
    @if (!empty((session()->get('SlipStored'))) && session()->get('SlipStored') != '')
        @php
            $slip_generation_status = 1;
            $generationmessage = !empty(session()->get('SlipStored')) ? session()->get('SlipStored') : ''; 
            session()->forget('SlipStored');
        @endphp
    @else
            @php
            $slip_generation_status = 0;     
            $generationmessage = '';
            @endphp
    @endif
    @if (session()->has('success'))
        @php
            $sweet_alert_status = 1;
            $message = session()->get('success');
            
        @endphp
    @else
        @php
            $sweet_alert_status = 0;
            $message='';
        @endphp
    @endif


    {{-- confimation modal for delete --}}
   

    <button  type="button" data-toggle="modal" data-target="#confirmationModal" id="confirmationmodalbtn" style="display: none">confirmation modal</button>
   
     <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document" >
             
             <div class="modal-content">
                 <div class="modal-header">
                 </div>
                 <div class="modal-body text-center">
                     <i class="fa fa-exclamation-triangle fa-10x"></i>
                     <h2 style="font-weight: bold;color: black;font-size: 35px;margin-top: 15px;">Are you
                         sure?</h2>

                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-danger" data-dismiss="modal"
                         style=" margin-left: 110px;"> No,cancel!</button>
                     <form action="" method="POST" id="confirmationModalForm"
                         class="blockuie dropdown-item" style="margin: auto">
                        @csrf
                        @method('delete')

                        <button type="submit" class="btn btn-success">Yes, I am
                            Sure!</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- @endif --}}


    {{-- confirmation modal for regenrate button --}}

    <button  type="button" data-toggle="modal" data-target="#confirmationModal1" id="confirmationmodalbtn1" style="display: none">confirmation modal</button>
   
    <div class="modal fade" id="confirmationModal1" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" >
            
            <div class="modal-content">
                <div class="modal-header">
                </div>
                <div class="modal-body text-center">
                    <i class="fa fa-exclamation-triangle fa-10x"></i>
                    <h2 style="font-weight: bold;color: black;font-size: 35px;margin-top: 15px;">Are you
                        sure?</h2>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                        style="margin-top: 9px; margin-left: 90px;"> No,cancel!</button>
                    <form action="" method="" id="confirmationModalForm1"
                        class="blockuie dropdown-item">
                       @csrf
                       {{-- @method('delete') --}}

                       <button type="submit" class="btn btn-success" style="margin-top:11px">Yes, I am
                           Sure!</button>
                   </form>
               </div>
           </div>
       </div>
   </div>




    <div id="overlay">
        <div class="cv-spinner">
            <span class="spinner"></span>
        </div>
    </div>
    <!--  only for data set loader starts here  -->
    <div id="overlay">
        <div class="cv-spinner">
            <span class="spinner"></span>
        </div>
    </div>

    {{-- <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <!--  <div class="loader-bar"></div> -->
        <div class="body1">
            <div class="loader">
                <div class="action_loader"></div>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1">
                <defs>
                    <filter id="goo">
                        <fegaussianblur in="SourceGraphic" stddeviation="15" result="blur"></fegaussianblur>
                        <fecolormatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 30 -10"
                            result="goo"></fecolormatrix>
                        <feblend in="SourceGraphic" in2="goo"></feblend>
                    </filter>
                </defs>
            </svg>
        </div>
    </div>
    <!-- [ Pre-loader ] end --> --}}

    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <!--  <div class="loader-bar"></div> -->
        <div class="body1">
            {{--
            <div class="loader">
                <div class="action_loader"></div>
            </div>
            --}}
    <div class="drawing" id="loading">
        <div class="loading-dot"></div>
    </div>
        </div>
    </div>
    <!-- [ Pre-loader ] end -->
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">
            <!-- [ Header ] start -->
            <nav class="navbar header-navbar pcoded-header">
                <div class="navbar-wrapper">
                    <div class="navbar-logo" style="padding-top: 25px;">
                        <a href="home" class="grv_imp">
                            <img class="img-fluid" src="{{ asset('images/logo-light.png') }}"
                                style="margin-top: -24px;width: 130px;height: 50px;margin-left: 20px;">
<!--                             <img class="img-fluid" src="{{ asset('images/logo.png') }}" alt="Theme-Logo"
                                style="width: 70%;"> -->
                            <!-- <h2 style="margin-top: -39px;font-size: 26px;margin-right: -252px;font-weight: bold;">GROUP</h2> -->
                            <!-- <img class="img-fluid" src="{{ asset('images/logo_group.png') }}"alt="Theme-Logo" style="width: 84%;margin-top: -22px;"> -->
                            <!-- <img class=img-fluid" src="{{ asset('images/erp.png') }}" style="width:31px;margin-left:-7px;">  -->
                        </a>
                        <a  class="mobile-menu" id="mobile-collapse" href="#!">
                            <i class="feather icon-menu icon-toggle-right"></i>
                        </a>
                        <a class="mobile-options waves-effect waves-light">
                            <i class="feather icon-more-horizontal"></i>
                        </a>
                    </div>
                    <div class="navbar-container container-fluid">
                        <ul class="nav-left">
                            <li class="header-search">
                           
                            </li>
                            <li>
                                <a href="#!" style="margin-left: -100px;" onclick="javascript:toggleFullScreen()" class="waves-effect waves-light">
                                    <i class="full-screen feather icon-maximize"></i>
                                </a>
                            </li>
                            
                        </ul>
                        <ul class="nav-right">
                            <?php
                            $data = App\Http\Controllers\NotificationController::index();
                            
                            ?>
                          
                            
                            
                            <li class="user-profile header-notification" style="margin-top: -6px;">
                                <div class="dropdown-primary dropdown">
                                    <div class="dropdown-toggle" data-toggle="dropdown">
                                        {{-- <img src="{{asset('theme/assets/images/avatar-4.jpg')}}" class="img-radius" alt="User-Profile-Image"> --}}
                                        <span>{{ Auth::user()->name }}</span>
                                        <i class="feather icon-chevron-down"></i>
                                    </div>
                                    <ul class="show-notification profile-notification dropdown-menu"
                                        data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                       
                                        <li>
                                            <a onclick="sidebarFunction()">
                                                <i class="feather icon-lock"></i> Side Bar Layout
                                            </a>
                                        </li>
                                        <li>
                                            <a onclick="upperbarFunction()">
                                                <i class="feather icon-lock"></i> Upper Bar Layout

                                            </a>
                                        </li>
                                        <li>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                style="display: none;">{{ csrf_field() }}</form>
                                                @method('POST')
                                            <a href="{{ route('logout') }}"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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
         
            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    <!-- [ navigation menu ] start -->
                    @include('layouts.partials.navbar')
                    @if (session()->has('message'))
                        <div class="pcoded-content">
                            <br>
                            <br>

                            <div class="alert alert-success alert-dismissable col-md-12" style="">
                                <h5> {{ session()->get('message') }}
                                    <button type="button" class="close" data-dismiss="alert"
                                        aria-label="Close">
                                        <span aria-hidden="true" class="fs-3">&times;</span>
                                </h5>
                            </div>
                        </div>

                </div>
                @endif
                @if ($message = Session::get('success'))
                @endif
                @yield('body')
                @yield('content')


            </div>
        </div>
    </div>
    </div>
    {{-- this is sweetalertbtn --}}
    <button id="slipgeneratedbtn" onclick="slipgenerated()" style="display: none;">
    <button id="sweetalertbtn" onclick="sweetalert()" style="display: none">see sweetalert</button>
    <button id="errorbtn" onclick="errorsweetalert()" style="display: none"></button>
    @php
        empty($sweet_alert_status) ? ($sweet_alert_status = 0) : ($sweet_alert_status = 1);
        empty($slip_generation_status) ? ($slip_generation_status = 0) : ($slip_generation_status = 1);
        empty($errorstatus) ? ($errorstatus = 0) : ($errorstatus = 1);        
    @endphp


    <!-- Required Jquery -->

    <?php
    
    ?>


    <script src="{{ asset('theme/bower_components/jquery/js/jquery.min.js') }}"></script>
    <!--<script src="{{ asset('theme/bower_components/jquery-ui/js/jquery-ui.min.js') }}"></script>-->
    <script src="{{ asset('theme/bower_components/popper.js/js/popper.min.js') }}"></script>
    <script src="{{ asset('theme/bower_components/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('theme/assets/pages/waves/js/waves.min.js') }}"></script>
    <script src="{{ asset('theme/bower_components/jquery-slimscroll/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('theme/bower_components/Sortable/js/Sortable.js') }}"></script>
    <script src="{{ asset('theme/assets/pages/sortable-custom.js') }}"></script>
    <script src="{{ asset('theme/bower_components/modernizr/js/modernizr.js') }}"></script>
    <script src="{{ asset('theme/bower_components/modernizr/js/css-scrollbars.js') }}"></script>
    <script src="{{ asset('theme/assets/js/pcoded.min.js') }}"></script>
    <!--<script src="{{ asset('theme/assets/js/fstdropdown.js') }}"></script>-->
    <script src="{{ asset('theme/assets/js/dropdown_search.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/chosen.jquery.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/sweet_alert.min.js') }}"></script>


    @yield('js')

    <script type="text/javascript">
// $(".fstdropdown-select").on('change' , function(){
//     $("this").next().trigger('click');
// });
$(document).on('focus', '.select2-selection.select2-selection--single', function (e) {
  $(this).closest(".select2-container").siblings('select:enabled').select2('open');
});

// steal focus during close - only capture once and stop propogation
$('select.select2').on('select2:closing', function (e) {
  $(e.target).data("select2").$selection.one('focus focusin', function (e) {
    e.stopPropagation();
  });
});
$(function() {
  $(document).off('keydown ,select2:close', '.form-control,.select2-search__field')
  jQuery.extend(jQuery.expr[':'], {
    focusable: function(el, index, selector) {
      return $(el).is('a, button, :input, [tabindex]');
    }
  });
  $(document).on('keydown ,select2:close', '.select2-search__field', function(e) {

    if (e.which == 13) {
      e.preventDefault();
      // console.log($(this).index());
      nextOnTabIndex($(this));
    }
  });
});
function nextOnTabIndex(element) {
    var container = element.parent();
    var parent_updateed_id = container.parent()[0].lastChild.childNodes[0].id;
    var replced_parent =  parent_updateed_id.replace('select2-' , '');
    var parent_id = replced_parent.replace('-results' , '');

    var parentobj = $("#"+parent_id);
            var self = parentobj, form = self.parents('form:eq(0)'), focusable, next;
            
            var  form_lenth = form[0].length;
            var    form_elements  = form[0];
            var cuurent_select_index = Array.from(form_elements.elements).indexOf(self[0]);

            form[0][cuurent_select_index+1].focus();
            
                        // console.log(form[0][2] == self[0]);
            // focusable = form.find('input:not([readonly]) , select').filter(':visible'); 
            // next = focusable.eq(focusable.index(parentobj) + 1);
            // next.focus();


    // console.log(container.parent()[0].lastChild.childNodes[0].id);
    // $(this).next().find('input')[0].firstChild.childNodes;
    // $.tabNext();
    // console.log(element[0]);
    // console.log('container');
    // var container = element.parent('.select2-container');
    // console.log(container);
    // console.log('select');
    // var select = container.closest('select');
    // console.log(select);
      // var $focused = $(':focus');
      // var  focusindex = $(':focus').index();
      // var select = $focused.parents('select');
      // console.log(select);
      // var form = $focused.parents('form:eq(0)');
      //       // var self = $(this), form = self.parents('form:eq(0)'), focusable, next;
      //       focusable = form.find('input:not([readonly]) , select').filter(':visible'); 
      //       console.log(element.index());
      //        next = focusable.eq(focusable.index(focusindex) +1);
      //        console.log(next);
      //        next.focus();
}



        let mobile_grv = document.getElementById("mobile_grv");
        let hide_ag = document.getElementById("hide_ag");
        let grv_margin = document.getElementById("grv_margin");
        var app_url = "{{ config('app.url') }}";

        $.ajaxSetup({
            headers: {
                'Access-Control-Allow-Origin': '*',
                // 'Authorization': bearer_token
            }
        });
        $(document).ready(function() {
            //  Get User Plants
            $.ajax({
                // beforeSend: function(xhr) {},
                url: app_url + 'get-user-plants',
                method: "GET",
                // dataType: "json",
                success: function(response) {
                    var plants = '';
                    if (response.data) {
                        var data_list = response.data;
                        $.each(data_list, function(index, value) {
                            plants += '<li><a href="' + app_url + 'setPlant/' + value.id +
                                '" data-plant="' + JSON.stringify(value) +
                                '"><i class="feather icon-list"></i>' + value.name +
                                '</a></li>';
                        });
                        $(".user-plants").append(plants);
                    }
                },
            });

        });


        mobile_grv.addEventListener("click", (e) => {

            if (hide_ag.style.display != "none") {
                hide_ag.style.display = "none";
                grv_margin.classList.add("grv__margin");
            } else {
                hide_ag.style.display = "block";
                grv_margin.classList.remove("grv__margin");
            }
        });
    </script>
    <script type="text/javascript">
        function sidebarFunction() {
            var status = 2;
            // var user_id = 0;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "{{ route('layout-set-auth') }}",
                dataType: 'json',
                data: "status=" + status,
                success: function(data) {
                    location.reload();
                }
            });
        }

        function upperbarFunction() {
            var status = 1;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "{{ route('layout-set-auth') }}",
                dataType: 'json',
                data: "status=" + status,
                success: function(data) {
                    location.reload();
                }
            });
        }
    </script>
    <script>
        // ved => success sweetalert code starts here 
        var status = "<?php echo $sweet_alert_status; ?>";
        var message = "<?php echo $message; ?>";

        if (status == 1) {
            document.getElementById("sweetalertbtn").click();
        }

        function sweetalert() {
            Swal.fire({
                position: 'middle',
                icon: 'success',
                title: message,
                showConfirmButton: false,
                timer: 1500
            })
        }


        // sweetalert code ends here
    </script>
    <script type="text/javascript">
        // ved =>  slip generation sweetalert code 
        var generated = "<?php echo $slip_generation_status; ?>";
        var generationmsg = "<?php echo $generationmessage; ?>";

        if( generated == 1 ){
            document.getElementById("slipgeneratedbtn").click();
        }

        function slipgenerated(){
            Swal.fire({
                position: 'middle',
                icon: 'success',
                title: generationmsg,
                showConfirmButton: true,
            })            
        }
        // slip generation sweetalert code ends
    </script>
    <script type="text/javascript">
        // ved => error sweetalert code starts
        var error = "<?php echo $errorstatus; ?>";
        var errormsg = "<?php echo $errormessage; ?>";

        if( error == 1 ){
            document.getElementById("errorbtn").click();
        }   
        function errorsweetalert(){
            Swal.fire({
                position: 'middle',
                icon: 'error',
                title: errormsg,
                showConfirmButton: true,
            })            
        }             
    </script>
    <script type="text/javascript">
        //script to redirect new tab on request from controller
        var newtab = "{{$newtab}}";
        if(newtab != ''){
            let a= document.createElement('a');
            a.target= '_blank';
            a.href= '{{$newtab}}';
            a.click();
        }
    </script>
    <?php
      if($layout_status == '2' ) {
    ?>
    <style type="text/css">
        .pcoded[theme-layout="vertical"][vertical-placement="left"][vertical-nav-type="offcanvas"][vertical-effect="shrink"] .pcoded-navbar .pcoded-item>li>a .pcoded-mtext {
            opacity: 0;
        }

        .pcoded[theme-layout="vertical"][vertical-placement="left"][vertical-nav-type="offcanvas"][vertical-effect="shrink"] .pcoded-navbar .pcoded-item li.pcoded-hasmenu>a::after {
            opacity: 0;
        }

        .pcoded-micon i {
            margin-left: -15px;

            font-size: 20px;
        }

        .pcoded-mtext {
            margin-left: 36px !important;
        }

        .page-header.card {
            margin: 30px 59px 15px !important;
        }

        .pcoded[theme-layout="vertical"][vertical-placement="left"][vertical-nav-type="offcanvas"][vertical-effect="shrink"] .pcoded-navbar {
            margin-left: 0px !important;
            width: 60px !important;
            opacity: 1 !important;
        }


        .pcoded[theme-layout="vertical"][vertical-placement="left"][vertical-nav-type="offcanvas"][vertical-effect="shrink"] .pcoded-navbar {
            width: 60px !important;
            opacity: 1 !important;
        }

    </style>
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/assets/css/style1.css') }}">
    <script src="{{ asset('theme/assets/js/vertical/vertical-layout.min.js') }}"></script>
    <?php
    } 
    else if($layout_status == '1') {
    ?>
    <script src="{{ asset('theme/assets/js/vertical/menu/menu-hori-fixed.js') }}"></script>
    <?php
    }
    else {
    ?>

    <?php
    }
    ?>



    <script src="{{ asset('theme/assets/js/drag_and_drop.js') }}"></script>
    <script src="{{ asset('theme/assets/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('theme/assets/js/script.js') }}"></script>
    <script src="{{ asset('theme/assets/js/bootstrap-table.js') }}"></script>
    <script src="{{ asset('theme/assets/js/bootstrap-table-editable.js') }}"></script>
    <script src="{{ asset('theme/assets/js/bootstrap-table-export.js') }}"></script>
    <!-- <script src="{{ asset('theme/assets/js/tableExport.js') }}"></script> -->
    <script src="{{ asset('theme/assets/js/bootstrap-table-filter-control.js') }}"></script>
    <script src="{{ asset('theme/assets/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/state_district.js') }}"></script>
    <script src="{{ asset('theme/assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/ajaxclient_options.js') }}"></script>
    <script src="{{ asset('theme/assets/js/confirmation_alert.js') }}"></script>

    <script type="text/javascript">
         function select2hander(e){
             var key = e.keyCode || e.which;
             if(key == 13){
                // console.log($(this));
                // console.log($(this));
                 // select2-results__option--highlighted
             // var e = jQuery.Event("keydown");e.which = 3;  
                    // $(this).closest('select').select2("close");
                 // $(this).parent().next().find('input').focus();
                 // var text = $(".select2-results__option--highlighted").trigger('select');
                 // alert(text);
             // $(this).closest('select').trigger('select2:select');
             // var val = $('.select2-results__option--highlighted').attr('aria-selected' , true);
                 // alert($(this).parents('select').val());
             }
         }
        function focusnext(e){
// document.activeElement.blur();
        }
        jQuery(function($) {
            if (!ace.vars['touch']) {
                $('.chosen-select').chosen({
                    allow_single_deselect: true
                });
                //resize the chosen on window resize

                $(window)
                    .off('resize.chosen')
                    .on('resize.chosen', function() {
                        $('.chosen-select').each(function() {
                            var $this = $(this);
                            $this.next().css({
                                'width': $this.parent().width()
                            });
                        })
                    }).trigger('resize.chosen');
                //resize chosen on sidebar collapse/expand
                $(document).on('settings.ace.chosen', function(e, event_name, event_val) {
                    if (event_name != 'sidebar_collapsed') return;
                    $('.chosen-select').each(function() {
                        var $this = $(this);
                        $this.next().css({
                            'width': $this.parent().width()
                        });
                    })
                });
                $('#chosen-multiple-style .btn').on('click', function(e) {
                    var target = $(this).find('input[type=radio]');
                    var which = parseInt(target.val());
                    if (which == 2) $('#form-field-select-4').addClass('tag-input-style');
                    else $('#form-field-select-4').removeClass('tag-input-style');
                });
            }
        });
    </script>

@yield('overriddenjs')

</body>

</html>
