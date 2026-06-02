@extends('layouts.store')

@section('title', $produto->nome . ' - Amor em Linhas')

@section('content')
<div class="row my-5">
    <div class="col-md-6 d-flex justify-content-center">
        <img src="{{ asset($produto->imagem_principal_url) }}" 
            class="img-fluid rounded shadow" style="max-height: 500px; object-fit: cover;"
            onerror="this.src='https://placehold.co/500x500/d4d9a1/434a11?text=Sem+Foto'">
    </div>
    <div class="col-md-6 mt-4 mt-md-0">
        <h2 style="color: var(--dark-olive) !important;">{{ $produto->nome }}</h2>
        <p class="text-muted mt-3" style="font-size: 1.1rem;">{{ $produto->descricao }}</p>
        
        <h3 class="mt-4 fw-bold" style="color: var(--primary-olive) !important; background-color: var(--dark-olive); padding: 10px 20px; border-radius: 10px; display: inline-block;">
            R$ {{ number_format($produto->preco, 2, ',', '.') }}
        </h3>

        <div class="mt-4">
            @if ($produto->estoque_atual > 0)
                <button class="btn btn-lg w-100 fw-bold shadow-sm btn-comprar" onclick="addCarrinho({{ $produto->id }})" style="font-size: 1.2rem; padding: 15px; border-radius: 30px;">
                    🛒 Comprar Agora
                </button>
                <p class="text-muted small mt-2 text-center">Em estoque: {{ $produto->estoque_atual }} unidades disponíveis</p>
            @else
                <button class="btn btn-secondary btn-lg mt-3 w-100 fw-bold" style="border-radius: 30px;" disabled>
                    🚫 Esgotado
                </button>
            @endif
        </div>
    </div>
</div>
@endsection
