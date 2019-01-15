<?php

use Illuminate\Http\Request;
use Dibs\Item;
use Dibs\Position;
use Dibs\Category;
use Dibs\Http\Resources\ItemResource;
use Dibs\Http\Resources\PositionResource;
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

//get item by id - Used in home page, called in a marker click on map
Route::get('/item/{id}', function ($id) {

    return json_encode(Item::where('id',$id)->first());
});


Route::get('/get_markers', function (Request $request) {

  $userPosition = new Position; // Creates new position, class created to handle latitude and longitude coordinates
  $userPosition->lat = $request->lat;
  $userPosition->lng = $request->lng;
  
  $allitems = Item::select('id','lat','lng')->get();
  $items = array();
  
  foreach ($allitems as $item)
  {
     $distance = $userPosition->getDistance($item->lat,$item->lng);
      if ($distance <= 20) // If its within 20km of user location
      {
        $markerItem = new Position;
        $markerItem->lat = $item->lat;
        $markerItem->lng = $item->lng;
        $markerItem->id = $item->id;
        $markerItem->setDistanceToUser($distance);
        
        array_push($items,$markerItem);
      }
  }
    return PositionResource::collection(collect($items));
});

Route::get('/get_categories', function () {
    return CategoryResource::collection(Category::all());
});

Route::get('/get_displayed_items', function () {
    return ItemResource::collection(Item::where('is_available', true)->get());
});
