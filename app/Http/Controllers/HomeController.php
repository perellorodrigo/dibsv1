<?php

namespace Dibs\Http\Controllers;

use Illuminate\Http\Request;
use Dibs\Item;
use Dibs\Category;
use Dibs\Position;
use Dibs\Http\Resources\ItemResource;
use Dibs\Http\Resources\MarkerItemResource;
use Dibs\Http\Resources\CategoryResource;
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
    public function cancelDibs($id)
    {
        $affected = Item::where([['id','=', $id],['owner_id','!=',Auth::id()]])
                ->whereNotNull('dibs_caller_id')
                ->update(['dibs_caller_id' => null]);
                
        if ($affected == 0)
            $message = 'Whops! Something went wrong!';
        else
            $message = 'You successfully canceled dibs!';
            
        return response()->json([
        'message' => $message], 200);
                
    }

    public function index()
    {
        return view('home');
    }
    
    public function getMarkers(Request $request)
    {
        $userPosition = new Position; // Creates new position, class created to handle latitude and longitude coordinates
        $userPosition->lat = $request->lat;
        $userPosition->lng = $request->lng;
        
        $allitems = Item::where('is_available',true)->get();
        $markeritems = array();
        
        foreach ($allitems as $item)
        {
            $distance = $userPosition->getDistance($item->lat,$item->lng);
            if ($distance <= 20) // If its within 20km of user location
            {
                $markerItem = new Position;
                $markerItem->lat = $item->lat;
                $markerItem->lng = $item->lng;
                $markerItem->id = $item->id;
                $markerItem->name = $item->name;
                $markerItem->category_id = $item->category_id;
                $markerItem->description = $item->description;
                $markerItem->imageurl = $item->imageurl;
                $markerItem->setDistanceToUser($distance);
                $markerItem->dibs_caller_id = $item->dibs_caller_id;
                $markerItem->owner_id = $item->owner_id;
                
                array_push($markeritems,$markerItem);
            }
        }
        
        return MarkerItemResource::collection(collect($markeritems));
    }
    
    public function getItemByID($id){
        return json_encode(Item::where('id',$id)->first());
    }
    
    public function getCategories(){
        return CategoryResource::collection(Category::all());
    }
}
