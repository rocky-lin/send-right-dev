<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Mail;
use App\Mail\UserRegistered;
use App\Notifications\UserRegisteredNotification;
use Auth;
use Illuminate\Support\Facades\Input;
use App\UserAccount; 
use App\Account;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */ 

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }  

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    { 
        /*
         * add new users
         */
        $registrationToken = strtotime("now") . rand(0, 999999);
        $newCreatedUser = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'registration_token' => bcrypt($registrationToken),
        ]);      

        /*
         * Create new account
         */             
        $account = Account::create(); 
        // print "<br><br> account id " . $account->id;
        // dd($account);
 
        // dd($insertIntoUserAccount);

        /**
         * Create new user account
         */ 
        UserAccount::create([
            'account_id' => $account->id, 
            'user_id' => $newCreatedUser->id, 
            'role' => 'administrator'
        ]);
 

        // exit;
        /*
         * Send registration confirmation to the email  
         */
         $user = User::find($newCreatedUser->id);  
         $user->notify(new UserRegisteredNotification($user));     

         /*
          * return instance
          */
        return $newCreatedUser;  
    }

    public function confirmUserRegistration() { 
        $isUserConfirmed = User::where('registration_token', Input::get('token'))->update(array('status' => 'activated')); 
        if($isUserConfirmed) { 
            return "successfully activated  please click <a href='" . url('/') . "/login' > here </a> to login"; 
        } else {
            return "failed to activated  please click <a href='" . url('/') . "/login' > here </a> to login"; 
        }
    }
}