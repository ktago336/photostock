<div class="post">
    <img class="author-image" src="{{$profile->avatar()}}" alt="Author Image">
    <div class="post-content">
        <p><b>{{$profile->name??''}}: </b>{{$post->text??''}}</p>
        <div class="width-1">
            @foreach($post->images as $image)
                <img width="400px" src="{{$image->image}}">
            @endforeach
        </div>
        <div class="post-info d-flex justify-content-between align-items-end">
            <span class="publish-date">{{$post->createdAgo()}}</span>
            <span class="likes like-btn d-flex" data-post-id="{{$post->id}}">
                <div class="numberOfLikes">{{$post->likes()->count()}} </div>
                <div class="like-symbol @if(in_array($post->id, $userLikedPostsIds)) red @endif">&#10084;</div>
            </span>
        </div>
    </div>
</div>
