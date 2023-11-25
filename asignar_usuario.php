
<?php

include_once "conexion.php";



// Obtener los datos del formulario
$userId = $_POST['userId'];
$actividadId = $_POST['actividadId'];

try {
    // Verificar que los datos existen y son válidos
    if (!empty($userId) && !empty($actividadId) && is_numeric($userId) && is_numeric($actividadId)) {
        // Ejecutar las sentencias SQL para asignar el usuario a la actividad
        // Suponiendo que la tabla es 'actividades_usuarios'
        // Aquí debes tener cuidado con la seguridad, asegúrate de usar sentencias preparadas para evitar SQL Injection

        $query = "INSERT INTO actividades_usuarios (id_actividad, id_usuario) VALUES (:actividadId, :userId)";
        $stmt = $conexion->prepare($query);
        $stmt->bindParam(':actividadId', $actividadId, PDO::PARAM_INT);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);

        // Ejecutar la consulta dentro del bloque try
        $stmt->execute();

        // Éxito en la asignación
        print '<script>
        Swal.fire({
            title: "Usuario Asignado",
            text: "¡El usuario  ha sido asignado a esta actividad!",
            icon: "success",
            allowOutsideClick: false,
            showCancelButton: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            confirmButtonText: "OK"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "detalle_actividad.php"; // Redirige a la página de periodos
            }
        });
    </script>';
    } else {
        // Datos inválidos o faltantes
        echo 'Datos de usuario o actividad inválidos';
    }
} catch (PDOException $e) {
    // Captura cualquier excepción de PDO
    echo 'Error en la asignación: ' . $e->getMessage();
}
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
<script src="plugins/sweetalert2/sweetalert2@11.js"></script>