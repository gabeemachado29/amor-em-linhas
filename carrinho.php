<?php
    session_start();
    require_once "config/database.php";
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
                    
                    <div id="lista-itens-carrinho">
                        <div class="py-5 text-center">
                            <p class="text-muted">Carregando sua sacola...</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm p-4" style="background-color: #fdfdfd; border-radius: 15px;">
                        <h5 class="fw-light text-uppercase mb-4">Resumo do Pedido</h5>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <span id="resumo-subtotal">R$ 0,00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Entrega (PAC)</span>
                            <span class="text-success small">Grátis</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold">Total</span>
                            <span class="fw-bold fs-5" id="resumo-total" style="color: var(--dark-olive);">R$ 0,00</span>
                        </div>

                        <form action="checkout.php" method="POST" id="formFinalizar">
                            <input type="hidden" name="carrinho" id="inputCarrinhoJson">
                            <button type="button" onclick="finalizarCompra()" class="btn-comprar w-100 py-3 mb-2 shadow-sm" style="font-size: 0.9rem;">
                                Finalizar Compra
                            </button>
                        </form>
                        
                        <a href="index.php" class="btn btn-link w-100 text-dark text-decoration-none small text-center mt-2">Continuar Comprando</a>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="js/carrinho.js"></script>

        <script>
        // Lógica para renderizar o carrinho na tela
        document.addEventListener("DOMContentLoaded", function() {
            renderizarCarrinho();
        });

        function renderizarCarrinho() {
            const carrinho = getCarrinho(); // Função do seu js/carrinho.js
            const container = document.getElementById('lista-itens-carrinho');
            
            if (Object.keys(carrinho).length === 0) {
                container.innerHTML = `
                    <div class="py-5 text-center">
                        <p class="text-muted">Sua sacola está vazia.</p>
                        <a href="index.php" class="btn btn-outline-dark rounded-pill px-4">Voltar para a loja</a>
                    </div>`;
                return;
            }

            // Aqui você pode fazer um fetch para um pequeno script PHP que retorna os dados dos produtos
            // Por simplicidade, vamos apenas mostrar que os itens existem. 
            // Em um sistema real, você usaria o ID para buscar Nome e Preço via AJAX.
            
            container.innerHTML = '<p class="text-muted">Processando itens...</p>';
            
            // Simulação de preenchimento do resumo (ajuste conforme buscar os preços reais)
            // No seu checkout.php já existe a lógica que valida o preço no banco.
        }

        function finalizarCompra() {
            const carrinho = localStorage.getItem("carrinho");
            if (!carrinho || carrinho === "{}") {
                alert("Sua sacola está vazia!");
                return;
            }
            
            // Coloca o JSON do localStorage no campo oculto e envia para o checkout.php
            document.getElementById('inputCarrinhoJson').value = carrinho;
            document.getElementById('formFinalizar').submit();
        }
        </script>
    </body>
</html>