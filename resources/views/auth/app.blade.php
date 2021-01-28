<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{config('app.name')}}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('admin.layouts.partials.styles')
</head>

<body class="app flex-row justify-content-center mt-3">
<div class="container">
    <main class="main">
        @include('coreui-templates::common.errors')
        <div class="clearfix"></div>
        @include('flash::message')
        <div class="clearfix"></div>
        <div class="d-flex justify-content-center mt-4">
            <a href="/">
            <img src="{{ asset('img/logo/logo.png') }}" alt="{{ env('APP_NAME') }}">
            </a>
        </div>
        @yield('content')
    </main>
</div>
</body>


</html>
