@extends('layouts.admin')

@section('title', 'Novo Banner | Admin')

@section('content')
<div class="row py-4 justify-content-center">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="fw-bold" style="color: var(--primary-color);">Novo Banner</h3>
            <a href="{{ route('admin.banners.index') }}" class="btn btn-outline-secondary">Voltar</a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="titulo" class="form-label fw-bold">Título (Opcional)</label>
                        <input type="text" class="form-control @error('titulo') is-invalid @enderror" id="titulo" name="titulo" value="{{ old('titulo') }}">
                        @error('titulo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="imagem" class="form-label fw-bold">Imagem do Banner *</label>
                        <input type="file" class="form-control @error('imagem') is-invalid @enderror" id="imagem" name="imagem" accept="image/*" required>
                        <small class="text-muted">Use imagens largas (ex: 1920x600px) para melhor visualização no carrossel.</small>
                        @error('imagem')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-4" style="background-color: var(--primary-color); border-color: var(--primary-color);">Adicionar Banner</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
