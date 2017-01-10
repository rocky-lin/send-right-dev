<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Account;
use App\User;
use Auth;
use App\Subscription;
use App\AddOn;
use App;
use App\Language;
 
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Language::setCurrentLanguage();
        // App::setLocale('pl');
        // This need to be change and point only to real page of the site
        view()->composer('*', function ($view) {

            if (Auth::user() ) {



                //                  $addOns = ''; //Account::getAddOns();
                //                print "name" . $addOns[0]['name'];
                //                dd($addOns);
                  $addOns['is_has_email_mobile_opt_in'] = AddOn::isHasMobileOptIn();
//                    if( $addOns['is_has_email_mobile_opt_in']) {
//                    print "has subscribed to mobile optin";
//                    } else {
//                        print "not subscribed to mobile email optin";
//                    }
                  Subscription::updateSubscriptionExpired();
                  //                print"test";
                  //                print "total days remaining for your billed account " . Subscription::getRemainingDaysFromSubscription();


                $subscription_status = Account::getSubscriptionStatus();
                $view->with(['subscription_status'=>$subscription_status, 'addOns'=>$addOns]);
            }
        });
    } 

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
