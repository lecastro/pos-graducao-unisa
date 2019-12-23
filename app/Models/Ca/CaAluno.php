<?php

/**
 * @author Samuel Lopes
 *
 * Criado em: 05/11/2019
 * */

namespace App\Models\Ca;

use Illuminate\Database\Eloquent\Model;

class CaAluno extends Model
{
    protected $table = 'ca_aluno';
    protected $primaryKey = 'cod_ra';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'nom_primeiro_aluno',
        'nom_segundo_aluno',
        'nom_sobrenome_aluno',
        'nom_sufixo_aluno',
        'nom_primeiro_mae',
        'nom_segundo_mae',
        'nom_sobrenome_mae',
        'nom_sufixo_mae',
        'nom_primeiro_pai',
        'nom_segundo_pai',
        'nom_sobrenome_pai',
        'nom_sufixo_pai',
        'ind_sexo',
        'ind_tipo_docto_id',
        'cod_docto_id',
        'sig_uf_emis_docto_id',
        'sig_org_emis_docto_id',
        'dat_emis_docto_id',
        'dat_valid_docto_id',
        'num_cpf',
        'num_tit_eleitor',
        'num_secao_tit_eleitor',
        'num_zona_tit_eleitor',
        'nom_localid_tit_eleitor',
        'sig_uf_tit_eleitor',
        'num_docto_militar',
        'nom_docto_militar',
        'nom_orgao_emis_militar',
        'nom_repar_militar',
        'ano_exped_docto_militar',
        'ind_serie_docto_militar',
        'num_cart_trab',
        'nom_regiao_militar',
        'num_serie_cart_trab',
        'sig_uf_cart_trab',
        'dat_nascimento',
        'nom_localid_nascto',
        'sig_uf_nascto',
        'nom_pais_nascto',
        'num_passaporte',
        'nom_pais_passaporte',
        'dat_emis_passaporte',
        'dat_valid_passaporte',
        'ind_tp_visto',
        'dat_visto',
        'dat_valid_visto',
        'ind_est_civil',
        'dsc_end_e_mail',
        'ind_emancipacao',
        'cod_religiao',
        'ind_def_fisica',
        'ind_def_visual',
        'ind_def_auditiva',
        'ind_escrita',
        'nom_aluno',
        'nom_pai',
        'nom_mae',
        'cod_senha',
        'cod_usuario',
        'dat_inclusao',
        'cod_pais_nascto',
        'ind_inad_ano_anterior',
        'ind_inad_ano_atual',
        'ind_inad_mes_atual',
        'dat_ref_inad',
        'cod_pais_passaporte',
        'ind_recebe_nf_email',
        'ind_inad_mes_anterior',
        'dig_docto_id',
        'ind_tp_def_fisica',
        'ind_tp_def_visual',
        'ind_tp_def_auditiva',
        'dat_envio_esc_cobr',
        'dat_envio_bib_virtual',
        'dat_envio_xerox',
        'cod_ra_ftc',
        'cod_ra_fasf',
        'ind_negativ_serasa',
        'num_crm',
        'dat_inscricao_crm',
        'dat_expedicao_crm',
        'sig_uf_emiss_crm',
        'ind_negativ_spc',
        'ind_permite_negativacao',
        'ind_deficiencia',
        'ind_tp_def_cegueira',
        'ind_tp_def_bx_visao',
        'ind_tp_def_surdez',
        'ind_tp_def_audit',
        'ind_tp_def_fis',
        'ind_tp_def_sur_ceg',
        'ind_tp_def_multipla',
        'ind_tp_def_mental'
    ];

    public function getCursos($ra, $cod_niv_ens)
    {
        $aluno = $this->join('ca_matricula', 'ca_aluno.cod_ra', 'ca_matricula.cod_ra')
            ->join('gc_curso', 'ca_matricula.cod_curso', 'gc_curso.cod_curso')
            ->where('ca_aluno.cod_ra', $ra)
            ->where('gc_curso.cod_niv_ens', $cod_niv_ens)
            ->select(['gc_curso.nom_curso'])
            ->get();
    }
}
