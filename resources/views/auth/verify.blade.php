@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Verifique sua caixa de entrada do e-mail cadastrado') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('E-mail com link de redefinição enviado') }}
                    </div>
                    @endif

                    {{ __('E-mail de confirmação enviado!') }} <br>

                    {{ __('Se você não recebeu o e-mail') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit"
                            class="btn btn-link p-0 m-0 align-baseline">{{ __('reenviar e-mail') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
