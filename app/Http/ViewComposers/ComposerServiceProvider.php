<?php

namespace App\Http\ViewComposers;

use Illuminate\Support\ServiceProvider;
use Auth;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {




//        print "Test";
        // Using class based composers...
//        view()->composer(
//            'pages.campaign.campaign', 'App\Http\ViewComposers\ProfileComposer'
//        );
//
//        // Using Closure based composers...
//        view()->composer('dashboard', function ($view) {
//            //
//        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}