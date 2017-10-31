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
        @yield('meta')

        <title>برنامج ادارة مكاتب المحاماة -  @yield('title')</title>

        <!-- font awesome -->
        <link rel="stylesheet" href="{{ URL::asset('css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('css/bootstrap_rtl.css') }}">

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
        
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script src="{{ URL::asset('js/ie10-viewport-bug-workaround.js') }}"></script>

        <!-- webpack vendor packages -->
        <script src="{{ URL::asset('js/manifest.js') }}"></script>
        <script src="{{ URL::asset('js/vendor.js') }}"></script>

@yield('js')


<div id="footer_container">
    @yield('footer')
    <footer class="footer print-hidden">
      <b>&copy; Copyright 2017 by <a href="#aboutModal" data-toggle="modal" data-target="#aboutDeveloperModal">Bahaa Alhagar</a>.</b>

      <!-- about developer modal -->
      <div class="modal fade" id="aboutDeveloperModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title" id="myModalLabel">عن المبرمج</h4>
                    </div>
                <div class="modal-body">
                    <center>
                    <img src="{{ Storage::url('pic.jpg') }}" name="aboutme" width="140" height="140" border="0" class="rounded-circle"></a>
                    <h3 class="media-heading"><b>Bahaa Alhagar</b></h3>
                    <span class="social-icons">
                    <a href="https://github.com/BahaaAlhagar" target="_blank">
                        <li class="fa fa-github-alt git"></li>
                    </a>
                    <a href="https://twitter.com/bahaa_alhagar" target="_blank">
                      <li class="twitter fa fa-twitter"></li>
                    </a>
                    <a href="https://www.facebook.com/BahaaAlhagar14" target="_blank">
                      <li class="facebook fa fa-facebook"></li>
                    </a>
                    </span>
                      
                    </center>
                    <hr>
                    <center>
                    <p id="biography" class="text-right"><strong>السيرة الذاتية: </strong><br>
                        بهاء الحجر, من مصر, مطور تطبيقات ويب.<br>
                        مهتم بتطوير مواقع الانترنت و كل ما يخص الحاسوب.
                        </p>
                    </center>
                </div>
                <div class="modal-footer text-right">
                    <center>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">اغلاق</button>
                    </center>
                </div>
            </div>
        </div>
    </div>
    </footer>
</div>
</div>
    </body>
</html>