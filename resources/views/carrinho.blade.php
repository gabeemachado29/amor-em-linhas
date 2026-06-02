@extends('layouts.store')

@section('title', 'Minha Sacola - Amor em Linhas')

@section('content')
<div class="row g-5 my-5">
    <div class="col-md-8">
        <h4 class="fw-light text-uppercase mb-4">Minha Sacola</h4>
        
        <div id="lista-itens-carrinho">
            <div class="py-5 text-center">
                <p class="text-muted">Carregando sua sacola...</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-4" style="background-color: #fdfdfd; border-radius: 15px;">
            <h5 class="fw-light text-uppercase mb-4">Resumo do Pedido</h5>
            
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Subtotal</span>
                <span id="resumo-subtotal">R$ 0,00</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Entrega (PAC)</span>
                <span class="text-success small">Grátis</span>
            </div>
            <hr>
            <div class="d-flex justify-content-between mb-4">
                <span class="fw-bold">Total</span>
                <span class="fw-bold fs-5" id="resumo-total" style="color: var(--dark-olive);">R$ 0,00</span>
            </div>

            <form action="{{ url('/checkout') }}" method="POST" id="formFinalizar">
                @csrf
                <input type="hidden" name="carrinho" id="inputCarrinhoJson">
                <button type="button" onclick="finalizarCompra()" class="btn-comprar w-100 py-3 mb-2 shadow-sm" style="font-size: 0.9rem;">
                    Finalizar Compra
                </button>
            </form>
            
            <a href="{{ url('/') }}" class="btn btn-link w-100 text-dark text-decoration-none small text-center mt-2">Continuar Comprando</a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Transforma os produtos do PHP em uma variável JavaScript
    const produtosDB = @json($todosProdutos);

    document.addEventListener("DOMContentLoaded", function() {
        renderizarCarrinho();
    });

    function renderizarCarrinho() {
        const carrinho = getCarrinho(); // Função do seu js/carrinho.js
        const container = document.getElementById('lista-itens-carrinho');
        
        if (Object.keys(carrinho).length === 0) {
            container.innerHTML = `
                <div class="py-5 text-center">
                    <p class="text-muted">Sua sacola está vazia.</p>
                    <a href="{{ url('/') }}" class="btn btn-outline-dark rounded-pill px-4">Voltar para a loja</a>
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
                <div class="card mb-3 shadow-sm border-0" style="border-radius: 12px;">
                    <div class="row g-0 align-items-center p-3">
                        <div class="col-3 col-md-2">
                            <img src="/${produto.imagem_principal_url}" class="img-fluid rounded" alt="${produto.nome}" onerror="this.src='https://placehold.co/400x533/d4d9a1/434a11?text=Sem+Foto'">
                        </div>
                        <div class="col-9 col-md-10 ps-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-bold">${produto.nome}</h6>
                                <button class="btn btn-sm text-danger p-0" onclick="removerItem(${produto.id})">Remover</button>
                            </div>
                            <p class="text-muted mb-1 small">Quantidade: ${quantidade}</p>
                            <p class="mb-0 fw-bold" style="color: var(--dark-olive);">R$ ${precoTotalItem.toFixed(2).replace('.', ',')}</p>
                        </div>
                    </div>
                </div>`;
            }
        }

        container.innerHTML = htmlItens;

        let valorFormatado = 'R$ ' + subtotal.toFixed(2).replace('.', ',');
        document.getElementById('resumo-subtotal').innerText = valorFormatado;
        document.getElementById('resumo-total').innerText = valorFormatado;
    }

    function finalizarCompra() {
        const carrinho = localStorage.getItem("carrinho");
        if (!carrinho || carrinho === "{}") {
            alert("Sua sacola está vazia!");
            return;
        }
        
        document.getElementById('inputCarrinhoJson').value = carrinho;
        document.getElementById('formFinalizar').submit();
    }
</script>
@endsection
