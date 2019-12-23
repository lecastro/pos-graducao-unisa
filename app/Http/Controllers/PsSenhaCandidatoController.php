<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PsSenhaCandidatoController extends Controller
{
    private $sucesso = 'Senha atualizada com sucesso';
    private $error = 'error para atualizar senha';

    public function index()
    {
        return view('configuracoes.senha');
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            //regra para validar senha atual do usuario;
            'currentPassword' => ['required', function ($attribute, $value, $fail) {
                if (!Hash::check($value, Auth::user()->password)) {
                    return $fail(__('A senha atual está incorreta.'));
                }
            }],
            'password' => 'required|confirmed|min:8',
        ]);

        //alterar senhar
        $resposta = $request->user()->update([
            'password' => bcrypt($request->password),
        ]);

        if (!$resposta) {
            return redirect()
                ->route('redefinir')
                ->with('success', $this->error);
        }

        return redirect()
            ->route('redefinir')
            ->with('success', $this->sucesso);
    }
}
