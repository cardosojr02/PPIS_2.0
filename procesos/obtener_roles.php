<?php
// Incluir el archivo de conexión
require_once('../conexion.php');

try {
    // Realizar la conexión a la base de datos
    $conn = Conexion::Conectar();

    // Obtener los roles desde la base de datos
    $stmt = $conn->prepare("SELECT * FROM roles");
    $stmt->execute();
    $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Devolver los datos en formato JSON
    echo json_encode($roles);
} catch (PDOException $e) {
    // Manejar el error en caso de que ocurra
    $response = array('message' => 'Error al obtener los roles: ' . $e->getMessage());
    echo json_encode($response);
}
?>
