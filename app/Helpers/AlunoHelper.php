<?php

use App\Models\Ca\CaAluno;
use App\Models\Ps\PsCandidato;
use App\Models\Ps\PsCandInscrNaoFin;
use App\Models\S\SUsuario;
use App\Models\User;
use Illuminate\Support\Facades\DB;

function getAluno($cpf)
{
    return CaAluno::where(['num_cpf' => $cpf])->first();
}

function getNomeAluno($cpf)
{
    $aluno = CaAluno::where(['num_cpf' => $cpf])->first();
    return ($aluno) ? $aluno->nom_aluno : new CaAluno;
}

function getRaAluno($cpf = null)
{
    if ($cpf) {
        $aluno = CaAluno::where('num_cpf', $cpf)->first();
    } else {
        $aluno = CaAluno::where('num_cpf', auth()->user()->num_cpf)->first();
    }
    if ($aluno)
        return $aluno->cod_ra;
    else
        return null;
}

function getEstadoCadastro($id)
{
    return User::where(['id' => $id])
        ->whereNotNull('email_verified_at')->first();
}

function alunoInadimplente()
{

    if (getRaAluno(auth()->user()->num_cpf)) {
        return DB::table('vw_qtd_matriculas')->select('cod_matr')
            ->whereRaw("COD_RA = " . getRaAluno(auth()->user()->num_cpf) . " AND IND_INADIMPLENCIA <> 'N'")->get();
    }

    return [];
}

function VerificarEndereçoEmail($endereço)
{
    $syntaxe = '#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';
    if (preg_match($syntaxe, $endereço))
        return true;
    else
        return false;
}

function alteraEmailPsCandECaAluno()
{
    try {
        if (getRaAluno()) {
            PsCandidato::where(['num_cpf' => auth()->user()->num_cpf])->update(['dsc_end_e_mail' => auth()->user()->email]);
            CaAluno::where(['cod_ra' => getRaAluno()])->update(['dsc_end_e_mail' => auth()->user()->email]);
        }
        PsCandInscrNaoFin::where(['num_cpf' => auth()->user()->num_cpf])->update(['dsc_end_e_mail' => auth()->user()->email]);
    } catch (Exception $ex) {
        dd($ex);
    }
}

function getLoginName($ra = null)
{
    $usuario = ($ra) ? $usuario = SUsuario::where('cod_ra', $ra)->first() : $usuario = SUsuario::where('num_cpf', auth()->user()->num_cpf)->first();
    return ($usuario) ? $usuario->cod_usuario : $ra;
}
