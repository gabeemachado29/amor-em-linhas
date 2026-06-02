<?php
    require_once "config/database.php";
    session_start();

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $telefone = $_POST['telefone'];
        $cpf = $_POST['cpf'];
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

        $stmt = $db->prepare("INSERT INTO usuarios (nome, email, senha_hash, tipo_perfil, telefone, cpf) VALUES (?, ?, ?, ?, ?, ?)");

        try {
            $stmt->execute([$nome, $email, $senha, 'CLIENTE', $telefone, $cpf]);
            header("Location: login.php");
            exit;
        } catch (PDOException $e) {
            $erro = "Email já cadastrado.";
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
        <title>Cadastro</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-light">

        <div class="container d-flex justify-content-center align-items-center" style="min-height: 85vh;">
            <div class="card shadow-lg p-4" style="width: 450px;">
                <h3 class="text-center mb-4">Criar Conta</h3>

                <?php if(isset($erro)): ?>
                    <div class="alert alert-danger"><?php echo $erro; ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label>Nome</label>
                        <input type="text" name="nome" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Telefone</label>
                        <input type="text" name="telefone" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>CPF</label>
                        <input type="text" name="cpf" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Senha</label>
                        <input type="password" name="senha" class="form-control" required>
                    </div>
                    <button class="btn btn-primary w-100">Cadastrar</button>
                </form>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>