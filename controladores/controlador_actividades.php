<?php
require_once('./conexion.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
  
    try {
        $consulta = "SELECT a.*, 
                            s.nombre AS nombre_subproceso,
                            sp.nombre AS nombre_subproceso_nivel,
                            p.nombre AS nombre_proceso,
                            pe.nombre AS nombre_periodo
                    FROM actividades AS a
                    LEFT JOIN subprocesos_nivel2 AS s ON a.id_subproceso_nivel2 = s.id
                    LEFT JOIN subprocesos AS sp ON s.id_subproceso = sp.id
                    LEFT JOIN procesos AS p ON sp.id_proceso = p.id
                    LEFT JOIN periodos AS pe ON p.id_periodo = pe.id";
                    
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    
/* Acciones */

if (isset($_GET['opcion'])) {
    $action = $_GET['opcion'];

    if ($action == '8') {
        
    
        ?>
        <script>
            Swal.fire({
                title: 'Asignar Responsable',
                html: `
                    <form action="#" method="POST" class="text-left m-3">
                        
                        <div class="form-group">
                            <label for="userId">Usuario Responsable</label>
                            <select name="userId" class="form-control">
                                <option value="">Seleccionar Usuario responsable</option>
                                <?php
                                // Obtén la lista de usuarios de tu base de datos
                                $sql_usuarios = "SELECT id, nombre FROM usuarios";
                                $stmt_usuarios = $conexion->prepare($sql_usuarios);
                                $stmt_usuarios->execute();
                                $usuarios = $stmt_usuarios->fetchAll(PDO::FETCH_ASSOC);
    
                                // Muestra opciones para cada usuario
                                foreach ($usuarios as $usuario) {
                                    echo '<option value="' . $usuario['id'] . '">' . $usuario['nombre'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="actividadId" value="<?php echo $detalle_actividad['id']; ?>">
                        </div>
                                    
                            
                        
                        <input type="submit" name="btnRegistrarUser" class="btn btn-outline-secondary btn-lg btn-block mt-4">
                    </form>
                `,
                showConfirmButton: false,
                allowOutsideClick: false,
                showCancelButton: false,
                showCloseButton: true,
                allowEscapeKey: false,
                allowEnterKey: false,
            });
        </script>
        <?php
    }

    if ($action == '7' && isset($_GET['usuario_id']) && isset($_GET['id'])) {
        $usuario_id = $_GET['usuario_id'];
        $actividad_id = $_GET['id'];
    
        try {
            $sql_delete = "DELETE FROM actividades_usuarios WHERE id_usuario = :usuario_id AND id_actividad = :id";
            $stmt = $conexion->prepare($sql_delete);
            $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
            $stmt->bindParam(':id', $actividad_id, PDO::PARAM_INT); // Aquí cambié ':id' por ':actividad_id'
    
            if ($stmt->execute()) {
                print '<script>
                    Swal.fire({
                        title: "Usuario eliminado de la actividad",
                        text: "Usuario ' . $usuario_id . ' eliminado correctamente",
                        icon: "success",
                        allowOutsideClick: false,
                        showCancelButton: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        confirmButtonText: "OK"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "detalle_actividad.php?id='.$actividad_id.'"; // Redirige a la página de detalles de actividad
                        }
                    });
                </script>';
            }
        } catch (Exception $e) {
            print "<script>
            Swal.fire(
                'Error!',
                'Ocurrió un error: " . $e->getMessage() . "',
                'error'
            )
            </script>";
        }
    }

    if ($action == '4' && isset($_GET['id']) && isset($_GET['estado'])) {
        $progreso = $_GET['estado'];
        $id = $_GET['id'];

        try {
            // Actualiza el progreso de la actividad en la base de datos
            $consulta = "UPDATE actividades SET estado = :estado WHERE id = :id";
            $stmt = $conexion->prepare($consulta);
            $stmt->bindParam(':estado', $estado, PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                // Si la actualización es exitosa, muestra una notificación
                print '<script>
                    Swal.fire({
                        title: "Estado Actualizado",
                        text: "¡Estado de la actividad ' . $id . ' actualizado!",
                        icon: "success",
                        allowOutsideClick: false,
                        showCancelButton: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        confirmButtonText: "OK"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "actividades.php"; // Redirige a la página de actividades
                        }
                    });
                </script>';
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    if ($action == '3' && isset($_GET['id'])) {
        $id = $_GET['id'];

        try {
            $sql_delete = "DELETE FROM actividades WHERE id = :id";
            $stmt = $conexion->prepare($sql_delete);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                print '<script>
                    Swal.fire({
                        title: "Actividad Eliminada",
                        text: "Actividad ' . $id . ' Eliminada correctamente",
                        icon: "success",
                        allowOutsideClick: false,
                        showCancelButton: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        confirmButtonText: "OK"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window location.href = "actividades.php"; // Redirige a la página de actividades
                        }
                    });
                </script>';
            }
        } catch (Exception $e) {
            print "<script>
            Swal.fire(
                'Error!',
                'Ocurrió un error: " . $e->getMessage() . "',
                'error'
            )
            </script>";
        }
    }
    //ACTUALIZACION ACTIVIDADES DESDE DETALLES ACTIVIDAD
    if ($action == '9' && isset($_GET['id'])) {
        $id = $_GET['id'];
    
        // Realiza una consulta para obtener los detalles de la actividad
        $consulta_actividad = "SELECT * FROM actividades WHERE id = :id";
        $stmt = $conexion->prepare($consulta_actividad);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $actividad = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($actividad) {
            $id = $actividad['id'];
            $nombre = $actividad['nombre'];
            $descripcion = $actividad['descripcion']; // Agregado
            $observaciones = $actividad['observaciones']; // Agregado
            $docentes_responsables = $actividad['docentes_responsables']; // Agregado
            $presupuesto_proyectado = $actividad['presupuesto_proyectado']; // Agregado
            $fecha_inicio = $actividad['fecha_inicio']; // Agregado
            $fecha_fin = $actividad['fecha_fin']; // Agregado
            $estado = $actividad['estado']; // Agregado
            $progreso = $actividad['progreso'];
            $id_subproceso = $actividad['id_subproceso_nivel2'];
            ?>
    
            <script>
                Swal.fire({
                    title: 'Actualizar Actividad',
                    html: `
                        <form action="#" method="POST" class="text-left m-3">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" name="nombre" value="<?php echo $nombre ?>" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <textarea name="descripcion" class="form-control" rows="4" required><?php echo $descripcion ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="observaciones">Observaciones</label>
                                <textarea name="observaciones" class="form-control" rows="4" required><?php echo $observaciones ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="docentes_responsables">Docentes Responsables</label>
                                <select name="docentes_responsables" class="form-control">
                                    <?php
                                    // Obten la lista de usuarios de tu base de datos
                                    $sql_usuarios = "SELECT id, nombre FROM usuarios";
                                    $stmt_usuarios = $conexion->prepare($sql_usuarios);
                                    $stmt_usuarios->execute();
                                    $usuarios = $stmt_usuarios->fetchAll(PDO::FETCH_ASSOC);
    
                                    // Muestra opciones para cada usuario
                                    foreach ($usuarios as $usuario) {
                                        $selected = ($usuario['id'] == $docentes_responsables) ? 'selected' : '';
                                        echo '<option value="' . $usuario['id'] . '" ' . $selected . '>' . $usuario['nombre'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="presupuesto_proyectado">Presupuesto</label>
                                <input type="number" name="presupuesto_proyectado" value="<?php echo $presupuesto_proyectado ?>" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="fecha_inicio">Fecha de Inicio</label>
                                <input type="date" name="fecha_inicio" value="<?php echo $fecha_inicio ?>" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="fecha_fin">Fecha de Fin</label>
                                <input type="date" name="fecha_fin" value="<?php echo $fecha_fin ?>" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="progreso">Progreso</label>
                                <select name="progreso" class="form-control">
                                    <option value="Pendiente" <?php if ($progreso == 'Pendiente') echo 'selected'; ?>>Pendiente</option>
                                    <option value="En Progreso" <?php if ($progreso == 'En Progreso') echo 'selected'; ?>>En Progreso</option>
                                    <option value="Completada" <?php if ($progreso == 'Completada') echo 'selected'; ?>>Completada</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="subprocesoNivel2">Subproceso Asociado</label>
                                <select name="subprocesoNivel2" class="form-control">
                                    <?php
                                    $consulta_subprocesos_nivel2 = "SELECT id, nombre FROM subprocesos_nivel2"; // Ajusta la consulta según tu estructura
                                    $stmt_subprocesos_nivel2 = $conexion->prepare($consulta_subprocesos_nivel2);
                                    $stmt_subprocesos_nivel2->execute();
                                    $subprocesos_nivel2 = $stmt_subprocesos_nivel2->fetchAll(PDO::FETCH_ASSOC);
    
                                    foreach ($subprocesos_nivel2 as $subproceso_nivel2) {
                                        $selected = ($subproceso_nivel2['id'] == $id_subproceso) ? 'selected' : '';
                                        echo '<option value="' . $subproceso_nivel2['id'] . '" ' . $selected . '>' . $subproceso_nivel2['nombre'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="estado">Estado de la Actividad:</label>
                                <select class="form-control" id="estado" name="estado">
                                    <option value="1" <?php echo ($estado == 1) ? 'selected' : ''; ?>>Activo</option>
                                    <option value="0" <?php echo ($estado == 0) ? 'selected' : ''; ?>>Inactivo</option>
                                </select>
                            </div>
                            <input type="hidden" name="id" value="<?php echo $id ?>">
                            <input type="submit" name="btnActualizarDet" class="btn btn-outline-secondary btn-lg btn-block mt-4">
                        </form>
                    `,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    showCancelButton: false,
                    showCloseButton: true,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                });
            </script>
            <?php
        
    }
    
    }
    //ACTUALIZACION ACTIVIDADES DESDE EL CRUD
    if ($action == '2' && isset($_GET['id'])) {
        $id = $_GET['id'];
    
        // Realiza una consulta para obtener los detalles de la actividad
        $consulta_actividad = "SELECT * FROM actividades WHERE id = :id";
        $stmt = $conexion->prepare($consulta_actividad);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $actividad = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($actividad) {
            $id = $actividad['id'];
            $nombre = $actividad['nombre'];
            $descripcion = $actividad['descripcion']; // Agregado
            $observaciones = $actividad['observaciones']; // Agregado
            $docentes_responsables = $actividad['docentes_responsables']; // Agregado
            $presupuesto_proyectado = $actividad['presupuesto_proyectado']; // Agregado
            $fecha_inicio = $actividad['fecha_inicio']; // Agregado
            $fecha_fin = $actividad['fecha_fin']; // Agregado
            $estado = $actividad['estado']; // Agregado
            $progreso = $actividad['progreso'];
            $id_subproceso = $actividad['id_subproceso_nivel2'];
            ?>
    
            <script>
                Swal.fire({
                    title: 'Actualizar Actividad',
                    html: `
                        <form action="#" method="POST" class="text-left m-3">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" name="nombre" value="<?php echo $nombre ?>" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <textarea name="descripcion" class="form-control" rows="4" required><?php echo $descripcion ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="observaciones">Observaciones</label>
                                <textarea name="observaciones" class="form-control" rows="4" required><?php echo $observaciones ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="docentes_responsables">Docentes Responsables</label>
                                <select name="docentes_responsables" class="form-control">
                                    <?php
                                    // Obten la lista de usuarios de tu base de datos
                                    $sql_usuarios = "SELECT id, nombre FROM usuarios";
                                    $stmt_usuarios = $conexion->prepare($sql_usuarios);
                                    $stmt_usuarios->execute();
                                    $usuarios = $stmt_usuarios->fetchAll(PDO::FETCH_ASSOC);
    
                                    // Muestra opciones para cada usuario
                                    foreach ($usuarios as $usuario) {
                                        $selected = ($usuario['id'] == $docentes_responsables) ? 'selected' : '';
                                        echo '<option value="' . $usuario['id'] . '" ' . $selected . '>' . $usuario['nombre'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="presupuesto_proyectado">Presupuesto</label>
                                <input type="number" name="presupuesto_proyectado" value="<?php echo $presupuesto_proyectado ?>" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="fecha_inicio">Fecha de Inicio</label>
                                <input type="date" name="fecha_inicio" value="<?php echo $fecha_inicio ?>" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="fecha_fin">Fecha de Fin</label>
                                <input type="date" name="fecha_fin" value="<?php echo $fecha_fin ?>" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="progreso">Progreso</label>
                                <select name="progreso" class="form-control">
                                    <option value="Pendiente" <?php if ($progreso == 'Pendiente') echo 'selected'; ?>>Pendiente</option>
                                    <option value="En Progreso" <?php if ($progreso == 'En Progreso') echo 'selected'; ?>>En Progreso</option>
                                    <option value="Completada" <?php if ($progreso == 'Completada') echo 'selected'; ?>>Completada</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="subprocesoNivel2">Subproceso Asociado</label>
                                <select name="subprocesoNivel2" class="form-control">
                                    <?php
                                    $consulta_subprocesos_nivel2 = "SELECT id, nombre FROM subprocesos_nivel2"; // Ajusta la consulta según tu estructura
                                    $stmt_subprocesos_nivel2 = $conexion->prepare($consulta_subprocesos_nivel2);
                                    $stmt_subprocesos_nivel2->execute();
                                    $subprocesos_nivel2 = $stmt_subprocesos_nivel2->fetchAll(PDO::FETCH_ASSOC);
    
                                    foreach ($subprocesos_nivel2 as $subproceso_nivel2) {
                                        $selected = ($subproceso_nivel2['id'] == $id_subproceso) ? 'selected' : '';
                                        echo '<option value="' . $subproceso_nivel2['id'] . '" ' . $selected . '>' . $subproceso_nivel2['nombre'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="estado">Estado de la Actividad:</label>
                                <select class="form-control" id="estado" name="estado">
                                    <option value="1" <?php echo ($estado == 1) ? 'selected' : ''; ?>>Activo</option>
                                    <option value="0" <?php echo ($estado == 0) ? 'selected' : ''; ?>>Inactivo</option>
                                </select>
                            </div>
                            <input type="hidden" name="id" value="<?php echo $id ?>">
                            <input type="submit" name="btnActualizar" class="btn btn-outline-secondary btn-lg btn-block mt-4">
                        </form>
                    `,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    showCancelButton: false,
                    showCloseButton: true,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                });
            </script>
            <?php
        
    }
    
    }
    if ($action == '1') {
        $consulta_subprocesos_nivel2 = "SELECT id, nombre FROM subprocesos_nivel2 WHERE estado = 1";
        $stmt_subprocesos_nivel2 = $conexion->prepare($consulta_subprocesos_nivel2);
        $stmt_subprocesos_nivel2->execute();
        $subprocesos_nivel2 = $stmt_subprocesos_nivel2->fetchAll(PDO::FETCH_ASSOC);
    
        ?>
        <script>
            Swal.fire({
                title: 'Crear Actividad',
                html: `
                    <form action="#" method="POST" class="text-left m-3">
                        <div class="form-group">
                            <label for="nombre">Nombre de la Actividad</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción de la Actividad</label>
                            <textarea name="descripcion" class="form-control" rows="4" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="observaciones">Observaciones de la Actividad</label>
                            <textarea name="observaciones" class="form-control" rows="4" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="docentes_responsables">Docentes Responsables</label>
                            <select name="docentes_responsables" class="form-control">
                                <option value="">Seleccionar docente responsable</option>
                                <?php
                                // Obtén la lista de usuarios de tu base de datos
                                $sql_usuarios = "SELECT id, nombre FROM usuarios";
                                $stmt_usuarios = $conexion->prepare($sql_usuarios);
                                $stmt_usuarios->execute();
                                $usuarios = $stmt_usuarios->fetchAll(PDO::FETCH_ASSOC);
    
                                // Muestra opciones para cada usuario
                                foreach ($usuarios as $usuario) {
                                    echo '<option value="' . $usuario['id'] . '">' . $usuario['nombre'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="presupuesto_proyectado">Presupuesto de la Actividad:</label>
                            <input type="number" name="presupuesto_proyectado" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="fecha_inicio">Fecha de Inicio de la Actividad:</label>
                            <input type="date" name="fecha_inicio" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="fecha_fin">Fecha de Fin de la Actividad:</label>
                            <input type="date" name="fecha_fin" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="progreso">Progreso de la Actividad:</label>
                            <select name="progreso" class="form-control">
                                <option value="Pendiente">Pendiente</option>
                                <option value="En Progreso">En Progreso</option>
                                <option value="Completada">Completada</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="subprocesoNivel2">Subproceso Nivel 2 Asociado:</label>
                            <select name="subprocesoNivel2" class="form-control">
                                <?php
                                foreach ($subprocesos_nivel2 as $subproceso_nivel2) {
                                    echo '<option value="' . $subproceso_nivel2['id'] . '">' . $subproceso_nivel2['nombre'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="estado">Estado de la Actividad:</label>
                                <select class="form-control" id="estado" name="estado">
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                        </div>
                        <input type="submit" name="btnRegistrar" class="btn btn-outline-secondary btn-lg btn-block mt-4">
                    </form>
                `,
                showConfirmButton: false,
                allowOutsideClick: false,
                showCancelButton: false,
                showCloseButton: true,
                allowEscapeKey: false,
                allowEnterKey: false,
            });
        </script>
        <?php
    }
}

if (isset($_POST['btnRegistrarUser'])) {
    $userId = $_POST['userId'];
    $actividadId = $_POST['actividadId'];
    

    $insert_usuario_actividad = "INSERT INTO actividades_usuarios (id_actividad, id_usuario) VALUES (:actividadId, :userId)";

    try {
        $stmt = $conexion->prepare($insert_usuario_actividad);

        $stmt->bindParam(':actividadId', $actividadId, PDO::PARAM_INT);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        


        if ($stmt->execute()) {
            echo "<script>
                let timerInterval;
                Swal.fire({
                    title: '¡Registrando!',
                    text: 'Espere un momento...',
                    icon: 'success',
                    timer: 3000, // Tiempo en milisegundos (3 segundos)
                    timerProgressBar: true, // Muestra una barra de progreso
                    showConfirmButton: false,
                    onBeforeOpen: () => {
                        Swal.showLoading();
                        timerInterval = setInterval(() => {
                            const content = Swal.getContent();
                            if (content) {
                                const b = content.querySelector('b');
                                if (b) {
                                    b.textContent = (Swal.getTimerLeft() / 1000).toFixed(0);
                                }
                            }
                        }, 1000);
                    },
                    onClose: () => {
                        clearInterval(timerInterval);
                        window.location.href = 'detalle_actividad.php?id=$id_actividad'; // Redirige a la página de actividades
                    }
                });
            </script>";
        }
    } catch (PDOException $e) {
        print "<script>
            Swal.fire(
                'Error!',
                'Ocurrió un error: " . $e->getMessage() . "',
                'error'
            )
        </script>";
    }
    echo "<script>
    setTimeout(function() {
        window.location.href = 'detalle_actividad.php?id=$id_actividad';
    }, 3000);
</script>";
    
}

/* Enviar formulario de registro */

if (isset($_POST['btnRegistrar'])) {
    $campos = [
        'nombre', 
        'descripcion', 
        'observaciones', 
        'docentes_responsables', 
        'presupuesto_proyectado', 
        'fecha_inicio', 
        'fecha_fin', 
        'estado', 
        'progreso', 
        'subprocesoNivel2'
    ];
    
    $campos_vacios = [];

    foreach ($campos as $campo) {
        if (empty(trim($_POST[$campo]))) {
            $campos_vacios[] = $campo;
        }
    }

    if (!empty($campos_vacios)) {
        $mensaje = 'Por favor, complete todos los campos: ' . implode(', ', $campos_vacios);
        echo "<script>
            Swal.fire(
                'Error!',
                '$mensaje',
                'error'
            )
        </script>";
    } else {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $observaciones = $_POST['observaciones'];
    $docentes_responsables = $_POST['docentes_responsables'];
    $presupuesto_proyectado = $_POST['presupuesto_proyectado'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $estado = $_POST['estado'];
    $progreso = $_POST['progreso'];
    $subprocesoNivel2 = $_POST['subprocesoNivel2'];
    $creadorActividad = $_SESSION['id'];
    
    if (strtotime($fecha_fin) < strtotime($fecha_inicio)) {
        echo "<script>
            Swal.fire(
                'Error!',
                'La fecha de fin no puede ser anterior a la fecha de inicio.',
                'error'
            )
        </script>";
    } else {
        $insert_actividad = "INSERT INTO actividades (nombre, descripcion, observaciones, docentes_responsables, presupuesto_proyectado, fecha_inicio, fecha_fin, estado, id_subproceso_nivel2, progreso, creador) VALUES (:nombre, :descripcion, :observaciones, :docentes_responsables, :presupuesto_proyectado, :fecha_inicio, :fecha_fin, :estado, :id_subproceso_nivel2, :progreso, :creador)";

    try {
        $stmt = $conexion->prepare($insert_actividad);

        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':observaciones', $observaciones, PDO::PARAM_STR);
        $stmt->bindParam(':docentes_responsables', $docentes_responsables, PDO::PARAM_INT);
        $stmt->bindParam(':presupuesto_proyectado', $presupuesto_proyectado, PDO::PARAM_INT);
        $stmt->bindParam(':fecha_inicio', $fecha_inicio, PDO::PARAM_STR);
        $stmt->bindParam(':fecha_fin', $fecha_fin, PDO::PARAM_STR);
        $stmt->bindParam(':estado', $estado, PDO::PARAM_INT);
        $stmt->bindParam(':id_subproceso_nivel2', $subprocesoNivel2, PDO::PARAM_INT);
        $stmt->bindParam(':progreso', $progreso, PDO::PARAM_STR);
        $stmt->bindParam(':creador', $creadorActividad, PDO::PARAM_INT);


        if ($stmt->execute()) {
            echo "<script>
                let timerInterval;
                Swal.fire({
                    title: '¡Registrando!',
                    text: 'Espere un momento...',
                    icon: 'success',
                    timer: 3000, // Tiempo en milisegundos (3 segundos)
                    timerProgressBar: true, // Muestra una barra de progreso
                    showConfirmButton: false,
                    onBeforeOpen: () => {
                        Swal.showLoading();
                        timerInterval = setInterval(() => {
                            const content = Swal.getContent();
                            if (content) {
                                const b = content.querySelector('b');
                                if (b) {
                                    b.textContent = (Swal.getTimerLeft() / 1000).toFixed(0);
                                }
                            }
                        }, 1000);
                    },
                    onClose: () => {
                        clearInterval(timerInterval);
                        window.location.href = 'actividades.php'; // Redirige a la página de actividades
                    }
                });
            </script>";
        }
    } catch (PDOException $e) {
        print "<script>
            Swal.fire(
                'Error!',
                'Ocurrió un error: " . $e->getMessage() . "',
                'error'
            )
        </script>";
    }
    echo "<script>
    setTimeout(function() {
        window.location.href = 'actividades.php';
    }, 3000);
</script>";
    
  }
 }
}



/* Actualizar formulario de CRUD */

if (isset($_POST['btnActualizar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $observaciones = $_POST['observaciones'];
    $docentes_responsables = $_POST['docentes_responsables'];
    $presupuesto_proyectado = $_POST['presupuesto_proyectado'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $estado = $_POST['estado'];
    $progreso = $_POST['progreso'];
    $id_subproceso_nivel2 = $_POST['subprocesoNivel2'];

    // Validación de fechas
    if (strtotime($fecha_fin) < strtotime($fecha_inicio)) {
        echo "<script>
            Swal.fire(
                'Error!',
                'La fecha de fin no puede ser anterior a la fecha de inicio.',
                'error'
            )
        </script>";
    } else {
        $update_actividad = "UPDATE actividades 
                             SET nombre = :nombre, 
                                 descripcion = :descripcion,
                                 observaciones = :observaciones,
                                 docentes_responsables = :docentes_responsables,
                                 presupuesto_proyectado = :presupuesto_proyectado,
                                 fecha_inicio = :fecha_inicio,
                                 fecha_fin = :fecha_fin,
                                 estado = :estado,
                                 progreso = :progreso,  -- Agregado progreso
                                 id_subproceso_nivel2 = :id_subproceso_nivel2
                             WHERE id = :id";
    
        try {
            $stmt = $conexion->prepare($update_actividad);

            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
            $stmt->bindParam(':observaciones', $observaciones, PDO::PARAM_STR);
            $stmt->bindParam(':docentes_responsables', $docentes_responsables, PDO::PARAM_INT);
            $stmt->bindParam(':presupuesto_proyectado', $presupuesto_proyectado, PDO::PARAM_INT);
            $stmt->bindParam(':fecha_inicio', $fecha_inicio, PDO::PARAM_STR);
            $stmt->bindParam(':fecha_fin', $fecha_fin, PDO::PARAM_STR);
            $stmt->bindParam(':estado', $estado, PDO::PARAM_INT);
            $stmt->bindParam(':id_subproceso_nivel2', $id_subproceso_nivel2, PDO::PARAM_INT);
            $stmt->bindParam(':progreso', $progreso, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT); // Se añade enlace para el ID

            if ($stmt->execute()) {
                echo "<script>
                    let timerInterval;
                    Swal.fire({
                        title: '¡Actualizando!',
                        text: 'Espere un momento...',
                        icon: 'success',
                        timer: 3000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                        onBeforeOpen: () => {
                            Swal.showLoading();
                            timerInterval = setInterval(() => {
                                const content = Swal.getContent();
                                if (content) {
                                    const b = content.querySelector('b');
                                    if (b) {
                                        b.textContent = (Swal.getTimerLeft() / 1000).toFixed(0);
                                    }
                                }
                            }, 1000);
                        },
                        onClose: () => {
                            clearInterval(timerInterval);
                            window.location.href = 'actividades.php';
                        }
                    });
                </script>";
            }
        } catch (PDOException $e) {
            print "<script>
                Swal.fire(
                    'Error!',
                    'Ocurrió un error: " . $e->getMessage() . "',
                    'error'
                )
            </script>";
        }
        echo "<script>
    setTimeout(function() {
        window.location.href = 'actividades.php';
    }, 3000);
</script>";
    
  
    }
}

/* Actualizar formulario de detalles actividad */

if (isset($_POST['btnActualizarDet'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $observaciones = $_POST['observaciones'];
    $docentes_responsables = $_POST['docentes_responsables'];
    $presupuesto_proyectado = $_POST['presupuesto_proyectado'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $estado = $_POST['estado'];
    $progreso = $_POST['progreso'];
    $id_subproceso_nivel2 = $_POST['subprocesoNivel2'];

    // Validación de fechas
    if (strtotime($fecha_fin) < strtotime($fecha_inicio)) {
        echo "<script>
            Swal.fire(
                'Error!',
                'La fecha de fin no puede ser anterior a la fecha de inicio.',
                'error'
            )
        </script>";
    } else {
        $update_actividad = "UPDATE actividades 
                             SET nombre = :nombre, 
                                 descripcion = :descripcion,
                                 observaciones = :observaciones,
                                 docentes_responsables = :docentes_responsables,
                                 presupuesto_proyectado = :presupuesto_proyectado,
                                 fecha_inicio = :fecha_inicio,
                                 fecha_fin = :fecha_fin,
                                 estado = :estado,
                                 progreso = :progreso,  -- Agregado progreso
                                 id_subproceso_nivel2 = :id_subproceso_nivel2
                             WHERE id = :id";
    
        try {
            $stmt = $conexion->prepare($update_actividad);

            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
            $stmt->bindParam(':observaciones', $observaciones, PDO::PARAM_STR);
            $stmt->bindParam(':docentes_responsables', $docentes_responsables, PDO::PARAM_INT);
            $stmt->bindParam(':presupuesto_proyectado', $presupuesto_proyectado, PDO::PARAM_INT);
            $stmt->bindParam(':fecha_inicio', $fecha_inicio, PDO::PARAM_STR);
            $stmt->bindParam(':fecha_fin', $fecha_fin, PDO::PARAM_STR);
            $stmt->bindParam(':estado', $estado, PDO::PARAM_INT);
            $stmt->bindParam(':id_subproceso_nivel2', $id_subproceso_nivel2, PDO::PARAM_INT);
            $stmt->bindParam(':progreso', $progreso, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT); // Se añade enlace para el ID

            if ($stmt->execute()) {
                echo "<script>
                    let timerInterval;
                    Swal.fire({
                        title: '¡Actualizando!',
                        text: 'Espere un momento...',
                        icon: 'success',
                        timer: 3000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                        onBeforeOpen: () => {
                            Swal.showLoading();
                            timerInterval = setInterval(() => {
                                const content = Swal.getContent();
                                if (content) {
                                    const b = content.querySelector('b');
                                    if (b) {
                                        b.textContent = (Swal.getTimerLeft() / 1000).toFixed(0);
                                    }
                                }
                            }, 1000);
                        },
                        onClose: () => {
                            clearInterval(timerInterval);
                            window.location.href = 'actividades.php';
                        }
                    });
                </script>";
            }
        } catch (PDOException $e) {
            print "<script>
                Swal.fire(
                    'Error!',
                    'Ocurrió un error: " . $e->getMessage() . "',
                    'error'
                )
            </script>";
        }
        echo "<script>
    setTimeout(function() {
        window.location.href = 'detalle_actividad.php?id=$id_actividad';
    }, 3000);
</script>";
    
  
    }
}

?>