<?php
session_start();
require_once "../conex.php"; // tu conexión PDO

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['email'])) {
    $email = $_POST['email'];

    // Buscar usuario por correo
    $sql = "SELECT id_usuario, username FROM usuarios WHERE email = ? LIMIT 1";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_OBJ);

    if ($usuario) {
        // Generar token
        $token = bin2hex(random_bytes(16));
        $expiracion = date("Y-m-d H:i:s", strtotime("+1 hour"));

        // Guardar token en DB
        $sqlInsert = "INSERT INTO recuperacion (usuario_id, token, expiracion) VALUES (?, ?, ?)";
        $stmtInsert = $conexion->prepare($sqlInsert);
        $stmtInsert->execute([$usuario->id_usuario, $token, $expiracion]);

        // Enviar correo
        $enlace = "http://localhost/lugopata/cambiarcontrasena.php?token=$token";
        $asunto = "Recuperación de contraseña";
        $mensaje = "Hola $usuario->username,\n\nHaz clic en el siguiente enlace para cambiar tu contraseña:\n$enlace\n\nEl enlace expira en 1 hora.";
        $headers = "From: Lugopata@Gmail.com";

        if(mail($email, $asunto, $mensaje, $headers)){
            echo "Se envió un correo con instrucciones.";
        } else {
            echo "Error al enviar correo. Verifica tu servidor SMTP.";
        }
    } else {
        echo "Correo no registrado.";
    }
} else {
    header("Location: formrecuperar.php");
    exit;
}
?>
