<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedController extends Controller
{
    public function index(){
        //TODO better cache liked posts
        $userLikedPostsIds = Like::select('likeable_type','likeable_id','id')->where('user_id',Auth::id())->groupBy('likeable_type','likeable_id','id')->get();
        //$posts = \App\Models\Post::latest()->with(['author', 'author.images'])->get();
        $posts=Post::query();
        $subscriptions = Auth::user()->subscriptions()->get();
        foreach ($subscriptions as $subscription){
            $posts->orWhere(function ($q) use ($subscription){
                $q->where('postable_type',$subscription->subscribeable_type)->where('postable_id',$subscription->subscribeable_id);
            });
        }
        $posts = $posts->latest()->get();
        return view('feed',compact('userLikedPostsIds','posts'));
    }
}
