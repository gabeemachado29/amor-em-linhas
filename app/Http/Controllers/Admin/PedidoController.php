<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::with('cliente')->latest('data_criacao')->paginate(15);
        return view('admin.pedidos.index', compact('pedidos'));
    }

    public function show($id)
    {
        $pedido = Pedido::with(['cliente', 'itens.produto'])->findOrFail($id);
        return view('admin.pedidos.show', compact('pedido'));
    }

    public function update(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|string|in:PENDENTE,PAGO,ENVIADO,ENTREGUE,CANCELADO'
        ]);

        $pedido->status = $validated['status'];
        $pedido->save();

        return redirect()->route('admin.pedidos.show', $pedido->id)->with('success', 'Status do pedido atualizado com sucesso!');
    }
}
