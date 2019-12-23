<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'identity' => decrypt($request->email)]
        );
    }

    public function reset(Request $request)
    {
        $messages = [
            'password.required' => 'O campo Nova senha é obrigatório',
            'password.regex' => 'O campo Nova senha tem um formato inválido',
            'password.min' => 'O campo Nova senha deve ter no mínimo 8 caracteres',
            'password.confirmed' =>  'Os campos de senha não conferem.',
            'password_confirmation' => 'O campo Confirmar nova senha é obrigatório'
        ];
        $request->validate($this->rules(), $messages);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $response == Password::PASSWORD_RESET
                    ? $this->sendResetResponse($request, $response)
                    : $this->sendResetFailedResponse($request, $response);
    }

    public function rules()
    {
        return [
            'token' => 'required',
            'password' => "required|confirmed|min:8|regex:'^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&#])[A-Za-z\d$@$!%*?&#]{8,}'",
            'password_confirmation' => 'required'
        ];
    }

    public function credentials(Request $request)
    {
        $login = $request->identity;
        if(VerificarEndereçoEmail($login)){
            $field = 'email';
        }elseif(preg_match('#@#', $login)){
            $field = 'email';
        }else{
            $field = 'num_cpf';
        }

        $request->merge([$field => $login]);

        return $request->only(
            'email', 'num_cpf', 'password', 'password_confirmation', 'token'
        );
    }

    public function sendResetFailedResponse(Request $request, $response)
    {
        return redirect()->back()
                    ->withInput($request->only('email', 'num_cpf'))
                    ->withErrors(['email' => trans($response), 'num_cpf' => trans($response)]);
    }

    public function updateAuthUserPassword(Request $request)
    {
        $this->validate($request, [
            'currentPassword' => 'required',
            'password' => ['required', 'confirmed' , 'string', 'min:8', "regex:'^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&#])[A-Za-z\d$@$!%*?&#]{8,}'"],
            'password_confirmation' => 'required'
        ], [
            'password.regex' => 'O campo Nova senha tem um formato inválido',
            'currentPassword.required' => 'O campo Senha Atual é obrigatório',
            'password.required' => 'O campo Nova Senha é obrigatório',
            'password.min' => 'O campo Nova Senha deve ter no mínimo 8 caracteres',
            'password.confirmed' =>  'Os campos de Senha não conferem.',
            'password_confirmation' => 'O campo Confirmar Senha é obrigatório'
        ]);

        $user = User::where('num_cpf', auth()->user()->num_cpf)->first();
        if (!Hash::check($request->currentPassword, $user->password)) {
            return response()->json(abort(406));
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json('success');
    }

    public function updateAuthUserEmail(Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'confirmed' , 'email'],
            'email_confirmation' => 'required',
            'passwordEmail' => ['required', 'min:8'],
        ], [
            'passwordEmail.required' => 'O campo Senha é obrigatório',
            'passwordEmail.min' => 'O campo Senha deve ter no mínimo 8 caracteres',
        ]);

        $user = User::where('num_cpf', auth()->user()->num_cpf)->first();
        if (!Hash::check($request->passwordEmail, $user->password)) {
            return response()->json(abort(406));
        }

        $user->email = $request->email;    
        $user->email_verified_at = null;  
          
        if ($user->save()){
            auth()->setUser($user); 
            auth()->user()->sendEmailVerificationNotification();
            alteraEmailPsCandECaAluno(); 

            redirect()->route('home');

            return response()->json('success');
        }else{
            return response()->json(abort(406)); 
        }
   
    }
}
