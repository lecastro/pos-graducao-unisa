<?php

namespace App\Models\Ps;

use Illuminate\Database\Eloquent\Model;

class PsCandInscrNaoFin extends Model
{
    protected $table = 'ps_cand_inscr_nao_fin';
    protected $primaryKey = 'codseq';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'cod_proc_seletivo',
        'nom_candidato',
        'nom_primeiro',
        'nom_sobrenome',
        'dsc_end_e_mail',
        'dsc_observacao',
        'cod_campus_prova_ag',
        'dat_prova_agendada',
        'hro_prova_agendada',
        'ind_conhecimento_unisa',
        'ind_aceita_sms',
        'cod_curso_ps1',
        'cod_campus_cur1',
        'ind_dia_semana1',
        'ind_turno1',
        'cod_curso_ps2',
        'cod_campus_cur2',
        'ind_dia_semana2',
        'ind_turno2',
        'dddf',
        'telefonef',
        'dddc',
        'telefonec',
        'dat_inclusao',
        'num_cpf',
        'ind_sexo',
        'dat_nascimento',
        'end_logradouro',
        'end_numero',
        'end_complemento',
        'end_bairro',
        'end_localidade',
        'end_uf',
        'end_cep',
        'ind_deficiente',
        'ind_def_visual',
        'ind_def_auditiva',
        'ind_def_fisica',
        'ind_def_mental',
        'ind_escrita',
        'ind_parceria_maisestudo',
        'val_nota_redacao_enem',
        'cod_inscricao_enem',
        'val_media_nota_em',
        'ano_conclusao_em',
        'sg_uf_conclusao_em',
        'cod_localid_conclusao_em',
        'nom_escola_conclusao_em',
        'redacao_he',
        'redacao_he_tema',
        'rg_nr',
        'rg_oe',
        'rg_uf',
        'codseq'
    ];

    public function getMaxCodSeq()
    {
        return $this->max('codseq');
    }

    public function getCpf($num_cpf)
    {
        return $this->where('num_cpf', $num_cpf)->first();
    }

    //verifcar o interesse do aluno no curso.
    public function getInteresseCurso($cod_pro, $num_cpf, $cod_curso, $cod_campus)
    {
        return $this->where(['cod_proc_seletivo' => $cod_pro, 'num_cpf' => $num_cpf, 'cod_curso_ps1' => $cod_curso, 'cod_campus_cur1' => $cod_campus])->first();
    }
}
