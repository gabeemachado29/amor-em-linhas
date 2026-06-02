<?php 
    require_once "config/database.php";
    include "includes/navbar.php"; 
    
    // Busca banners para o carrossel
    $banners = $db->query("SELECT * FROM banners ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css?v=1.3">
    <style>
        .carousel-item img {
            height: 300px;
            object-fit: cover;
            border-radius: 15px;
        }
        
        .carousel-control-prev-icon, .carousel-control-next-icon {
            background-color: rgba(0,0,0,0.3);
            border-radius: 50%;
            padding: 20px;
        }

        .card-produto {
            transition: transform 0.3s;
            margin-bottom: 20px;
        }
        .card-produto:hover {
            transform: translateY(-5px);
        }
        .card-img-container img {
            aspect-ratio: 1/1 !important;
            border-radius: 10px !important;
        }
    </style>
    <script>
        const temaSalvo = localStorage.getItem('tema') || 'light';
        document.documentElement.setAttribute('data-bs-theme', temaSalvo);
    </script>
</head>
<body>

    <div class="container mt-4">
        <?php if (count($banners) > 0): ?>
            <div id="carouselPromo" class="carousel slide shadow-sm mb-5" data-bs-ride="carousel" data-bs-interval="10000">
                
                <div class="carousel-indicators">
                    <?php foreach ($banners as $index => $b): ?>
                        <button type="button" data-bs-target="#carouselPromo" data-bs-slide-to="<?= $index ?>" class="<?= $index === 0 ? 'active' : '' ?>" aria-current="true"></button>
                    <?php endforeach; ?>
                </div>

                <div class="carousel-inner" style="border-radius: 15px;">
                    <?php foreach ($banners as $index => $b): ?>
                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>" data-bs-interval="10000">
                            <img src="<?= $b['imagem_url'] ?>" class="d-block w-100" alt="<?= htmlspecialchars($b['titulo']) ?>">
                            <?php if ($b['titulo']): ?>
                                <div class="carousel-caption d-none d-md-block" style="background: rgba(0,0,0,0.4); border-radius: 10px; padding: 5px 15px;">
                                    <h5 class="mb-0"><?= htmlspecialchars($b['titulo']) ?></h5>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselPromo" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselPromo" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
            </div>
        <?php endif; ?>

        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3 justify-content-center">
            <?php 
            $stmt = $db->query("SELECT * FROM produtos LIMIT 8");
            $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($produtos) > 0): 
                foreach($produtos as $prod): 
            ?>
                <div class="col d-flex justify-content-center">
                    <div class="card-produto text-center p-2 w-100" style="max-width: 250px;">
                        <div class="card-img-container shadow-sm">
                            <img src="<?php echo './' . $prod['imagem_principal_url']; ?>" 
                                 class="img-fluid w-100" 
                                 onerror="this.src='https://placehold.co/400x400/d4d9a1/434a11?text=Sem+Foto'">
                        </div>
                        <div class="mt-2">
                            <p class="text-uppercase mb-0 small fw-bold" style="color: var(--dark-olive) !important; font-size: 0.75rem;">
                                <?php echo htmlspecialchars($prod['nome']); ?>
                            </p>
                           <p class="mb-2" style="color: var(--dark-olive) !important; font-size: 0.9rem;">
                                R$ <?php echo number_format($prod['preco'], 2, ',', '.'); ?>
                            </p>
                            
                            <?php 
                            $isAdmin = isset($_SESSION['user']) && $_SESSION['user']['tipo_perfil'] === 'ADMIN'; 
                            if(!$isAdmin): ?>
                                <button class="btn btn-sm btn-comprar w-100 py-1" onclick="addCarrinho(<?php echo $prod['id']; ?>)" style="font-size: 0.8rem; border-radius: 20px;">
                                    Comprar
                                </button>
                            <?php else: ?>
                                <a href="admin/gerenciar_produtos.php?editar=<?php echo $prod['id']; ?>" class="btn btn-warning btn-sm w-100 py-1 fw-bold" style="font-size: 0.7rem; border-radius: 20px;">
                                    ✏️ Editar
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php 
                endforeach; 
            else:
                echo "<div class='col-12 text-center'><p class='alert alert-warning'>Nenhum produto encontrado.</p></div>";
            endif; 
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/carrinho.js"></script>
</body>
</html>