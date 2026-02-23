<?php
session_start();

$host = "sql313.infinityfree.com";
$dbname = "if0_41207105_amorlinhas";
$user = "if0_41207105";
$pass = "SUA_SENHA_AQUI";

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro no banco: " . $e->getMessage());
}
