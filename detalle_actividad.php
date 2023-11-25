<?php


require_once "vistas/parte_superior.php";
require_once "conexion.php";




// Obtener los usuarios de la base de datos
$queryUsuarios = "SELECT id, nombre FROM usuarios"; // Modifica esto para ajustarlo a tu tabla de usuarios
$stmtUsuarios = $conexion->query($queryUsuarios);
$usuarios = $stmtUsuarios->fetchAll(PDO::FETCH_ASSOC);

// Obtener los usuarios de la base de datos
$queryActividades = "SELECT id, nombre FROM actividades"; // Modifica esto para ajustarlo a tu tabla de usuarios
$stmtActividades = $conexion->query($queryActividades);
$actividades = $stmtActividades->fetchAll(PDO::FETCH_ASSOC);


// Función para obtener los detalles de una actividad por su ID
function obtenerDetalleActividad($id_actividad) {
    global $conexion; // Asegúrate de tener una conexión a la base de datos

    $query = "SELECT id, id_subproceso_nivel2, nombre, descripcion, observaciones, docentes_responsables, presupuesto_proyectado, fecha_inicio, fecha_fin, estado, progreso, fecha_sys FROM actividades WHERE id = :id_actividad";

    $stmt = $conexion->prepare($query);
    $stmt->bindParam(':id_actividad', $id_actividad, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $detalle_actividad = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($detalle_actividad) {
            return $detalle_actividad;
        } else {
            return null; // No se encontró la actividad
        }
    } else {
        // Manejo de errores
        return null;
    }
}
// Función para obtener los avances de una actividad por su ID
function obtenerAvances($id_actividad) {
    global $conexion;

    $query = "SELECT id, nombre_avance, texto_avance, archivo_avance, fecha_registro FROM avances WHERE id_actividades_usuarios = ? ORDER BY fecha_registro DESC";


    $stmt = $conexion->prepare($query);
    $stmt->bindParam(1, $id_actividad, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// Verifica si se proporcionó un ID válido para la actividad
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_actividad = $_GET['id'];
    $detalle_actividad = obtenerDetalleActividad($id_actividad);

    if (!$detalle_actividad) {
        // No se encontró la actividad, puedes mostrar un mensaje de error o redireccionar
        header("Location: actividades.php");
        exit();
    }

    // Obtener avances de la actividad
    $avances = obtenerAvances($id_actividad);
} else {
    // Si no se proporciona un ID válido, redirecciona
    header("Location: actividades.php");
    exit();
}
include "controladores/controlador_actividades_usuarios.php";
// Realiza una consulta para obtener los detalles de los usuarios asignados a esta actividad desde la tabla actividades_usuarios
$consulta_usuarios_actividad = "SELECT u.id, u.nombre FROM usuarios u INNER JOIN actividades_usuarios au ON u.id = au.id_usuario WHERE au.id_actividad = id_actividad";
$stmt_usuarios_actividad = $conexion->prepare($consulta_usuarios_actividad);

$stmt_usuarios_actividad->execute();
$usuarios_asignados = $stmt_usuarios_actividad->fetchAll(PDO::FETCH_ASSOC);
?>

<div id="layoutSidenav_content">
            <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- Contenido que ocupa todo el ancho -->
                    <h1 class="mt-4">Detalles de la Actividad</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="principal.php">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="configuracion.php">Configuración</a></li>
                        <li class="breadcrumb-item"><a href="configuracion.php">Actividades</a></li>
                        <li class="breadcrumb-item active">Detalles</li>
                    </ol>
                </div>
            </div>
        <div class="row justify-content-center"> <!-- Centra el contenido -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="card-title text-center"><?php echo $detalle_actividad['nombre']; ?></h1>
                            <hr>
                            <p class="card-text"><strong>Descripción:</strong> <?php echo $detalle_actividad['descripcion']; ?></p>
                            <p class="card-text"><strong>Información Adicional:</strong> <?php echo $detalle_actividad['observaciones']; ?></p>
                            <hr>
                            
                            <div class="row">
                                <div class="col-md-6 mt-4">
                                    <p><strong>Docentes Responsables:</strong> <?php  echo '<ul>';
                                    foreach ($usuarios_asignados as $usuario) {
                                        echo '<li>' . $usuario['nombre'] . '<a href="?id='. $detalle_actividad['id']. '&usuario_id='.$usuario['id'].'&opcion=7"><button class="btn btn-danger btn-sm ml-2 mb-2">X</button></a>'.'</li>';
                                        
                                    }
                                        echo '</ul>'; ?></p>
                                    <p><strong>Presupuesto Proyectado:</strong> $<?php echo $detalle_actividad['presupuesto_proyectado']; ?></p>
                                    <p><strong>Fecha de Inicio:</strong> <?php echo $detalle_actividad['fecha_inicio']; ?></p>
                                    <p><strong>Fecha de Fin:</strong> <?php echo $detalle_actividad['fecha_fin']; ?></p>
                                </div>
                                <div class="col-md-6 mt-4">
                                    
                                    <p><strong>Estado:</strong>
                                        <?php if ($detalle_actividad['estado'] == 1) : ?>
                                            <span class="badge badge-success">Activo</span>
                                        <?php else : ?>
                                            <span class="badge badge-danger">Inactivo</span>
                                        <?php endif; ?>
                                    </p>
                                    <p><strong>Progreso:</strong> <?php echo $detalle_actividad['progreso']; ?></p>
                                    <p><strong>Fecha de Creación:</strong> <?php echo $detalle_actividad['fecha_sys']; ?></p>
                                    <a href='?id=<?php echo $detalle_actividad['id']; ?>&opcion=1'><button class="btn btn-primary btn-block mb-3" >Asignar Responsables</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                <!-- Columna para avances -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4>Avances de la Actividad</h4>
            
                            <?php
                            $numAvances = count($avances);
                            $numMostrar = min(3, $numAvances);

                            for ($i = 0; $i < $numMostrar; $i++) {
                                $avance = $avances[$i];
                            ?>
                            <div class="alert alert-info">
                                <strong>Nombre del Avance:</strong> <?php echo $avance['nombre_avance']; ?><br>
                                <strong>Descripción:</strong> <?php echo nl2br($avance['texto_avance']); ?><br>
                                <strong>Usuario:</strong> <?php echo $_SESSION['nombre']; ?><br>
                                <strong>Fecha del Avance:</strong> <?php echo date('Y-m-d H:i:s', strtotime($avance['fecha_registro'])); ?><br>
                                <?php if (!empty($avance['archivo_avance'])) : ?>
                                    <a href="<?php echo $avance['archivo_avance']; ?>" download class="btn btn-primary">Descargar archivo</a>
                                <?php endif; ?>
                            </div>
                                <?php
                                }

                                if ($numAvances > 3) {
                                ?>
                                <button class="btn btn-info" id="verMasAvances" >Ver más avances</button>

                                <div id="avancesOcultos" style="display: none;">
                                    <?php
                                    for ($i = 3; $i < $numAvances; $i++) {
                                        $avance = $avances[$i];
                                    ?>
                                    <div class="alert alert-info">
                                        <strong>Nombre del Avance:</strong> <?php echo $avance['nombre_avance']; ?><br>
                                        <strong>Descripción:</strong> <?php echo nl2br($avance['texto_avance']); ?><br>
                                        <strong>Usuario:</strong> <?php echo $_SESSION['nombre']; ?><br>
                                        <strong>Fecha del Avance:</strong> <?php echo date('Y-m-d H:i:s', strtotime($avance['fecha_registro'])); ?><br>
                                        <?php if (!empty($avance['archivo_avance'])) : ?>
                                            <a href="<?php echo $avance['archivo_avance']; ?>" download class="btn btn-primary">Descargar archivo</a>
                                        <?php endif; ?>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                 <!-- Columna para el formulario de avance -->
                 <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Registrar Avance</h5>
                            <form action="guardar_avance.php" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="nombre_avance">Nombre del Avance</label>
                                    <input type="text" class="form-control" name="nombre_avance" id="nombre_avance" required>
                                </div>

                                <div class="form-group">
                                    <label for="texto_avance">Texto del Avance</label>
                                    <textarea class="form-control" name="texto_avance" id="texto_avance" rows="4" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="archivo_avance">Adjuntar Archivo (opcional)</label>
                                    <input type="file" class="form-control-file" name="archivo_avance" id="archivo_avance">
                                </div>
                                <input type="hidden" name="id_actividad" value="<?php echo $detalle_actividad['id']; ?>">
                                <button type="submit" class="btn btn-primary">Guardar Avance</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    const verMasAvancesBtn = document.getElementById("verMasAvances");
    const avancesOcultos = document.getElementById("avancesOcultos");

    verMasAvancesBtn.addEventListener("click", function () {
        avancesOcultos.style.display = "block";
        verMasAvancesBtn.style.display = "none";
    });
</script>
<script src="jquery/jquery-3.3.1.min.js"></script>
<script src="popper/popper.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>

<!-- Código custom -->
<script src="js/scripts.js"></script>
<script src="controladores/eliminar.js"></script>
<!-- JQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


</html>
