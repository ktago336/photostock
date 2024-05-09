<?php

namespace App\Models;

use App\Interfaces\Postable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Community extends Model implements Postable
{
    use HasFactory;


    public function posts():MorphMany{
        return $this->morphMany(Post::class, 'author');
    }


    public function subscribers():MorphToMany{
        return $this->morphToMany(User::class, 'subscribeable');
    }


    public function wall(): MorphMany{
        return $this->morphMany(Post::class, 'postable', 'postable_type', 'postable_id');
    }
}
