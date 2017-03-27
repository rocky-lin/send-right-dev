<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LabelDetail;


class LabelDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
         


         // print_r($request->all());

         // print "<br>";
         // print "<br>";
         // print "<br>";

        $label_id   = $request->get('label_id'); 
        $table_name = $request->get('table_name'); 
        $table_ids  = $request->get('table_ids');  
        foreach($table_ids as $table_id) { 
            if(LabelDetail::where('label_id', $label_id)->where('table_name', $table_name)->where('table_id', $table_id)->count()<1) { 

                // print "not exist ";
                $data = [
                        'label_id' => $label_id, 
                        'table_name'=>$table_name, 
                        'table_id'=>$table_id
                    ]; 

                // print_r($data); 

                $isInserted = LabelDetail::create(
                    $data
                ); 
                if($isInserted) {
                    print "inserted";
                } else {
                    print "not inserted";
                }
            } else {
                print "exist"; 
            }
        }  
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
        //
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


         $LDdeleted = LabelDetail::where("id", $id)->delete();

        if($LDdeleted) {
            print "successfully dlete label detail $id";
        } else {
            print "failed to dleted label detail $id";
        }

    }

    public function ajaxDelete(Request $request)
    {
        $id = $request->get('id');

         $LDdeleted = LabelDetail::where("id", $id)->delete();

        if($LDdeleted) {
            print "successfully dlete label detail $id";
        } else {
            print "failed to dleted label detail $id";
        }

    }


}
