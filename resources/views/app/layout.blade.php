@include('app.head')

<body>
@include('app.header')

<div class="container-main">
    @auth()
        @include('app.menus.sidebar')
    @endauth

    @yield('content')
</div>

@include('app.footer')

</body>
</html>


