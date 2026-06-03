@extends('layouts.admin')

@section('title', 'Banners (Carrossel) | Admin')

@section('content')
<div class="row py-4">
    <div class="col-12 mb-3 d-flex justify-content-between align-items-center">
        <h3 class="fw-bold" style="color: var(--primary-color);">Banners do Carrossel</h3>
        <a href="{{ route('admin.banners.create') }}" class="btn btn-primary" style="background-color: var(--primary-color); border-color: var(--primary-color);">+ Novo Banner</a>
    </div>

    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Imagem</th>
                                <th>Título</th>
                                <th>Data de Adição</th>
                                <th class="text-end pe-4">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($banners as $banner)
                                <tr>
                                    <td class="ps-4">
                                        <img src="{{ asset($banner->imagem_url) }}" alt="Banner" class="rounded" style="width: 120px; height: 60px; object-fit: cover;">
                                    </td>
                                    <td class="fw-medium">{{ $banner->titulo ?: 'Sem Título' }}</td>
                                    <td>{{ $banner->created_at ? $banner->created_at->format('d/m/Y') : 'N/A' }}</td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('admin.banners.edit', $banner->id) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                                        <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Excluir este banner?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Excluir</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Nenhum banner cadastrado.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
