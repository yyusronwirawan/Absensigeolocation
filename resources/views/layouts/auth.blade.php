<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <title>Login - Sisenpai</title>
    <link rel="stylesheet" href="{{ asset('template/admin') }}/css/main/app.css" />
    <link rel="stylesheet" href="{{ asset('template/admin') }}/css/pages/auth.css" />
    <link rel="shortcut icon" href="{{ asset('template/admin') }}/images/logo/logo.png" type="image/x-icon" />
    <link rel="shortcut icon" href="{{ asset('template/admin') }}/images/logo/logo.png" type="image/png" />
</head>

<body>
    <div id="auth">
        @yield('content')
    </div>

    @stack('js')
</body>

</html>
