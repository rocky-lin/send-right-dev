<div class="row">
<div class="col-sm-12">
    @if(!Auth::guest())
        <center> 

        
                @if($subscription_status == 1) 
                    {{-- <div class="alert alert-info alert-dismissible subscription-status" style="width:103%">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <b> Your subscription is expired!</b>
                    </div> --}}
                @elseif($subscription_status == 2)
                    {{-- <div class="alert alert-info alert-dismissible subscription-status" style="width:103%">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                         <b> You are currently in trial status, please upgrade now!</b>
                    </div> --}}
                @elseif($subscription_status == 4)
                    {{-- <div class="alert alert-info alert-dismissible subscription-status" style="width:103%">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                         <b>Your trial subscription is expired </b>
                    </div> --}}
                @elseif($subscription_status == 3)
                    {{--subscription billed--}}
                @else
                    {{--do nothing--}}
                @endif 
 



                @if(Auth::user()->status == 'inactive')
                  {{--   <div class="alert alert-danger"  style="width:103%" >
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <b>Your account is currently in active, please visit your email and hit comfirm, thank you!</b>
                    </div> --}}
                @endif 


        </center>
    @endif

</div>
</div>

