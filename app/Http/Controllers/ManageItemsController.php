<?php

namespace Dibs\Http\Controllers;

use Illuminate\Http\Request;
use Dibs\User;
use Dibs\Item;
use Auth;

class ManageItemsController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return view('manage_items');
    }
    
    public function getAvailable(){
        
        return Item::with('owner','dibscaller')
        ->where('owner_id',Auth::id())
        ->whereNull('dibs_caller_id')
        ->where('is_available',true)
        ->get();
    }
    
    public function getAwaiting(){
        
        
        return Item::with('owner','dibscaller')
        ->where('owner_id',Auth::id())
        ->whereNotNull('dibs_caller_id')
        ->where('is_available',true)
        ->get();
    }
    
    public function getHistory(){
        
        return Item::with('owner','dibscaller')
        ->where('owner_id',Auth::id())
        ->where('is_available',false)
        ->get();
        
    }
    public function archiveItem($itemID){
        
        $affected = Item::where([['id','=', $itemID],
                                ['owner_id','=',Auth::id()]])
                            ->update(['is_available' => false]);
                            
        if ($affected == 0)
            $message = 'Whops! Something went wrong!';
        else
            $message = 'You successfully archived the Item!';
            
        return response()->json([
        'message' => $message], 200);
    }
    
}
