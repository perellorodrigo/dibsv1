<?php

namespace Dibs\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Dibs\Item;

class DashboardController extends Controller
{
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
        $items = Item::where('dibs_caller_id',Auth::id())->where('is_available', true)->get();;
        
        
        return view('dashboard')->withItems($items);
    }
}
