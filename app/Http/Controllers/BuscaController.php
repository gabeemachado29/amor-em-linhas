<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;

class BuscaController extends Controller
{
    /**
     * Realiza busca de produtos por nome ou descrição.
     * Input é sanitizado para prevenir injeção.
     */
    public function index(Request $request)
    {
        $query = strip_tags(trim($request->input('q', '')));

        if (empty($query)) {
            return redirect()->route('home');
        }

        $produtos = Produto::where('nome', 'LIKE', '%' . $query . '%')
            ->orWhere('descricao', 'LIKE', '%' . $query . '%')
            ->paginate(12)
            ->appends(['q' => $query]);

        return view('busca', compact('produtos', 'query'));
    }
}
