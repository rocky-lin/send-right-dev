@extends('layouts.app')
@section('content')
    <br><br><br>
    Title : {{$orderDetail['title']}} <br>
    Order Id : {{$orderDetail['merchant_order_no']}} <br>
    Amount : {{$orderDetail['amt']}} <br>
    Paid at : {{human_readable_date_time($orderDetail['created_at'])}} <br>
@endsection