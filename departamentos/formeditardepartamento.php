<?php
session_start();
require_once "../conex.php";
require_once "departamento.php";
include_once "../encabezado.php";

$departamentoObj = new Departamento($conexion);
$d = $departamentoObj->obtener($_GET['id']);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Editar Departamento</title>
</head>
<body background="../assets/resources/fondo4.png">
<div class="form-container" align="center">
    <h1><b>Editar Departamento</b></h1>
    <form method="post" action="actualizardepartamento.php">
        <input type="hidden" name="id" value="<?= $d->id_departamento ?>">

        <label for="nombre">Nombre:</label>
        <input class="form-control" name="nombre" required type="text" value="<?= $d->nombre ?>">

        <label for="descripcion">Descripción:</label>
        <textarea class="form-control" name="descripcion"><?= $d->descripcion ?></textarea>

        <label for="ubicacion">Ubicación:</label>
        <input class="form-control" name="ubicacion" type="text" value="<?= $d->ubicacion ?>">

        <label for="telefono">Teléfono:</label>
        <input class="form-control" name="telefono" type="text" value="<?= $d->telefono ?>">

        <label for="email">Email:</label>
        <input class="form-control" name="email" type="email" value="<?= $d->email ?>">

        <br>
        <button type="submit">Actualizar</button>
    </form>
</div>
</body>
</html>
