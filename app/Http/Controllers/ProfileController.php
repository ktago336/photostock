<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Like;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function myPage(){
        $profile = Auth::user();
        return redirect()->route('user.page',$profile);
    }


    public function userPage($id){
        $profile = User::with('images')->findOrFail($id);
        $userLikedPostsIds = Like::select('likeable_type','likeable_id','id')->where('user_id',Auth::id())->pluck('likeable_type','likeable_id','id');
        $friendsTotal = $profile->friendsCount();
        $friends = $profile->friends()->latest()->take(9)->get();
        return view('personal-page',compact('profile','userLikedPostsIds', 'friendsTotal','friends'));
    }


    public function updateAvatar(Request $request, $id){
        //Permissions
        if ($id != Auth::id()){
            abort(403);
        }

        $user = User::findOrFail($id);

        $image = Image::createFromUploaded($request->file('image'));
        $image->is_avatar = true;
        $image->author_id = $id;
        $user->images()->save($image);
        $image->save();

        return response()->json(['succes'=>true],200);

    }
}
