<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User; 
use App\Form;
use File; 
use Auth;
class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.form.form');
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
            $form = Form::find($id);
            print "form name " . $form->folder_name; 
            // if( $deletedRows ) { 
            if($form->delete()) {  
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

    public function getUserAccountForms() { 
        $contacts = User::getUserAccountForms(); 
        $collection = collect( $contacts ); 
        $sorted = $collection->sortBy('id', SORT_REGULAR, true); 
        return $sorted->values()->all();
    } 
 
    public function viewConnectList()
    { 
        $formLists = User::formLists();  
        return view('pages.form.form-connect-list', compact('formLists')); 
    } 

    public function postConnectList(Request $request)
    {
        dd($request);
    } 

    public function registerNewFormStep1(Request $request)
    {    
        session_start();  
        $_SESSION['formEntryStep1'] = $request->all();
        $_SESSION['formEntryStep1']['email'] = Auth::user()->email; 
        // dd($_SESSION['formEntryStep1']);  
        return redirect(url('extension/form/create/editor/index.php')); 
    } 
}
