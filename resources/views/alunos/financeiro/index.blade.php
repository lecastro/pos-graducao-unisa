@extends('layouts.app')

@section('style')

@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('aluno.financeiro.index') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="mb-4 mt-4 col-md-12 col-sm-12 col-xs-12 mt-12 justify-content-center text-center">
            <h6>
                @if($ra)
                    {{ $ra }} - {{ $nome_aluno }}
                @endif
            </h6>
        </div>
        <form name="form_filtro" id="i_form_filtro" action="{{ route('aluno.financeiro.index') }}" method="get">
            <div class="row mb-3">
                <div class="col-sm-4"></div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text border-0">
                                <input type="radio" id="i_filtro_todas" name="filtro" aria-label="Todas" value="1" onClick="this.form.submit();" {{ ($filtro == '1') ? 'checked': '' }}>
                                <label class="form-check-label" for="i_filtro_todas">Todas</label>
                            </div>
                            <div class="input-group-text border-0">
                                <input type="radio" id="i_filtro_a_vencer" name="filtro" aria-label="A Vencer" value="2" onClick="this.form.submit();" {{ ($filtro == '2') ? 'checked': '' }}>
                                <label class="form-check-label" for="i_filtro_a_vencer">A Vencer</label>
                            </div>
                            <div class="input-group-text border-0">
                                <input type="radio" id="i_filtro_vencidas" name="filtro" aria-label="Vencidas" value="3" onClick="this.form.submit();" {{ ($filtro == '3') ? 'checked': '' }}>
                                <label class="form-check-label" for="i_filtro_vencidas">Vencidas</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4"></div>
            </div>
        </form>
        <div class="row">
            @if($titulos->count() === 0)
                <div class="col-sm-12 mb-3 text-center">
                    <h6>Não há boletos para esse filtro!</h6>
                </div>
            @endif
            @foreach($titulos as $index_titulo => $titulo)
                <div class="col-sm-6 mb-3">
                    <div class="card border-dark mb-3">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm-6 text-left">
                                    Boleto - {{ $titulo->cod_titulo }}
                                </div>
                                <div class="col-sm-6 text-right">
                                    @if($titulo->val_saldo == 0)
                                        Pago
                                    @else
                                        Em aberto
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="card-body text-dark">
                            <div class="row">
                                <div class="col-sm-6 text-left border-right">
                                    <p>Referente à {{ ($titulo->dat_vencimento) ? \Carbon\Carbon::parse($titulo->dat_vencimento)->translatedFormat('F/y') : '' }}</p>
                                    <p>Vencimento: {{ ($titulo->dat_vencimento) ? \Carbon\Carbon::parse($titulo->dat_vencimento)->translatedFormat('d/m/Y'): '' }}</p>
                                    <p>Pago em: {{ ($titulo->dat_pagamento) ? \Carbon\Carbon::parse($titulo->dat_pagamento)->translatedFormat('d/m/Y'): '' }}</p>
                                </div>

                                <div class="col-sm-6 text-right align-self-center">
                                    <h3>{{ money_format('R$ %.2n', $titulo->val_saldo) }}</h3>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="row text-center">
                                <div class="col-sm-4">
                                    <a  href="#"
                                        id="btn-modal"
                                        class="card-link btn btn-info"
                                        data-cod-titulo="{{ $titulo->cod_titulo }}"
                                        data-ano-titulo="{{ $titulo->ano_titulo }}"
                                        data-mes-titulo="{{ $titulo->mes_titulo }}"
                                        data-qtd-parcela="{{ $titulo->qtd_parcela }}"
                                        data-dat-emissao="{{ ($titulo->dat_emissao) ? \Carbon\Carbon::parse($titulo->dat_emissao)->translatedFormat('d/m/Y') : '' }}"
                                        data-dat-vencimento="{{ ($titulo->dat_vencimento) ? \Carbon\Carbon::parse($titulo->dat_vencimento)->translatedFormat('d/m/Y') : '' }}"
                                        data-ano-mes-vencimento="{{ $titulo->ano_mes_vencimento }}"
                                        data-dat-pagamento="{{ ($titulo->dat_pagamento) ? \Carbon\Carbon::parse($titulo->dat_pagamento)->translatedFormat('d/m/Y') : '' }}"
                                        data-val-titulo="{{ ($titulo->val_titulo) ? money_format('R$ %.2n', $titulo->val_titulo) : 0 }}"
                                        data-val-recebido="{{ ($titulo->val_recebido) ? money_format('R$ %.2n', $titulo->val_recebido) : 0 }}"
                                        data-val-saldo="{{ ($titulo->val_saldo) ? money_format('R$ %.2n', $titulo->val_saldo) : 0 }}"
                                        data-num-tit-bco="{{ $titulo->num_tit_bco }}"
                                        data-cod-contrato="{{ $titulo->cod_contrato }}"
                                        data-cod-especie-titulo="{{ $titulo->cod_especie_titulo }}"
                                        data-ind-status="{{ $titulo->ind_status }}"
                                        data-ano-mes-inicio="{{ $titulo->ano_mes_inicio }}"
                                        data-ano-mes-titulo="{{ $titulo->ano_mes_titulo }}"
                                        data-cod-campus="{{ $titulo->cod_campus }}"
                                        data-cod-curso="{{ $titulo->cod_curso }}"
                                        data-nom-curso-abrev="{{ $titulo->nom_curso_abrev }}"
                                        data-cod-modalidade-ensino="{{ $titulo->cod_modalidade_ensino }}"
                                        data-turno="{{ $titulo->turno }}"
                                        data-nom-campus-abrev="{{ $titulo->nom_campus_abrev }}"
                                        data-dsc-especie-titulo="{{ $titulo->dsc_especie_titulo }}"
                                        data-cod-portador-bco="{{ $titulo->cod_portador_bco }}"
                                        data-ra="{{ $titulo->ra }}"
                                        data-first-name="{{ $titulo->first_name }}"
                                        data-last-name="{{ $titulo->last_name }}"
                                        data-rg="{{ $titulo->rg }}"
                                        data-email="{{ $titulo->email }}"
                                        data-val-juros="{{ ($titulo->val_juros) ? $titulo->val_juros : 0 }}"
                                        data-val-multa="{{ ($titulo->val_juros) ? $titulo->val_multa : 0 }}"
                                        data-val-desconto="{{ ($titulo->val_saldo) ? money_format('R$ %.2n', $titulo->val_desconto) : 0 }}"
                                        data-toggle="modal"
                                        data-target="#modalBoletoDetalhes">DETALHES</a>
                                </div>
                                <div class="col-sm-4">
                                    <a href="{{ route('aluno.financeiro.cartao', $titulo->cod_titulo) }}" class="card-link btn btn-info {{ ($titulo->val_saldo == 0) ? 'disabled' : '' }}">CARTÃO</a>
                                </div>
                                <div class="col-sm-4">
                                    <a href="{{ ($titulo->val_saldo == 0) ? '#' : env('METODO_URL_PLS_PRD').'pw_boleto.imprimeBoleto?codPag=1962&codRa='.$titulo->ra.'&codTitulo='.$titulo->cod_titulo }}" class="card-link btn btn-info {{ ($titulo->val_saldo == 0) ? 'disabled' : '' }}" target="_blank">BOLETO</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
                {{ $titulos->links() }}
            </div>
            <div class="col-sm-4"></div>
        </div>
    </div>
@endsection

@section('modal')
    <!-- Modal -->
    <div class="modal fade" id="modalBoletoDetalhes" role="dialog" aria-labelledby="modalBoletoDetalhesLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalBoletoDetalhesLabel"><span id="iCodigoTitulo"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <th class="text-left">Parcela</th>
                            <td><span id="iParcela"></span></td>
                        </tr>
                        <tr>
                            <th class="text-left">Emissão</th>
                            <td><span id="iEmissao"></span></td>
                        </tr>
                        <tr>
                            <th class="text-left">Vencimento</th>
                            <td><span id="iVencimento"></span></td>
                        </tr>
                        <tr>
                            <th class="text-left">Valor Titulo</th>
                            <td><span id="iValorTitulo"></span></td>
                        </tr>
                        <tr>
                            <th class="text-left">Pago</th>
                            <td><span id="iPago"></span></td>
                        </tr>
                        <tr>
                            <th class="text-left">Data Pagamento</th>
                            <td><span id="iDataPagamento"></span></td>
                        </tr>
                        <tr>
                            <th class="text-left">Saldo</th>
                            <td><span id="iSaldo"></span></td>
                        </tr>
                        <tr>
                            <th class="text-left">Desconto/Bolsa</th>
                            <td><span id="iDescontoBolsa"></span></td>
                        </tr>
                        <tr>
                            <th class="text-left">Multa/Juros</th>
                            <td><span id="iMultaJuros"></span></td>
                        </tr>
                        <tr>
                            <th class="text-left">Campus</th>
                            <td><span id="iCampus"></span></td>
                        </tr>
                        <tr>
                            <th class="text-left">Curso</th>
                            <td><span id="iCurso"></span></td>
                        </tr>
                        <tr>
                            <th class="text-left">Especie Titulo</th>
                            <td><span id="iEspecieTitulo"></span></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Voltar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function loadData(){
            window.document.querySelector("span#iCodigoTitulo").innerHTML  = $(this).data("codTitulo");
            window.document.querySelector("span#iParcela").innerHTML       = $(this).data("qtdParcela");
            window.document.querySelector("span#iEmissao").innerHTML       = $(this).data("datEmissao");
            window.document.querySelector("span#iVencimento").innerHTML    = $(this).data("datVencimento");
            window.document.querySelector("span#iValorTitulo").innerHTML   = $(this).data("valTitulo");
            window.document.querySelector("span#iPago").innerHTML          = ($(this).data("valRecebido")) == 0 ? 'R$ ' + ($(this).data("valRecebido")) : ($(this).data("valRecebido")) ;
            window.document.querySelector("span#iDataPagamento").innerHTML = $(this).data("datPagamento");
            window.document.querySelector("span#iSaldo").innerHTML         = $(this).data("valSaldo");
            window.document.querySelector("span#iDescontoBolsa").innerHTML = $(this).data("valDesconto");
            window.document.querySelector("span#iMultaJuros").innerHTML    = ($(this).data("valMulta")+$(this).data("valJuros")) == 0 ? 'R$ '+($(this).data("valMulta")+$(this).data("valJuros")) : ($(this).data("valMulta")+$(this).data("valJuros"));
            window.document.querySelector("span#iCampus").innerHTML        = $(this).data("codCampus") + " - " + $(this).data("nomCampusAbrev");
            window.document.querySelector("span#iCurso").innerHTML         = $(this).data("codCurso")  + " - " + $(this).data("nomCursoAbrev");
            window.document.querySelector("span#iEspecieTitulo").innerHTML = $(this).data("dscEspecieTitulo");
        }
        $(document).on("click", "#btn-modal", loadData);
    </script>
@endsection
