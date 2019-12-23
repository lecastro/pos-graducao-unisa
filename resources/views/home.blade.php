@extends('layouts.app')

@section('style')
<style>
</style>
@endsection

@section('content')
<div class="container">
    <div class="jumbotron">
        <h3 class="display-5">Prezado (a), {{ auth()->user()->name }}</h3>
        <p class="lead">Seja bem-vindo ao Portal Acadêmico da Pós-Graduação e Extensão da Universidade Santo Amaro – Unisa.
        </p>
        <hr class="my-4">
        {{--<p>Para acessar o ambiente de aulas, clique o botão abaixo.</p>
        <a class="btn btn-primary btn-lg" href="#" role="button">Boa aula!</a>--}}
    </div>
</div>
@endsection

@section('script')
<script>
</script>
@endsection