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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

Route::get('/', 'HomeController@index');
Auth::routes();

Route::post('/post_item', function (Request $request) {
    

    $item = new Item;
    $item->name = $request->input('name');
    $item->description = $request->input('description');
    $item->lat = floatval($request->input('itemlat'));
    $item->lng = floatval($request->input('itemlng'));
    $file = $request->file('picture');
    
    
    
    $item->imageurl = Storage::disk('uploads')->put('photos',$file);
    
  
    $item->save();

    return redirect('/');
});

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::get('/post_item', 'PostItemController@index')->name('post_item');
Route::get('/home/{id}', 'DisplayItemDetailsController@show');