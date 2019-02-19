<?php

use Illuminate\Http\Request;
use Dibs\Item;
use Dibs\Position;
use Dibs\Category;
use Dibs\Message;
use Dibs\Http\Resources\ItemResource;
use Dibs\Http\Resources\MarkerItemResource;
use Dibs\Http\Resources\CategoryResource;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


//get
Route::get('/dibbeditems/{id}', function ($id) {

    return ItemResource::collection(Item::where('dibs_caller_id',$id)->where('is_available', true)->get());
});

Route::get('/user_active_items/{id}', function ($id) {
    return ItemResource::collection(Item::where('owner_id',$id)->where('is_available', true)->get());
});


//get item by id - Used in home page, called in a marker click on map
Route::get('/item/{id}', function ($id) {
    return json_encode(Item::where('id',$id)->first());
});


Route::get('/get_markers', function (Request $request) {

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
});

 


