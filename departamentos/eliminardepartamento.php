<?php
session_start();
require_once "../conex.php";
require_once "departamento.php";

if (isset($_GET['id'])) {
    $departamento = new Departamento($conexion);
    if ($departamento->eliminar($_GET['id'])) {
        header("Location: listardepartamentos.php?mensaje=Departamento eliminado");
    } else {
        header("Location: listardepartamentos.php?error=No se pudo eliminar");
    }
    exit();
}
?>
