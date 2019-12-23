<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ca\CaAlunoDoctoPendRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;

use App\Models\Ca\CaAlunoDoctoPend;

class CaAlunoDoctoPendController extends Controller
{
    private $caAlunoDoctoPend;
    private $path ;
    private $docto = [
        175 => 'Diploma de Graduação',
        302 => 'Declaração de Conclusão do Ensino Superior',
        27 => 'Histórico do Ensino Superior'
    ];

    public function __construct(CaAlunoDoctoPend $caAlunoDoctoPend)
    {
        $this->caAlunoDoctoPend = $caAlunoDoctoPend;
        $this->path = "PortalPosExtensao/Alunos";
    }

    public function index()
    {
        $doctos = [];
        if(getRaAluno()){
            $doctos = $this->caAlunoDoctoPend
            ->doctoPend()
            ->where('ca_aluno_docto_pend.cod_ra', getRaAluno())
            ->whereIn('ca_aluno_docto_pend.cod_tp_docto', array_keys($this->docto))
            ->orderBy(
                DB::raw(
                    "CASE
                        WHEN ca_aluno_docto_pend.cod_tp_docto = 175 THEN 1
                        WHEN ca_aluno_docto_pend.cod_tp_docto = 302 THEN 2
                        WHEN ca_aluno_docto_pend.cod_tp_docto = 27 THEN 3
                    END"
                )
            )->get();
        }

        return view('alunos.documentos.index')->with(
            compact(
                'doctos'
                //,'path'
            )
        );
    }

    public function store(CaAlunoDoctoPendRequest $request)
    {
        try {
            if($request->file('filesDiploma')){
                $this->storeArchives($request->file('filesDiploma'), 175);
            }

            if($request->file('filesDeclaracao')){
                $this->storeArchives($request->file('filesDeclaracao'), 302);
            }

            if($request->file('filesHistorico')){
                $this->storeArchives($request->file('filesHistorico'), 27);
            }

            return response()->json('success');
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function storeArchives($file, $cod_tp_docto)
    {
        $custom_file_name = "{$cod_tp_docto}-";
        $path = $this->path . '/' . getRaAluno() . '/';
        $dsc_link_arquivo = storeCustomToS3($file, $path, $custom_file_name);

        $this->caAlunoDoctoPend->updateOrInsert(
            [
                'cod_ra' => getRaAluno(),
                'cod_tp_docto' => $cod_tp_docto
            ],
            [
                'dat_inclusao' => Carbon::now(),
                'dat_pendencia' => Carbon::now(),
                'cod_usuario' => getRaAluno(),
                'dat_envio' => Carbon::now(),
                'dsc_link_arquivo' => getArquivo($path . $dsc_link_arquivo)
            ]
        );
    }

    public function destroy(Request $request)
    {
        try{
            /*$dsc_link_arquivo = $request->get('file');
            destroy($dsc_link_arquivo, $this->path.getRaAluno().'/');

            $caAlunoDoctoPend->where([
                'cod_ra' => getRaAluno(),
                'dsc_link_arquivo' => $this->path.getRaAluno().'/' . $dsc_link_arquivo
            ])->delete();

            return $dsc_link_arquivo;*/
        } catch (\Throwable $th) {
            abort(404);
        }
    }
}
