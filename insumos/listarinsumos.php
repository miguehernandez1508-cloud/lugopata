<?php
session_start();
include_once "../encabezado.php";
require_once "Insumo.php";
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

$insumoObj = new Insumo($conexion);
$totalRegistros = $conexion->query("SELECT COUNT(*) FROM insumos")->fetchColumn();
$totalPaginas = ceil($totalRegistros / $registrosPorPagina);

// Obtener insumos con límite y offset
$stmt = $conexion->prepare("SELECT * FROM insumos ORDER BY id_insumo DESC LIMIT :inicio, :registros");
$stmt->bindValue(':inicio', $inicio, PDO::PARAM_INT);
$stmt->bindValue(':registros', $registrosPorPagina, PDO::PARAM_INT);
$stmt->execute();
$insumos = $stmt->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Insumos</title>
</head>
<body background="../assets/resources/fondo4.png">
<div class="container py-5">

    <!-- Encabezado y botón agregar -->
    <div class="form-container text-center mb-4" style="background-color: rgba(255, 255, 255, 0.95); border-radius: 20px; padding: 20px; border: 3px solid black;">
        <h1 class="fw-bold text-primary">
            <img src="../assets/resources/insumos.png" alt="Insumos" width="40">
            Lista de Insumos
        </h1>
        <p class="text-muted">Gestión de insumos del sistema</p>
        <a href="formInsumo.php" class="btn btn-success">
            <img src="../assets/resources/cinsumos.png" width="25"> Agregar nuevo insumo
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
                            <th>Unidad</th>
                            <th>Cantidad</th>
                            <th>Imagen</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="table-light">
                        <?php foreach ($insumos as $i): ?>
                        <tr>
                            <td class="fw-bold"><?= $i->id_insumo ?></td>
                            <td><?= $i->nombre ?></td>
                            <td><?= $i->descripcion ?></td>
                            <td><?= $i->unidad_medida ?></td>
                            <td><?= $i->cantidad ?></td>
                            <td>
                                <?php if($i->imagen): ?>
                                    <img src="../assets/imagenes/insumos/<?= $i->imagen ?>" alt="Imagen" width="50">
                                <?php else: ?>
                                    Sin imagen
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="formeditarinsumo.php?id=<?= $i->id_insumo ?>" class="btn btn-warning btn-sm">
                                    <img src="../assets/resources/cinsumos.png" height="30">Actualizar
                                </a>
                                <a href="eliminarinsumo.php?id=<?= $i->id_insumo ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este insumo?')">
                                    <img src="../assets/resources/eliminar.png" height="30">Eliminar
                                </a>
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
