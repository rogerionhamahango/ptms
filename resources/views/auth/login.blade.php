@extends('adminlte::auth.auth-page')

@section('auth_header')
    <h1 class="text-center">
        <b>PTMS</b>
    </h1>

    <p class="text-center text-muted">
        Production and Technical Management System
    </p>
@stop

@section('auth_body')

    <form action="{{ route('login') }}" method="POST">
        @csrf

        {{-- Email --}}
        <div class="input-group mb-3">
            <input
                type="email"
                name="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}"
                placeholder="Email"
                required
                autofocus
            >

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>


        {{-- Senha --}}
        <div class="input-group mb-3">
            <input
                type="password"
                name="password"
                class="form-control @error('password') is-invalid @enderror"
                placeholder="Senha"
                required
            >

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>


        {{-- Entrar --}}
        <div class="row">
            <div class="col-12">
                <button
                    type="submit"
                    class="btn btn-danger btn-block"
                >
                    <i class="fas fa-sign-in-alt"></i>
                    Entrar
                </button>
            </div>
        </div>
         <div class="social-auth-links text-center mt-2 mb-3">
       
      </div>
      <!-- /.social-auth-links -->

      <p class="mb-1">
        <a href="{{ route('recoverPassword') }}">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="#" class="text-center">Register a new membership</a>
      </p>

    </form>

@stop