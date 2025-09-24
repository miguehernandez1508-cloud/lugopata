<?php
session_start();
require_once "auditoria.php";
require_once "usuario.php";
require_once "../conex.php";

// Validar datos del formulario
if (!isset($_POST["usuario"], $_POST["contrasena"],$_POST["correo"], $_POST["nivel"], $_POST["id_trabajador"])) {
    exit("Faltan datos del formulario");
}

// Crear usuario con los datos
$usuario = new Usuario(
    $_POST["usuario"],
    $_POST["contrasena"],
    $_POST["correo"],
    $_POST["nivel"],
    $_POST["id_trabajador"]
);


if ($usuario->guardar($conexion)) {

    // Registrar auditoría
    $auditoria = new Auditoria($conexion);
    $auditoria->registrar(
        'Creacion de usuario',
        $_POST["usuario"],
        "Usuario creado con ID trabajador: " . $_POST["id_trabajador"]
    );
    
    header("Location: formcrearusuario.php?exito=1");
    exit;
} else {
    echo "Error al guardar el usuario.";
}