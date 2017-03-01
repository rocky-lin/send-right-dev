<?php

namespace App\Http\Controllers; 

use Illuminate\Http\Request; 
use App\Http\Requests; 
use App\Contact; 
use App\User; 
use App\ListContact;
use Storage; 
use Excel;
use App\Activity;

class ContactController extends Controller
{

    private $excelPath='';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        return view("pages/contact/contact"); 
    }

    public function getUserAccountContacts() { 
            $contacts = User::getUserAccountContacts(); 
            $collection = collect( $contacts ); 
            $sorted = $collection->sortBy('id', SORT_REGULAR, true); 
            return $sorted->values()->all();
    }
 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
          return view("pages.contact.contact-create"); 
       //return "show form to create a contact";
    }
        

    public function import() {
        return view('pages/contact/contact-import');
    }

    /**
     * [import This will handle in importing files for create contact]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function importStore(Requests\StoreContactFileRequest $request) {  
     
        //save file to the server
        $this->excelPath = $request->file('importFile')->store('contact/import/files');   

        // extract file content to contact table
        Excel::load('storage/app/' . $this->excelPath, function($reader) {  
             $contacts = $reader->get();   
             foreach ($contacts as $contact) { 
                $contacArray['account_id']        = User::getUserAccount();
                $contacArray['first_name']        = (!empty($contact->first_name)) ? $contact->first_name : '';
                $contacArray['last_name']         = (!empty($contact->last_name)) ? $contact->last_name : '';
                $contacArray['email']             = (!empty($contact->email)) ? $contact->email : '';
                $contacArray['location']          = (!empty($contact->location)) ? $contact->location : '';
                $contacArray['phone_number']      = (!empty($contact->phone_number)) ? $contact->phone_number : '';
                $contacArray['telephone_number']  = (!empty($contact->telephone_number)) ? $contact->telephone_number : '';
                $contacArray['status']            = (!empty($contact->status)) ? $contact->status : 'not active'; 
                $contacArray['type']              = (!empty($contact->type)) ? $contact->type : 'import contact';  
                $contacArray['history']           = (!empty($contact->history)) ? $contact->history : "Imported from  storage/app/$this->excelPath";  

                $contactCreated = Contact::firstOrCreate($contacArray);   
             } 
        }); 
        

        return redirect()->back()->with('status1', 'successfully imported and extracted to contacts');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\StoreContact $request)
    {   
        $data = [];  
        $data = $request->except('_token'); 
        $data['account_id'] = User::getUserAccount();   
        Contact::create($data);   
        return redirect()->back()->with('status', 'New Contact Created!');
          // return redirect('dashboard')->with('status', 'Profile updated!');
    } 
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return "show specific cotnact";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    { 
 
        $contact = Contact::find($id); 
        return view("pages.contact.contact-edit", compact('id', 'contact'));
    }

    public function getById($id) {
        return Contact::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        $input = $request->except(['_token', '_method']);  
        Contact::where('id', $id)->update($input);    
        return redirect()->back()->with('status', 'Successfully updated!'); 
    }
    
    /**
     * Remove the specified resource from storage. 
     * @param  int  $id
     * @return \Illuminate\Http\Response    
     * Delete specific contact
     * Delete contact from the list details  
     */
    public function destroy($id)
    {   
        ListContact::where('contact_id', $id)->delete(); 
        Contact::find($id)->delete();  
        return "Successfully deleted contact!";  
    }
    /**
     * This unsubscribe need more upgrade in coding  
     */
    public function unsubscribe($id, $email)
    {    
       if(Contact::where('id', $id)->where('email', $email)->update(['status'=> 'unsubscribed'])) {
            print "Contact successfully un subscribed to this campaign";
       }else{ 
            print "Contact failed to unsubscribe, something wrong";
       } 
       print " click <a href='". url('/'). "'>  here </a>  to go http://sendright.net"; 
    } 
} 