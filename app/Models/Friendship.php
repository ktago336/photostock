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
    protected $fillable=['user_id','friend_id'];


    // Relationship with User model for the user_id column
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship with User model for the friend_id column
    public function friend()
    {
        return $this->belongsTo(User::class, 'friend_id');
    }


    public function profile(){
        return Auth::id() == $this->user_id ? $this->friend : $this->user;
    }
}
