<?php
session_start();
include "includes/navbar.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $_SESSION['lang'] = $_POST['idioma'];
}
?>

<div class="container mt-5">
<h3>Configurações</h3>

<form method="POST" class="card p-4 shadow-sm">
<select name="idioma" class="form-select mb-3">
<option value="pt">Português</option>
<option value="en">English</option>
</select>

<button class="btn btn-primary">Salvar Idioma</button>
</form>

<hr>

<button onclick="alternarTema()" class="btn btn-dark">
Alternar Tema
</button>

</div>

<?php include "scripts.php"; ?>
