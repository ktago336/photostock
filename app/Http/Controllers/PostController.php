<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function createPost(Request $request){

        $input = $request->validate([
            'text'=>'required',
            'image'=>'file'
        ]);

        $post = new Post();
        $post->text = $input['text'];
        $post->save();
        $post->author()->associate(Auth::user());
        $post->save();

        //TODO add $post->postable() relation adding (and validation)

        if ($request->file('image')){
            $image = Image::createFromUploaded($request->file('image'));
            $image->is_avatar = false;
            $image->author_id = Auth::id();
            $post->images()->save($image);
            $image->save();
        }


        return redirect()->back();
    }
}
