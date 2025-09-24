    <?php
    require_once "../conex.php";

    class Usuario {
        private $username;
        private $password;
        private $email;
        private $nivel;
        private $id_trabajador;

        public function __construct($username, $password, $email, $nivel, $id_trabajador) {
            $this->username = $username;
            $this->password = password_hash($password, PASSWORD_DEFAULT); // encriptar
            $this->email = $email;
            $this->nivel = $nivel;
            $this->id_trabajador = $id_trabajador;
        }

        public function guardar($conexion) {
            $sql = "INSERT INTO usuarios (username, password, email, nivel, id_trabajador) VALUES (?, ?, ?, ?, ?)";
            $sentencia = $conexion->prepare($sql);
            return $sentencia->execute([
                $this->username,
                $this->password,
                $this->email,
                $this->nivel,
                $this->id_trabajador
            ]);
        }

        
    }