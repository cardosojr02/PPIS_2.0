<?php
include_once 'conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$_POST = json_decode(file_get_contents("php://input"), true);
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
$apellido = (isset($_POST['apellido'])) ? $_POST['apellido'] : '';
$email = (isset($_POST['email'])) ? $_POST['email'] : '';
$documento = (isset($_POST['documento'])) ? $_POST['documento'] : '';
$telefono = (isset($_POST['telefono'])) ? $_POST['telefono'] : '';
$tipo_usuario = (isset($_POST['tipo_usuario'])) ? $_POST['tipo_usuario'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';


// Encriptar la contraseña
// Utilizar el número de documento como contraseña
$pass_encriptada = password_hash($documento, PASSWORD_DEFAULT);

switch ($opcion) {
    case 1:
        $consulta = "INSERT INTO usuarios (nombre, apellido, email, documento, telefono, tipo_usuario, usuario, pass, fecha_sys) VALUES (?, ?, ?, ?, ?, ?, ?, ?, now())";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute([$nombre, $apellido, $email, $documento, $telefono, $tipo_usuario, $usuario, $pass_encriptada]);
        break;
    case 2:
        $consulta = "UPDATE usuarios SET nombre = ?, apellido = ?, email = ?, tipo_usuario = ?, usuario = ?, pass = ? WHERE id = ?";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute([$nombre, $apellido, $email, $tipo_usuario, $usuario, $pass_encriptada, $id]);
        break;
    case 3:
        $consulta = "DELETE FROM usuarios WHERE id = ?";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute([$id]);
        break;
    case 4:
        $consulta = "SELECT * FROM usuarios";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
}
print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
?>