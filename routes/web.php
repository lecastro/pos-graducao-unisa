<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Auth::routes(['verify' => true]);

Route::get('password/reset/{token}/{email}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', 'HomeController@index')->name('home')->middleware('verified', 'check.student');

    Route::get('candidato/getPolo', 'PsCandidatoController@getPolo')->name('candidato.getPolo');
    Route::get('candidato/getProcessoSeletivo', 'PsCandidatoController@getProcessoSeletivo')->name('candidato.getProcessoSeletivo');
    Route::get('candidato/getTabelaPrecos', 'PsCandidatoController@getTabelaPrecos')->name('candidato.getTabelaPrecos');
    Route::get('candidato/getCursos', 'PsCandidatoController@getCursos')->name('candidato.getCursos');

    Route::get('redefinir/senha', 'PsSenhaCandidatoController@index')->name('redefinir');
    Route::patch('update/senha', 'PsSenhaCandidatoController@update');

    Route::put('updateAuthUserPassword', 'Auth\ResetPasswordController@updateAuthUserPassword')->name('updateAuthUserPassword');
    Route::put('updateAuthUserEmail', 'Auth\ResetPasswordController@updateAuthUserEmail')->name('updateAuthUserEmail');

    Route::get('aluno/cursos/pos', 'CaAlunoController@listarCursosPos')->name('alunos.cursos.pos');
    Route::get('aluno/cursos/pos', 'CaAlunoController@listarCursosPos')->name('alunos.cursos.pos');
    Route::get('aluno/cursos/extensao', 'CaAlunoController@listarCursosExtensao')->name('alunos.cursos.extensao');

    Route::resource('alunos', 'CaAlunoController');
    Route::resource('candInscrNaoFin', 'PsCandInscrNaoFinController');
    Route::resource('candidato', 'PsCandidatoController');
    Route::resource('aluno/documentos', 'CaAlunoDoctoPendController', ['as' => 'aluno']);
    Route::get('financeiro', 'FinanceiroController@index')->name('aluno.financeiro.index');
    Route::post('financeiro/inicia/log', 'FinanceiroController@inicia_log')->name('aluno.financeiro.inicia.log');
    Route::post('financeiro/finalizar/pagamento', 'FinanceiroController@finalizar_pagamento')->name('aluno.financeiro.finalizar.pagamento');
    Route::get('financeiro/cartao/{titulo}', 'FinanceiroController@cartao')->middleware('get.net.token')->name('aluno.financeiro.cartao');
    Route::get('cep/{n_cep}', 'CepController@getCepByNumber')->name('cep.getCepByNumber');
});
