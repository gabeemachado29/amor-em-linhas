<?php
session_start();
require "../config/database.php";

if($_POST){
    $stmt = $db->prepare("INSERT OR REPLACE INTO configuracao_loja 
    (id,chave_pix_destino,nome_beneficiario,cidade_beneficiario)
    VALUES (1,?,?,?)");

    $stmt->execute([
        $_POST['chave'],
        $_POST['nome'],
        $_POST['cidade']
    ]);

    echo "PIX atualizado!";
}
?>

<form method="POST">
Chave PIX: <input name="chave"><br>
Nome Beneficiário: <input name="nome"><br>
Cidade: <input name="cidade"><br>
<button>Salvar</button>
</form>
