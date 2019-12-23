@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="mt-2 col-md-12 col-sm-12 col-xs-12 mt-12 justify-content-center text-center">
            <h5>Você está quase lá. O próximo passo é selecionar a modalidade de curso desejada.
            </h5>
        </div>
        <div class="col-md-6 col-sm-8 col-xs-12 mt-3">
            <div class="card">
                @include('cursos.presencial.pos.index')
            </div>
        </div>
        <div class="col-md-6 col-sm-8 col-xs-12 mt-3">
            <div class="card">
                @include('cursos.ead.pos.index')
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-3">
        <div class="col-md-6 col-sm-8 col-xs-12 mt-3">
            <div class="card">
                @include('cursos.ead.extensao.index')
            </div>
        </div>
    </div>
</div>
@endsection