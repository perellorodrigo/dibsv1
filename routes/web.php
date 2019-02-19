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




Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index');

Route::post('/call-dibs/{id}','HomeController@callDibs');
Route::post('/cancel-dibs/{id}','HomeController@cancelDibs');

Route::get('/post_item', 'PostItemController@index')->name('post_item');
Route::post('/post_item/add_item', 'PostItemController@addItem');


//Message Routes
Route::get('/messages', 'MessageController@index')->name('messages');
Route::get('/get-chats', 'MessageController@getchats');
Route::get('/private-messages/{id}','MessageController@getMessages');
Route::post('/send-message','MessageController@sendMessage');
//


//Manage Items Route
Route::get('/manage_items', 'ManageItemsController@index')->name('manage_items');
Route::get('/manage_items/get_available', 'ManageItemsController@getAvailable');
Route::get('/manage_items/get_awaiting', 'ManageItemsController@getAwaiting');
Route::get('/manage_items/get_history', 'ManageItemsController@getHistory');
Route::post('/manage_items/archive_item/{itemID}', 'ManageItemsController@archiveItem');
//


Route::get('/profile', 'ProfileController@index')->name('profile');
Route::post('/changePassword','ProfileController@changePassword')->name('changePassword');

Route::get('/get_categories', function () {
    return CategoryResource::collection(Category::all());
});