<?php
    session_start();
    require_once "config/database.php";

    // Busca todos os produtos para o JavaScript conseguir renderizar a tela
    $stmt = $db->query("SELECT id, nome, preco, imagem_principal_url FROM produtos");
    $todosProdutos = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            // Transforma os produtos do PHP em uma variável JavaScript
            const produtosDB = <?php echo json_encode($todosProdutos); ?>;

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

                let htmlItens = '';
                let subtotal = 0;

                // Percorre os itens salvos no localStorage
                for (let idProduto in carrinho) {
                    let quantidade = carrinho[idProduto];
                    
                    // Encontra os detalhes do produto (nome, preço, imagem) no array que veio do PHP
                    let produto = produtosDB.find(p => p.id == idProduto);

                    if (produto) {
                        let precoTotalItem = produto.preco * quantidade;
                        subtotal += precoTotalItem;

                        htmlItens += `
                        <div class="card mb-3 shadow-sm border-0" style="border-radius: 12px;">
                            <div class="row g-0 align-items-center p-3">
                                <div class="col-3 col-md-2">
                                    <img src="${produto.imagem_principal_url}" class="img-fluid rounded" alt="${produto.nome}" onerror="this.src='https://placehold.co/400x533/d4d9a1/434a11?text=Sem+Foto'">
                                </div>
                                <div class="col-9 col-md-10 ps-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0 fw-bold">${produto.nome}</h6>
                                        <button class="btn btn-sm text-danger p-0" onclick="removerItem(${produto.id})">Remover</button>
                                    </div>
                                    <p class="text-muted mb-1 small">Quantidade: ${quantidade}</p>
                                    <p class="mb-0 fw-bold" style="color: var(--dark-olive);">R$ ${precoTotalItem.toFixed(2).replace('.', ',')}</p>
                                </div>
                            </div>
                        </div>`;
                    }
                }

                // Atualiza a tela com os itens
                container.innerHTML = htmlItens;

                // Atualiza os valores de Resumo do Pedido na lateral
                let valorFormatado = 'R$ ' + subtotal.toFixed(2).replace('.', ',');
                document.getElementById('resumo-subtotal').innerText = valorFormatado;
                document.getElementById('resumo-total').innerText = valorFormatado;
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