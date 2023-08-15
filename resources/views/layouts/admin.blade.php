@include('layouts.partials.admin.head')

<body>
    <div id="app">
        @include('layouts.partials.admin.sidebar')
        <div id="main" class="layout-navbar">
            @include('layouts.partials.admin.header')

            <div id="main-content">
                @yield('content')
            </div>

            @include('layouts.partials.admin.footer')
        </div>
    </div>

    @include('layouts.partials.admin.script')
</body>

</html>
