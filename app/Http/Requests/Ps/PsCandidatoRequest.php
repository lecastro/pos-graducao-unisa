<?php

/**
 *
 *
 * @author glalves
 * Criado em: 29/10/2019
 */

namespace App\Http\Requests\Ps;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class PsCandidatoRequest extends FormRequest
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

    protected function prepareForValidation(){

        $this['num_cpf'] = somenteNumeros($this['num_cpf']);
        $this['dddf'] = pegaDDDTelefoneOuCelular(somenteNumeros($this['telefonef']));
        $this['dddc'] = pegaDDDTelefoneOuCelular(somenteNumeros($this['telefonec']));
        $this['telefonef'] = pegaTelefoneOuCelularSemDDD(somenteNumeros($this['telefonef']));
        $this['telefonec'] = pegaTelefoneOuCelularSemDDD(somenteNumeros($this['telefonec']));
        $this['end_cep'] = somenteNumeros($this['end_cep']);

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $dt = new Carbon();

        return [
            'cod_curso_ps' => 'required',
            'cod_campus' => 'required',
            'ind_conhecimento_unisa' => 'required',
            'nom_candidato' => 'required|max:100',
            'ind_sexo' => 'required',
            'dat_nascimento' => 'required|date_format:"d/m/Y"|before_or_equal:'.$dt->subYears(18)->format('d/m/Y'),
            'end_numero' => 'max:10',
            'end_complemento' => 'max:20',
            'end_cep' => 'required',
            'telefonef' => 'required',
            'end_logradouro' => 'required|max:100',
            'end_bairro' => 'required|max:50'
        ];
    }

    public function messages(){
        return ['dat_nascimento.before_or_equal' => 'O candidato deve ter mais que 16 anos'];
    }

    public function attributes()
    {
        return [
            'cod_curso_ps' => '',
            'cod_campus' => '',
            'ind_conhecimento_unisa' => '',
            'nom_candidato' => '',
            'ind_sexo' => '',
            'dat_nascimento' => '',
            'end_numero' => '',
            'end_complemento' => '',
            'end_cep' => '',
            'end_logradouro' => '',
            'end_bairro' => '',
            'telefonef' => ''
        ];
    }
}
