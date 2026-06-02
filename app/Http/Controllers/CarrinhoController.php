<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;

class CarrinhoController extends Controller
{
    public function index()
    {
        // Precisamos buscar todos para o Javascript conseguir montar a interface do carrinho
        $todosProdutos = Produto::select('id', 'nome', 'preco', 'imagem_principal_url')->get();
        return view('carrinho', compact('todosProdutos'));
    }
}
