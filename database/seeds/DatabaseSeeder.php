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
use App\Subscription; 
use App\Product; 
use App\ProductDetail; 
use App\Invoice; 
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
        Subscription::truncate(); 
        Product::truncate(); 
        ProductDetail::truncate(); 
        Invoice::truncate(); 
 
        // DB::table('users')->truncate();
        // DB::table('users')->truncate();
        // DB::table('users')->truncate(); 
        factory(Account::class, 10)->create();  
        factory(UserAccount::class, 10)->create();  
        factory(Contact::class, 10)->create();
        factory(List1::class, 10)->create();  
        factory(ListContact::class, 10)->create();  
        factory(Form::class, 10)->create();
        factory(FormList::class, 10)->create();
        factory(Campaign::class, 10)->create();
        factory(CampaignSchedule::class, 10)->create();
        factory(Newsletter::class, 10)->create(); 
        factory(Subscription::class, 10)->create();
        factory(Product::class, 10)->create();
        factory(ProductDetail::class, 10)->create();
        factory(Invoice::class, 10)->create();
    
        // Model::reguarded();  
    }
}  