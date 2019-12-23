<?php

/**
 * @author Adolfo Menezes Silva
 *
 * Criado em: 12/12/2019
 * */

namespace App\Models\S;

use Illuminate\Database\Eloquent\Model;

class SUsuario extends Model
{
    protected $table = 's_usuario';
    protected $primaryKey = 'cod_usuario';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'cod_usuario',
        'nom_usuario',
        'dsc_email',
        'dsc_usuario',
        'ind_grupo',
        'dsc_hor_acesso_semanal',
        'dsc_icone',
        'dsc_www',
        'dat_expira_password',
        'dat_inclusao',
        'ind_acesso_datasul',
        'ind_acesso_metodo',
        'ind_acesso_serv_arquivos',
        'ind_acesso_web',
        'ind_status',
        'cod_pessoa',
        'dat_bloqueio',
        'cod_ra',
        'cod_proc_seletivo',
        'cod_inscricao',
        'cod_usr_transacao',
        'dsc_os_user',
        'dsc_terminal',
        'dsc_host',
        'ind_transacao',
        'dat_transacao',
        'dsc_ip_address',
        'cod_principal_id',
        'dsc_principal_err_msg',
        'dsc_perfil',
        'cod_arq_foto',
        'ind_tipo_usuario_ead ',
        'ind_acesso_niv_ens',
        'ind_acesso_campus',
        'ind_acesso_curso',
        'ind_acesso_mod_ens',
        'ind_acesso_disc',
        'cod_portador_bco',
        'num_cpf',
        'cod_dn_ldap',
        'dsc_email_interno',
        'ind_ldap_grupo_default',
        'cod_usr_manager',
        'cod_empresa',
        'cod_campus',
        'ind_habilita_pearson',
        'ind_perm_ativo',
        'ind_usa_ldap',
        'ind_acesso_metodo_ext',
        'ind_acesso_moodle',
        'ind_acesso_email',
        'cod_migra'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'dsc_password',
    ];

}
