<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AutoResponseDetails;

class AutoResponseDetailsController extends Controller
{
    /**
     * @return string
     */
    public function startResponse() {


        $autoResponseDetails = AutoResponseDetails::getActiveAutoResponses();
//        $autoResponseDetails = AutoResponseDetails::find(1);

//        dd($autoResponseDetails);



//        return "test";
    }
}
