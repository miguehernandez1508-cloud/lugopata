<?php
require_once "../conex.php";
require_once "../user/gestorsesion.php";

class Departamento {
    private $conexion;

    public $nombre;
    public $descripcion;
    public $ubicacion;
    public $telefono;
    public $email;

    public function __construct($conexion, $nombre = "", $descripcion = "", $ubicacion = "", $telefono = "", $email = "") {
        $this->conexion = $conexion;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->ubicacion = $ubicacion;
        $this->telefono = $telefono;
        $this->email = $email;

        GestorSesiones::iniciar();
    }

    public function crear() {
        try {
            $sql = "INSERT INTO departamentos(nombre, descripcion, ubicacion, telefono, email) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->conexion->prepare($sql);
            return $stmt->execute([$this->nombre, $this->descripcion, $this->ubicacion, $this->telefono, $this->email]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function listar($inicio, $registrosPorPagina) {
        $stmt = $this->conexion->prepare("SELECT * FROM departamentos ORDER BY id_departamento DESC LIMIT :inicio, :registros");
        $stmt->bindValue(':inicio', $inicio, PDO::PARAM_INT);
        $stmt->bindValue(':registros', $registrosPorPagina, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function contar() {
        $stmt = $this->conexion->query("SELECT COUNT(*) FROM departamentos");
        return $stmt->fetchColumn();
    }

    public function obtener($id) {
        $stmt = $this->conexion->prepare("SELECT * FROM departamentos WHERE id_departamento = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function actualizar($id) {
        $sql = "UPDATE departamentos SET nombre=?, descripcion=?, ubicacion=?, telefono=?, email=? WHERE id_departamento=?";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$this->nombre, $this->descripcion, $this->ubicacion, $this->telefono, $this->email, $id]);
    }

    public function eliminar($id) {
        $stmt = $this->conexion->prepare("DELETE FROM departamentos WHERE id_departamento=?");
        return $stmt->execute([$id]);
    }
}
?>
<?php