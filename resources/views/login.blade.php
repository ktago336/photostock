
@extends('app.layout',['page'=>'login','title'=>'Вход'])

@section('title','Вход')

@section('content')

    <body>
    <div class="flex-auth">
        <div class="log-form">
            <h2>Войдите в аккаунт</h2>
            <form action="{{route('login.post')}}" method="post">
                @csrf
                <input required type="text" name="email" title="email" placeholder="E-mail">
                <input required type="password" name="password" title="username" placeholder="Пароль">
                <button type="submit" class="btn">Вход</button>
            </form>
            @if($errors->any())
                {!! implode('', $errors->all('<div>:message</div>')) !!}
            @endif
        </div><!--end log form -->
    </div>

    </body>


@endsection
