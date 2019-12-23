@extends('layouts.app')

@section('style')
@endsection


@section('breadcrumbs')
{{ Breadcrumbs::render('candidato.show', encrypt(auth()->user()->num_cpf))}}
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table id="table" class="table table-responsive-sm" data-toggle="table" data-pagination="true" data-search="true" data-mobile-responsive="true" data-checkOnInit="true">
                    <thead>
                        <tr>
                            <th>Inscrição</th>
                            <th data-sortable="true">Tipo</th>
                            <th>Curso</th>
                            <th>Links úteis</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inscricoes as $inscricao)
                        <tr>
                            <td>{{ $inscricao->cod_inscricao }}</td>
                            <td>{{ $inscricao->nom_niv_ens }}</td>
                            <td data-placement="bottom" data-toggle="tooltip" title="{{ $inscricao->nom_campus }}">{{ $inscricao->nom_curso_ps }}</td>
                            <td>
                                <a class="btn mb-1  btn-sm btn-primary" target="_blank" id="" href="{{env('METODO_URL_PLS_PRD')}}pw_secretaria.exibeContratoMatricula?codpag=9055&pcodinscr={{ $inscricao->cod_inscricao }}" role="button">Requerimento
                                </a>
                                <a class="btn mb-1  btn-sm btn-secondary" target="_blank" id="" href="{{env('METODO_URL')}}imagens_inscricao_processos_seletivos/pos/Contrato_de_Prestacao_de_Servico_POS_2017.pdf" role="button">Contrato
                                </a>
                                <a class="btn mb-1 btn-sm btn-success" target="_blank" id="" href="{{env('METODO_URL_PLS_PRD')}}pw_secretaria.exibeContratoMatricula?codpag=9056&pcodinscr={{$inscricao->cod_inscricao}}" role="button">Anexo
                                </a>
                                <a class="btn mb-1  btn-sm btn-warning" target="_blank" id="" href="{{env('METODO_URL_PLS_PRD')}}pw_boleto.imprimeBoleto?codPag=1962&codRa={{ getRaAluno(auth()->user()->num_cpf) }}&codTitulo={{ $inscricao->cod_titulo }}" role="button">Boleto
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/bootstrap-table-mobile.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-table-pt-PT.min.js') }}"></script>
<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
@endsection