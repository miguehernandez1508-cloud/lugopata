<?php
require_once "../conex.php";
require_once "../user/gestorsesion.php";

class Trabajador {
    private $conexion;

    // Propiedades del trabajador
    public $cedula;
    public $nombre;
    public $apellido;
    public $telefono;
    public $direccion;
    public $firma;
    public $id_departamento; // Nueva propiedad

    // Constructor recibe conexión y opcionalmente los datos del trabajador
    public function __construct($conexion, $cedula = "", $nombre = "", $apellido = "", $telefono = "", $direccion = "", $firma = "", $id_departamento = null) {
        $this->conexion = $conexion;
        $this->cedula = $cedula;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->telefono = $telefono;
        $this->direccion = $direccion;
        $this->firma = $firma;
        $this->id_departamento = $id_departamento; // Asignamos departamento

        GestorSesiones::iniciar();
    }

    // Crear un trabajador usando las propiedades
    public function crear() {
        try {
            $sql = "INSERT INTO trabajadores(cedula, nombre, apellido, telefono, direccion, firma, id_departamento) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conexion->prepare($sql);
            return $stmt->execute([$this->cedula, $this->nombre, $this->apellido, $this->telefono, $this->direccion, $this->firma, $this->id_departamento]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Listar todos los trabajadores
    public function listar() {
        $stmt = $this->conexion->query("SELECT t.*, d.nombre AS departamento
                                        FROM trabajadores t
                                        LEFT JOIN departamentos d ON t.id_departamento = d.id_departamento
                                        ORDER BY t.id_trabajador DESC");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Obtener un trabajador por ID
    public function obtener($id) {
        $stmt = $this->conexion->prepare("SELECT * FROM trabajadores WHERE id_trabajador = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // Actualizar usando propiedades
    public function actualizar($id) {
        $sql = "UPDATE trabajadores SET cedula=?, nombre=?, apellido=?, telefono=?, direccion=?, id_departamento=? WHERE id_trabajador=?";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$this->cedula, $this->nombre, $this->apellido, $this->telefono, $this->direccion, $this->id_departamento, $id]);
    }

    // Eliminar trabajador
    public function eliminar($id) {
        $stmt = $this->conexion->prepare("DELETE FROM trabajadores WHERE id_trabajador=?");
        return $stmt->execute([$id]);
    }
}
?>
