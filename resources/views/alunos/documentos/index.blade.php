@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('alunoDoctoPend.index')}}
@endsection

@section('content')
    @if(getRaAluno())
    <div class="container-fluid">
        <div class="mb-4 mt-4 col-md-12 col-sm-12 col-xs-12 mt-12 justify-content-center text-center">
            <h6>
                Anexe os documentos que comprovem a conclusão do seu curso de Graduação, como Diploma e/ou Certificado de Conclusão do Curso.
            </h6>
        </div>
        <form method="POST" action="{{ route('aluno.documentos.store') }}" id="frmAlunoDocts" enctype="multipart/form-data">
            @csrf
            <div class="row justify-content-center">
                @if(count($doctos) > 0)
                    @foreach($doctos as $docto)
                        <div class="col-12 col-md-8 form-group __files" id="__files-{{ $docto->cod_tp_docto }}">
                            <label class="col-form-label">{{ $docto->dsc_tp_docto }}</label>
                            <div class="custom-file">
                                <!--
                                @if($docto->dsc_link_arquivo == '')
                                    <input type="file" accept="application/pdf" class="custom-file-input __files" id="{{ $docto->form_id }}" name="{{ $docto->form_id }}" aria-describedby="docto-{{ $docto->cod_tp_docto }}">
                                @else
                                <input type="file" accept="application/pdf" class="custom-file-input __files" disabled>
                                <div class="row mt-1 file-display">
                                    <div class="col-md-12">
                                        <a href="{{ 'getArquivo($path . $docto->dsc_link_arquivo)' }}" target="_blank"><i class="fas fa-file-pdf fa-1x"></i> Arquivo</a>
                                    </div>
                                </div>
                                @endif
                                -->
                                <input type="file" accept="application/pdf" class="custom-file-input __files" id="{{ $docto->form_id }}" name="{{ $docto->form_id }}" aria-describedby="docto-{{ $docto->cod_tp_docto }}">
                                <label class="custom-file-label" for="{{ $docto->form_id }}"></label>
                                @if($docto->dsc_link_arquivo != '')
                                <div class="row mt-1 file-display">
                                    <div class="col-md-12">
                                        <a href="{{ $docto->dsc_link_arquivo }}" target="_blank"><i class="fas fa-file-pdf fa-1x"></i> Arquivo</a>
                                    </div>
                                </div>
                            @endif
                            </div>
                        </div>
                    @endforeach
                @endif

                <div class="col-12 col-md-6 form-group mt-4">
                    <button id="btnEnviar" class="btn btn-primary btn-block">{{ __('Enviar Documentos') }}</button>
                </div>
            </div>
        </form>
    </div>
    @else
    <div class="text-center mt-5">
        <h3>Você não possui documentos pendentes!</h3>
    </div>
    @endif
@endsection

@section('script')
    <script>
        $('#btnEnviar').click(function(e){
            e.preventDefault();
            submitValidations($("#frmAlunoDocts"));
        });

        $('.__files').on('change', function () {
            var fileName = $(this).val();
            $(this).next('.custom-file-label').html(fileName);
        });
    </script>
@endsection
