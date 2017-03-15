<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;
use App\User; 
use App\Form;
use File; 
use Auth;
use App\List1;
use App\Contact;
use App\Campaign;
use App\AutoResponse;
use App\Label;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $labels = Label::where('account_id', User::getUserAccount())->where('type', 'form')->get();  
        return view('pages/form/form', compact('labels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('plugin/form-builder/index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return 'edit this specific form';
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
        //
    } 
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $deletedRows = Form::where('id', $id)->delete();
        // print "deleted form id " .   $id; 
            $form         = Form::find($id);
            $autoResponse = AutoResponse::where('table_name', 'forms')->where('table_id', $id);

            print "form name " . $form->folder_name; 
            // if( $deletedRows ) { 
            if($form->delete()) {
                if($autoResponse->delete()) {
                    print "<br> Auto response successfully deleted";
                } else {
                    print "<br> Auto response failed to delete";
                }
                // delete foder of the form
                $success = File::deleteDirectory('E:/xampp/htdocs/rocky/send-right-dev/extension/form/create/editor/forms/' . $form->folder_name);
                if($success == true) {  
                    print "successfully deleted";
                } else {
                    print "failed to delete";
                }
                // delete entry of the form? not sure in this part yet
                print "folder " .$form->folder_name . " successfully deleted.";
            } else {
                print "folder " .$form->folder_name . " failed to delete."; 
            }
             // dd($form);
        // } else {
            // print "<br>failed to delete form row id $id"; 
        // } 
        // exit;
        // $form = Form::find($id);
        // delete form 
        // if($form->delete()){
        //     print "form " . $id . " row successfully deleted.";
        // } else {
        //     print "fold " . $id . " row failed to delete.";
        // } 
        // delete form list 
        // delete form build  
        // delete file 
        // $frm = Form::find($id); 
        // print  ' id - ' . $id . " folder name = " . $frm->folder_name;  
        // dd($form);
        // print "delete this folder name" . $form->folder_name;  
        // $success = File::deleteDirectory('E:/xampp/htdocs/rocky/send-right-dev/extension/form/create/editor/forms/' . $frm->folder_name);
        // if($success == true) {
        //     print "folder " .$frm->folder_name . " successfully deleted.";
        // } else {
        //     print "folder " .$frm->folder_name . " failed to delete."; 
        // }
    }
    public function getUserAccountForms() 
    {   
        $forms = User::getUserAccountForms(); 
        $counter = 0; 
        foreach ($forms as $form) { 
            $forms[$counter]['total_entry'] = Form::getFormTotalContact($form['id']);
            $counter++; 
        }  
        // dd($forms);
        $collection = collect( $forms ); 
        $sorted = $collection->sortBy('id', SORT_REGULAR, true); 
        return $sorted->values()->all();
    }
    public function viewConnectList()
    { 
        $autoRespondersArr = [];
        $autoRespondersArr[0] = 'select..';


        $formLists = User::formLists();  
        $autoResponders = Campaign::where('account_id', User::getUserAccount())->where('kind', 'auto responder')->get();

        foreach($autoResponders as $responder) {
            $autoRespondersArr[$responder->id] = $responder->title; 
        }
         // $autoResponders = array_collapse($autoResponders); 
         // dd($autoResponders);

        // get user lists
        $lists = List1::where('account_id', User::getUserAccount())->get();

        return view('pages/form/form-connect-list', compact('formLists', 'autoRespondersArr', 'lists'));
    }
    public function postConnectList(Request $request)
    {
        dd($request);
    }
    public function registerNewFormStep1(Request $request)
    {    
        //        session_start();
 
        if(!List1::where('name', $request->get('selectedList') )->where('account_id', User::getUserAccount())->count()) {
            return redirect()->back()->with('status', 'Please select your correct list correctly.')->withInput();
        } else if (empty($request->get('formName'))) {
            return redirect()->back()->with('status', 'Form name is required.')->withInput();
        }
 
        $_SESSION['formEntryStep1'] = $request->all(); 
        if($request->get('selectedAutoResponse') != 0) {
            $_SESSION['formEntryStep1']['autoresponse']['name'] = Campaign::find($request->get('selectedAutoResponse'))->title;
            $_SESSION['formEntryStep1']['autoresponse']['id'] = $request->get('selectedAutoResponse');
        } else {
            $_SESSION['formEntryStep1']['autoresponse']['name'] = 'not selected..';
            $_SESSION['formEntryStep1']['autoresponse']['id'] = 0;
        }

        $_SESSION['formEntryStep1']['email'] = Auth::user()->email;   
        // dd($_SESSION['formEntryStep1']);  
        return redirect(url('extension/form/create/editor/index.php')); 
    }
    public function viewContacts($id) 
    {   
        $listId = Form::getListIdFirst($id); 
        // return "test". $listId;
        return view('pages.form.form-contact-detail', compact('listId'));  
    }   
    public function getContacts($listId) 
    { 
        // return Contact::find(50);
        // return App\List1::getListContacts(8);
        // print "list id " .$list_id;
        // return  List1::amazingTest();
        return List1::getListContactsWithDetails($listId);
    }  
  
    public function getAllByLabel($label_id=null)
    {   
        $data = [];   

        // get all form under this label     
        $labelDetails = Label::find($label_id)->labelDetails;    

        // // get form by label details table id and add it in array    
        foreach($labelDetails as $labelDetail) {  
             $data[] = Form::find($labelDetail->table_id); 
        }  
  
        //  return form, to be display in front end  
        return $data; 
    } 
}