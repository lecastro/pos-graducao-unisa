@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form id="frm_aluno_edit" action="{{ route('alunos.update', encrypt(auth()->user()->num_cpf)) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="cod_ra" value="{{ $aluno->cod_ra }}">

                            <div class="col py-3 px-md-5">
                                <h3 class="row d-flex justify-content-center">Dados pessoais</h3>
                                <hr>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('CPF *') }}</label>
                                <div class="col-md-6">
                                    <input readonly type="text" class="mask_cpf form-control" name="num_cpf"
                                        value="{{ auth()->user()->num_cpf }}"  autocomplete="num_cpf" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('Nome *') }}</label>
                                <div class="col-md-6">
                                    <input id="nom_aluno" type="text" class="form-control"
                                name="nom_aluno" value="{{ $aluno->nom_aluno }}"  autocomplete="nom_aluno" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('E-mail *') }}</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="dsc_end_e_mail" value="{{ $aluno->dsc_end_e_mail }}" autocomplete="dsc_end_e_mail">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('Celular *') }}</label>
                                <div class="col-md-6">
                                    <input id="num_telefone" type="text" class="mask_telefone form-control" name="num_telefone" value="{{ $telefones['CEL1'] }}"  autocomplete="telefone" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('Telefone fixo') }}</label>
                                <div class="col-md-6">
                                    <input  id="num_telefone_fixo" type="text" class="mask_telefone form-control" name="telefones[RES1]" value="{{ $telefones['RES1'] }}" autocomplete="telefone" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('Telefone comercial') }}</label>
                                <div class="col-md-6">
                                    <input id="num_telefone_com" type="text" class="mask_telefone form-control" name="telefones[COM1]" value="{{ $telefones['COM1'] }}" autocomplete="num_telefone_com" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('Telefone de recado') }}</label>
                                <div class="col-md-6">
                                    <input  id="num_tel_cand" type="text" class="mask_telefone form-control" name="telefones[REC1]" value="{{ $telefones['REC1'] }}" autocomplete="num_tel_cand" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('Gênero *') }}</label>
                                <div class="col-md-6">
                                    @php
                                        $ind_sexo = ['Masculino', 'Feminino']
                                    @endphp
                                    <select class="form-control ignoreSelect2" name="ind_sexo" >
                                        <option>Selecione</option>
                                        @foreach ($ind_sexo as $key => $value)
                                            <option value="{{ $key+1 }}" @if (($aluno->ind_sexo == $key+1) ) selected @endif >{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Data de nascimento *</label>
                                <div class="col-md-6">
                                    <input type="text" class="mask_date form-control"
                                name="dat_nascimento" value="{{ converteDate($aluno->dat_nascimento) }}" >
                                </div>
                            </div>

                            <div class="col py-4 px-md-5">
                                <h3 class="row d-flex justify-content-center">Endereço</h3>
                                <hr>
                            </div>

                            <input type="hidden" name="ind_tp_end_aluno" value="{{ $aluno->ind_tp_end_aluno }}">

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('Cep *') }}</label>
                                <div class="col-md-6">
                                    <input type="text" id="end_cep_aluno" class="mask_cep form-control"
                                        name="end_cep_aluno" value="{{ $aluno->end_cep_aluno }}"  autocomplete="end_cep_aluno"
                                         placeholder='00000-000'>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('Logradouro *') }}</label>
                                <div class="col-md-6">
                                    <input type="text" id="end_logr_aluno" class="form-control"
                                        name="end_logr_aluno" value="{{ $aluno->end_logr_aluno }}"
                                        autocomplete="end_logr_aluno"  readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('Número *') }}</label>
                                <div class="col-md-6">
                                    <input type="number" id="end_num_aluno" class="form-control"
                                        name="end_num_aluno" value="{{ $aluno->end_num_aluno }}"  autocomplete="end_num_aluno"
                                        >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('Complemento') }}</label>
                                <div class="col-md-6">
                                    <input type="text" id="end_compl_aluno" class="form-control"
                                        name="end_compl_aluno" value="{{ $aluno->end_compl_aluno }}"
                                        autocomplete="end_compl_aluno" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('Bairro *') }}</label>
                                <div class="col-md-6">
                                    <input type="text" id="end_bairro_aluno" class="form-control"
                                        name="end_bairro_aluno" value="{{ $aluno->end_bairro_aluno }}"  autocomplete="end_bairro_aluno"
                                        readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('Cidade *') }}</label>
                                <div class="col-md-6">
                                    <input type="text" id="end_localid_aluno" class="form-control"
                                        name="end_localid_aluno" value="{{ $aluno->end_localid_aluno }}"
                                        autocomplete="end_localid_aluno"  readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('UF *') }}</label>
                                <div class="col-md-6">
                                    <input type="text" id="end_uf_aluno" class="form-control"
                                        name="end_uf_aluno" value="{{ $aluno->end_uf_aluno }}"  autocomplete="end_uf_aluno"  readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Salvar') }}
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

@section('script')
    @include('bibliotecas.js.scripts.cep')
    <script>
        $(document).on('blur', '#end_cep_aluno', function () {
            if ($(this).val()) {
                getEndereco($(this), $('#end_logr_aluno'), $('#end_bairro_aluno'), $('#end_localid_aluno'), $('#end_uf_aluno'));
            }
        });

        $("form").submit(function(e) {
            e.preventDefault();
            submitValidations($(this));
        });
    </script>
@endsection
