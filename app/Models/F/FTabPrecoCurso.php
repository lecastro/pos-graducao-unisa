<?php

/**
 * @author Samuel Lopes
 *
 * Criado em: 11/11/2019
 * */

namespace App\Models\F;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FTabPrecoCurso extends Model
{
    protected $table = 'f_tab_preco_curso';
    protected $primaryKey = 'num_tab_preco_curso';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'val_planilha_custo',
        'val_bolsa_filant',
        'val_desc_pactuado',
        'val_desc_incondicional',
        'cod_curso',
        'per_valid_inicial',
        'per_valid_final',
        'ind_tp_tab_preco',
        'qtd_duracao_curso',
        'pct_reajuste',
        'cod_usuario',
        'dat_inclusao',
        'dsc_os_user',
        'dsc_terminal',
        'dsc_host',
        'ind_transacao',
        'dat_transacao',
        'dsc_ip_address',
        'client_info',
        'cod_movto',
        'cod_movto_filan',
        'ind_reajusta_contrato',
        'pct_repasse',
        'cod_campus',
        'dsc_observacao',
        'cod_movto_descto',
        'val_movto_descto',
        'ind_ger_parc_ferias',
        'txa_desc_mes_ant',
        'val_desc_mes_ant',
        'txa_desc_4dia',
        'val_desc_4dia',
        'txa_desc_mes_ant_me',
        'val_desc_mes_ant_me',
        'txa_desc_4dia_me',
        'val_desc_4dia_me',
        'txa_desc_mes_ant_ie',
        'val_desc_mes_ant_ie',
        'txa_desc_4dia_ie',
        'val_desc_4dia_ie',
        'ind_dia_lim_des',
        'dat_inicio_tur_ing',
        'dat_lim_des_mes_ant',
        'dat_lim_des_4dia',
        'txa_desc_ini',
        'val_desc_ini'
    ];

    public function getTabelaPrecosExtensao($cod_curso, $cod_campus, $cod_proc_seletivo)
    {
        $sql = "SELECT nvl(ftp.val_planilha_custo, 0) AS val_planilha_custo,
                       nvl(ftp.val_bolsa_filant, 0),
                       ftp.num_tab_preco_curso,
                       ftp.qtd_duracao_curso,
                       ftp.per_valid_inicial,
                       ftp.per_valid_final
                FROM f_tab_preco_curso ftp
                WHERE ftp.cod_curso        = $cod_curso
                    AND ftp.ind_tp_tab_preco = 'E'
                    AND ftp.cod_campus       = $cod_campus
                    AND EXISTS (SELECT 1
                                    FROM ps_proc_seletivo  ps
                                  WHERE trunc(ftp.per_valid_inicial) = trunc(ps.per_valid_inicial)
                                    AND ps.dat_term_inscr_inter      >= trunc(sysdate)
                                    AND ps.cod_niv_ens               = 10
                                    AND ps.cod_inst_ensino           = 19
                                    AND ps.cod_proc_seletivo         = '$cod_proc_seletivo'
                                    AND ps.ind_distancia_presencial  = 'P')";

        return DB::select(DB::raw($sql));
    }

    public function getTabelaPrecosPos($cod_curso, $cod_campus, $cod_proc_seletivo)
    {
        $sql = "SELECT nvl(ftp.val_planilha_custo, 0) AS val_planilha_custo,
                      nvl(ftp.val_bolsa_filant, 0),
                      ftp.num_tab_preco_curso,
                      ftp.qtd_duracao_curso,
                      ftp.per_valid_inicial,
                      ftp.per_valid_final
                FROM f_tab_preco_curso ftp
                WHERE ftp.cod_curso        = '$cod_curso'
                    AND ftp.ind_tp_tab_preco = 'P'
                    AND ftp.cod_campus       = '$cod_campus'
                    AND EXISTS (SELECT 1
                                  FROM ps_agenda_pos_parc ap,
                                       ps_agenda_pos      ag
                                  WHERE trunc(ftp.per_valid_inicial) = trunc(ap.per_valid_inicial)
                                    AND  ag.cod_agenda_ead           = ap.cod_agenda_ead
                                    AND  ag.cod_proc_seletivo        = $cod_proc_seletivo)
                ORDER BY qtd_duracao_curso";

        return DB::select(DB::raw($sql));
    }
}
