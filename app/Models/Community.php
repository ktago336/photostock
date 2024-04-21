<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Community extends Models
{
    use HasFactory;


    public function posts():MorphMany{
        return $this->morphMany(Post::class, 'author');
    }


    public function wall(): MorphMany{
        return $this->morphMany(Post::class, 'postable', 'postable_type', 'postable_id');
    }
}
