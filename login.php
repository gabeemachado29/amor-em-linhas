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
        $_SESSION['usuario'] = $usuario;
        header("Location: index.php");
        exit;
    } else {
        $erro = "Email ou senha inválidos";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Amor em Linhas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">🧵 Amor em Linhas</a>
    </div>
</nav>

<div class="container d-flex justify-content-center align-items-center" style="height: 80vh;">
    <div class="card shadow p-4" style="width: 400px;">
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

            <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </form>

        <div class="text-center mt-3">
            <a href="cadastro.php">Criar conta</a>
        </div>
    </div>
</div>

</body>
</html>
