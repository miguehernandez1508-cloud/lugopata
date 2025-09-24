    <?php
    require_once "gestorsesion.php";

    class Login {
        private $conexion; // debe ser PDO

        public function __construct($conexion) {
            $this->conexion = $conexion;
            GestorSesiones::iniciar();
        }

        public function validarUsuario($nombre, $clave) {
            $sql = "SELECT u.*, t.nombre, t.apellido, t.firma
FROM usuarios u
JOIN trabajadores t ON u.id_trabajador = t.id_trabajador
WHERE u.username = ? 
LIMIT 1
";
        $sentencia = $this->conexion->prepare($sql);
        $sentencia->execute([$nombre]);
        $usuario = $sentencia->fetch(PDO::FETCH_OBJ);


if ($usuario && password_verify($clave, $usuario->password)) {
    GestorSesiones::set("username", $usuario->username);
    GestorSesiones::set("nivel", $usuario->nivel);
    GestorSesiones::set("id_trabajador", $usuario->id_trabajador);
    GestorSesiones::set("nombre_completo", $usuario->nombre . " " . $usuario->apellido);
    
    // 🔹 Aquí ya correcto con objeto
    GestorSesiones::set('firma', $usuario->firma ?? null);

    GestorSesiones::set("status", 0);

    require_once "Auditoria.php";
    $auditoria = new Auditoria($this->conexion);
    $auditoria->registrar('Inicio de Sesion', $usuario->username);

    return true;
}


            // Login fallido
            GestorSesiones::set("status", 1);
            return false;
        }
    }   
    ?>
