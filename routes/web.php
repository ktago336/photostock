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
    Route::get('/people', [\App\Http\Controllers\FriendsController::class, 'people'])->name('people');
    Route::get('/my-page', [\App\Http\Controllers\ProfileController::class, 'myPage'])->name('my.page');
    Route::post('/wall/{id}/create/post',[\App\Http\Controllers\PostController::class, 'createPost'])->name('create.post');
    Route::post('/community/{id}/create/post',[\App\Http\Controllers\PostController::class, 'createCommunityPost'])->name('create.community.post');
    Route::post('/like',[\App\Http\Controllers\LikeController::class, 'like'])->name('like.post');
    Route::post('profile-settings', [\App\Http\Controllers\ProfileSettingsController::class, 'settings'])->name('profile.settings');

    Route::get('/messages',[\App\Http\Controllers\MessageController::class, 'messages'])->name('messages');
    Route::get('/chat/{to_id}',[\App\Http\Controllers\MessageController::class, 'chat'])->name('chat');
    Route::post('/send-message', [\App\Http\Controllers\MessageController::class, 'sendMessage'])->name('message.send');
    Route::get('/user/{id}',[\App\Http\Controllers\ProfileController::class, 'userPage'])->name('user.page');
    Route::post('/update/photo/profile/{id}',[\App\Http\Controllers\ProfileController::class, 'updateAvatar'])->name('update.avatar');
    Route::post('/update/photo/community/{id}',[\App\Http\Controllers\CommunityController::class, 'updateAvatar'])->name('update.community.avatar');

    Route::get('/subscribe-profile/{id}',[\App\Http\Controllers\SubscriptionController::class, 'subscribeToProfile'])->name('subscribe.profile');
    Route::get('/subscribe-community/{id}',[\App\Http\Controllers\SubscriptionController::class, 'subscribeToCommunity'])->name('subscribe.community');
    Route::get('/delete-friend/{id}',[\App\Http\Controllers\FriendsController::class, 'deleteFriend'])->name('delete.friend');
    Route::get('/unsubscribe/user/{id}',[\App\Http\Controllers\SubscriptionController::class, 'deleteProfileSubscription'])->name('delete.subscription');
    Route::get('/unsubscribe/community/{id}',[\App\Http\Controllers\SubscriptionController::class, 'deleteCommunitySubscription'])->name('delete.community.subscription');

    Route::get('/communities',[\App\Http\Controllers\CommunityController::class, 'communities'])->name('communities');
    Route::get('/community/{id}',[\App\Http\Controllers\CommunityController::class, 'communityPage'])->name('community.page');
    Route::get('/new-community/create',[\App\Http\Controllers\CommunityController::class, 'communityCreate'])->name('community.create');
    Route::post('/new-community/create',[\App\Http\Controllers\CommunityController::class, 'communityCreatePost'])->name('community.create.post');

    Route::get('/get/comments',[\App\Http\Controllers\CommentController::class, 'getComments'])->name('get.comments');
    Route::post('/send/comment',[\App\Http\Controllers\CommentController::class, 'sendComment'])->name('send.comment');

    
    Route::get('/developer-blog',function (){
        return view('developers-blog');
    });

    Route::get('/image/{id}',[\App\Http\Controllers\ImageController::class,'getImage'])->name('get.image');


});

