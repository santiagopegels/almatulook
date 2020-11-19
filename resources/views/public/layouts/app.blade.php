<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('public.layouts.partials.styles')
</head>

<body>
<div id="app">
    <router-view></router-view>
</div>
</body>

@include('admin.layouts.partials.scripts')

</html>
