<?php
session_start();
include_once "../encabezado.php";
require_once "departamento.php";
require_once "../conex.php"; // Contiene $conexion como PDO

$mensaje = "";

// Manejar POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $departamentoObj = new Departamento(
        $conexion,
        trim($_POST['nombre']),
        trim($_POST['descripcion']),
        trim($_POST['telefono']),
        trim($_POST['email']),
        trim($_POST['responsable']),
        trim($_POST['ubicacion'])
    );

    if ($departamentoObj->crear()) {
        $mensaje = "Departamento agregado exitosamente.";
    } else {
        $mensaje = "Error al agregar departamento.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Crear Departamento</title>
</head>
<body background="../assets/resources/fondo4.png">
<div class="form-container" align="center">
    <h1><b>Nuevo Departamento</b></h1>

    <?php if($mensaje) { ?>
        <div class="alert alert-info"><?php echo $mensaje; ?></div>
    <?php } ?>

    <form method="post" action="">
        <label for="nombre">Nombre del departamento:</label>
        <input class="form-control" name="nombre" required type="text" id="nombre" placeholder="Nombre del departamento">

        <label for="descripcion">Descripción:</label>
        <textarea class="form-control" name="descripcion" id="descripcion" rows="4" placeholder="Describe las funciones del departamento"></textarea>


            <div>
                <label for="telefono">Teléfono:</label>
                <input class="form-control" name="telefono" type="text" id="telefono" placeholder="Teléfono">
            </div>


        <label for="email">Correo electrónico:</label>
        <input class="form-control" name="email" type="email" id="email" placeholder="ejemplo@empresa.com">

        <label for="responsable">Responsable:</label>
        <input class="form-control" name="responsable" type="text" id="responsable" placeholder="Nombre del encargado">

        <label for="ubicacion">Ubicación:</label>
        <input class="form-control" name="ubicacion" type="text" id="ubicacion" placeholder="Edificio, piso, oficina...">

        <br>
        <button type="submit">
            <img src="../assets/resources/guardar.png" width="40" height="40"><br><b>Guardar</b>
        </button>
    </form>
</div>
</body>
</html>
<?php include_once "../pie.php"; ?>
