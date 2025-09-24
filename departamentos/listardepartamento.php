<?php
session_start();
include_once "../encabezado.php";
require_once "departamento.php";
require_once "../conex.php";
require_once "../user/gestorsesion.php";

// Validación de sesión
GestorSesiones::iniciar();
if (!isset($_SESSION['nivel']) || $_SESSION['nivel'] !== 'admin') {
    exit("No tienes permisos para acceder a esta página.");
}

// Parámetros de paginación
$registrosPorPagina = 10;
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
if ($pagina < 1) $pagina = 1;
$inicio = ($pagina - 1) * $registrosPorPagina;

$departamentoObj = new Departamento($conexion);
$totalRegistros = $departamentoObj->contar();
$totalPaginas = ceil($totalRegistros / $registrosPorPagina);

$departamentos = $departamentoObj->listar($inicio, $registrosPorPagina);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Departamentos</title>
</head>
<body background="../assets/resources/fondo4.png">
<div class="container py-5">

    <!-- Encabezado y botón agregar -->
    <div class="form-container text-center mb-4" style="background-color: rgba(255, 255, 255, 0.95); border-radius: 20px; padding: 20px; border: 3px solid black;">
        <h1 class="fw-bold text-primary">
            <img src="../assets/resources/departamentos.png" alt="Departamentos" width="40">
            Lista de Departamentos
        </h1>
        <p class="text-muted">Gestión de departamentos del sistema</p>
        <a href="formcreardepartamento.php" class="btn btn-success">
            <img src="../assets/resources/cdepartamentos.png" width="25"> Agregar nuevo departamento
        </a>
    </div>

    <!-- Tabla -->
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-body">
            <div class="table-responsive" style="background-color: white; border-radius: 10px; padding: 10px;">
    <table class="table table-bordered table-hover text-center align-middle">
        <thead class="table-primary">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Ubicación</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody class="table-light">
            <?php foreach ($departamentos as $d): ?>
            <tr>
                <td class="fw-bold"><?= $d->id_departamento ?></td>
                <td><?= $d->nombre ?></td>
                <td><?= $d->descripcion ?></td>
                <td><?= $d->ubicacion ?></td>
                <td><?= $d->telefono ?></td>
                <td><?= $d->email ?></td>
                <td>
                    <a href="formeditardepartamento.php?id=<?= $d->id_departamento ?>" class="btn btn-warning btn-sm"><img src="/lugopata/assets/resources/cdepartamento.png" height="30">Actualizar</a>
                    <a href="eliminardepartamento.php?id=<?= $d->id_departamento ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este departamento?')"><img src="/lugopata/assets/resources/eliminar.png" height="30">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

            <!-- Paginación -->
            <nav>
                <ul class="pagination justify-content-center">
                    <li class="page-item <?= $pagina <= 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="?pagina=<?= $pagina - 1 ?>">Anterior</a>
                    </li>
                    <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                        <li class="page-item <?= $pagina == $i ? 'active' : '' ?>">
                            <a class="page-link" href="?pagina=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?= $pagina >= $totalPaginas ? 'disabled' : '' ?>">
                        <a class="page-link" href="?pagina=<?= $pagina + 1 ?>">Siguiente</a>
                    </li>
                </ul>
            </nav>

        </div>
    </div>
</div>
</body>
</html>
