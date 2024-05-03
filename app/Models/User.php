<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function avatar(){
        //TODO add Images model realisation, Images with is_avatar are array, last is actual
         return $this->images()->where('is_avatar',1)->latest('id')->first()
             ??
             (object)['image'=>config('app.profile_placeholder')];
    }


    public function allImages(){
        return Image::where(function($q){
            $q->where('imageable_type','App\Models\Post')
              ->orWhere('imageable_type','App\Models\User');
        })
            ->where('author_id',$this->id);
    }


    public function images():MorphMany{
        return $this->morphMany(Image::class,'imageable');
    }


    public function posts():MorphMany{
        return $this->morphMany(Post::class, 'author');
    }


    public function sentMessages() : HasMany {
        return $this->hasMany(Message::class, 'from_id');
    }


    public function recievedMessages() : HasMany {
        return $this->hasMany(Message::class, 'to_id');
    }


    public function likes(): HasMany
    {
        return $this->hasMany(Like::class, 'user_id');
    }


    public function wall(): MorphMany{
        return $this->morphMany(Post::class, 'postable', 'postable_type', 'postable_id');
    }


    public function authored(): HasMany
    {
        return $this->hasMany(Image::class, 'author_id');
    }
}
