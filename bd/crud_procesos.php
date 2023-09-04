<?php
include_once 'conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$_POST = json_decode(file_get_contents("php://input"), true);
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
$descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : '';
$categoria = (isset($_POST['categoria'])) ? $_POST['categoria'] : '';
$id_periodo = (isset($_POST['id_periodo'])) ? $_POST['id_periodo'] : '';

$data = array(); // Inicializar el arreglo $data

switch ($opcion) {
    case 1:
        $consulta = "INSERT INTO procesos (nombre, descripcion, categoria, id_periodo, fecha_sys) VALUES('$nombre', '$descripcion', '$categoria', '$id_periodo', now())";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        break;
    case 2:
        $consulta = "UPDATE procesos SET nombre='$nombre', descripcion='$descripcion', categoria='$categoria' WHERE id='$id'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        break;
    case 3:
        try {
            // Antes de eliminar, verifica si hay registros relacionados en la tabla subprocesos
            $consulta_relacion = "SELECT * FROM subprocesos WHERE id_proceso = $id";
            $resultado_relacion = $conexion->prepare($consulta_relacion);
            $resultado_relacion->execute();
            $num_rows = $resultado_relacion->rowCount();

            if ($num_rows > 0) {
                $mensaje = "No se puede eliminar el registro porque tiene subprocesos relacionados.";
                echo json_encode(array("error" => true, "mensaje" => $mensaje));
            } else {
                $consulta = "DELETE FROM procesos
                WHERE id='$id'
                AND id NOT IN (
                    SELECT id_proceso FROM subprocesos
                );
                ";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute();
                echo json_encode(array("error" => false, "mensaje" => "Registro eliminado exitosamente."));
            }
        } catch (Exception $e) {
            echo json_encode(array("error" => true, "mensaje" => $e->getMessage()));
        }
        break;
    case 4:
        $consulta = "SELECT procesos.id, procesos.nombre, procesos.descripcion, procesos.categoria, procesos.id_periodo, procesos.fecha_sys, periodos.nombre AS nombre_periodo FROM procesos JOIN periodos ON procesos.id_periodo = periodos.id";
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
