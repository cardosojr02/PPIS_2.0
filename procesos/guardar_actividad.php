<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
require_once('../conexion.php');

// Obtener los datos del formulario
$nombreActividad = $_POST['nombreActividad'];
$descripcionActividad = $_POST['descripcionActividad'];
$observacionesActividad = $_POST['observacionesActividad']; // Nuevo campo 'observaciones'
$docentes_responsables = $_POST['docentes_responsables']; // Nuevo campo 'docentes_responsables'
$presupuestoActividad = $_POST['presupuestoActividad'];
$fecha_inicioActividad = $_POST['fechaInicioActividad'];
$fechaFinActividad = $_POST['fechaFinActividad'];
$estadoActividad = $_POST['estadoActividad'];
$subprocesoNivel2 = $_POST['subprocesoNivel2'];
$progresoActividad = $_POST['progresoActividad'];
$creadorActividad = $_SESSION['id'];

try {
  // Realizar la conexión a la base de datos
  $conn = Conexion::Conectar();

  // Preparar la consulta SQL para insertar la actividad
  $stmt = $conn->prepare("INSERT INTO actividades (nombre, descripcion, observaciones, docentes_responsables, presupuesto_proyectado, fecha_inicio, fecha_fin, estado, id_subproceso_nivel2, progreso, creador) VALUES (:nombre, :descripcion, :observaciones, :docentes_responsables, :presupuesto_proyectado, :fecha_inicio, :fecha_fin, :estado, :id_subproceso_nivel2, :progreso, :creador)");

  // Asignar los valores a los parámetros de la consulta
  $stmt->bindParam(':nombre', $nombreActividad);
  $stmt->bindParam(':descripcion', $descripcionActividad);
  $stmt->bindParam(':observaciones', $observacionesActividad); // Asignar el valor del nuevo campo 'observaciones'
  $stmt->bindParam(':docentes_responsables', $docentes_responsables); // Asignar el valor del nuevo campo 'docentes_responsables'
  $stmt->bindParam(':presupuesto_proyectado', $presupuestoActividad);
  $stmt->bindParam(':fecha_inicio', $fecha_inicioActividad);
  $stmt->bindParam(':fecha_fin', $fechaFinActividad);
  $stmt->bindParam(':estado', $estadoActividad);
  $stmt->bindParam(':id_subproceso_nivel2', $subprocesoNivel2);
  $stmt->bindParam(':progreso', $progresoActividad);
  $stmt->bindParam(':creador', $creadorActividad);

  // Ejecutar la consulta
  $stmt->execute();

  // Devolver una respuesta indicando que la actividad se ha guardado correctamente
  $response = array('success' => true, 'message' => 'La actividad se ha creado correctamente');
  header('Content-Type: application/json');
  echo json_encode($response);
} catch(PDOException $e) {
  // Devolver una respuesta indicando que ha ocurrido un error al guardar la actividad
  $response = array('success' => false, 'message' => 'Error al guardar la actividad: ' . $e->getMessage());
  header('Content-Type: application/json');
  echo json_encode($response);
}
?>
