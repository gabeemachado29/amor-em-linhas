<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Pedido;
use App\Models\ItemPedido;
use App\Models\ConfiguracaoLoja;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function process(Request $request)
    {
        $carrinhoJson = $request->input('carrinho');
        if (!$carrinhoJson) {
            return redirect()->route('carrinho.index')->with('error', 'Sua sacola está vazia.');
        }

        $carrinho = json_decode($carrinhoJson, true);
        if (empty($carrinho)) {
            return redirect()->route('carrinho.index')->with('error', 'Sua sacola está vazia.');
        }

        $config = ConfiguracaoLoja::first();
        $freteFixo = $config ? $config->valor_frete_fixo : 10.00;
        
        $subtotal = 0;
        $itensComprar = [];

        DB::beginTransaction();

        try {
            foreach ($carrinho as $idProduto => $quantidade) {
                // Lock the row to prevent race conditions during checkout
                $produto = Produto::where('id', $idProduto)->lockForUpdate()->first();

                if (!$produto) {
                    throw new \Exception("Um dos produtos na sua sacola não foi encontrado.");
                }

                if ($produto->estoque_atual < $quantidade) {
                    throw new \Exception("Estoque insuficiente para o produto: {$produto->nome}. Disponível: {$produto->estoque_atual}.");
                }

                $subtotal += ($produto->preco * $quantidade);
                
                $itensComprar[] = [
                    'produto' => $produto,
                    'quantidade' => $quantidade,
                    'preco_unitario' => $produto->preco
                ];
            }

            $total = $subtotal + $freteFixo;

            // Criar o Pedido
            $pedido = new Pedido();
            $pedido->cliente_id = Auth::id();
            $pedido->status = 'PENDENTE';
            $pedido->tipo_entrega = 'PAC'; // Default para este MVP
            $pedido->valor_frete = $freteFixo;
            $pedido->valor_total = $total;
            $pedido->chave_pix_copia_cola = $config ? $config->chave_pix : null;
            $pedido->save();

            // Deduzir estoque e salvar itens
            foreach ($itensComprar as $item) {
                $produto = $item['produto'];
                
                // Salvar Item do Pedido
                $itemPedido = new ItemPedido();
                $itemPedido->pedido_id = $pedido->id;
                $itemPedido->produto_id = $produto->id;
                $itemPedido->quantidade = $item['quantidade'];
                $itemPedido->preco_unitario = $item['preco_unitario'];
                $itemPedido->save();

                // Deduzir estoque
                $produto->estoque_atual -= $item['quantidade'];
                $produto->save();
            }

            DB::commit();

            return redirect()->route('checkout.success', ['pedido' => $pedido->id]);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('carrinho.index')->with('error', $e->getMessage());
        }
    }

    public function success(Pedido $pedido)
    {
        // Garante que o usuário só possa ver seus próprios pedidos
        if ($pedido->cliente_id !== Auth::id()) {
            abort(403);
        }

        return view('checkout.success', compact('pedido'));
    }
}
