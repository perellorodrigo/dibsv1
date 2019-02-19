<?php

namespace Dibs\Http\Controllers;

use Illuminate\Http\Request;

class PostItemController extends Controller
{
    //Only allow this page to registered users
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('post_item');
    }
    
    public function AddItem(Request $request) {
        
        $item = new Item;
        $item->name = $request->name;
        $item->description = $request->description;
        $item->category_id = $request->selected_category;
        $item->pickup_instructions = $request->pickup_instructions;
        $item->owner_id = $request->owner_id;
        $item->lat = floatval($request->latitude);
        $item->lng = floatval($request->longitude);
        $file = $request->image;
        $item->imageurl = Storage::disk('uploads')->put('photos',$file);
        
        $item->save();
    
        return response()->json(['success'=>'You have successfully uploaded an item.']);
    }
}
