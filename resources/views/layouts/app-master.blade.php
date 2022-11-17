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
    


    <style>
        label.col-sm-2.col-form-label {
    text-align: left !important;
    padding-left: 103px !important;
}

.col-sm-10 {
    border: 1px solid #b9b9b9;
    margin-bottom: 11px;
}

label.col-form-label {
    padding: 10px 5px 11px 0 !important;
}


.row {
    margin-bottom: 20px;
}

label.col-sm-2.col-form-label {
    text-align: left !IMPORTANT;
}label.col-sm-2.col-form-label {
    text-align: left !important;
    padding-left: 103px !important;
}

.card-body .col-sm-10 {
    border: 1px solid #b9b9b9;
    margin-bottom: 11px;
}

label.col-form-label {
    padding: 10px 5px 11px 0 !important;
}


.card-body .row {
    margin-bottom: 20px;
}

label.col-sm-2.col-form-label {
    text-align: left !IMPORTANT;
}


.table-sales {
    margin-top: auto !important;
}

.text-xs-right {
    width: 57% !important;
    display: flex !important;
    justify-content: center !important;
}

a.btn.btn-danger.col-md-3.ml-auto {
    margin: auto;
}

a.btn.btn-primary.col-md-3.ml-auto {
    margin: auto;
}

.controls {
    display: flex !important;
    padding: 0 15px;
}

span.input-group-text {
    padding: 0 15px 0 15px;
}

.text-xs-right {
    justify-content: flex-start !important;
    padding: 0 15px;
}


.col-md-8.col-lg-10.offset-1 h5 {
    padding: 0 15px;
}

.form-group .text-xs-right {
    justify-content: center !important;
}

.dark-mode {
background-color: #191919;
}

.country-bg{
    background-color: #2a2929 !important;
}

.card-bg{
 background-color: #343434;
    color: white;
}

.card-h4 {
  color: white !important;
}

.chart-bg{
    background-color: #4d4c4c;
}


</style>





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
                    <button onclick="darkMode()">Toggle dark mode</button>
                    
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
