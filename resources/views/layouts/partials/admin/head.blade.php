<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{ asset('template/admin') }}/css/main/app.css">
    <link rel="stylesheet" href="{{ asset('template/admin') }}/css/main/app-dark.css">
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('template/admin') }}/images/logo/logo.png" type="image/png" />
    <link rel="stylesheet" href="{{ asset('template/admin') }}/css/shared/iconly.css">
    <link rel="stylesheet" href="{{ asset('template/admin') }}/extensions/@icon/dripicons/dripicons.css" />
    @stack('css')
</head>
