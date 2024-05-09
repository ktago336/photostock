
@extends('app.layout')

@section('title','Feed')

@section('content')
    <div class="content">

        @foreach($users as $user)
            @include('blocks.user', [ 'profile'=>$user])
        @endforeach


        <!-- More feed items go here -->
    </div>

@endsection
