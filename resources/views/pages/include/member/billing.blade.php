<div class="container">
    <div class="row">
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
                    {{Form::open(['url'=>route('user.billing.confirm'), 'method'=>'post'])}}
                        <input type="hidden" name="name" value="{{$bronze['product']->name}}" />
                        <button type="submit"  class="btn btn-info" > Upgrade </button>  1 month FREE trial</div>
                    {{Form::close()}}
                @endif
            </div>
        </div>
        <div class="col-xs-12 col-md-3">
            <div class="panel panel-success">
                <div class="cnrflash">
                    <div class="cnrflash-inner">
                        <span class="cnrflash-label">MOST
                            <br>
                            POPULR</span>
                    </div>
                </div>
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Silver</h3>
                </div>
                <div class="panel-body">
                    <div class="the-price">
                        <h1>
                            $20<span class="subscript">/mo</span></h1>
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
