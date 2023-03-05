<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\Service;
use App\Models\UserChat;

class ChatController extends Controller
{

    public function index(){
        try {
            $chats = Chat::all();

            if(count($chats) == 0){
                return response()-> json();
            }

            return response()->json([
                'chats' => $chats
            ],200);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ],400);            
        }
    }

    public function create($id){
        try{
            $service_id = $id;
            $user_id=auth()->user()->id;

            $chat = Chat::create([
                'service_id' => $service_id
            ]);

            $chat_id = $chat->id;
            
            $user_chat = UserChat::create([
                'user_id' => $user_id,
                'chat_id' => $chat_id
            ]);

            return response()->json([
               'message' =>'Started chat'
            ],201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
