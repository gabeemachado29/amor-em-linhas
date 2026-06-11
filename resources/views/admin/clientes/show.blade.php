@extends('layouts.admin')

@section('title', 'Detalhes do Cliente | Admin')

@section('content')
<div class="row py-4 justify-content-center">
    <div class="col-md-10">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="fw-bold mb-0" style="color: var(--primary-color);">Detalhes do Cliente</h3>
            <a href="{{ route('admin.clientes.index') }}" class="btn btn-outline-secondary" style="border-radius: 8px;">Voltar aos Clientes</a>
        </div>

        <div class="row g-4">
            {{-- Info do Cliente --}}
            <div class="col-md-4">
                <div class="card shadow-sm border-0 text-center">
                    <div class="card-body p-4">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center text-white fw-bold mx-auto mb-3" style="width: 72px; height: 72px; background: linear-gradient(135deg, var(--olive-400), var(--olive-600)); font-size: 1.6rem;">
                            {{ strtoupper(substr($cliente->name, 0, 1)) }}
                        </div>
                        <h5 class="fw-bold mb-1">{{ $cliente->name }}</h5>
                        <p class="text-muted mb-3" style="font-size: 0.88rem;">{{ $cliente->email }}</p>

                        <div class="text-start border-top pt-3 mt-2">
                            <p class="mb-2" style="font-size: 0.88rem;"><strong>📱 Telefone:</strong> {{ $cliente->telefone ?? 'Não informado' }}</p>
                            <p class="mb-2" style="font-size: 0.88rem;"><strong>🪪 CPF:</strong> {{ $cliente->cpf ?? 'Não informado' }}</p>
                            <p class="mb-0" style="font-size: 0.88rem;"><strong>📅 Cadastro:</strong> {{ $cliente->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pedidos do Cliente --}}
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                        <h5 class="fw-bold" style="color: var(--primary-color);">🛍️ Pedidos ({{ $pedidos->total() }})</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 mt-2">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Pedido #</th>
                                        <th>Data</th>
                                        <th>Valor</th>
                                        <th>Status</th>
                                        <th class="text-end pe-4">Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pedidos as $pedido)
                                        <tr>
                                            <td class="ps-4 fw-bold">#{{ str_pad($pedido->id, 5, '0', STR_PAD_LEFT) }}</td>
                                            <td style="font-size: 0.88rem;">{{ \Carbon\Carbon::parse($pedido->data_criacao)->format('d/m/Y H:i') }}</td>
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
                                                <a href="{{ route('admin.pedidos.show', $pedido->id) }}" class="btn btn-sm btn-outline-primary" style="font-size: 0.8rem; border-radius: 6px;">Ver</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted">Nenhum pedido encontrado.</td>
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
    </div>
</div>
@endsection
