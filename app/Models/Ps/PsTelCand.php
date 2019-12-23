<?php

/**
 * @author Samuel Lopes
 *
 * Criado em: 29/10/2019
 * */

namespace App\Models\Ps;

use Illuminate\Database\Eloquent\Model;
use \Awobaz\Compoships\Compoships;

class PsTelCand extends Model
{
    use Compoships;

    protected $table = 'ps_tel_cand';
    protected $primaryKey = ['cod_proc_seletivo', 'cod_inscricao', 'ind_tp_tel_cand'];
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'cod_proc_seletivo',
        'cod_inscricao',
        'ind_tp_tel_cand',
        'num_ddi_tel_cand',
        'num_ddd_tel_cand',
        'num_tel_cand',
        'num_ramal_tel_cand',
        'dsc_obs_tel_cand',
        'ind_tp_inscricao',
        'ind_tipo_msg'
    ];

    public function createOrUpdateTelCand(
        $cod_proc_seletivo,
        $cod_inscricao,
        $ind_tp_tel_cand,
        $num_ddd_tel_cand,
        $num_tel_cand)
    {
        $this->updateOrInsert(
            [
                'cod_proc_seletivo' => $cod_proc_seletivo,
                'cod_inscricao' => $cod_inscricao,
                'ind_tp_tel_cand' => $ind_tp_tel_cand
            ],
            [
                'num_ddi_tel_cand' => 55,
                'num_ddd_tel_cand' => $num_ddd_tel_cand,
                'ind_tp_inscricao' => null,
                'num_tel_cand' =>  $num_tel_cand
            ]
        );
    }

    public function psCandidato()
    {
        return $this->belongsTo(PsCandidato::class, ['cod_proc_seletivo', 'cod_inscricao'], ['cod_proc_seletivo', 'cod_inscricao']);
    }
}
