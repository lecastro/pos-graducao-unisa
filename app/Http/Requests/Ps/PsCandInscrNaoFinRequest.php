<?php

/**
 *
 *
 * @author selopes
 * Criado em: 07/11/2019
 */

namespace App\Http\Requests\Ps;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;


class PsCandInscrNaoFinRequest extends FormRequest
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
        $this['telefonec'] = somenteNumeros($this['telefonec']);
        $this['telefonef'] = somenteNumeros($this['telefonef']);
        $this['end_cep'] = somenteNumeros($this['end_cep']);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $array = [
            'cod_curso_ps' => 'required',
            'cod_campus' => 'required',
            'ind_conhecimento_unisa' => 'required'
        ];
        if($this->step == 'step2'){
            $dt = new Carbon();
            $array['nom_candidato'] = 'required|max:100';
            $array['ind_sexo'] = 'required';
            $array['telefonef'] = 'required|digits:10';
            $array['dat_nascimento'] = 'required|date_format:"d/m/Y"|before_or_equal:'.$dt->subYears(18)->format('d/m/Y');
        }
        if($this->step == 'step3'){
            $array['end_cep'] = 'required|numeric|digits:8';
            $array['end_logradouro'] = 'required|max:100';
            $array['end_bairro'] = 'required|max:50';
            $array['end_complemento'] = 'max:20';
            $array['end_numero'] = 'max:10';
            $array['end_localidade'] = 'required|max:40';
            $array['end_uf'] = 'required|max:2';
        }

        return $array;
    }

    public function messages(){
        return ['dat_nascimento.before_or_equal' => 'O candidato deve ter mais que 16 anos'];
    }

    public function attributes()
    {
        $array = [
            'cod_curso_ps' => '',
            'cod_campus' => '',
            'ind_conhecimento_unisa' => ''
        ];
        if($this->step == 'step2'){
            $array['nom_candidato'] = '';
            $array['ind_sexo'] = '';
            $array['telefonef'] = '';
            $array['dat_nascimento'] = '';
        }
        if($this->step == 'step3'){
            $array['end_cep'] = '';
            $array['end_logradouro'] = '';
            $array['end_bairro'] = '';
            $array['end_complemento'] = '';
            $array['end_numero'] = '';
            $array['end_localidade'] = '';
            $array['end_uf'] = '';
        }

        return $array;
    }
}
