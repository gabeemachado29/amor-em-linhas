<?php
    session_start();
    require_once "config/database.php";

    if(!isset($_SESSION['usuario'])){
        header("Location: login.php");
        exit;
    }

    $usuario = $_SESSION['usuario'];

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $nome = $_POST['nome'];

        $stmt = $db->prepare("UPDATE usuarios SET nome = ? WHERE id = ?");
        $stmt->execute([$nome, $usuario['id']]);

        $_SESSION['usuario']['nome'] = $nome;
        $sucesso = "Perfil atualizado com sucesso!";
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="css/style.css">
        <script>
            const temaSalvo = localStorage.getItem('tema') || 'light';
            document.documentElement.setAttribute('data-bs-theme', temaSalvo);
        </script>
        <meta charset="UTF-8">
        <title>Meu Perfil</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-light">

        <div class="container mt-5">
            <div class="card p-4 shadow">

                <h3>Editar Perfil</h3>

                <?php if(isset($sucesso)): ?>
                    <div class="alert alert-success"><?php echo $sucesso; ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label>Nome</label>
                        <input type="text" name="nome" class="form-control" value="<?php echo $usuario['nome']; ?>">
                    </div>

                    <button class="btn btn-primary">Salvar Alterações</button>
                </form>

            </div>
        </div>

    </body>
</html>
