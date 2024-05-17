<header class="border-bottom header sticky-top">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <a href="{{route('feed')}}" class="d-flex align-items-center col-lg-4 mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
            <img height="50px" src="/svg/logo-wide.svg">
        </a>


            @guest()
                @if(($page??'') == 'login')
                    <a href="{{route('register')}}" class="text-decoration-none" style="color: whitesmoke">Регистрация</a>
                @elseif(($page??'') == 'register')
                    <a href="{{route('login')}}" class="text-decoration-none" style="color: whitesmoke">Вход</a>
                @else
                    <a href="{{route('login')}}" class="text-decoration-none" style="color: whitesmoke">Вход</a>
                @endif
            @endguest
            @auth()

                <a href="{{route('my.page')}}" class="header-link my-page-link text-decoration-none" style="color: whitesmoke"><img class="header-avatar" src="{{\Illuminate\Support\Facades\Auth::user()->avatar()->url}}"> Моя страница</a>
            @endauth

    </div>
</header>