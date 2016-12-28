
  Profile Completed!
  <div class="progress">
      <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:50%">
        50% Complete (info)
      </div>
    </div>

<br><br><br>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-0 col-sm-offset-0">
    
          <div class="panel ">
            
            <div class="panel-body">
              <div class="row">
                <div class="col-md-3 col-lg-3 " align="center"> <img alt="User Pic" src="http://babyinfoforyou.com/wp-content/uploads/2014/10/avatar-300x300.png" class="img-circle img-responsive"> </div> 
                <div class=" col-md-9 col-lg-9 "> 
                  <table class="table table-user-information">
                    <tbody>
                    <tr>
                      <th style="width:20%">
                        Full Name:
                      </th>
                      <td>  {{ $userInfo['full_name'] or  'Not yet suplied' }} </td>
                    </tr>

                    <tr>
                      <th style="width:20%">
                        Email:
                      </th>
                      <td>  {{ $userInfo['email'] or  'Not yet suplied' }} </td>
                    </tr>

                    <tr>
                      <th style="width:20%">
                        Company:
                      </th>
                      <td>  {{ $userInfo['company'] or  'Not yet suplied' }} </td>
                    </tr>


                    <tr>
                      <th style="width:20%">
                        Time Zone:
                      </th>
                      <td>  {{ $userInfo['time_zone'] or  'Not yet suplied' }} </td>
                    </tr>

                    <tr>
                      <th style="width:20%">
                        Username:
                      </th>
                      <td>  {{ $userInfo['user_name'] or  'Not yet suplied'   }} </td>
                    </tr>
                    <tr>
                      <th style="width:20%">
                        Subscription plan billed:
                      </th>
                      <td>  {{ $userInfo['subscription_name'] . ' remaining days till next bill cycle ' . $subscriptionRemainingDaysBilled . ' days'  }}  </td>
                    </tr>
                 <tr>
                      <th style="width:20%">
                        Subscription plan free:
                      </th>
                      <td>  {{ $userInfo['subscription_name'] . ' your free subscription will expire in ' . $subscriptionRemainingDaysTrial . ' days'  }}  </td>
                    </tr>

                    </tbody>
                  </table>

                  <a href="{{url('user/account')}}" class="btn btn-primary">Edit Account</a>
                </div>
              </div>
            </div>
          </div>
        </div>
