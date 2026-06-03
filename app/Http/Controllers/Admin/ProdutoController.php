<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::latest()->paginate(10);
        return view('admin.produtos.index', compact('produtos'));
    }

    public function create()
    {
        return view('admin.produtos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
            'estoque_atual' => 'required|integer|min:0',
            'imagem' => 'nullable|image|max:2048'
        ]);

        $produto = new Produto();
        $produto->nome = $validated['nome'];
        $produto->descricao = $validated['descricao'] ?? null;
        $produto->preco = $validated['preco'];
        $produto->estoque_atual = $validated['estoque_atual'];

        if ($request->hasFile('imagem')) {
            $path = $request->file('imagem')->store('produtos', 'public');
            $produto->imagem_principal_url = '/storage/' . $path;
        }

        $produto->save();

        return redirect()->route('admin.produtos.index')->with('success', 'Produto criado com sucesso!');
    }

    public function edit(Produto $produto)
    {
        return view('admin.produtos.edit', compact('produto'));
    }

    public function update(Request $request, Produto $produto)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
            'estoque_atual' => 'required|integer|min:0',
            'imagem' => 'nullable|image|max:2048'
        ]);

        $produto->nome = $validated['nome'];
        $produto->descricao = $validated['descricao'] ?? null;
        $produto->preco = $validated['preco'];
        $produto->estoque_atual = $validated['estoque_atual'];

        if ($request->hasFile('imagem')) {
            // Delete old image if exists
            if ($produto->imagem_principal_url) {
                $oldPath = str_replace('/storage/', '', $produto->imagem_principal_url);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('imagem')->store('produtos', 'public');
            $produto->imagem_principal_url = '/storage/' . $path;
        }

        $produto->save();

        return redirect()->route('admin.produtos.index')->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy(Produto $produto)
    {
        if ($produto->imagem_principal_url) {
            $oldPath = str_replace('/storage/', '', $produto->imagem_principal_url);
            Storage::disk('public')->delete($oldPath);
        }

        $produto->delete();

        return redirect()->route('admin.produtos.index')->with('success', 'Produto excluído com sucesso!');
    }
}
