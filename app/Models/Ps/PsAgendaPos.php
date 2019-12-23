<?php

/**
 * @author Samuel Lopes
 *
 * Criado em: 29/10/2019
 * */

namespace App\Models\Ps;

use Illuminate\Database\Eloquent\Model;

class PsAgendaPos extends Model
{
    public $sequence = 'ps_agenda_pos_seq';
    protected $table = 'ps_agenda_pos';
    protected $primaryKey = 'cod_agenda_ead';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'cod_proc_seletivo',
        'ano_letivo',
        'num_seq_regime_ano_letivo',
        'anomes_ref',
        'ind_status',
        'cod_usuario',
        'dat_inclusao',
        'dat_inicio_inscr',
        'dat_term_inscr',
        'dat_inicio_matr',
        'dat_termino_matr',
        'dat_inicio_aulas',
        'dat_termino_aulas',
        'num_ident_cartorio',
        'num_reg_cartorio',
        'cod_conversao_pos',
        'dsc_os_user',
        'dsc_terminal',
        'dsc_host',
        'ind_transacao',
        'dat_transacao',
        'dsc_ip_address',
        'dat_lim_emiss_2_via_bol',
        'per_valid_inicial',
        'per_valid_final',
        'ind_dia_semana',
        'num_seq_regime_curr_curso',
    ];
}
