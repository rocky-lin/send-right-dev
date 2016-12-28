<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Account;
use App\User;
use Auth;
use App\Subscription;
 
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {  
            if (Auth::user() ) {
                  Subscription::updateSubscriptionExpired();
                  //                print"test";
                  //                print "total days remaining for your billed account " . Subscription::getRemainingDaysFromSubscription();
                $view->with('subscription_status', Account::getSubscriptionStatus()); 
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
