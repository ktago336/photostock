<div class="post">
    <a href="{{route('user.page',$profile->id)}}" target="_blank">
        <img class="author-image" src="{{$profile->avatar()->url}}" alt="Author Image">
    </a>
    <div class="post-content">
            <p>
                <a style="text-decoration: none; color: black" href="{{route('user.page',$profile->id)}}" target="_blank">
                    <b>{{$profile->name??''}} </b>
                </a>
            </p>
        <div class="width-1">

        </div>
    </div>
</div>
