<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewsLetterController extends Controller
{
    public function index()
    {
    	return view('pages.newsletter.newsletter-home'); 
    }

    public function getSeder()
    {

    }

    public function store(Request $request)
    { 
    	//
    }

    public function destroy($id)
    {
    	// delete newsletter
    }
}
