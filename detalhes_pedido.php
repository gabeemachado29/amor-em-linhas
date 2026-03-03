<?php
    session_start();
    require_once "config/database.php";

    // Verifica se o usuário está logado
    if(!isset($_SESSION['user'])){
        header("Location: login.php");
        exit;
    }

    $usuario_id = $_SESSION['user']['id'];
    $pedido_id = $_GET['id'] ?? 0;

    // Busca o pedido garantindo que pertence ao usuário logado (segurança)
    $stmt = $db->prepare("SELECT * FROM pedidos WHERE id = ? AND cliente_id = ?");
    $stmt->execute([$pedido_id, $usuario_id]);
    $pedido = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$pedido){
        die("Pedido não encontrado ou acesso negado.");
    }

    // Lógica de cancelamento
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cancelar_pedido'])){
        // Só permite cancelar se estiver aguardando pagamento
        if($pedido['status'] == 'AGUARDANDO_PAGAMENTO'){
            try {
                $db->beginTransaction();
                
                // 1. Muda o status para CANCELADO
                $stmt_cancel = $db->prepare("UPDATE pedidos SET status = 'CANCELADO' WHERE id = ?");
                $stmt_cancel->execute([$pedido_id]);
                
                // 2. Busca os itens para devolver ao estoque
                $stmt_itens_cancel = $db->prepare("SELECT produto_id, quantidade FROM itens_pedido WHERE pedido_id = ?");
                $stmt_itens_cancel->execute([$pedido_id]);
                $itens_cancelar = $stmt_itens_cancel->fetchAll(PDO::FETCH_ASSOC);
                
                // 3. Devolve o estoque
                foreach($itens_cancelar as $item){
                    $stmt_estoque = $db->prepare("UPDATE produtos SET estoque_atual = estoque_atual + ? WHERE id = ?");
                    $stmt_estoque->execute([$item['quantidade'], $item['produto_id']]);
                }
                
                $db->commit();
                $pedido['status'] = 'CANCELADO'; // Atualiza a variável para refletir na tela agora mesmo
                $msg_sucesso = "Seu pedido foi cancelado e os itens devolvidos ao estoque da loja.";
            } catch (Exception $e) {
                $db->rollBack();
                $msg_erro = "Erro ao cancelar o pedido: " . $e->getMessage();
            }
        }
    }

    // Busca os detalhes dos itens deste pedido
    $stmt_itens = $db->prepare("
        SELECT ip.quantidade, ip.preco_unitario, p.nome, p.imagem_principal_url 
        FROM itens_pedido ip 
        JOIN produtos p ON ip.produto_id = p.id 
        WHERE ip.pedido_id = ?
    ");
    $stmt_itens->execute([$pedido_id]);
    $itens = $stmt_itens->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Detalhes do Pedido #<?php echo $pedido_id; ?> - Amor em Linhas</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/style.css">
        <script>
            const temaSalvo = localStorage.getItem('tema') || 'light';
            document.documentElement.setAttribute('data-bs-theme', temaSalvo);
        </script>
    </head>
    <body class="bg-light">

        <?php include "includes/navbar.php"; ?>

        <div class="container mt-5 mb-5">
            <a href="historico.php" class="text-decoration-none text-muted mb-3 d-inline-block">← Voltar ao Histórico</a>
            
            <div class="row g-4">
                <div class="col-md-8">
                    <div class="card shadow-sm border-0 p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="mb-0">Pedido #<?php echo $pedido['id']; ?></h4>
                            <?php 
                                $badgeClass = 'bg-secondary';
                                if($pedido['status'] == 'PAGO') $badgeClass = 'bg-success';
                                if($pedido['status'] == 'CANCELADO') $badgeClass = 'bg-danger';
                                if($pedido['status'] == 'AGUARDANDO_PAGAMENTO') $badgeClass = 'bg-warning text-dark';
                            ?>
                            <span class="badge <?php echo $badgeClass; ?> fs-6">
                                <?php echo str_replace('_', ' ', $pedido['status']); ?>
                            </span>
                        </div>

                        <?php if(isset($msg_sucesso)): ?>
                            <div class="alert alert-success"><?php echo $msg_sucesso; ?></div>
                        <?php endif; ?>
                        <?php if(isset($msg_erro)): ?>
                            <div class="alert alert-danger"><?php echo $msg_erro; ?></div>
                        <?php endif; ?>

                        <h5 class="fw-bold mb-3">Itens Comprados</h5>
                        <ul class="list-group list-group-flush mb-4">
                            <?php foreach($itens as $item): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                                    <div class="d-flex align-items-center">
                                        <img src="<?php echo htmlspecialchars($item['imagem_principal_url']); ?>" alt="Produto" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;" class="me-3" onerror="this.src='https://placehold.co/60x60/d4d9a1/434a11?text=Sem+Foto'">
                                        <div>
                                            <h6 class="mb-0"><?php echo htmlspecialchars($item['nome']); ?></h6>
                                            <small class="text-muted">Qtd: <?php echo $item['quantidade']; ?></small>
                                        </div>
                                    </div>
                                    <span class="fw-bold">R$ <?php echo number_format($item['preco_unitario'] * $item['quantidade'], 2, ',', '.'); ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm border-0 p-4" style="border-radius: 15px;">
                        <h5 class="fw-bold mb-3">Resumo</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <span>R$ <?php echo number_format($pedido['valor_total'], 2, ',', '.'); ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Frete (<?php echo $pedido['tipo_entrega']; ?>)</span>
                            <span>R$ <?php echo number_format($pedido['valor_frete'], 2, ',', '.'); ?></span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold">Total</span>
                            <span class="fw-bold fs-5 text-success">R$ <?php echo number_format($pedido['valor_total'] + $pedido['valor_frete'], 2, ',', '.'); ?></span>
                        </div>

                        <p class="small text-muted mb-4">Data da compra: <?php echo date('d/m/Y às H:i', strtotime($pedido['data_criacao'])); ?></p>

                        <?php if($pedido['status'] == 'AGUARDANDO_PAGAMENTO'): ?>
                            <form method="POST" onsubmit="return confirm('Tem certeza que deseja cancelar este pedido? Esta ação não pode ser desfeita.');">
                                <input type="hidden" name="cancelar_pedido" value="1">
                                <button type="submit" class="btn btn-outline-danger w-100 py-2">Cancelar Compra</button>
                            </form>

                            <div class="mt-4 text-center">
                                <p class="small text-muted mb-2">Ainda não pagou? Copie a chave Pix abaixo:</p>
                                <input type="text" class="form-control form-control-sm text-center mb-2" value="<?php echo htmlspecialchars($pedido['chave_pix_copia_cola']); ?>" readonly onclick="this.select(); document.execCommand('copy'); alert('Chave copiada!');">
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>