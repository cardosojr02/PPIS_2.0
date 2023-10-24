<?php
include_once '../conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$_POST = json_decode(file_get_contents("php://input"), true);
$documento = (isset($_POST['documento'])) ? $_POST['documento'] : '';

$consulta = "SELECT * FROM usuarios WHERE documento = '$documento'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();

if ($resultado->rowCount() > 0) {
    // Ya existe un usuario con el mismo documento
    echo 'existe';
} else {
    // No existe un usuario con el mismo documento
    echo 'no_existe';
}

$conexion = NULL;
?>
