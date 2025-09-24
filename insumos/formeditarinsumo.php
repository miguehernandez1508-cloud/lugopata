<?php
session_start();
require_once "../conex.php";
require_once "insumo.php";
include_once "../encabezado.php";

if (!isset($_GET['id'])) {
    exit("No se especificó el insumo.");
}

$insumoObj = new Insumo($conexion);
$insumo = $insumoObj->obtener($_GET['id']);

if (!$insumo) {
    exit("Insumo no encontrado.");
}

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $unidad_medida = $_POST['unidad_medida'];
    $cantidad = $_POST['cantidad'];
    $imagenNombre = $insumo->imagen; // mantener imagen actual por defecto

    // Manejo de imagen nueva
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $carpetaDestino = "../assets/imagenes/insumos/";
        if (!is_dir($carpetaDestino)) mkdir($carpetaDestino, 0777, true);
        $imagenNombre = time() . "_" . $_FILES['imagen']['name'];
        move_uploaded_file($_FILES['imagen']['tmp_name'], $carpetaDestino . $imagenNombre);
    }

    $insumoActualizar = new Insumo($conexion, $insumo->id_insumo, $nombre, $descripcion, $unidad_medida, $cantidad, $imagenNombre);

    if ($insumoActualizar->actualizar($insumo->id_insumo)) {
        $mensaje = "Insumo actualizado correctamente.";
        $insumo = $insumoActualizar->obtener($insumo->id_insumo); // refrescar datos
    } else {
        $mensaje = "Error al actualizar el insumo.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Insumo</title>
</head>
<body>
    <div class="form-container" align="center">
    <h1><b>Editar Insumo <?= $insumo->nombre ?></b></h1>

    <?php if($mensaje) echo "<p>$mensaje</p>"; ?>

    <form method="post" action="" enctype="multipart/form-data">
        <label>ID del Insumo:</label>
        <input type="text" name="id_insumo" value="<?= $insumo->id_insumo ?>" readonly>

        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?= $insumo->nombre ?>" required>

        <label>Descripción:</label>
        <textarea name="descripcion" style="width:400px; height:150px;"><?= $insumo->descripcion ?></textarea>

        <label>Unidad de medida:</label>
        <select name="unidad_medida" required>
            <option value="Litros" <?= $insumo->unidad_medida=="Litros"?"selected":"" ?>>Litros</option>
            <option value="Kilos" <?= $insumo->unidad_medida=="Kilos"?"selected":"" ?>>Kilos</option>
            <option value="Metros" <?= $insumo->unidad_medida=="Metros"?"selected":"" ?>>Metros</option>
            <option value="Unidades" <?= $insumo->unidad_medida=="Unidades"?"selected":"" ?>>Unidades</option>
        </select>

        <label>Cantidad:</label>
        <input type="number" name="cantidad" step="0.01" value="<?= $insumo->cantidad ?>" required>

        <label>Imagen actual:</label>
        <?php if($insumo->imagen): ?>
            <img src="../assets/imagenes/insumos/<?= $insumo->imagen ?>" width="80">
        <?php else: ?>
            Sin imagen
        <?php endif; ?>
            <br>
        <label>Subir nueva imagen:</label>
        <input type="file" name="imagen" accept="image/*">

        <button type="submit">Actualizar</button>
    </form>
</div>
</body>
</html>
