@extends('app.layout')

@section('title','Feed')

@section('content')

    <div class="content" style="width: 80%;">


                @foreach($chats as $chat)
                    @include('blocks.chat',compact('chat'))
                @endforeach



                <!-- Add more posts, friends, etc. -->
            </div>
        </div>
    <!-- More feed items go here -->
    </div>

@endsection
