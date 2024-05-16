@include('app.head')

<body>
@include('app.header')

<div class="container-fluid">
    <div class="row w-100 flex-nowrap">
        @auth()
            @include('app.menus.sidebar')
        @endauth

        <div class="h-100 overflow-y-scroll" style="flex-shrink: unset">
            @yield('content')
        </div>
    </div>
</div>

@include('app.footer')

</body>
</html>


