<?php
session_start();
include_once "user/gestorsesion.php";
GestorSesiones::iniciar();
include_once "encabezado.php";
require_once "conex.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/estilo.css">
    <script src="assets/css/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/js/bootstrap.min.css">
</head>
<body >
    

<div class="form-container" align="center">
            <b><h1>¡Bienvenido<b>    <?php echo isset($_SESSION['name']) ? ($_SESSION['name']) : htmlspecialchars($_SESSION['username']); ?>!</h1>
            <p>Tu nivel de acceso es: <strong><?php echo ($_SESSION['nivel']); ?></strong></p>
            <?php echo $_SESSION['nombre_completo']."hola";  ?>
            
</div>

</body>
</html>
<?php include_once "pie.php"; ?>