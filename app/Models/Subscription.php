<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;


    protected $table='subscribeables';



    protected $fillable=['subscribeable_id','subscribeable_type','user_id'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscribeable()
    {
        return $this->belongsTo(User::class, 'subscribeable_id');
    }
}
