<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

     //Converte os inputs antes de passar no processo de validação
     public function validationData(){
        $cpf = str_replace(['.', '-', '_'], '', $this->num_cpf);

        $telefones = str_replace(['.', '-', '_', '(', ')', ' '], '', $this->num_cel);

        $this->request->set('num_cpf', $cpf);
        $this->request->set('num_telefone', $telefones);

        return $this->request->all();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return  [
            'num_cpf' => 'required|numeric|digits_between:11,11|cpf|unique:users',
            'name' => 'required|string|max:100|min:5|regex:/^[\pL\s\-]+$/u',
            'email' => 'required|string|email|max:255|unique:users',
            'num_telefone' => 'required|numeric|digits_between:1,19',
            'password' => 'required|string|min:8|confirmed',
        ];
    }
}
