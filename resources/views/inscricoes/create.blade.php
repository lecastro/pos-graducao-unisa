@extends('layouts.app')

@section('breadcrumbs')
{{ Breadcrumbs::render('inscricoes.create')}}
@endsection

@section('style')

<style>
    .select-box-readonly {
        background: #eee;
        /*Simular campo inativo - Sugestão @GabrielRodrigues*/
        pointer-events: none;
        touch-action: none;
    }


    .swal2-backdrop-show{
    overflow-y: visible !important;
}

    .li-candidato {
        padding-bottom: 15px;
    }

    #txt-candidato {
        font-family: inherit;
        font-size: 15px;
        font-weight: normal;
        line-height: normal;
        color: inherit
    }

    .wizard {
        margin: 20px auto;
        background: #fff;
    }

    .wizard .nav-tabs {
        position: relative;
        margin: 20px auto;
        margin-bottom: 0;
        border-bottom-color: #e0e0e0;
    }

    .wizard>div.wizard-inner {
        position: relative;
    }

    .connecting-line {
        height: 2px;
        background: #e0e0e0;
        position: absolute;
        width: 100%;
        margin: 0 auto;
        left: 0;
        right: 0;
        top: 50%;
        z-index: 1;
    }

    .wizard .nav-tabs>li.active>a,
    .wizard .nav-tabs>li.active>a:hover,
    .wizard .nav-tabs>li.active>a:focus {
        color: #555555;
        cursor: default;
        border: 0;
        border-bottom-color: transparent;
    }

    span.round-tab {
        width: 70px;
        height: 70px;
        line-height: 70px;
        display: inline-block;
        border-radius: 100px;
        background: #fff;
        border: 2px solid #e0e0e0;
        z-index: 2;
        position: absolute;
        left: 0;
        text-align: center;
        font-size: 25px;
    }

    span.round-tab i {
        color: #555555;
    }

    .wizard li a.active span.round-tab {
        background: #fff;
        border: 2px solid #5bc0de;

    }

    .wizard li a.active span.round-tab i {
        color: #5bc0de;
    }

    span.round-tab:hover {
        color: #333;
        border: 2px solid #333;
    }

    .wizard .nav-tabs>li {
        width: 20%;
    }

    .wizard li a:after {
        content: " ";
        position: relative;
        left: 46%;
        top: -20px;
        opacity: 0;
        margin: 0 auto;
        bottom: 0px;
        border: 5px solid transparent;
        border-bottom-color: #5bc0de;
        transition: 0.1s ease-in-out;
    }

    .wizard li.active.nav-item:after {
        content: " ";
        position: relative;
        left: 46%;
        top: -20px;
        opacity: 1;
        margin: 0 auto;
        bottom: 0px;
        border: 10px solid transparent;
        border-bottom-color: #5bc0de;
    }

    .wizard .nav-tabs>li a {
        width: 70px;
        height: 70px;
        margin: 20px auto;
        border-radius: 100%;
        padding: 0;
        position: relative;
    }

    .wizard .nav-tabs>li a:hover {
        background: transparent;
    }

    .wizard .tab-pane {
        position: relative;
        padding-top: 10px;
    }

    .wizard h3 {
        margin-top: 0;
    }

    @media(max-width: 585px) {
        .wizard {
            width: 90%;
            height: auto !important;
        }

        span.round-tab {
            font-size: 16px;
            width: 50px;
            height: 50px;
            line-height: 50px;
        }

        .wizard .nav-tabs>li a {
            width: 50px;
            height: 50px;
            line-height: 50px;
        }

        .wizard li.active:after {
            content: " ";
            position: absolute;
            left: 35%;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <form id="frm_step_inscricao" action="" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="_method" value="">
        <input type="hidden" id="step" name="step" value="0">
        <input type="hidden" id="cod_ra" name="cod_ra" value="{{ $candidato->cod_ra }}">
        <input type="hidden" id="modalidade" name="modalidade" value="{{ $modalidade }}">

        <div class="wizard">
            <div class="wizard-inner">
                <div class="connecting-line"></div>
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="nav-item">
                        <a href="#step1" data-toggle="tab" id="a_step1" aria-controls="step1" role="tab" title="Curso" class="nav-link active">
                            <span class="round-tab">
                                <i class="fas fa-graduation-cap"></i>
                            </span>
                        </a>
                    </li>
                    <li role="presentation" class="nav-item">
                        <a href="#step2" data-toggle="tab" id="a_step2" aria-controls="step2" role="tab" title="Dados Pessoais" class="nav-link disabled">
                            <span class="round-tab">
                                <i class="fas fa-user"></i>
                            </span>
                        </a>
                    </li>
                    <li role="presentation" class="nav-item">
                        <a href="#step3" data-toggle="tab" id="a_step3" aria-controls="step3" role="tab" title="Endereço" class="nav-link disabled">
                            <span class="round-tab">
                                <i class="fas fa-map-marked"></i>
                            </span>
                        </a>
                    </li>
                    <li role="presentation" class="nav-item">
                        <a href="#step4" data-toggle="tab" id="a_step4" aria-controls="step4" role="tab" title="Financeiro" class="nav-link disabled">
                            <span class="round-tab">
                                <i class="fas fa-wallet"></i>
                            </span>
                        </a>
                    </li>
                    <li role="presentation" class="nav-item">
                        <a href="#step5" data-toggle="tab" id="a_step5" aria-controls="step5" role="tab" title="Confirmação" class="nav-link disabled">
                            <span class="round-tab">
                                <i class="fas fa-handshake"></i>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="tab-content">
                <div class="tab-pane active" role="tabpanel" id="step1">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-10 form-group">
                            <label class="col-form-label">{{ __('Processo seletivo *') }}</label>
                            <select name="cod_proc_seletivo" id="cod_proc_seletivo" class="form-control col-10" >
                                <option value="">Selecione</option>
                                @foreach ($cods_procs_seletivos as $cod)
                                <option value="{{ $cod->cod_proc_seletivo }}">{{ $cod->dsc_proc_seletivo }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-10 form-group">
                            <label class="col-form-label">{{ __('Curso *') }}</label>
                            <select disabled id="cod_curso_ps" class="form-control col-10" name="cod_curso_ps">
                                <option  value="">Selecione</option>
                            </select>
                        </div>
                        @if($modalidade == 'P' || $cod_niv_ens == 10)
                        <div class="col-12 col-md-10 form-group">
                            <label class="col-form-label">{{ __('Campus *') }}</label>
                            <select disabled class="form-control" id="cod_campus" name="cod_campus">
                                <option value=''>Selecione</option>
                            </select>
                            <div class="col-form-label" id="div-t"></div>
                        </div>
                        @elseif($modalidade == 'D')
                        <div class="col-12 col-md-10 form-group">
                            <label class="col-form-label">{{ __('Polo *') }}</label>
                            <select disabled class="form-control" id="cod_campus" name="cod_campus">
                                <option value=''>Selecione</option>
                            </select>
                            <div class="col-form-label" id="div-t"></div>
                        </div>
                        @endif

                        <div class="col-12 col-md-10 form-group">
                            <label class="col-form-label">{{ __('Como ficou sabendo da Unisa ? *') }}</label>
                            <select class="form-control" name="ind_conhecimento_unisa" id="ind_conhecimento_unisa">
                                <option value=''>Selecione</option>
                                @foreach ($conhecimento as $opcao)
                                <option value="{{ $opcao->cod }}" @if ($candidato->ind_conhecimento_unisa == $opcao->cod) selected @endif >{{ $opcao->dsc }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>

                            <input type="hidden" value="{{ $cod_niv_ens }}" name="cod_niv_ens" id="h_cod_niv_ens">
                        </div>
                    </div>
                    <div class="d-flex bd-highlight mb-3">
                        <div class="ml-auto p-2 bd-highlight">
                            <button type="button" id="btn_step_1" class="btn btn-primary next-step next-button">Próximo</button>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" role="tabpanel" id="step2">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-4 form-group">
                            <label class="col-form-label">{{ __('CPF *') }}</label>
                            <input readonly type="text" id="num_cpf" class="mask_cpf form-control" name="num_cpf" value="{{ auth()->user()->num_cpf }}" autocomplete="num_cpf">
                        </div>

                        <div class="col-12 col-md-6 form-group">
                            <label class="col-form-label">{{ __('Nome *') }}</label>
                            <input id="nom_candidato" type="text" class="form-control" name="nom_candidato" value="{{ auth()->user()->name }}" autocomplete="nom_candidato">
                        </div>

                        <div class="col-12 col-md-5 form-group">
                            <label class="col-form-label">{{ __('E-mail *') }}</label>
                            <input id="emaill" readonly type="email" class="form-control" name="dsc_end_e_mail" value="{{ auth()->user()->email }}" autocomplete="dsc_end_e_mail">
                        </div>

                        <div class="col-12 col-md-2 form-group">
                            <label class="col-form-label">{{ __('Gênero *') }}</label>
                            @php
                            $ind_sexo = ['Masculino', 'Feminino']
                            @endphp
                            <select disabled class="form-control ignoreSelect2" id="ind_sexo" name="ind_sexo">
                                <option value="">Selecione</option>
                                @foreach ($ind_sexo as $key => $value)
                                <option value="{{ $key + 1 }}" @if ($candidato->ind_sexo == $key + 1) selected @endif >{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 col-md-3 form-group">
                            <label class="col-form-label">Data de nascimento *</label>
                            <input type="text" disabled class="form-control mask_date" name="dat_nascimento" value="{{ converteDate($candidato->dat_nascimento) }}" id="dat_nascimento">
                        </div>

                        <div class="col-12 col-md-4 form-group">
                            <label class="col-form-label">{{ __('Telefone celular *') }}</label>
                            <input readonly id="telefonec" type="text" class="mask_telefone form-control" name="telefonec" value="{{ auth()->user()->num_telefone }}" autocomplete="telefone">
                        </div>

                        <div class="col-12 col-md-4 form-group">
                            <label class="col-form-label">{{ __('Telefone fixo *') }}</label>
                            <input id="telefonef" value="{{ $candidato->num_ddd_tel_cand . $candidato->num_tel_cand }}" type="text" disabled class="mask_telefone_fixo form-control" name="telefonef" autocomplete="telefone">
                        </div>

                        <div class="col-12 col-md-2 form-group">
                            <label class="col-form-label">{{ __('Autorizo mensagem') }}</label>
                            <select class="form-control ignoreSelect2" name="ind_aceita_sms" id="ind_aceita_sms" disabled>
                                <option value=''>Selecione</option>
                                <option value="2">SMS</option>
                                <option value="1">Whatsapp</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex bd-highlight mb-3">
                        <div class="p-2 bd-highlight">
                            <button type="button" id="btn_step_2" class="btn btn-secondary prev-step next-button">Anterior</button>
                        </div>
                        <div class="ml-auto p-2 bd-highlight">
                            <button type="button" id="btn_step_2_next" class="btn btn-primary next-step next-button">Próximo</button>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" role="tabpanel" id="step3">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-2 form-group">
                            <label class="col-form-label">{{ __('Cep *') }}</label>
                            <input type="text" id="end_cep" disabled class="mask_cep form-control" name="end_cep" value="{{ $candidato->end_cep }}" autocomplete="end_cep" placeholder='00000-000'>
                        </div>

                        <div class="col-12 col-md-6 form-group">
                            <label class="col-form-label">{{ __('Logradouro *') }}</label>
                            <input type="text" id="end_logradouro" class="form-control" disabled name="end_logradouro" id="end_logradouro" value="{{ $candidato->end_logradouro }}" autocomplete="end_logradouro">
                        </div>

                        <div class="col-12 col-md-2 form-group">
                            <label class="col-form-label">{{ __('Número') }}</label>
                            <input type="number" id="end_numero" disabled class="form-control" name="end_numero" value="{{ $candidato->end_numero }}" autocomplete="end_numero">
                        </div>

                        <div class="col-12 col-md-5 form-group">
                            <label class="col-form-label">{{ __('Complemento') }}</label>
                            <input type="text" id="end_complemento" disabled class="form-control" name="end_complemento" value="{{ $candidato->end_complemento }}" autocomplete="end_complemento">
                        </div>

                        <div class="col-12 col-md-5 form-group">
                            <label class="col-form-label">{{ __('Bairro *') }}</label>
                            <input type="text" id="end_bairro" class="form-control" name="end_bairro" disabled value="{{ $candidato->end_bairro }}" autocomplete="end_bairro">
                        </div>

                        <div class="col-12 col-md-8 form-group">
                            <label class="col-form-label">{{ __('Cidade *') }}</label>
                            <input type="text" id="end_localidade" class="form-control" name="end_localidade" value="{{ $candidato->end_localidade }}" autocomplete="end_localidade" @if($candidato->end_localidade != '') readonly @endif>
                        </div>

                        <div class="col-12 col-md-2 form-group">
                            <label class="col-form-label">{{ __('UF *') }}</label>
                            <select name="end_uf" id="end_uf" class="form-control ignoreSelect2  @if($candidato->end_uf != '') select-box-readonly @endif">
                                <option value="">Selecione</option>
                                @foreach($ufs As $uf)
                                <option value="{{ $uf->cod_uf }}" @if($candidato->end_uf == $uf->cod_uf) selected @endif>{{ $uf->cod_uf }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="d-flex bd-highlight mb-3">
                        <div class="p-2 bd-highlight">
                            <button type="button" id="btn_step_3" class="btn btn-secondary prev-step next-button">Anterior</button>
                        </div>
                        <div class="ml-auto p-2 bd-highlight">
                            <button type="button" class="btn btn-primary next-step next-button">Próximo</button>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" role="tabpanel" id="step4">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-8 form-group" id="div_formas_pagamento">
                        </div>
                    </div>
                    <div class="d-flex bd-highlight mb-3">
                        <div class="p-2 bd-highlight">
                            <button type="button" class="btn btn-secondary prev-step next-button">Anterior</button>
                        </div>
                        <div class="ml-auto p-2 bd-highlight">
                            <button type="button" id="btn_step_4" disabled class="btn btn-success next-step next-button" onClick="ga('send', 'event', 'botao_prematricula', 'clique', 'formulario');">Fazer pré-matrícula</button>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" role="tabpanel" id="step5">
                    <blockquote class="blockquote text-center mt-3">
                        <p class="mb-0">Sua pré-matrícula foi realizada com sucesso.</p>
                        <p class="mb-0">Seu número de inscrição é o <span id="cod_inscricao"></span>.</p>
                        <p class="mb-0">As informações de sua pré-matrícula foram encaminhadas para o e-mail cadastrado.</p>


                        <p class="mt-2">Acesse ou clique nos links abaixo para finalizar o processo de matrícula.</p>
                        <ul class="list-inline">
                            <li class="list-inline-item"><a class="btn btn-primary btn-lg" target="_blank" id="lnk_requerimento" href="#" role="button">Requerimento de matrícula</a></li>
                            <li class="list-inline-item"><a class="btn btn-secondary btn-lg" target="_blank" id="lnk_contrato" href="#" role="button">Contrato</a></li>
                            <li class="list-inline-item"><a class="btn btn-success btn-lg" target="_blank" id="lnk_anexo" href="#" role="button">Anexo 1</a></li>
                            <li class="list-inline-item"><a class="btn btn-warning btn-lg" target="_blank" id="lnk_boleto" href="#" role="button">Boleto</a></li>
                        </ul>
                    </blockquote>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('script')
<script>
    //Wizard
    //Initialize tooltips
    $('.nav-tabs > li a[title]').tooltip();

    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
        let $target = $(e.target);

        if ($target.hasClass('disabled')) {
            return false;
        }
    });

    $(".next-step").click(function(e) {
        if ($(this).attr('id') == 'btn_step_1' && $('#step').val() <= 1) {
            $('#step').val('1');
            $("input[name='_method']").val('POST');
            $('#frm_step_inscricao').attr('action', "{{ route('candInscrNaoFin.store') }}");

            if ($('#cod_campus').val()) {
                getProcessoSeletivo();
            }
            submitValidations($("#frm_step_inscricao"), function() {}, nextStep);
        } else if ($(this).attr('id') == 'btn_step_4') {
            if ($('#h_cod_niv_ens').val() == 10){
                var msg = `
                <div class="row justify-content-center mt-4">
                    <div class="form-group col-12 col-md-8">
                        <p>
                            <label>
                                <small>
                                    Venho requerer minha inscrição para este Curso
                                    de Extensão, na modalidade Presencial, da
                                    Universidade Santo Amaro – Unisa. Declaro
                                    que estou ciente em relação aos termos abaixo:
                                </small>
                            </label>
                        </p>
                        <ul>
                            <small>
                                <li>
                                    <p class="text-left">
                                        As vagas são limitadas!
                                    </p>
                                </li>
                                <li>
                                    <p class="text-left">
                                        A inscrição é pessoal e intransferível;
                                    </p>
                                </li>
                                <li>
                                    <p class="text-left">
                                        Após a inscrição é necessário efetuar o pagamento da matrícula;
                                    </p>
                                </li>
                                <li>
                                    <p class="text-left">
                                        O pagamento é indispensável para a confirmação da matrícula;
                                    </p>
                                </li>
                                <li>
                                    <p class="text-left">
                                        A Unisa se reserva o direito de não realizar o curso,
                                        caso não tenha número mínimo de alunos matriculados;
                                    </p>
                                </li>
                                <li>
                                    <p class="text-left">
                                        Somente serão certificados os alunos com,
                                        no mínimo, 75% (setenta e cinco por cento) de frequência no curso;
                                    </p>
                                </li>
                                <li>
                                    <p class="text-left">
                                        É de sua responsabilidade verificar antes do início do curso, a
                                        confirmação de sua oferta, o que poderá ser feito pelo telefone
                                        2141-8555. No caso de curso cancelado, o(a) inscrito(a) deverá
                                        requerer o reembolso do valor pago;
                                    </p>
                                </li>
                                <li>
                                    <p class="text-left">
                                        Verifique as configurações de segurança do seu correio eletrônico
                                        (AntiSpam) para facilitar nossa comunicação on-line.
                                    </p>
                                </li>
                                <p>Para finalizar, sinalize seu aceite às normas indicadas.</p>
                            </small>
                        </ul>
                    </div>
                </div>
                `;
            }else if($('#h_cod_niv_ens').val() == 13 && $('#modalidade').val() == 'P'){
                var msg = `
                <div class="row justify-content-center mt-4">
                    <div class="form-group col-12 col-md-8">
                        <p>
                            <label>
                                <small>
                                    Venho requerer minha inscrição para este Curso de
                                    Especialização/MBA – Lato Sensu, na modalidade Presencial,
                                    da Universidade Santo Amaro – Unisa. Declaro que:
                                </small>
                            </label>
                        </p>
                        <ul>
                            <small>
                                <li>
                                    <p class="text-left">
                                        Estou ciente que para efetivação da matrícula não
                                        serão aceitos egressos de cursos sequenciais e/ou
                                        com formação específica;
                                    </p>
                                </li>
                                <li>
                                    <p class="text-left">
                                        Estou ciente de que devo apresentar a documentação
                                        dentro do prazo estabelecido para efetivação da matrícula,
                                        caso contrário a mesma será desconsiderada;
                                    </p>
                                </li>
                                <li>
                                    <p class="text-left">
                                        É de minha inteira responsabilidade a veracidade das
                                        informações fornecidas na Ficha de Inscrição;
                                    </p>
                                </li>
                                <li>
                                    <p class="text-left">
                                        Estou ciente de que são válidas, para a matrícula,
                                        unicamente as informações, procedimentos e normas
                                        contidas em nosso site.
                                    </p>
                                </li>
                                <li>
                                    <p class="text-left">
                                        Estou ciente de que a efetivação da minha matrícula
                                        só se dará mediante pagamento da primeira mensalidade.
                                    </p>
                                </li>
                                <p>Para finalizar, sinalize seu aceite às normas indicadas.</p>
                            </small>
                        </ul>
                    </div>
                </div>
                `;
            }else{
                var msg = `
                    <div class="row justify-content-center mt-4">
                        <div class="form-group col-12 col-md-8">
                            <p>
                                <label>
                                    <small>
                                        Venho requerer minha matrícula para
                                        este Curso de Especialização – Lato Sensu,
                                        na modalidade EaD, da Universidade
                                        Santo Amaro – Unisa. Declaro que:
                                    </small>
                                </label>
                            </p>
                            <ul>
                                <small>
                                    <li>
                                        <p class="text-left">
                                            Estou ciente que para efetivação da
                                            matrícula não serão aceitos egressos
                                            de cursos sequenciais e/ou com
                                            formação específica;
                                        </p>
                                    </li>
                                    <li>
                                        <p class="text-left">
                                            Estou ciente de que devo apresentar a
                                            documentação dentro do prazo estabelecido
                                            para efetivação da matrícula, caso contrário
                                            a mesma será desconsiderada;
                                        </p>
                                    </li>
                                    <li>
                                        <p class="text-left">
                                            É de minha inteira responsabilidade a veracidade
                                            das informações fornecidas na Ficha de Matrícula;
                                        </p>
                                    </li>
                                    <li>
                                        <p class="text-left">
                                            Estou ciente de que são válidas, para a matrícula,
                                            unicamente as informações, procedimentos e normas
                                            contidas em nosso site;
                                        </p>
                                    </li>
                                    <li>
                                        <p class="text-left">
                                            Estou ciente de que a efetivação da minha matrícula
                                            só se dará mediante pagamento da primeira mensalidade;
                                        </p>
                                    </li>
                                    <li>
                                        <p class="text-left">
                                            Documentos necessários para matrícula: Cópia autenticada do Histórico
                                            Escolar e do Diploma ou Certificado de conclusão
                                            da graduação / Cópias simples: Certidão de Nascimento
                                            e/ou Casamento, Carteira de Identidade – RG e do CPF
                                            / 1 foto 3X4 recente.
                                        </p>
                                    </li>
                                    <p>Para finalizar, sinalize seu aceite às normas indicadas.</p>
                                </small>
                            </ul>
                        </div>
                    </div>
                `;
            }
            swal.fire({
                html: msg,
                title: 'Dados do candidato',
                input: 'checkbox',
                inputValue: 0,
                inputPlaceholder: 'Confirmo os dados preenchidos',
                confirmButtonText: 'Finalizar',
                showCancelButton: true,
                cancelButtonText: 'Voltar',
                width: 'auto',
                onOpen: () => {
                    gtag('event', 'click', {
                        'event_category': 'botao_prematricula',
                        'event_label': 'formulario'
                    });
                },
                inputValidator: (result) => {
                    if (!result) {
                        return 'Para continuar, marque o campo de confirmação.'
                    } else {
                        gtag('event', 'click', {
                            'event_category': 'botao_aceito',
                            'event_label': 'formulario'
                        });

                        $("input[name='_method']").val('POST');
                        $('#frm_step_inscricao').attr('action', "{{ route('candidato.store') }}");
                        submitValidations($("#frm_step_inscricao"), null, nextStep);
                    }
                }
            });
        } else {
            if ($(this).attr('id') == 'btn_step_1' && $('#cod_campus').val()) {
                getProcessoSeletivo();
            } else if ($(this).attr('id') == 'btn_step_2_next') {
                getTabelaPrecos();
            }
            $("input[name='_method']").val('PUT');
            $('#frm_step_inscricao').attr('action', "{{ route('candInscrNaoFin.update', encrypt(auth()->user()->num_cpf)) }}");
            submitValidations($("#frm_step_inscricao"), function() {}, nextStep);
        }
    });

    function nextStep(data) {
        let active = $('.wizard .nav-tabs .nav-item .active');
        let activeli = active.parent("li");
        let a_tab = $(activeli).next().find('a[data-toggle="tab"]');

        id = $(a_tab).attr('aria-controls');
        $(`#${id}`).find('input, select').attr("disabled", false);
        $('#step').val(`${id}`);
        if (id == 'step5') {
            //FACEBOOK PIXEL TRACK
            fbq('track', 'CompleteRegistration');
            if (data.cod_niv_ensino == 13) {
                $('#cod_inscricao').text(data.cod_inscricao);
                $("#lnk_requerimento").attr("href", '{{env('METODO_URL_PLS_PRD')}}'+`pw_secretaria.exibeContratoMatricula?codpag=9055&pcodinscr=${data.cod_inscricao}`)
                $("#lnk_contrato").attr("href", '{{env('METODO_URL')}}'+`imagens_inscricao_processos_seletivos/pos/Contrato_de_Prestacao_de_Servico_POS_2017.pdf`)
                $("#lnk_anexo").attr("href", '{{env('METODO_URL_PLS_PRD')}}'+`pw_secretaria.exibeContratoMatricula?codpag=9056&pcodinscr=${data.cod_inscricao}`)
                $("#lnk_boleto").attr("href", '{{env('METODO_URL_PLS_PRD')}}'+`pw_boleto.imprimeBoleto?codPag=1962&codRa=${data.ra}&codTitulo=${data.cod_titulo}`)

            } else {
                $('#cod_inscricao').text(data.cod_inscricao)
                $("#lnk_requerimento").css("display", "none")
                $("#lnk_contrato").css("display", "none")
                $("#lnk_anexo").css("display", "none")
                $("#lnk_boleto").attr("href", '{{env('METODO_URL_PLS_PRD')}}'+`pw_boleto.imprimeBoleto?codPag=1962&codRa=${data.ra}&codTitulo=${data.cod_titulo}`)

            }
            $('#a_step1').addClass('disabled');
            $('#a_step2').addClass('disabled');
            $('#a_step3').addClass('disabled');
            $('#a_step4').addClass('disabled');
        }
        $(a_tab).removeClass("disabled");
        $(a_tab).click();
    }

    $(".prev-step").click(function(e) {
        prevStep();
    });

    function prevStep() {
        let active = $('.wizard .nav-tabs .nav-item .active');
        let activeli = active.parent("li");
        let a_tab = $(activeli).prev().find('a[data-toggle="tab"]');
        id = $(a_tab).attr('aria-controls');
        $('#step').val(`${id}`);
        $(a_tab).removeClass("disabled");
        $(a_tab).click();
    }
    //Wizard

    $('#cod_proc_seletivo').change(function() {
        $('#div-t').html('');
        $('#cod_curso_ps').empty();
        $('#cod_curso_ps').html(`<option value=''>Selecione</option>`);
        $('#cod_campus').empty();
        $('#cod_campus').html(`<option value=''>Selecione</option>`);
        $('#cod_curso_ps').prop('disabled', true)
        $('#cod_campus').prop('disabled', true)

        if ($(this).val()) {
            let rota = "{{ route('candidato.getCursos') }}";
            let json = {
                'cod_niv_ens': $('#h_cod_niv_ens').val(),
                'modalidade': $('#modalidade').val(),
                'cod_proc_seletivo': $(this).val()
            };

            function successGetSelect(json) {
                let itens = '';
                if(json.length == 0 || json.length > 1){
                    itens += `<option value=''>Selecione</option>`;
                }

                $.each(json, function(name, value) {
                    itens += `<option ${value.disabled} value='${value.cod_curso_ps}'>${value.nom_curso_ps}</option>`;
                });

                $('#cod_curso_ps').prop('disabled', false).html(itens);
                if(json.length == 1){
                    $('#cod_curso_ps').change();
                }
            }
            getDadosComParametros(rota, json, successGetSelect, null, function() {})
        } else {
            $('#cod_curso_ps').val(null).trigger('change');
            $('#cod_curso_ps').prop("disabled", true);
            $('#div-t').html('');
        }

    });

    $('#cod_curso_ps').change(function() {
        if ($(this).val()) {
            let rota = "{{ route('candidato.getPolo') }}";
            let json = {
                'cod_curso_ps': $(this).val(),
                'cod_proc_seletivo': $('#cod_proc_seletivo').val(),
                'cod_niv_ens': $('#h_cod_niv_ens').val(),
                'modalidade': $('#modalidade').val()
            };

            function successGetSelect(json) {
                let itens = '';

                if (json.length == 1) {
                    itens = "";
                    $('#div-t').html(`<label class="col-form-label text-right">Endereço</label>
                                    <span>${json[0].endereco}</span></div>`);
                } else {
                    itens = "<option value=''>Selecione</option>";
                }

                $.each(json, function(name, value) {
                    itens += `<option value = '${value.cod_campus}' data-endereco='${value.endereco}'>${value.nom_campus}</option>`;
                });

                $('#cod_campus').prop('disabled', false).html(itens);
            }
            getDadosComParametros(rota, json, successGetSelect, null, function() {})
        } else {
            $('#cod_campus').val(null).trigger('change');
            $('#cod_campus').prop("disabled", true);
            $('#div-t').html('');
        }
    })

    function getProcessoSeletivo() {
        let rota = "{{ route('candidato.getProcessoSeletivo') }}";
        let dados = {
            'cod_curso_ps': $('#cod_curso_ps').val(),
            'cod_campus': $('#cod_campus').val(),
            'cod_niv_ens': $('#h_cod_niv_ens').val(),
        };

        function successGetSelect(json) {
            //$('#cod_proc_seletivo').val(json[0].cod_proc_seletivo);
        }
        getDadosComParametros(rota, dados, successGetSelect, null, function() {});
    }

    function getTabelaPrecos() {
        $('#div_formas_pagamento').empty();

        let rota = "{{ route('candidato.getTabelaPrecos') }}";
        let json = {
            'cod_proc_seletivo': $('#cod_proc_seletivo').val(),
            'cod_curso_ps': $('#cod_curso_ps').val(),
            'cod_campus': $('#cod_campus').val(),
            'cod_niv_ens': $('#h_cod_niv_ens').val(),
        };

        function successGetSelect(json) {
            let itens = '';

            if ($('#h_cod_niv_ens').val() == 13) {
                msgParcela = 'vezes';
            } else {
                msgParcela = 'vez';
            }

            $('#btn_step_4').prop('disabled', true);
            if ((Object.keys(json).length) === 0) {
                itens = `<div class="alert alert-warning mb-4 mt-4" role="alert">
                                <h4 class="alert-heading">Plano de pagamento</h4>
                                <hr>
                                <p style="color: #0f0f0f">O Curso ainda não possui opções de pagamento, favor entrar em contato.</p>
                                <hr>
                            </div>`
            } else if ((Object.keys(json).length) === 1) {
                itens = `<div class="alert alert-secondary mb-4 mt-4" role="alert">
                                <h4 class="alert-heading">Plano de pagamento</h4>
                                <hr>
                                <p style="color: #0f0f0f">Conheça os planos de pagamento oferecidos para sua opção de curso.<h4 class='text-center'><span class="badge badge-secondary">Em ${json[0].qtd_duracao_curso} ${msgParcela} de R$ ${json[0].val_planilha_custo},00</span></h4></p>
                                <input type="hidden" readonly class="form-control" name="num_tab_preco_curso"
                                        value="${json[0].num_tab_preco_curso}" autocomplete="num_tab_preco_curso">
                                <hr>
                            </div>`;

                $('#btn_step_4').removeAttr('disabled');
            } else {

                itens = `<div class="alert alert-secondary mb-4 mt-4" role="alert">
                                <h4 class="alert-heading">Plano de pagamento</h4>
                                <hr>
                                <p style="color: #0f0f0f">Selecione o plano de pagamento que mais se adequa ao seu orçamento.<h4>`;
                $.each(json, function(name, value) {
                    itens += `<div class="form-check text-center">
                                <input class="form-check-input" type="radio" name="num_tab_preco_curso" id="num_tab_preco_curso_${name}" value="${value.num_tab_preco_curso}">
                                <label class="form-check-label" for="num_tab_preco_curso_${name}"><h4><span class="badge badge-secondary">Em ${value.qtd_duracao_curso} ${msgParcela} de R$ ${value.val_planilha_custo},00</span></h4></label>
                            </div>
                            `;
                });
                itens += `<hr></div>`
            }

            $('#div_formas_pagamento').append(itens);
        }
        getDadosComParametros(rota, json, successGetSelect, null, function() {});
    }

    $('#cod_campus').change(function() {
        if ($(this).val()) {
            let endereco = $(this).find(':selected').data('endereco');
            $('#div-t').html(`<label class="col-form-label text-right">Endereço</label>
                                    <span>${endereco}</span></div>`);
        } else {
            $('#div-t').html('');
        }
    });

    $(document).on('change', '#end_cep', function() {
        getEndereco($(this), $('#end_logradouro'), $('#end_bairro'), $('#end_localidade'), $('#end_uf'));
    });

    $(document).on('click', "input[name='num_tab_preco_curso']", function() {
        $('#btn_step_4').removeAttr('disabled');
    });
</script>


@include('bibliotecas.js.scripts.cep')
@endsection
