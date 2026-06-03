@extends('layouts.admin')

@section('title', 'Novo Produto | Admin')

@section('content')
<div class="row py-4 justify-content-center">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="fw-bold" style="color: var(--primary-color);">Novo Produto</h3>
            <a href="{{ route('admin.produtos.index') }}" class="btn btn-outline-secondary">Voltar</a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="{{ route('admin.produtos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="nome" class="form-label fw-bold">Nome do Produto *</label>
                        <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ old('nome') }}" required>
                        @error('nome')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="descricao" class="form-label fw-bold">Descrição</label>
                        <textarea class="form-control @error('descricao') is-invalid @enderror" id="descricao" name="descricao" rows="4">{{ old('descricao') }}</textarea>
                        @error('descricao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="preco" class="form-label fw-bold">Preço (R$) *</label>
                            <input type="number" step="0.01" class="form-control @error('preco') is-invalid @enderror" id="preco" name="preco" value="{{ old('preco') }}" required>
                            @error('preco')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="estoque_atual" class="form-label fw-bold">Estoque Inicial *</label>
                            <input type="number" class="form-control @error('estoque_atual') is-invalid @enderror" id="estoque_atual" name="estoque_atual" value="{{ old('estoque_atual', 0) }}" required>
                            @error('estoque_atual')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="imagem" class="form-label fw-bold">Imagem Principal</label>
                        <input type="file" class="form-control @error('imagem') is-invalid @enderror" id="imagem" name="imagem" accept="image/*">
                        @error('imagem')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-4" style="background-color: var(--primary-color); border-color: var(--primary-color);">Salvar Produto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
