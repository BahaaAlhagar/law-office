<?php
?>
<!doctype html>
	<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!-- IE compapility -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- first mobile meta -->
    	<meta name="viewport" content="width=device-width, initial-scale=1">


        <title>برنامج ادارة مكاتب المحاماة -  @yield('title')</title>

        <!-- date-time-picker -->
        <link rel="stylesheet" href="{{ URL::asset('css/bootstrap-datepicker3.min.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('css/bootstrap-datepicker3.min.css.map') }}">
        <!-- font awesome -->
        <link rel="stylesheet" href="{{ URL::asset('css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('css/bootstrap_rtl.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">

        @yield('css')
        </script>

    
        

    </head>

    <!-- body starts here -->
    <body>

@include('layouts.nav')

<div class="container">
@yield('content')



</div>



<!-- IE 9 -->
        <script src="{{ URL::asset('js/html5shiv.min.js') }}"></script>
        <script src="{{ URL::asset('js/respond-1.4.2.min.js') }}"></script>


        <!-- jquery -->
        <script src="{{ URL::asset('js/jquery-1.11.2.min.js') }}"></script>
        <script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
        <!-- date-time-picker -->
        <script src="{{ URL::asset('js/bootstrap-datepicker.min.js') }}"></script>
        <!-- Arabic support for datepicker -->
        <script src="{{ URL::asset('locales/bootstrap-datepicker.ar.min.js') }}">


@yield('js')

<footer class="footer">
@yield('footer')
  <b>&copy; Copyright 2017 by <a href="https://github.com/BahaaAlhagar" target="_blank">Bahaa Alhagar</a>.</b>

</footer>

    </body>
</html>