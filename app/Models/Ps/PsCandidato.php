<?php

/**
 * @author Samuel Lopes
 *
 * Criado em: 29/10/2019
 * */

namespace App\Models\Ps;

use App\Http\Requests\Ps\PsCandidatoRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PDO;
use Yajra\Pdo\Oci8\Exceptions\Oci8Exception;
use \Awobaz\Compoships\Compoships;

class PsCandidato extends Model
{
    use Compoships;

    protected $table = 'ps_candidato';
    protected $primaryKey = ['cod_proc_seletivo', 'cod_inscricao'];
    public $sequence = 'ps_candidato_seq';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'cod_proc_seletivo',
        'cod_inscricao',
        'num_ficha_inscricao',
        'cod_ra',
        'nom_candidato',
        'nom_primeiro',
        'nom_segundo',
        'nom_sobrenome',
        'nom_sufixo',
        'ind_tipo_docto_id',
        'cod_docto_id',
        'sig_uf_emis_docto_id',
        'sig_org_emis_docto_id',
        'dat_emis_docto_id',
        'dat_valid_docto_id',
        'num_cpf',
        'ind_sexo',
        'dat_nascimento',
        'nom_localid_nascto',
        'sig_uf_nascto',
        'dsc_nacionalidade',
        'end_logradouro',
        'end_numero',
        'end_complemento',
        'end_bairro',
        'end_localidade',
        'end_uf',
        'end_cep',
        'end_caixa_postal',
        'dsc_end_e_mail',
        'nom_primeiro_mae',
        'nom_segundo_mae',
        'nom_sobrenome_mae',
        'nom_sufixo_mae',
        'nom_primeiro_pai',
        'nom_segundo_pai',
        'nom_sobrenome_pai',
        'nom_sufixo_pai',
        'num_classificacao',
        'num_pontuacao',
        'dsc_respostas',
        'ind_status_cand',
        'dsc_gabarito',
        'dsc_resp_qsc',
        'dsc_profissao',
        'ind_grau_instr',
        'nom_mae',
        'nom_pai',
        'ind_escrita',
        'cod_est_civil',
        'ind_deficiente',
        'cod_gabarito',
        'cod_prova',
        'num_sala',
        'nom_curso_superior',
        'nom_inst_ensino',
        'dat_term_curso',
        'cod_ra_ant',
        'dat_inicio_curso',
        'num_contrato',
        'dat_inscricao',
        'num_serie_destino',
        'cod_turma_destino',
        'cod_titulo',
        'ind_tp_inscricao',
        'ind_status_inscricao',
        'cod_contrato',
        'cod_emp',
        'cod_re',
        'ind_pre_inscr',
        'ind_bolsista',
        'ind_descto',
        'val_nota_dissert',
        'cod_proc_sel_origem',
        'cod_inscr_origem',
        'ind_matr_cert_ext',
        'val_nota_redacao',
        'ind_result_enem',
        'ind_envio',
        'dat_envio_fcc',
        'val_nota_redacao_enem',
        'val_nota_redacao_ref',
        'ind_def_visual',
        'ind_def_auditiva',
        'ind_def_fisica',
        'num_class_2_fase',
        'cod_pais',
        'dat_envio_e_mail',
        'dat_envio_0800',
        'cod_usuario',
        'cod_ra_indicante',
        'cod_emp_indicante',
        'cod_re_indicante',
        'num_cupom',
        'nom_empresa',
        'cod_empresa',
        'cod_usuario_entr_cupom',
        'dat_entrega_cupom',
        'ind_ex_aluno',
        'ind_matr_liberada',
        'dsc_matr_liberada',
        'ind_tp_def_fisica',
        'ind_tp_def_visual',
        'ind_tp_def_auditiva',
        'nom_inst_ult_res_medica',
        'nom_localid_ult_res_medica',
        'sig_uf_ult_res_medica',
        'cod_inscricao_crm',
        'val_nota_prova_pratica',
        'cod_local_prova',
        'dsc_observacao',
        'val_nota_objetiva_enem',
        'cod_inscricao_enem',
        'cod_campus',
        'val_nota_objetiva_ref',
        'ind_premio_bolsa',
        'dsc_remote_addr',
        'dat_envio_ideal_invest',
        'ind_tp_transferencia',
        'cod_inscr_ftc',
        'cod_ra_ftc',
        'ind_sta_cand_origem',
        'dat_prova_agendada',
        'hro_prova_agendada',
        'ind_remaneja_vaga',
        'cod_cursinho',
        'ind_mult_esc_impress',
        'ind_red_impress',
        'ind_cor_raca',
        'ind_deficiencia',
        'ind_tp_def_cegueira',
        'ind_tp_def_bx_visao',
        'ind_tp_def_surdez',
        'ind_tp_def_audit',
        'ind_tp_def_fis',
        'ind_tp_def_sur_ceg',
        'ind_tp_def_multipla',
        'ind_tp_def_mental',
        'cod_emp_conv_abono_inscr',
        'dsc_chave_conv_abono_inscr',
        'cod_localid_nascto',
        'val_enem_ling_cod_tec',
        'val_enem_mat_tec',
        'val_enem_cie_hum_tec',
        'val_enem_cie_nat_tec',
        'cod_usuario_aprov',
        'ind_etp_1_matr_on_line',
        'ind_etp_2_matr_on_line',
        'ind_etp_3_matr_on_line',
        'ind_etp_4_matr_on_line',
        'proc_escola_publica',
        'ind_aceita_sms',
        'ind_tp_def_autismo',
        'ind_tp_def_asperger',
        'ind_tp_def_rett',
        'ind_tp_def_desintegrativo',
        'ind_tp_def_superdotacao',
        'dsc_url_twitter',
        'dsc_url_facebook',
        'ind_cod_educafro',
        'pct_bolsa_educafro',
        'ind_notific_matricula',
        'dat_envio_sms',
        'dat_envio_unite',
        'ind_parceria_maisestudo',
        'num_passaporte',
        'cod_pais_passaporte',
        'dat_emis_passaporte',
        'dat_valid_passaporte',
        'ind_def_mental',
        'val_media_nota_em',
        'ano_conclusao_em',
        'sg_uf_conclusao_em',
        'cod_localid_conclusao_em',
        'nom_escola_conclusao_em',
        'redacao_he',
        'redacao_he_tema',
        'redacao_he_nota',
        'redacao_he_login',
        'redacao_he_dtcorrecao',
        'ind_conhecimento_unisa',
        'ind_socio_sbait',
        'nom_candidato_social',
        'ind_def_multipla',
        'cid',
        'dsc_def_outras',
        'dat_realiz_prova'
    ];

    public function getInscricoesCandidato()
    {
        $sql = "SELECT op.cod_curso_ps
                    FROM ps_cand_opcao    op,
                         ps_candidato     ps,
                         ps_proc_seletivo p
                  WHERE ps.cod_proc_seletivo = op.cod_proc_seletivo
                    AND ps.cod_campus        = op.cod_campus
                    AND ps.cod_inscricao     = op.cod_inscricao
                    AND ps.num_cpf           = " . auth()->user()->num_cpf . "
                    AND op.cod_proc_seletivo = p.cod_proc_seletivo
                    AND sysdate BETWEEN p.dat_inicio_inscr_inter AND p.dat_term_inscr_inter";

        return DB::select(DB::raw($sql));
    }

    public function cursosFiltroInscricao($inscricoes, $cursos)
    {
        $aux = [];
        $i = 0;
        foreach ($cursos as $curso) {
            $aux[$i] = $curso;
            $aux[$i]->disabled = '';
            foreach ($inscricoes as $inscricao) {
                if ($inscricao->cod_curso_ps == $curso->cod_curso_ps) {
                    //formatar nome do curso
                    if ($aux[$i]->disabled != 'disabled') {
                        $aux[$i]->nom_curso_ps = $curso->nom_curso_ps . " - matrícula realizada";
                        $aux[$i]->disabled = 'disabled';
                    }
                    $aux[$i]->cod_curso_ps = 0; //para garantir q o aluno nao tente burlar
                    $aux[$i]->cod_curso_atual = 0; //idem
                }
            }
            $i++;
        }
        return $aux;
    }

    public function getConhecimentoUnisa()
    {
        $sql = "SELECT c.rv_low_value    cod,
                       c.rv_abbreviation dsc
                    FROM cg_ref_codes c
                  WHERE c.rv_domain = 'CONHECIMENTO_UNISA'";

        return DB::select(DB::raw($sql));
    }

    public function getPsAbertoPos()
    {
        $sql = "SELECT DISTINCT
                       prs.cod_proc_seletivo,
                       prs.dsc_proc_seletivo
                    FROM ps_proc_seletivo   prs,
                         ps_curso           psc,
                         ps_curso_oferecido ofe
                  WHERE ofe.ind_status               = 'A'
                    AND prs.ind_status               = 'A'
                    AND prs.dat_term_inscr_inter     >= trunc(sysdate)
                    AND ofe.cod_curso_ps             = psc.cod_curso_ps
                    AND prs.cod_proc_seletivo        = ofe.cod_proc_seletivo
                    AND prs.ind_distancia_presencial = 'D'
                    AND prs.cod_inst_ensino          = 19
                    AND prs.cod_niv_ens              = 13";

        return DB::select(DB::raw($sql));
    }

    public function getPsAbertoExtensao()
    {
        $sql = "SELECT DISTINCT
                       prs.cod_proc_seletivo,
                       prs.dsc_proc_seletivo
                    FROM ps_proc_seletivo   prs,
                         ps_curso           psc,
                         ps_curso_oferecido ofe
                  WHERE ofe.ind_status               = 'A'
                    AND prs.ind_status               = 'A'
                    AND prs.dat_term_inscr_inter     >= trunc(sysdate)
                    AND ofe.cod_curso_ps             = psc.cod_curso_ps
                    AND prs.cod_proc_seletivo        = ofe.cod_proc_seletivo
                    AND prs.ind_distancia_presencial = 'D'
                    AND prs.cod_inst_ensino          = 19
                    AND (prs.cod_niv_ens             = 10
                         OR prs.cod_niv_ens          = 7)";

        return DB::select(DB::raw($sql));
    }

    public function getPoloPorCursoExtensao($cod_curso_ps, $cod_proc_seletivo)
    {
        $sql = "SELECT DISTINCT
                       f.cod_campus,
                       g.nom_campus,
                       g.end_logr_campus  || ', '  || g.end_num_campus    || ' - ' ||
                       g.end_bairro_campus || ' - ' ||
                       g.end_local_campus || ' - ' || g.end_uf_campus     endereco
                    FROM ps_curso_oferecido        o,
                         ps_curso                  c,
                         ps_proc_seletivo          p,
                         g_campus                  g,
                         ps_campus_curso_oferecido f,
                         ps_campus_oferta          t
                         --, ps_agenda_pos ap
                  WHERE p.cod_proc_seletivo = o.cod_proc_seletivo
                    AND o.cod_proc_seletivo = f.cod_proc_seletivo
                    AND f.cod_campus        = g.cod_campus
                    AND p.cod_proc_seletivo = t.cod_proc_seletivo
                    AND o.cod_curso_ps      = '$cod_curso_ps'
                    AND p.cod_proc_seletivo = $cod_proc_seletivo
                    AND g.cod_campus        = t.cod_campus
                    AND p.ind_status        = 'A'
                    AND f.ind_status        = 'A'
                    AND o.ind_status        = 'A'
                    AND t.ind_status        = 'A'
                    AND p.cod_niv_ens       = 10
                    AND p.cod_inst_ensino   = 19
                    AND sysdate BETWEEN p.dat_inicio_inscr_inter AND p.dat_term_inscr_inter";

        return DB::select(DB::raw($sql));
    }

    public function getPoloPorCursoPs($cod_curso_ps, $cod_proc_seletivo)
    {
        $sql = "SELECT DISTINCT
                       f.cod_campus,
                       g.nom_campus,
                       g.end_logr_campus  || ', '  || g.end_num_campus    || ' - ' || g.end_bairro_campus || ' - ' ||
                       g.end_local_campus || ' - ' || g.end_uf_campus     endereco, g.end_uf_campus 
                    FROM ps_curso_oferecido        o,
                         ps_curso                  c,
                         ps_proc_seletivo          p,
                         g_campus                  g,
                         ps_campus_curso_oferecido f,
                         ps_campus_oferta          t,
                         ps_agenda_pos             ap
                  WHERE p.cod_proc_seletivo  = o.cod_proc_seletivo
                    AND o.cod_proc_seletivo  = f.cod_proc_seletivo
                    AND f.cod_campus         = g.cod_campus
                    AND p.cod_proc_seletivo  = t.cod_proc_seletivo
                    AND o.cod_curso_ps       = '$cod_curso_ps'
                    AND p.cod_proc_seletivo  = $cod_proc_seletivo
                    AND g.cod_campus         = t.cod_campus
                    AND p.ind_status         = 'A'
                    AND f.ind_status         = 'A'
                    AND o.ind_status         = 'A'
                    AND t.ind_status         = 'A'
                    AND p.cod_niv_ens        = 13 --ou 7
                    AND ap.cod_proc_seletivo = p.cod_proc_seletivo
                    AND ap.ano_letivo        = p.ano_letivo
                    AND o.cod_curso_ps       = c.cod_curso_ps
                    AND sysdate BETWEEN p.dat_inicio_inscr_inter AND p.dat_term_inscr_inter
                    AND sysdate BETWEEN ap.dat_inicio_inscr      AND ap.dat_term_inscr
                    ORDER BY g.end_uf_campus ASC";

        return DB::select(DB::raw($sql));
    }

    public function insereCandidatoPos(PsCandidatoRequest $request)
    {

        $cod_niv_ens = intval($request->cod_niv_ens);

        //ESTATICO POIS A PROCEDURE N ESTA PEGANDO ESSE DIA
        if ($cod_niv_ens == 13) {
            //CASO SEJA POS
            $diaSemana1 = 2;
        } elseif ($cod_niv_ens == 10) {
            //CASO SEJA EXTENSAO
            $diaSemana1 = 5;
        } else {
            //DEFAULT
            $diaSemana1 = NULL;
        }

        //aluno já se inscreveu em 3 cursos de extensão
        if ($cod_niv_ens != 13 && getTodasIncricoesExtensao($request->cod_proc_seletivo) >= 4) {
            return NULL;
        }

        try {
            $pnuminscricao = null; //output
            $pdo = DB::getPdo();

            //** DADOS OBRIGATÓRIOS DA TAB PS_CANDIDATO **//
            $codProcSeletivo = $request->cod_proc_seletivo;
            $nome =  $request->nom_candidato;
            $sexo =  $request->ind_sexo;
            $cpf =  auth()->user()->num_cpf;
            $dtnasc = $request->dat_nascimento;
            $email = auth()->user()->email;
            $dddc1 = $request->dddf;
            $dddc2 = $request->dddc;
            $dddf = $request->dddf;
            $dddc = $request->dddc;
            $telefonef = $request->telefonef;
            $telefonec = $request->telefonec;
            $cel1 = $request->telefonec;
            $cel2 =  $request->telefonec;
            $codcurso1 = $request->cod_curso_ps;
            $cep = $request->end_cep;
            $ender = $request->end_logradouro;
            $num = $request->end_numero;
            $compl = $request->end_complemento;
            $bairro = $request->end_bairro;
            $cidade =  $request->end_localidade;
            $uf = $request->end_uf;
            $codcampus1 = $request->cod_campus;
            $num_tab_preco_curso = $request->num_tab_preco_curso;
            //** FIM DADOS OBRIG.  **//

            //igual o formulário antigo
            $tppsv = 1;

            //** DEMAIS CAMPOS **//
            $codcampus2 = null;
            $unidade = null;
            $dtagenda = null;
            $def = null;
            $tpdef = null;
            $cor = null;
            $escrita = null;
            $sms = null;
            $unisa = null;
            $sobrnm = null;
            $emailc = null;
            $codcurso2 = null;
            $selectcmsoube = null;

            $diaSemana2 = null;
            $maisestudo = null;
            $aceitoeditalcurso = null;
            $enemhist = null;
            $inscrienem = null;
            $notaenem = null;
            $nomeescola = null;
            $anoconclu = null;
            $estadohist = null;
            $cidadehist = null;
            $notahist = null;
            $vnmcurso1 = null;
            $vdscpolo1 = null;
            $vnmcurso2 = null;
            $vdscpolo2 = null;
            $necrec = null;
            $redhe = null;
            $temahe = null;
            $codtemahe = null;
            $rg = null;
            $rgoe = null;
            $rguf = null;
            $instens = null;
            $dtter = null;
            $profissao = null;
            $quest1 = null;
            $quest2 = null;
            $cursopos = null;
            $instpos = null;
            $titulacao = null;
            $dtterpos = null;
            $outroscursos = null;
            $check1 = null;
            $empresa = null;
            $tempoemp = null;
            $ramo = null;
            $porte = null;
            $cargo = null;
            $tempocargo = null;
            $chksbait = null;
            $cat = null;
            $cat = null;
            //** FIM CAMPOS **//

            $stmt = $pdo->prepare(
                "DECLARE pnuminscricao NUMBER;
                    BEGIN
                        insereCandidatoPos(
                            :codProcSeletivo,
                            :nome,
                            :sexo,
                            :cpf,
                            :dtnasc,
                            :email,
                            :emailc,
                            :dddf,
                            :telefonef,
                            :dddc,
                            :telefonec,
                            :codcurso1,
                            :codcurso2,
                            :cep,
                            :ender,
                            :num,
                            :compl,
                            :bairro,
                            :cidade,
                            :uf,
                            :codcampus1,
                            :codcampus2,
                            :unidade,
                            :dtagenda,
                            :def,
                            :tpdef,
                            :cor,
                            :escrita,
                            :sms,
                            :unisa,
                            :sobrnm,
                            :tppsv,
                            :cel1,
                            :cel2,
                            :selectcmsoube,
                            :dddc1,
                            :dddc2,
                            :diaSemana1,
                            :diaSemana2,
                            :maisestudo,
                            :aceitoeditalcurso,
                            :enemhist,
                            :inscrienem,
                            :notaenem,
                            :nomeescola,
                            :anoconclu,
                            :estadohist,
                            :cidadehist,
                            :notahist,
                            :vnmcurso1,
                            :vdscpolo1,
                            :vnmcurso2,
                            :vdscpolo2,
                            :necrec,
                            :redhe,
                            :temahe,
                            :codtemahe,
                            :pnuminscricao,
                            :rg,
                            :rgoe,
                            :rguf,
                            :instens,
                            :dtter,
                            :profissao,
                            :quest1,
                            :quest2,
                            :cursopos,
                            :instpos,
                            :titulacao,
                            :dtterpos,
                            :outroscursos,
                            :check1,
                            :empresa,
                            :tempoemp,
                            :ramo,
                            :porte,
                            :cargo,
                            :tempocargo,
                            :chksbait,
                            :cat,
                            :num_tab_preco_curso
                        );
                    END;"
            );

            $stmt->bindParam(':codProcSeletivo', $codProcSeletivo, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':nome', $nome, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':sexo', $sexo, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':cpf', $cpf, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':dtnasc', $dtnasc, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':emailc', $emailc, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':dddf', $dddf, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':telefonef', $telefonef, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':dddc', $dddc, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':telefonec', $telefonec, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':codcurso1', $codcurso1, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':codcurso2', $codcurso2, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':cep', $cep, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':ender', $ender, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':num', $num, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':compl', $compl, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':bairro', $bairro, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':cidade', $cidade, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':uf', $uf, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':codcampus1', $codcampus1, PDO::PARAM_INT);
            $stmt->bindParam(':codcampus2', $codcampus2, PDO::PARAM_INT);
            $stmt->bindParam(':unidade', $unidade, PDO::PARAM_INT);
            $stmt->bindParam(':dtagenda', $dtagenda, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':def', $def, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':tpdef', $tpdef, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':cor', $cor, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':escrita', $escrita, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':sms', $sms, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':unisa', $unisa, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':sobrnm', $sobrnm, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':tppsv', $tppsv, PDO::PARAM_INT);
            $stmt->bindParam(':cel1', $cel1, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':cel2', $cel2, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':selectcmsoube', $selectcmsoube, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':dddc1', $dddc1, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':dddc2', $dddc2, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':diaSemana1', $diaSemana1, PDO::PARAM_INT);
            $stmt->bindParam(':diaSemana2', $diaSemana2, PDO::PARAM_INT);
            $stmt->bindParam(':maisestudo', $maisestudo, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':aceitoeditalcurso', $aceitoeditalcurso, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':enemhist', $enemhist, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':inscrienem', $inscrienem, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':notaenem', $notaenem, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':nomeescola', $nomeescola, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':anoconclu', $anoconclu, PDO::PARAM_INT);
            $stmt->bindParam(':estadohist', $estadohist, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':cidadehist', $cidadehist, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':notahist', $notahist, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':vnmcurso1', $vnmcurso1, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':vdscpolo1', $vdscpolo1, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':vnmcurso2', $vnmcurso2, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':vdscpolo2', $vdscpolo2, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':necrec', $necrec, PDO::PARAM_INT);
            $stmt->bindParam(':redhe', $redhe, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':temahe', $temahe, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':codtemahe', $codtemahe, PDO::PARAM_INT);
            $stmt->bindParam(':pnuminscricao', $pnuminscricao, PDO::PARAM_INPUT_OUTPUT, 4000);
            $stmt->bindParam(':rg', $rg, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':rgoe', $rgoe, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':rguf', $rguf, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':instens', $instens, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':dtter', $dtter, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':profissao', $profissao, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':quest1', $quest1, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':quest2', $quest2, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':cursopos', $cursopos, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':instpos', $instpos, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':titulacao', $titulacao, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':dtterpos', $dtterpos, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':outroscursos', $outroscursos, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':check1', $check1, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':empresa', $empresa, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':tempoemp', $tempoemp, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':ramo', $ramo, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':porte', $porte, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':cargo', $cargo, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':tempocargo', $tempocargo, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':chksbait', $chksbait, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':cat', $cat, PDO::PARAM_INT);
            $stmt->bindParam(':num_tab_preco_curso', $num_tab_preco_curso, PDO::PARAM_STR, 4000);

            //** DEIXAR COM DOIS **//
            $stmt->execute();
            $stmt->execute();

            return $pnuminscricao;
        } catch (Oci8Exception $e) { }
    }

    //QUERY DE CURSOS DE EXTENSAO ONDE:
    //  -- NAO MOSTRA OS CURSOS Q O ALUNO JA SE INSCREVEU
    //  -- NAO MOSTRA OS CURSOS Q NÃO POSSUEM TABELA DE PREÇO
    //verificar se compensa adaptar
    //todas as requests e a funcao no controler
    private function verificar()
    {
        $sql = "SELECT DISTINCT
                       c.cod_curso_ps,
                       c.nom_curso_ps,
                       c.cod_curso_atual,
                       p.per_valid_inicial,
                       p.per_valid_final
                    FROM ps_curso_oferecido        o,
                         ps_curso                  c,
                         ps_proc_seletivo          p,
                         ps_campus_curso_oferecido f
                  WHERE p.cod_proc_seletivo = o.cod_proc_seletivo
                    AND o.cod_proc_seletivo = f.cod_proc_seletivo
                    AND p.ind_status        = 'A'
                    AND f.ind_status        = 'A'
                    AND o.ind_status        = 'A'
                    AND p.cod_proc_seletivo = 1608
                    AND o.cod_curso_ps      = c.cod_curso_ps
                    AND f.cod_curso_ps      = c.cod_curso_ps
                    AND p.cod_niv_ens       = 10
                    AND p.cod_inst_ensino   = 19
                    AND sysdate BETWEEN p.dat_inicio_inscr_inter AND p.dat_term_inscr_inter
                    AND EXISTS (SELECT 1
                                    FROM f_tab_preco_curso ftp
                                  WHERE ftp.cod_curso                = c.cod_curso_atual
                                    AND ftp.ind_tp_tab_preco         = 'E'
                                    AND ftp.cod_campus               = f.cod_campus
                                    AND trunc(ftp.per_valid_inicial) = trunc(p.per_valid_inicial)
                                    AND trunc(ftp.per_valid_final)   = trunc(p.per_valid_final))
                    AND NOT EXISTS (SELECT 1
                                        FROM ps_cand_opcao op,
                                             ps_candidato  ps
                                      WHERE ps.cod_proc_seletivo = op.cod_proc_seletivo
                                        AND ps.cod_campus        = op.cod_campus
                                        AND ps.cod_inscricao     = op.cod_inscricao
                                        AND op.cod_curso_ps      = o.cod_curso_ps
                                        AND ps.cod_proc_seletivo = o.cod_proc_seletivo
                                        AND ps.cod_inscricao     = 101845138)";
    }

    public function getCursosPsExtensao($cod_niv_ens, $cod_proc_seletivo)
    {
        $sql = "SELECT DISTINCT
                       c.cod_curso_ps,
                       c.nom_curso_ps,
                       c.cod_curso_atual,
                       p.per_valid_inicial,
                       p.per_valid_final
                    FROM ps_curso_oferecido        o,
                         ps_curso                  c,
                         ps_proc_seletivo          p,
                         ps_campus_curso_oferecido f
                  WHERE p.cod_proc_seletivo = o.cod_proc_seletivo
                    AND o.cod_proc_seletivo = f.cod_proc_seletivo
                    AND p.ind_status        = 'A'
                    AND f.ind_status        = 'A'
                    AND o.ind_status        = 'A'
                    AND p.cod_proc_seletivo = $cod_proc_seletivo
                    AND o.cod_curso_ps      = c.cod_curso_ps
                    AND f.cod_curso_ps      = c.cod_curso_ps
                    AND p.cod_niv_ens       = 10
                    AND p.cod_inst_ensino   = 19
                    AND sysdate BETWEEN p.dat_inicio_inscr_inter AND p.dat_term_inscr_inter
                    AND EXISTS (SELECT 1
                                    FROM f_tab_preco_curso ftp
                                  WHERE ftp.cod_curso                = c.cod_curso_atual
                                    AND ftp.ind_tp_tab_preco         = 'E'
                                    AND ftp.cod_campus               = f.cod_campus
                                    AND trunc(ftp.per_valid_inicial) = trunc(p.per_valid_inicial)
                                    )
                                    ORDER BY  c.nom_curso_ps ASC
                                    ";

        return DB::select(DB::raw($sql));
    }

    public function getCampusCursoPosPresencial($cod_curso_ps, $cod_proc_seletivo)
    {

        $sql = "SELECT DISTINCT
            gc.cod_campus,
            g.nom_campus,
            g.end_logr_campus  || ', '  || g.end_num_campus    || ' - ' || g.end_bairro_campus || ' - ' ||
            g.end_local_campus || ' - ' || g.end_uf_campus     endereco
        FROM ps_curso_oferecido        o,
            ps_curso                  c,
            gc_curso                  gc,
            ps_proc_seletivo          p,
            g_campus                  g,
        
            ps_agenda_pos             ap
        WHERE p.cod_proc_seletivo  = o.cod_proc_seletivo
            AND c.cod_curso_atual   = gc.cod_curso
            AND gc.cod_campus         = g.cod_campus         
            AND o.cod_curso_ps       = '$cod_curso_ps'
            AND p.cod_proc_seletivo  = $cod_proc_seletivo
            AND p.ind_status         = 'A'
            AND o.ind_status         = 'A'            
            AND p.cod_niv_ens        = 13 
            AND ap.cod_proc_seletivo = p.cod_proc_seletivo
            AND ap.ano_letivo        = p.ano_letivo
            AND o.cod_curso_ps       = c.cod_curso_ps
            AND sysdate BETWEEN ap.dat_inicio_inscr  AND ap.dat_term_inscr";


        return DB::select(DB::raw($sql));
    }

    public function getCursosPsPosPresencial($cod_niv_ens, $cod_proc_seletivo, $modalidade){
        $sql = "SELECT      b.cod_curso_ps,
                    b.nom_curso_ps,
                    b.cod_curso_atual,
                    ap.per_valid_inicial,
                    ap.per_valid_final,
                    c.cod_campus
                FROM PS_CURSO_OFERECIDO A,
                    PS_CURSO           B,
                    GC_CURSO           C,
                    GC_CURSO_CURRICULO D,
                    ps_proc_seletivo          p,
                    ps_agenda_pos             ap
                WHERE A.COD_CURSO_PS       =  B.COD_CURSO_PS
                    AND B.COD_CURSO_ATUAL     = C.COD_CURSO
                    AND C.COD_CURSO           = D.COD_CURSO
                    AND A.COD_CURR           = D.COD_CURR
                    AND p.COD_PROC_SELETIVO  = $cod_proc_seletivo
                    AND p.cod_niv_ens        = $cod_niv_ens
                    AND A.IND_STATUS         = 'A'
                    AND ap.cod_proc_seletivo = p.cod_proc_seletivo
                    AND ap.ano_letivo        = p.ano_letivo
                    AND  p.ind_distancia_presencial = '$modalidade'
                    AND p.cod_proc_seletivo  = a.cod_proc_seletivo
                    AND sysdate BETWEEN ap.dat_inicio_inscr AND ap.dat_term_inscr
                    AND EXISTS (SELECT 1
                                    FROM f_tab_preco_curso ftp
                                    WHERE ftp.cod_curso                = b.cod_curso_atual
                                        AND ftp.ind_tp_tab_preco         = 'P'
                                        AND ftp.cod_campus               = c.cod_campus
                                        AND trunc(ftp.per_valid_inicial) = trunc(ap.per_valid_inicial))
                                ORDER BY  b.nom_curso_ps ASC";
        return DB::select(DB::raw($sql));
    }

    public function getCursosPsPos($cod_niv_ens, $cod_proc_seletivo, $modalidade)
    {
        $sql = "SELECT DISTINCT
                    c.cod_curso_ps,
                    c.nom_curso_ps,
                    c.cod_curso_atual,
                    ap.per_valid_inicial,
                    ap.per_valid_final
                FROM ps_curso_oferecido        o,
                    ps_curso                  c,
                    ps_proc_seletivo          p,
                    ps_campus_curso_oferecido f,
                    ps_agenda_pos             ap
                WHERE p.cod_proc_seletivo  = o.cod_proc_seletivo
                    AND o.cod_proc_seletivo  = f.cod_proc_seletivo
                    AND p.ind_status         = 'A'
                    AND f.ind_status         = 'A'
                    AND o.ind_status         = 'A'
                    AND p.cod_proc_seletivo  = $cod_proc_seletivo
                    AND o.cod_curso_ps       = c.cod_curso_ps
                    AND f.cod_curso_ps       = c.cod_curso_ps
                    AND p.cod_niv_ens        = $cod_niv_ens
                    AND ap.cod_proc_seletivo = p.cod_proc_seletivo
                    AND ap.ano_letivo        = p.ano_letivo
                    AND p.ind_distancia_presencial = '$modalidade'
                    AND sysdate BETWEEN ap.dat_inicio_inscr AND ap.dat_term_inscr
                    AND EXISTS (SELECT 1
                                    FROM f_tab_preco_curso ftp
                                WHERE ftp.cod_curso                = c.cod_curso_atual
                                    AND ftp.ind_tp_tab_preco         = 'P'
                                    AND ftp.cod_campus               = f.cod_campus
                                    AND trunc(ftp.per_valid_inicial) = trunc(ap.per_valid_inicial))
                                    ORDER BY  c.nom_curso_ps ASC";

        return DB::select(DB::raw($sql));
    }

    public function psCandOpcao()
    {
        return $this->hasMany(PsCandOpcao::class, ['cod_proc_seletivo', 'cod_inscricao'], ['cod_proc_seletivo', 'cod_inscricao']);
    }

    public function psTelCand()
    {
        return $this->hasMany(PsTelCand::class, ['cod_proc_seletivo', 'cod_inscricao'], ['cod_proc_seletivo', 'cod_inscricao']);
    }
}
