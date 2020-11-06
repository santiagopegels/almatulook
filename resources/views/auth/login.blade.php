@extends('auth.app')

@section('content')

    <form class="text-center justify-content-center mt-4" method="post" action="{{ url('/login') }}">
        @csrf
        <h1 class="mb-4">@lang('general.login') @lang('general.in_app')</h1>
        <!-- <p class="text-muted">Sign In to your account</p> -->
        <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 input-group input-group-lg mb-3">
            <div class="input-group-prepend">
            <span class="input-group-text">
                <i class="icon-user"></i>
            </span>
            </div>
            <input type="email" class="form-control {{ $errors->has('email')?'is-invalid':'' }}" name="email"
                   value="{{ old('email') }}" placeholder="{{ __('fields.email') }}">
            @if ($errors->has('email'))
                <span class="invalid-feedback">
            <strong>{{ $errors->first('email') }}</strong>
        </span>
            @endif
        </div>
        </div>
        <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 input-group input-group-lg mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text">
                <i class="icon-lock"></i>
            </span>
            </div>
            <input type="password" class="form-control {{ $errors->has('password')?'is-invalid':'' }}"
                   autocomplete="new-password" placeholder="{{ __('fields.password') }}" name="password">
            @if ($errors->has('password'))
                <span class="invalid-feedback">
            <strong>{{ $errors->first('password') }}</strong>
        </span>
            @endif
        </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <button class="w-100 btn btn-primary btn-pill btn-lg" type="submit">@lang('general.login')</button>
            </div>
        </div>
        <div class="row justify-content-center align-items-center">
                <div class="mr-1">
                    <a class="btn btn-link px-0" href="{{ url('/password/reset') }}">
                        {{ __('general.forgot_password') }}
                    </a>
                </div>
                <h3 class="separator-point">·</h3>
                <div class="ml-1">
                    <a class="btn btn-link px-0" href="{{ url('/register') }}">
                        {{ __('general.register') }} {{ __('general.in_app') }}
                    </a>
                </div>
        </div>
    </form>

@endsection
