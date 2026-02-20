<?php
session_start();
require "../config/database.php";

if(!isset($_SESSION['user']) || $_SESSION['user']['tipo_perfil'] != 'ADMIN'){
    die("Acesso negado");
}
?>

<h2>Painel Admin</h2>

<a href="produto_novo.php">Cadastrar Produto</a><br>
<a href="config_pix.php">Configurar PIX</a>
