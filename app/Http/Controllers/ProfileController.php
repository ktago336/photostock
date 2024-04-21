<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function myPage(){
        $profile = Auth::user();
        $userLikedPostsIds = Like::select('post_id')->where('user_id',Auth::id())->pluck('post_id')->toArray();

        return view('my-page',compact('profile','userLikedPostsIds'));
    }
}
