<?php

namespace App\Http\Middleware;

use Closure;

class CheckStudent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!getRaAluno(auth()->user()->num_cpf)){
            return redirect()->route('candidato.index');
        }

        return $next($request);
    }
}
