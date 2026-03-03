<?php
    require "config/database.php";

    $nome = "Ana Lia Santos Rodrigues";
    $email = "amorlinhas@gmail.com";
    $senha_plana = "amorlinhas123";
    
    // Criptografa a senha para manter o padrão de segurança do sistema
    $senha_hash = password_hash($senha_plana, PASSWORD_DEFAULT);
    $tipo_perfil = "ADMIN";

    try {
        // Primeiro, vamos verificar se esse e-mail já está cadastrado
        $stmt = $db->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);

        if($stmt->rowCount() > 0){
            // Se já existir, apenas atualiza para garantir que seja ADMIN e com a senha nova
            $stmtUpdate = $db->prepare("UPDATE usuarios SET nome = ?, senha_hash = ?, tipo_perfil = ? WHERE email = ?");
            $stmtUpdate->execute([$nome, $senha_hash, $tipo_perfil, $email]);
            echo "<h3>✅ Conta Admin atualizada com sucesso!</h3>";
        } else {
            // Se não existir, cria a nova conta
            $stmtInsert = $db->prepare("INSERT INTO usuarios (nome, email, senha_hash, tipo_perfil) VALUES (?, ?, ?, ?)");
            $stmtInsert->execute([$nome, $email, $senha_hash, $tipo_perfil]);
            echo "<h3>✅ Conta Admin criada com sucesso!</h3>";
        }
        
        echo "<p>Você já pode fazer <a href='login.php'>login</a>.</p>";
        echo "<p style='color:red;'><b>Aviso:</b> Por segurança, exclua este arquivo (criar_admin.php) agora.</p>";

    } catch(PDOException $e) {
        echo "Erro ao criar admin: " . $e->getMessage();
    }
?>