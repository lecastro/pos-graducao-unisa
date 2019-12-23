<?php

/**
 *
 *
 * @author selopes
 * Criado em: 11/11/2019
 */

namespace App\Http\Requests\Ca;

use Illuminate\Foundation\Http\FormRequest;

class CaAlunoRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'num_cpf' => 'required',
            'nom_aluno' => 'required',
            'dsc_end_e_mail' => 'required|email:rfc',
            "num_telefone" => 'required',
            'ind_sexo' => 'required|numeric',
            'dat_nascimento' => 'required',
            'end_cep_aluno' => 'required',
            'end_num_aluno' => 'required|max:10'
        ];
    }

    public function attributes()
    {
        return [
            'num_cpf' => 'CPF',
            'nom_aluno' => 'Nome',
            'dsc_end_e_mail' => 'E-mail',
            'num_telefone' => 'Celular',
            'ind_sexo' => 'Gênero',
            'dat_nascimento' => 'Data de nascimento',
            'end_cep_aluno' => 'CEP',
            'end_num_aluno' => 'Número'
        ];
    }
}
