<?php
require_once('../conexion.php');

// Obtener los datos del formulario
$nombrePeriodo = $_POST['nombre'];
$fechaInicioPeriodo = $_POST['fechaInicio'];
$fechaFinPeriodo = $_POST['fechaFin'];

try {
  // Realizar la conexión a la base de datos
  $conn = Conexion::Conectar();

  // Insertar los datos en la tabla correspondiente (modifica el nombre de la tabla según tu estructura)
  $stmt = $conn->prepare("INSERT INTO periodos (nombre, fecha_inicio, fecha_fin) VALUES (:nombre, :fechaInicio, :fechaFin)");
  $stmt->bindParam(':nombre', $nombrePeriodo);
  $stmt->bindParam(':fechaInicio', $fechaInicioPeriodo);
  $stmt->bindParam(':fechaFin', $fechaFinPeriodo);
  $stmt->execute();

  // Devolver una respuesta indicando que el periodo se ha guardado correctamente
  $response = array('success' => true, 'message' => 'Periodo guardado correctamente');
  echo json_encode($response);
} catch(PDOException $e) {
  // Devolver una respuesta indicando que ha ocurrido un error al guardar el periodo
  $response = array('success' => false, 'message' => 'Error al guardar el periodo: ' . $e->getMessage());
  echo json_encode($response);
}
?>
