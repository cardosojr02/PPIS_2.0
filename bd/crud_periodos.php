<?php
include_once 'conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$_POST = json_decode(file_get_contents("php://input"), true);
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
$fechaInicio = (isset($_POST['fechaInicio'])) ? $_POST['fechaInicio'] : '';
$fechaFin = (isset($_POST['fechaFin'])) ? $_POST['fechaFin'] : '';


$data = array(); // Inicializar el arreglo $data


switch ($opcion) {
    case 1:
        $consulta = "INSERT INTO periodos (nombre, fecha_inicio, fecha_fin, fecha_sys) VALUES('$nombre', '$fechaInicio', '$fechaFin', now())";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        break;
    case 2:
        $consulta = "UPDATE periodos SET nombre='$nombre', fecha_inicio='$fechaInicio', fecha_fin='$fechaFin' WHERE id='$id'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        break;
    case 3:
        $consulta = "DELETE FROM periodos WHERE id='$id'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        break;
    case 4:
        $consulta = "SELECT * FROM periodos";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
}

// Comprobar si hay resultados
if ($data === false) {
    $data = array();
}

print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
?>
