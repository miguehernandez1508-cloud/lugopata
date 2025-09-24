<?php
require_once "gestorsesion.php";
require_once "login.php";
require_once "../conex.php"; // debe devolver $conexion como PDO

GestorSesiones::iniciar();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['username'] ?? '';
    $clave = $_POST['password'] ?? '';

    // Crear instancia de Login con la conexión PDO
    $login = new Login($conexion);

    if ($login->validarUsuario($nombre, $clave)) {
        header("Location: ../dashboard.php");
        exit;
    } else {
        // Redirigir al login con el error activado
        header("Location: Formlogin.php");
        exit;
    }
}
?>
<?php
// Si no es POST, redirigir al formulario de login