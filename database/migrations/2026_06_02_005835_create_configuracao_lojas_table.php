<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('configuracao_lojas', function (Blueprint $table) {
            $table->id();
            $table->text('chave_pix')->nullable();
            $table->string('nome_loja')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('configuracao_lojas');
    }
};
