<?php

namespace Dibs\Http\Controllers;

use Illuminate\Http\Request;
use Dibs\Item;

class DisplayItemDetailsController extends Controller
{
    //
    public function show($id)
    {
        $item = Item::where('id', $id)->first();
        
    
        return view('display_item_details')->withItem($item);
    }
}
