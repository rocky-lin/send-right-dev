@extends('layouts.app')

@section('content')
    <div class="container"> 
        <div class="row"> 
        
            <div class="panel panel-default"> 
                <div class="panel-heading"><b>Subscription Billing Confirmation</b></div>   
                <div class="panel-body">   
                    <div class="row ">  
                        {{Form::open(['url' => route('user.billing.confirm.proceed'), 'method'=>'post' ] )}}  

                             <div class="form-group">  
                                {{Form::label('Email', 'Email', ['class'=>'control-label col-sm-2'])}} 
                                <div class="col-sm-10">         
                                    {{Form::text('Email', Auth::user()->email, ['class'=>'form-control', 'placeholder'=>'Enter Email'] )}} 
                                </div>   
                            </div>

                             <br><br><br>
                             <div class="form-group">  
                                {{Form::label('Product Name', 'Product Name', ['class'=>'control-label col-sm-2'])}} 
                                <div class="col-sm-10">         
                                    {{Form::text('productName', $productInfo->name, ['class'=>'form-control', 'placeholder'=>'Enter Email' , 'disabled'] )}} 
                                </div>   
                            </div>   


                            <br><br><br>
                             <div class="form-group">  
                                {{Form::label('Price', 'Product Price', ['class'=>'control-label col-sm-2'])}} 
                                <div class="col-sm-10">         
                                    {{Form::text('Price', $productInfo->unit  . ' ' .$productInfo->price, ['class'=>'form-control', 'placeholder'=>'Enter Email', 'disabled'] )}} 
                                </div>   
                            </div>


                            <br><br><br>
                            <div class="form-group">  
                                {{Form::label('Order Number', 'Order Number', ['class'=>'control-label col-sm-2'])}} 
                                <div class="col-sm-10">         
                                    {{Form::text('orderNumber', $orderId, ['class'=>'form-control', 'placeholder'=>'Enter Email', 'disabled'] )}} 
                                </div>   
                            </div> 

                         <br><br><br>
                            <div class="form-group">  
                                {{Form::label('', '', ['class'=>'control-label col-sm-2'])}} 
                                <div class="col-sm-10">         
                                    {{Form::submit('Proceed', ['class'=>'btn btn-info', 'placeholder'=>'Enter Email'] )}} 
                                </div>   
                            </div> 
                            {{Form::hidden('name', $productInfo->name, ['class'=>'form-control', 'placeholder'=>'Enter Email'] )}}  
                        {{Form::close()}} 
                    </div>  
                </div>
            </div>  
        </div>
    </div> 
@endsection