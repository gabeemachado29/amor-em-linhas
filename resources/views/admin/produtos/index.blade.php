@extends('layouts.admin')

@section('title', 'Produtos | Admin')

@section('content')
<div class="row py-4">
    <div class="col-12 mb-3 d-flex justify-content-between align-items-center">
        <h3 class="fw-bold" style="color: var(--primary-color);">Gerenciar Produtos</h3>
        <a href="{{ route('admin.produtos.create') }}" class="btn btn-primary" style="background-color: var(--primary-color); border-color: var(--primary-color);">+ Novo Produto</a>
    </div>

    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Imagem</th>
                                <th>Nome</th>
                                <th>Preço</th>
                                <th>Estoque</th>
                                <th class="text-end pe-4">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($produtos as $produto)
                                <tr>
                                    <td class="ps-4">
                                        @if($produto->imagem_principal_url)
                                            <img src="{{ asset($produto->imagem_principal_url) }}" alt="{{ $produto->nome }}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted" style="width: 50px; height: 50px;">
                                                <small>S/ Img</small>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="fw-medium">{{ $produto->nome }}</td>
                                    <td>R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
                                    <td>
                                        <span class="badge {{ $produto->estoque_atual > 0 ? 'bg-success' : 'bg-danger' }}">
                                            {{ $produto->estoque_atual }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('admin.produtos.edit', $produto->id) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                                        <form action="{{ route('admin.produtos.destroy', $produto->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este produto?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Excluir</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Nenhum produto cadastrado.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($produtos->hasPages())
                <div class="card-footer bg-white border-top-0 pt-3 pb-2">
                    {{ $produtos->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
