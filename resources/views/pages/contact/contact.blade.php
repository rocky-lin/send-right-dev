@extends('layouts.app')
@section('content')
    <div class="wrapper">
        <div class="row row-offcanvas row-offcanvas-left">
            <!-- left content as sidebar -->
            <div class="column col-sm-2 col-xs-1 sidebar-offcanvas left-side-container-opposite " id="sidebar">
                 @include("pages/include/contact/sidebar")
            </div>


            <div class="column col-sm-10 col-xs-11 right-side-container-opposite" id="main">

                <ul class="nav nav-tabs hide">
                    <li role="presentation" class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false"> Stats <span class="caret"></span> </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="#">Overview</a></li>
                            <li><a href="#">Social Profile</a></li>
                        </ul>
                    </li>
                    <li role="presentation" class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false"> Manage Contacts <span class="caret"></span> </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="#">View Contacts</a></li>
                            <li><a href="#">Unsubscribe Addressess</a></li>
                            <li><a href="#">Groups</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#">Segments</a></li>
                            <li><a href="#">Import history</a></li>
                            <li><a href="#">Contact exports</a></li>
                            <li><a href="#">Delete all contacts</a></li>
                        </ul>
                    </li>
                    <li role="presentation" class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false"> Add Contacts <span class="caret"></span> </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="#">Add a subscriber</a></li>
                            <li><a href="#">Import Contacts</a></li>
                        </ul>
                    </li>
                    <li role="presentation" class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false"> Signup forms </a>
                    </li>
                    <li role="presentation" class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false"> Settings <span class="caret"></span> </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="#">List name and defaults</a></li>
                            <li><a href="#">Publicity settings</a></li>
                            <li><a href="#">List fields and *|MERGE|* tags</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#">Required email footer content</a></li>
                            <li><a href="#">Required email footer content</a></li>
                            <li><a href="#">Email Beamer</a></li>
                            <li><a href="#">Google Analytics on archive/list pages</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav nav-tabs contact-sorting-ul hide" style="border-bottom:none; padding:5px;">
                    <li role="presentation" class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false"> Toogle Column <span class="caret"></span> </a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Descending order</a></li>
                            <li><a href="#">Ascending order</a></li>
                        </ul>
                    </li>
                    <li role="presentation" class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false">Export List</a>
                    </li>
                    <li role="presentation" class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false">Action<span class="caret"></span> </a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Descending order</a></li>
                            <li><a href="#">Ascending order</a></li>
                        </ul>
                    </li>
                </ul>





                @include('pages/include/contact/contact-view')

                {{--<br><br><br>--}}
                {{--<ul class="nav nav-tabs contact-sorting-ul" style="border-bottom:none;">--}}
                    {{--<li role="presentation" class="dropdown">--}}
                        {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"--}}
                           {{--aria-expanded="false">Delete</a>--}}
                    {{--</li>--}}
                {{--</ul>--}}
                {{--<hr/>--}}
                {{--<div class="row contact-menu-setting">--}}
                    {{--<div class="col-md-2">--}}
                        {{--<ul class="nav nav-tabs contact-sorting-ul" style="border-bottom:none;">--}}
                            {{--<li role="presentation" class="dropdown">--}}
                                {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"--}}
                                   {{--aria-haspopup="true" aria-expanded="false"> Toogle Column <span class="caret"></span>--}}
                                {{--</a>--}}
                                {{--<ul class="dropdown-menu">--}}
                                    {{--<li><a href="#">Descending order</a></li>--}}
                                    {{--<li><a href="#">Ascending order</a></li>--}}
                                {{--</ul>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                    {{--<div class="col-md-2">--}}
                    {{--</div>--}}
                    {{--<div class="col-md-2">--}}
                        {{--<ul class="nav nav-tabs contact-sorting-ul" style="border-bottom:none;">--}}
                            {{--<li role="presentation" class="dropdown">--}}
                                {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"--}}
                                   {{--aria-haspopup="true" aria-expanded="false">Filter By Tag<span class="caret"></span>--}}
                                {{--</a>--}}
                                {{--<ul class="dropdown-menu">--}}
                                    {{--<li><a href="#">Descending order</a></li>--}}
                                    {{--<li><a href="#">Ascending order</a></li>--}}
                                {{--</ul>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                    {{--<div class="col-md-2">--}}
                        {{--<ul class="nav nav-tabs contact-sorting-ul" style="border-bottom:none;">--}}
                            {{--<li role="presentation" class="dropdown">--}}
                                {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"--}}
                                   {{--aria-haspopup="true" aria-expanded="false">Filter By List<span class="caret"></span>--}}
                                {{--</a>--}}
                                {{--<ul class="dropdown-menu">--}}
                                    {{--<li><a href="#">Descending order</a></li>--}}
                                    {{--<li><a href="#">Ascending order</a></li>--}}
                                {{--</ul>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                    {{--<div class="col-md-2">--}}
                        {{--<ul class="nav nav-tabs contact-sorting-ul" style="border-bottom:none;">--}}
                            {{--<li role="presentation" class="dropdown">--}}
                                {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"--}}
                                   {{--aria-haspopup="true" aria-expanded="false">Filter By Status<span--}}
                                            {{--class="caret"></span> </a>--}}
                                {{--<ul class="dropdown-menu">--}}
                                    {{--<li><a href="#">Descending order</a></li>--}}
                                    {{--<li><a href="#">Ascending order</a></li>--}}
                                {{--</ul>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                    {{--<div class="col-md-2">--}}
                        {{--<div class="input-group">--}}
                            {{--<input type="text" class="form-control  contact-search" placeholder="Search for...">--}}
                        {{--</div><!-- /input-group -->--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<table class="table">--}}
                    {{--<thead>--}}
                    {{--<tr>--}}
                        {{--<th>Firstname</th>--}}
                        {{--<th>Lastname</th>--}}
                        {{--<th>Email</th>--}}
                    {{--</tr>--}}
                    {{--</thead>--}}
                    {{--<tbody>--}}
                    {{--@for($i=0; $i<10; $i++)--}}
                        {{--<tr>--}}
                            {{--<td><input type="checkbox"/> &nbsp;&nbsp;--}}
                                {{--<a href="{{url('user/contact/profile/1')}}">John</a>--}}
                            {{--</td>--}}
                            {{--<td>Doe</td>--}}
                            {{--<td>john@example.com</td>--}}
                        {{--</tr>--}}
                    {{--@endfor--}}
                    {{--</tbody>--}}
                {{--</table>--}}
                {{--<hr>--}}
                {{--<div class="row">--}}
                    {{--<div class="col-md-12">--}}
                        {{--<center>--}}
                            {{--<ul class="pagination">--}}
                                {{--<li><a href="#">1</a></li>--}}
                                {{--<li class="active"><a href="#">2</a></li>--}}
                                {{--<li><a href="#">3</a></li>--}}
                                {{--<li><a href="#">4</a></li>--}}
                                {{--<li><a href="#">5</a></li>--}}
                            {{--</ul>--}}
                        {{--</center>--}}
                    {{--</div>--}}
                {{--</div>--}}
                <hr/>
            </div>
            <!-- /main -->
        </div>
    </div>
@endsection 