<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('configuracao_lojas', function (Blueprint $table) {
            $table->decimal('valor_frete_fixo', 8, 2)->default(10.00)->after('chave_pix');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('configuracao_lojas', function (Blueprint $table) {
            $table->dropColumn('valor_frete_fixo');
        });
    }
};
