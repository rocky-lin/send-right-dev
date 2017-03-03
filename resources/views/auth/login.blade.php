@extends('layouts.app')

@section('content')
    <style>
        .footer, .navbar-default {
            display:none !important;
        }
        .other-text-login {
            text-align: center;
        }

        .login-rightside img {
            width:100%;
        }

        .login-leftside {
            padding:39px !important
        }

        .container-full {
            padding:0px;
            width:100%;
        }
        body {
            overflow-x: hidden;
        }


    </style>


    <div class="row">
        <div class="col-md-4 login-leftside "  >

                    <br><br><Br>


                    <center><h3>Login</h3>


                    <b>Need a SendRight account?</b> <a href="{{url('/register')}}"> Create an account </a>
                    </center>

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }} 
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-md-12"> <label class="label label-default" >E-Mail Address</label> </div>
                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="col-md-12"> <label class="label label-default" >Password</label> </div>

                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group other-text-login">
                            <div class="col-md-12">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group other-text-login">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>

                                <a class="btn btn-link" href="{{ url('/password/reset') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>
                    </form>

                    @include("pages/include/footer/simple-footer")

        </div>
         <div class="col-md-8 login-rightside" >
                
                <img  src="{{ url('public/img/others/Why-SMS-Marketing-Makes-Sense-for-Both-Large-and-Small-Businesses.jpg')  }}" />
          </div>
    </div>
@endsection

