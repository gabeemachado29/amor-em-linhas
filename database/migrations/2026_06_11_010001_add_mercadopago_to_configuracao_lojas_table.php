<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('configuracao_lojas', function (Blueprint $table) {
            $table->boolean('mercadopago_ativo')->default(false)->after('valor_frete_fixo');
        });
    }

    public function down(): void
    {
        Schema::table('configuracao_lojas', function (Blueprint $table) {
            $table->dropColumn('mercadopago_ativo');
        });
    }
};
