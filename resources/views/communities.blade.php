
@extends('app.layout')

@section('title','Feed')

@section('content')
    <div class="content">

        <button
                style="margin-top: 5%; margin-bottom: 5%; width: 20%"
                class="subscribe-button" onclick="location.href='{{route('community.create')}}'">Создать сообщество</button>


        @foreach($communities as $community)
            @include('blocks.community', [ 'community'=>$community])
        @endforeach


    </div>

@endsection
