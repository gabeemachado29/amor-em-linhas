@extends('layouts.admin')

@section('title', 'Configurações da Loja | Admin')

@section('content')
<div class="row py-4 justify-content-center">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="fw-bold" style="color: var(--primary-color);">Configurações Gerais</h3>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Voltar ao Painel</a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="{{ route('admin.configuracoes.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="nome_loja" class="form-label fw-bold">Nome da Loja</label>
                        <input type="text" class="form-control @error('nome_loja') is-invalid @enderror" id="nome_loja" name="nome_loja" value="{{ old('nome_loja', $config->nome_loja) }}" placeholder="Ex: Amor em Linhas">
                        <small class="text-muted">Como a loja será chamada em algumas partes do site.</small>
                        @error('nome_loja')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="chave_pix" class="form-label fw-bold">Chave PIX (Recebimento)</label>
                        <input type="text" class="form-control @error('chave_pix') is-invalid @enderror" id="chave_pix" name="chave_pix" value="{{ old('chave_pix', $config->chave_pix) }}" placeholder="Sua chave PIX">
                        <small class="text-muted">A chave que será exibida para os clientes efetuarem o pagamento.</small>
                        @error('chave_pix')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="valor_frete_fixo" class="form-label fw-bold">Taxa de Entrega Fixa (R$)</label>
                        <input type="number" step="0.01" class="form-control @error('valor_frete_fixo') is-invalid @enderror" id="valor_frete_fixo" name="valor_frete_fixo" value="{{ old('valor_frete_fixo', $config->valor_frete_fixo ?? 10.00) }}">
                        <small class="text-muted">Valor cobrado pela entrega em todos os pedidos.</small>
                        @error('valor_frete_fixo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-4" style="background-color: var(--primary-color); border-color: var(--primary-color);">Salvar Configurações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
