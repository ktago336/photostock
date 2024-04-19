<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Community extends Model
{
    use HasFactory;


    public function posts():MorphMany{
        return $this->morphMany(Post::class, 'author');
    }
}
