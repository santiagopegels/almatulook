@extends('auth.app')

@section('content')
    <form class="text-center justify-content-center mt-4" method="post" action="{{ url('/password/email') }}">
        @csrf
        <h1>Recuperar Contraseña</h1>
        <p class="text-muted">Ingresa tu Email para recuperar la contraseña</p>
        <div class="row justify-content-center">
        <div class="col-lg-6 input-group input-group-lg mb-3">
            <div class="input-group-prepend">
                                    <span class="input-group-text">
                                      <i class="icon-user"></i>
                                    </span>
            </div>
            <input type="email" class="form-control {{ $errors->has('email')?'is-invalid':'' }}" name="email"
                   value="{{ old('email') }}"
                   placeholder="Email">
            @if ($errors->has('email'))
                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
            @endif
        </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-6 ">
                <button class="w-100 btn btn-primary btn-pill btn-lg" type="submit">
                    <i class="fa fa-btn fa-envelope"></i> Enviar Email de Recuperación
                </button>
            </div>
        </div>
    </form>
@endsection
