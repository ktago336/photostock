<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Interfaces\Postable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements Postable
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
            ->where('author_id',$this->id)
	    ->orderBy('id','desc');
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


    public function subscribers():MorphToMany{
        //SUbscriptions with type User and subscribeable_id == $this->id
        //upd works fine
            return $this->morphToMany(User::class, 'subscribeable', 'subscribeables');
   }


    public function subscriptions():MorphToMany{
        return $this->morphToMany(User::class, 'subscribeable', 'subscribeables', 'user_id', 'subscribeable_id');
    }


    public function getFriendsAttribute(){
        if ( ! array_key_exists('friends', $this->relations)) $this->loadFriends();

        return $this->getRelation('friends');
    }


    public function makeFriendsWith(int $id){
        $thisUserId = $this->id;
        $friendship = Friendship::where(function ($q) use ($id, $thisUserId){
            $q->where('user_id',$id)
                ->where('friend_id',$thisUserId);
        })
            ->orWhere(function ($q) use ($id, $thisUserId){
                $q->where('user_id',$thisUserId)
                    ->where('friend_id',$id);
            })->first();
        if ($friendship){
            return $friendship;
        }
        $friendship = new Friendship();
        $friendship->user_id = $this->id;
        $friendship->friend_id = $id;
        $friendship->save();

        return $friendship;
    }

    public function deleteFriend(int $id){
        $thisUserId = $this->id;
        $friendship = Friendship::where(function ($q) use ($id, $thisUserId){
            $q->where('user_id',$id)
                ->where('friend_id',$thisUserId);
        })
            ->orWhere(function ($q) use ($id, $thisUserId){
                $q->where('user_id',$thisUserId)
                    ->where('friend_id',$id);
            });
        if ($friendship){
            $friendship->delete();
        }
        return false;
    }


    public function subscribe($subscribeableType, $subscribeableId){
        if ($subscription = Subscription::where('user_id',$this->id)->where('subscribeable_type',$subscribeableType)->where('subscribeable_id',$subscribeableId)->first()){
            return $subscription;
        }
        $subscription = new Subscription();
        $subscription->user_id = $this->id;
        $subscription->subscribeable_type = $subscribeableType;
        $subscription->subscribeable_id = $subscribeableId;
        $subscription->save();
    }


    public function unsubscribe($subscribeableType, $subscribeableId){
        if ($subscription = Subscription::where('user_id',$this->id)->where('subscribeable_type',$subscribeableType)->where('subscribeable_id',$subscribeableId)->first()){
            $subscription->delete();
        }
    }


    public function hasSubscriber($subscriberId){
        return (bool)Subscription::where('user_id',$subscriberId)->where('subscribeable_type',User::class)->where('subscribeable_id',$this->id)->first();
    }
    


    public function isFriend($id){
        $thisUserId=$this->id;
        return (bool)Friendship::where(function ($q) use ($id, $thisUserId){
            $q->where('user_id',$id)
                ->where('friend_id',$thisUserId);
        })
            ->orWhere(function ($q) use ($id, $thisUserId){
                $q->where('user_id',$thisUserId)
                    ->where('friend_id',$id);
            })->first();
    }
    
    public function isSubscribed($id){
        $thisUserId=$this->id;
        return Subscription::where(function ($q) use ($id, $thisUserId){
            $q->where('user_id',$thisUserId)
                ->where('subscribeable_id',$id);
            })
        ->first() ?? false;
    }



    public function friends(){
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id');
    }


    protected function mergeFriends(){
        return $this->friendsOfMine->merge($this->friendOf);
    }


    public function getFriends(){

    }


    public function authored(): HasMany
    {
        return $this->hasMany(Image::class, 'author_id');
    }








    protected function friendsOfMine(){
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id');
    }


    protected function friendOf(){
        return $this->belongsToMany(User::class, 'friends', 'friend_id', 'user_id');
    }

    protected function loadFriends(){
        if ( ! array_key_exists('friends', $this->relations))
        {
            $friends = $this->mergeFriends();

            $this->setRelation('friends', $friends);
        }
    }


    protected function friendships(){
        return $this->hasMany(Friendship::class);
    }
}
