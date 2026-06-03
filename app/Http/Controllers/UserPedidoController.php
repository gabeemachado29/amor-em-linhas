<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use Illuminate\Support\Facades\Auth;

class UserPedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::where('cliente_id', Auth::id())
                         ->orderBy('created_at', 'desc')
                         ->get();

        return view('pedidos.index', compact('pedidos'));
    }

    public function show($id)
    {
        $pedido = Pedido::with('itens.produto')
                        ->where('cliente_id', Auth::id())
                        ->findOrFail($id);

        return view('pedidos.show', compact('pedido'));
    }
}
