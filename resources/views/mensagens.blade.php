{{-- messagem de sucesso para cadastrar --}}

@if(session('success'))
<div class="alert alert-success mt-2" role="alert">
    {{ session('success') }}
</div>
@endif

{{-- ouve alguem erro --}}

@if(session('erros'))
<div class="alert alert-danger" role="alert">
    {{session('erros')}}
</div>
@endif
