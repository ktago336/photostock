<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedController extends Controller
{
    public function index(){
        $userLikedPostsIds = Like::select('post_id')->where('user_id',Auth::id())->pluck('post_id')->toArray();
        $posts = \App\Models\Post::latest()->with(['author', 'author.images'])->get();
        return view('feed',compact('userLikedPostsIds','posts'));
    }
}
