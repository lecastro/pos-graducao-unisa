<?php

/**
 *
 *
 * @author selopes
 * Criado em: 5/11/2019
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Ps\PsCandidato;
use App\Models\Ca\CaAluno;
use App\Models\Ca\CaAlunoEndereco;
use App\Models\Ca\CaAlunoTelefone;

use App\Http\Requests\Ca\CaAlunoRequest;

class CaAlunoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
    }

    public function edit($id)
    {
        $aluno = DB::table('ca_aluno')
            ->join('ca_aluno_endereco', 'ca_aluno.cod_ra', 'ca_aluno_endereco.cod_ra')
            ->where('NUM_CPF', decrypt($id))
            ->select([
                'ca_aluno.cod_ra','ca_aluno.nom_aluno', 'ca_aluno.dsc_end_e_mail', 'ca_aluno.dat_nascimento', 'ca_aluno.ind_sexo',
                'ca_aluno_endereco.ind_tp_end_aluno', 'ca_aluno_endereco.end_cep_aluno', 'ca_aluno_endereco.end_logr_aluno', 'ca_aluno_endereco.end_num_aluno',
                'ca_aluno_endereco.end_bairro_aluno', 'ca_aluno_endereco.end_compl_aluno', 'ca_aluno_endereco.end_localid_aluno',
                'ca_aluno_endereco.end_uf_aluno'
        ])->get()->first();

        if($aluno){
            $aluno->end_cep_aluno = str_pad($aluno->end_cep_aluno , 8 , '0' , STR_PAD_LEFT);

            $telefones = DB::table('ca_aluno_telefone')
                ->where('cod_ra', $aluno->cod_ra)
                ->select(['ind_tp_tel_aluno', 'num_ddd_tel_aluno', 'num_tel_aluno'])->get();

            $arrayTelefones['RES1'] = '';
            $arrayTelefones['CEL1'] = '';
            $arrayTelefones['COM1'] = '';
            $arrayTelefones['REC1'] = '';
            foreach ($telefones as $telefone){
                if($telefone->ind_tp_tel_aluno == "RES1"){
                    $arrayTelefones['RES1'] = intval("$telefone->num_ddd_tel_aluno$telefone->num_tel_aluno");
                }

                if($telefone->ind_tp_tel_aluno == "CEL1"){
                    $arrayTelefones['CEL1'] = intval("$telefone->num_ddd_tel_aluno$telefone->num_tel_aluno");
                }

                if($telefone->ind_tp_tel_aluno == "COM1"){
                    $arrayTelefones['COM1'] = intval("$telefone->num_ddd_tel_aluno$telefone->num_tel_aluno");
                }

                if($telefone->ind_tp_tel_aluno == "REC1"){
                    $arrayTelefones['REC1'] = intval("$telefone->num_ddd_tel_aluno$telefone->num_tel_aluno");
                }
            }

            $psCandidato = new PsCandidato();

            return view('alunos.edit', ['aluno' => $aluno,
                'telefones' => $arrayTelefones,
                'conhecimentoUnisa' => getConhecimentoUnisa()
            ]);
        }
        else{
            return back()->withInput();
        }

    }

    public function update($id, CaAlunoRequest $request)
    {
        try {
            CaAluno::where('num_cpf', decrypt($id))->update([
                'nom_aluno' => $request->nom_aluno,
                'dsc_end_e_mail' => $request->dsc_end_e_mail,
                'dat_nascimento' => converteDateBD($request->dat_nascimento),
                'ind_sexo' => $request->ind_sexo,
            ]);

            CaAlunoEndereco::where(
                ['ind_tp_end_aluno'=> $request->ind_tp_end_aluno,
                 'cod_ra' => $request->cod_ra
                ])->update(
                    ["end_cep_aluno" => somenteNumeros($request->end_cep_aluno),
                    "end_logr_aluno" => $request->end_logr_aluno,
                    "end_num_aluno" => $request->end_num_aluno,
                    "end_compl_aluno" => $request->end_compl_aluno,
                    "end_bairro_aluno" => $request->end_bairro_aluno,
                    "end_localid_aluno" => $request->end_localid_aluno,
                    "end_uf_aluno" => $request->end_uf_aluno
                ]
            );

            CaAlunoTelefone::where('cod_ra', $request->cod_ra)->delete();

            $caAlunoTelefone = new CaAlunoTelefone;
            $caAlunoTelefone->cod_ra = $request->cod_ra;
            $caAlunoTelefone->ind_tp_tel_aluno = 'CEL1';
            $caAlunoTelefone->num_ddi_tel_aluno = 55;
            $caAlunoTelefone->num_ddd_tel_aluno = substr(somenteNumeros($request->num_telefone), 0, 2);
            $caAlunoTelefone->num_tel_aluno = substr(somenteNumeros($request->num_telefone), 2);
            $caAlunoTelefone->save();

            foreach($request->telefones as $key => $telefone){
                if($telefone){
                    $caAlunoTelefone = new CaAlunoTelefone;
                    $caAlunoTelefone->cod_ra = $request->cod_ra;
                    $caAlunoTelefone->ind_tp_tel_aluno = $key;
                    $caAlunoTelefone->num_ddi_tel_aluno = 55;
                    $caAlunoTelefone->num_ddd_tel_aluno = substr(somenteNumeros($telefone), 0, 2);
                    $caAlunoTelefone->num_tel_aluno = substr(somenteNumeros($telefone), 2);
                    $caAlunoTelefone->save();
                }
            }
            return response()->json('success');

        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function listarCursosPos()
    {
        return view('alunos.cursos.pos.index');
    }

    public function listarCursosExtensao()
    {
        return view('alunos.cursos.extensao.index');
    }
}
