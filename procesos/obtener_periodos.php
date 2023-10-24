<?php
// Incluir el archivo de conexión
require_once('../conexion.php');

try {
    // Realizar la conexión a la base de datos
    $conn = Conexion::Conectar();

    // Obtener los periodos de la base de datos
    
$stmt = $conn->prepare("SELECT * FROM periodos");
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC); // Establecer el fetch mode a FETCH_ASSOC
$periodos = $stmt->fetchAll();


    // Devolver los datos en formato JSON
    echo json_encode($periodos);
} catch (PDOException $e) {
    // Manejar el error en caso de que ocurra
    $response = array('message' => 'Error al obtener los periodos: ' . $e->getMessage());
    echo json_encode($response);
}
?>