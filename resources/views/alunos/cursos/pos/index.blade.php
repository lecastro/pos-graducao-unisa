@extends('layouts.app')

@section('breadcrumbs')
{{ Breadcrumbs::render('alunos.cursos.pos')}}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card-deck" id="divCardDeck">
                    <div class="card border-dark col-xl-2 p-0 shadow-lg bg-white rounded">
                        <a href="#" class="">
                            <div class="card-header text-center">
                                <h6 class="card-title">MBA Executivo em Auditoria, compliance e Gestão de Riscos</h6>
                                <p class="card-text">Descrição do curso ou outra coisa relevante</p>
                            </div>
                        </a>

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item small">Data Inicio: 01/02/2020</li>
                            <li class="list-group-item small">Data Término: 31/07/2020</li>
                        </ul>

                        <div class="card-body">
                            <div class="mt-n2">
                                <a href="#"><span class="small">Deixe uma classificação</span></a>
                            </div>

                            <a href="#" class="estrela far fa-star"></a>
                            <a href="#" class="estrela far fa-star"></a>
                            <a href="#" class="estrela far fa-star"></a>
                            <a href="#" class="estrela far fa-star"></a>
                            <a href="#" class="estrela far fa-star"></a>
                        </div>
                        <div class="card-footer">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 100%"><strong class="text-dark">0% concluído</strong></div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-dark col-xl-2 p-0 shadow-lg bg-white rounded">
                        <a href="#" class="">
                            <img src="https://unisamaraba.com.br/wp-content/uploads/2019/01/Unisa-Maraba-curso-de-analise-e-desenvolvimento-de-sistemasa-distancia.jpg" class="card-img-top" alt="...">
                        </a>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item small">Data Inicio: 01/02/2020</li>
                            <li class="list-group-item small">Data Término: 31/07/2020</li>
                        </ul>

                        <div class="card-body">
                            <div class="mt-n2">
                                <span class="small">Deixe uma classificação</span>
                            </div>

                            <a href="#" class="estrela fas fa-star"></a>
                            <a href="#" class="estrela fas fa-star"></a>
                            <a href="#" class="estrela fas fa-star"></a>
                            <a href="#" class="estrela fas fa-star"></a>
                            <a href="#" class="estrela fas fa-star"></a>
                        </div>
                        <div class="card-footer">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%"><strong>75% concluído</strong></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).on('click', '.estrela', function () {
            $(this).addClass('fas fa-star');
            $(this).prevAll('a').removeClass('far fa-star').addClass('fas fa-star');
            $(this).nextAll('a').removeClass('fas fa-star').addClass('far fa-star');
        });

        let cursosPos = {{ $cursosPos ?? 'undefined'}};
        let itens = '';
        $.each(cursosPos, function (name, value) {
            itens += `
                <div class="card border-dark col-xs-12 col-2 p-0 shadow-lg bg-white rounded">
                    <a href="#" class="">
                        <img src="https://unisamaraba.com.br/wp-content/uploads/2019/01/Unisa-EAD-P%C3%B3lo-Marab%C3%A1-Educa%C3%A7%C3%A3o-presencial-e-a-Dist%C3%A2nciajpg-7-1200x1200.jpg" class="card-img-top" alt="...">
                    </a>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item small">Data Inicio: 01/02/2020</li>
                        <li class="list-group-item small">Data Término: 31/07/2020</li>
                    </ul>

                    <div class="card-body">
                        <div class="mt-n2">
                            <a href="#"><span class="small">Deixe uma classificação</span></a>
                        </div>

                        <a href="#" class="estrela far fa-star"></a>
                        <a href="#" class="estrela far fa-star"></a>
                        <a href="#" class="estrela far fa-star"></a>
                        <a href="#" class="estrela far fa-star"></a>
                        <a href="#" class="estrela far fa-star"></a>
                    </div>
                    <div class="card-footer">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 100%"><strong class="text-dark">0% concluído</strong></div>
                        </div>
                    </div>
                </div>
            `;
        });
        $('#divCardDeck').append(itens);
    </script>
@endsection
