<?php
// Obtener los datos del formulario
$nombreSubproceso = $_POST['nombreSubproceso'];
$descripcionSubproceso = $_POST['descripcionSubproceso'];
$idProcesoPadre = $_POST['procesoPrincipal'];

// Incluir el archivo de conexión
require_once('../conexion.php');

try {
    // Realizar la conexión a la base de datos
    $conn = Conexion::Conectar();

    // Preparar la consulta SQL para insertar el subproceso
    $stmt = $conn->prepare("INSERT INTO subprocesos (nombre, descripcion, id_proceso) VALUES (:nombre, :descripcion, :id_proceso)");
    $stmt->bindParam(':nombre', $nombreSubproceso);
    $stmt->bindParam(':descripcion', $descripcionSubproceso);
    $stmt->bindParam(':id_proceso', $idProcesoPadre);
    $stmt->execute();

    // Devolver una respuesta indicando que el proceso se ha guardado correctamente
    $response = array('success' => true, 'message' => 'Subproceso guardado correctamente');
    echo json_encode($response);
} catch(PDOException $e) {
    // Devolver una respuesta indicando que ha ocurrido un error al guardar el proceso
    $response = array('success' => false, 'message' => 'Error al guardar el Subproceso: ' . $e->getMessage());
    echo json_encode($response);
}
?>

