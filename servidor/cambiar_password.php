<?php
require_once('../conexion.php');

// Obtener los datos enviados por AJAX
$pass = $_POST['pass'];

// Validar y encriptar la nueva contraseña
if (empty($pass)) {
    echo json_encode(['success' => false, 'message' => 'Por favor, ingrese una contraseña']);
    exit;
}

$pass_encriptada = password_hash($pass, PASSWORD_DEFAULT);

// Actualizar la contraseña en la base de datos
$consulta = "UPDATE usuarios SET pass = '$pass_encriptada', cambio_pass = 1 WHERE id = :id";
$resultado = $conexion->prepare($consulta);
$resultado->bindValue(':id', $_SESSION['id']);
$resultado->execute();

// Verificar si la consulta fue exitosa
if ($resultado->rowCount() > 0) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'No se pudo cambiar la contraseña']);
}
?>
