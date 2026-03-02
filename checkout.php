<?php
    session_start(); 
    require "config/database.php";

    if(!isset($_SESSION['user'])){
        header("Location: login.php");
        exit;
    }

    $conteudo_finalizado = false;
    $qrCode = "";
    $chavePix = "";

    if($_POST && isset($_POST['carrinho'])){
        $carrinho = json_decode($_POST['carrinho'], true);
        $total = 0;

        /* VALIDA E REDUZ ESTOQUE */
        foreach($carrinho as $id => $qtd){
            $stmt_prod = $db->prepare("SELECT * FROM produtos WHERE id = ?");
            $stmt_prod->execute([$id]);
            $produto = $stmt_prod->fetch(PDO::FETCH_ASSOC);

            if($produto['estoque_atual'] < $qtd){
                die("Estoque insuficiente para ".$produto['nome']);
            }

            $total += $produto['preco'] * $qtd;
            $db->prepare("UPDATE produtos SET estoque_atual = estoque_atual - ? WHERE id = ?")->execute([$qtd, $id]);
        }

        /* GERA PIX */
        $config = $db->query("SELECT * FROM configuracao_loja LIMIT 1")->fetch(PDO::FETCH_ASSOC);
        $pixPayload = "00020126580014BR.GOV.BCB.PIX0136".$config['chave_pix_destino']."5204000053039865405".$total."5802BR5925".$config['nome_beneficiario']."6009".$config['cidade_beneficiario']."6304";
        $qrCode = "https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=".$pixPayload;
        $chavePix = $config['chave_pix_destino'];

        /* CRIA PEDIDO */
        $stmt = $db->prepare("INSERT INTO pedidos (cliente_id, data_criacao, status, tipo_entrega, valor_frete, valor_total, chave_pix_copia_cola) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_SESSION['user']['id'],
            date("Y-m-d H:i:s"),
            "AGUARDANDO_PAGAMENTO",
            "ENTREGA",
            0,
            $total,
            $pixPayload
        ]);

        $pedido_id = $db->lastInsertId();

        /* SALVA ITENS */
        foreach($carrinho as $id => $qtd){
            $stmt_prod = $db->prepare("SELECT * FROM produtos WHERE id = ?");
            $stmt_prod->execute([$id]);
            $produto = $stmt_prod->fetch(PDO::FETCH_ASSOC);
            
            $stmt_item = $db->prepare("INSERT INTO itens_pedido (pedido_id, produto_id, quantidade, preco_unitario) VALUES (?, ?, ?, ?)");
            $stmt_item->execute([$pedido_id, $id, $qtd, $produto['preco']]);
        }
        
        $conteudo_finalizado = true;
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Finalizar Pedido - Amor em Linhas</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/style.css">
        <script>
            const temaSalvo = localStorage.getItem('tema') || 'light';
            document.documentElement.setAttribute('data-bs-theme', temaSalvo);
        </script>
    </head>
    <body class="bg-light">

        <?php include "includes/navbar.php"; ?>

        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm p-4 text-center" style="border-radius: 15px;">
                        
                        <?php if($conteudo_finalizado): ?>
                            <h3 class="fw-light text-uppercase mb-4">Pedido Criado! 🧶</h3>
                            <p class="text-muted">Escaneie o QR Code abaixo para pagar via PIX:</p>
                            
                            <div class="my-4 d-flex justify-content-center">
                                <img src="<?= $qrCode ?>" class="img-fluid border p-2 bg-white" alt="QR Code PIX">
                            </div>

                            <div class="alert alert-secondary py-2 small">
                                <strong>Chave PIX:</strong> <?= htmlspecialchars($chavePix) ?>
                            </div>

                            <p class="small text-muted mb-4">O seu pedido será processado assim que confirmarmos o pagamento.</p>
                            
                            <a href="historico.php" class="btn-comprar d-block text-decoration-none py-3">Ver Meus Pedidos</a>
                            
                            <script>localStorage.removeItem('carrinho');</script>

                        <?php else: ?>
                            <h3 class="fw-light text-uppercase mb-4">Confirmar Pedido</h3>
                            <p>Deseja finalizar sua compra e gerar o pagamento?</p>
                            
                            <form method="POST" onsubmit="enviarCarrinho()">
                                <input type="hidden" name="carrinho" id="carrinhoInput">
                                <button class="btn-comprar w-100 py-3 mt-3 shadow-sm">Confirmar e Pagar</button>
                            </form>
                            
                            <a href="carrinho.php" class="btn btn-link text-dark mt-3 small">Voltar para a sacola</a>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>

        <script>
            function enviarCarrinho(){
                let carrinho = localStorage.getItem("carrinho");
                document.getElementById("carrinhoInput").value = carrinho;
            }
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>