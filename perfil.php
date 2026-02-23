<?php
require_once "config/database.php";
session_start();
include "includes/navbar.php";

$stmt = $db->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$_SESSION['usuario_id']]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nome = $_POST['nome'];
    $db->prepare("UPDATE usuarios SET nome=? WHERE id=?")
       ->execute([$nome,$_SESSION['usuario_id']]);
    $_SESSION['usuario_nome'] = $nome;
    header("Location: perfil.php");
}
?>

<div class="container mt-5">
<h3>Editar Perfil</h3>

<form method="POST" class="card p-4 shadow-sm">
<input type="text" name="nome"
class="form-control mb-3"
value="<?php echo $usuario['nome']; ?>">
<button class="btn btn-primary">Salvar</button>
</form>
</div>

<?php include "scripts.php"; ?>
