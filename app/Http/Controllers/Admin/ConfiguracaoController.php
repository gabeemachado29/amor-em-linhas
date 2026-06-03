<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConfiguracaoLoja;
use Illuminate\Http\Request;

class ConfiguracaoController extends Controller
{
    public function edit()
    {
        $config = ConfiguracaoLoja::first() ?? new ConfiguracaoLoja();
        return view('admin.configuracoes.edit', compact('config'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nome_loja' => 'nullable|string|max:255',
            'chave_pix' => 'nullable|string|max:255',
            'valor_frete_fixo' => 'nullable|numeric|min:0'
        ]);

        $config = ConfiguracaoLoja::first();
        if (!$config) {
            $config = new ConfiguracaoLoja();
        }

        $config->nome_loja = $request->input('nome_loja');
        $config->chave_pix = $request->input('chave_pix');
        $config->valor_frete_fixo = $request->input('valor_frete_fixo', 0);
        $config->save();

        return redirect()->route('admin.configuracoes.edit')->with('success', 'Configurações atualizadas com sucesso!');
    }
}
