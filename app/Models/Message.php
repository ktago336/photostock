<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Message extends Model
{
    use HasFactory;


    public function to() : BelongsTo {
        return $this->belongsTo(User::class, 'to_id');
    }


    public function from() : BelongsTo {
        return $this->belongsTo(User::class, 'from_id');
    }


    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }


    public static function getLastMessage($from_id, $requesterId):self|null{
        return self::where(function ($query) use ($from_id, $requesterId){
            $query->where('to_id',$requesterId)->where('from_id',$from_id);
        })->orWhere(function ($query) use ($from_id, $requesterId){
            $query->where('to_id',$from_id)->where('from_id',$requesterId);
        })->latest()->first();
    }


    public static function chat($from_id, $requesterId):Builder{
        return self::where(function ($query) use ($from_id, $requesterId){
            $query->where('to_id',$requesterId)->where('from_id',$from_id);
        })->orWhere(function ($query) use ($from_id, $requesterId){
            $query->where('to_id',$from_id)->where('from_id',$requesterId);
        });
    }
}
