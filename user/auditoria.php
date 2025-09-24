<?php
require_once "../conex.php";

class Auditoria {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function registrar($accion, $usuario = null, $detalle = null) {
        $sql = "INSERT INTO auditoria (accion, usuario, detalle) VALUES (?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$accion, $usuario, $detalle]);
    }
}
?>