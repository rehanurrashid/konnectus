<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Language;

class LanguageController extends Controller
{
     public function index(Request $request)
    {
        $language = Language::all();

        if($language){
            return response()->json($language, 200);
        }
        else{
            return response()->json(['error'=> 'No Languages Found!'], 404);
        }  
    }
}
