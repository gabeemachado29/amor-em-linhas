<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = [
        'cliente_id',
        'status',
        'tipo_entrega',
        'valor_frete',
        'valor_total',
        'chave_pix_copia_cola',
    ];

    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }

    public function itens()
    {
        return $this->hasMany(ItemPedido::class, 'pedido_id');
    }
}
