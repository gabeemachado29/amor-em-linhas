<?php 
    require_once "config/database.php";
    include "includes/navbar.php"; 
    $stmt = $db->query("SELECT * FROM produtos LIMIT 3"); // Puxa os 3 primeiros
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css?v=1.3">
    <script>
        const temaSalvo = localStorage.getItem('tema') || 'light';
        document.documentElement.setAttribute('data-bs-theme', temaSalvo);
    </script>
</head>
<body>
    <div class="container mt-5">
        <div class="row row-cols-2 row-cols-md-3 g-4">
            <?php 
            // 1. Tenta buscar os produtos
            $stmt = $db->query("SELECT * FROM produtos LIMIT 3");
            $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // 2. Verifica se o banco retornou algo
            if (count($produtos) > 0): 
                foreach($produtos as $prod): 
            ?>
                <div class="col">
                    <div class="card-produto text-center">
                        <div class="card-img-container shadow-sm" style="border: 1px solid #ddd;">
                            <img src="<?php echo './' . $prod['imagem_principal_url']; ?>" 
                                class="img-fluid w-100" 
                                style="aspect-ratio: 3/4; object-fit: cover; border-radius: 12px;"
                                onerror="this.src='https://placehold.co/400x533/d4d9a1/434a11?text=Sem+Foto'">
                        </div>
                        <div class="mt-3">
                            <p class="text-uppercase mb-1 small" style="color: var(--dark-olive) !important;">
                                <?php echo htmlspecialchars($prod['nome']); ?>
                            </p>
                            <p class="fw-bold mb-0" style="color: var(--dark-olive) !important;">
                                R$ <?php echo number_format($prod['preco'], 2, ',', '.'); ?>
                            </p>
                            <button class="btn-comprar w-100 py-2 mt-2" onclick="addCarrinho(<?php echo $prod['id']; ?>)">
                                Comprar
                            </button>
                        </div>
                    </div>
                </div>
            <?php 
                endforeach; 
            else:
                // 3. Se cair aqui, o banco de dados está vazio!
                echo "<div class='col-12 text-center'><p class='alert alert-warning'>Atenção: Nenhum produto encontrado no banco de dados.</p></div>";
            endif; 
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>