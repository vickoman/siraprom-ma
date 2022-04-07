@extends('layouts.app')

@section('content')
<div class="container h_80 d-flex align-items-center col-12
">
    <div class="row justify-content-center col-12">
        <div class="col-md-6 login_left d-flex align-items-center">
            <div class="col-12">
                <img src="https://twm.ec/wp-content/uploads/2021/11/LOGOWEB-01.png">
                <h2>SIREPROM</h2>
                <h4>Sistema de Registro de Proyectos Multimedia</h4>
</div>
        </div>
        <div class="col-md-6 bg_login d-flex align-items-center"> 
            <div class="reset_pass align-middle col-12">
                <div class="card-header"><h3>{{ __('Resetear Password') }}</h3></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Enviar link de Reinicio de Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
