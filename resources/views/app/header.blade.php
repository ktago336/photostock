<div class="header sticky ">
    <h1 class="flex-container">
        <img height="50px" src="/svg/1logo-wide.svg">
        @guest()
            @if(($page??'') == 'login')
                <a href="{{route('register')}}" class="header-link" style="padding-right: 1%" >Регистрация</a>
            @elseif(($page??'') == 'register')
                <a href="{{route('login')}}" class="header-link" style="padding-right: 1%">Вход</a>
            @else
                <a href="{{route('login')}}" class="header-link" style="padding-right: 1%">Вход</a>
            @endif
        @endguest
        @auth()
            <a href="{{route('my.page')}}" class="header-link my-page-link"><img class="header-avatar" src="{{\Illuminate\Support\Facades\Auth::user()->avatar()}}"> Моя страница</a>
        @endauth
    </h1>
</div>
