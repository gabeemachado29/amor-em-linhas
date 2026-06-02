@extends('layouts.store')

@section('title', 'Amor em Linhas - Produtos')

@section('content')
    @if (count($banners) > 0)
        <div id="carouselPromo" class="carousel slide shadow-sm mb-5" data-bs-ride="carousel" data-bs-interval="10000">
            
            <div class="carousel-indicators">
                @foreach ($banners as $index => $b)
                    <button type="button" data-bs-target="#carouselPromo" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}" aria-current="true"></button>
                @endforeach
            </div>

            <div class="carousel-inner" style="border-radius: 15px;">
                @foreach ($banners as $index => $b)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}" data-bs-interval="10000">
                        <img src="{{ asset($b->imagem_url) }}" class="d-block w-100" alt="{{ $b->titulo }}">
                        @if ($b->titulo)
                            <div class="carousel-caption d-none d-md-block" style="background: rgba(0,0,0,0.4); border-radius: 10px; padding: 5px 15px;">
                                <h5 class="mb-0">{{ $b->titulo }}</h5>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
            
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselPromo" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselPromo" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </button>
        </div>
    @endif

    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3 justify-content-center">
        @forelse($produtos as $prod)
            <div class="col d-flex justify-content-center">
                <div class="card-produto w-100" onclick="window.location.href='{{ url('produto/'.$prod->id) }}'">
                    <div class="card-img-container">
                        <img src="{{ asset($prod->imagem_principal_url) }}" 
                             alt="{{ $prod->nome }}"
                             onerror="this.src='https://placehold.co/400x400/d4d9a1/434a11?text=Sem+Foto'">
                    </div>
                    <div class="card-body-produto">
                        <p class="card-price">
                            R$ {{ number_format($prod->preco, 2, ',', '.') }}
                        </p>
                        <p class="card-frete">Chegará grátis amanhã</p>
                        <p class="card-title-produto">
                            {{ $prod->nome }}
                        </p>
                        
                        @auth
                            @if(auth()->user()->tipo_perfil === 'ADMIN')
                                <a href="{{ url('admin/produtos/'.$prod->id.'/edit') }}" class="btn btn-warning btn-sm w-100 py-1 fw-bold" style="font-size: 0.7rem; border-radius: 20px;">
                                    ✏️ Editar
                                </a>
                            @else
                                <button class="btn btn-comprar w-100 py-1 mt-auto" onclick="event.stopPropagation(); addCarrinho({{ $prod->id }})">
                                    Adicionar ao Carrinho
                                </button>
                            @endif
                        @else
                            <button class="btn btn-comprar w-100 py-1 mt-auto" onclick="event.stopPropagation(); addCarrinho({{ $prod->id }})">
                                Adicionar ao Carrinho
                            </button>
                        @endauth
                    </div>
                </div>
            </div>
        @empty
            <div class='col-12 text-center'><p class='alert alert-warning'>Nenhum produto encontrado.</p></div>
        @endforelse
    </div>
@endsection

@section('styles')
<style>
    .carousel-item img {
        height: 300px;
        object-fit: cover;
        border-radius: 15px;
    }
    
    .carousel-control-prev-icon, .carousel-control-next-icon {
        background-color: rgba(0,0,0,0.3);
        border-radius: 50%;
        padding: 20px;
    }

    .card-produto {
        transition: transform 0.3s;
        margin-bottom: 20px;
    }
    .card-produto:hover {
        transform: translateY(-5px);
    }
    .card-img-container img {
        aspect-ratio: 1/1 !important;
        border-radius: 10px !important;
    }
</style>
@endsection
