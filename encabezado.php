<?php
require_once "user/gestorsesion.php";

// Validar que el usuario esté logueado
/* if (!isset($_SESSION['nivel']) || !isset($_SESSION['username'])) {

    exit;
} */

$nivel = $_SESSION['nivel'];
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/lugopata/assets/css/2.css">
    <link rel="stylesheet" href="/lugopata/assets/css/estilo.css">
    <link rel="stylesheet" href="/lugopata/assets/css.css">

            <style>
        body {
            background: url("/lugopata/assets/resources/fondof.png") no-repeat center center fixed;
            background-size: cover;

        }
    </style>
</head>
<body>

<div class="header">
    <div class="header-left">
        <!-- Logo -->
        <div class="logo">
            <a href ="/lugopata/dashboard.php"><img src="/lugopata/assets/resources/logo.png" alt="Logotipo"></a>
        </div>

        <!-- Botón desplegable Usuario -->
        <div class="dropdown">
            <button class="dropbtn">
                <img src="/lugopata/assets/resources/cusuario.png" alt="Usuario"> Usuario
            </button>
            <div class="dropdown-content">
                <?php if($nivel === 'admin'){ ?>
                    <a href="/lugopata/user/formcrearusuario.php"><img src="/lugopata/assets/resources/nusuario.png " width="30">Crear Usuario</a>
                    <a href="/lugopata/user/listauditoria.php"><img src="/lugopata/assets/resources/cuaderno.png " width="30">Auditoría de Usuario</a>
                <?php } ?>

            </div>
        </div>
        <div class="dropdown">
            <button class="dropbtn">
                <img src="/lugopata/assets/resources/trabajador.png" alt="Usuario"> Trabajadores
            </button>
            <div class="dropdown-content">
                <?php if($nivel === 'admin'){ ?>
                    <a href="/lugopata/trabajador/formctrabajador.php">
                        <img src="/lugopata/assets/resources/creartrabajador.png" width="20" alt="Usuario">Crear Trabajador</a>
                <?php } ?>
            </div>
        </div>
        <div class="dropdown">
            <button class="dropbtn">
                <img src="/lugopata/assets/resources/insumos.png" alt="Usuario"> Insumos
            </button>
            <div class="dropdown-content">
                <?php if($nivel === 'admin'){ ?>
                    <a href="/lugopata/insumos/formsolicitudinsumos.php">
                        <img src="/lugopata/assets/resources/sinsumos.png" width="20" alt="Usuario">Solicitar Insumos</a>
                    <a href="/lugopata/insumos/formcrearinsumo.php">
                        <img src="/lugopata/assets/resources/cinsumo.png" width="20" alt="Usuario">Crear Insumos</a>
                    <a href="/lugopata/insumos/listarinsumos.php">
                        <img src="/lugopata/assets/resources/linsumos.png" width="20" alt="Usuario">Listar Insumos</a>
                <?php } ?>
            </div>
        </div>
                <div class="dropdown">
            <button class="dropbtn">
                <img src="/lugopata/assets/resources/departamentos.png" alt="Usuario"> Departamentos
            </button>
            <div class="dropdown-content">
                <?php if($nivel === 'admin'){ ?>
                    <a href="/lugopata/departamentos/formcreardepartamentos.php">
                        <img src="/lugopata/assets/resources/cdepartamento.png" width="20" alt="Usuario">Crear departamento</a>
                        <a href="/lugopata/departamentos/listardepartamento.php">
                        <img src="/lugopata/assets/resources/ldepartamento.png" width="20" alt="Usuario">Listar Departamentos</a>
                <?php } ?>
            </div>
        </div>
    </div>
<div class="header-right"><center>
<a href="/lugopata/user/cerrarsesion.php" 
   onclick="return confirm('¿Seguro que quieres cerrar sesión?');">
  <img src="/lugopata/assets/resources/cerrarsesion.png" alt="Cerrar Sesión" style="width:40px; height:40px;"> 
</a>
<br><h5>Cerrar sesion</h5>
</center>
</div>
</div>
