@extends('layouts.app')

@section('content')
<div class="container">
  
    <div class="row">
        <div class="">
            @if(Auth::user()->status == 'inactive') 
                    <div class="alert alert-danger"  > {{  "your account is currently in active, please visit your email and hit comfirm, thank you!" }} </div>
                @endif
            <div class="panel panel-default"> 
                <div class="panel-heading">Dashboard</div>   
                <div class="panel-body"> 

                {{ "Current user account " . App\User::getUserAccount()  }}  
                            {{-- {{ "you current account is " . App\User::find(Auth::user()->id)->user_account->account->id }} --}}
                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
