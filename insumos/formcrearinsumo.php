<?php
session_start();
include_once "../encabezado.php";
require_once "../conex.php";
require_once "Insumo.php";

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_insumo = $_POST['id_insumo'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $unidad_medida = $_POST['unidad_medida'];
    $cantidad = $_POST['cantidad'];
    $imagenNombre = NULL;

    // Manejo de imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $carpetaDestino = "../assets/imagenes/insumos/";
        if (!is_dir($carpetaDestino)) {
            mkdir($carpetaDestino, 0777, true);
        }
        $imagenNombre = time() . "_" . $_FILES['imagen']['name'];
        move_uploaded_file($_FILES['imagen']['tmp_name'], $carpetaDestino . $imagenNombre);
    }

    $insumo = new Insumo($conexion, $id_insumo, $nombre, $descripcion, $unidad_medida, $cantidad, $imagenNombre);

    if ($insumo->crear()) {
        $mensaje = "Insumo registrado correctamente.";
    } else {
        $mensaje = "Error al registrar insumo.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Agregar Insumo</title>
</head>
<body>

<div class="form-container" align="center">
    <h1><b>Registrar Nuevo Insumo</b></h1>

    <?php if($mensaje) { echo "<p>$mensaje</p>"; } ?>

<form method="post" action="" enctype="multipart/form-data">
    <label for="id_insumo">ID del Insumo:</label>
    <input type="text" name="id_insumo" id="id_insumo" required placeholder="Ej: MAT001">

    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" id="nombre" required>

    <label for="descripcion">Descripción:</label>
    <textarea name="descripcion" id="descripcion" style="width: 600px; height: 150px;"></textarea>
    <br>
    <label for="unidad_medida">Unidad de medida:</label>
    <select name="unidad_medida" id="unidad_medida" required>
        <option value="">Seleccione...</option>
        <option value="Litros">Litros</option>
        <option value="Kilos">Kilos</option>
        <option value="Metros">Metros</option>
        <option value="Unidades">Unidades</option>
    </select>

    <label for="cantidad">Cantidad inicial:</label>
    <input type="number" name="cantidad" id="cantidad" step="0.01" value="0" required>

    <label for="imagen">Imagen del insumo:</label>
    <input type="file" name="imagen" id="imagen" accept="image/*">

    <button type="submit">Guardar</button>
</form>

</div>
</body>
</html>
