
@extends('app.layout',['page'=>'register'])

@section('title','Регистрация')

@section('content')

    <body>
    <div class="flex-auth">
        <div class="log-form">
            <h2>Создание аккаунта</h2>
            <form action="{{route('register.post')}}" method="post">
                @csrf
                <input required type="text" name="email" title="email" placeholder="E-mail">
                <input required type="text" name="name" title="name" placeholder="Имя">
                <input required type="text" name="surname" title="name" placeholder="Фамилия">
                <input required type="password" name="password" title="username" placeholder="Пароль">
                <button required type="submit" class="btn">Вход</button>
            </form>
            @if($errors->any())
                {!! implode('', $errors->all('<div>:message</div>')) !!}
            @endif
        </div><!--end log form -->
    </div>


    </body>

@endsection
