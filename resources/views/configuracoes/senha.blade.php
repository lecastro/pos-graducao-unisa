@extends('layouts.app')

@section('content')
<div class="container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Alterar minha senha</div>
                    <div class="card-body">
                        <form action="{{ url('update/senha') }}" method="POST">
                            @csrf
                            <input type="hidden" name="_method" value="patch">

                            <!-- atual Senha -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-right">{{ __('Senha Atual *') }}</label>
                                <div class="col-md-7">
                                    <input class="form-control @error('currentPassword') is-invalid @enderror"
                                        name="currentPassword" required autocomplete="currentPassword" type="password"
                                        name="currentPassword">
                                    @error('currentPassword')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Senha -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-right">{{ __('Nova Senha *') }}</label>
                                <div class="col-md-7">
                                    <input class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password" type="password" name="password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Nova Senha -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-right">{{ __('Confirmar Senha *') }}</label>
                                <div class="col-md-7">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                    @error('password-confirm')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- importando os alerts --}}
                            @include('mensagens')

                            <!-- Submit Button -->
                            <div class="form-group row text-right">
                                <div class="col-md-9 ml-md-auto">
                                    <button type="submit" class="btn btn-success">Salvar nova senha</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
