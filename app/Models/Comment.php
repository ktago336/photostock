<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    use HasFactory;


    public function images():MorphMany{
        return $this->morphMany(Image::class,'imageable');
    }


    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }


    public function commentable():MorphTo{
        return $this->morphTo('commentable');
    }


    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }


    public function createdAgo(){
        return $this->created_at->diffForHumans();
    }
}
