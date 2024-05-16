@php
    $link = route('user.page',$post->user->id);
@endphp
<div class="post">
    <a href="{{$link}}" target="_blank">
        <img class="author-image" src="{{$post->user->avatar()->url}}" alt="Author Image">
    </a>
    <div class="post-content">
        <p>
            <a style="text-decoration: none; color: black" href="{{$link}}" target="_blank">
                <b>{{$post->user->name??''}}: </b>
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

            <div class="d-flex">

                <span class="likes like-btn d-flex" data-likeable-id="{{$post->id}}" data-likeable-type="{{\App\Models\Comment::class}}">
                <div class="numberOfLikes">{{$post->likes()->count()}} </div>
                    @if(\Illuminate\Support\Facades\Auth::user()->liked()->where('likeable_type',$post::class)->where('likeable_id',$post->id)->first())
                        <div class="like-symbol red"><i class="bi bi-heart-fill"></i></div>
                    @else
                        <div class="like-symbol"><i class="bi bi-heart"></i></div>
                    @endif

            </span>
            </div>

        </div>
    </div>
</div>
