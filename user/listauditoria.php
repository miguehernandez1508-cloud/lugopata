<?php
session_start();
include_once "../encabezado.php";
require_once "gestorsesion.php";
require_once "../conex.php";

// Validar que el usuario esté logueado y sea admin
GestorSesiones::iniciar();
if (!isset($_SESSION['nivel']) || $_SESSION['nivel'] !== 'admin') {
    exit("No tienes permisos para acceder a esta página.");
}

// Definir cuántos registros mostrar por página
$registrosPorPagina = 10;

// Saber en qué página estamos (por GET, por defecto la 1)
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
if ($pagina < 1) $pagina = 1;

// Calcular desde qué registro empezar
$inicio = ($pagina - 1) * $registrosPorPagina;

// Obtener total de registros para calcular páginas
$totalRegistros = $conexion->query("SELECT COUNT(*) FROM auditoria")->fetchColumn();
$totalPaginas = ceil($totalRegistros / $registrosPorPagina);

// Obtener solo los registros de la página actual
$stmt = $conexion->prepare("SELECT * FROM auditoria ORDER BY fecha DESC LIMIT :inicio, :registros");
$stmt->bindValue(':inicio', $inicio, PDO::PARAM_INT);
$stmt->bindValue(':registros', $registrosPorPagina, PDO::PARAM_INT);
$stmt->execute();
$auditoria = $stmt->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Auditoría</title>
</head>
<body background="../assets/resources/fondo4.png">
    <div class="container py-5">
        <!-- Encabezado -->
        <div class="form-container" align="center" style="background-color: rgba(255, 255, 255, 0.95); border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.2); border: 3px solid black; max-width: 500px; margin: 20px auto; padding: 20px;">
            <div class="text-center mb-4">
                <h1 class="fw-bold text-primary">
                    <img src="../assets/resources/cuaderno.png" alt="Cuaderno" width="40">
                    Registro de Auditoría
                </h1>
                <p class="text-muted">Historial completo de actividades realizadas en el sistema</p>
            </div>
        </div>

        <!-- Tarjeta contenedora -->
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-body">
                <div class="table-responsive">
                    <div class="tabla-auditoria">
                        <table class="table table-bordered table-hover align-middle text-center">
                            <thead class="table-primary">
                                <tr>
                                    <th>ID</th>
                                    <th>Acción</th>
                                    <th>Usuario</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody class="table-light">
                                <?php foreach ($auditoria as $a) { ?>
                                <tr>
                                    <td class="fw-bold"><?= $a->id_auditoria ?></td>
                                    <td><?= ($a->accion) ?></td>
                                    <td><span class="badge bg-info text-dark"><?= ($a->usuario) ?></span></td>
                                    <td><span class="text-secondary small"><?= $a->fecha ?></span></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- PAGINACIÓN -->
                <nav aria-label="Paginación auditoría">
                    <ul class="pagination justify-content-center">
                        <!-- Botón "Anterior" -->
                        <li class="page-item <?= $pagina <= 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="?pagina=<?= $pagina - 1 ?>">Anterior</a>
                        </li>

                        <!-- Números de página -->
                        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                            <li class="page-item <?= $pagina == $i ? 'active' : '' ?>">
                                <a class="page-link" href="?pagina=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>

                        <!-- Botón "Siguiente" -->
                        <li class="page-item <?= $pagina >= $totalPaginas ? 'disabled' : '' ?>">
                            <a class="page-link" href="?pagina=<?= $pagina + 1 ?>">Siguiente</a>
                        </li>
                    </ul>
                </nav>

                <!-- Botón de volver -->
                <div class="text-center mt-4">
                    <button onclick="history.back()" class="btn btn-secondary">
                        <h4>
                            <img src="../assets/resources/volver.png" alt="Volver" width="30" height="30">
                            Volver
                        </h4>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS desde tus archivos -->
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>