<div class="post">
    <a href="{{route('community.page',$community->id)}}" target="_blank">
        <img class="author-image" src="{{$community->avatar()->url}}" alt="Author Image">
    </a>
    <div class="post-content">
        <p>
            <a style="text-decoration: none; color: black" href="{{route('community.page',$community->id)}}" target="_blank">
                <b>{{$community->name??''}} </b>
            </a>
        </p>
        <div class="width-1">
            bio
        </div>
    </div>
</div>
