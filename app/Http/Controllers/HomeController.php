<?php

namespace Dibs\Http\Controllers;

use Illuminate\Http\Request;
use Dibs\Item;
use Auth;

class HomeController extends Controller
{
    
    public function callDibs($id)
     {
         //to-do: test if another user already called dibs
        $affected = Item::where('id', $id)
                ->whereNull('dibs_caller_id')
                ->update(['dibs_caller_id' => Auth::id()]);
      
      
        $messages = array();
        if ($affected == 0)
            array_push($messages,'Whops! Someone called dibs before you');
        else
            array_push($messages,'You successfully called dibs!');
        
        return view('home')->withMessages($messages);
     }
     
     
    public function index()
    {
        //$items = Item::all();
        //$message = '';
        $messages = array();
        //return view('home')->withItems($items);
        return view('home')->withMessages($messages);
    }
}
