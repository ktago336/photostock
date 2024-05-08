<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Auth;

class Friendship extends Model
{
    use HasFactory;

    protected $table='friends';


    protected $fillable=['subscribeable_id','subscribeable_type','user_id'];


    public function subscribeable():MorphTo
    {
        return $this->morphTo();
    }
}
