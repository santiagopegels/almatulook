<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{config('app.name')}}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('admin.layouts.partials.styles')
</head>

<body class="app flex-row align-items-center justify-content-center">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-group">
                <div class="card p-4">
                    <div class="card-body">
                        <main class="main" id="app">
                            @include('coreui-templates::common.errors')
                            <div class="clearfix"></div>
                            @include('flash::message')
                            <div class="clearfix"></div>
                            @yield('content')
                        </main>
                    </div>
                </div>
                <div class="card text-white bg-primary py-5 d-md-down-none flex-row align-items-center justify-content-center">
                    <div class="card-body text-center flex-row align-items-center justify-content-center">

                        <div>
                        <!-- <img src="{{ asset('img/logo/logo.svg') }}" width="120" alt="{{ env('APP_NAME') }}"> -->
                            <h1 class="gratta logo mb-0">
                                {{ env('APP_NAME') }}
                            </h1>
                            <p class="mt-0">{{ env('APP_SLOGAN') }}</p>

                            <p class="mb-4">

                            @if(Request::is('*login'))
                                <p class="mt-4 mb-2">
                                    @lang('general.not_has_account')
                                </p>
                                <a class="btn btn-primary m-0 text-white active" href="{{ url('/register') }}">@lang('general.register')</a>
                            @endif

                            @if(Request::is('*register'))
                                <p class="mt-4 mb-2">
                                    @lang('general.has_account')
                                </p>
                                <a class="btn btn-primary text-light active" href="{{ url('/login') }}">@lang('general.login')</a>
                            @endif


                            @if(!Request::is('*login') && !Request::is('*register'))
                                <a class="btn btn-primary text-light active" href="{{ url('/login') }}">@lang('general.back')</a>
                                @endif

                                </p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

@include('admin.layouts.partials.scripts')

</html>
