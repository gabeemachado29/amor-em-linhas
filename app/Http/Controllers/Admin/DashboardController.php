<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use App\Models\Produto;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $hoje = Carbon::today();
        $inicioMes = Carbon::now()->startOfMonth();

        // Vendas do dia (pedidos pagos/entregues/enviados hoje)
        $vendasHoje = Pedido::whereDate('data_criacao', $hoje)
            ->whereIn('status', ['PAGO', 'ENVIADO', 'ENTREGUE'])
            ->count();

        // Pedidos pendentes
        $pedidosPendentes = Pedido::where('status', 'PENDENTE')->count();

        // Total de produtos
        $totalProdutos = Produto::count();

        // Faturamento do mês
        $faturamentoMes = Pedido::where('data_criacao', '>=', $inicioMes)
            ->whereIn('status', ['PAGO', 'ENVIADO', 'ENTREGUE'])
            ->sum('valor_total');

        // Total de clientes
        $totalClientes = User::where('tipo_perfil', '!=', 'ADMIN')->count();

        // Últimos 5 pedidos
        $ultimosPedidos = Pedido::with('cliente')
            ->latest('data_criacao')
            ->take(5)
            ->get();

        // Dados para gráfico dos últimos 7 dias
        $vendasPorDia = [];
        for ($i = 6; $i >= 0; $i--) {
            $dia = Carbon::today()->subDays($i);
            $total = Pedido::whereDate('data_criacao', $dia)
                ->whereIn('status', ['PAGO', 'ENVIADO', 'ENTREGUE'])
                ->sum('valor_total');
            $vendasPorDia[] = [
                'dia' => $dia->format('d/m'),
                'dia_semana' => $dia->locale('pt_BR')->isoFormat('ddd'),
                'total' => round($total, 2),
            ];
        }

        return view('dashboard', compact(
            'vendasHoje',
            'pedidosPendentes',
            'totalProdutos',
            'faturamentoMes',
            'totalClientes',
            'ultimosPedidos',
            'vendasPorDia'
        ));
    }
}
