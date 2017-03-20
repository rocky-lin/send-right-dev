@extends('layouts.app')
@section('content')

    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12 contact-profile-header-div-left"  >
                    <div class="media">
                        <div class="media-left media-middle">
                            <a href="#">

                                <img class="img-circle contact-profile-pic-sm"
                                     src="https://www.w3schools.com/bootstrap/img_avatar1.png"/>


                            </a>
                        </div>
                        <div class="media-body"><br/>
                            <a href="{{url('user/contact/' . $contact->id . '/edit')}}">
                                <i class="material-icons contact-message-icon pull-right">message</i>
                            </a> 
                            <h4 class="media-heading">{{$contact->first_name . '' . $contact->last_name}}</h4>
                            <span class="contact-profile-user-email">{{$contact->email}}</span>
                        </div>
                    </div>
                </div>
                <div class="row contact-profile-content-left">
                    <div class="col-md-12 ">
                        <div class="row">
                            <div class="col-md-12  ">
                                <div class="row">
                                    <div class="col-md-6" >
                                        <div class="panel panel-info">
                                            <div class="panel-heading">List</div>
                                            <div class="panel-body">
                                                <ul class="list-group">
                                                    <li class="list-group-item"><i class="material-icons contact-list-checked contact-list-icon">check_circle</i>
                                                        Cras justo odio
                                                    </li>
                                                    <li class="list-group-item "><i class="material-icons contact-list-icon">check_circle</i>Dapibus
                                                        ac facilisis in
                                                    </li>
                                                    <li class="list-group-item"><i class="material-icons contact-list-icon">check_circle</i>Morbi
                                                        leo risus
                                                    </li>
                                                    <li class="list-group-item"><i class="material-icons contact-list-icon">check_circle</i>Porta
                                                        ac consectetur ac
                                                    </li>
                                                    <li class="list-group-item"><i class="material-icons contact-list-icon">check_circle</i>Vestibulum
                                                        at eros
                                                    </li>
                                                </ul>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">

                                        <div class="panel panel-info">
                                            <div class="panel-heading"><h5>Note</h5> </div>
                                            <div class="panel-body">
                                                <textarea class="contact-profile-note"></textarea>
                                                <input type="button" class="btn btn-default pull-right contact-add-note-btn" value="add"/>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <hr>
                                        <div class="panel panel-info">
                                            <div class="panel-heading"><h5>Tags</h5></div>
                                            <div class="panel-body"><input type="text" class="form-control"/></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <hr>
                                        <div class="panel panel-info">
                                            <div class="panel-heading"> <h5>Work Flow</h5></div>
                                            <div class="panel-body"> </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 ">
            <div class="row">
                <div class="col-md-12 contact-profile-header-div-right ">
                    <br/>
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#home">Activities</a></li>
                        <li><a data-toggle="tab" href="#menu1">Notes</a></li>
                        <li><a data-toggle="tab" href="#menu2">Site & Event Tracking 2</a></li>
                        <li class="pull-right" ><a data-toggle="tab" href="#menu3" >Filter</a></li>
                    </ul>

                </div>
                <div class="col-md-12  contact-profile-content-right"  >
                    <div class="tab-content">
                        <div id="home" class="tab-pane fade in active">
                            <div class="activity-feed">  
                                <h1> Activities </h1> <br> 
                                @if(false) 
                                    <div class="feed-item">
                                        <div class="date">Sep 25</div>
                                        <div class="text">Responded to need <a href="single-need.php">“Volunteer opportunity”</a>
                                        </div>
                                    </div> 
                                    <div class="feed-item">
                                        <div class="date">Sep 25</div>
                                        <div class="text">Responded to need <a href="single-need.php">“Volunteer opportunity”</a>
                                        </div>
                                    </div>
                                    <div class="feed-item">
                                        <div class="date">Sep 25</div>
                                        <div class="text">Responded to need <a href="single-need.php">“Volunteer opportunity”</a>
                                        </div>
                                    </div>
                                    <div class="feed-item">
                                        <div class="date">Sep 25</div>
                                        <div class="text">Responded to need <a href="single-need.php">“Volunteer opportunity”</a>
                                        </div>
                                    </div>
                                    <div class="feed-item">
                                        <div class="date">Sep 25</div>
                                        <div class="text">Responded to need <a href="single-need.php">“Volunteer opportunity”</a>
                                        </div>
                                    </div>
                                    <div class="feed-item">
                                        <div class="date">Sep 25</div>
                                        <div class="text">Responded to need <a href="single-need.php">“Volunteer opportunity”</a>
                                        </div>
                                    </div>
                                    <div class="feed-item">
                                        <div class="date">Sep 25</div>
                                        <div class="text">Responded to need <a href="single-need.php">“Volunteer opportunity”</a>
                                        </div>
                                    </div>
                                    <div class="feed-item">
                                        <div class="date">Sep 25</div>
                                        <div class="text">Responded to need <a href="single-need.php">“Volunteer opportunity”</a>
                                        </div>
                                    </div>
                                    <div class="feed-item">
                                        <div class="date">Sep 25</div>
                                        <div class="text">Responded to need <a href="single-need.php">“Volunteer opportunity”</a>
                                        </div>
                                    </div>
                                    <div class="feed-item">
                                        <div class="date">Sep 25</div>
                                        <div class="text">Responded to need <a href="single-need.php">“Volunteer opportunity”</a>
                                        </div>
                                    </div>
                                @else  
                                    <div  class="alert alert-default">No contact activities yet.</div>  
                                @endif 
                            </div>
                        </div>
                        <div id="menu1" class="tab-pane fade"> 

                            <h3>Notes</h3> <br>

                            @if(false)                             
                                <ul class="list-group">
                                  <li class="list-group-item">New </li>
                                  <li class="list-group-item">Deleted </li> 
                                  <li class="list-group-item">Warnings </li> 
                                </ul>                              
                            @else 
                                <div  class="alert alert-default">No note yet.</div> 
                            @endif 

                        </div>
                        <div id="menu2" class="tab-pane fade">
                            <h3>Site & Event Tracking 2</h3> 
                            <br> 
                            <div  class="alert alert-default">No Site & event tracking yet.</div> 
                        </div>
                        <div id="menu3" class="tab-pane fade">
                            <h3>Filter</h3> 
                            <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection