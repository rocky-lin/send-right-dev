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
use Route;
use Session;
 
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }


        Language::setCurrentLanguage();


        // App::setLocale('pl');
        // This need to be change and point only to real page of the site
        view()->composer('*', function ($view) {

            if (Auth::user() ) {
 
                /**
                 * Query subscription in payshortcut and store to a session
                 */
                Account::getLatestSubscriptionQueryToPayshortcut();
 
                /**
                 * If total contact exceed with quota for specific subscription trigger this function to save new billing upgrade for queue in payshortcut.net
                 */
                Account::billingCheckCurrentSubscriptionTotalContactExceed();

                /**
                 * redirect billing page if, billing is not valid
                 */
                if(Account::isSubscribedAndValid() == false) {
                    if (Route::current()->getName() != 'user.billing') {
                        $urlBilling = url('user/billing');
                        ?>
                        <script>
                            document.location = '<?php echo $urlBilling; ?>';
                        </script> <?php
                    }
                }

                /**
                 * Subscription information
                 */
                
                $sendRightProductLink ='http://demo4.iamrockylin.com/shop/uncategorized/sendright-lite-plan/'; 


                /**  Use this data anywhere in the project  */
                $_SESSION['UserId'] = Auth::user()->id;
                $_SESSION['account_id'] = User::getUserAccount();
                $_SESSION['extension']['db_name'] = env('DB_DATABASE');
                $_SESSION['extension']['db_user'] = env('DB_USERNAME');
                $_SESSION['extension']['db_pass'] = env('DB_PASSWORD');
                $_SESSION['extension']['site_url'] = url('/');
                $_SESSION['form_builder']['menu']['excludedFields'] = ['url', 'textarea', 'checkbox', 'radio', 'select','selectmultiple','upload','date','rating','time','hidden','image','terms'];
                $_SESSION['form_builder']['db_contact']['entry_fields_filters'] = ['first_name', 'last_name', 'email', 'location', 'phone', 'telephone'];
                $_SESSION['url']['hoem'] =  url('/');

                /**  global variables  */
                $addOns['is_has_email_mobile_opt_in'] = AddOn::isHasMobileOptIn(); 
                Subscription::updateSubscriptionExpired(); 
                $subscription_status = Account::getSubscriptionStatus();

                $view->with(
                    [
                        'subscription_status'=>$subscription_status, 
                        'addOns'=>$addOns, 
                        'userRole'=>User::getUserRole(), 
                        'sendRightProductLink'=>$sendRightProductLink
                    ]
                );
                
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
