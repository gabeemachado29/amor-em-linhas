@extends('layouts.admin')

@section('title', 'Detalhes do Pedido | Admin')

@section('content')
<div class="row py-4 justify-content-center">
    <div class="col-md-10">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="fw-bold" style="color: var(--primary-color);">Pedido #{{ str_pad($pedido->id, 5, '0', STR_PAD_LEFT) }}</h3>
            <a href="{{ route('admin.pedidos.index') }}" class="btn btn-outline-secondary">Voltar aos Pedidos</a>
        </div>

        <div class="row g-4">
            <!-- Detalhes do Cliente e Status -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                        <h5 class="fw-bold" style="color: var(--primary-color);">Dados do Cliente</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-1"><strong>Nome:</strong> {{ $pedido->cliente->name ?? 'Usuário Deletado' }}</p>
                        <p class="mb-1"><strong>Email:</strong> {{ $pedido->cliente->email ?? 'N/A' }}</p>
                        <p class="mb-0"><strong>Data:</strong> {{ \Carbon\Carbon::parse($pedido->data_criacao)->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                        <h5 class="fw-bold" style="color: var(--primary-color);">Atualizar Status</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.pedidos.update', $pedido->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="mb-3">
                                <label for="status" class="form-label">Status Atual:</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="PENDENTE" {{ $pedido->status == 'PENDENTE' ? 'selected' : '' }}>Pendente</option>
                                    <option value="PAGO" {{ $pedido->status == 'PAGO' ? 'selected' : '' }}>Pago</option>
                                    <option value="ENVIADO" {{ $pedido->status == 'ENVIADO' ? 'selected' : '' }}>Enviado</option>
                                    <option value="ENTREGUE" {{ $pedido->status == 'ENTREGUE' ? 'selected' : '' }}>Entregue</option>
                                    <option value="CANCELADO" {{ $pedido->status == 'CANCELADO' ? 'selected' : '' }}>Cancelado</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100" style="background-color: var(--primary-color); border-color: var(--primary-color);">Atualizar Pedido</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Itens do Pedido -->
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                        <h5 class="fw-bold" style="color: var(--primary-color);">Itens Comprados</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 mt-3">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Produto</th>
                                        <th>Qtd</th>
                                        <th>Preço Unit.</th>
                                        <th class="text-end pe-4">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pedido->itens as $item)
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center gap-3">
                                                    @if($item->produto && $item->produto->imagem_principal_url)
                                                        <img src="{{ asset($item->produto->imagem_principal_url) }}" alt="img" class="rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted" style="width: 40px; height: 40px;">
                                                            <small>S/ Img</small>
                                                        </div>
                                                    @endif
                                                    <span class="fw-medium">{{ $item->produto->nome ?? 'Produto Removido' }}</span>
                                                </div>
                                            </td>
                                            <td>{{ $item->quantidade }}x</td>
                                            <td>R$ {{ number_format($item->preco_unitario, 2, ',', '.') }}</td>
                                            <td class="text-end pe-4 fw-medium">R$ {{ number_format($item->quantidade * $item->preco_unitario, 2, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end text-muted pt-3">Frete:</td>
                                        <td class="text-end pe-4 pt-3">R$ {{ number_format($pedido->valor_frete, 2, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold fs-5 border-0">Total:</td>
                                        <td class="text-end pe-4 fw-bold fs-5 text-success border-0">R$ {{ number_format($pedido->valor_total, 2, ',', '.') }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
