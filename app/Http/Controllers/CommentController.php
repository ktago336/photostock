<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Image;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function getComments(Request $request){
        $input = $request->input();

        $userLikedPostsIds = Like::select('likeable_type','likeable_id','id')->where('user_id',Auth::id())->where('likeable_type',Comment::class)->pluck('likeable_type','likeable_id','id');
        $commentable = $input['commentable_type']::find($input['commentable_id']);

        $comments = $commentable->comments()->with('user')->get();//TODO pagination
        $cards='';
        if ($comments->count()==0){
            $cards = 'Нет комментариев';
        }
        else{
            foreach ($comments as $comment){
                $cards .= view('blocks.comment',['post' => $comment,'userLikedPostsIds'=>$userLikedPostsIds])->render();
            }
        }
        //TODO pagination

        return response()->json(['cards'=>$cards, 'success'=>true]);
    }


    public function sendComment(Request $request){
        $input = $request->input();

        $validated = $request->validate([
            'commentable_type'=>'required',
            'commentable_id'=>'required',
            'text'=>'required',
        ]);
        if (!Auth::check()){
            abort(401);
        }

        $newComment = new Comment();
        $newComment->commentable_type = $input['commentable_type'];
        $newComment->commentable_id = $input['commentable_id'];
        $newComment->text = $input['text'];
        $newComment->user_id = Auth::id();
        $newComment->save();
        if ($request->file()){
            foreach ($request->file('images') as $image){
                $image = Image::createFromUploaded($image);
                $image->is_avatar = false;
                $image->author_id = Auth::id();
                $newComment->images()->save($image);
                $image->save();
            }
        }

        return response()->json(['success'=>true,'commentable_type'=>$input['commentable_type'],'commentable_id'=>$input['commentable_id']]);

    }
}
