<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like(Request $request){
        $input = $request->validate([
            'likeable_type'=>'required',
            'likeable_id'=>'required'
        ]);

        if (!$user = Auth::user()){
            return response()->json(['success'=>false],403);
        }

        $likeable_id = $input['likeable_id'];
        $likeable_type = $input['likeable_type'];

        if ($like = Like::where('likeable_id', $likeable_id)->where('likeable_type',$likeable_type)->where('user_id',$user->id)->first()){
            $like->delete();
            return response()->json(['increase'=>false]);
        }
        else{
            $like = new Like();
            $like->user_id = $user->id;
            $like->likeable_id = $likeable_id;
            $like->likeable_type = $likeable_type;
            $like->save();
            return response()->json(['increase'=>true]);
        }

    }
}
