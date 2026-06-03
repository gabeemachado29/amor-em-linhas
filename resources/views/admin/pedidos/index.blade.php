@extends('layouts.admin')

@section('title', 'Pedidos | Admin')

@section('content')
<div class="row py-4">
    <div class="col-12 mb-3">
        <h3 class="fw-bold" style="color: var(--primary-color);">Gerenciar Pedidos</h3>
    </div>

    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Pedido #</th>
                                <th>Data</th>
                                <th>Cliente</th>
                                <th>Valor Total</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pedidos as $pedido)
                                <tr>
                                    <td class="ps-4 fw-bold">#{{ str_pad($pedido->id, 5, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($pedido->data_criacao)->format('d/m/Y H:i') }}</td>
                                    <td>{{ $pedido->cliente->name ?? 'Usuário Deletado' }}</td>
                                    <td class="fw-medium">R$ {{ number_format($pedido->valor_total, 2, ',', '.') }}</td>
                                    <td>
                                        @php
                                            $badgeClass = match($pedido->status) {
                                                'PENDENTE' => 'bg-warning text-dark',
                                                'PAGO' => 'bg-info text-dark',
                                                'ENVIADO' => 'bg-primary',
                                                'ENTREGUE' => 'bg-success',
                                                'CANCELADO' => 'bg-danger',
                                                default => 'bg-secondary'
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ $pedido->status }}</span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('admin.pedidos.show', $pedido->id) }}" class="btn btn-sm btn-outline-primary">Ver Detalhes</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">Nenhum pedido encontrado.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($pedidos->hasPages())
                <div class="card-footer bg-white border-top-0 pt-3 pb-2">
                    {{ $pedidos->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
