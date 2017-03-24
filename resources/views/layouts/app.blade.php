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
    <link type="text/css" rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"/>
    <link href="<?php print url('/'); ?>/public/css/contact-profile.css" rel="stylesheet">
    <link href="<?php print url('/'); ?>/public/css/custom_style.css" rel="stylesheet">
    <link href="<?php print url('/'); ?>/public/css/refine_style.css" rel="stylesheet">
    <link href="<?php print url('/'); ?>/public/css/sticky-footer.css" rel="stylesheet">

     {{-- @src: http://www.codeply.com/go/ecE6qHNBOC  --}}
    <link href="<?php print url('/'); ?>/public/css/other-pages-style.css" rel="stylesheet">  

 
    <script src="<?php print url('/'); ?>/public/js/src/1.5.8-angular.min.js"></script>   
    <script src="<?php print url('/'); ?>/public/js/src/ui-bootstrap-tpls-2.2.0.min.js"></script> 
    
    {{-- https://fonts.google.com/specimen/PT+Sans?selection.family=PT+Sans --}}
    <link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet">

    {{-- https://material.io/icons/ --}}
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">



    <link href="<?php print url('/'); ?>/public/css/bootstrap-combined.min.css" rel="stylesheet">


    {{--angular pagination--}}
    {{--<link data-require="bootstrap-css@2.3.2" data-semver="2.3.2" rel="stylesheet" href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" />--}}
    {{--<script data-require="angular.js@1.1.5" data-semver="1.1.5" src="http://code.angularjs.org/1.1.5/angular.min.js"></script>--}}
    <script data-require="angular-ui-bootstrap@0.3.0" data-semver="0.3.0" src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.3.0.min.js"></script>


    {{-- Theme Style  --}}
 
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
<body data-ng-init="document" >
     <input type="hidden" value="{{url('/')}}" id="url_home" />
    <div id="app" >
        <nav class="navbar-default navbar-static-top">
            <div class="container-full">

                <div class="navbar-header"> 
                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>  
                    <!-- Branding Image --> 
                    <a class="navbar-brand" href="{{ url('/home') }}"><img src="{{ url('public/img/logo/re design combin-4 color.png') }}" /></a>
    
             
                @if (!Auth::guest())
                    <ul class="nav navbar-nav navbar-right"> 
                       <li> <a href="{{ url('/user/contact') }}">Contacts</a>      </li> 
                       <li> <a href="{{ url('/user/list') }}">List</a>      </li> 
                       <li> <a href="{{ url('/user/form') }}">Form</a>       </li> 
                       <li> <a href="{{ route('user.campaign.campaign.view') }}">Campaigns</a>       </li> 

                        


                            <li class="dropdown hide">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    Campaign  <span class="caret"></span>
                                </a> 
                                <ul class="dropdown-menu" role="menu">
                                    <li><a  href="{{ route('user.campaign.newsletter.view') }}">Newsletter</a></li>
                                    <li><a  href="{{ route('user.campaign.autoresponders.view') }}">Auto Responder</a></li> 
                                    @if($addOns['is_has_email_mobile_opt_in'])
                                        <li> <a href="{{ route('user.campaign.mobileoptin.view') }}">Mobile Optin</a></li>
                                    @else
                                        <li>
                                            <a href="#" data-toggle="modal" data-target="#popUpModal" > <span style="color:#b7b7b7"> Mobile Optin </span>  </a>
                                        </li>
                                    @endif 
                                    
                                    @if($userRole == 'supper administrator')
                                        <li><a  href="{{ url('extension/campaign/index.php?type=template') }}">Create template</a></li>
                                    @endif
                                </ul>
                            </li>
                        </ul> 
                    @endif  
                </div> 
                <div class="  navbar-collapse" id="app-navbar-collapse">
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
                                    <i class="material-icons">mood</i>    
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
                            <li><a href="#" data-toggle="modal" data-target="#helpGlobal" ><span>Help</span></a></li>
                            <li>
                                <a href="#" data-toggle="modal" data-target="#searchGlobal" ><i class="material-icons">search</i></a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>



        <div class='container-full'>
            {!! Support\Popup::globalSearchPopup()!!}
            {!! Support\Popup::globalHelpPopup()!!}
            {{-- @include('pages/include/subscription/subscription-status-message') --}}
            @yield('content')
            @include('pages/popup/popup')

        </div>
    </div>

     <div style="clear:both"></div>
     <footer class="footer" style=" float:left;">
         <div class="container">
             <p class="text-muted">
             <p>©2016-2017 All Rights Reserved. Sendright is a registered trademark of The Rocket Science Group. <a href="/legal/privacy">Privacy</a> and <a href="/legal">Terms</a></p>
             </p>
         </div>
     </footer>

    






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
        <script src="<?php print url('/'); ?>/public/js/refine_jquery.js"></script>


    {{--Data tables--}}
    <script src="//code.jquery.com/jquery-1.12.4.js" ></script>
    <script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js" ></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css" />

    <script>
        $.noConflict();
        jQuery( document ).ready(function( $ ) {



            // Setup - add a text input to each footer cell
            $('#contacts thead th').each( function () {
                var title = $(this).text();
                $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
            } );
            //            $('#contacts tfoot th').each( function () {
            //                var title = $(this).text();
            //                $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
            //            } );
            // DataTable
            var table = $('#contacts').DataTable();

            // Apply the search
            table.columns().every( function () {
                var that = this;

                $( 'input', this.footer() ).on( 'keyup change', function () {
                    if ( that.search() !== this.value ) {
                        that
                                .search( this.value )
                                .draw();
                    }
                } );
            } );


        });

        //        $.noConflict();
        //        jQuery( document ).ready(function( $ ) {
        //            // Code that uses jQuery's $ can follow here.
        //
        //            $('#contacts').DataTable();
        //        });

    </script>

</body>
</html>
