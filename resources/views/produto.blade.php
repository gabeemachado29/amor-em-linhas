@extends('layouts.store')

@section('title', $produto->nome . ' - Amor em Linhas')

@section('content')
<div class="row my-5 animate-fade-in">
    {{-- Imagem do Produto --}}
    <div class="col-md-6 d-flex justify-content-center mb-4 mb-md-0">
        <div class="product-detail-img w-100">
            <img src="{{ asset($produto->imagem_principal_url) }}"
                class="img-fluid w-100" style="max-height: 520px; object-fit: cover;"
                alt="{{ $produto->nome }}"
                onerror="this.src='https://placehold.co/500x500/d4d9a1/434a11?text=Sem+Foto'">
        </div>
    </div>

    {{-- Detalhes do Produto --}}
    <div class="col-md-6">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb" style="font-size: 0.82rem;">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" style="color: var(--olive-500); text-decoration: none;">Início</a></li>
                <li class="breadcrumb-item active" aria-current="page" style="color: var(--text-secondary);">{{ Str::limit($produto->nome, 30) }}</li>
            </ol>
        </nav>

        <h1 class="font-playfair" style="font-size: 1.8rem; font-weight: 700; color: var(--text-primary); line-height: 1.3; margin-bottom: 16px;">
            {{ $produto->nome }}
        </h1>

        @if($produto->descricao)
            <p style="color: var(--text-secondary); font-size: 1rem; line-height: 1.7; margin-bottom: 24px;">
                {{ $produto->descricao }}
            </p>
        @endif

        <div class="product-price-tag mb-4">
            R$ {{ number_format($produto->preco, 2, ',', '.') }}
        </div>

        <p class="mb-4" style="color: var(--success); font-weight: 600; font-size: 0.92rem;">
            ✓ Frete grátis para todo o Brasil
        </p>

        <div class="mt-3">
            @if ($produto->estoque_atual > 0)
                <button class="btn-comprar py-3" onclick="addCarrinho({{ $produto->id }})" style="font-size: 1.1rem; border-radius: 12px; max-width: 400px;">
                    🛒 Comprar Agora
                </button>
                <p class="mt-3" style="color: var(--text-secondary); font-size: 0.85rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: -2px; margin-right: 4px;"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Em estoque — <strong>{{ $produto->estoque_atual }}</strong> {{ $produto->estoque_atual === 1 ? 'unidade disponível' : 'unidades disponíveis' }}
                </p>
            @else
                <button class="btn btn-secondary btn-lg w-100 fw-bold" style="border-radius: 12px; max-width: 400px; padding: 14px;" disabled>
                    Esgotado
                </button>
                <p class="mt-2" style="color: var(--danger); font-size: 0.85rem;">
                    Este produto está temporariamente indisponível.
                </p>
            @endif
        </div>

        {{-- Info extras --}}
        <div class="mt-4 pt-4" style="border-top: 1px solid var(--border-color);">
            <div class="d-flex align-items-center mb-3" style="gap: 12px; color: var(--text-secondary); font-size: 0.88rem;">
                <span>🔒</span>
                <span>Compra 100% segura</span>
            </div>
            <div class="d-flex align-items-center mb-3" style="gap: 12px; color: var(--text-secondary); font-size: 0.88rem;">
                <span>📦</span>
                <span>Envio em até 3 dias úteis</span>
            </div>
            <div class="d-flex align-items-center" style="gap: 12px; color: var(--text-secondary); font-size: 0.88rem;">
                <span>🧶</span>
                <span>Produto feito à mão com carinho</span>
            </div>
        </div>
    </div>
</div>
@endsection
