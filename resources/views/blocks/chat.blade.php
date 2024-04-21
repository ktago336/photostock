<a class="post" href="{{route('chat',['to_id'=>$chat->id])}}">
    @php
        \Carbon\Carbon::setLocale('ru');
        $lastMessage=\App\Models\Message::getLastMessage($chat->id,\Illuminate\Support\Facades\Auth::id());
    @endphp
    <img class="author-image" src="{{$chat->avatar()}}" alt="Author Image">
    <div class="post-content">
        <p><b>{{$chat->name??''}}: </b>{{$lastMessage->text??''}}</p>
        <div class="post-info d-flex justify-content-between align-items-end">
            @if($lastMessage)
                <span class="publish-date">{{$lastMessage->created_at->diffForHumans()??"00:00"}}</span>
            @endif
        </div>
    </div>
</a>
