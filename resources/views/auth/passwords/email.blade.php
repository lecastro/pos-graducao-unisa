@extends('layouts.app')

{{-- @section('breadcrumbs')
<div class="row justify-content-center">
    <div class="col-md-8">
        {{ Breadcrumbs::render('auth.reset')}}
</div>
</div>
@endsection --}}

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Esqueci minha senha') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @else
                    <p style="color:#212529" class="text-center">Vamos ajudar você a recuperar sua senha.</p>
                    <p style="color:#212529" class="text-center">Informe o número do seu CPF ou e-mail. Enviaremos sua senha ao endereço eletrônico cadastrado.</p>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-10">
                                <label for="identity" class="col-form-label">{{ __('E-mail ou CPF') }}</label>
                                <input id="identity" type="text" class="form-control @error('identity') is-invalid @enderror @error('email') is-invalid @enderror @error('num_cpf') is-invalid @enderror" name="identity" value="{{ $identity ?? old('identity') }}" autocomplete="identity">
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

                            <div class="row mt-3">
                                <div class="p-2 text-left">
                                    <a href="{{ route('home') }}" class="btn btn-secondary ">{{ __('Voltar') }}</a>
                                </div>
                                <div class="text-right p-2">
                                    <button type="submit" class="btn btn-primary ml-2">
                                        {{ __('Redefinir senha') }}
                                    </button>
                                </div>
                                
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection