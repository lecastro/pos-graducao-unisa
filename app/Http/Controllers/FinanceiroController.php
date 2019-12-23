<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use GuzzleHttp;
use PDO;

class FinanceiroController extends Controller
{
    //
    protected function dados_titulo_get_net(int $ra = null, int $titulo = null)
    {
        if (!$ra || !$titulo) {
            return [];
        }

        $dados = DB::select(DB::raw("
            select ft.val_saldo                                                as val_saldo,
                   ft.cod_ra                                                   as cod_ra,
                   ft.cod_titulo                                               as cod_titulo,
                   to_char(fun_dia_util(ft.dat_vencimento), 'DD/MM/YYYY')      as dat_vencimento,
                   regexp_substr (ca.nom_aluno, '[A-z]*' )                     as primeiro_nom_aluno,
                   regexp_substr(ca.nom_aluno, ' \s*([^\s]+)' , 1, 1, null, 1) as ultimo_nom_aluno,
                   fun_ret_cpf_ra(ft.cod_ra, ft.cod_titulo)                    as num_cpf,
                   ca.dsc_end_e_mail                                           as dsc_end_e_mail,
                   fun_tel_aluno_cel(ft.cod_ra)                                as tel,
                   cae.end_logr_aluno                                          as end_logr_aluno,
                   cae.end_num_aluno                                           as end_num_aluno,
                   cae.end_compl_aluno                                         as end_compl_aluno,
                   cae.end_bairro_aluno                                        as end_bairro_aluno,
                   cae.end_localid_aluno                                       as end_localid_aluno,
                   cae.end_uf_aluno                                            as end_uf_aluno,
                   trim(to_char(cae.end_cep_aluno, 'FM00000000'))              as end_cep_aluno,
                   decode(gp.nom_pais_por, null, 'Brasil', gp.nom_pais_por)    as nom_pais_por,
                   fun_corrige_titulo(ft.cod_titulo, sysdate, 'J')             as val_juros,
                   fun_corrige_titulo(ft.cod_titulo, sysdate, 'M')             as val_multa,
                   fun_corrige_titulo(ft.cod_titulo, sysdate, 'D')             as val_desconto
              from f_titulo          ft,
                   ca_aluno          ca,
                   ca_aluno_endereco cae,
                   g_pais            gp
            where gp.cod_pais(+)      = ca.cod_pais_nascto
              and cae.cod_ra          = ft.cod_ra
              and ft.cod_ra           = ca.cod_ra
              and cae.ind_end_corresp = 'S'
              and ft.cod_titulo       = '$titulo'
              and ft.cod_ra           = '$ra'
              and not exists (select 1
                                from ca_aluno_resp_legal carl
                              where carl.cod_ra       = ca.cod_ra
                                and carl.ano_vigencia = ft.ano_titulo)
            union all
            select ft.val_saldo                                                                         as val_saldo,
                   ft.cod_ra                                                                            as cod_ra,
                   ft.cod_titulo                                                                        as cod_titulo,
                   to_char(fun_dia_util(ft.dat_vencimento), 'DD/MM/YYYY')                               as dat_vencimento,
                   nvl(regexp_substr(
                        carl.nom_resp_legal, '[A-z]*' ),
                        regexp_substr (ca.nom_aluno, '[A-z]*' )
                   )                                                                                    as primeiro_nom_aluno,
                   nvl(regexp_substr(
                        carl.nom_resp_legal, ' \s*([^\s]+)' , 1, 1, null, 1),
                        regexp_substr(ca.nom_aluno, ' \s*([^\s]+)' , 1, 1, null, 1)
                   )                                                                                    as ultimo_nom_aluno,
                   nvl(to_char(carl.num_cpf_cnpj_resp_legal), fun_ret_cpf_ra(ft.cod_ra, ft.cod_titulo)) as num_cpf,
                   nvl(carl.dsc_end_e_mail, ca.dsc_end_e_mail)                                          as dsc_end_e_mail,
                   fun_tel_aluno_cel(ft.cod_ra)                                                         as tel,
                   nvl(carl.end_logr_resp_legal, cae.end_logr_aluno)                                    as end_logr_aluno,
                   nvl(carl.end_num_resp_legal, cae.end_num_aluno)                                      as end_num_aluno,
                   nvl(carl.end_compl_resp_legal, cae.end_compl_aluno)                                  as end_compl_aluno,
                   nvl(carl.end_bairro_resp_legal, cae.end_bairro_aluno)                                as end_bairro_aluno,
                   nvl(carl.end_localid_resp_legal, cae.end_localid_aluno)                              as end_localid_aluno,
                   nvl(carl.end_uf_resp_legal, cae.end_uf_aluno)                                        as end_uf_aluno,
                   trim(to_char(nvl(carl.end_cep_resp_legal, cae.end_cep_aluno), 'FM00000000'))         as end_cep_aluno,
                   decode(gp.nom_pais_por, null, 'Brasil', gp.nom_pais_por)                             as nom_pais_por,
                   fun_corrige_titulo(ft.cod_titulo, sysdate, 'J')                                      as val_juros,
                   fun_corrige_titulo(ft.cod_titulo, sysdate, 'M')                                      as val_multa,
                   fun_corrige_titulo(ft.cod_titulo, sysdate, 'D')                                      as val_desconto
              from f_titulo            ft,
                   ca_aluno            ca,
                   ca_aluno_endereco   cae,
                   g_pais              gp,
                   ca_aluno_resp_legal carl
            where carl.cod_ra         = ca.cod_ra
              and carl.ano_vigencia   = ft.ano_titulo
              and gp.cod_pais(+)      = ca.cod_pais_nascto
              and cae.cod_ra          = ft.cod_ra
              and ft.cod_ra           = ca.cod_ra
              and cae.ind_end_corresp = 'S'
              and ft.cod_titulo       = '$titulo'
              and ft.cod_ra           = '$ra'
        "));

        return $dados;
    }

    protected function dados_titulos(int $ra = null, int $titulo = null, int $filtro = 1)
    {
        if (!$ra) {
            return [];
        }

        $dados = DB::select(DB::raw("
            select distinct
                   a.cod_titulo                                              as cod_titulo,
                   a.ano_titulo                                              as ano_titulo,
                   to_char(a.mes_titulo, '00')                               as mes_titulo,
                   a.num_parcela                                             as qtd_parcela,
                   to_char(a.dat_emissao, 'mm/dd/yyyy')                      as dat_emissao,
                   to_char(a.dat_vencimento, 'mm/dd/yyyy')                   as dat_vencimento,
                   to_number(to_char(a.dat_vencimento, 'yyyymm'))            as ano_mes_vencimento,
                   to_char(a.dat_pagamento, 'mm/dd/yyyy')                    as dat_pagamento,
                   a.val_titulo                                              as val_titulo,
                   a.val_recebido                                            as val_recebido,
                   a.val_saldo                                               as val_saldo,
                   a.num_tit_bco                                             as num_tit_bco,
                   nvl(b.cod_contrato_origem, b.cod_contrato)                as cod_contrato,
                   a.cod_especie_titulo                                      as cod_especie_titulo,
                   b.ind_status                                              as ind_status,
                   to_char(b.dat_inicio, 'yyyymm')                           as ano_mes_inicio,
                   a.anomes_titulo                                           as ano_mes_titulo,
                   a.cod_campus                                              as cod_campus,
                   a.cod_curso                                               as cod_curso,
                   bx.nom_curso_abrev                                        as nom_curso_abrev,
                   bx.cod_modalidade_ensino                                  as cod_modalidade_ensino,
                   d.rv_meaning                                              as turno,
                   e.nom_campus_abrev                                        as nom_campus_abrev,
                   f.dsc_especie_titulo                                      as dsc_especie_titulo,
                   nvl(a.cod_portador_bco,0)                                 as cod_portador_bco,
                   a.cod_ra                                                  as ra,
                   regexp_substr(g.nom_aluno, '[A-z]*')                      as first_name,
                   regexp_substr(g.nom_aluno, ' \s*([^\s]+)', 1, 1, null, 1) as last_name,
                   g.cod_docto_id                                            as rg,
                   g.dsc_end_e_mail                                          as email,
                   fun_corrige_titulo(a.cod_titulo, sysdate, 'J')            as val_juros,
                   fun_corrige_titulo(a.cod_titulo, sysdate, 'M')            as val_multa,
                   fun_corrige_titulo(a.cod_titulo, sysdate, 'D')            as val_desconto
                from f_titulo         a,
                     f_contrato       b,
                     f_grp_esp_rel    c,
                     gc_curso         bx,
                     cg_ref_codes     d,
                     g_campus         e,
                     f_especie_titulo f,
                     ca_aluno         g,
                     s_usuario        h
            where a.cod_ra             = '$ra'
              and a.cod_titulo         = nvl('$titulo', a.cod_titulo)
              and g.cod_ra(+)          = a.cod_ra
              and h.cod_ra(+)          = a.cod_ra
              and c.cod_especie_titulo = a.cod_especie_titulo
              and b.cod_contrato(+)    = a.cod_contrato
              and a.ind_status_titulo  = 'A'
              and bx.cod_curso(+)      = a.cod_curso
              and f.cod_especie_titulo = c.cod_especie_titulo
              and d.rv_domain(+)       = 'TURNO'
              and d.rv_low_value(+)    = bx.ind_turno
              and e.cod_campus         = a.cod_campus
              and c.cod_grupo          = 51
              and (('$filtro'=1) or
                   ('$filtro'=2 and a.val_saldo > 0 and (to_number(to_char(a.dat_vencimento, 'yyyymm')) between to_char(sysdate,'yyyymm') and to_char(add_months(sysdate,1),'yyyymm'))) or
                   ('$filtro'=3 and a.val_saldo > 0 and (to_number(to_char(a.dat_vencimento, 'yyyymm')) < to_char(sysdate,'yyyymm'))))
              and not exists (select cod_titulo
                                from f_movto_titulo
                              where cod_titulo       = a.cod_titulo
                                and cod_movto_contem = 868)
            order by a.anomes_titulo desc,
                     cod_contrato    desc,
                     dat_vencimento  desc
        "));

        return $dados;
    }

    protected function dados_pagamento_get_net(int $ra, int $titulo)
    {
        $dados = DB::select(DB::raw("
            select distinct
                   fcgn.status
              from f_cartao_get_net fcgn
            where fcgn.customer_id = '$ra'
              and fcgn.order_id    = '$titulo'
        "));

        return (count($dados)) ? ['status' => $dados[0]->status] : ['status' => null];
    }

    protected function dados_baixa_bancaria_get_net(int $ra, int $titulo)
    {
        $dados = DB::select(DB::raw("
            select fcc.ind_pagto
              from f_controle_cartao fcc
            where fcc.cod_ra           = '$ra'
              and fcc.cod_titulo_docto = '$titulo'
              and not exists (select *
                                from tb_ctrl_ret_superpay s
                              where s.cod_titulo = fcc.cod_titulo_docto)
        "));

        return (count($dados)) ? ['ind_pagto' => $dados[0]->ind_pagto] : ['ind_pagto' => null];
    }

    protected function indicativo_cartao_bloqueado(int $ra)
    {
        $dados = DB::select(DB::raw("
             select ca.ind_bloqueio_cartao
               from ca_aluno ca
             where ca.cod_ra = '$ra'
        "));

        return (count($dados)) ? ['ind_bloqueio_cartao' => $dados[0]->ind_bloqueio_cartao] : ['ind_bloqueio_cartao' => null];
    }

    protected function dados_status_titulo(int $titulo)
    {
        $pdo = DB::getPdo();
        $codigo_titulo = $titulo;
        $status_titulo = null;
        $mensagem_titulo = null;
        $result = null;

        $stmt = $pdo->prepare("declare r boolean; begin r := fun_verifica_boleto(:codigo_titulo, :status_titulo, :mensagem_titulo); if (r) then :result := 1; else :result := 0; end if; end;");

        $stmt->bindParam(':codigo_titulo', $codigo_titulo, PDO::PARAM_INT);
        $stmt->bindParam(':status_titulo', $status_titulo, PDO::PARAM_STR, 4000);
        $stmt->bindParam(':mensagem_titulo', $mensagem_titulo, PDO::PARAM_STR, 4000);
        $stmt->bindParam(':result', $result, PDO::PARAM_BOOL);
        $stmt->execute();

        return [
            'status_titulo' => $status_titulo,
            'mensagem_titulo' => $mensagem_titulo,
            'result' => $result
        ];
    }

    protected function botao_pagamento_cartao(int $ra, int $titulo, float $saldo)
    {
        $status = $this->dados_pagamento_get_net($ra, $titulo)['status'];
        $indPagto = $this->dados_baixa_bancaria_get_net($ra, $titulo)['ind_pagto'];
        $indicativo_cartao_bloqueado = $this->indicativo_cartao_bloqueado($ra)['ind_bloqueio_cartao'];
        $titulo_status = $this->dados_status_titulo($titulo);
        $permissao_titulo = $titulo_status['result'];
        $status_titulo = $titulo_status['status_titulo'];

        if ($status === 'CANCELED') {
            $botao_cartao_title    = 'Ultima tentativa de pagamento cancelada';
            $botao_cartao_disabled = '';
        } else if ($status === 'APPROVED') {
            $botao_cartao_title    = 'Pagamento Realizado';
            $botao_cartao_disabled = ' disabled="disabled" ';
        } else if ($status === 'DENIED') {
            $botao_cartao_title    = 'Ultima tentativa de pagamento negada';
            $botao_cartao_disabled = '';
        } else if ($status === 'AUTHORIZED') {
            $botao_cartao_title    = 'Pagamento Autorizado';
            $botao_cartao_disabled = '';
        } else if ($status === 'ERROR') {
            $botao_cartao_title    = 'Ultima tentativa de pagamento com erro';
            $botao_cartao_disabled = '';
        } else {
            if ($indPagto === 0) {
                $botao_cartao_title    = 'Aguardando confirmação de pagamento';
                $botao_cartao_disabled = ' disabled="disabled" ';
            } else if ($indPagto !== 1 or $indPagto === null) {
                $botao_cartao_title    = 'Pagamento com cartão de credito';
                $botao_cartao_disabled = '';
            } else {
                $botao_cartao_title    = 'Pagamento realizado';
                $botao_cartao_disabled = ' disabled="disabled" ';
            }
        }

        if ($saldo <= 0) {
            $botao_cartao_title    = 'Pagamento realizado';
            $botao_cartao_disabled = ' disabled="disabled" ';
        }

        if ($permissao_titulo == false && $status_titulo == 'FUTURO') {
            $botao_cartao_title    = 'Pagamentos futuros não disponivel no momento, somente a do mes corrente e a do mes seguinte';
            $botao_cartao_disabled = ' disabled="disabled" ';
        }

        if ($permissao_titulo == false && $status_titulo == 'ENVIADO') {
            $botao_cartao_title    = 'Enviado e sem retorno bancário';
            $botao_cartao_disabled = ' disabled="disabled" ';
        }

        if ($permissao_titulo == false && $status_titulo == 'NEGADO') {
            $botao_cartao_title    = 'Pagamento via cartão de credito não disponivel';
            $botao_cartao_disabled = ' disabled="disabled" ';
        }

        if ($indicativo_cartao_bloqueado == 'S') {
            $botao_cartao_title    = 'Pagamento não permitido';
            $botao_cartao_disabled = ' disabled="disabled" ';
        }

        return [
            'botao_cartao_title' => $botao_cartao_title,
            'botao_cartao_disabled' => $botao_cartao_disabled
        ];
    }

    public function index(Request $request)
    {
        $filtro     = isset($request->filtro) ? $request->filtro : 1;
        $ra         = getRaAluno();
        $nome_aluno = getNomeAluno(auth()->user()->num_cpf);
        $titulos    = $this->dados_titulos($ra, null, $filtro);

        // Get current page form url e.x. &page=1
        $current_page = LengthAwarePaginator::resolveCurrentPage();

        // Create a new Laravel collection from the array data
        $item_collection = collect($titulos);

        // Define how many items we want to be visible in each page
        $per_page = 6;

        // Slice the collection to get the items to display in current page
        $current_page_items = $item_collection->slice(($current_page * $per_page) - $per_page, $per_page)->all();

        // Create our paginator and pass it to the view
        $paginated_items= new LengthAwarePaginator($current_page_items , count($item_collection), $per_page);

        // set url path for generted links
        $paginated_items->setPath($request->url());

        return view('alunos.financeiro.index')->with([
            'ra'         => $ra,
            'nome_aluno' => $nome_aluno,
            'titulos'    => $paginated_items,
            'filtro'     => $filtro
        ]);
    }

    public function cartao($titulo, Request $request)
    {
        $ra = getRaAluno();
        $titulos = $this->dados_titulos($ra, $titulo);
        $dados_titulo_get_net = $this->dados_titulo_get_net($ra, $titulo);

        $status_botao_cartao = $this->botao_pagamento_cartao($ra, $titulo, $titulos[0]->val_saldo);

        return view('alunos.financeiro.cartao')->with([
            'titulos'               => $titulos,
            'dados_titulo_get_net'  => $dados_titulo_get_net,
            'url_js'                => $request->url_js,
            'seller_id'             => $request->seller_id,
            'access_token'          => $request->header()['access-token'][0],
            'token_type'            => $request->header()['token-type'][0],
            'expires_in'            => $request->header()['expires-in'][0],
            'scope'                 => $request->header()['scope'][0],
            'botao_cartao_title'    => $status_botao_cartao['botao_cartao_title'],
            'botao_cartao_disabled' => $status_botao_cartao['botao_cartao_disabled']
        ]);
    }

    public function inicia_log(Request $request)
    {
        $guzzle = new GuzzleHttp\Client;

        $response = $guzzle->post(env('METODO_URL_PLS_PRD').'pw_get_net.logInicio', [
            'headers' => [
                'Accept'        => 'application/json, text/plain, */*',
                'Content-Type'  => 'application/x-www-form-urlencoded',
            ],
            'form_params' => [
                'codRa'          => $request->codRa,
                'codTitulo'      => $request->codTitulo,
                'qtdParcelas'    => $request->qtdParcelas,
                'valorCorrigido' => $request->valorCorrigido,
                'codTitulos'     => $request->codTitulos,
                'codUsuario'     => $request->codUsuario,
            ],
        ]);

        return response()->json([
            json_decode((string) $response->getBody(), true)
        ]);
    }

    public function finalizar_pagamento(Request $request)
    {
        $guzzle = new GuzzleHttp\Client;

        $response = $guzzle->post(env('METODO_URL_PLS_PRD').'pw_get_net.finalizarPagamento', [
            'headers' => [
                'Accept'        => 'application/json, text/plain, */*',
                'Content-Type'  => 'application/x-www-form-urlencoded',
            ],
            'form_params' => [
                'codRa'          => $request->codRa,
                'codTitulo'      => $request->codTitulo,
                'qtdParcelas'    => $request->qtdParcelas,
                'valorCorrigido' => $request->valorCorrigido,
                'codTitulos'     => $request->codTitulos,
                'codUsuario'     => $request->codUsuario,
            ],
        ]);

        return response()->json([
            json_decode((string) $response->getBody(), true)
        ]);
    }
}
