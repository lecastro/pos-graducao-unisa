<div class="card-body">
    <h5 class="card-title">Extensão Presencial</h5>
    <p>Cursos livres em diversas áreas do conhecimento</p>
    @if($cod_proc_seletivo_ext && $cod_proc_seletivo_ext != 0)
        @if (getTodasIncricoesExtensao($cod_proc_seletivo_ext) >= 4)
        <h3><span class="text-wrap badge badge-secondary">Limite de curso por processo seletivo atingido!</span></h3>
        @else
            <a href="{{ route('candidato.create', ['id' => encrypt(auth()->user()->num_cpf), 'cod_niv_ens' => 10, 'modalidade' => 'P']) }}"
            class="btn btn-primary">Fazer matrícula</a>
        @endif
    @else
        <h3><span class="text-wrap badge badge-secondary">Não há processo seletivo aberto no momento!</span></h3>
    @endif
</div>
