<!DOCTYPE html>
<html lang="en"  ng-app="myApp">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles --> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">  
    <link href="<?php print url('/'); ?>/public/css/custom_style.css" rel="stylesheet"> 
    <script src="<?php print url('/'); ?>/public/js/src/1.5.8-angular.min.js"></script>   
    <script src="<?php print url('/'); ?>/public/js/src/ui-bootstrap-tpls-2.2.0.min.js"></script> 
 
    <script>
      angular.module("myApp").constant("CSRF_TOKEN", '{{ csrf_token() }}');
    </script>
 
    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body data-ng-init="document"   > 
     <input type="hidden" value="{{url('/')}}" id="url_home" />   
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
                    <a class="navbar-brand" href="{{ url('/home') }}">{{ config('app.name', 'Laravel') }}</a> 
                    @if (!Auth::guest())    
                    <ul class="nav navbar-nav navbar-right"> 
                       <li> <a href="{{ url('/user/contact') }}">Contacts</a>      </li> 
                       <li> <a href="{{ url('/user/list') }}">List</a>      </li> 
                       <li> <a href="{{ url('/user/form') }}">Form</a>       </li>
                       
                        
 

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    Campaign  <span class="caret"></span>
                                </a> 
                                <ul class="dropdown-menu" role="menu">
                                    <li><a  href="{{ route('user.campaign.newsletter.view') }}">Newsletter</a></li>
                                    <li><a  href="{{ route('user.campaign.autoresponders.view') }}">Auto Responder</a></li>
                                    <li> <a href="{{ route('user.campaign.mobileoptin.view') }}">Mobile Optin</a></li> 
                                </ul>
                            </li>
                        </ul>



                    @endif  
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
                                        <a href="{{route('user.profile')}}" title="">Profile</a>
                                    </li>

                                    <li> 
                                        <a href="{{route('user.account')}}" title="">Account</a>
                                    </li> 
                                    <li> 
                                        <a href="{{route('user.billing')}}" title="">Billing</a>
                                    </li>  
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
        <div class='container'>
            @include('pages/include/subscription/subscription-status-message')
            @yield('content')  
        </div>
    </div> 



    






        {{--   <footer class="footer">
            <div class="container">
                <br>
                <p class="text-muted"> Copy right @ Send Right </p>
            </div>
        </footer> --}}

    <!-- Scripts src -->
        <script src="<?php print url('/'); ?>/public/js/src/jquery-3.1.1.min.js"></script>
        <script src="<?php print url('/'); ?>/public/js/src/3.3.7-bootstrap.min.js"></script> 
        <script src="<?php print url('/'); ?>/public/js/src/1.4.8-angular-route.js"></script>
        <script src="<?php print url('/'); ?>/public/js/src/jquery-ui.min.js"></script>


 
    {{-- Individual Auto suggest needs--}} 
    <link rel="stylesheet" href="//cdn.jsdelivr.net/fontawesome/4.5.0/css/font-awesome.css">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="//mgcrea.github.io/angular-strap/styles/libs.min.css">  
    <script src="//cdn.jsdelivr.net/angularjs/1.5.5/angular.min.js" data-semver="1.5.5"></script>
    <script src="//cdn.jsdelivr.net/angularjs/1.5.5/angular-animate.min.js" data-semver="1.5.5"></script>
    <script src="//cdn.jsdelivr.net/angularjs/1.5.5/angular-sanitize.min.js" data-semver="1.5.5"></script>
    <script src="//mgcrea.github.io/angular-strap/dist/angular-strap.js" data-semver="v2.3.8"></script>
    <script src="//mgcrea.github.io/angular-strap/dist/angular-strap.tpl.js" data-semver="v2.3.8"></script>
    <script src="//mgcrea.github.io/angular-strap/docs/angular-strap.docs.tpl.js" data-semver="v2.3.8"></script> 

    {{--  
        Date picker 
        Current used: campaign-settings.blade.php
    --}}  

 
    <link rel="stylesheet" href="<?php print url('/'); ?>/public/css/src/2.2.3-dist-flatpickr.min.css" /> 
    <script src="<?php print url('/'); ?>/public/js/src/flatpickr"></script> 



     <!-- Scripts custom --> 
        <script src="<?php print url('/'); ?>/public/js/custom_jquery.js"></script>
        <script src="<?php print url('/'); ?>/public/js/custom_angular_js.js"></script>
        <script src="<?php print url('/'); ?>/public/js/custom_js.js"></script>  
        <script src="<?php print url('/'); ?>/public/js/custom_jquery_ui.js"></script> 
 

</body>
</html>
