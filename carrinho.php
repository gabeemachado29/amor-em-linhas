<?php
session_start();
require_once "config/database.php";

// Simulando a lógica de buscar itens (Ajuste conforme seu sistema de sessão/banco)
$itens_no_carrinho = isset($_SESSION['carrinho']) ? $_SESSION['carrinho'] : [];
$total_geral = 0;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Minha Sacola - Amor em Linhas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css?v=1.4">
    <script>
        const temaSalvo = localStorage.getItem('tema') || 'light';
        document.documentElement.setAttribute('data-bs-theme', temaSalvo);
    </script>
</head>
<body>

<?php include "includes/navbar.php"; ?>

<div class="container mt-5">
    <div class="row g-5">
        <div class="col-md-8">
            <h4 class="fw-light text-uppercase mb-4">Minha Sacola</h4>
            
            <?php if(empty($itens_no_carrinho)): ?>
                <div class="py-5 text-center">
                    <p class="text-muted">Sua sacola está vazia.</p>
                    <a href="index.php" class="btn btn-outline-dark rounded-pill px-4">Voltar para a loja</a>
                </div>
            <?php else: ?>
                <div class="d-flex align-items-start border-bottom pb-3 mb-3">
                    <div style="width: 100px; height: 130px; background: #f7f7f7; border-radius: 8px; overflow: hidden;">
                        <img src="https://images.unsplash.com/photo-1590600922898-b21d784ef7e7?w=500" class="w-100 h-100" style="object-fit: cover;">
                    </div>
                    <div class="ms-3 flex-grow-1">
                        <div class="d-flex justify-content-between">
                            <p class="text-uppercase mb-1 small fw-bold">Biquíni Brasil - Edição Especial</p>
                            <button class="btn btn-sm text-danger border-0">Remover</button>
                        </div>
                        <p class="text-muted small mb-2">Tamanho: M | Cor: Oliva</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="input-group input-group-sm" style="max-width: 100px;">
                                <button class="btn btn-outline-secondary">-</button>
                                <input type="text" class="form-control text-center border-secondary" value="1">
                                <button class="btn btn-outline-secondary">+</button>
                            </div>
                            <span class="fw-bold">R$ 119,00</span>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-4" style="background-color: #fdfdfd; border-radius: 15px;">
                <h5 class="fw-light text-uppercase mb-4">Resumo do Pedido</h5>
                
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Subtotal</span>
                    <span>R$ 119,00</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Entrega (PAC)</span>
                    <span class="text-success small">Grátis</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-4">
                    <span class="fw-bold">Total</span>
                    <span class="fw-bold fs-5" style="color: var(--dark-olive);">R$ 119,00</span>
                </div>

                <div class="mb-3">
                    <input type="text" class="form-control rounded-pill border-secondary-subtle py-2" placeholder="Cupom de desconto">
                </div>

                <button class="btn-comprar w-100 py-3 mb-2 shadow-sm" style="font-size: 0.9rem;">Finalizar Compra</button>
                <a href="index.php" class="btn btn-link w-100 text-dark text-decoration-none small text-center mt-2">Continuar Comprando</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>