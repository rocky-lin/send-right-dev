<?php 
use Illuminate\Database\Seeder; 
// use Illuminate\Database\Eloquent\Model;  
use App\UserAccount;
use App\User;
use App\Account; 
use App\Contact;
use App\List1;
use App\ListContact;
use App\Form;
use App\FormList;
use App\Campaign;
use App\CampaignSchedule;
use App\Newsletter;

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
        List1::truncate(); 
        ListContact::truncate(); 
        Form::truncate(); 
        FormList::truncate(); 
        Campaign::truncate();
        CampaignSchedule::truncate(); 
        Newsletter::truncate(); 
        // DB::table('users')->truncate();
        // DB::table('users')->truncate();
        // DB::table('users')->truncate(); 
        factory(UserAccount::class, 20)->create();  
        factory(Contact::class, 20)->create();
        factory(List1::class, 20)->create();  
        factory(ListContact::class, 20)->create();  
        factory(Form::class, 20)->create();
        factory(FormList::class, 40)->create();
        factory(Campaign::class, 40)->create();
        factory(CampaignSchedule::class, 40)->create();
        factory(Newsletter::class, 40)->create();
        
        // Model::reguarded();  
    }
}  