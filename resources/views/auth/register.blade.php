@extends('auth.app')

@section('content')

    <form class="text-center justify-content-center mt-4" method="post" action="{{ url('/register') }}">
        @csrf
        <h1 class="mb-4">@lang('general.register') @lang('general.in_app')</h1>
        <!-- <p class="text-muted">Create your account</p> -->
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 input-group input-group-lg mb-3">
                <div class="input-group-prepend">
            <span class="input-group-text">
                <i class="icon-user"></i>
            </span>
                </div>
                <input type="text" class="form-control {{ $errors->has('name')?'is-invalid':'' }}" name="name"
                       value="{{ old('name') }}" placeholder="{{ __('fields.name') }}">
                @if ($errors->has('name'))
                    <span class="invalid-feedback">
            <strong>{{ $errors->first('name') }}</strong>
        </span>
                @endif
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 input-group input-group-lg mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">@</span>
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
            <div class="col-lg-6 col-md-8 input-group input-group-lg mb-3">
                <div class="input-group-prepend">
            <span class="input-group-text">
                <i class="icon-lock"></i>
            </span>
                </div>
                <input type="password" class="form-control {{ $errors->has('password')?'is-invalid':''}}"
                       name="password" placeholder="{{ __('fields.password') }}">
                @if ($errors->has('password'))
                    <span class="invalid-feedback">
            <strong>{{ $errors->first('password') }}</strong>
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
                <input type="password" name="password_confirmation" class="form-control" autocomplete="new-password"
                       placeholder="{{ __('fields.password_confirmation') }}">
                @if ($errors->has('password_confirmation'))
                    <span class="help-block">
            <strong>{{ $errors->first('password_confirmation') }}</strong>
        </span>
                @endif
            </div>
        </div>
        <div class="row justify-content-center mb-1">
            <div class="col-lg-6 ">
                <button class="w-100 btn btn-primary btn-pill btn-lg" type="submit">@lang('general.register')</button>
            </div>
        </div>
        <a href="{{ url('/login') }}" class="text-center">
            @lang('general.has_account')
        </a>
    </form>

@endsection

@push('scripts')
    @include('admin.layouts.partials.validators', ['empty_options'=>true])
@endpush
