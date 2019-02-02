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



Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index');

Route::post('/call-dibs/{id}','HomeController@callDibs');


Route::get('/post_item', 'PostItemController@index')->name('post_item');

Route::get('/manage_items', function () {
  return view('manage_items');
});



Route::get('/messages', 'MessageController@index')->name('messages');
Route::get('/get-chats', 'MessageController@getchats');
Route::get('/private-messages/{id}','MessageController@getMessages');
Route::post('/send-message','MessageController@sendMessage');