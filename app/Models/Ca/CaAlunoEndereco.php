<?php

/**
 * @author Samuel Lopes
 *
 * Criado em: 05/11/2019
 * */

namespace App\Models\Ca;

use Illuminate\Database\Eloquent\Model;

class CaAlunoEndereco extends Model
{
    protected $table = 'ca_aluno_endereco';
    protected $primaryKey = ['ind_tp_end_aluno', 'cod_ra'];
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'end_logr_aluno',
        'end_num_aluno',
        'end_compl_aluno',
        'end_bairro_aluno',
        'end_localid_aluno',
        'end_uf_aluno',
        'end_cep_aluno',
        'end_caixa_postal',
        'ind_end_corresp',
        'cod_pais',
        'cod_usuario',
        'dat_inclusao'
    ];
}
