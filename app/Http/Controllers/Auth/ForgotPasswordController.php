<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
     */

    use SendsPasswordResetEmails;

    public function validateEmail(Request $request)
    {
        $login = request()->input('identity');

        if (VerificarEndereçoEmail($login)) {
            $field = 'email';
        } elseif (preg_match('#@#', $login)) {
            $field = 'email';
        } else {
            $field = 'num_cpf';
        }

        $request->merge([$field => $login]);

        $rules = [
            'identity' => 'required|string',
            'email' => 'email|exists:users',
            'num_cpf' => 'nullable|numeric|exists:users',
        ];
        $messages = [
            'identity.required' => 'O campo E-mail ou CPF é obrigatório',
            'num_cpf.numeric' => 'O CPF deve conter apenas números',
            'email.email' => 'Formato de e-mail inválido',
            'email.exists' => 'E-mail não encontrado',
            'num_cpf.exists' => 'CPF não encontrado',
        ];

        $this->validate($request, $rules, $messages);
    }

    public function credentials(Request $request)
    {
        return $request->only(['email', 'num_cpf']);
    }

    public function sendResetLinkFailedResponse(Request $request, $response)
    {
        return back()
            ->withInput($request->only('identity'))
            ->withErrors(['identity' => trans($response)]);
    }
}
