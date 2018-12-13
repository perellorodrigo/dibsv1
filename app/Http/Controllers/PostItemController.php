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
}
