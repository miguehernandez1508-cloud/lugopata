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

    if ($departamento->actualizar($_POST['id'])) {
        header("Location: listardepartamentos.php?mensaje=Departamento actualizado");
    } else {
        header("Location: formeditardepartamento.php?id=".$_POST['id']."&error=No se pudo actualizar");
    }
    exit();
}
?>
