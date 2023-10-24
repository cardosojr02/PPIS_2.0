<?php
require_once('../conexion.php');
// Obtener los datos del formulario
$nombreActividad = $_POST['nombreActividad'];
$descripcionActividad = $_POST['descripcionActividad'];
$docentesResponsables = $_POST['docentesResponsables'];
$presupuestoActividad = $_POST['presupuestoActividad'];
$fecha_inicioActividad = $_POST['fechaInicioActividad'];
$fechaFinActividad = $_POST['fechaFinActividad'];
$estadoActividad = $_POST['estadoActividad'];
$subprocesoNivel2 = $_POST['subprocesoNivel2'];


try {
  // Realizar la conexión a la base de datos
  $conn = Conexion::Conectar();

  // Preparar la consulta SQL para insertar la actividad
  $stmt = $conn->prepare("INSERT INTO actividades (nombre, descripcion, docentes_responsables, presupuesto_proyectado, fecha_inicio, fecha_fin, estado, id_subproceso_nivel2) VALUES (:nombre, :descripcion, :docentes_responsables, :presupuesto_proyectado, :fecha_inicio, :fecha_fin, :estado, :id_subproceso_nivel2)");

  // Asignar los valores a los parámetros de la consulta
  $stmt->bindParam(':nombre', $nombreActividad);
  $stmt->bindParam(':descripcion', $descripcionActividad);
  $stmt->bindParam(':docentes_responsables', $docentesResponsables);
  $stmt->bindParam(':presupuesto_proyectado', $presupuestoActividad);
  $stmt->bindParam(':fecha_inicio', $fecha_inicioActividad);
  $stmt->bindParam(':fecha_fin', $fechaFinActividad);
  $stmt->bindParam(':estado', $estadoActividad);
  $stmt->bindParam(':id_subproceso_nivel2', $subprocesoNivel2);

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
