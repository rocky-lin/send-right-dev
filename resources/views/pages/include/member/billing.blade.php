<div class="container">
    <div class="row">

            {{--<div class="col-xs-12 col-md-3" >--}}
                {{--<div class="card" style="width: 20rem;">--}}
                    {{--<img class="card-img-top" data-src="holder.js/100px180/" alt="100%x180" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22318%22%20height%3D%22180%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20318%20180%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_15b194623c9%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A16pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_15b194623c9%22%3E%3Crect%20width%3D%22318%22%20height%3D%22180%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22118.015625%22%20y%3D%2297.2%22%3E318x180%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true" style="height: 180px; width: 100%; display: block;">--}}
                    {{--<div class="card-block">--}}
                        {{--<h4 class="card-title">Card title</h4>--}}
                        {{--<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>--}}
                        {{--<a href="#" class="btn btn-primary">Go somewhere</a>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}

        <div class="col-xs-12 col-md-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"  style="color:black">{{ $bronze['product']->name}}</h3>
                </div>
                <div class="panel-body">
                    <div class="the-price">
                        <h1>
                            {{ $bronze['product']->price}}<span class="subscript">/mo</span></h1>
                        <small>1 month FREE trial</small>
                    </div>
                    <table class="table">
                        @foreach($bronze['product']['details'] as $i => $bd)
                            @if($i%2==0)
                                <tr>
                                    <td>
                                        {{$bd->name}}
                                    </td>
                                </tr>
                            @else
                                <tr class="active">
                                    <td>
                                        {{$bd->name}}
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                </div>
                <div class="panel-footer">
                    @if(App\Account::isSubscribedAndValid('basic') === true)
                            <button type="submit"  class="btn btn-info"  disabled> Selected </button>  1 month FREE trial </div>
                    @else
                        <b style="color:red">Expired subscription!</b>
                        {{Form::open(['url'=>route('user.billing.confirm'), 'method'=>'post'])}}
                            <input type="hidden" name="name" value="{{$bronze['product']->name}}" />
                            <button type="submit"  class="btn btn-info" > Subscribe </button>  1 month FREE trial</div>
                        {{Form::close()}}
                    @endif
                </div>
        </div>
        <div class="col-xs-12 col-md-3">
            <div class="panel panel-success">
                <div class="cnrflash">
                    <div class="cnrflash-inner">
                        <span class="cnrflash-label">MOST
                            <br>POPULR</span>
                    </div>
                </div>
                <div class="panel-heading">
                    <h3 class="panel-title">Silver</h3>
                </div>
                <div class="panel-body">
                    <div class="the-price">
                        <h1>$20<span class="subscript">/mo</span></h1>
                        <small>1 month FREE trial</small>
                    </div>
                    <table class="table">
                        <tr>
                            <td>
                                2 Account
                            </td>
                        </tr>
                        <tr class="active">
                            <td>
                                5 Project
                            </td>
                        </tr>
                        <tr>
                            <td>
                                100K API Access
                            </td>
                        </tr>
                        <tr class="active">
                            <td>
                                200MB Storage
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Custom Cloud Services
                            </td>
                        </tr>
                        <tr class="active">
                            <td>
                                Weekly Reports
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="panel-footer">
                    <button class="btn btn-success" role="button" disabled>Upgrade</button>
                    1 month FREE trial</div>
            </div>
        </div>
        <div class="col-xs-12 col-md-3">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Gold</h3>
                </div>
                <div class="panel-body">
                    <div class="the-price">
                        <h1>
                            $35<span class="subscript">/mo</span></h1>
                        <small>1 month FREE trial</small>
                    </div>
                    <table class="table">
                        <tr>
                            <td>
                                5 Account
                            </td>
                        </tr>
                        <tr class="active">
                            <td>
                                20 Project
                            </td>
                        </tr>
                        <tr>
                            <td>
                                300K API Access
                            </td>
                        </tr>
                        <tr class="active">
                            <td>
                                500MB Storage
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Custom Cloud Services
                            </td>
                        </tr>
                        <tr class="active">
                            <td>
                                Weekly Reports
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="panel-footer">
                    <button class="btn btn-success" role="button" disabled>Upgrade </button> </div>
            </div>
        </div>
    </div>
</div>
