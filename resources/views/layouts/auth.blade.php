<!doctype html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">


@include('includes.head.main')

<body class="main-body {{Route::current()->getName() }} authentication-bg">

    <!-- Global Loader -->

    {{-- @include('includes.loader.global') --}}

    <!-- ./Global Loader -->

    {{-- <div class="home-btn d-none d-sm-block">

        <a href="index.html" class="text-dark"><i class="mdi mdi-home-variant h2"></i></a>

    </div> --}}

    <div class="account-pages my-5">

            <div class="container">

                <div class="row">

                    <div class="col-lg-12">

                        <div class="text-center">

                            <a href="{{url('/')}}" class="mb-5 d-block auth-logo">

                               <img src="{{ asset('themed/admin/assets/images/logo-light.png') }}" alt="" class="logo logo-dark">

                            </a>

                        </div>

                    </div>

                </div>

                @yield('content')

                <!-- end row -->

            </div>

            <!-- end container -->

        </div>

    <!-- Footer Modal -->

    @include('includes.footer.main')

    <!-- ./Footer Modal -->

</body>

</html>

