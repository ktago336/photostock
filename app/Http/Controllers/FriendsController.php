<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendsController extends Controller
{
    public function getFriends($user_id){
        $user = User::findOrFail($user_id);

        $friends = $user->getFriends();
    }


    public function deleteFriend($id){
        $user = Auth::user();
        if ($id == $user->id || !User::find($id)){
            return redirect()->back();
        }

        $user->unsubscribe(User::class, $id);
        $user->deleteFriend($id);

        return redirect()->back();
    }


    public function people(){
        $users = User::all()->except([Auth::id()]);
        return view('people',compact('users'));
    }
}
