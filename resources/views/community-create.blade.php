@extends('app.layout')

@section('title','Feed')

@section('content')

    <div class="flex-auth">
        <div class="log-form">
            <h2>Создание сообщества</h2>
            <form action="{{route('community.create.post')}}" method="post">
                @csrf
                <input required type="text" name="name" title="Название" placeholder="Название">
                <input required type="text" name="bio" title="Описание" placeholder="Описание">
                <button type="submit" class="btn">СОЗДАТЬ КОММУНИЗМ</button>
            </form>
            @if($errors->any())
                {!! implode('', $errors->all('<div>:message</div>')) !!}
            @endif
        </div><!--end log form -->
    </div>
@endsection
