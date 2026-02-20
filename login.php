<?php
session_start();
require "config/database.php";

if($_POST){
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $stmt = $db->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user && password_verify($senha, $user['senha_hash'])){
        $_SESSION['user'] = $user;
        header("Location: index.php");
    } else {
        echo "Login inválido";
    }
}
?>

<form method="POST">
Email: <input name="email"><br>
Senha: <input type="password" name="senha"><br>
<button>Entrar</button>
</form>
