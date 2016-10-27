<!DOCTYPE html>
<html lang="en"  ng-app="myApp" >
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="<?php print url('/'); ?>/public/css/app.css" rel="stylesheet">
    <link href="<?php print url('/'); ?>/public/css/custom_style.css" rel="stylesheet">

    <script src="<?php print url('/'); ?>/public/js/src/1.5.8-angular.min.js"></script> 


    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button> 

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a>
                    <a class="navbar-brand dropdown" href="{{ url('/user/contact') }}">Contacts</a>      

                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ url('/login') }}">Login</a></li>
                            <li><a href="{{ url('/register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav> 
        @yield('content')
    </div> 

    <!-- Scripts src -->
        <script src="<?php print url('/'); ?>/public/js/src/jquery-3.1.1.min.js"></script>
        <script src="<?php print url('/'); ?>/public/js/src/3.3.7-bootstrap.min.js"></script>

        <script src="<?php print url('/'); ?>/public/js/src/1.4.8-angular-route.js"></script>
        <script src="<?php print url('/'); ?>/public/js/src/jquery-ui.min.js"></script>
     <!-- Scripts custom --> 
        <script src="<?php print url('/'); ?>/public/js/custom_jquery.js"></script>
        <script src="<?php print url('/'); ?>/public/js/custom_angular_js.js"></script>
        <script src="<?php print url('/'); ?>/public/js/custom_js.js"></script> 
</body>
</html>
