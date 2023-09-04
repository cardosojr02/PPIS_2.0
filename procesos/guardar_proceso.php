<?php
require_once('../conexion.php');

// Obtener los datos del formulario
$nombreProceso = $_POST['nombreProceso'];
$descripcionProceso = $_POST['descripcionProceso'];
$categoriaProceso = $_POST['categoriaProceso'];
$periodoProceso = $_POST['periodoProceso'];

try {
    // Realizar la conexión a la base de datos
  $conn = Conexion::Conectar();
    // Insertar los datos en la tabla correspondiente (modifica el nombre de la tabla según tu estructura)
    $stmt = $conn->prepare("INSERT INTO procesos (nombre, descripcion, categoria, id_periodo) VALUES (:nombre, :descripcion, :categoria, :id_periodo)");
    $stmt->bindParam(':nombre', $nombreProceso);
    $stmt->bindParam(':descripcion', $descripcionProceso);
    $stmt->bindParam(':categoria', $categoriaProceso);
    $stmt->bindParam(':id_periodo', $periodoProceso);
    $stmt->execute();

    // Devolver una respuesta indicando que el proceso se ha guardado correctamente
    $response = array('success' => true, 'message' => 'Proceso guardado correctamente');
    echo json_encode($response);
} catch(PDOException $e) {
    // Devolver una respuesta indicando que ha ocurrido un error al guardar el proceso
    $response = array('success' => false, 'message' => 'Error al guardar el proceso: ' . $e->getMessage());
    echo json_encode($response);
}
?>
