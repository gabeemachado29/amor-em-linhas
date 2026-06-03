@extends('layouts.store')

@section('title', 'Minhas Compras | Amor em Linhas')

@section('content')
<div class="row my-4 animate-fade-in-up">
    <div class="col-12">
        <h2 class="font-playfair mb-4" style="color: var(--primary); font-weight: 700;">🛍️ Minhas Compras</h2>
        
        <div class="card shadow-sm border-0" style="border-radius: var(--radius-lg);">
            <div class="card-body p-4">
                @if($pedidos->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead style="background-color: var(--olive-50);">
                                <tr>
                                    <th class="border-0 rounded-start" style="color: var(--olive-800);">Pedido #</th>
                                    <th class="border-0" style="color: var(--olive-800);">Data da Compra</th>
                                    <th class="border-0" style="color: var(--olive-800);">Status</th>
                                    <th class="border-0" style="color: var(--olive-800);">Total</th>
                                    <th class="border-0 rounded-end text-center" style="color: var(--olive-800);">Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pedidos as $pedido)
                                    <tr>
                                        <td class="fw-bold">#{{ str_pad($pedido->id, 5, '0', STR_PAD_LEFT) }}</td>
                                        <td>{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            @php
                                                $badgeClass = 'bg-secondary';
                                                if($pedido->status == 'PAGO') $badgeClass = 'bg-success';
                                                if($pedido->status == 'CANCELADO') $badgeClass = 'bg-danger';
                                                if($pedido->status == 'PENDENTE') $badgeClass = 'bg-warning text-dark';
                                            @endphp
                                            <span class="badge {{ $badgeClass }} px-2 py-1 rounded-pill">
                                                {{ str_replace('_', ' ', $pedido->status) }}
                                            </span>
                                        </td>
                                        <td class="text-success fw-bold">
                                            R$ {{ number_format($pedido->valor_total, 2, ',', '.') }}
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('pedidos.show', $pedido->id) }}" class="btn btn-sm btn-outline-primary" style="border-radius: 8px;">Ver Detalhes</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="mb-3" style="font-size: 3rem; color: var(--neutral-300);">🛍️</div>
                        <h5 class="text-muted mb-3">Você ainda não realizou nenhuma compra.</h5>
                        <p style="color: var(--text-secondary);">Que tal dar uma olhada nos nossos produtos exclusivos?</p>
                        <a href="{{ url('/') }}" class="btn btn-primary mt-2" style="background-color: var(--primary); border-color: var(--primary); border-radius: 8px;">Ir para a Loja</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
