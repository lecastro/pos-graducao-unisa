<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->username = $this->findUser();
    }

    public function findUser()
    {
        $login = request()->input('identity');
        if(VerificarEndereçoEmail($login)){
            $field = 'email';
        }elseif(preg_match('#@#', $login)){
                $field = 'email';
        }else{
            $field = 'num_cpf';
        }

        request()->merge([$field => $login]);

        return $field;
    }

    public function validateLogin(Request $request)
    {
        $rules = [
            'identity' => 'required|string',
            'password' => 'required|string',
            'email'    => 'email|exists:users',
            'num_cpf'  => 'nullable|numeric|exists:users'
        ];
        $messages = [
            'identity.required' => 'O campo E-mail ou CPF é obrigatório',
            'password.required' => 'O campo Senha é obrigatório',
            'num_cpf.numeric' => 'O CPF deve conter apenas números',
            'email.email' => 'Formato de e-mail inválido',
            'email.exists' => 'E-mail não encontrado',
            'num_cpf.exists' => 'CPF não encontrado'
        ];

        $this->validate($request, $rules, $messages);
    }

    public function username()
    {
        return $this->findUser();
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'password' => [trans('auth.failed')],
        ]);
    }

}
