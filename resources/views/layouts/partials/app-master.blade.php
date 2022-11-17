<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{!! url('public/assets/img/apple-icon.png') !!}">
    <link rel="icon" type="image/png" href="{!! url('public/assets/img/favicon.png') !!}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        Day 2 Day
    </title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- CSS Files -->
    <link href="{!! url('public/assets/css/material-dashboard.css?v=2.1.2') !!}" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="{!! url('public/assets/demo/demo.css') !!}" rel="stylesheet" />
    <link type="text/css" rel="stylesheet" href="{{asset('public/assets/dist/image-uploader.min.css')}}">
    <script src="https://cdn.ckeditor.com/4.19.0/standard/ckeditor.js"></script>
</head>


@auth
    <body class="">
    <div class="wrapper ">
        <div class="main-panel">
            @include('layouts.partials.messages')
            <!-- Sidebar -->
            @include('layouts.partials.sidebar', ['activePage' => $activePage, 'activeSub' => $activeSub])
            <!-- End Sidebar -->
            <!-- Navbar -->
            @include('layouts.partials.navbar', ['titlePage' => $titlePage])
            <!-- End Navbar -->
            <!-- Content -->
            <div class="content">
                <div class="content">
                    @yield('content')
                </div>
            </div>
            <!-- End Content -->
            <!-- Footer -->
            @include('layouts.partials.footer')
            <!-- End Footer -->
        </div>
    </div>
    @include('layouts.partials.app-js')

    @yield('scripts')
    </body>
    @endauth

    @guest
        <body class="off-canvas-sidebar">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top text-white">
            <div class="container">
                <div class="navbar-wrapper">
                    <img src="{!! url('public/assets/img/logo.png') !!}" alt="logo"  height="80">
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
        <div class="wrapper wrapper-full-page">
            <div class="page-header login-page header-filter" filter-color="black"
                 style="background-image: url('{!! url('public/assets/img/login.jpg') !!}'); background-size: cover; background-position: top center;">
                <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
                @yield('content')

                @include('layouts.partials.footer')
            </div>
        </div>
        @include('layouts.partials.auth-js')

        </body>
        @endguest

</html>
