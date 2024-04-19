<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(){
        if (Auth::check()){
            return redirect()->route('feed');
        }

        return view('login');
    }


    public function loginPost(Request $request){
        if (Auth::check()){
            return redirect()->route('feed');
        }
        $input = $request->validate([
            'email'=>'required',
            'password'=>'required',
        ]);

        if (Auth::attempt($input)) {
            $request->session()->regenerate();

            return redirect()->route('feed');
        }

        return back()->withErrors([
            'email' => 'Электронная почта или пароль не совпадают с нашими записями',
        ])->onlyInput('email');
    }


    public function exit(){
        Auth::logout();
        return redirect()->route('login');
    }
}
