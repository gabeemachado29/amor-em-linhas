@extends('layouts.store')

@section('title', 'Pedido Confirmado | Amor em Linhas')

@section('content')
<div class="row justify-content-center my-5 animate-fade-in-up">
    <div class="col-md-8 col-lg-6 text-center">
        
        <div class="mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="var(--success)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-3">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
            <h1 class="font-playfair" style="color: var(--primary); font-weight: 700;">Pedido Realizado!</h1>
            <p style="color: var(--text-secondary); font-size: 1.1rem;">
                Obrigado pela sua compra. Seu pedido <strong>#{{ str_pad($pedido->id, 5, '0', STR_PAD_LEFT) }}</strong> está pendente de pagamento.
            </p>
        </div>

        <div class="card border-0 shadow-sm mb-4" style="border-radius: var(--radius-lg);">
            <div class="card-body p-4 text-center">
                <h5 class="fw-bold mb-3" style="color: var(--text-primary);">Pague com PIX</h5>
                <p style="color: var(--text-secondary); font-size: 0.95rem; margin-bottom: 20px;">
                    Utilize a chave PIX abaixo para transferir o valor total de <strong>R$ {{ number_format($pedido->valor_total, 2, ',', '.') }}</strong>.
                </p>

                <div class="p-3 bg-light rounded border mb-3">
                    <span id="pixKey" style="font-family: monospace; font-size: 1.1rem; word-break: break-all; color: var(--text-primary); font-weight: 600;">
                        {{ $pedido->chave_pix_copia_cola ?? 'Chave PIX não configurada' }}
                    </span>
                </div>

                <button onclick="copiarPix()" class="btn btn-outline-primary w-100" style="border-color: var(--primary); color: var(--primary); font-weight: 600; border-radius: 8px;">
                    📋 Copiar Chave PIX
                </button>
            </div>
        </div>

        <div class="d-flex gap-3 justify-content-center">
            <a href="{{ url('/') }}" class="btn btn-light" style="font-weight: 600; border-radius: 8px;">Voltar à Loja</a>
            <a href="{{ url('/profile') }}" class="btn btn-primary" style="background-color: var(--primary); border-color: var(--primary); font-weight: 600; border-radius: 8px;">Meus Pedidos</a>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    // Limpar o carrinho agora que o pedido foi gerado
    localStorage.removeItem('carrinho');

    // Atualizar badge instantaneamente para não mostrar itens fantasmas
    const badge = document.getElementById('cartBadge');
    if (badge) {
        badge.innerText = '';
        badge.style.display = 'none';
        badge.setAttribute('data-count', '0');
    }

    function copiarPix() {
        const pixKey = document.getElementById('pixKey').innerText;
        navigator.clipboard.writeText(pixKey).then(() => {
            alert('Chave PIX copiada para a área de transferência!');
        }).catch(err => {
            console.error('Falha ao copiar: ', err);
        });
    }
</script>
@endsection
