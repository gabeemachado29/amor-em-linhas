@extends('layouts.store')

@section('title', 'Amor em Linhas - Produtos Artesanais')

@section('content')
    {{-- Carousel de Banners --}}
    @if (count($banners) > 0)
        <div id="carouselPromo" class="carousel slide mb-5 animate-fade-in" data-bs-ride="carousel" data-bs-interval="8000">

            <div class="carousel-indicators">
                @foreach ($banners as $index => $b)
                    <button type="button" data-bs-target="#carouselPromo" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}" aria-current="true"></button>
                @endforeach
            </div>

            <div class="carousel-inner">
                @foreach ($banners as $index => $b)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}" data-bs-interval="8000">
                        <img src="{{ asset($b->imagem_url) }}" class="d-block w-100" alt="{{ $b->titulo }}">
                        @if ($b->titulo)
                            <div class="carousel-caption d-none d-md-block">
                                <h5 class="mb-0">{{ $b->titulo }}</h5>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#carouselPromo" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselPromo" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Próximo</span>
            </button>
        </div>
    @endif

    {{-- Seção de Destaques --}}
    <section class="mb-5">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="section-title">Nossos Produtos</h2>
                <p class="section-subtitle mb-0">Feitos à mão com amor e carinho</p>
            </div>
        </div>

        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3 justify-content-center">
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

                            @auth
                                @if(auth()->user()->tipo_perfil === 'ADMIN')
                                    <a href="{{ url('admin/produtos/'.$prod->id.'/edit') }}" class="btn btn-warning btn-sm w-100 py-1 fw-bold" style="font-size: 0.7rem; border-radius: 20px;" onclick="event.stopPropagation();">
                                        ✏️ Editar
                                    </a>
                                @else
                                    <button class="btn-comprar" onclick="event.stopPropagation(); addCarrinho({{ $prod->id }})">
                                        Adicionar ao Carrinho
                                    </button>
                                @endif
                            @else
                                <button class="btn-comprar" onclick="event.stopPropagation(); addCarrinho({{ $prod->id }})">
                                    Adicionar ao Carrinho
                                </button>
                            @endauth
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state">
                        <div class="empty-state-icon">🧶</div>
                        <p>Nenhum produto encontrado no momento.</p>
                        <small style="color: var(--text-secondary);">Volte em breve para conferir novidades!</small>
                    </div>
                </div>
            @endforelse
        </div>
    </section>
@endsection
