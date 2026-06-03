@extends('layouts.store')

@section('title', 'Minha Sacola - Amor em Linhas')

@section('content')
<div class="row g-4 g-lg-5 my-4 animate-fade-in">
    <div class="col-lg-8">
        <h1 class="section-title" style="font-size: 1.3rem;">Minha Sacola</h1>
        <p class="section-subtitle">Revise seus itens antes de finalizar.</p>

        <div id="lista-itens-carrinho">
            <div class="empty-state">
                <div class="empty-state-icon">🛒</div>
                <p>Carregando sua sacola...</p>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="resumo-card p-4">
            <h5 style="font-weight: 600; font-size: 1rem; margin-bottom: 20px; color: var(--text-primary);">Resumo do Pedido</h5>

            <div class="d-flex justify-content-between mb-2">
                <span style="color: var(--text-secondary); font-size: 0.92rem;">Subtotal</span>
                <span id="resumo-subtotal" style="font-weight: 500;">R$ 0,00</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span style="color: var(--text-secondary); font-size: 0.92rem;">Entrega</span>
                <span style="font-weight: 500;">R$ {{ number_format($freteFixo, 2, ',', '.') }}</span>
            </div>
            <hr style="border-color: var(--border-color);">
            <div class="d-flex justify-content-between mb-4">
                <span style="font-weight: 700; font-size: 1rem;">Total</span>
                <span style="font-weight: 700; font-size: 1.2rem; color: var(--primary);" id="resumo-total">R$ 0,00</span>
            </div>

            <form action="{{ url('/checkout') }}" method="POST" id="formFinalizar">
                @csrf
                <input type="hidden" name="carrinho" id="inputCarrinhoJson">
                <button type="button" onclick="finalizarCompra()" class="btn-comprar py-3 mb-2" style="font-size: 0.95rem; border-radius: 12px;">
                    Finalizar Compra
                </button>
            </form>

            <a href="{{ url('/') }}" class="d-block text-center mt-3" style="color: var(--text-secondary); text-decoration: none; font-size: 0.88rem; transition: color 0.2s;">
                ← Continuar comprando
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const produtosDB = @json($todosProdutos);
    const freteFixo = {{ $freteFixo }};

    document.addEventListener("DOMContentLoaded", function() {
        renderizarCarrinho();
    });

    function renderizarCarrinho() {
        const carrinho = getCarrinho();
        const container = document.getElementById('lista-itens-carrinho');

        if (Object.keys(carrinho).length === 0) {
            container.innerHTML = `
                <div class="empty-state">
                    <div class="empty-state-icon">🧺</div>
                    <p>Sua sacola está vazia.</p>
                    <a href="{{ url('/') }}" class="btn-comprar" style="display: inline-block; width: auto; padding: 12px 32px; border-radius: 30px; text-decoration: none;">
                        Explorar produtos
                    </a>
                </div>`;
            return;
        }

        let htmlItens = '';
        let subtotal = 0;

        for (let idProduto in carrinho) {
            let quantidade = carrinho[idProduto];
            let produto = produtosDB.find(p => p.id == idProduto);

            if (produto) {
                let precoTotalItem = produto.preco * quantidade;
                subtotal += precoTotalItem;

                htmlItens += `
                <div class="card mb-3 border-0 card-carrinho" style="border-radius: 12px;">
                    <div class="row g-0 align-items-center p-3">
                        <div class="col-3 col-md-2">
                            <img src="/${produto.imagem_principal_url}" class="img-fluid" style="border-radius: 10px; aspect-ratio: 1/1; object-fit: cover;" alt="${produto.nome}" onerror="this.src='https://placehold.co/200x200/d4d9a1/434a11?text=Sem+Foto'">
                        </div>
                        <div class="col-9 col-md-10 ps-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <h6 class="mb-1" style="font-weight: 600; font-size: 0.95rem; color: var(--text-primary);">${produto.nome}</h6>
                                <button class="btn btn-sm p-0" onclick="removerItem(${produto.id})" style="color: var(--danger); font-size: 0.8rem; font-weight: 500; border: none; background: none;">Remover</button>
                            </div>
                            <div class="d-flex align-items-center mt-2 mb-2">
                                <div class="qty-control">
                                    <button class="qty-btn" onclick="alterarQtd(${produto.id}, -1)">−</button>
                                    <span class="qty-value">${quantidade}</span>
                                    <button class="qty-btn" onclick="alterarQtd(${produto.id}, 1)">+</button>
                                </div>
                            </div>
                            <p class="mb-0" style="font-weight: 700; font-size: 1rem; color: var(--primary);">R$ ${precoTotalItem.toFixed(2).replace('.', ',')}</p>
                        </div>
                    </div>
                </div>`;
            }
        }

        container.innerHTML = htmlItens;

        let total = subtotal > 0 ? subtotal + freteFixo : 0;

        document.getElementById('resumo-subtotal').innerText = 'R$ ' + subtotal.toFixed(2).replace('.', ',');
        document.getElementById('resumo-total').innerText = 'R$ ' + total.toFixed(2).replace('.', ',');
    }

    function alterarQtd(id, delta) {
        let carrinho = getCarrinho();
        if (!carrinho[id]) return;

        carrinho[id] += delta;
        if (carrinho[id] <= 0) {
            delete carrinho[id];
        }
        salvarCarrinho(carrinho);
        renderizarCarrinho();
        atualizarBadgeCarrinho();
    }

    function finalizarCompra() {
        const carrinho = localStorage.getItem("carrinho");
        if (!carrinho || carrinho === "{}" || Object.keys(JSON.parse(carrinho)).length === 0) {
            alert("Sua sacola está vazia!");
            return;
        }

        @auth
            document.getElementById('inputCarrinhoJson').value = carrinho;
            document.getElementById('formFinalizar').submit();
        @else
            // Save current state and redirect to login
            window.location.href = "{{ route('login') }}";
        @endauth
    }
</script>
@endsection
