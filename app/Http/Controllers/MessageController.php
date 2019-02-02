<?php

namespace Dibs\Http\Controllers;

use Illuminate\Http\Request;
use Dibs\Message;
use Dibs\User;
use Dibs\Item;
use Auth;

class MessageController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return view('messages');
    }
    
    
    public function getChats(){
        $user = Auth::user();
        $user_id = $user->id;
      
      
        return Item::with('owner','dibscaller')->where([
                    ['dibs_caller_id', '=', $user_id],
                    ['dibs_caller_id', '<>', '', 'and'],
                    ])
                    ->orWhere([
                    ['owner_id', '=' , $user_id],
                    ['dibs_caller_id', '<>', '', 'and'],
                    ])->get();
    }
    
    
    public function getMessages($id) // Item and user must match
    {
        // not testing for is available
        $user = Auth::user();
        $user_id = $user->id;
        $item_id = $id;
        
        
        //The query will return everything that the user received or send as message according to the item, it can return 
        $messages = Message::with('user','receiver')
        ->where(['user_id'=> $user_id, 'item_id' => $item_id])
        ->orWhere(function($query) use($user_id, $item_id){
          $query->where(['receiver_id' => $user_id, 'item_id' => $item_id]);
        })
        ->get();
        
        return $messages;
    }


    public function sendMessage(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $message = new Message;
        
        
        if ($user_id == $request->item_owner_id)
            $message->receiver_id = $request->item_dibs_caller_id;
        else if ($user_id == $request->item_dibs_caller_id)
            $message->receiver_id = $request->item_owner_id;
        
        $message->user_id = $user_id;
        $message->item_id = $request->item_id;
        $message->message = $request->message;
        
        $message->save();
        
        return response(['status'=>'Message private sent successfully','message'=> $message]);
    }
    
}
