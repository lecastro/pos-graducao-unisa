<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Pós-graduação e Extensão - UNISA</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @include('bibliotecas.js.scripts.facebook.pixel')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Styles SiderBar -->
    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">

    <!-- Styles forcePassword -->
    <link href="{{ asset('css/ForcePassword.css') }}" rel="stylesheet">

    @hasSection('style')
    @yield('style')
    @endif
    <style>
        .drop-mobile {
            background-color: #fcfcfc;
            border-radius: 3px;
            margin-top: 5px;
        }

        .nav-tabs {
            border-bottom: none !important;
        }
    </style>
</head>

<body>
    <div class="div-loader" style="display: none;">
        <div id="loader" style="position: fixed; width: 100%; height: 100%; background-color: rgba(255,255,255,0.5); z-index: 99999;">
            <div style="position: fixed; left: 50%; top: 50%; margin-top: -19px; z-index: 999999999;">
                <i class="fas fa-spinner fa-pulse fa-3x"></i>
            </div>
        </div>
    </div>
    <div id="app">
        <div class="wrapper">
            @if(Auth::check() && getEstadoCadastro(auth()->user()->id))
            <nav id="sidebar" class="">
                <div class="sidebar-header">
                    <a href="{{ route('home') }}"><img width="110px" height="56px" class="img img-responsive" src="/images/logo.png"></a>
                </div>

                <ul class="list-unstyled components">
                    <p class="mt-n5"></p>
                    <li>
                        <a href="/">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            Início
                        </a>
                        <a href="#inscricoesSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <i class="fas fa-check-double" aria-hidden="true"></i>
                            Matrículas
                        </a>
                        <ul class="collapse list-unstyled" id="inscricoesSubmenu">
                            <li>
                                <a href="{{ route('candidato.index') }}">
                                    <i class="fa fa-edit" aria-hidden="true"></i>
                                    Fazer matrícula
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('candidato.show',  encrypt(auth()->user()->num_cpf)) }}">
                                    <i class="fab fa-buffer" aria-hidden="true"></i>
                                    Minhas matrículas
                                </a>
                            </li>
                        </ul>
                        {{-- <a href="#cursosSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                <i class="fa fa-book" aria-hidden="true"></i>
                                Cursos já adquiridos
                            </a>
                            <ul class="collapse list-unstyled" id="cursosSubmenu">
                                <li>
                                    <a href="{{ route('alunos.cursos.pos') }}">
                        <i class="fa fa-mortar-board" aria-hidden="true"></i>
                        Pós-graduação EAD
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('alunos.cursos.extensao') }}">
                            <i class="fas fa-chalkboard-teacher" aria-hidden="true"></i> Extensão EAD
                        </a>
                    </li>
                </ul>
                --}}
                    </li>
                    <li class="">
                        <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <i class="fa fa-child" aria-hidden="true"></i> Aluno
                        </a>
                        <ul class="collapse list-unstyled" id="homeSubmenu">
                            <li>
                                <a href="{{ route('aluno.documentos.index') }}">
                                    <i class="fa fa-copy"></i>
                                    Documentos
                                </a>
                            </li>
                        </ul>
                        <ul class="collapse list-unstyled" id="homeSubmenu">
                            <li>
                                <a href="{{ route('aluno.financeiro.index') }}">
                                    <i class="fa fa-money"></i>
                                    Financeiro
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
            @endif

            <div id="content" style="padding: 0px">

                <nav class="navbar navbar-expand-md navbar-light shadow-md" style="background: linear-gradient(to left, rgba(17,92,203,1) , rgba(169,211,552,1)); padding: 12px 10px;">
                    <div class="container-fluid">
                        @if(Auth::check() && getEstadoCadastro(auth()->user()->id))
                        <button type="button" id="sidebarCollapse" class="navbar-btn btn btn-secondary">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>

                        <!-- Menu Esquerda -->

                        <button class="btn btn-light d-inline-block d-md-none d-lg-none d-xl-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <i class="fas fa-user-graduate"></i>
                        </button>

                        <div class="text-center collapse navbar-collapse" id="navbarSupportedContent">
                            <div class="drop-mobile" style="">
                                <span id="span-mobile" class="navbar-text mt-3 d-md-none d-lg-none d-xl-none ml-auto">{{ getRaAluno(auth()->user()->num_cpf) ? 'RA: ' . getRaAluno(auth()->user()->num_cpf)  : '' }}</span>
                                <hr>

                                <ul class=" navbar-nav d-md-none d-lg-none d-xl-none ml-auto">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('redefinir/senha') }}">
                                            {{ __('Alterar Senha') }}
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                        document.getElementById('logout-form-mobile').submit();">
                                            {{ __('Sair') }}
                                        </a>
                                        <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>

                            <ul class="nav navbar-nav ml-auto d-none d-md-block d-lg-block d-xl-block">
                                <li class="nav-item active">
                                    <button class="btn" data-toggle="dropdown" id="navBarAluno">
                                        <div style="font-size: 0.5rem;">
                                            <span style="color: #F5F5F5;">
                                                <i class="fas fa-user-graduate fa-3x"></i>
                                            </span>
                                            <span class="ml-2" style="color: #F5F5F5; font-size: 0.75rem;">
                                                {{ (auth()->user()->name) }}
                                            </span>
                                        </div>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-default mr-4 " aria-labelledby="navBarAluno">
                                        <div class="d-flex bd-highlight ml-4 mb-n2 mr-4">
                                            <h5 for="">
                                                {{ getRaAluno(auth()->user()->num_cpf) ? 'RA: ' . getRaAluno(auth()->user()->num_cpf)  : '' }}
                                            </h5>
                                        </div>
                                        <div class="dropdown-divider"></div>

                                        <button class="dropdown-item" data-toggle="modal" data-target="#perfil">
                                            {{ __('Perfil') }}
                                        </button>

                                        <button class="dropdown-item" data-toggle="modal" data-target="#mdlAlterarSenha">
                                            {{ __('Alterar Senha') }}
                                        </button>

                                        <button class="dropdown-item" data-toggle="modal" data-target="#mdlAlterarEmailTitle">
                                            {{ __('Alterar E-mail') }}
                                        </button>

                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                            {{ __('Sair') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        @else
                        <div class="pl-2">
                            <a href="{{ route('home') }}"><img width="77px" height="auto" class="img img-responsive" src="/images/logo.png"></a>
                        </div>
                        @endif
                    </div>
                </nav>
                <div class="container d-none d-sm-block">
                    @yield('breadcrumbs')
                </div>
                @yield('content')
            </div>
        </div>
        @yield('modal')
    </div>
    @if(Auth::check())
    {{-- Modal do perfil --}}
    <div class="modal fade" id="perfil" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="perfil">Perfil</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5>Nome:<span class=""> {{ auth()->user()->name }}</span></h5>
                    <h5>Email:<span class=""> {{ auth()->user()->email }}</span></h5>
                    <h5>CPF:<span class=""> {{ formatarCpf(auth()->user()->num_cpf) }}</span></h5>
                    <h5>Tel:<span class=""> {{ formatarCelular(auth()->user()->num_telefone) }}</span></h5>
                    <h5>Data de criação:<span class=""> {{ converteDate(auth()->user()->created_at) }}</span></h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    @endif
    {{-- Modal alteração de senha --}}
    <div class="modal fade" id="mdlAlterarSenha" tabindex="-1" role="dialog" aria-labelledby="mdlAlterarSenhaTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mdlAlterarSenhaTitle">Alterar minha senha</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('updateAuthUserPassword') }}" method="POST" id="fmUptPass">
                        @csrf
                        <input type="hidden" name="_method" value="put">
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-8 form-group">
                                <label class="col-form-label">{{ __('Senha Atual *') }}</label>
                                <input class="form-control" id="currentPassword" name="currentPassword" required autocomplete="currentPassword" type="password">
                            </div>

                            <div class="col-12 col-md-8 form-group">
                                <label class="col-form-label">{{ __('Nova Senha *') }}</label>
                                <input class="form-control" name="password" id="modal-password" required autocomplete="nova-senha" type="password">
                            </div>
                            <div class="col-12 col-md-8 form-group">
                                <label class="col-form-label">{{ __('Confirmar Senha *') }}</label>
                                <input data-toggle="tooltip" data-placement="top" title="A senha deve ter mínimo de oito caracteres e mesclar letras maiúsculas e minúsculas, números e caracteres especiais" id="password_confirmation" type="password" class="form-control" name="password_confirmation" required autocomplete="nova-senha">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btnUpdPass">Salvar nova senha</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal alteração de e-mail --}}
    <div class="modal fade" id="mdlAlterarEmailTitle" tabindex="-1" role="dialog" aria-labelledby="mdlAlterarEmailTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mdlAlterarEmailTitle">Alterar meu e-mail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('updateAuthUserEmail') }}" method="POST" id="fmUptEmail">
                        @csrf
                        <input type="hidden" name="_method" value="put">
                        <div class="row justify-content-center">

                            <div class="col-12 col-md-8 form-group">
                                <label class="col-form-label">{{ __('Novo e-mail *') }}</label>
                                <input id="email" type="email" class="form-control" name="email" required autocomplete="email">
                            </div>

                            <div class="col-12 col-md-8 form-group">
                                <label class="col-form-label">{{ __('Confirmar novo e-mail *') }}</label>
                                <input id="email_confirm" type="email" class="form-control" name="email_confirmation" required>
                            </div>

                            <div class="col-12 col-md-8 form-group">
                                <label class="col-form-label">{{ __('Confirme sua senha *') }}</label>
                                <input  class="form-control" name="passwordEmail" id="passwordEmail" required autocomplete="passwordEmail" type="password">
                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btnUpdEmail">Salvar novo e-mail</button>
                </div>
            </div>
        </div>
    </div>
    @include('bibliotecas.js.scripts.google-analytics')

    <script>

        validationMsgSuccess();
        $(document).ready(function() {
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').toggleClass('active');
                $(this).toggleClass('active');
            });
        });

        $("#btnUpdPass").click(function(e) {
            e.preventDefault();
            submitValidations($("#fmUptPass"));
        });
        $("#btnUpdEmail").click(function(e) {
            e.preventDefault();
            submitValidations($("#fmUptEmail"));
        });

        if ($('#span-mobile').text() == "") {
            $('#span-mobile').css('display', 'none')
        }

        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>

    @hasSection('script')
    @yield('script')
    @endif
</body>

</html>
