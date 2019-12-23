<?php

/**
 * @author Samuel Lopes
 *
 * Criado em: 05/11/2019
 * */

namespace App\Models\Ca;

use Illuminate\Database\Eloquent\Model;

class CaAlunoTelefone extends Model
{
    protected $table = 'ca_aluno_telefone';
    protected $primaryKey = ['cod_ra', 'ind_tp_tel_aluno'];
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'num_ddi_tel_aluno',
        'num_ddd_tel_aluno',
        'num_tel_aluno'
    ];
}
