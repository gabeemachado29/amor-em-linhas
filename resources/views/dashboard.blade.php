@extends('layouts.admin')

@section('title', 'Painel de Controle | Amor em Linhas')

@section('styles')
<style>
    .stat-card {
        background: var(--bg-card, #fff);
        border-radius: 16px;
        padding: 24px;
        border: 1px solid rgba(0,0,0,0.06);
        box-shadow: 0 1px 3px rgba(0,0,0,0.06);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        border-radius: 16px 16px 0 0;
    }
    .stat-card.card-vendas::before { background: linear-gradient(90deg, #16a34a, #22c55e); }
    .stat-card.card-pendentes::before { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
    .stat-card.card-produtos::before { background: linear-gradient(90deg, #2563eb, #3b82f6); }
    .stat-card.card-faturamento::before { background: linear-gradient(90deg, #7c3aed, #a855f7); }
    .stat-card.card-clientes::before { background: linear-gradient(90deg, #ec4899, #f472b6); }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
    }
    .stat-icon.icon-vendas { background: rgba(22, 163, 74, 0.1); }
    .stat-icon.icon-pendentes { background: rgba(245, 158, 11, 0.1); }
    .stat-icon.icon-produtos { background: rgba(37, 99, 235, 0.1); }
    .stat-icon.icon-faturamento { background: rgba(124, 58, 237, 0.1); }
    .stat-icon.icon-clientes { background: rgba(236, 72, 153, 0.1); }

    .stat-value {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--text-primary, #1a1a1a);
        line-height: 1.1;
        margin-top: 16px;
    }
    .stat-label {
        font-size: 0.82rem;
        color: var(--text-secondary, #737373);
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 4px;
    }

    /* Gráfico CSS */
    .chart-container {
        background: var(--bg-card, #fff);
        border-radius: 16px;
        padding: 24px;
        border: 1px solid rgba(0,0,0,0.06);
        box-shadow: 0 1px 3px rgba(0,0,0,0.06);
    }
    .chart-title {
        font-weight: 600;
        font-size: 1rem;
        color: var(--text-primary, #1a1a1a);
        margin-bottom: 20px;
    }
    .chart-bars {
        display: flex;
        align-items: flex-end;
        gap: 8px;
        height: 160px;
        padding-bottom: 32px;
        position: relative;
    }
    .chart-bar-group {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        height: 100%;
        justify-content: flex-end;
    }
    .chart-bar {
        width: 100%;
        max-width: 48px;
        background: linear-gradient(180deg, var(--olive-400), var(--olive-600));
        border-radius: 6px 6px 0 0;
        min-height: 4px;
        transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }
    .chart-bar:hover {
        filter: brightness(1.1);
    }
    .chart-bar-value {
        position: absolute;
        top: -22px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 0.7rem;
        font-weight: 600;
        color: var(--text-secondary, #737373);
        white-space: nowrap;
    }
    .chart-bar-label {
        margin-top: 8px;
        font-size: 0.72rem;
        color: var(--text-secondary, #737373);
        font-weight: 500;
        text-align: center;
    }

    /* Tabela recentes */
    .recent-table {
        background: var(--bg-card, #fff);
        border-radius: 16px;
        border: 1px solid rgba(0,0,0,0.06);
        box-shadow: 0 1px 3px rgba(0,0,0,0.06);
        overflow: hidden;
    }
    .recent-table-header {
        padding: 20px 24px;
        border-bottom: 1px solid rgba(0,0,0,0.06);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .recent-table-header h6 {
        font-weight: 600;
        font-size: 1rem;
        color: var(--text-primary, #1a1a1a);
        margin: 0;
    }
</style>
@endsection

@section('content')
<div class="py-4">
    {{-- Saudação --}}
    <div class="mb-4">
        <h4 class="fw-bold mb-1" style="color: var(--primary-color); font-family: 'Playfair Display', serif;">
            Bem-vindo, {{ Auth::user()->name }}! 👋
        </h4>
        <p class="text-muted mb-0" style="font-size: 0.92rem;">Aqui está o resumo da sua loja hoje.</p>
    </div>

    {{-- Cards de Estatísticas --}}
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl">
            <div class="stat-card card-vendas">
                <div class="stat-icon icon-vendas">📈</div>
                <div class="stat-value">{{ $vendasHoje }}</div>
                <div class="stat-label">Vendas Hoje</div>
            </div>
        </div>
        <div class="col-sm-6 col-xl">
            <div class="stat-card card-pendentes">
                <div class="stat-icon icon-pendentes">⏳</div>
                <div class="stat-value">{{ $pedidosPendentes }}</div>
                <div class="stat-label">Pendentes</div>
            </div>
        </div>
        <div class="col-sm-6 col-xl">
            <div class="stat-card card-produtos">
                <div class="stat-icon icon-produtos">📦</div>
                <div class="stat-value">{{ $totalProdutos }}</div>
                <div class="stat-label">Produtos</div>
            </div>
        </div>
        <div class="col-sm-6 col-xl">
            <div class="stat-card card-faturamento">
                <div class="stat-icon icon-faturamento">💰</div>
                <div class="stat-value" style="font-size: 1.4rem;">R$ {{ number_format($faturamentoMes, 2, ',', '.') }}</div>
                <div class="stat-label">Faturamento Mês</div>
            </div>
        </div>
        <div class="col-sm-6 col-xl">
            <div class="stat-card card-clientes">
                <div class="stat-icon icon-clientes">👥</div>
                <div class="stat-value">{{ $totalClientes }}</div>
                <div class="stat-label">Clientes</div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Gráfico de Vendas --}}
        <div class="col-lg-5">
            <div class="chart-container h-100">
                <div class="chart-title">💹 Vendas — Últimos 7 dias</div>
                @php
                    $maxVenda = max(array_column($vendasPorDia, 'total'));
                    $maxVenda = $maxVenda > 0 ? $maxVenda : 1;
                @endphp
                <div class="chart-bars">
                    @foreach($vendasPorDia as $dia)
                        @php
                            $percentual = ($dia['total'] / $maxVenda) * 100;
                            $percentual = max($percentual, 3); // mínimo visual
                        @endphp
                        <div class="chart-bar-group">
                            <div class="chart-bar" style="height: {{ $percentual }}%;">
                                @if($dia['total'] > 0)
                                    <span class="chart-bar-value">R$ {{ number_format($dia['total'], 0, ',', '.') }}</span>
                                @endif
                            </div>
                            <span class="chart-bar-label">{{ $dia['dia'] }}<br>{{ $dia['dia_semana'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Últimos Pedidos --}}
        <div class="col-lg-7">
            <div class="recent-table h-100">
                <div class="recent-table-header">
                    <h6>🛍️ Últimos Pedidos</h6>
                    <a href="{{ route('admin.pedidos.index') }}" class="btn btn-sm btn-outline-primary" style="border-radius: 8px; font-size: 0.8rem;">Ver todos</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4" style="font-size: 0.82rem;">Pedido</th>
                                <th style="font-size: 0.82rem;">Cliente</th>
                                <th style="font-size: 0.82rem;">Valor</th>
                                <th style="font-size: 0.82rem;">Status</th>
                                <th class="text-end pe-4" style="font-size: 0.82rem;">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ultimosPedidos as $pedido)
                                <tr>
                                    <td class="ps-4 fw-bold" style="font-size: 0.88rem;">#{{ str_pad($pedido->id, 5, '0', STR_PAD_LEFT) }}</td>
                                    <td style="font-size: 0.88rem;">{{ Str::words($pedido->cliente->name ?? 'Removido', 2, '') }}</td>
                                    <td class="fw-medium" style="font-size: 0.88rem;">R$ {{ number_format($pedido->valor_total, 2, ',', '.') }}</td>
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
                                        <span class="badge {{ $badgeClass }}" style="font-size: 0.72rem;">{{ $pedido->status }}</span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('admin.pedidos.show', $pedido->id) }}" class="btn btn-sm btn-outline-secondary" style="font-size: 0.78rem; border-radius: 6px;">Ver</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted" style="font-size: 0.88rem;">Nenhum pedido ainda.</td>
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
