<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
     */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $cpf = somenteNumeros($data['num_cpf']);
        $telefone = somenteNumeros($data['num_telefone']);

        $data['num_cpf'] = $cpf;
        $data['num_telefone'] = $telefone;

        return Validator::make($data, [
            'num_cpf' => ['required', 'numeric', 'digits_between:11,11', 'cpf', 'unique:users'],
            'name' => ['required', 'string', 'max:100', 'min:5', 'regex:/^[\pL\s\-]+$/u'],
            'email' => ['required', 'confirmed' ,'string', 'email', 'max:255', 'unique:users'],
            'email_confirmation' => 'required',
            'num_telefone' => ['required', 'numeric', 'digits_between:1,19'],
            'password' => ['required','confirmed' ,'string', 'min:8', "regex:'^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&#])[A-Za-z\d$@$!%*?&#]{8,}'"],
            'password_confirmation' => 'required'
        ],
        [
            'password.regex' => 'O campo Nova senha tem um formato inválido'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $cpf = somenteNumeros($data['num_cpf']);
        $telefone = somenteNumeros($data['num_telefone']);

        $data['num_cpf'] = $cpf;
        $data['num_telefone'] = $telefone;

        return User::create([
            'num_cpf' => $data['num_cpf'],
            'name' => $data['name'],
            'email' => $data['email'],
            'num_telefone' => $data['num_telefone'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
