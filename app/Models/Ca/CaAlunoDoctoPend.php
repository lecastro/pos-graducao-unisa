<?php

namespace App\Models\Ca;

use Illuminate\Database\Eloquent\Model;
use DB;

class CaAlunoDoctoPend extends Model
{
    protected $table = 'ca_aluno_docto_pend';
    protected $primaryKey = ['cod_ra', 'cod_tp_docto'];
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'dat_pendencia',
        'obs_pendencia',
        'dat_entrega',
        'cod_usuario',
        'dat_inclusao',
        'dsc_link_arquivo',
        'dat_envio'
    ];

    //$cod_tp_doctos estiver vazia: retorna todos os docs. do usuário
    public function scopeDoctoPend($query){
         $query
        ->select([
            'ca_aluno_docto_pend.cod_ra',
            'ca_aluno_docto_pend.cod_tp_docto',
            'ca_aluno_docto_pend.obs_pendencia',
            'ca_aluno_docto_pend.dat_entrega',
            'ca_aluno_docto_pend.dsc_link_arquivo',
            'ca_aluno_docto_pend.dat_envio',
            DB::raw("(
                CASE
                    WHEN ca_aluno_docto_pend.cod_tp_docto = 175 THEN 'Diploma de Graduação'
                    WHEN ca_aluno_docto_pend.cod_tp_docto = 302 THEN 'Declaração de Conclusão do Ensino Superior'
                    WHEN ca_aluno_docto_pend.cod_tp_docto = 27 THEN 'Histórico do Ensino Superior'
                    ELSE b.dsc_tp_docto
                END
            ) AS dsc_tp_docto"),
            DB::raw("(
                CASE
                    WHEN ca_aluno_docto_pend.cod_tp_docto = 175 THEN 'filesDiploma'
                    WHEN ca_aluno_docto_pend.cod_tp_docto = 302 THEN 'filesDeclaracao'
                    WHEN ca_aluno_docto_pend.cod_tp_docto = 27 THEN 'filesHistorico'
                    ELSE 'files_'||b.cod_tp_docto
                END
            ) AS form_id")
        ])
        ->join('ca_tp_docto_pend b', 'ca_aluno_docto_pend.cod_tp_docto', '=',  'b.cod_tp_docto');

        return $query;
    }
}
