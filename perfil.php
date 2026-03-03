<?php
    session_start();
    require_once "config/database.php";

    // Correção: A sessão definida no login.php é 'user', não 'usuario'
    if(!isset($_SESSION['user'])){
        header("Location: login.php");
        exit;
    }

    $usuario_id = $_SESSION['user']['id'];

    // Processa a atualização dos dados se o formulário for enviado
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $nome = trim($_POST['nome']);
        $email = trim($_POST['email']);
        $telefone = trim($_POST['telefone']);
        $cpf = trim($_POST['cpf']);

        try {
            // Atualiza no banco de dados
            $stmt = $db->prepare("UPDATE usuarios SET nome = ?, email = ?, telefone = ?, cpf = ? WHERE id = ?");
            $stmt->execute([$nome, $email, $telefone, $cpf, $usuario_id]);
            
            // Atualiza o nome na sessão para refletir imediatamente na Navbar
            $_SESSION['user']['nome'] = $nome; 
            
            $sucesso = "Perfil atualizado com sucesso!";
        } catch (PDOException $e) {
            $erro = "Erro ao atualizar. Este e-mail pode já estar em uso por outra conta.";
        }
    }

    // Busca os dados atualizados do usuário no banco para preencher os campos
    $stmt = $db->prepare("SELECT nome, email, telefone, cpf FROM usuarios WHERE id = ?");
    $stmt->execute([$usuario_id]);
    $usuario_db = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$usuario_db) {
        die("Usuário não encontrado.");
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Meu Perfil - Amor em Linhas</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/style.css">
        <script>
            const temaSalvo = localStorage.getItem('tema') || 'light';
            document.documentElement.setAttribute('data-bs-theme', temaSalvo);
        </script>
    </head>
    <body class="bg-light">

        <?php include "includes/navbar.php"; ?>

        <div class="container mt-5 mb-5">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card shadow-sm border-0 p-4" style="border-radius: 15px;">
                        
                        <h3 class="mb-4 text-center">👤 Meu Perfil</h3>

                        <?php if(isset($sucesso)): ?>
                            <div class="alert alert-success"><?php echo $sucesso; ?></div>
                        <?php endif; ?>
                        
                        <?php if(isset($erro)): ?>
                            <div class="alert alert-danger"><?php echo $erro; ?></div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nome Completo</label>
                                <input type="text" name="nome" class="form-control" value="<?php echo htmlspecialchars($usuario_db['nome']); ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">E-mail</label>
                                <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($usuario_db['email']); ?>" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Telefone</label>
                                    <input type="text" name="telefone" class="form-control" value="<?php echo htmlspecialchars($usuario_db['telefone']); ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">CPF</label>
                                    <input type="text" name="cpf" class="form-control" value="<?php echo htmlspecialchars($usuario_db['cpf']); ?>">
                                </div>
                            </div>

                            <button class="btn btn-primary w-100 py-2 mt-3 fw-bold">Salvar Alterações</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>