<?php

namespace Dibs\Http\Controllers;

use Illuminate\Http\Request;
use Dibs\Item;
use Auth;

class HomeController extends Controller
{
    
    public function callDibs($id)
    {
        $affected = Item::where([['id','=', $id],['owner_id','!=',Auth::id()]])
                ->whereNull('dibs_caller_id')
                ->update(['dibs_caller_id' => Auth::id()]);

      
    
        if ($affected == 0)
            $message = 'Whops! Someone called dibs before you';
        else
            $message = 'You successfully called dibs!';
    
    return response()->json([
        'message' => $message], 200);
    
    }
     
     
    public function index()
    {
        return view('home');
    }
}
