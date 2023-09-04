<?php
// Incluir el archivo de conexión
require_once('../conexion.php');

try {
    // Realizar la conexión a la base de datos
    $conn = Conexion::Conectar();

    // Obtener los subprocesos nivel 2 desde la base de datos
    $stmt = $conn->prepare("SELECT * FROM subprocesos");
    $stmt->execute();
    $subprocesos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Devolver los subprocesos en formato JSON
    echo json_encode($subprocesos);
} catch(PDOException $e) {
    // Devolver una respuesta indicando que ha ocurrido un error al obtener los subprocesos
    $response = array('success' => false, 'message' => 'Error al obtener los subprocesos: ' . $e->getMessage());
    echo json_encode($response);
}
?>
