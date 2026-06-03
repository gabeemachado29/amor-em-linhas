@extends('layouts.admin')

@section('title', 'Painel de Controle | Amor em Linhas')

@section('content')
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
        <h4 class="mb-0 fw-bold" style="color: var(--primary-color); font-family: var(--font-heading);">
            Bem-vindo, {{ Auth::user()->name }}!
        </h4>
    </div>
    <div class="card-body py-4">
        <p style="color: var(--text-color);">
            Aqui você pode gerenciar sua loja, visualizar pedidos e atualizar seus dados.
        </p>

        <div class="row g-3 mt-2">
            <!-- Card de Estatísticas -->
            <div class="col-sm-4">
                <div class="p-3 bg-light rounded border text-center">
                    <h3 class="fw-bold mb-0 text-success">0</h3>
                    <span class="text-muted small">Vendas Hoje</span>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="p-3 bg-light rounded border text-center">
                    <h3 class="fw-bold mb-0 text-primary">0</h3>
                    <span class="text-muted small">Pedidos Pendentes</span>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="p-3 bg-light rounded border text-center">
                    <h3 class="fw-bold mb-0 text-warning">0</h3>
                    <span class="text-muted small">Total de Produtos</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
