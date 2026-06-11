@extends('layouts.store')

@section('title', 'Checkout | Amor em Linhas')

@section('styles')
<style>
    .checkout-section {
        background: var(--bg-card);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        padding: 32px;
        margin-bottom: 24px;
        border: 1px solid var(--border-color);
        transition: box-shadow var(--transition-fast);
    }
    .checkout-section:hover {
        box-shadow: var(--shadow-md);
    }
    .checkout-section-title {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        font-size: 1.15rem;
        color: var(--text-primary);
        margin-bottom: 24px;
        padding-bottom: 12px;
        border-bottom: 2px solid var(--olive-100);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .checkout-section-number {
        width: 28px;
        height: 28px;
        background: linear-gradient(135deg, var(--olive-600), var(--olive-700));
        color: var(--olive-50);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        font-weight: 700;
        font-family: 'Inter', sans-serif;
    }
    [data-bs-theme="dark"] .checkout-section-number {
        background: linear-gradient(135deg, var(--olive-400), var(--olive-500));
        color: var(--olive-900);
    }
    .checkout-input {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid var(--border-color);
        border-radius: var(--radius-sm);
        font-size: 0.92rem;
        font-family: 'Inter', sans-serif;
        color: var(--text-primary);
        background: var(--bg-card);
        transition: all var(--transition-fast);
    }
    .checkout-input:focus {
        outline: none;
        border-color: var(--olive-400);
        box-shadow: 0 0 0 4px rgba(212, 217, 161, 0.25);
    }
    .checkout-label {
        display: block;
        font-weight: 500;
        font-size: 0.85rem;
        color: var(--text-primary);
        margin-bottom: 6px;
    }
    .checkout-label .required {
        color: var(--danger);
        margin-left: 2px;
    }
    .checkout-form-group {
        margin-bottom: 16px;
    }
    .payment-option {
        border: 2px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: 20px;
        cursor: pointer;
        transition: all var(--transition-fast);
        display: flex;
        align-items: center;
        gap: 16px;
        position: relative;
    }
    .payment-option:hover {
        border-color: var(--olive-300);
        background: var(--olive-50);
    }
    [data-bs-theme="dark"] .payment-option:hover {
        background: var(--neutral-800);
    }
    .payment-option.selected {
        border-color: var(--olive-500);
        background: var(--olive-50);
        box-shadow: 0 0 0 3px rgba(122, 138, 46, 0.15);
    }
    [data-bs-theme="dark"] .payment-option.selected {
        background: rgba(122, 138, 46, 0.1);
    }
    .payment-option input[type="radio"] {
        display: none;
    }
    .payment-radio-circle {
        width: 22px;
        height: 22px;
        border: 2px solid var(--neutral-300);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: all var(--transition-fast);
    }
    .payment-option.selected .payment-radio-circle {
        border-color: var(--olive-500);
    }
    .payment-option.selected .payment-radio-circle::after {
        content: '';
        width: 12px;
        height: 12px;
        background: var(--olive-500);
        border-radius: 50%;
    }
    .payment-icon {
        font-size: 1.6rem;
        flex-shrink: 0;
    }
    .payment-info h6 {
        font-weight: 600;
        margin: 0 0 2px;
        color: var(--text-primary);
        font-size: 0.95rem;
    }
    .payment-info p {
        margin: 0;
        color: var(--text-secondary);
        font-size: 0.82rem;
    }
    .payment-option.disabled {
        opacity: 0.5;
        pointer-events: none;
    }
    .payment-option .badge-soon {
        position: absolute;
        top: 10px;
        right: 10px;
        background: var(--warning);
        color: #000;
        font-size: 0.65rem;
        padding: 3px 8px;
        border-radius: var(--radius-full);
        font-weight: 700;
        text-transform: uppercase;
    }

    /* Resumo lateral */
    .checkout-resumo {
        background: var(--bg-card);
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-md);
        position: sticky;
        top: 90px;
        overflow: hidden;
    }
    .checkout-resumo-header {
        background: linear-gradient(135deg, var(--olive-700), var(--olive-800));
        color: var(--olive-50);
        padding: 20px 24px;
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        font-size: 1rem;
    }
    [data-bs-theme="dark"] .checkout-resumo-header {
        background: linear-gradient(135deg, var(--olive-600), var(--olive-700));
    }
    .checkout-resumo-body {
        padding: 24px;
    }
    .checkout-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid var(--border-color);
    }
    .checkout-item:last-child {
        border-bottom: none;
    }
    .checkout-item-img {
        width: 48px;
        height: 48px;
        border-radius: var(--radius-sm);
        object-fit: cover;
        flex-shrink: 0;
    }
    .checkout-item-info {
        flex: 1;
        min-width: 0;
    }
    .checkout-item-name {
        font-size: 0.82rem;
        font-weight: 500;
        color: var(--text-primary);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .checkout-item-qty {
        font-size: 0.75rem;
        color: var(--text-secondary);
    }
    .checkout-item-price {
        font-weight: 600;
        font-size: 0.88rem;
        color: var(--text-primary);
        flex-shrink: 0;
    }

    @media (max-width: 768px) {
        .checkout-section {
            padding: 20px;
        }
        .checkout-resumo {
            position: static;
        }
    }
</style>
@endsection

@section('content')
<div class="row g-4 g-lg-5 my-3 animate-fade-in-up">
    {{-- Formulário --}}
    <div class="col-lg-7">
        <h1 class="section-title mb-1" style="font-size: 1.3rem;">Finalizar Compra</h1>
        <p class="section-subtitle" style="margin-bottom: 24px;">Preencha os dados de entrega para concluir seu pedido.</p>

        <form action="{{ route('checkout.process') }}" method="POST" id="formCheckout">
            @csrf
            <input type="hidden" name="carrinho" id="inputCarrinhoJson">

            {{-- Endereço de Entrega --}}
            <div class="checkout-section">
                <div class="checkout-section-title">
                    <span class="checkout-section-number">1</span>
                    Endereço de Entrega
                </div>

                <div class="row">
                    <div class="col-md-4 checkout-form-group">
                        <label class="checkout-label">CEP <span class="required">*</span></label>
                        <input type="text" name="endereco_cep" id="cep" class="checkout-input @error('endereco_cep') is-invalid @enderror" placeholder="00000-000" maxlength="9" required value="{{ old('endereco_cep') }}">
                        @error('endereco_cep')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small id="cep-loading" class="text-muted" style="display:none;">🔍 Buscando endereço...</small>
                    </div>
                    <div class="col-md-8 checkout-form-group">
                        <label class="checkout-label">Rua / Logradouro <span class="required">*</span></label>
                        <input type="text" name="endereco_rua" id="rua" class="checkout-input @error('endereco_rua') is-invalid @enderror" placeholder="Nome da rua" required value="{{ old('endereco_rua') }}">
                        @error('endereco_rua')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 checkout-form-group">
                        <label class="checkout-label">Número <span class="required">*</span></label>
                        <input type="text" name="endereco_numero" id="numero" class="checkout-input @error('endereco_numero') is-invalid @enderror" placeholder="123" required value="{{ old('endereco_numero') }}">
                        @error('endereco_numero')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 checkout-form-group">
                        <label class="checkout-label">Complemento</label>
                        <input type="text" name="endereco_complemento" class="checkout-input" placeholder="Apto, bloco..." value="{{ old('endereco_complemento') }}">
                    </div>
                    <div class="col-md-5 checkout-form-group">
                        <label class="checkout-label">Bairro <span class="required">*</span></label>
                        <input type="text" name="endereco_bairro" id="bairro" class="checkout-input @error('endereco_bairro') is-invalid @enderror" placeholder="Bairro" required value="{{ old('endereco_bairro') }}">
                        @error('endereco_bairro')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8 checkout-form-group">
                        <label class="checkout-label">Cidade <span class="required">*</span></label>
                        <input type="text" name="endereco_cidade" id="cidade" class="checkout-input @error('endereco_cidade') is-invalid @enderror" placeholder="Sua cidade" required value="{{ old('endereco_cidade') }}">
                        @error('endereco_cidade')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 checkout-form-group">
                        <label class="checkout-label">Estado <span class="required">*</span></label>
                        <select name="endereco_estado" id="estado" class="checkout-input @error('endereco_estado') is-invalid @enderror" required>
                            <option value="">UF</option>
                            @foreach(['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'] as $uf)
                                <option value="{{ $uf }}" {{ old('endereco_estado') == $uf ? 'selected' : '' }}>{{ $uf }}</option>
                            @endforeach
                        </select>
                        @error('endereco_estado')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Forma de Pagamento --}}
            <div class="checkout-section">
                <div class="checkout-section-title">
                    <span class="checkout-section-number">2</span>
                    Forma de Pagamento
                </div>

                <div class="d-flex flex-column gap-3">
                    {{-- PIX --}}
                    <label class="payment-option selected" id="optionPix" onclick="selecionarPagamento('PIX')">
                        <input type="radio" name="metodo_pagamento" value="PIX" checked>
                        <div class="payment-radio-circle"></div>
                        <div class="payment-icon">💸</div>
                        <div class="payment-info">
                            <h6>PIX</h6>
                            <p>Pagamento instantâneo via chave PIX. Aprovação imediata.</p>
                        </div>
                    </label>

                    {{-- Mercado Pago --}}
                    @if($mercadoPagoAtivo)
                        <label class="payment-option" id="optionMercadoPago" onclick="selecionarPagamento('MERCADO_PAGO')">
                            <input type="radio" name="metodo_pagamento" value="MERCADO_PAGO">
                            <div class="payment-radio-circle"></div>
                            <div class="payment-icon">💳</div>
                            <div class="payment-info">
                                <h6>Cartão de Crédito / Débito</h6>
                                <p>Via Mercado Pago. Parcele em até 12x.</p>
                            </div>
                        </label>
                    @else
                        <div class="payment-option disabled">
                            <div class="payment-radio-circle"></div>
                            <div class="payment-icon">💳</div>
                            <div class="payment-info">
                                <h6>Cartão de Crédito / Débito</h6>
                                <p>Via Mercado Pago. Em breve disponível.</p>
                            </div>
                            <span class="badge-soon">Em breve</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Botão mobile --}}
            <div class="d-lg-none mt-3">
                <button type="button" onclick="finalizarCheckout()" class="btn-comprar py-3" style="font-size: 1rem; border-radius: 12px;">
                    🔒 Finalizar Pedido
                </button>
            </div>
        </form>
    </div>

    {{-- Resumo do Pedido --}}
    <div class="col-lg-5">
        <div class="checkout-resumo">
            <div class="checkout-resumo-header">
                🛒 Resumo do Pedido
            </div>
            <div class="checkout-resumo-body">
                <div id="checkout-itens">
                    <div class="text-center py-3">
                        <span class="text-muted" style="font-size: 0.88rem;">Carregando itens...</span>
                    </div>
                </div>

                <hr style="border-color: var(--border-color); margin: 16px 0;">

                <div class="d-flex justify-content-between mb-2">
                    <span style="color: var(--text-secondary); font-size: 0.88rem;">Subtotal</span>
                    <span id="checkout-subtotal" style="font-weight: 500; font-size: 0.92rem;">R$ 0,00</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span style="color: var(--text-secondary); font-size: 0.88rem;">Entrega</span>
                    <span style="font-weight: 500; font-size: 0.92rem;">R$ {{ number_format($freteFixo, 2, ',', '.') }}</span>
                </div>

                <hr style="border-color: var(--border-color); margin: 16px 0;">

                <div class="d-flex justify-content-between mb-4">
                    <span style="font-weight: 700; font-size: 1.05rem; color: var(--text-primary);">Total</span>
                    <span style="font-weight: 700; font-size: 1.3rem; color: var(--primary);" id="checkout-total">R$ 0,00</span>
                </div>

                <button type="button" onclick="finalizarCheckout()" class="btn-comprar py-3 d-none d-lg-block" style="font-size: 0.95rem; border-radius: 12px;">
                    🔒 Finalizar Pedido
                </button>

                <a href="{{ url('/carrinho') }}" class="d-block text-center mt-3" style="color: var(--text-secondary); text-decoration: none; font-size: 0.85rem;">
                    ← Voltar à sacola
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const produtosDB = @json($todosProdutos);
    const freteFixo = {{ $freteFixo }};

    document.addEventListener("DOMContentLoaded", function() {
        renderizarResumo();
        configurarMascaraCEP();
    });

    function renderizarResumo() {
        const carrinho = getCarrinho();
        const container = document.getElementById('checkout-itens');

        if (Object.keys(carrinho).length === 0) {
            window.location.href = "{{ url('/carrinho') }}";
            return;
        }

        let html = '';
        let subtotal = 0;

        for (let idProduto in carrinho) {
            let quantidade = carrinho[idProduto];
            let produto = produtosDB.find(p => p.id == idProduto);

            if (produto) {
                let precoItem = produto.preco * quantidade;
                subtotal += precoItem;

                html += `
                <div class="checkout-item">
                    <img src="/${produto.imagem_principal_url}" class="checkout-item-img" alt="${produto.nome}" onerror="this.src='https://placehold.co/100x100/d4d9a1/434a11?text=Foto'">
                    <div class="checkout-item-info">
                        <div class="checkout-item-name">${produto.nome}</div>
                        <div class="checkout-item-qty">${quantidade}x — R$ ${produto.preco.toFixed(2).replace('.', ',')}</div>
                    </div>
                    <div class="checkout-item-price">R$ ${precoItem.toFixed(2).replace('.', ',')}</div>
                </div>`;
            }
        }

        container.innerHTML = html;
        let total = subtotal + freteFixo;
        document.getElementById('checkout-subtotal').innerText = 'R$ ' + subtotal.toFixed(2).replace('.', ',');
        document.getElementById('checkout-total').innerText = 'R$ ' + total.toFixed(2).replace('.', ',');
    }

    function selecionarPagamento(metodo) {
        document.querySelectorAll('.payment-option').forEach(el => el.classList.remove('selected'));
        if (metodo === 'PIX') {
            document.getElementById('optionPix').classList.add('selected');
        } else if (metodo === 'MERCADO_PAGO') {
            const mpEl = document.getElementById('optionMercadoPago');
            if (mpEl) mpEl.classList.add('selected');
        }
    }

    function finalizarCheckout() {
        const carrinho = localStorage.getItem("carrinho");
        if (!carrinho || carrinho === "{}" || Object.keys(JSON.parse(carrinho)).length === 0) {
            alert("Sua sacola está vazia!");
            return;
        }

        document.getElementById('inputCarrinhoJson').value = carrinho;
        document.getElementById('formCheckout').submit();
    }

    // Máscara e busca automática de CEP
    function configurarMascaraCEP() {
        const cepInput = document.getElementById('cep');
        cepInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 5) {
                value = value.substring(0, 5) + '-' + value.substring(5, 8);
            }
            e.target.value = value;

            // Auto-busca via ViaCEP
            if (value.replace('-', '').length === 8) {
                buscarCEP(value.replace('-', ''));
            }
        });
    }

    function buscarCEP(cep) {
        const loading = document.getElementById('cep-loading');
        loading.style.display = 'block';

        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(res => res.json())
            .then(data => {
                loading.style.display = 'none';
                if (!data.erro) {
                    document.getElementById('rua').value = data.logradouro || '';
                    document.getElementById('bairro').value = data.bairro || '';
                    document.getElementById('cidade').value = data.localidade || '';
                    // Selecionar estado
                    const estadoSelect = document.getElementById('estado');
                    for (let opt of estadoSelect.options) {
                        if (opt.value === data.uf) {
                            opt.selected = true;
                            break;
                        }
                    }
                    // Foca no campo número
                    document.getElementById('numero').focus();
                }
            })
            .catch(() => {
                loading.style.display = 'none';
            });
    }
</script>
@endsection
