@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-8 form-group">
                                <label for="identity" class="col-form-label">{{ __('E-mail ou CPF *') }}</label>
                                <input id="identity" type="text"
                                    class="form-control @error('identity') is-invalid @enderror @error('email') is-invalid @enderror @error('num_cpf') is-invalid @enderror"
                                    name="identity" value="{{ old('identity') }}" autocomplete="identity">

                                @error('identity')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                @error('num_cpf')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="col-12 col-md-8 form-group">
                                <label for="password" class="col-form-label">{{ __('Senha *') }}</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="col-12 col-md-8">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Permanecer logado') }}
                                    </label>
                                </div>
                            </div>

                            <div class="col-12 col-md-8 mt-4">
                              
                                <button type="submit" class="btn btn-primary btn-block">
                                    {{ __('Acessar o Portal') }}
                                </button> 
                            </div>
                        </div>
                    </form>

                    @if (Route::has('password.request'))
                    <hr>
                    <div class="row justify-content-center">
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Esqueci minha senha') }}
                        </a>
                        <a class="btn btn-link" href="{{ route('register') }}">Não tem conta? Registre-se</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
