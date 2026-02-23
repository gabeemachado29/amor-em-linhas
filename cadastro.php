<?php
require_once "config/database.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $stmt = $db->prepare("INSERT INTO usuarios (nome,email,senha_hash,tipo_perfil) VALUES (?,?,?,?)");
    $stmt->execute([$nome,$email,$senha,'cliente']);

    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cadastro</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h2>Cadastro</h2>

<form method="POST">
    <input type="text" name="nome" placeholder="Nome" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="senha" placeholder="Senha" required>
    <button type="submit">Cadastrar</button>
</form>

</body>
</html>
