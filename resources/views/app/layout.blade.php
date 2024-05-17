@include('app.head')

<body class="d-flex flex-column">
@include('app.header')

<main class="" style="flex: 1">
    <div class="row w-100 flex-nowrap">
        @auth()
            @include('app.menus.sidebar')
        @endauth

        <div class="h-100" style="flex-shrink: unset; padding-right: 0px">
            @yield('content')
        </div>
    </div>
</main>

{{--@include('app.footer')--}}

</body>

<!-- Modal -->

@include('modals.comments')

<!-- Modal -->
</html>

