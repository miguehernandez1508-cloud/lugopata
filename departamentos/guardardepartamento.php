<?php
session_start();
require_once "../conex.php";
require_once "departamento.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $departamento = new Departamento(
        $conexion,
        trim($_POST['nombre']),
        trim($_POST['descripcion']),
        trim($_POST['ubicacion']),
        trim($_POST['telefono']),
        trim($_POST['email'])
    );

    if ($departamento->crear()) {
        header("Location: listardepartamentos.php?mensaje=Departamento creado correctamente");
    } else {
        header("Location: formcrearDepartamento.php?error=No se pudo crear el departamento");
    }
    exit();
}
?>
