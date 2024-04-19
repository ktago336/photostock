<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function myPage(){
        $profile = Auth::user();
        return view('my-page',compact('profile'));
    }
}
