@extends('layouts.app') 
@section('content')
    <div ng-controller="myBillingCtr">
        <link rel="stylesheet" type="text/css" href="{{url('/public/css/billing.css')}}" />
        <br><br>
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#home">Subscription</a></li>
            <li><a data-toggle="tab" href="#menu1">Invoice</a></li>
        </ul>
        <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
                <div class="panel panel-default">
                    <div class="panel-heading" style="text-align: left;">billing</div>
                    <div class="panel-body">
                        @include('pages/include/member/billing');
                    </div>
                </div>
            </div>
            <div id="menu1" class="tab-pane fade">
                <br><br><br>
                <table id="billing-invoice" class="display" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th style="display:none" >id</th>
                        <th>Product Name</th>
                        <th>Order Number</th>
                        <th>Amount</th>
                        <th>Date Paid</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th style="display:none" >id</th>
                        <th>Product Name</th>
                        <th>Order Number</th>
                        <th>Amount</th>
                        <th>Date Paid</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @if(!empty($payshortcut_member_orders))
                        @foreach($payshortcut_member_orders as $order)
                            @if($order['title'] == 'Sendright Lite Plan')
                                <tr>
                                    <td style="display:none" >{{$order['id']}}</td>
                                    <td>{{$order['title']}}</td>
                                    <td>{{$order['merchant_order_no']}}</td>
                                    <td>${{number_format($order['amt'])}}</td>
                                    <td>{{human_readable_date_time($order['created_at'])}}</td>
                                    <td>
                                        <button class="btn btn-success">{{$order['status']}}</button>
                                    </td>
                                    <td><a href="{{route('user.billing.invoice', $order['id'])}}" class="btn btn-info">View </a></td>
                                </tr>
                            @endif
                        @endforeach
                    @endif
                    </tbody>
                </table>
                <hr>
                   @if($deactivateButton  == 'deactivated') 
                        <span style="color:red">
                            <br> Account currently deactivated, please click <a href="{{$sendRightProductLink}}" class="btn btn-success btn-sm">  here </a> to reactivate and subscribe sendright again. 
                        </span>
                    @else  

                            @if(App\Account::isSubscribedAndValid() == true)
                                <h4>Next billing </h4>  
                                <b>{!! $nextPaymentDate !!}</b>  
                                @if(strpos($nextPaymentDate, "free version")  <= 0)  
                                {!!  $deactivateButton !!}  
                                @endif
                            @else   
                                <span style="color:red">Trial has expired please click <a href="{{$sendRightProductLink}}" class="btn btn-success btn-sm">  here </a> to subscribe sendright</span>
                            @endif
                      {{--   @else 
                            <h4>Next billing </h4>  
                            <b>{!! $nextPaymentDate !!}</b> 
                            @if(strpos($nextPaymentDate, "free version")  <= 0)  
                                {!!  $deactivateButton !!}  
                            @endif 
                        @endif  --}}
                    @endif

            </div>
        </div>
    </div>
@endsection