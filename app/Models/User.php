<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Http\Controllers\SubscriptionController;
use App\Interfaces\Postable;
use Illuminate\Database\Eloquent\Builder;
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


    private $avatar;

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
        if (!$this->avatar){
            return $this->avatar = $this->images()->where('is_avatar',1)->latest('id')->first()
                ??
                (object)['url'=>config('app.profile_placeholder')];
        }
        //TODO add Images model realisation, Images with is_avatar are array, last is actual
        return $this->avatar;
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


    /**
     * @return mixed Users builder, the example of model  have chat with
     */
    public function chats(){
        $chattersIds = $this->recievedMessages()->groupBy('from_id')->select('from_id as to_id')->union(
            $this->sentMessages()->groupBy('to_id')->select('to_id')
        )->get()->pluck('to_id')->toArray();

        return User::whereIn('id',$chattersIds);
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


    public function subscriptions():HasMany{
        return $this->hasMany(Subscription::class);
    }


//    public function getFriendsAttribute(){
//        if ( ! array_key_exists('friends', $this->relations)) $this->loadFriends();
//
//        return $this->getRelation('friends');
//    }


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
            })->first();
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


    public function friendsCount(){
        return Friendship::select('id')->where('user_id',$this->id)->orWhere('friend_id',$this->id)->count();
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


    public function friends()
    {
        // Query for friends where the current user is user_id and the friend is friend_id
        $friendsAsUserId = $this->belongsToMany(
            User::class,
            'friends',
            'user_id',
            'friend_id'
        )
            ->select('users.*'); // Select the same set of columns as the other query

        // Query for friends where the current user is friend_id and the user is user_id
        $friendsAsFriendId = $this->belongsToMany(
            User::class,
            'friends',
            'friend_id',
            'user_id'
        )
            ->select('users.*')->addSelect('friends.user_id as pivot_user_id')->addSelect('friends.friend_id as pivot_friend_id'); // Select the same set of columns as the other query


        $combinedQuery = $friendsAsUserId->union($friendsAsFriendId);

        return $combinedQuery;
    }

    protected function mergeFriends(){
        return $this->friendsOfMine->merge($this->friendOf);
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

}
