<?php

/**
 * @author Samuel Lopes
 *
 * Criado em: 29/10/2019
 * */

namespace App\Models\Ps;

use Illuminate\Database\Eloquent\Model;
use \Awobaz\Compoships\Compoships;

class PsCandOpcao extends Model
{
    use Compoships;

    protected $table = 'ps_cand_opcao';
    protected $primaryKey = ['cod_proc_seletivo', 'cod_inscricao', 'cod_curso_ps', 'num_opcao'];
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'cod_proc_seletivo',
        'cod_inscricao',
        'cod_curso_ps',
        'num_opcao',
        'num_pontuacao',
        'num_classificacao',
        'num_chamada',
        'dat_inicio_matr',
        'dat_termino_matr',
        'dat_prorrogacao_matr',
        'cod_turma',
        'cod_periodo',
        'ind_status_matr',
        'ind_status_inscricao',
        'cod_titulo',
        'ind_tp_inscricao',
        'cod_usuario_prorrogacao_matr',
        'dat_alteracao_prorrogacao_matr',
        'cod_usuario',
        'dat_inclusao',
        'cod_usuario_class',
        'dat_class',
        'ind_dia_semana',
        'num_chamada_2_fase',
        'num_pontos_2_fase',
        'num_class_2_fase',
        'dsc_observacao',
        'dat_limite_prorrogacao',
        'cod_agenda_ead',
        'cod_campus'
    ];

    public function psCandidato()
    {
        return $this->belongsTo(PsCandidato::class, ['cod_proc_seletivo', 'cod_inscricao'], ['cod_proc_seletivo', 'cod_inscricao']);
    }
}
