
@extends('app.layout')

@section('title','Feed')

@section('content')
    <div class="content">

        @foreach(\App\Models\Post::latest()->with(['author', 'author.images'])->get() as $feedPost)
            @include('blocks.post', ['post'=>$feedPost, 'profile'=>$feedPost->author])
        @endforeach


        <!-- More feed items go here -->
    </div>

@endsection
