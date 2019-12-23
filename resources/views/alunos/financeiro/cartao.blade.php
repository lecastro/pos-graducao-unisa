@extends('layouts.app')

@section('style')

@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('aluno.financeiro.cartao') }}
@endsection

@section('content')
    <div class="container-fluid">
        @foreach($titulos as $index_titulo => $titulo)
            <div class="mb-4 mt-4 col-md-12 col-sm-12 col-xs-12 mt-12 justify-content-center text-center">
                <h6>
                    Pagamento com cartão
                </h6>
            </div>
            <div class="col-sm-12 mb-3">
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
                            <div class="col-sm-6">
                                <a href="{{ route('aluno.financeiro.index') }}" class="card-link btn btn-info">VOLTAR</a>
                            </div>
                            <div class="col-sm-6">
                                <a  id="btn-cartao"
                                    title="{{ $botao_cartao_title }}"
                                    class="card-link btn btn-info {{ ($titulo->val_saldo == 0) ? 'disabled' : 'pay-button-getnet' }}"
                                    data-cod-ra="{{ $titulo->ra }}"
                                    data-cod-titulo="{{ $titulo->cod_titulo }}"
                                    data-qtd-parcelas="1"
                                    data-valor-corrigido="{{ number_format($titulo->val_saldo+$titulo->val_juros+$titulo->val_multa-$titulo->val_desconto, 2, ',', '.') }}"
                                    data-cod-titulos="{{ $titulo->cod_titulo }}"
                                    data-cod-login="{{ getLoginName($titulo->ra) }}"
                                    {{ $botao_cartao_disabled }} >PAGAR</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('script')
    @foreach($dados_titulo_get_net as $index_titulo => $titulo)
        <script async src="{{ $url_js }}"
                data-getnet-sellerid="{{ $seller_id }}"
                data-getnet-token="{{ $token_type }} {{ $access_token }}"
                data-getnet-payment-methods-disabled='["debito", "boleto"]'
                data-getnet-amount="{{ money_format('%.2n', $titulo->val_saldo+$titulo->val_juros+$titulo->val_multa-$titulo->val_desconto) }}"
                data-getnet-customerid="{{ $titulo->cod_ra }}"
                data-getnet-orderid="{{ $titulo->cod_titulo }}"
                data-getnet-button-class="pay-button-getnet"
                data-getnet-installments="1"
                data-getnet-boleto-expiration-date="{{ $titulo->dat_vencimento }}"
                data-getnet-customer-first-name="{{ $titulo->primeiro_nom_aluno }}"
                data-getnet-customer-last-name="{{ $titulo->ultimo_nom_aluno }}"
                data-getnet-customer-document-type="CPF"
                data-getnet-customer-document-number="{{ $titulo->num_cpf }}"
                data-getnet-customer-email="{{ $titulo->dsc_end_e_mail }}"
                data-getnet-customer-phone-number="{{ $titulo->tel }}"
                data-getnet-customer-address-street="{{ $titulo->end_logr_aluno }}"
                data-getnet-customer-address-street-number="{{ $titulo->end_num_aluno }}"
                data-getnet-customer-address-complementary="{{ $titulo->end_compl_aluno }}"
                data-getnet-customer-address-neighborhood="{{ $titulo->end_bairro_aluno }}"
                data-getnet-customer-address-city="{{ $titulo->end_localid_aluno }}"
                data-getnet-customer-address-state="{{ $titulo->end_uf_aluno }}"
                data-getnet-customer-address-zipcode="{{ $titulo->end_cep_aluno }}"
                data-getnet-customer-country="{{ $titulo->nom_pais_por }}"
                data-getnet-items='[{"name": "Titulo", "description": "Titulo {{ $titulo->cod_ra }}", "value": {{ $titulo->val_saldo+$titulo->val_juros+$titulo->val_multa-$titulo->val_desconto }}, "quantity": 1, "sku": "{{ $titulo->cod_titulo }}"}]'
                data-getnet-url-callback="">
        </script>
        <script>
            function loadIframe () {

                const codRa = $(this).data("codRa");
                const codTitulo = $(this).data("codTitulo");
                const qtdParcelas = $(this).data("qtdParcelas");
                const valorCorrigido = $(this).data("valorCorrigido");
                const codTitulos = $(this).data("codTitulos");
                const codLogin = $(this).data("codLogin");

                $.ajax({
                    url : "{{ route('aluno.financeiro.inicia.log') }}",
                    type : "post",
                    data : {
                        _token         : "{{ csrf_token() }}",
                        codRa          : codRa,
                        codTitulo      : codTitulo,
                        qtdParcelas    : qtdParcelas,
                        valorCorrigido : valorCorrigido,
                        codTitulos     : codTitulos,
                        codUsuario     : codLogin
                    },
                    beforeSend : function(){
                        console.log("Registrando inicio de log!");
                    }
                }).done(function(msg){
                    (msg[0].data === "success") ? console.log("Inicio de log registrado!") : console.log("Inicio de log não registrado!");
                }).fail(function(jqXHR, textStatus, msg){
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(msg);
                    alert("Erro ao registrar log de transação com cartão de credito!");
                    return;
                });

                getnetIfrm = document.getElementById("getnet-checkout");

                getnetIfrm.addEventListener("load", ev => {
                    // Funções compatíveis com IE e outros navegadores
                    var eventMethod = (window.addEventListener ? "addEventListener" : "attachEvent");
                    var eventer = window[eventMethod];
                    var messageEvent = (eventMethod === "attachEvent") ? "onmessage" : "message";

                    // Ouvindo o evento do loader
                    eventer(messageEvent, function iframeMessage(e) {
                        var data = e.data || "";

                        switch (data.status || data) {
                            // Corfirmação positiva do checkout.
                            case "success":
                                console.log("Transação realizada.");
                                $("#btn-cartao").attr("disabled", "disabled");
                                $("#btn-cartao").attr("title", "Aguardando confirmação");
                                $.ajax({
                                    url : "{{ route('aluno.financeiro.finalizar.pagamento') }}",
                                    type : "post",
                                    data : {
                                        _token         : "{{ csrf_token() }}",
                                        codRa          : codRa,
                                        codTitulo      : codTitulo,
                                        qtdParcelas    : qtdParcelas,
                                        valorCorrigido : valorCorrigido,
                                        codTitulos     : codTitulos,
                                        codUsuario     : codLogin
                                    },
                                    beforeSend : function(){
                                        console.log("Registrando inicio de log!");
                                    }
                                }).done(function(msg){
                                    (msg[0].data === "success") ? console.log("Inicio de log registrado!") : console.log("Inicio de log não registrado!");
                                }).fail(function(jqXHR, textStatus, msg){
                                    console.log(jqXHR);
                                    console.log(textStatus);
                                    console.log(msg);
                                    alert("Erro ao registrar log de transação com cartão de credito!");
                                    return;
                                });
                                break;

                            // Notificação de que o IFrame de checkout foi fechado a aprovação.
                            case "close":
                                console.log("Checkout fechado.");
                                window.location.reload();
                                break;

                            // Notificação que um boleto foi registrado com sucesso
                            case "pending":
                                console.log("Boleto registrado e pendente de pagamento");
                                console.log(data.detail);
                                break;

                            // Notificação que houve um erro na tentativa de pagamento
                            case "error":
                                console.warn(data.detail.message);
                                break;

                            // Ignora qualquer outra mensagem
                            default:
                                break;
                        }
                    }, false);
                });
            };
            $(document).on("click", ".pay-button-getnet", loadIframe);
        </script>
    @endforeach
@endsection
