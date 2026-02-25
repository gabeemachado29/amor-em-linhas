<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Certifique-se de que a verificação é exatamente esta:
    if(!isset($_SESSION['user'])){
        header("Location: login.php");
        exit;
    }   

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(isset($_POST['tema'])){
            $_SESSION['tema'] = $_POST['tema'];
        }

        if(isset($_POST['idioma'])){
            $_SESSION['idioma'] = $_POST['idioma'];
        }

        $msg = "Configurações salvas!";
    }
?>

<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="light">
    <head>
        <link rel="stylesheet" href="css/style.css">
        <script>
            const temaSalvo = localStorage.getItem('tema') || 'light';
            document.documentElement.setAttribute('data-bs-theme', temaSalvo);
        </script>
        <meta charset="UTF-8">
        <title>Configurações</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script>
            const temaSalvo = localStorage.getItem('tema') || 'light';
            document.documentElement.setAttribute('data-bs-theme', temaSalvo);
        </script>
    </head>
    <body>

        <?php include "includes/navbar.php"; ?>

        <div class="container mt-5">
            <div class="card p-4 shadow-sm mx-auto" style="max-width: 600px;">
                <h3 class="mb-4">⚙️ Configurações</h3>

                <?php if(isset($msg)): ?>
                    <div class="alert alert-success"><?php echo $msg; ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tema da Interface</label>
                        <select name="tema" id="seletorTema" class="form-select" onchange="mudarTema()">
                            <option value="light">Claro</option>
                            <option value="dark">Escuro</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Idioma do Sistema</label>
                        <select name="idioma" class="form-select">
                            <option value="pt" <?php echo (isset($_SESSION['idioma']) && $_SESSION['idioma'] == 'pt') ? 'selected' : ''; ?>>Português</option>
                            <option value="en" <?php echo (isset($_SESSION['idioma']) && $_SESSION['idioma'] == 'en') ? 'selected' : ''; ?>>English</option>
                            <option value="es" <?php echo (isset($_SESSION['idioma']) && $_SESSION['idioma'] == 'es') ? 'selected' : ''; ?>>Español</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Receber Notificações por Email</label>
                        <select class="form-select">
                            <option>Sim</option>
                            <option>Não</option>
                        </select>
                    </div>

                    <button class="btn btn-primary w-100 fw-bold">Salvar Alterações</button>
                </form>
            </div>
        </div>

        <script>
            document.getElementById('seletorTema').value = localStorage.getItem('tema') || 'light';

            function mudarTema() {
                const temaEscolhido = document.getElementById('seletorTema').value;
                document.documentElement.setAttribute('data-bs-theme', temaEscolhido);
                localStorage.setItem('tema', temaEscolhido);
            }
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>