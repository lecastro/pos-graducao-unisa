<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Vw\VwCep;
use Illuminate\Http\Request;

class CepController extends Controller
{

    public function getCepByNumber($n_cep){
        $vwCep = VwCep::select([
            'logradouro as logradouro',
            'bairro as bairro',
            'cidade as localidade',
            'uf'
        ])
        ->where('cep', intval($n_cep))
        ->first();

        return response()->json(
            $vwCep
        );
    }
}
