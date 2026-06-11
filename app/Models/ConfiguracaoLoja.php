<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfiguracaoLoja extends Model
{
    protected $fillable = [
        'chave_pix',
        'nome_loja',
        'valor_frete_fixo',
        'mercadopago_ativo',
    ];

    protected function casts(): array
    {
        return [
            'mercadopago_ativo' => 'boolean',
        ];
    }
}
