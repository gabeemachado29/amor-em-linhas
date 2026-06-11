<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->string('endereco_rua')->nullable()->after('chave_pix_copia_cola');
            $table->string('endereco_numero')->nullable()->after('endereco_rua');
            $table->string('endereco_complemento')->nullable()->after('endereco_numero');
            $table->string('endereco_bairro')->nullable()->after('endereco_complemento');
            $table->string('endereco_cidade')->nullable()->after('endereco_bairro');
            $table->string('endereco_estado', 2)->nullable()->after('endereco_cidade');
            $table->string('endereco_cep', 9)->nullable()->after('endereco_estado');
            $table->string('metodo_pagamento')->default('PIX')->after('endereco_cep');
        });
    }

    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropColumn([
                'endereco_rua',
                'endereco_numero',
                'endereco_complemento',
                'endereco_bairro',
                'endereco_cidade',
                'endereco_estado',
                'endereco_cep',
                'metodo_pagamento',
            ]);
        });
    }
};
