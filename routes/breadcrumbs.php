<?php

use App\Models\Ps\PsCandidato;

Breadcrumbs::for('home', function ($trail) {
    $trail->push('Início', route('home'));
});

Breadcrumbs::for('candidato.show', function ($trail, $id) {
    $trail->parent('home');
    $trail->push('Matrículas');
    $trail->push('Minhas matrículas', route('candidato.show', $id));
});

Breadcrumbs::for('candidato.index', function ($trail) {
    $trail->parent('home');
    $trail->push('Matrícula');
});

Breadcrumbs::for('inscricoes.create', function ($trail) {
    $trail->parent('home');
    $trail->push('Matrículas');
    $trail->push('Fazer matrícula');
});

Breadcrumbs::for('alunos.cursos.pos', function ($trail) {
    $trail->parent('home');
    $trail->push('Cursos já adquiridos');
    $trail->push('Pós-graduação');
});

Breadcrumbs::for('alunos.cursos.extensao', function ($trail) {
    $trail->parent('home');
    $trail->push('Cursos já adquiridos');
    $trail->push('Extensão');
});

Breadcrumbs::for('alunoDoctoPend.index', function ($trail) {
    $trail->parent('home');
    $trail->push('Aluno');
    $trail->push('Documentos');
});

Breadcrumbs::for('candidato.create', function ($trail) {
    $trail->parent('home');
    $trail->push('Matrículas');
    $trail->push('Fazer matrícula');
});

Breadcrumbs::for('auth.index', function ($trail) {
    $trail->push('Home', route('home'));

});

Breadcrumbs::for('aluno.financeiro.index', function ($trail) {
    $trail->parent('home');
    $trail->push('Aluno');
    $trail->push('Financeiro');
});

Breadcrumbs::for('aluno.financeiro.cartao', function ($trail) {
    $trail->parent('home');
    $trail->push('Aluno');
    $trail->push('Financeiro');
    $trail->push('Cartao');
});

// Breadcrumbs::for('auth.register', function ($trail) {
//     $trail->parent('auth.index');
//     $trail->push('Registre-se');

// });

// Breadcrumbs::for('auth.reset', function ($trail) {
//     $trail->parent('auth.index');
//     $trail->push('Esqueci minha senha');

// });

