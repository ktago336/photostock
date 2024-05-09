@extends('app.layout')

@section('title','Feed')

@section('content')

    <div class="content w-100">


                @foreach(\App\Models\User::all() as $chat)
                    @include('blocks.chat',compact('chat'))
                @endforeach



                <!-- Add more posts, friends, etc. -->
            </div>
        </div>
    <!-- More feed items go here -->
    </div>

@endsection
