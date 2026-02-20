<?php
require "config/database.php";

$config = $db->query("SELECT * FROM configuracao_loja LIMIT 1")->fetch(PDO::FETCH_ASSOC);

if(!$config){
    echo "PIX não configurado pelo administrador.";
    exit;
}
?>

<h2>Pagamento via PIX</h2>

<p>Beneficiário: <?= $config['nome_beneficiario'] ?></p>
<p>Cidade: <?= $config['cidade_beneficiario'] ?></p>

<h3>Chave PIX:</h3>
<input value="<?= $config['chave_pix_destino'] ?>" readonly style="width:300px">

<p>Após pagar, envie o comprovante via WhatsApp.</p>
