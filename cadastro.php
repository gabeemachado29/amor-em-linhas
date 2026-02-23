<?php
require_once "config/database.php";
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $stmt = $db->prepare("INSERT INTO usuarios (nome,email,senha_hash,tipo_perfil) VALUES (?,?,?,?)");
    
    try {
        $stmt->execute([$nome,$email,$senha,'cliente']);
        header("Location: login.php");
        exit;
    } catch (PDOException $e) {
        $erro = "Este email já está cadastrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro - Amor em Linhas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- NAVBAR -->
<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">🧵 Amor em Linhas</a>
    </div>
</nav>

<!-- FORM CENTRALIZADO -->
<div class="container d-flex justify-content-center align-items-center" style="min-height: 85vh;">
    <div class="card shadow-lg border-0 p-4" style="width: 450px; border-radius: 15px;">

        <h3 class="text-center mb-4 fw-bold">Criar Conta</h3>

        <?php if(isset($erro)): ?>
            <div class="alert alert-danger">
                <?php echo $erro; ?>
            </div>
        <?php endif; ?>

        <form method="POST">

            <div class="mb-3">
                <label class="form-label">Nome Completo</label>
                <input type="text" name="nome" class="form-control form-control-lg" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control form-control-lg" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Senha</label>
                <input type="password" name="senha" class="form-control form-control-lg" required>
            </div>

            <button type="submit" class="btn btn-primary btn-lg w-100 mt-3">
                Criar Conta
            </button>

        </form>

        <div class="text-center mt-4">
            Já tem conta? <a href="login.php">Entrar</a>
        </div>

    </div>
</div>

</body>
</html>
