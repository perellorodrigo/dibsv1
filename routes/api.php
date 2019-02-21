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












 


