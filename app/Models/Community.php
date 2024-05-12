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

    private $avatar;

    public function posts():MorphMany{
        return $this->morphMany(Post::class, 'author');
    }


    //TODO admins
    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }


    public function subscribers():MorphToMany{
        return $this->morphToMany(User::class, 'subscribeable');
    }


    public function wall(): MorphMany{
        return $this->morphMany(Post::class, 'postable', 'postable_type', 'postable_id');
    }


    public function allImages(){
        return Image::where(function($q){
            $q->where('imageable_type','App\Models\Post')
                ->orWhere('imageable_type','App\Models\User');
        })
            ->where('author_id',$this->id)
            ->orderBy('id','desc');
    }


    public function images():MorphMany{
        return $this->morphMany(Image::class,'imageable');
    }


    public function avatar(){
        if (!$this->avatar){
            return $this->avatar = $this->images()->where('is_avatar',1)->latest('id')->first()
                ??
                (object)['url'=>config('app.profile_placeholder')];
        }
        //TODO add Images model realisation, Images with is_avatar are array, last is actual
        return $this->avatar;
    }

}
