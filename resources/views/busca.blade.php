@extends('layouts.store')

@section('title', 'Buscar: ' . $query . ' - Amor em Linhas')

@section('content')
<section class="my-4 animate-fade-in">
    {{-- Header de Resultados --}}
    <div class="search-results-header">
        <h1 class="section-title" style="font-size: 1.3rem;">Resultados para "{{ $query }}"</h1>
        <p class="search-results-count mt-2 mb-0">
            <strong>{{ $produtos->total() }}</strong> {{ $produtos->total() === 1 ? 'produto encontrado' : 'produtos encontrados' }}
        </p>
    </div>

    {{-- Grid de Produtos --}}
    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
        @forelse($produtos as $index => $prod)
            <div class="col d-flex justify-content-center">
                <div class="card-produto w-100 animate-fade-in-up stagger-{{ ($index % 8) + 1 }}" onclick="window.location.href='{{ url('produto/'.$prod->id) }}'">
                    <div class="card-img-container">
                        <img src="{{ asset($prod->imagem_principal_url) }}"
                             alt="{{ $prod->nome }}"
                             loading="lazy"
                             onerror="this.src='https://placehold.co/400x400/d4d9a1/434a11?text=Sem+Foto'">
                    </div>
                    <div class="card-body-produto">
                        <p class="card-price">
                            R$ {{ number_format($prod->preco, 2, ',', '.') }}
                        </p>
                        <p class="card-frete">Frete grátis</p>
                        <p class="card-title-produto">
                            {{ $prod->nome }}
                        </p>
                        <button class="btn-comprar" onclick="event.stopPropagation(); addCarrinho({{ $prod->id }})">
                            Adicionar ao Carrinho
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state">
                    <div class="empty-state-icon">🔍</div>
                    <p>Nenhum produto encontrado para "<strong>{{ $query }}</strong>"</p>
                    <a href="{{ url('/') }}" class="btn-comprar" style="display: inline-block; width: auto; padding: 12px 32px; border-radius: 30px; text-decoration: none;">
                        Voltar para a loja
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Paginação --}}
    @if($produtos->hasPages())
        <div class="d-flex justify-content-center mt-5">
            {{ $produtos->links() }}
        </div>
    @endif
</section>
@endsection
