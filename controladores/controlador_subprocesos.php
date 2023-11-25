<?php
require_once('./conexion.php');

try {
    // Consulta SQL para obtener la lista de subprocesos con información sobre su proceso padre
    $consulta = "SELECT s.id AS subproceso_id, s.nombre AS subproceso_nombre, 
    s.descripcion AS subproceso_descripcion, s.fecha_sys AS subproceso_fecha,
    s.id_proceso AS proceso_id, p.nombre AS proceso_nombre, s.estado AS subproceso_estado
    FROM subprocesos s
    INNER JOIN procesos p ON s.id_proceso = p.id";

    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo $e->getMessage();
}

/* Acciones */

if (isset($_GET['opcion'])) {
    $action = $_GET['opcion'];

    // Acción para actualizar el estado de un subproceso
    if ($action == '4' && isset($_GET['id']) && isset($_GET['estado'])) {
        $estado = $_GET['estado'];
        $id = $_GET['id'];

        try {
            // Actualiza el estado del subproceso en la base de datos
            $consulta = "UPDATE subprocesos SET estado = :estado WHERE id = :id";
            $stmt = $conexion->prepare($consulta);
            $stmt->bindParam(':estado', $estado, PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                // Si la actualización es exitosa, muestra una notificación
                print '<script>
                    Swal.fire({
                        title: "Estado Actualizado",
                        text: "¡Estado del subproceso ' . $id . ' actualizado!",
                        icon: "success",
                        allowOutsideClick: false,
                        showCancelButton: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        confirmButtonText: "OK"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "subprocesos.php"; // Redirige a la página de subprocesos
                        }
                    });
                </script>';
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    // Acción para eliminar un subproceso
    if ($action == '3' && isset($_GET['id'])) {
        $id = $_GET['id'];

        try {
            $sql_delete = "DELETE FROM subprocesos WHERE id = :id";
            $stmt = $conexion->prepare($sql_delete);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                print '<script>
                Swal.fire({
                    title: "Subproceso Eliminado",
                    text: "Subproceso ' . $id . ' Eliminado correctamente",
                    icon: "success",
                    allowOutsideClick: false,
                    showCancelButton: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    confirmButtonText: "OK"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "subprocesos.php";
                    }
                });
            </script>';
            } else {
                print "<script>
                Swal.fire(
                    'Error!',
                    'Ocurrió un error.',
                    'error'
                )
                </script>";
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

    // Acción para editar un subproceso
if ($action == '2' && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Realiza una consulta para obtener los detalles del subproceso
    $consulta_subproceso = "SELECT * FROM subprocesos WHERE id = :id";
    $stmt = $conexion->prepare($consulta_subproceso);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $subproceso = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($subproceso) {
        $id = $subproceso['id'];
        $nombre = $subproceso['nombre'];
        $descripcion = $subproceso['descripcion']; // Cambio de fecha_inicio a descripcion
        $id_proceso = $subproceso['id_proceso']; // Agregar el campo id_proceso
        ?>

        <script>
            Swal.fire({
                title: 'Actualizar Subproceso',
                html: `
                    <form action="#" method="POST" class="text-left m-3">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" value="<?php echo $nombre ?>" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción</label> <!-- Cambio de fecha_inicio a descripcion -->
                            <textarea name="descripcion" class="form-control" rows="4" required><?php echo $descripcion ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="proceso_padre">Proceso Padre</label>
                            <select name="proceso_padre" class="form-control">
                                <?php
                                $consulta_procesos = "SELECT id, nombre FROM procesos";
                                $stmt_procesos = $conexion->prepare($consulta_procesos);
                                $stmt_procesos->execute();
                                $procesos = $stmt_procesos->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($procesos as $proceso) {
                                    $selected = ($proceso['id'] == $id_proceso) ? 'selected' : '';
                                    echo '<option value="' . $proceso['id'] . '" ' . $selected . '>' . $proceso['nombre'] . '</option>';
                                }
                                ?>
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

    // Acción para crear un subproceso
if ($action == '1') {
    // Obtén la lista de procesos para el menú desplegable
    $consulta_procesos = "SELECT id, nombre FROM procesos WHERE estado = 1";
    $stmt_procesos = $conexion->prepare($consulta_procesos);
    $stmt_procesos->execute();
    $procesos = $stmt_procesos->fetchAll(PDO::FETCH_ASSOC);

    ?>

    <script>
        Swal.fire({
            title: 'Nuevo Subproceso',
            html: `
                <form action="#" method="POST" class="text-left m-3">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="proceso_padre">Proceso Padre</label>
                        <select name="proceso_padre" class="form-control">
                            <?php
                            foreach ($procesos as $proceso) {
                                echo '<option value="' . $proceso['id'] . '">' . $proceso['nombre'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <input type="submit" name="btnRegistrar" class="btn btn-outline-secondary btn-lg btn-block mt-4">
                </form>
            `,
            showConfirmButton: false,
            allowOutsideClick: false,
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            showCloseButton: true,
            allowEscapeKey: false,
            allowEnterKey: false,
        });
    </script>
    <?php
}

}

/* Enviar formulario de registro */

if (isset($_POST['btnRegistrar'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $id_proceso = $_POST['proceso_padre']; // Obtener el proceso padre
    $estado = 1;

        // Insertar el nuevo subproceso en la base de datos
    $insert_subproceso = "INSERT INTO subprocesos (nombre, descripcion, id_proceso, estado, fecha_sys) 
    VALUES (:nombre, :descripcion, :id_proceso, :estado, NOW())";

    try {
    $stmt = $conexion->prepare($insert_subproceso);

    $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
    $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
    $stmt->bindParam(':id_proceso', $id_proceso, PDO::PARAM_INT);
    $stmt->bindParam(':estado', $estado, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "<script>
        let timerInterval;
        Swal.fire({
            title: '¡Registrando!',
            text: 'Espere un momento...',
            icon: 'success',
            timer: 3000, // Tiempo en milisegundos (2 segundos)
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
                window.location.href = 'subprocesos.php'; // Redirige a la página de subprocesos
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

    echo "<script>window.location.href = 'subprocesos.php';</script>";

}

/* Actualizar formulario de editar */

if (isset($_POST['btnActualizar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $id_proceso = $_POST['proceso_padre'];

    $update_subproceso = "UPDATE subprocesos SET nombre = :nombre, descripcion = :descripcion, id_proceso = :id_proceso WHERE id = :id";

    try {
        $stmt = $conexion->prepare($update_subproceso);

        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':id_proceso', $id_proceso, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<script>
    let timerInterval;
    Swal.fire({
        title: '¡Actualizando!',
        text: 'Espere un momento...',
        icon: 'success',
        timer: 3000, // Tiempo en milisegundos (2 segundos)
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
            window.location.href = 'subprocesos.php'; 
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
        window.location.href = 'subprocesos.php';
    }, 3000);
</script>";
    
}

?>
