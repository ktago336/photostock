<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\Image;
use App\Models\Like;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityController extends Controller
{
    public function communityPage($id){
        $community = Community::findOrFail($id);
        $lastSubscribers = $community->subscribers()->latest()->take(3)->get();
        $userLikedPostsIds = Like::select('post_id')->where('user_id',Auth::id())->pluck('post_id')->toArray();

        return view('community-page',compact('community','lastSubscribers','userLikedPostsIds'));
    }


    public function communityCreate(){
        return view('community-create');
    }


    public function communityCreatePost(Request $request){
        $input = $request->input();

        $validated = $request->validate([
           'name'=>'required'
        ]);

        $community = new Community();
        $community->name = $input['name'];
        $community->bio = $input['bio']??null;

        $community->user_id = Auth::id();

        $community->save();

        return redirect()->route('community.page',$community->id);
    }
    

    public function communities(){
        $communities = Community::get();
        return view('communities',compact('communities'));
    }


    public function updateAvatar(Request $request, $id){
        //Permissions
        $community = Community::findOrFail($id);
        if ($community->user_id != Auth::id()){
            abort(403);
        }

        $image = Image::createFromUploaded($request->file('image'));
        $image->is_avatar = true;
        $image->author_id = Auth::id();
        $community->images()->save($image);
        $image->save();

        return response()->json(['succes'=>true],200);

    }

}
