<?php

/**
 *
 *
 * @author glalves
 * Criado em: 29/10/2019
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Ps\PsCandidato;
use App\Models\F\FTabPrecoCurso;

use App\Http\Requests\Ps\PsCandidatoRequest;
use App\Models\G\GUf;
use Exception;

class PsCandidatoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(PsCandidato $psCandidato)
    {
        $this->psCandidato = $psCandidato;
    }

    public function index()
    {   
        if (count(alunoInadimplente()) > 0) {
            return view('inscricoes.inadimplente');
        }

        $cod_proc_seletivo_pos_ead = getPsAbertoPos('D');        
        $cod_proc_seletivo_ext = getPsAbertoExtensao();
        $cod_proc_seletivo_pos_presencial = getPsAbertoPos('P');

        return view('inscricoes.index', [
            'cod_proc_seletivo_pos' => $cod_proc_seletivo_pos_ead ? $cod_proc_seletivo_pos_ead[0]->cod_proc_seletivo : 0,
            'cod_proc_seletivo_ext' => $cod_proc_seletivo_ext ?  $cod_proc_seletivo_ext[0]->cod_proc_seletivo : 0,
            'cod_proc_seletivo_pos_presencial' => $cod_proc_seletivo_pos_presencial ? $cod_proc_seletivo_pos_presencial[0]->cod_proc_seletivo : 0
        ]);
    }

    public function create(Request $request)
    {

        $cod_niv_ens = intval($request->cod_niv_ens);

        //validar somente P||D para o tipo de modalide
        //validar nivel de ensino
        if ($cod_niv_ens != 13 && $cod_niv_ens != 10 && $request->modalidade != "P" && $request->modalidade != "D"){
            return \redirect()->route('home');
        }    

        try {            

            $candidato = $this->psCandidato::
                where('num_cpf', decrypt($request->id))                
                ->join('PS_TEL_CAND', function($join){
                    $join->on('PS_TEL_CAND.cod_inscricao', '=', 'ps_candidato.cod_inscricao')
                    ->on('PS_TEL_CAND.cod_proc_seletivo', '=', 'ps_candidato.cod_proc_seletivo');

                })
                ->orderBy('dat_inscricao', 'DESC')->first();

            !$candidato ? $candidato = new PsCandidato() : $candidato->end_cep = str_pad($candidato->end_cep, 8, '0', STR_PAD_LEFT);

            $cods_procs_seletivos = [];

            if ($cod_niv_ens == 13 && $request->modalidade == "P") {
                $cods_procs_seletivos = getPsAbertoPos('P');
            }elseif($cod_niv_ens == 13 && $request->modalidade == "D"){
                $cods_procs_seletivos = getPsAbertoPos('D'); ;
            }elseif($cod_niv_ens == 10 && $request->modalidade == "P"){
                $cods_procs_seletivos = getPsAbertoExtensao();
            }
            
            $ufs = GUf::get();

            return view('inscricoes.create', [
                'cods_procs_seletivos' => $cods_procs_seletivos,
                'candidato' => $candidato,
                'conhecimento' => getConhecimentoUnisa(),
                'cod_niv_ens' => $cod_niv_ens,
                'modalidade' => $request->modalidade,
                'ufs' => $ufs
            ]);
        } catch (\Throwable $th) {
           return $th;
        }

    }

    public function getCursos(Request $request){

        $cod_niv_ens = intval($request->cod_niv_ens);
        $inscricoes = $this->psCandidato->getInscricoesCandidato();

        if ($cod_niv_ens == 13) {
            if ($request->modalidade == "D"){
                $cursos = $this->psCandidato->getCursosPsPos($cod_niv_ens, $request->cod_proc_seletivo, 'D');
            }else{
                $cursos = $this->psCandidato->getCursosPsPosPresencial($cod_niv_ens, $request->cod_proc_seletivo, 'P');
            }
        } else {
            $cursos = $this->psCandidato->getCursosPsExtensao($cod_niv_ens, $request->cod_proc_seletivo);
        }

        $cursos = $this->psCandidato->cursosFiltroInscricao($inscricoes, $cursos);

        return response()->json($cursos);
    }

    public function show($id)
    {
        return view('inscricoes.show', [
            'inscricoes' => getInscricoesCandidato(decrypt($id))
        ]);
    }

    public function getPolo(Request $request)
    {
        $cod_niv_ens = \intval($request->cod_niv_ens);

        if ($cod_niv_ens == 13) {
            if ($request->modalidade == 'P'){
                return response()->json($this->psCandidato->getCampusCursoPosPresencial($request->cod_curso_ps, $request->cod_proc_seletivo));
            }else{
                return response()->json($this->psCandidato->getPoloPorCursoPs($request->cod_curso_ps, $request->cod_proc_seletivo));
            }
        } else {
            return response()->json($this->psCandidato->getPoloPorCursoExtensao($request->cod_curso_ps, $request->cod_proc_seletivo));
        }
    }

    public function getProcessoSeletivo(Request $request)
    {
        return getProcessoSeletivo($request->cod_curso_ps, $request->cod_campus, $request->cod_niv_ens);
    }

    public function getTabelaPrecos(Request $request)
    {
        $cod_curso = DB::table('ps_curso')
            ->where('cod_curso_ps', $request->cod_curso_ps)
            ->select('cod_curso_atual')->get()->first();

        $tabPrecoCurso = new FTabPrecoCurso();

        $cod_niv_ens = \intval($request->cod_niv_ens);

        if ($cod_niv_ens == 13) {
            return response()->json(
                $tabPrecoCurso->getTabelaPrecosPos($cod_curso->cod_curso_atual, $request->cod_campus, $request->cod_proc_seletivo)
            );
        } else {
            return response()->json(
                $tabPrecoCurso->getTabelaPrecosExtensao($cod_curso->cod_curso_atual, $request->cod_campus, $request->cod_proc_seletivo)
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PsCandidatoRequest $request)
    {
        try {
            
            $cod_inscricao = $this->psCandidato->insereCandidatoPos($request); //Chamando procedure de criação do candidato

            if ($cod_inscricao) {
                $psCandidato = $this->psCandidato->where([
                    'num_cpf' => $request->num_cpf,
                    'cod_proc_seletivo' => $request->cod_proc_seletivo,
                    'cod_inscricao' => $cod_inscricao
                ])->select('num_contrato')
                    ->orderBy('dat_inscricao', 'DESC')->first();

                $cod_titulo = DB::select(
                    DB::raw(
                        "select ft.cod_titulo
                        from f_contrato fc,
                            f_titulo ft
                        where fc.cod_contrato = ft.cod_contrato
                            and fc.cod_contrato = $psCandidato->num_contrato
                            and to_char(fc.dat_inicio, 'YYYYMM') = ft.anomes_titulo
                    ")
                );

                if ($cod_inscricao && $cod_titulo) {
                    return response()->json(
                        [
                            'cod_inscricao' => $cod_inscricao,
                            'cod_titulo' => $cod_titulo[0]->cod_titulo,
                            'ra' => getRaAluno($request->num_cpf),
                            'cod_niv_ensino' => $request->cod_niv_ens
                        ]
                    );
                }
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }
}
