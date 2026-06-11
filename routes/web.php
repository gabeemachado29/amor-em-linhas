<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\BuscaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/produto/{id}', [ProdutoController::class, 'show'])->name('produto.show');
Route::get('/carrinho', [CarrinhoController::class, 'index'])->name('carrinho.index');
Route::get('/busca', [BuscaController::class, 'index'])->name('busca');

Route::get('/dashboard', function () {
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Checkout
    Route::get('/checkout', [\App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [\App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/sucesso/{pedido}', [\App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');

    // Minhas Compras
    Route::get('/pedidos', [\App\Http\Controllers\UserPedidoController::class, 'index'])->name('pedidos.index');
    Route::get('/pedidos/{id}', [\App\Http\Controllers\UserPedidoController::class, 'show'])->name('pedidos.show');
});

// Webhook Mercado Pago (sem auth - recebe chamadas externas)
Route::post('/checkout/mercadopago/webhook', function (\Illuminate\Http\Request $request) {
    $mpService = new \App\Services\MercadoPagoService();
    $mpService->processarWebhook($request->all());
    return response()->json(['status' => 'ok']);
})->name('checkout.mercadopago.webhook');

// Rotas protegidas para administradores
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('produtos', App\Http\Controllers\Admin\ProdutoController::class);
    Route::resource('banners', App\Http\Controllers\Admin\BannerController::class);
    
    Route::get('pedidos', [App\Http\Controllers\Admin\PedidoController::class, 'index'])->name('pedidos.index');
    Route::get('pedidos/{id}', [App\Http\Controllers\Admin\PedidoController::class, 'show'])->name('pedidos.show');
    Route::patch('pedidos/{id}', [App\Http\Controllers\Admin\PedidoController::class, 'update'])->name('pedidos.update');

    Route::get('clientes', [App\Http\Controllers\Admin\ClienteController::class, 'index'])->name('clientes.index');
    Route::get('clientes/{id}', [App\Http\Controllers\Admin\ClienteController::class, 'show'])->name('clientes.show');

    Route::get('configuracoes', [App\Http\Controllers\Admin\ConfiguracaoController::class, 'edit'])->name('configuracoes.edit');
    Route::put('configuracoes', [App\Http\Controllers\Admin\ConfiguracaoController::class, 'update'])->name('configuracoes.update');
});

require __DIR__.'/auth.php';
