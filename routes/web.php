<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/',function (){
    if (Auth::check()){
        return redirect()->route('feed');
    }
    return redirect()->route('login');
});

Route::get('/login',[\App\Http\Controllers\LoginController::class, 'login'])->name('login');
Route::post('/login',[\App\Http\Controllers\LoginController::class, 'loginPost'])->name('login.post');
Route::get('/register',[\App\Http\Controllers\RegisterController::class, 'register'])->name('register');
Route::post('/register',[\App\Http\Controllers\RegisterController::class, 'registerPost'])->name('register.post');
Route::get('/exit',[\App\Http\Controllers\LoginController::class, 'exit'])->name('login.exit');

Route::group(['middleware' => 'auth'], function(){
    Route::get('/feed', [\App\Http\Controllers\FeedController::class, 'index'])->name('feed');
    Route::get('/my-page', [\App\Http\Controllers\ProfileController::class, 'myPage'])->name('my.page');
    Route::post('/wall/{id}/create/post',[\App\Http\Controllers\PostController::class, 'createPost'])->name('create.post');
    Route::post('/like',[\App\Http\Controllers\LikeController::class, 'like'])->name('like.post');

    Route::get('/messages',[\App\Http\Controllers\MessageController::class, 'messages'])->name('messages');
    Route::get('/chat/{to_id}',[\App\Http\Controllers\MessageController::class, 'chat'])->name('chat');
    Route::post('/send-message', [\App\Http\Controllers\MessageController::class, 'sendMessage'])->name('message.send');
    Route::get('/user/{id}',[\App\Http\Controllers\ProfileController::class, 'userPage'])->name('user.page');
    Route::post('/update/photo/profile/{id}',[\App\Http\Controllers\ProfileController::class, 'updateAvatar'])->name('update.avatar');
});

