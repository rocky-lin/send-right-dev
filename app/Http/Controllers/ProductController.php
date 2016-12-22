<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    //

    public function processSelectedProduct(Request $request)
    {
        dd($request->all());
    }
}
