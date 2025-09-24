<?php
session_start();
include_once "../encabezado.php";
require_once "trabajador.php";
require_once "../departamentos/departamento.php";
require_once "../conex.php"; // Contiene $conexion como PDO

$mensaje = "";

// Crear objeto Departamento para listar departamentos
$departamentoObj = new Departamento($conexion);
$departamentos = $departamentoObj->listar(0, 1000); // Tomamos todos los departamentos para el select

// Manejar POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firmaBase64 = $_POST['firma'] ?? '';
    $firmaRuta = null;

    if($firmaBase64){
        $data = explode(',', $firmaBase64);
        $data = base64_decode($data[1]);
        $nombreArchivo = "../assets/imagenes/firmas/firma_" . time() . ".png";
        file_put_contents($nombreArchivo, $data);
        $firmaRuta = $nombreArchivo;
    }

    // Crear trabajador
$trabajadorObj = new Trabajador(
    $conexion,
    trim($_POST['cedula']),
    trim($_POST['nombre']),
    trim($_POST['apellido']),
    trim($_POST['telefono']),
    trim($_POST['direccion']),
    $firmaRuta,                // Ahora sí la firma
    $_POST['id_departamento']  // Ahora sí el departamento
);


    if ($trabajadorObj->crear()) {
        $mensaje = "Trabajador agregado exitosamente.";
    } else {
        $mensaje = "Error al agregar trabajador. Verifica los datos.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Crear Trabajador</title>
    <style>
        .form-container { width: 1000px; margin: 20px auto; background: #f5f5f5; padding: 20px; border-radius: 8px; }
        canvas { border:1px solid #000; background-color:white; cursor: crosshair; }
        .alert { padding: 10px; background-color: #d9edf7; margin-bottom: 15px; border-radius: 5px; }
    </style>
</head>
<body background="../assets/resources/fondo4.png">
<div class="form-container" align="center">
    <h1><b>Nuevo Trabajador</b></h1>

    <?php if($mensaje) { ?>
        <div class="alert alert-info"><?php echo $mensaje; ?></div>
    <?php } ?>

    <form method="post" action="">
        <label for="cedula">Cédula:</label>
        <input class="form-control" name="cedula" required type="number" id="cedula" placeholder="Cédula">

        <label for="nombre">Nombre:</label>
        <input class="form-control" name="nombre" required type="text" id="nombre" placeholder="Nombre">

        <label for="apellido">Apellido:</label>
        <input class="form-control" name="apellido" required type="text" id="apellido" placeholder="Apellido">

        <label for="telefono">Teléfono:</label>
        <input class="form-control" name="telefono" required type="number" id="telefono" placeholder="Teléfono">

        <label for="direccion">Dirección:</label>
        <textarea required id="direccion" name="direccion" cols="30" rows="5" class="form-control"></textarea>

        <label>Firma digital:</label><br>
        <canvas id="canvasFirma" width="400" height="150"></canvas>
        <br>
        <button type="button" onclick="limpiarFirma()">Limpiar</button>
        <input type="hidden" name="firma" id="firma">

        <label for="id_departamento">Departamento:</label>
        <select class="form-control" name="id_departamento" id="id_departamento" required>
            <option value="">-- Seleccione un departamento --</option>
            <?php foreach($departamentos as $d): ?>
                <option value="<?= $d->id_departamento ?>"><?= $d->nombre ?></option>
            <?php endforeach; ?>
        </select>

        <br><br>
        <button type="submit">
            <img src="../assets/resources/guardar.png" width="40" height="40"><br><b>Guardar</b>
        </button>
    </form>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const canvas = document.getElementById("canvasFirma");
    const ctx = canvas.getContext("2d");

    ctx.strokeStyle = "black";
    ctx.lineWidth = 2;
    ctx.lineCap = "round";

    let dibujando = false;

    canvas.addEventListener("mousedown", e => {
        dibujando = true;
        ctx.beginPath();
        ctx.moveTo(e.offsetX, e.offsetY);
    });

    canvas.addEventListener("mousemove", e => {
        if(dibujando){
            ctx.lineTo(e.offsetX, e.offsetY);
            ctx.stroke();
        }
    });

    canvas.addEventListener("mouseup", e => { dibujando = false; });
    canvas.addEventListener("mouseout", e => { dibujando = false; });

    function limpiarFirma(){
        ctx.clearRect(0, 0, canvas.width, canvas.height);
    }

    document.querySelector("form").addEventListener("submit", function(){
        const dataURL = canvas.toDataURL("image/png");
        document.getElementById("firma").value = dataURL;
    });

    window.limpiarFirma = limpiarFirma;
});
</script>

</body>
</html>
<?php include_once "../pie.php"; ?>
