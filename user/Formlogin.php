<?php 
session_start();
?>
<?php 
if (!empty($_SESSION['status']) && $_SESSION['status'] == 1) {
?>
    <div class="alert alert-danger text-center mt-3">
        <strong>Error de Usuario o Contraseña</strong>
    </div>
<?php
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inicio de sesión</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css"> <!-- Bootstrap local -->
    <link rel="stylesheet" href="../assets/css/2.css">
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
                <img src="../assets/resources/inicio1.png" width="100" height="100" alt="Inicio Sesión">
            </div>

            <form action="implementar.php" method="POST" autocomplete="off">
                <h1 class="text-center mb-3"><b>Inicio de sesión</b></h1>
                <hr>

                <div class="mb-4">
                    <label for="username" class="form-label">
                        <img src="../assets/resources/in.png" width="24" height="24" alt="Usuario"> Nombre
                    </label>
                    <input type="text" name="username" class="form-control" required placeholder="Ingresa el nombre de usuario">
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">
                        <img src="../assets/resources/contra.png" width="30" height="30" alt="Contraseña"> Contraseña
                    </label>
                    <input type="password" name="password" class="form-control" required placeholder="Ingresar la contraseña">
                </div>

                <div class="d-flex justify-content-around">
                    <input type="submit" name="login_button" class="btn btn-primary" value="Acceder">
                    <input type="reset" name="limpiar" value="Limpiar" class="btn btn-secondary" style="background-color: #2a2828; color: white;">
                </div>
                <br>

                <center>
                    <div onclick="window.location.href='formrecuperar.php'" 
                         title="Se enviará un código a su correo registrado" 
                         style="display:inline-block; text-align:center; cursor:pointer; transition: transform 0.2s;"
                         onmouseover="this.style.transform='scale(1.2)';" 
                         onmouseout="this.style.transform='scale(1)';">
                        <img src="../assets/resources/token.png" alt="Token" width="60" height="60">
                        <div><strong>¿Olvidó su Usuario y/o Contraseña?</strong></div>
                    </div>
                </center>
            </form>
        </div>
    </div>
</body>
</html>
