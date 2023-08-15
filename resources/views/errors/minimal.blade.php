<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('template/admin') }}/css/main/app.css" />
    <link rel="stylesheet" href="{{ asset('template/admin') }}/css/pages/error.css" />
</head>

<body>
    <div id="error">
        <div class="error-page container">
            <div class="col-md-8 col-12 offset-md-2">
                <div class="text-center">
                    <h1 class="error-title">@yield('title')</h1>
                    <p class="fs-5 text-gray-600">
                        @yield('message')
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
