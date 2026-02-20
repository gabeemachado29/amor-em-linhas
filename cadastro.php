<?php
require "config/database.php";

if($_POST){

$nome = trim($_POST['nome']);
$email = trim($_POST['email']);
$senha = $_POST['senha'];

if(!$nome || !$email || !$senha){
    die("Preencha todos os campos.");
}

$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

$stmt = $db->prepare("INSERT INTO usuarios 
(nome,email,senha_hash,tipo_perfil)
VALUES (?,?,?,'CLIENTE')");

try{
$stmt->execute([$nome,$email,$senhaHash]);

$userId = $db->lastInsertId();

$_SESSION['user'] = [
'id' => $userId,
'nome' => $nome,
'email' => $email,
'tipo_perfil' => 'CLIENTE'
];

header("Location: index.php");
exit;

}catch(PDOException $e){
die("Email já cadastrado.");
}
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Criar Conta</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="container">
<h2>👤 Criar Conta</h2>

<form method="POST" style="max-width:400px;">
<input name="nome" placeholder="Nome completo" required><br><br>
<input type="email" name="email" placeholder="Email" required><br><br>
<input type="password" name="senha" placeholder="Senha" required><br><br>

<button class="btn">Cadastrar</button>
</form>

<p>Já tem conta? <a href="login.php">Entrar</a></p>
</div>

</body>
</html>
