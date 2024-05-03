@if($message->from_id == $userId)
    <div class="my-message d-flex justify-content-end">
        <img class="author-image" src="{{$message->to->avatar()->image}}" alt="Author Image">
        <div class="post-content">
            <p><b>Вы: </b>{{$message->text??''}}</p>
            @include('blocks.gallery',['images'=>$message->images])
            <div class="post-info d-flex justify-content-between align-items-end">
                <span class="publish-date">{{$message->created_at->diffForHumans()??"00:00"}}</span>
            </div>
        </div>
    </div>
@else
    <div class="their-message-message d-flex justify-content-end">
        <img class="author-image" src="{{$message->to->avatar()->image}}" alt="Author Image">
        <div class="post-content">
            <p><b>{{$message->from->name??''}}: </b>{{$message->text??''}}</p>
            @include('blocks.gallery',['images'=>$message->images])
            <div class="post-info d-flex justify-content-between align-items-end">
                <span class="publish-date">{{$message->created_at->diffForHumans()??"00:00"}}</span>
            </div>
        </div>
    </div>
@endif

