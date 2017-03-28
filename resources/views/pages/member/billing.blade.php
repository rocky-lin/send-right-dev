@extends('layouts.app') 
@section('content')  
<link rel="stylesheet" type="text/css" href="{{url('/public/css/billing.css')}}" />
<div class="container">
    <div class="container">
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
                        <th>Product Name</th>
                        <th>Marchant Order Number</th>
                        <th>Amount</th>
                        <th>Date Created</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Product Name</th>
                        <th>Marchant Order Number</th>
                        <th>Amount</th>
                        <th>Date Created</th>
                        <th>Status</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($payshortcut_member_orders as $order)
                        <tr>
                            <td>{{$order['title']}}</td>
                            <td>{{$order['merchant_order_no']}}</td>
                            <td>${{number_format($order['amt'])}}</td>
                            <td>{{$order['created_at']}}</td>
                            <td>{{$order['status']}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> 
@endsection