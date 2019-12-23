<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Ps\PsCandInscrNaoFin;

use App\Http\Requests\Ps\PsCandInscrNaoFinRequest;

class PsCandInscrNaoFinController extends Controller
{

    public function __construct(PsCandInscrNaoFin $psCandInscrNaoFin)
    {
        $this->psCandInscrNaoFin = $psCandInscrNaoFin;
    }

    public function index()
    {
    }

    public function store(PsCandInscrNaoFinRequest $request)
    {
        try {
            $cand_inscr_nao_fin = DB::table('ps_cand_inscr_nao_fin')->where([
                    'cod_proc_seletivo' => $request->cod_proc_seletivo, 'num_cpf' => $request->num_cpf,
                    'cod_curso_ps1' => $request->cod_curso_ps, 'cod_campus_cur1' => $request->cod_campus
                ]);

            if($cand_inscr_nao_fin->exists()){
                $cand_inscr_nao_fin->update([
                    'ind_conhecimento_unisa' => $request->ind_conhecimento_unisa, 'nom_candidato'=> $request->nom_candidato, 'ind_sexo' => $request->ind_sexo,
                    'dsc_end_e_mail' => $request->dsc_end_e_mail, 'telefonec' => substr($request->telefonec, 0, 2),  'dat_nascimento' => converteDateBD($request->dat_nascimento),
                    'dddc' => substr($request->telefonec, 2), "end_cep" => $request->end_cep,
                    'telefonef' => substr($request->telefonef, 0, 2), 'dddf' => substr($request->telefonef, 2),'ind_aceita_sms' => $request->ind_aceita_sms,
                    "end_logradouro" => $request->end_logradouro, "end_numero" => $request->end_numero, "end_complemento" => $request->end_complemento,
                    "end_bairro" => $request->end_bairro, "end_localidade" => $request->end_localidade, "end_uf" => $request->end_uf
                    ]
                );
            }else{
                DB::table('ps_cand_inscr_nao_fin')->insert([
                    'cod_proc_seletivo' => $request->cod_proc_seletivo, 'num_cpf' => $request->num_cpf,
                    'cod_curso_ps1' => $request->cod_curso_ps, 'cod_campus_cur1' => $request->cod_campus, 'ind_sexo' => $request->ind_sexo,
                    'ind_conhecimento_unisa' => $request->ind_conhecimento_unisa, 'nom_candidato'=> $request->nom_candidato, 'dat_nascimento' => converteDateBD($request->dat_nascimento),
                    'dsc_end_e_mail' => $request->dsc_end_e_mail, 'telefonec' => substr($request->telefonec, 0, 2),
                    'telefonef' => substr($request->telefonef, 0, 2), 'dddf' => substr($request->telefonef, 2),'ind_aceita_sms' => $request->ind_aceita_sms,
                    'dddc' => substr($request->telefonec, 2), 'codseq' => $this->psCandInscrNaoFin->getMaxCodSeq()+1,
                    "end_cep" => $request->end_cep, "end_logradouro" => $request->end_logradouro,
                    "end_numero" => $request->end_numero, "end_complemento" => $request->end_complemento,
                    "end_bairro" => $request->end_bairro, "end_localidade" => $request->end_localidade, "end_uf" => $request->end_uf
                    ]
                );
            }

            return response()->json('success');

        } catch (Exception $ex) {
            abort(404);
        }
    }

    public function update($id, PsCandInscrNaoFinRequest $request)
    {
        try {
            $cand_inscr_nao_fin = DB::table('ps_cand_inscr_nao_fin')->where([
                'cod_proc_seletivo' => $request->cod_proc_seletivo, 'num_cpf' => decrypt($id),
                'cod_curso_ps1' => $request->cod_curso_ps, 'cod_campus_cur1' => $request->cod_campus
            ])->update([
                    'ind_conhecimento_unisa' => $request->ind_conhecimento_unisa, 'nom_candidato'=> $request->nom_candidato, 'ind_sexo' => $request->ind_sexo,
                    'dsc_end_e_mail' => $request->dsc_end_e_mail, 'telefonec' => substr($request->telefonec, 0, 2),  'dat_nascimento' => converteDateBD($request->dat_nascimento),
                    'dddc' => substr($request->telefonec, 2), "end_cep" => $request->end_cep,
                    'telefonef' => substr($request->telefonef, 0, 2), 'dddf' => substr($request->telefonef, 2),'ind_aceita_sms' => $request->ind_aceita_sms,
                    "end_logradouro" => $request->end_logradouro, "end_numero" => $request->end_numero, "end_complemento" => $request->end_complemento,
                    "end_bairro" => $request->end_bairro, "end_localidade" => $request->end_localidade, "end_uf" => $request->end_uf
                ]
            );
            return response()->json('success');

        } catch (\Throwable $th) {
            abort($th);
        }
    }
}
