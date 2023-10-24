<?php
// Incluir el archivo de conexión
require_once('../conexion.php');

try {
    // Realizar la conexión a la base de datos
    $conn = Conexion::Conectar();

    // Obtener los usuarios desde la base de datos
    $stmt = $conn->prepare("SELECT * FROM usuarios");
    $stmt->execute();
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Devolver los datos en formato JSON
    echo json_encode($usuarios);
} catch (PDOException $e) {
    // Manejar el error en caso de que ocurra
    $response = array('message' => 'Error al obtener los usuarios: ' . $e->getMessage());
    echo json_encode($response);
}
?>
