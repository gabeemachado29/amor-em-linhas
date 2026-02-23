<?php
session_start();

if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(isset($_POST['tema'])){
        $_SESSION['tema'] = $_POST['tema'];
    }

    if(isset($_POST['idioma'])){
        $_SESSION['idioma'] = $_POST['idioma'];
    }

    $msg = "Configurações salvas!";
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Configurações</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="<?php echo ($_SESSION['tema'] ?? 'light') == 'dark' ? 'bg-dark text-white' : 'bg-light'; ?>">

<div class="container mt-5">
<div class="card p-4 shadow">

<h3>Configurações</h3>

<?php if(isset($msg)): ?>
<div class="alert alert-success"><?php echo $msg; ?></div>
<?php endif; ?>

<form method="POST">

<div class="mb-3">
<label>Tema</label>
<select name="tema" class="form-select">
<option value="light">Claro</option>
<option value="dark">Escuro</option>
</select>
</div>

<div class="mb-3">
<label>Idioma</label>
<select name="idioma" class="form-select">
<option value="pt">Português</option>
<option value="en">English</option>
<option value="es">Español</option>
</select>
</div>

<div class="mb-3">
<label>Receber Notificações por Email</label>
<select class="form-select">
<option>Sim</option>
<option>Não</option>
</select>
</div>

<button class="btn btn-primary">Salvar</button>

</form>

</div>
</div>

</body>
</html>
