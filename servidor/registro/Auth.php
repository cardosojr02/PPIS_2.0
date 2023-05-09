<?php 
    include "../../conexion.php";

    class Auth extends conexion {
        public function registrar($usuario, $password) {
            $conexion = parent::conectar();
            $sql = "SELECT * FROM usuarios WHERE usuario='$usuario'";
            $result = mysqli_query($conexion, $sql);

    // Si se ha encontrado un usuario con el mismo nombre, mostrar un error
    if (mysqli_num_rows($result) > 0) {
        echo "Error: ya existe un usuario con el mismo nombre";
    }else {
        $sql = "INSERT INTO usuarios (usuario, password) 
                    VALUES (?,?)";
            $query = $conexion->prepare($sql);
            $query->bind_param('ss', $usuario, $password);
            return $query->execute();
    }
            
        }

    }

    

?>