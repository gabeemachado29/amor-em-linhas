@extends('layouts.store')

@section('title', 'Detalhes do Pedido | Amor em Linhas')

@section('content')
<div class="row my-4 animate-fade-in-up">
    <div class="col-lg-8 mx-auto">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="font-playfair m-0" style="color: var(--primary); font-weight: 700;">Detalhes do Pedido #{{ str_pad($pedido->id, 5, '0', STR_PAD_LEFT) }}</h2>
            <a href="{{ route('pedidos.index') }}" class="btn btn-outline-secondary btn-sm" style="border-radius: 8px;">&larr; Voltar</a>
        </div>

        @if($pedido->status === 'PENDENTE')
        <div class="card shadow-sm border-0 mb-4 bg-light" style="border-radius: var(--radius-lg); border-left: 4px solid var(--warning) !important;">
            <div class="card-body p-4 text-center">
                <h5 class="fw-bold mb-3" style="color: var(--text-primary);">Aguardando Pagamento</h5>
                <p style="color: var(--text-secondary); font-size: 0.95rem;">
                    Para confirmar seu pedido, realize o pagamento via PIX no valor de <strong>R$ {{ number_format($pedido->valor_total, 2, ',', '.') }}</strong> utilizando a chave abaixo:
                </p>

                <div class="p-3 bg-white rounded border mb-3 mx-auto" style="max-width: 400px;">
                    <span id="pixKey" style="font-family: monospace; font-size: 1rem; word-break: break-all; color: var(--text-primary); font-weight: 600;">
                        {{ $pedido->chave_pix_copia_cola ?? 'Chave PIX não configurada' }}
                    </span>
                </div>

                <button onclick="copiarPix()" class="btn btn-primary" style="background-color: var(--primary); border-color: var(--primary); font-weight: 600; border-radius: 8px;">
                    📋 Copiar Chave PIX
                </button>
            </div>
        </div>
        @endif

        <div class="card shadow-sm border-0 mb-4" style="border-radius: var(--radius-lg);">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4" style="color: var(--primary); border-bottom: 1px solid var(--border-color); padding-bottom: 10px;">Resumo da Compra</h5>
                
                <div class="table-responsive">
                    <table class="table align-middle border-0">
                        <tbody>
                            @foreach($pedido->itens as $item)
                                <tr>
                                    <td style="width: 80px;">
                                        @if($item->produto)
                                            <img src="{{ asset($item->produto->imagem_principal_url) }}" alt="{{ $item->produto->nome }}" class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                        @else
                                            <div class="bg-secondary rounded" style="width: 60px; height: 60px;"></div>
                                        @endif
                                    </td>
                                    <td>
                                        <h6 class="mb-0" style="color: var(--text-primary);">{{ $item->produto ? $item->produto->nome : 'Produto Removido' }}</h6>
                                        <small style="color: var(--text-secondary);">Qtd: {{ $item->quantidade }}</small>
                                    </td>
                                    <td class="text-end fw-bold" style="color: var(--text-primary);">
                                        R$ {{ number_format($item->preco_unitario * $item->quantidade, 2, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between mt-3 pt-3" style="border-top: 1px solid var(--border-color);">
                    <span style="color: var(--text-secondary);">Subtotal Itens</span>
                    <span style="font-weight: 500;">R$ {{ number_format($pedido->valor_total - $pedido->valor_frete, 2, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <span style="color: var(--text-secondary);">Entrega Fixa</span>
                    <span style="font-weight: 500;">R$ {{ number_format($pedido->valor_frete, 2, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between mt-3 pt-3" style="border-top: 1px dashed var(--border-color);">
                    <span style="font-weight: 700; font-size: 1.1rem; color: var(--text-primary);">Total do Pedido</span>
                    <span style="font-weight: 700; font-size: 1.2rem; color: var(--primary);">R$ {{ number_format($pedido->valor_total, 2, ',', '.') }}</span>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
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
