<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedController extends Controller
{
    public function index(){
        $userLikedPostsIds = Like::select('post_id')->where('user_id',Auth::id())->pluck('post_id')->toArray();
        return view('feed',compact('userLikedPostsIds'));
    }
}
