<?php
require_once "../conex.php";

class Insumo {
    private $conexion;

    public $id_insumo;      // <-- agregada
    public $nombre;
    public $descripcion;
    public $unidad_medida;
    public $cantidad;
    public $imagen;

    public function __construct($conexion, $id_insumo="", $nombre="", $descripcion="", $unidad_medida="", $cantidad=0, $imagen=NULL) {
        $this->conexion = $conexion;
        $this->id_insumo = $id_insumo;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->unidad_medida = $unidad_medida;
        $this->cantidad = $cantidad;
        $this->imagen = $imagen;
    }

    public function crear() {
        try {
            $sql = "INSERT INTO insumos(id_insumo, nombre, descripcion, unidad_medida, cantidad, imagen) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->conexion->prepare($sql);
            return $stmt->execute([$this->id_insumo, $this->nombre, $this->descripcion, $this->unidad_medida, $this->cantidad, $this->imagen]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function listar() {
        $stmt = $this->conexion->query("SELECT * FROM insumos ORDER BY id_insumo DESC");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Obtener un insumo por ID
public function obtener($id_insumo) {
    $stmt = $this->conexion->prepare("SELECT * FROM insumos WHERE id_insumo = ?");
    $stmt->execute([$id_insumo]);
    return $stmt->fetch(PDO::FETCH_OBJ);
}

// Actualizar un insumo existente
public function actualizar($id_insumo) {
    try {
        $sql = "UPDATE insumos SET nombre=?, descripcion=?, unidad_medida=?, cantidad=?, imagen=? WHERE id_insumo=?";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$this->nombre, $this->descripcion, $this->unidad_medida, $this->cantidad, $this->imagen, $id_insumo]);
    } catch (PDOException $e) {
        echo "Error SQL: " . $e->getMessage();
        return false;
    }
}

// Eliminar un insumo
public function eliminar($id_insumo) {
    try {
        $stmt = $this->conexion->prepare("DELETE FROM insumos WHERE id_insumo=?");
        return $stmt->execute([$id_insumo]);
    } catch (PDOException $e) {
        echo "Error SQL: " . $e->getMessage();
        return false;
    }
}

}
?>
