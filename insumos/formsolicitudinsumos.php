<?php
session_start();
include_once "../encabezado.php";
require_once "../conex.php";
require_once "../user/gestorsesion.php";
require_once "solicitud.php";
require_once "insumo.php";
require_once "../user/gestorsesion.php";
// Validación de sesión
GestorSesiones::iniciar();

$mensaje = "";


// Obtener departamentos
$departamentos = $conexion->query("SELECT id_departamento, nombre FROM departamentos")->fetchAll(PDO::FETCH_ASSOC);

// Obtener nombre del emisor
$emisorNombre = $_SESSION['nombre_completo'];
// Manejar POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $solicitud = new Solicitud($conexion);
    $solicitud->fecha = $_POST['fecha'];
    $solicitud->emisor = $emisorNombre; // Emisor actual
    $solicitud->receptor = $_POST['receptor'];
    $solicitud->departamento_emisor = $_POST['emisor_dep'];
    $solicitud->departamento_destino = $_POST['receptor_dep'];
    $solicitud->descripcion = $_POST['descripcion'];

    $materiales = $_POST['materiales']; // Array de materiales

    $id_solicitud = $solicitud->crearSolicitud();
    if ($id_solicitud) {
        $solicitud->agregarDetalle($id_solicitud, $materiales);
        // Aquí antes mostrabas un mensaje
        $mensaje = "Solicitud registrada exitosamente.";
        // NUEVO: redirigir a PDF / impresión
        header("Location: imprimirsolicitud.php?id=$id_solicitud");
        exit;
    } else {
        $mensaje = "Error al guardar la solicitud.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nueva Solicitud de Material</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top:10px; }
        th, td { border:1px solid #ccc; padding:5px; text-align:center; }
        .btn { padding:5px 10px; cursor:pointer; }
        input[type=text], input[type=number] { width: 100%; }
    </style>
</head>
<body>
<div class="form-container" align="center">
<h1><b>Nueva Solicitud de Material</b></h1>
<?php if($mensaje) echo "<p>$mensaje</p>"; ?>


<form method="post" action="" id="solicitudForm">
    <label>Fecha:</label>
    <input type="date" name="fecha" value="<?= date('Y-m-d') ?>" readonly>

    <label>Departamento emisor:</label>
    <select name="emisor_dep" required>
        <option value="">Seleccione...</option>
        <?php foreach ($departamentos as $dep) echo "<option value='{$dep['id_departamento']}'>{$dep['nombre']}</option>"; ?>
    </select>

        <label>Departamento de destino:</label>
    <select name="receptor_dep" required>
        <option value="">Seleccione...</option>
        <?php foreach ($departamentos as $dep) echo "<option value='{$dep['id_departamento']}'>{$dep['nombre']}</option>"; ?>
    </select>

    <label>Receptor:</label>
    <input type="text" name="receptor" required>

    <label>Descripción general:</label>
    <textarea name="descripcion" style="width:400px; height:100px;"></textarea>

    <h3>Insumos</h3>
    <table id="tablaMateriales">
        <thead>
            <tr>
                <th>Código/Nombre</th>
                <th>Unidad</th>
                <th>Cant. pedida</th>
                <th>Cant. recibida</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <button type="button" class="btn" onclick="agregarFila()">Agregar material</button>
    <br><br>
    <button type="submit">Guardar solicitud</button>
</form>
</div>

<script>
// Función para agregar fila
function agregarFila() {
    const tbody = document.querySelector("#tablaMateriales tbody");
    const index = tbody.children.length;
    const fila = document.createElement("tr");

    fila.innerHTML = `
        <td>
            <input type="text" name="materiales[${index}][codigo]" placeholder="Código o nombre" required onblur="autocompletar(this, ${index})">
            <input type="hidden" name="materiales[${index}][id_insumo]">
        </td>
        <td><input type="text" name="materiales[${index}][unidad]" readonly></td>
        <td><input type="number" name="materiales[${index}][cantidad_pedida]" step="0.01" required></td>
        <td><input type="number" name="materiales[${index}][cantidad_recibida]" step="0.01" value="0"></td>
        <td><button type="button" onclick="this.closest('tr').remove()">X</button></td>
    `;
    tbody.appendChild(fila);
}

// Función para autocompletar unidad según material
function autocompletar(input, index) {
    const codigo = input.value.trim();
    if(codigo === "") return;
    
    fetch(`buscarInsumo.php?query=${codigo}`)
    .then(res => res.json())
    .then(data => {
        if(data) {
            input.nextElementSibling.value = data.id_insumo; // hidden id
            document.querySelector(`input[name='materiales[${index}][unidad]']`).value = data.unidad_medida;
        } else {
            input.nextElementSibling.value = "";
            document.querySelector(`input[name='materiales[${index}][unidad]']`).value = "";
            alert("Material no encontrado");
        }
    });
}
</script>
</body>
</html>
