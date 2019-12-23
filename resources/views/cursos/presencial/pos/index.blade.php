<div class="card-body">
    <h5 class="card-title">Pós-graduação Presencial</h5>
    <p>Cursos de Especialização, MBA e Aprimoramento</p>

    @if($cod_proc_seletivo_pos && $cod_proc_seletivo_pos != 0)
        <a href="{{ route('candidato.create', ['id' => encrypt(auth()->user()->num_cpf), 'cod_niv_ens' => 13, 'modalidade' => 'P']) }}"
            class="btn btn-primary">Fazer matrícula</a>
    @else
        <h3><span class="text-wrap badge badge-secondary">Não há processo seletivo aberto no momento!</span></h3>
    @endif
</div>
