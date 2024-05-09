<div class="post">
    <a href="{{route('user.page',$profile->id)}}" target="_blank">
        <img class="author-image" src="{{$profile->avatar()->url}}" alt="Author Image">
    </a>
    <div class="post-content">
            <p>
                <a style="text-decoration: none; color: black" href="{{route('user.page',$profile->id)}}" target="_blank">
                    <b>{{$profile->name??''}}: </b>
                </a>
                {{$post->text??''}}
            </p>
        <div class="width-1">
            @foreach($post->images as $image)
                <img width="400px" src="{{$image->url}}">
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
