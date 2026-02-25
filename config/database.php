<?php
    // MUDAMOS AQUI DE 'localhost' PARA '127.0.0.1'
    $host = '127.0.0.1';
    $dbname = 'amor_em_linhas'; 
    $user = 'root';             
    $pass = '';                 

    try {
        $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        die("Erro de conexão com o banco de dados: " . $e->getMessage());
    }
?>