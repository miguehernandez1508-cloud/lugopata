<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Recuperar contraseña</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="../assets/css/estilo.css">
    <meta charset="utf-8">
    <style>
        body {
            background: url("../assets/resources/fondo.png") no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
    <div class="container-fluid d-flex justify-content-center align-items-start" style="margin-top: 120px; color">
        <div class="card shadow-lg rounded-4 p-4" style="max-width: 500px; width: 100%; background-color:#ececec; border: 3px solid powderblue;">
            <div class="d-flex justify-content-end">
                <img src="../assets/resources/logo.png" waidth="70" height="70" alt="Logo">
            </div>
            <div class="text-center mb-3">
                <img src="../assets/resources/recuperar.png" width="100" height="100" alt="Recuperar Contraseña">
            </div>
    <div align="center">
        <h1>Recuperar Contraseña</h1>
        <br>
        <form method="post" action="enviartoken.php">
            <label for="email">Correo electrónico:</label>
            <input class="form-label" type="email" required="" name="email" id="email" required placeholder="Ingresa tu correo"  style="width: 300px; height: 40px; font-size: 16px; padding: 8px;">
            <br><br>
            <button type="submit" class="btn btn-secondary">Enviar enlace</button> <br><br>
            <a href="Formlogin.php" class="btn btn-danger">Volver</a>
        </form>
    </div>
</body>
</html>
