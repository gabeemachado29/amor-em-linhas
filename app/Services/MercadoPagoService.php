<?php

namespace App\Services;

use App\Models\Pedido;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MercadoPagoService
{
    protected string $accessToken;
    protected string $baseUrl = 'https://api.mercadopago.com';

    public function __construct()
    {
        $this->accessToken = config('services.mercadopago.access_token', '');
    }

    /**
     * Verifica se o Mercado Pago está configurado.
     */
    public function isConfigured(): bool
    {
        return !empty($this->accessToken);
    }

    /**
     * Cria uma preferência de pagamento no Mercado Pago.
     * Retorna a URL de checkout ou null em caso de falha.
     */
    public function criarPreferencia(Pedido $pedido): ?string
    {
        if (!$this->isConfigured()) {
            Log::warning('MercadoPago: Access token não configurado.');
            return null;
        }

        $pedido->load('itens.produto');

        $items = [];
        foreach ($pedido->itens as $item) {
            $items[] = [
                'title' => $item->produto ? $item->produto->nome : 'Produto',
                'quantity' => (int) $item->quantidade,
                'unit_price' => (float) $item->preco_unitario,
                'currency_id' => 'BRL',
            ];
        }

        // Adicionar frete como item separado
        if ($pedido->valor_frete > 0) {
            $items[] = [
                'title' => 'Frete',
                'quantity' => 1,
                'unit_price' => (float) $pedido->valor_frete,
                'currency_id' => 'BRL',
            ];
        }

        $preference = [
            'items' => $items,
            'payer' => [
                'email' => $pedido->cliente ? $pedido->cliente->email : '',
            ],
            'back_urls' => [
                'success' => route('checkout.success', $pedido->id),
                'failure' => route('carrinho.index'),
                'pending' => route('checkout.success', $pedido->id),
            ],
            'auto_return' => 'approved',
            'external_reference' => (string) $pedido->id,
            'notification_url' => route('checkout.mercadopago.webhook'),
        ];

        try {
            $response = Http::withToken($this->accessToken)
                ->post("{$this->baseUrl}/checkout/preferences", $preference);

            if ($response->successful()) {
                $data = $response->json();
                // Usa sandbox URL se em desenvolvimento
                return app()->environment('production')
                    ? $data['init_point']
                    : $data['sandbox_init_point'];
            }

            Log::error('MercadoPago: Erro ao criar preferência', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('MercadoPago: Exception ao criar preferência', [
                'message' => $e->getMessage(),
            ]);
            return null;
        }
    }

    /**
     * Processa notificação de webhook do Mercado Pago.
     */
    public function processarWebhook(array $data): bool
    {
        if (!$this->isConfigured()) {
            return false;
        }

        $type = $data['type'] ?? null;
        $dataId = $data['data']['id'] ?? null;

        if ($type !== 'payment' || !$dataId) {
            return false;
        }

        try {
            $response = Http::withToken($this->accessToken)
                ->get("{$this->baseUrl}/v1/payments/{$dataId}");

            if (!$response->successful()) {
                Log::error('MercadoPago: Erro ao consultar pagamento', [
                    'payment_id' => $dataId,
                ]);
                return false;
            }

            $payment = $response->json();
            $externalReference = $payment['external_reference'] ?? null;
            $status = $payment['status'] ?? null;

            if (!$externalReference) {
                return false;
            }

            $pedido = Pedido::find($externalReference);
            if (!$pedido) {
                return false;
            }

            // Mapear status do MP para status interno
            $statusMap = [
                'approved' => 'PAGO',
                'pending' => 'PENDENTE',
                'in_process' => 'PENDENTE',
                'rejected' => 'CANCELADO',
                'cancelled' => 'CANCELADO',
                'refunded' => 'CANCELADO',
            ];

            $novoStatus = $statusMap[$status] ?? 'PENDENTE';
            $pedido->status = $novoStatus;
            $pedido->save();

            Log::info('MercadoPago: Pedido atualizado via webhook', [
                'pedido_id' => $pedido->id,
                'status' => $novoStatus,
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('MercadoPago: Exception ao processar webhook', [
                'message' => $e->getMessage(),
            ]);
            return false;
        }
    }
}
