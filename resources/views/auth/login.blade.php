@extends('auth.app')

@section('content')

    <form method="post" action="{{ url('/login') }}">
        @csrf
        <h1 class="mb-4">@lang('general.login')</h1>
        <!-- <p class="text-muted">Sign In to your account</p> -->
        <div class="input-group mb-3">
            <div class="input-group-prepend">
            <span class="input-group-text">
                <i class="icon-user"></i>
            </span>
            </div>
            <input type="email" class="form-control {{ $errors->has('email')?'is-invalid':'' }}" name="email" value="{{ old('email') }}" placeholder="{{ __('fields.email') }}">
            @if ($errors->has('email'))
                <span class="invalid-feedback">
            <strong>{{ $errors->first('email') }}</strong>
        </span>
            @endif
        </div>
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text">
                <i class="icon-lock"></i>
            </span>
            </div>
            <input type="password" class="form-control {{ $errors->has('password')?'is-invalid':'' }}" autocomplete="new-password" placeholder="{{ __('fields.password') }}" name="password">
            @if ($errors->has('password'))
                <span class="invalid-feedback">
            <strong>{{ $errors->first('password') }}</strong>
        </span>
            @endif
        </div>
        <div class="row">
            <div class="col-lg-12">
                <button class="btn btn-primary btn-block px-4" type="submit">@lang('general.login')</button>
            </div>
            <div class="col-lg-12 d-block d-sm-none">
                <a class="btn btn-link px-0" href="{{ url('/register') }}">
                    {{ __('general.not_has_account') }} {{ __('general.register') }}
                </a>
            </div>
            <div class="col-lg-12">
                <a class="btn btn-link px-0" href="{{ url('/password/reset') }}">
                    {{ __('general.forgot_password') }}
                </a>
            </div>
        </div>
    </form>

@endsection

@push('scripts')
    {{-- @include('admin.layouts.partials.validators', ['empty_options'=>true]) --}}
@endpush
