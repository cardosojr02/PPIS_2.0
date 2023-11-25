<?php
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_avance = $_POST["nombre_avance"]; // Nuevo campo: Nombre del Avance
    $texto_avance = $_POST["texto_avance"];
    $id_actividad = $_POST["id_actividad"];

    // Verifica si se adjuntó un archivo
    $archivo_avance = null;
    if ($_FILES["archivo_avance"]["error"] === 0) {
        $nombre_archivo = $_FILES["archivo_avance"]["name"];
        $ruta_archivo = "archivos_avances/" . $nombre_archivo;
        if (move_uploaded_file($_FILES["archivo_avance"]["tmp_name"], $ruta_archivo)) {
            $archivo_avance = $ruta_archivo;
        }
    }

    // Crear una instancia de la clase Conexion
    $conexion = Conexion::Conectar();

    // Inserta el avance en la base de datos
    $query = "INSERT INTO avances (id_actividades_usuarios, nombre_avance, texto_avance, archivo_avance) VALUES (:id_actividad, :nombre_avance, :texto_avance, :archivo_avance)";
    $stmt = $conexion->prepare($query);
    
    $stmt->bindParam(":id_actividad", $id_actividad, PDO::PARAM_INT);
    $stmt->bindParam(":nombre_avance", $nombre_avance, PDO::PARAM_STR); // Nuevo campo: Nombre del Avance
    $stmt->bindParam(":texto_avance", $texto_avance, PDO::PARAM_STR);
    $stmt->bindParam(":archivo_avance", $archivo_avance, PDO::PARAM_STR);
    
    if ($stmt->execute()) {
        // Avance guardado exitosamente
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
        });
    </script>';
        header("Location: detalle_actividad.php?id=$id_actividad");
    } else {
        // Error al guardar el avance
        echo "Error al guardar el avance.";
    }

    $stmt->closeCursor();
    $conexion = null; // Cierra la conexión

}
?>
