<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pedido;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('tipo_perfil', '!=', 'ADMIN');

        // Busca por nome ou email
        if ($request->has('q') && $request->q) {
            $search = strip_tags(trim($request->q));
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('cpf', 'like', "%{$search}%");
            });
        }

        $clientes = $query->withCount('pedidos')
            ->latest()
            ->paginate(15);

        return view('admin.clientes.index', compact('clientes'));
    }

    public function show($id)
    {
        $cliente = User::where('tipo_perfil', '!=', 'ADMIN')->findOrFail($id);
        $pedidos = Pedido::where('cliente_id', $id)
            ->latest('data_criacao')
            ->paginate(10);

        return view('admin.clientes.show', compact('cliente', 'pedidos'));
    }
}
