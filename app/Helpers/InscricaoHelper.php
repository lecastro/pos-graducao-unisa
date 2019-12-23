<?php

use Illuminate\Support\Facades\DB;

function getTodasIncricoesExtensao($cod_proc_seletivo)
{
    $count = 0;

    $sql = "select count(*) total
    from ps_cand_opcao     op,
        ps_candidato       ps,
        ps_proc_seletivo   p,
        ps_curso_oferecido o,
        ps_curso           c,
        f_contrato         fc,
        f_titulo           ft,
        g_nivel_ensino     ns
    where p.cod_proc_seletivo          = o.cod_proc_seletivo
        and p.cod_proc_seletivo  = $cod_proc_seletivo
    and o.cod_curso_ps             = op.cod_curso_ps
        and op.cod_curso_ps            = c.cod_curso_ps
        and ps.cod_proc_seletivo       = op.cod_proc_seletivo
        and ps.cod_inscricao           = op.cod_inscricao
        and op.cod_proc_seletivo       = p.cod_proc_seletivo
        and ps.num_cpf                 = '".auth()->user()->num_cpf."'
        and p.ind_distancia_presencial = 'P'
        and p.cod_niv_ens              in (10, 7)
        and p.cod_niv_ens           = ns.cod_niv_ens
        and fc.cod_contrato            = ft.cod_contrato
        and fc.cod_contrato            = ps.num_contrato";

    try {
       
        $count = DB::connection(env('DB_CONNECTION_METODO_DEFAULT'))
        ->select(DB::raw($sql));

        $count = intval($count[0]->total);
        
    } catch (Exception $a) {
        return NULL;
    }

    return $count;
}

function getInscricoesCandidato($num_cpf)
{
    $sql = "select distinct
        op.cod_inscricao,
        op.cod_curso_ps,
        c.nom_curso_ps,
        ns.nom_niv_ens,
        ps.num_contrato,
        ft.cod_titulo,
        p.dat_term_inscr_inter,
        op.cod_campus,
        camp.nom_campus
    from ps_cand_opcao     op,
        ps_candidato       ps,
        ps_proc_seletivo   p,
        ps_curso_oferecido o,
        ps_curso           c,
        f_contrato         fc,
        f_titulo           ft,
        g_nivel_ensino     ns,
        g_campus          camp
    where p.cod_proc_seletivo          = o.cod_proc_seletivo
        and o.cod_curso_ps             = op.cod_curso_ps
        and op.cod_curso_ps            = c.cod_curso_ps
        and ps.cod_proc_seletivo       = op.cod_proc_seletivo
        and ps.cod_inscricao           = op.cod_inscricao
        and op.cod_proc_seletivo       = p.cod_proc_seletivo
        and ps.num_cpf                 = $num_cpf
        and ps.cod_campus              = camp.cod_campus
        --and p.ind_distancia_presencial = 'D'
        and p.cod_niv_ens              in (13, 10, 7)
        and p.cod_niv_ens           = ns.cod_niv_ens
        and sysdate between p.dat_inicio_inscr_inter and p.dat_term_inscr_inter
        and fc.cod_contrato            = ft.cod_contrato
        and fc.cod_contrato            = ps.num_contrato
        and to_char(fc.dat_inicio, 'YYYYMM') = ft.anomes_titulo";

    return DB::select(DB::raw($sql));
}

function getConhecimentoUnisa()
{
    $sql = "select c.rv_low_value cod, c.rv_abbreviation dsc
    from cg_ref_codes c
    where c.rv_domain = 'CONHECIMENTO_UNISA'";

    return DB::select(DB::raw($sql));
}

function getPsAbertoPos($modalidade)
{
    $sql = "select distinct prs.cod_proc_seletivo  cod_proc_seletivo,
            prs.dsc_proc_seletivo  dsc_proc_seletivo
            from  ps_proc_seletivo prs, ps_curso psc,
                ps_curso_oferecido ofe,  ps_agenda_pos  ap
            where ofe.ind_status = 'A'
            and   prs.ind_status = 'A'
            and   ofe.cod_curso_ps = psc.cod_curso_ps
            and   prs.cod_proc_seletivo = ofe.cod_proc_seletivo
            AND   ap.cod_proc_seletivo = prs.cod_proc_seletivo
            AND   ap.ano_letivo        = prs.ano_letivo
            AND   sysdate BETWEEN ap.dat_inicio_inscr AND ap.dat_term_inscr
            and prs.dat_prova is null
            and   prs.ind_distancia_presencial = '$modalidade'
            and   prs.cod_inst_ensino = 19
            and   prs.cod_niv_ens = 13";

    return DB::select(DB::raw($sql));
}

function getPsAbertoExtensao()
{
    $sql = "select distinct prs.cod_proc_seletivo,
        prs.dsc_proc_seletivo  dsc_proc_seletivo
        from  ps_proc_seletivo prs, ps_curso psc,
            ps_curso_oferecido ofe
        where ofe.ind_status = 'A'
            and   prs.ind_status = 'A'
            and sysdate between prs.dat_inicio_inscr_inter and prs.dat_term_inscr_inter
            and   ofe.cod_curso_ps = psc.cod_curso_ps
            and   prs.cod_proc_seletivo = ofe.cod_proc_seletivo
            and   prs.ind_distancia_presencial = 'P'
            and   prs.cod_inst_ensino = 19
            and   (prs.cod_niv_ens = 10 or prs.cod_niv_ens = 7) ";

    return DB::select(DB::raw($sql));
}

function getProcessoSeletivo($cod_curso_ps, $cod_campus, $cod_niv_ens)
{
    $sql = "select * from
                (select prs.cod_proc_seletivo
                    from  ps_proc_seletivo prs, ps_curso psc,
                        ps_curso_oferecido ofe, ps_campus_curso_oferecido cco
                    where ofe.ind_status = 'A'
                        and   prs.ind_status = 'A'
                        and   cco.cod_campus = $cod_campus
                        and   ofe.cod_curso_ps = '$cod_curso_ps'
                        and   prs.cod_niv_ens = $cod_niv_ens
                        and sysdate between prs.dat_inicio_inscr_inter and prs.dat_term_inscr_inter
                        and   ofe.cod_curso_ps = psc.cod_curso_ps
                        and   prs.cod_proc_seletivo = ofe.cod_proc_seletivo
                        and   ofe.cod_proc_seletivo = cco.cod_proc_seletivo
                        --and   prs.ind_distancia_presencial = 'D'
                        and   prs.cod_inst_ensino = 19
                    ORDER BY
                        prs.dat_term_inscr_inter desc
                )
            where rownum <= 1";

    return DB::connection(env('DB_CONNECTION_METODO_DEFAULT'))
        ->select(DB::raw($sql));
}
