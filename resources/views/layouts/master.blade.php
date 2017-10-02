<?php
?>
<!doctype html>
	<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!-- IE compapility -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- first mobile meta -->
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


        <title>برنامج ادارة مكاتب المحاماة -  @yield('title')</title>

        <!-- font awesome -->
        <link rel="stylesheet" href="{{ URL::asset('css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('css/bootstrap_rtl.css') }}">

        <!-- date-time-picker -->
        <link rel="stylesheet" href="{{ URL::asset('css/bootstrap-datepicker3.min.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('css/bootstrap-datepicker3.min.css.map') }}">

        <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">

        @yield('css')


    </head>

    <!-- body starts here -->
    <body>
<div class="container-fluid">
@include('layouts.nav')

<div class="container">
@yield('content')



</div>



        <!--[if lt IE 9]>
        <script src="{{ URL::asset('js/html5shiv.min.js') }}"></script>
        <![endif]-->
        
        <script src="{{ URL::asset('js/respond-1.4.2.min.js') }}"></script>

        <!-- jquery & bootstrap requirements -->
        <script src="{{ URL::asset('js/jquery-3.2.1.slim.min.js') }}"></script>
        <script src="{{ URL::asset('js/popper.min.js') }}"></script>
        <script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
        
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script src="{{ URL::asset('js/ie10-viewport-bug-workaround.js') }}"></script>

        <!-- date-time-picker -->
        <script src="{{ URL::asset('js/bootstrap-datepicker.min.js') }}"></script>
        <!-- Arabic support for datepicker -->
        <script src="{{ URL::asset('locales/bootstrap-datepicker.ar.min.js') }}"></script>


@yield('js')

<footer class="footer print-hidden">
@yield('footer')
  <b>&copy; Copyright 2017 by <a href="https://github.com/BahaaAlhagar" target="_blank">Bahaa Alhagar</a>.</b>

</footer>
</div>
    </body>
</html>