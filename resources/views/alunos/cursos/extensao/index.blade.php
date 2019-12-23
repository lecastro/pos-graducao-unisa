@extends('layouts.app')

@section('breadcrumbs')
{{ Breadcrumbs::render('alunos.cursos.extensao')}}
@endsection

@section('content')

<div class="container-fluid">

    <div class="row ">
        <div class="col-md-3 mb-5">
            <div class="card border-dark">
                <a href="#" class="card-hover"><img id="card-teste" class="card-img-top" src="https://unisamaraba.com.br/wp-content/uploads/2019/01/Unisa-Maraba-curso-de-analise-e-desenvolvimento-de-sistemasa-distancia.jpg" alt="Imagem de capa do card">
                    <div class="overlay"></div>
                </a>
                <div class="card-body text-center">
                    <h6 class="card-title ">MBA Executivo em Auditoria, compliance e Gestão de Riscos</h6>
                    <p class="card-text">Descrição do curso ou outra coisa relevante</p>
                </div>
                <ul class="list-group list-group-flush text-center">
                    <li class="list-group-item">Início: 03/09/2019</li>
                    <li class="list-group-item">Fim: 03/09/2020</li>

                </ul>
            </div>
        </div>
        <div class="col-md-3 mb-5">
            <div class="card border-dark">
                <a href="#" class="card-hover"><img id="card-teste" class="card-img-top" src="https://unisamaraba.com.br/wp-content/uploads/2019/01/Unisa-Maraba-curso-de-analise-e-desenvolvimento-de-sistemasa-distancia.jpg" alt="Imagem de capa do card">
                    <div class="overlay"></div>
                </a>

                <div class="card-body text-center">
                    <h6 class="card-title ">MBA Executivo em Auditoria, compliance e Gestão de Riscos</h6>
                    <p class="card-text">Descrição do curso ou outra coisa relevante</p>
                </div>
                <ul class="list-group list-group-flush text-center">
                    <li class="list-group-item">Início: 03/09/2019</li>
                    <li class="list-group-item">Fim: 03/09/2020</li>

                </ul>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center">
        <nav aria-label="Navegação de página exemplo">
            <ul class="pagination">
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Anterior">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Anterior</span>
                    </a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Próximo">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Próximo</span>
                    </a>
                </li>
            </ul>
        </nav>

    </div>



</div>
<style>
    .card-hover:hover #card-teste {
        opacity: .8;
    }

    .card-hover:hover .overlay {
        opacity: 1;
    }


    #card-teste {
        opacity: 1;
        display: block;
        transition: .5s ease;
        backface-visibility: hidden;
    }

    .overlay {
        width: 100px;
        height: 100px;
        transition: .5s ease;
        opacity: 0;
        position: absolute;
        margin-top: -50%;
        margin-left: 50%;
        transform: translate(-50%, -50%);
        background-image: url('/images/icon.svg');
        background-repeat: no-repeat;
        background-size: 100px 100px;
    }
</style>

@endsection