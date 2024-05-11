<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function deleteProfileSubscription($id){
        $user = Auth::user();
        $user->deleteFriend($id);
        $user->unsubscribe(User::class, $id);
        return redirect()->back();
    }


    public function deleteCommunitySubscription($id){
        $user = Auth::user();
        $user->unsubscribe(Community::class, $id);
        return redirect()->back();
    }

    public function subscribeToProfile($id){
        $user = Auth::user();
        if ($id == $user->id || !User::find($id)){
            return redirect()->back();
        }

        $user->subscribe(User::class,$id);

        if($user->hasSubscriber($id)){
            $user->makeFriendsWith($id);
        }

        return redirect()->back();
    }

    public function subscribeToCommunity($id){
        $user = Auth::user();
        if (Subscription::where('user_id',$user->id)->where('subscribeable_id',$id)->where('subscribeable_type',Community::class)->first() || !Community::find($id)){
            return redirect()->back();
        }

        $user->subscribe(Community::class,$id);


        return redirect()->back();
    }
}
