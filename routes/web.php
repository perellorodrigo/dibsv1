<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
  //  return view('welcome');
//});
use Dibs\Item;
use Dibs\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;



Auth::routes();
Route::post('/post_item', function (Request $request) {
  //To-do: add file validation
    $item = new Item;
    $item->name = $request->input('name');
    $item->description = $request->input('description');
    $item->pickup_instructions = $request->input('pickup_instructions');
    $item->owner_id = Auth::id();
    $item->lat = floatval($request->input('itemlat'));
    $item->lng = floatval($request->input('itemlng'));
    $file = $request->file('picture');
    $item->imageurl = Storage::disk('uploads')->put('photos',$file);
    
    $item->save();

    return redirect('/');
});
Route::get('/test', function () {
  
  return view('test');
})->name('test');


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index');

//To-do: Extint route
Route::get('/home/{id}', 'DisplayItemDetailsController@show');
//

// To-do: extinct function, create similar in api routes
Route::get('/call_dibs/{id}','HomeController@callDibs');
//------

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::get('/post_item', 'PostItemController@index')->name('post_item');

/* Old Function 
Route::post('/get_user_position', function (Request $request) {

  $userPosition = new Position; // Creates new position, class created to handle latitude and longitude coordinates
  $userPosition->lat = $request->lat;
  $userPosition->lng = $request->lng;
  
  
  //$allitems = Item::all(); // Query all items from database
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

  return view('coordinates')->withItems($items);
  
});
*/