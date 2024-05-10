<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like(Request $request){
        $input = $request->validate([
            'post_id'=>'required'
        ]);

        if (!$user = Auth::user()){
            return response()->json(['success'=>false],403);
        }

        $post_id = $input['post_id'];

        if ($like = Like::where('post_id', $post_id)->where('user_id',$user->id)->first()){
            $like->delete();
            return response()->json(['increase'=>false]);
        }
        else{
            $like = new Like();
            $like->user_id = $user->id;
            $like->post_id = $post_id;
            $like->save();
            return response()->json(['increase'=>true]);
        }

    }
}
