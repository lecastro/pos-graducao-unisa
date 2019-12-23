<?php

namespace App\Http\Requests\Ca;

use Illuminate\Foundation\Http\FormRequest;
use DB;

class CaAlunoDoctoPendRequest extends FormRequest
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
        $rules = [
            'filesDiploma' => ['file', 'mimes:pdf', 'max:2048'],
            'filesDeclaracao' => ['file', 'mimes:pdf', 'max:2048'],
            'filesHistorico' => ['file', 'mimes:pdf', 'max:2048'],
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            'filesDiploma' => 'Diploma',
            'filesDeclaracao' => 'Declaração',
            'filesHistorico' => 'Histórico'
        ];
    }
}
