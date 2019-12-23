<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Ca\CaAluno;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $ra = getRaAluno(auth()->user()->num_cpf);
        if($ra){
            $caAluno = new CaAluno;
            return view('home')->with(['cursosPos' => $caAluno->getCursos($ra, 13)]);
        }

        return view('home');
    }
}
