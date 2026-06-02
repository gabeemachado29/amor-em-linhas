<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('data_criacao')->useCurrent();
            $table->string('status')->default('PENDENTE');
            $table->string('tipo_entrega')->nullable();
            $table->decimal('valor_frete', 10, 2)->default(0);
            $table->decimal('valor_total', 10, 2)->default(0);
            $table->text('chave_pix_copia_cola')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
