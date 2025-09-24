<?php
require_once "../conex.php";

$query = $_GET['query'] ?? '';
$query = "%$query%";

$stmt = $conexion->prepare("SELECT id_insumo, nombre, unidad_medida FROM insumos WHERE id_insumo LIKE ? OR nombre LIKE ? LIMIT 1");
$stmt->execute([$query, $query]);
$insumo = $stmt->fetch(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($insumo);
