@extends('layouts.admin')

@section('title', 'Clientes | Admin')

@section('content')
<div class="row py-4">
    <div class="col-12 mb-3">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <h3 class="fw-bold mb-0" style="color: var(--primary-color);">👥 Clientes</h3>

            {{-- Busca --}}
            <form action="{{ route('admin.clientes.index') }}" method="GET" class="d-flex gap-2" style="max-width: 360px; width: 100%;">
                <input type="text" name="q" class="form-control form-control-sm" placeholder="Buscar por nome, email ou CPF..." value="{{ request('q') }}" style="border-radius: 8px; font-size: 0.88rem;">
                <button type="submit" class="btn btn-sm btn-primary px-3" style="background-color: var(--primary-color); border-color: var(--primary-color); border-radius: 8px; white-space: nowrap;">Buscar</button>
            </form>
        </div>
    </div>

    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Nome</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th>CPF</th>
                                <th class="text-center">Pedidos</th>
                                <th>Cadastro</th>
                                <th class="text-end pe-4">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($clientes as $cliente)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" style="width: 36px; height: 36px; background: linear-gradient(135deg, var(--olive-400), var(--olive-600)); font-size: 0.82rem; flex-shrink: 0;">
                                                {{ strtoupper(substr($cliente->name, 0, 1)) }}
                                            </div>
                                            <span class="fw-medium" style="font-size: 0.9rem;">{{ $cliente->name }}</span>
                                        </div>
                                    </td>
                                    <td style="font-size: 0.88rem;">{{ $cliente->email }}</td>
                                    <td style="font-size: 0.88rem;">{{ $cliente->telefone ?? '—' }}</td>
                                    <td style="font-size: 0.88rem; font-family: monospace;">{{ $cliente->cpf ?? '—' }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border" style="font-size: 0.82rem;">{{ $cliente->pedidos_count }}</span>
                                    </td>
                                    <td style="font-size: 0.82rem; color: var(--text-secondary);">{{ $cliente->created_at->format('d/m/Y') }}</td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('admin.clientes.show', $cliente->id) }}" class="btn btn-sm btn-outline-primary" style="border-radius: 6px; font-size: 0.8rem;">Ver</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">Nenhum cliente encontrado.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($clientes->hasPages())
                <div class="card-footer bg-white border-top-0 pt-3 pb-2">
                    {{ $clientes->appends(['q' => request('q')])->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
