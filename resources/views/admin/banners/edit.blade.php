@extends('layouts.admin')

@section('title', 'Editar Banner | Admin')

@section('content')
<div class="row py-4 justify-content-center">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="fw-bold" style="color: var(--primary-color);">Editar Banner</h3>
            <a href="{{ route('admin.banners.index') }}" class="btn btn-outline-secondary">Voltar</a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="titulo" class="form-label fw-bold">Título (Opcional)</label>
                        <input type="text" class="form-control @error('titulo') is-invalid @enderror" id="titulo" name="titulo" value="{{ old('titulo', $banner->titulo) }}">
                        @error('titulo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="imagem" class="form-label fw-bold">Nova Imagem (Opcional)</label>
                        @if($banner->imagem_url)
                            <div class="mb-2">
                                <img src="{{ asset($banner->imagem_url) }}" alt="Banner Atual" class="img-thumbnail" style="max-height: 150px;">
                            </div>
                        @endif
                        <input type="file" class="form-control @error('imagem') is-invalid @enderror" id="imagem" name="imagem" accept="image/*">
                        <small class="text-muted">Deixe em branco para manter a imagem atual.</small>
                        @error('imagem')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-4" style="background-color: var(--primary-color); border-color: var(--primary-color);">Atualizar Banner</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
