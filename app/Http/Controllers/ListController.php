<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\List1; 
use App\User;
use Auth; 
use App\ListContact;
use DB;
use Redirect;
use Input; 
class ListController extends Controller
{
    private $id;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
       return view('pages.list.list', ['listContacts']); 
    }  
   
   public function getLists($id) { 
        return; 
   }

    public function getListsAndDetails() {   


        $lists = List1::getLists()->toArray();  
   


        // print "test";

        $counter=0;
        foreach($lists as $list) {   
            $lists[$counter]['contact_total'] = List1::getListContactsTotal($list['id']);
            $counter++; 
        } 
        // print"<pre>"; 
        // print_r($lists); 
        // print "</pre>";
        // dd($lists);
        return $lists;
    } 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        return view('pages/list/list-create');
    } 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\StoreListReuquest $request)
    {   

        print "list " . $request->get('contact_ids');

        // $totalContact = explode(',', $request->get('contact_ids')); 
        $totalContactLen = strlen($request->get('contact_ids')); 

        // dd($totalContact); 

        // if less than 3 meaning user didn't select a contact that belongs to the list 
        if($totalContactLen < 3) {
            return Redirect::back()->withInput(Input::all())->with('status_contact', 'Please select at least 1 contact.');
        }



        // insert new list
        $listData = $request->except('_token', 'contact_ids'); 
        $listData['account_id'] = User::getUserAccount();    
        $list1 = List1::create($listData);   
 



        // insert to list contacts 
        foreach ($this->toArrayContactIds($request->get('contact_ids')) as $contact_id) { 
            ListContact::firstOrCreate(['list_id'=>$list1->id, 'contact_id'=>$contact_id]); 
        }  




        // return response
        return redirect()
            ->back()
            ->with('status', 'successfully added new list');  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }



    public function getListContacts($id) { 
        $listContacts = ListContact::where('list_id', $id)->get();  
        return $listContacts;  
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {  

        $list = List1::find($id); 
        // $this->id = $id; 
        // $listDetails = DB::table('lists')
        // ->join('list_contacts', function ($join)  {  
        //     $join->on('lists.id', '=', 'list_contacts.list_id') 
        //          ->where('lists.id', '=', $this->id);
        // })
        // ->get();  
        return view('pages.list.list-edit', compact('list', 'id'));
    } 
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\StoreListReuquest $request, $id)
    {    
        // dd($request->all());
        // insert new list
        $listData = $request->except('_token', 'contact_ids', '_method'); 
        // $listData['account_id'] = User::getUserAccount();    
         List1::where('id', $id)->update($listData); 

         // delete first all the list contacts
        ListContact::where('list_id', $id)->delete(); 
 
        // insert to list contacts 
        foreach ($this->toArrayContactIds($request->get('contact_ids')) as $contact_id) { 
            ListContact::firstOrCreate(['list_id'=>$id, 'contact_id'=>$contact_id]); 
        }   
        
        // return response
        return redirect()
            ->back()
            ->with('status', 'successfully updated list');  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * delete lists
     * delete list_contact
     */
    public function destroy($id)
    {    
        ListContact::where('list_id', $id)->delete();  
        List1::find($id)->delete(); 
        return "Successfully deleted list!";   
    }

    private function toArrayContactIds($contact_ids) {
         // compose id for list_contacts
        $contact_ids = str_replace('[', '', $contact_ids) ; 
        $contact_ids = str_replace(']', '', $contact_ids);  
        $contact_ids  = explode(',', $contact_ids);   
        return $contact_ids;
    }

    public function searchLists($query='') 
    {   
        $lists = List1::where('name', 'LIKE', '%'. $query . '%')
            ->where('account_id', Auth::user()->id)
            ->get()
            ->toArray();  
        return $lists;   
    }  
}
