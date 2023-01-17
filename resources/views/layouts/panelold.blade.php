<!doctype html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@php

 //$userSessionData = getAuthDetails();  

@endphp

@include('includes.head.main')

<body class="main-body app sidebar-mini admin-bg sidenav-toggled">

    <!-- Global Loader -->

    @include('includes.loader.global')

    <!-- ./Global Loader -->

    <!-- main-sidebar -->

    @include('includes.sidebar.main')

    <!-- ./main-sidebar -->



    <!-- main-content -->

    <div class="main-content app-content">

        <!-- main-header -->

        @include('includes.header.main')

        <!-- /main-header -->



        <!-- container -->

        <div class="container-fluid">

            <!-- breadcrumb -->

            @include('includes.breadcrumb.main')

            <!-- /breadcrumb -->

            <!-- breadcrumb -->

            @include('includes.flash.message')

            <!-- /breadcrumb -->

            <!-- Main Content -->

                <main>

                @yield('content')

                </main>

            <!-- ./Main Content -->

        </div>

        <!-- /Container -->

    </div>

    <!-- /main-content -->

    <!-- Sidebar-right-->

    @include('includes.sidebar.right')

    <!--/Sidebar-right-->

    <!-- Modals -->

    @include('includes.modals.main')

    <!-- ./Modals -->

    <!-- Footer Modal -->

    @include('includes.footer.main')

    @yield('custom_scripts')

    <script type="text/javascript" src="{{asset('js/form_script.js')}}"></script>

    <!-- ./Footer Modal -->

</body>

</html>

