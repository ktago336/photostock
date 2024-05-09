<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedController extends Controller
{
    public function index(){
        //TODO better cache liked posts
        $userLikedPostsIds = Like::select('post_id')->where('user_id',Auth::id())->pluck('post_id')->toArray();
        //$posts = \App\Models\Post::latest()->with(['author', 'author.images'])->get();
        $posts=collect();
        $subscriptions = Auth::user()->subscriptions()->with(['subscribeable','subscribeable.posts'])->get();
        foreach ($subscriptions as $subscription){
            $posts=$posts->merge($subscription->subscribeable->posts);
        }
        $posts = $posts->merge(Auth::user()->posts);
        return view('feed',compact('userLikedPostsIds','posts'));
    }
}
