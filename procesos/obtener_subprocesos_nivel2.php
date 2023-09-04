<?php
// Incluir el archivo de conexión
require_once('../conexion.php');

try {
    // Realizar la conexión a la base de datos
    $conn = Conexion::Conectar();

    // Obtener los subprocesos nivel 2 desde la base de datos
    $stmt = $conn->prepare("SELECT * FROM subprocesos_nivel2");
    $stmt->execute();
    $subprocesosNivel2 = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Devolver los subprocesos nivel 2 en formato JSON
    header('Content-Type: application/json');
    echo json_encode($subprocesosNivel2);
} catch(PDOException $e) {
    // Devolver una respuesta indicando que ha ocurrido un error al obtener los subprocesos nivel 2
    $response = array('success' => false, 'message' => 'Error al obtener los subprocesos nivel 2: ' . $e->getMessage());
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>

