<?php
session_start();
require_once "../conex.php";
require_once "usuario.php"; // para usar la clase Usuario

$token = $_GET['token'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tokenPost = $_POST['token'];
    $nuevaClave = $_POST['password'];

    // Verificar token
    $sql = "SELECT r.usuario_id FROM recuperacion r WHERE r.token = ? AND r.expiracion >= NOW() LIMIT 1";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$tokenPost]);
    $fila = $stmt->fetch(PDO::FETCH_OBJ);

    if ($fila) {
        // Cambiar contraseña
        $sqlUser = "SELECT username FROM usuarios WHERE id_usuario = ?";
        $stmtUser = $conexion->prepare($sqlUser);
        $stmtUser->execute([$fila->usuario_id]);
        $usuario = $stmtUser->fetch(PDO::FETCH_OBJ);

        $user = new Usuario($usuario->username, $nuevaClave, "", "", 0); // solo username y password
        $sqlUpdate = "UPDATE usuarios SET password = ? WHERE id_usuario = ?";
        $stmtUpdate = $conexion->prepare($sqlUpdate);
        $stmtUpdate->execute([$user->password, $fila->usuario_id]);

        // Eliminar token
        $sqlDel = "DELETE FROM recuperacion WHERE token = ?";
        $stmtDel = $conexion->prepare($sqlDel);
        $stmtDel->execute([$tokenPost]);

        echo "Contraseña actualizada. Puedes iniciar sesión.";
    } else {
        echo "Token inválido o expirado.";
    }
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cambiar Contraseña</title>
</head>
<body>
    <div align="center">
        <h1>Cambiar Contraseña</h1>
        <form method="post">
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
            <label for="password">Nueva contraseña:</label>
            <input type="password" name="password" id="password" required placeholder="Nueva contraseña">
            <br><br>
            <button type="submit">Cambiar contraseña</button>
        </form>
    </div>
</body>
</html>
