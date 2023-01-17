<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta charset="utf-8"/>


    <meta name="description" content="top menu &amp; navigation"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>

    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" href="{{asset('/msell/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('/msell/font-awesome/4.5.0/css/font-awesome.min.css')}}"/>

    <!-- page specific plugin styles -->

    <!-- text fonts -->
    <link rel="stylesheet" href="{{asset('/msell/css/fonts.googleapis.com.css')}}"/>

    <!-- ace styles -->
    <link rel="stylesheet" href="{{asset('/msell/css/ace.min.css')}}" class="ace-main-stylesheet" id="main-ace-style"/>

    <!--[if lte IE 9]>
    <link rel="stylesheet" href="{{asset('/msell/css/ace-part2.min.css')}}" class="ace-main-stylesheet"/>
    <![endif]-->
    <link rel="stylesheet" href="{{asset('/msell/css/ace-skins.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('/msell/css/ace-rtl.min.css')}}"/>

    <!--[if lte IE 9]>
    <link rel="stylesheet" href="{{asset('/msell/css/ace-ie.min.css')}}"/>
    <![endif]-->

    @yield('css')

<!-- ace settings handler -->
    <script src="{{asset('/msell/js/ace-extra.min.js')}}"></script>
    <script>

        if (location.hostname == "localhost") {
            var domain = '{{Request::root()}}';
        }
        else {
            var domain = location.protocol + '//' + '162.213.190.125/gopal-reports';
//            var domain = location.protocol + '//' + location.hostname + (location.port ? ':' + location.port : '');
        }
        //alert(domain);
    </script>

    {{--<!--[if lte IE 8]>--}}
    {{--<script src="msell/js/html5shiv.min.js"></script>--}}
    {{--<script src="msell/js/respond.min.js"></script>--}}
    {{--<![endif]-->--}}
<style>
        @import url(https://fonts.googleapis.com/css?family=Droid+Sans);
        #loader {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url('https://demo.msell.in/public/loader.svg') 50% 50% no-repeat rgb(249,249,249);

        }

        body{
            font-family: 'Droid Sans', sans-serif;
            background: rgba(170,179,86,1);
            background: -moz-linear-gradient(left, rgba(170,179,86,1) 0%, rgba(134,145,28,0.91) 60%, rgba(124,136,12,0.91) 77%);
            background: -webkit-gradient(left top, right top, color-stop(0%, rgba(170,179,86,1)), color-stop(60%, rgba(134,145,28,0.91)), color-stop(77%, rgba(124,136,12,0.91)));
            background: -webkit-linear-gradient(left, rgba(170,179,86,1) 0%, rgba(134,145,28,0.91) 60%, rgba(124,136,12,0.91) 77%);
            background: -o-linear-gradient(left, rgba(170,179,86,1) 0%, rgba(134,145,28,0.91) 60%, rgba(124,136,12,0.91) 77%);
            background: -ms-linear-gradient(left, rgba(170,179,86,1) 0%, rgba(134,145,28,0.91) 60%, rgba(124,136,12,0.91) 77%);
            background: linear-gradient(to right, rgba(170,179,86,1) 0%, rgba(134,145,28,0.91) 60%, rgba(124,136,12,0.91) 77%);
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#aab356', endColorstr='#7c880c', GradientType=1 );

        }
        #box{
            width:45%;
            background: rgba(226,226,226,1);
            background: -moz-linear-gradient(left, rgba(226,226,226,1) 0%, rgba(219,219,219,1) 10%, rgba(209,209,209,1) 98%, rgba(254,254,254,1) 100%);
            background: -webkit-gradient(left top, right top, color-stop(0%, rgba(226,226,226,1)), color-stop(10%, rgba(219,219,219,1)), color-stop(98%, rgba(209,209,209,1)), color-stop(100%, rgba(254,254,254,1)));
            background: -webkit-linear-gradient(left, rgba(226,226,226,1) 0%, rgba(219,219,219,1) 10%, rgba(209,209,209,1) 98%, rgba(254,254,254,1) 100%);
            background: -o-linear-gradient(left, rgba(226,226,226,1) 0%, rgba(219,219,219,1) 10%, rgba(209,209,209,1) 98%, rgba(254,254,254,1) 100%);
            background: -ms-linear-gradient(left, rgba(226,226,226,1) 0%, rgba(219,219,219,1) 10%, rgba(209,209,209,1) 98%, rgba(254,254,254,1) 100%);
            background: linear-gradient(to right, rgba(226,226,226,1) 0%, rgba(219,219,219,1) 10%, rgba(209,209,209,1) 98%, rgba(254,254,254,1) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e2e2e2', endColorstr='#fefefe', GradientType=1 );

        }
    </style>


</head>

<body class="no-skin">
<div class="loader" id="loader"></div>



    



@extends('layouts.panel')
<!-- basic scripts -->
<!--[if !IE]> -->
<script src="{{asset('msell/js/jquery-2.1.4.min.js')}}"></script>

<!-- <![endif]-->

<!--[if IE]>
<script src="{{asset('msell/js/jquery-1.11.3.min.js')}}"></script>
<![endif]-->
<script type="text/javascript">
    if ('ontouchstart' in document.documentElement) document.write("<script src='msell/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
</script>
<script src="{{asset('msell/js/bootstrap.min.js')}}"></script>

<!-- page specific plugin scripts -->

<!-- ace scripts -->
<script src="{{asset('msell/js/ace-elements.min.js')}}"></script>
<script src="{{asset('msell/js/ace.min.js')}}"></script>

<!-- inline scripts related to this page -->

<script>
    $(window).load(function(){
        $('#loader').fadeOut();
    });
</script>
@yield('js')

</body>
</html>
