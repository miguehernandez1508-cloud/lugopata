<?php
session_start();
include_once "../encabezado.php";
require_once "../conex.php";

// Obtener lista de trabajadores
$trabajadores = $conexion->query("SELECT id_trabajador, nombre, apellido FROM trabajadores")->fetchAll(PDO::FETCH_OBJ);
?>
<?php if (isset($_GET['exito']) && $_GET['exito'] == 1){ ?>
    <div class="alert alert-success text-center mt-3">
        <strong>Usuario creado con éxito</strong>
    </div>
<?php } ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Crear Usuario</title>

</head>
<body >
    <div class="form-container" align="center">
        <h1><b>Crear Usuario</b></h1>
        <form method="post" action="nuevousuario.php">
            <label for="usuario">Usuario:</label>
            <input class="form-control" name="usuario" required type="text" id="usuario" placeholder="Escribe el Usuario">    

            <label for="contrasena">Contraseña:</label>
            <input class="form-control" name="contrasena" required type="password" id="contrasena" placeholder="Escribe la contraseña">    

            <label for="correo">Correo electrónico:</label>
            <input class="form-control" name="correo" required type="email" id="correo" placeholder="Escribe su correo electrónico">

            <label for="nivel">Nivel de acceso:</label>
            <select class="form-control" name="nivel" id="nivel">
                <option value="admin">Gerente</option>
                <option value="obrero">Obrero</option>
            </select>

            <label for="trabajador">Trabajador:</label>
            <select class="select-wrapper" name="id_trabajador" id="trabajador">
                <?php foreach ($trabajadores as $t) { ?>
                    <option value="<?= $t->id_trabajador ?>"><?= $t->nombre . " " . $t->apellido ?></option>
                <?php } ?>
            </select>

            <button type="form-container ">
                <img src="../assets/resources/guardar.png" width="40" height="40"><br><b>Guardar</b>
            </button>
        </form>
    </div>
</body>
</html>
<?php include_once "../pie.php"; ?>