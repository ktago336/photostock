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
        $profile = User::findOrFail($id);
        $userLikedPostsIds = Like::select('post_id')->where('user_id',Auth::id())->pluck('post_id')->toArray();

        return view('personal-page',compact('profile','userLikedPostsIds'));
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
