<?php
require_once "../conex.php";

class Solicitud {
    private $conexion;

    public $fecha;
    public $emisor;
    public $receptor;
    public $departamento_emisor;
    public $departamento_destino;
    public $descripcion;



    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // Crear solicitud
// Crear solicitud
public function crearSolicitud() {
    try {
        $sql = "INSERT INTO solicitud_materiales(fecha, emisor, receptor, departamento_emisor, departamento_destino, descripcion)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([
            $this->fecha,
            $this->emisor,
            $this->receptor,
            $this->departamento_emisor,
            $this->departamento_destino,
            $this->descripcion
        ]);
        return $this->conexion->lastInsertId();
    } catch (PDOException $e) {
        echo "Error SQL solicitud: " . $e->getMessage();
        return false;
    }
}


    // Crear detalle de solicitud
    public function agregarDetalle($id_solicitud, $materiales) {
        try {
            $sql = "INSERT INTO detalle_solicitud_material(id_solicitud, id_insumo, cantidad_pedida, cantidad_recibida)
                    VALUES (?, ?, ?, ?)";
            $stmt = $this->conexion->prepare($sql);

            foreach ($materiales as $m) {
                $stmt->execute([$id_solicitud, $m['id_insumo'], $m['cantidad_pedida'], $m['cantidad_recibida']]);
            }
            return true;
        } catch (PDOException $e) {
            echo "Error SQL detalle: " . $e->getMessage();
            return false;
        }
    }

    // Obtener solicitud con nombre de departamentos y nombre del trabajador emisor
    public function obtener($id_solicitud) {
        try {
$sql = "SELECT s.*, 
               d1.nombre AS nombre_departamento_emisor,
               d2.nombre AS nombre_departamento_destino
        FROM solicitud_materiales s
        INNER JOIN departamentos d1 ON s.departamento_emisor = d1.id_departamento
        INNER JOIN departamentos d2 ON s.departamento_destino = d2.id_departamento
        WHERE s.id_solicitud = ?";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$id_solicitud]);
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo "Error SQL obtener solicitud: " . $e->getMessage();
            return false;
        }
    }

    // Obtener detalles de la solicitud
    public function obtenerDetalle($id_solicitud) {
    try {
        $stmt = $this->conexion->prepare(
            "SELECT d.id_insumo, i.nombre, i.descripcion, i.unidad_medida as unidad, d.cantidad_pedida, d.cantidad_recibida
             FROM detalle_solicitud_material d
             INNER JOIN insumos i ON d.id_insumo = i.id_insumo
             WHERE d.id_solicitud = ?"
        );
        $stmt->execute([$id_solicitud]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    } catch (PDOException $e) {
        echo "Error SQL obtener detalle: " . $e->getMessage();
        return false;
    }
}


}
?>
