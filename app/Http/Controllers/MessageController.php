<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Like;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function messages(){
        $profile = Auth::user();
        return view('messages',compact('profile'));
    }


    public function chat($to_id){
        $messages = Message::chat($to_id, Auth::id())->get();
        $userId = Auth::id();
        $chatWith = User::find($to_id);
        return view('chat',compact('messages','userId', 'to_id', 'chatWith'));
    }


    public function sendMessage(Request $request){
        $input = $request->input();

        $message = new Message();
        $message->from_id = Auth::id();
        $message->to_id=$input['to_id'];
        $message->text = $input['text'];
        $message->save();
        MessageSent::dispatch($message);

        return response()->json(['success'=>true]);

    }
}
