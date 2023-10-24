<?php
// Incluir el archivo de conexión
require_once('../conexion.php');

try {
    // Realizar la conexión a la base de datos
    $conn = Conexion::Conectar();

    // Obtener los procesos principales de la base de datos
    $stmt = $conn->prepare("SELECT * FROM procesos");
    $stmt->execute();
    $procesos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Devolver los datos en formato JSON
    echo json_encode($procesos);
} catch (PDOException $e) {
    // Manejar el error en caso de que ocurra
    $response = array('message' => 'Error al obtener los procesos principales: ' . $e->getMessage());
    echo json_encode($response);
}
?>

