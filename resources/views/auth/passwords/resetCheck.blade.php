@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Redefinir senha') }}</div>

                <div class="card-body">
                @if (session('senha'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Senha redefinida com sucesso!') }}
                        </div>
                    @endif
                    <form id="frm_reset" method="POST" action="{{ route('candidato.alterarSenha') }}">
                        @csrf


                        <div class="form-group row">
                            <label for="password_old" class="col-md-4 col-form-label text-md-right">{{ __('Senha atual') }}</label>

                            <div class="col-md-6">
                                <input id="password_old" type="password" class="form-control @error('password_old') is-invalid @enderror" name="password_old" value="{{ $password_old ?? old('password_old') }}" required autocomplete="password_old" autofocus>

                                @error('password_old')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Nova senha') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirmar nova senha') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Redefinir senha') }}
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
