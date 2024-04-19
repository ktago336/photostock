
@extends('app.layout')

@section('title','Feed')

@section('content')

    <div class="content">

        @for($i=0; $i<10; $i++)
            @include('blocks.feed-item')
        @endfor


        <!-- More feed items go here -->
    </div>

@endsection
