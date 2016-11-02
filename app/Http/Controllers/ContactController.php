<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Contact;

use App\User;



class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        return view("pages.contact.contact"); 
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
        // dd($data);
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
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {  
        if(Contact::find($id)->delete()){
            return "Successfully deleted contact! id " . $id;
        } else {
            return "Failed to delete contact! id = " . $id; 
        } 
    }
}