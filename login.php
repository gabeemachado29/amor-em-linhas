<?php
    require_once "config/database.php";
    session_start();

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $stmt = $db->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if($usuario && password_verify($senha, $usuario['senha_hash'])){
            // CORREÇÃO: Padronização da sessão em array para o checkout e dashboard funcionarem
            $_SESSION['user'] = [
                'id' => $usuario['id'],
                'nome' => $usuario['nome'],
                'tipo_perfil' => $usuario['tipo_perfil']
            ];
            
            // Redireciona para o painel correto
            if($usuario['tipo_perfil'] === 'ADMIN'){
                header("Location: admin/dashboard.php");
            } else {
                header("Location: index.php");
            }
            exit;
        } else {
            $erro = "Email ou senha inválidos.";
        }
    }
?>

<?php include "includes/navbar.php"; ?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <link rel="stylesheet" href="css/style.css">
        <script>
            const temaSalvo = localStorage.getItem('tema') || 'light';
            document.documentElement.setAttribute('data-bs-theme', temaSalvo);
        </script>
        <meta charset="UTF-8">
        <title>Login</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-light">

        <div class="container d-flex justify-content-center align-items-center" style="min-height: 85vh;">
            <div class="card shadow-lg p-4" style="width: 400px;">
                <h3 class="text-center mb-4">Entrar</h3>

                <?php if(isset($erro)): ?>
                    <div class="alert alert-danger"><?php echo $erro; ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Senha</label>
                        <input type="password" name="senha" class="form-control" required>
                    </div>

                    <button class="btn btn-primary w-100">Entrar</button>
                </form>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>