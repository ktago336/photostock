
<div class="sticky-top col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-light h-100" style="top: 70px; z-index: -2">
    <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2">

        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
            <li class="nav-item">
                <a href="{{route('feed')}}" class="nav-link align-middle px-0">
                    <i class="fs-4 bi-newspaper"></i> <span class="ms-1 d-none d-sm-inline">Лента</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{route('my.page')}}" class="nav-link align-middle px-0">
                    <i class="fs-4 bi-person"></i> <span class="ms-1 d-none d-sm-inline">Мой профиль</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{route('messages')}}" class="nav-link align-middle px-0">
                    <i class="fs-4 bi-chat"></i> <span class="ms-1 d-none d-sm-inline">Мои сообщения</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{route('people')}}" class="nav-link align-middle px-0">
                    <i class="fs-4 bi-person-add"></i> <span class="ms-1 d-none d-sm-inline">Люди</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{route('communities')}}" class="nav-link align-middle px-0">
                    <i class="fs-4 bi-people"></i> <span class="ms-1 d-none d-sm-inline">Сообщества</span>
                </a>
            </li>
            <hr>
            <li class="nav-item">
                <a href="{{route('login.exit')}}" class="nav-link align-middle px-0">
                    <i class="fs-4 bi-door-open"></i> <span class="ms-1 d-none d-sm-inline">Выйти</span>
                </a>
            </li>

        </ul>


{{--        <hr>--}}
{{--        <div class="dropdown pb-4">--}}
{{--            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">--}}
{{--                <img style="object-fit: cover;" src="{{\Illuminate\Support\Facades\Auth::user()->avatar()->url}}" alt="hugenerd" width="30" height="30" class="rounded-circle">--}}
{{--                <span class="d-none d-sm-inline mx-1">{{\Illuminate\Support\Facades\Auth::user()->name??''}}</span>--}}
{{--            </a>--}}
{{--            <ul class="dropdown-menu dropdown-menu-dark text-small shadow">--}}
{{--                <li><a class="dropdown-item" href="{{route('my.page')}}">Профиль</a></li>--}}
{{--                <li><a class="dropdown-item" href="#">Редактировать</a></li>--}}
{{--                <li>--}}
{{--                    <hr class="dropdown-divider">--}}
{{--                </li>--}}
{{--                <li><a class="dropdown-item" href="{{route('login.exit')}}">Выйти</a></li>--}}
{{--            </ul>--}}
{{--        </div>--}}
    </div>
</div>