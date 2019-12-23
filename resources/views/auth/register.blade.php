@extends('layouts.app')

{{-- @section('breadcrumbs')
<div class="row justify-content-center">
    <div class="col-md-8">
        {{ Breadcrumbs::render('auth.register')}}
</div>
</div>
@endsection --}}


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Registre-se') }}</div>

                <div class="card-body">
                    <form id="frm_create" method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-10">
                                <label for="num_cpf" class="col-form-label">{{ __('CPF *') }}</label>
                                <input id="num_cpf" type="text"
                                    class="form-control mask_cpf @error('num_cpf') is-invalid @enderror" name="num_cpf"
                                    value="{{ old('num_cpf') }}" required autocomplete="cpf">

                                @error('num_cpf')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="col-12 col-md-10">
                                <label for="name" class="col-form-label">{{ __('Nome *') }}</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" required autocomplete="name">

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="col-12 col-md-10">
                                <label for="email" class="col-form-label">{{ __('E-mail *') }}</label>
                                <input required id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="col-12 col-md-10">
                                <label for="email_confirm" class="col-form-label">{{ __('Confirmar E-mail *') }}</label>
                                <input required id="email_confirm" type="email" class="form-control" name="email_confirmation">

                                @error('email_confirm')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="col-12 col-md-10">
                                <label for="num_telefone" class="col-form-label">{{ __('Telefone celular *') }}</label>
                                <input required id="num_telefone" type="text"
                                    class="mask_telefone form-control @error('num_telefone') is-invalid @enderror"
                                    name="num_telefone" value="{{ old('num_telefone') }}" autocomplete="telefone">

                                @error('num_telefone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="col-12 col-md-10">
                                <label for="password" class="col-form-label">{{ __('Senha *') }}</label>
                                <input id="password" type="password" data-toggle="tooltip" data-placement="top"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="new-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            {{-- title="A senha deve ter mínimo de oito caracteres e mesclar letras maiúsculas e minúsculas, números e caracteres especiais" --}}
                            <div class="col-12 col-md-10">
                                <label for="password-confirm"
                                    class="col-form-label">{{ __('Confirmar senha *') }}</label>
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">
                                @error('password-confirm')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="col-12 col-md-10 mt-4">
                                <div class="btn-toolbar justify-content-between" role="toolbar"
                                    aria-label="Toolbar com grupos de botões">
                                    <div class="btn-group" role="group" aria-label="Primeiro grupo">
                                        <a href="{{ route('home') }}"
                                            class="btn btn-secondary btn-block">{{ __('Voltar') }}</a>

                                    </div>
                                    <div class="input-group">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            {{ __('Enviar dados')  }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                </form>
                {{-- modal que ajuda na força da senha --}}

                {{-- <div class="pswd_info">
                    <ul>
                        <li id="letter">Pelo menos uma letra minúscula</li>
                        <li id="capital">Pelo menos uma letra maiúscula</li>
                        <li id="number">Pelo menos um numero</li>
                        <li id="specialCharacters">Pelo menos um caractere especial</li>
                        <li id="length">Pelo menos oito caracteres de comprimento</li>
                    </ul>
                </div> --}}
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@section('script')
{{-- <script src="{{ asset('js/ForcePassword.js') }}"></script> --}}
@endsection
