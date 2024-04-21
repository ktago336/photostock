<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Post extends Model
{
    use HasFactory;


    public function images():MorphMany{
        return $this->morphMany(Image::class,'imageable');
    }


    public function author(): MorphTo {
        return $this->morphTo(__FUNCTION__, 'author_type','author_id');
    }


    public function likes(): HasMany
    {
        return $this->hasMany(Like::class, 'post_id');
    }


    public function postable(): MorphTo{
        return $this->morphTo();
    }


    public function createdAgo(){
        Carbon::setLocale('ru');
        return $this->created_at->diffForHumans();
    }

}
