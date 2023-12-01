<?php
// Obtener los datos del formulario
$nombreSubprocesoNivel2 = $_POST['nombreSubprocesoNivel2'];
$subprocesoPadre = $_POST['subprocesoPadre'];

// Incluir el archivo de conexión
require_once('../conexion.php');

try {
    // Realizar la conexión a la base de datos
    $conn = Conexion::Conectar();

    // Preparar la consulta SQL para insertar el subproceso de nivel 2
    $stmt = $conn->prepare("INSERT INTO subprocesos_nivel2 (nombre, id_subproceso) VALUES (:nombre, :id_subproceso)");
    $stmt->bindParam(':nombre', $nombreSubprocesoNivel2);
    $stmt->bindParam(':id_subproceso', $subprocesoPadre);
    $stmt->execute();

     // Devolver una respuesta indicando que el proceso se ha guardado correctamente
     $response = array('success' => true, 'message' => 'Subproceso nivel 2 guardado correctamente');
     echo json_encode($response);
 } catch(PDOException $e) {
     // Devolver una respuesta indicando que ha ocurrido un error al guardar el proceso
     $response = array('success' => false, 'message' => 'Error al guardar el Subproceso nivel 2: ' . $e->getMessage());
     echo json_encode($response);
 }
 ?>
