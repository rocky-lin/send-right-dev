<?php 
use Illuminate\Database\Seeder; 
// use Illuminate\Database\Eloquent\Model;  
use App\UserAccount;
use App\User;
use App\Account; 
use App\Contact;
 
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {  
    	// create specific users with accounts   
    	// Model::unguard();   
    	User::truncate();
    	UserAccount::truncate(); 
    	Account::truncate();
        Contact::truncate();

        // DB::table('users')->truncate();
        // DB::table('users')->truncate();
        // DB::table('users')->truncate(); 
        factory(UserAccount::class, 10)->create();  
        factory(Contact::class, 200)->create();
        // Model::reguarded(); 
    }
}
