<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(){
        if (Auth::check()){
            return redirect()->route('feed');
        }

        return view('register');
    }


    public function registerPost(Request $request){
        if (Auth::check()){
            return redirect()->route('feed');
        }

        $input = $request->validate([
            'email'=>'required|email',
            'name'=>'required',
            'surname'=>'required',
            'password'=>'required',
        ]);

        if (User::where('email',$input['email'])->first()){
            return redirect()->back()->withErrors('Электронная почта уже использована!');
        }

        $user = new User();
        $user->name = $input['name'];
        $user->surname = $input['surname'];
        $user->email = $input['email'];
        $user->password = Hash::make($input['password']);

        $user->save();

        Auth::login($user);

        return redirect()->route('feed');

    }
}
